<?php

namespace PesquisaProjeto\Listeners;

use PesquisaProjeto\Events\PesquisaEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

use PesquisaProjeto\Pesquisa;

class PesquisaListener
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
            'body'=>"Atualização no status do projeto de pesquisa @title. Novo status: @status"
        ];

        $created = [
            'title'=>'Novo Projeto!',
            'body'=>"Novo projeto de pesquisa criado: @title. Status: @status"
        ];

        $deleted = [
            'title'=>'Projeto removido!',
            'body'=>"Projeto de pesquisa apagado: @title"
        ];        

        $this->eventMessages['updated'] = $updated;
        $this->eventMessages['created'] = $created;
        $this->eventMessages['deleted'] = $deleted;
    }

    /**
     * Handle the event.
     *
     * @param  PesquisaEvent  $event
     * @return void
     */
    public function handle(PesquisaEvent $event)
    {
        $requestBody = $this->buildRequest($event->pesquisa,$event->eventType);
        $this->makeRequest($requestBody);
    }

    /**
     * Monta o request para o firebase
     *
     * @return array
     */
    private function buildRequest(Pesquisa $pesquisa,$eventType)
    {
        $request = [];
        if($pesquisa->orientador->token){
            $request[] = $this->createNotification($pesquisa,$pesquisa->orientador,$eventType);    
        }
        

        if($pesquisa->coorientador->token){
            $request[] = $this->createNotification($pesquisa,$pesquisa->coorientador,$eventType);
        }
        
        if($pesquisa->alunos){
            foreach($pesquisa->alunos as $aluno){
                if($aluno->token){
                    $request[] = $this->createNotification($pesquisa,$aluno,$eventType);
                }
            }
        }

        return $request;
    }

    /**
     * Monta o request body para o firebase
     * @param  [type] $pesquisa [description]
     * @param  [type] $user     [description]
     * @return [type]           [description]
     */
    private function createNotification($pesquisa,$user,$eventType)
    {
        $body = str_replace(
            ["@title","@status"],
            [$pesquisa->titulo,$pesquisa->status->descricao],
            $this->eventMessages[$eventType]['body']
        );

        return [
            "notification" => [
                "title"=> $this->eventMessages[$eventType]['title'],
                "body"=> $body,
                "click_action"=> route('detalhar_pesquisa',$pesquisa),
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
