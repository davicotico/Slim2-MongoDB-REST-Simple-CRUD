<?php

/**
 * @param \Slim\Slim $app Instancia da aplicação
 * @param array $data Array asociativo da resposta
 */
function response(\Slim\Slim $app, $data)
{
    $app->response->headers->set('Content-Type', 'application/json; charset=utf-8');
    echo json_encode($data);
}

/**
 * @param \Slim\Slim $app Instancia da aplicação
 * @param string $controller Nome do controller
 */
function createController(\Slim\Slim $app, $controller)
{
    $file = "./controllers/".$controller.".php";
    if (file_exists($file))
    {
        require $file;
        $class = ucfirst($controller);
        if (class_exists($class))
        {
            return new $class();
        }
        $app->notFound();
    }
    $app->notFound();
}
