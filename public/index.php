<?php
require_once('../vendor/autoload.php');
require_once('../app/config/config.php');
require_once('../app/functions/functions.php');

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseException;

ParseClient::initialize('ehr', 'JZqWMejDJWOvNd1of0w0G95BznXH03H2f35QhVwC', 'http://localhost:1337/parse');

// Defina a URL do servidor Parse
ParseClient::setServerURL('http://localhost:1337', '/parse');

/*
$testObject = ParseObject::create('TestObject');
$testObject->set('foo', 'bar');

try {
    $testObject->save();
    echo 'Objeto salvo com sucesso! ID: ' . $testObject->getObjectId();
} catch (ParseException $e) {
    echo 'Erro ao salvar o objeto: ' . $e->getMessage();
}

// Consultar objetos da classe "TestObject"
$query = new Parse\ParseQuery('TestObject');
try {
    $results = $query->find();
    foreach ($results as $result) {
        echo 'Objeto ID: ' . $result->getObjectId() . ', foo: ' . $result->get('foo') . '<br>';
    }
} catch (ParseException $e) {
    echo 'Erro ao consultar objetos: ' . $e->getMessage();
}
*/

(new \app\core\RouterCore());
