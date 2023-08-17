<?php

namespace app\model;

use Parse\ParseException;
use Parse\ParseUser;
use Parse\ParseClient;
use Parse\ParseQuery;

class AccountModel
{
    private $parseAppId;
    private $parseRestKey;
    private $parseServerUrl;

    public function __construct()
    {
        // Configure as informações do Parse Server
        $this->parseAppId = 'ehr';
        $this->parseRestKey = 'JZqWMejDJWOvNd1of0w0G95BznXH03H2f35QhVwC';
        $this->parseServerUrl = 'http://localhost:1337/parse';
    }

    public function login(string $username, string $password)
    {
        try {
            ParseClient::initialize($this->parseAppId, $this->parseRestKey, $this->parseServerUrl);
            $user = ParseUser::logIn($username, $password);

            // Verifica se o login foi bem-sucedido
            if ($user) {
                return true; // Autenticação bem-sucedida
            }
        } catch (ParseException $e) {
            // Trate o erro de autenticação
        }

        return false; // Autenticação falhou
    }

    public function register(string $username, string $password, string $email)
    {
        try {
            ParseClient::initialize($this->parseAppId, $this->parseRestKey, $this->parseServerUrl);

            // Crie um novo usuário no Parse
            $user = new ParseUser();
            $user->set('username', $username);
            $user->set('password', $password);
            $user->set('email', $email);

            $user->signUp(); // Registre o usuário

            return true; // Registro bem-sucedido
        } catch (ParseException $e) {
            // Trate o erro de registro
        }

        return false; // Registro falhou
    }


    /*
    public function isProfileComplete(string $username)
    {
        try {
            ParseClient::initialize($this->parseAppId, $this->parseRestKey, $this->parseServerUrl);

            // Recupere o usuário pelo nome de usuário
            $user = ParseUser::query()->equalTo('username', $username)->first();

            // Verifique se o usuário foi encontrado
            if ($user) {
                // Verifique se os campos específicos estão preenchidos
                $firma = $user->get('firma');
                $nif = $user->get('nif');
                $provincia = $user->get('provincia');

                if (!empty($firma) && !empty($nif) && !empty($provincia)) {
                    return true; // Perfil completo
                }
            }
        } catch (ParseException $e) {
            // Trate o erro de consulta
        }

        return false; // Perfil não está completo
    }
    */

    public function isProfileComplete($id, string $username)
    {
        try {
            ParseClient::initialize($this->parseAppId, $this->parseRestKey, $this->parseServerUrl);
        
            // Query the ParseUser class for the specified objectId
            //$userQuery = ParseUser::query();
            //$userQuery->equalTo('username', $username);
            
            // Retrieve the user
            //$user = $userQuery->first();
            //$bio = $user->get('bio');
        
            $user = ParseUser::query();
            $user->equalTo('username', 'huima.jose@hotmail.com')->first();

            $firmasQuery = new ParseQuery('tributeiFirmas');
                    $firmasQuery->equalTo('user',$id);
        
                    // Execute the query to retrieve firmas
                    $firmas = $firmasQuery->find();

            var_dump($user);
            if ($user) {
                // Retrieve the 'bio' field from the user
                $bio = $user->get('bio');
        
                if (!empty($bio)) {
                    // Verifique também os campos na tabela tributeiFirmas
                    $firmasQuery = new ParseQuery('tributeiFirmas');
                    $firmasQuery->equalTo('user', $id);
        
                    // Execute the query to retrieve firmas
                    $firmas = $firmasQuery->find();
        
                    foreach ($firmas as $firma) {
                        // Retrieve the 'designacao' and 'nif' fields from the firma
                        $designacao = $firma->get('designacao');
                        $nif = $firma->get('nif');
        
                        if (empty($designacao) || empty($nif)) {
                            return false; // Algum campo está vazio, perfil não está completo
                        }
                    }
        
                    return true; // Todos os campos estão preenchidos
                }
            }
        } catch (ParseException $e) {
            // Handle the ParseException
            error_log('Error querying user or tributeiFirmas: ' . $e->getMessage());
        }
        
        return false; // Perfil não está completo ou ocorreu um erro
    }
        
}
