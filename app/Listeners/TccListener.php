<?php

namespace PesquisaProjeto\Listeners;

use PesquisaProjeto\Events\TccEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

use PesquisaProjeto\Tcc;

class TccListener
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
            'body'=>"Atualização no status do TCC @title. Novo status: @status"
        ];

        $created = [
            'title'=>'Novo TCC!',
            'body'=>"Novo projeto TCC: @title. Status: @status"
        ];

        $deleted = [
            'title'=>'TCC removido!',
            'body'=>"TCC apagado: @title"
        ];        

        $this->eventMessages['updated'] = $updated;
        $this->eventMessages['created'] = $created;
        $this->eventMessages['deleted'] = $deleted;
    }

    /**
     * Handle the event.
     *
     * @param  TccEvent  $event
     * @return void
     */
    public function handle(TccEvent $event)
    {
        $requestBody = $this->buildRequest($event->tcc,$event->eventType);
        $this->makeRequest($requestBody);
    }

    /**
     * Monta o request para o firebase
     *
     * @return array
     */
    private function buildRequest(TCC $tcc,$eventType)
    {
        $request = [];
        if($tcc->orientador->token){
            $request[] = $this->createNotification($tcc,$tcc->orientador,$eventType);    
        }
        

        if($tcc->coorientador->token){
            $request[] = $this->createNotification($tcc,$tcc->coorientador,$eventType);
        }
        

        if($tcc->aluno->token){
            $request[] = $this->createNotification($tcc,$tcc->aluno,$eventType);
        }

        return $request;
    }

    /**
     * Monta o request body para o firebase
     * @param  [type] $tcc [description]
     * @param  [type] $user     [description]
     * @return [type]           [description]
     */
    private function createNotification($tcc,$user,$eventType)
    {
        $body = str_replace(
            ["@title","@status"],
            [$tcc->titulo,$tcc->status->descricao],
            $this->eventMessages[$eventType]['body']
        );

        return [
            "notification" => [
                "title"=> $this->eventMessages[$eventType]['title'],
                "body"=> $body,
                "click_action"=> route('detalhar_tcc',$tcc),
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
