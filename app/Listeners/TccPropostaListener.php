<?php

namespace PesquisaProjeto\Listeners;

use PesquisaProjeto\Events\TccPropostaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

use PesquisaProjeto\TccProposta;

class TccPropostaListener
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
            'body'=>"Atualização no status da proposta de TCC @title. Novo status: @status"
        ];

        $created = [
            'title'=>'Nova proposta de TCC!',
            'body'=>"Novo proposta de TCC: @title. Status: @status"
        ];

        $deleted = [
            'title'=>'Proposta de TCC removida!',
            'body'=>"Proposta apagada: @title"
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
    public function handle(TccPropostaEvent $event)
    {
        $requestBody = $this->buildRequest($event->tccProposta,$event->eventType);
        $this->makeRequest($requestBody);
    }

    /**
     * Monta o request para o firebase
     *
     * @return array
     */
    private function buildRequest(TccProposta $tccProposta,$eventType)
    {
        $request = [];
        if($tccProposta->orientador->token){
            $request[] = $this->createNotification($tccProposta,$tccProposta->orientador,$eventType);    
        }
        

        if($tccProposta->aluno->token){
            $request[] = $this->createNotification($tccProposta,$tccProposta->aluno,$eventType);
        }

        return $request;
    }

    /**
     * Monta o request body para o firebase
     * @param  [type] $tccProposta [description]
     * @param  [type] $user     [description]
     * @return [type]           [description]
     */
    private function createNotification($tccProposta,$user,$eventType)
    {
        $body = str_replace(
            ["@title","@status"],
            [$tccProposta->titulo,$tccProposta->status->descricao],
            $this->eventMessages[$eventType]['body']
        );

        return [
            "notification" => [
                "title"=> $this->eventMessages[$eventType]['title'],
                "body"=> $body,
                "click_action"=> route('detalhar_proposta_tcc',$tccProposta),
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
            }catch(ConnectException $ex){
                throw $ex;
            }
        }
    }
}
