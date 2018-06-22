<?php
/**
 * Simmple REST
 * Slim 2 + MongoDB
 * 
 * PHP >= 5.6
 * 
 * @author David Ticona Saravia <david.ticona.saravia@gmail.com>
 * 
 */
require 'Slim/Slim.php';
require 'includes/functions.php';

use \Slim\Slim as Slim;

Slim::registerAutoloader();

date_default_timezone_set('America/Sao_Paulo');

$app = new Slim();

$app->get('/', function (){ 
    echo "Home";
});

/**
 * GET api/{collection}/?limit={int}&orderby[{field1}]={asc|desc}&orderby[field2]=[asc|desc]&field3=YYY&field4=ZZZ
 * 
 * Exemplo:
 * GET api/cidades/?limit=15&orderby[field1]=asc&orderby[field2]=desc&fieldY=valorY&fieldZ=valorZ
 */
$app->get('/api/:controller', function ($controller) use ($app) {
    $ctrl = createController($app, $controller);
    $function = 'getList';
    if (is_callable(array($ctrl, $function)))
    {
        $time = time();
        $app->lastModified($time);
        $app->expires($time + 300); 
        $params = $app->request->get();
        response($app, $ctrl->$function($params));
    } else
    {
        $app->notFound();
    }
});
/**
 * POST api/{collection}
 * BODY
 * {"field1": "zz", "field2": "yy"}
 * 
 */
$app->post('/api/:controller', function($controller) use ($app){
    $ctrl = createController($app, $controller);
    $function = 'postCreate';
    if (is_callable(array($ctrl, $function)))
    {
        $data = $app->request->getBody();
        response($app, $ctrl->$function($data));
    } else
    {
        $app->notFound();
    }
});
    
/**
 * PUT api/{collection}/{_id}
 * BODY
 * {"field1": "yyy", "field2": "zzz"}
 * 
 * Exemplo:
 * PUT api/cidades/22
 * BODY
 *  {"nome": "Campinas", "estadoId": "2"}
 */
$app->put('/api/:controller/:id', function($controller, $id) use ($app){
    $ctrl = createController($app, $controller);
    $function = 'putUpdate';
    if (is_callable(array($ctrl, $function)))
    {
        $data = $app->request->getBody();
        response($app, $ctrl->$function($id, $data));
    } else
    {
        $app->notFound();
    }
});

/**
 * DELETE api/{collection}/{_id}
 * 
 * Exemplo:
 * DELETE api/cidades/123
 */
$app->delete('/api/:controller/:id', function($controller, $id) use ($app){
    $ctrl = createController($app, $controller);
    $function = 'deleteObject';
    if (is_callable(array($ctrl, $function)))
    {
        response($app, $ctrl->$function($id));
    } else
    {
        $app->notFound();
    }
});

$app->run();
