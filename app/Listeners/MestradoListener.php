<?php

namespace PesquisaProjeto\Listeners;

use PesquisaProjeto\Events\MestradoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

use PesquisaProjeto\Mestrado;

class MestradoListener
{
    private $eventMessages = [];
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $updated = [
            'title'=>'Atualizaçao!',
            'body'=>"Atualização no status do mestrado @title. Novo status: @status"
        ];

        $created = [
            'title'=>'Novo Mestrado!',
            'body'=>"Novo mestrado criado: @title. Status: @status"
        ];

        $deleted = [
            'title'=>'Mestrado removido!',
            'body'=>"Mestrado apagado: @title"
        ];        

        $this->eventMessages['updated'] = $updated;
        $this->eventMessages['created'] = $created;
        $this->eventMessages['deleted'] = $deleted;
    }

    /**
     * Handle the event.
     *
     * @param  MestradoEvent  $event
     * @return void
     */
    public function handle(MestradoEvent $event)
    {
        $requestBody = $this->buildRequest($event->mestrado,$event->eventType);
        $this->makeRequest($requestBody);
    }

    /**
     * Monta o request para o firebase
     *
     * @return array
     */
    private function buildRequest(Mestrado $mestrado,$eventType)
    {
        $request = [];
        if($mestrado->orientador->token){
            $request[] = $this->createNotification($mestrado,$mestrado->orientador,$eventType);    
        }
        

        if($mestrado->coorientador->token){
            $request[] = $this->createNotification($mestrado,$mestrado->coorientador,$eventType);
        }
        
        if($mestrado->aluno->token){
            $request[] = $this->createNotification($mestrado,$mestrado->aluno,$eventType);
        }

        return $request;
    }

    /**
     * Monta o request body para o firebase
     * @param  [type] $mestrado [description]
     * @param  [type] $user     [description]
     * @return [type]           [description]
     */
    private function createNotification($mestrado,$user,$eventType)
    {
        $body = str_replace(
            ["@title","@status"],
            [$mestrado->titulo,$mestrado->status->descricao],
            $this->eventMessages[$eventType]['body']
        );

        return [
            "notification" => [
                "title"=> $this->eventMessages[$eventType]['title'],
                "body"=> $body,
                "click_action"=> route('detalhar_mestrado',$mestrado),
                "icon"=> "/media/icons/favicon-96x96.png"
            ],
            "to"=> $user->token
        ];
    }

    /**
     * Executa o request para o firebase
     * @param  [type] $requestBody [description]
     * @return [type]              [description]
     */
    private function makeRequest($requestBody)
    {
        $httpClient = new Client();
        foreach($requestBody as $req){
            try
            {
                $response = $httpClient->request(
                    'POST', 
                    'https://fcm.googleapis.com/fcm/send', 
                    [
                        "body" => json_encode($req),
                        "headers" => [
                            "Content-Type" => "application/json",
                            "Authorization"=>env('GOOGLE_SERVER_KEY')
                        ],
                    ]
                );
            }
            catch (ClientException $ex) { 

                throw $ex;
            }catch(RequestException $ex){

                throw $ex;
            }
        }
    }

}
