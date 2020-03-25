<?php

$router->get('/books', 'BookController@index');
$router->post('/books', 'BookController@store');
$router->get('/books/{book}', 'BookController@show');
$router->put('/books/{book}', 'BookController@update');
$router->patch('/books/{book}', 'BookController@update');
$router->delete('/books/{book}', 'BookController@destroy');
