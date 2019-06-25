<?php

// Create Router instance
$router = new Router();


$router->get('', 'PagesController@home' );
$router->get('list-flights', 'FlightsController@index');
$router->get('add-flight', 'FlightsController@add');
$router->post('add-flight', 'FlightsController@save');

// Run it!
$router->run();