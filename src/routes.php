<?php

//Define to use slim http request
use Slim\Http\Request;
use Slim\Http\Response;

// In this file we define the Routes of http request

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


// Routes for the api

//We create the group with the routes and the methods 
$app->group('/api', function () use ($app) {
  // Version group
  $app->group('/v1', function () use ($app) {
    $app->get('/hosting', 'obtenerHostings');
    $app->get('/hosting/{id}', 'obtenerHosting');
    $app->post('/hosting', 'agregarHosting');
    $app->put('/hosting/{id}', 'actualizarHosting');
    $app->delete('/hosting/{id}', 'eliminarHosting');
  });
});
