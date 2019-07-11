<?php
namespace PesquisaProjeto\LdapiAPI;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

class LdapiAPI{

    public function authUserAPI(array $credentials)
    {

        $credentials['email'] = str_replace('.', '', $credentials['email']);
        $credentials['email'] = str_replace('-', '', $credentials['email']);

        // corpo da requisição para a api
        $requestBody['user'] = $credentials['email'];
        $requestBody['password'] = $credentials['password'];
        //atributos que devem ser retornados em caso autenticação confirmada
        $requestBody['attributes'] = ["cpf", "nomecompleto", "email", "id_grupo", "grupo"]; 
        
        // Chamada de autenticação para a LDAPI
        $httpClient = new Client(['verify' => false]);
        try
        {
            $response = $httpClient->request(
                config('ldapi.requestMethod'), 
                config('ldapi.authUrl'), 
                [
                    "auth" => [
                        config('ldapi.user'),
                        config('ldapi.password'), "Basic"
                    ],
                    "body" => json_encode($requestBody),
                    "headers" => [
                        "Content-type" => "application/json",
                    ],
                ]
            );
        }
        catch (ClientException $ex) { 

            return null;
        }catch(RequestException $ex){

            return null;
        }
        
        $attributes = null;
        $data = json_decode($response->getBody()->getContents());
        if($data){
            $attributes = array (
                'cpf' => $data->cpf,
                'nome' => $data->nomecompleto,
                'email'=> $data->email,
                'id_grupo'=>$data->id_grupo,
                'grupo'=>$data->grupo
            );     
        }

        return $attributes;
    }

    public function getUsersAPI($cpf)
    {
        $search['baseConnector'] = 'and';
        $search['filters'] = [['cpf'=> ['equals',$cpf] ]];
        $search['attributes']= [
                        "nomecompleto", 
                        "grupo", 
                        "email",
                        "id_grupo",
                        "cpf"
                    ];

        $httpClient = new Client(['verify' => false]);
        try
        {
             $response = $httpClient->request(
                config('ldapi.requestMethod'), 
                config('ldapi.searchUrl'), 
                [ 
                    "auth" => [
                        config('ldapi.user'),
                        config('ldapi.password'), "Basic"
                    ],
                    "body" => json_encode($search),
                    "headers" => [
                        "Content-type" => "application/json",
                    ],
                ]
            );
        }
        catch (ClientException $ex) { 

            throw $ex;
        }catch(RequestException $ex){

            throw $ex;
        }

        $data = json_decode($response->getBody()->getContents());
        $result = [];
        if($data->count){
            $result['nomecompleto'] = $data->result[0]->nomecompleto;
            $result['grupo'] = $data->result[0]->id_grupo;
            $result['email'] = $data->result[0]->email;
            $result['cpf'] = $data->result[0]->cpf;
        }
        
        return $result;
    }

}