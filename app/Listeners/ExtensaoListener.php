<?php

namespace PesquisaProjeto\Listeners;

use PesquisaProjeto\Events\ExtensaoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

use PesquisaProjeto\Extensao;

class ExtensaoListener
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
            'body'=>"Atualização no projeto de extensão @title. Novo status: @status"
        ];

        $created = [
            'title'=>'Novo projeto de extensão!',
            'body'=>"Novo projeto de extensão criado: @title. Status: @status"
        ];

        $deleted = [
            'title'=>'Projeto de extensão removido!',
            'body'=>"Projeto de extensão apagado: @title"
        ];        

        $this->eventMessages['updated'] = $updated;
        $this->eventMessages['created'] = $created;
        $this->eventMessages['deleted'] = $deleted;
    }

    /**
     * Handle the event.
     *
     * @param  ExtensaoEvent  $event
     * @return void
     */
    public function handle(ExtensaoEvent $event)
    {
        $requestBody = $this->buildRequest($event->extensao,$event->eventType);
        $this->makeRequest($requestBody);
    }

    /**
     * Monta o request para o firebase
     *
     * @return array
     */
    private function buildRequest(Extensao $extensao,$eventType)
    {
        $request = [];
        if($extensao->orientador->token){
            $request[] = $this->createNotification($extensao,$extensao->orientador,$eventType);    
        }
        

        if($extensao->coorientador->token){
            $request[] = $this->createNotification($extensao,$extensao->coorientador,$eventType);
        }
        
        if($extensao->alunos){
            foreach($extensao->alunos as $aluno){
                if($aluno->token){
                    $request[] = $this->createNotification($extensao,$aluno,$eventType);
                }
            }
        }


        return $request;
    }

    /**
     * Monta o request body para o firebase
     * @param  [type] $extensao [description]
     * @param  [type] $user     [description]
     * @return [type]           [description]
     */
    private function createNotification($extensao,$user,$eventType)
    {
        $body = str_replace(
            ["@title","@status"],
            [$extensao->titulo,$extensao->status->descricao],
            $this->eventMessages[$eventType]['body']
        );

        return [
            "notification" => [
                "title"=> $this->eventMessages[$eventType]['title'],
                "body"=> $body,
                "click_action"=> route('detalhar_extensao',$extensao),
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
