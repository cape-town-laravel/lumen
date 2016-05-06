<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'Controller@getIndex');
$app->get('/fast', 'Controller@getFast');
$app->get('/fast/{id:\d+}', 'Controller@getFastId');

/**
 * Resource routes
 */
$app->group(['prefix' => 'resources', 'namespace' => 'App\Http\Controllers'], function ($app) {
    $app->get('/', ['as' => 'resources.index', 'uses' => 'ResourceController@index']);
    $app->post('/', ['as' => 'resources.store', 'uses' => 'ResourceController@store']);
    $app->get('/{resource:\d+}', ['as' => 'resources.show', 'uses' => 'ResourceController@show']);
    $app->put('/{resource:\d+}', ['as' => 'resources.replace', 'uses' => 'ResourceController@replace']);
    $app->patch('/{resource:\d+}', ['as' => 'resources.update', 'uses' => 'ResourceController@update']);
    $app->delete('/{resource:\d+}', ['as' => 'resources.destroy', 'uses' => 'ResourceController@destroy']);
    $app->options('/', ['as' => 'resources.options', 'uses' => 'ResourceController@options']);
});

$app->get('/example', 'ExampleController@index');

/**
 * Game Of Life
 */
$app->post('/gol/{width:\d+}x{height:\d+}', ['as' => 'game-of-life.engine', 'uses' => 'GameOfLifeController@engine']);
$app->get('/gol/{width:\d+}x{height:\d+}' ,['as'=>'game-of-life.stream','uses'=>'GameOfLifeController@stream']);
$app->get('/gol', ['as' => 'game-of-life.index', 'uses' => 'GameOfLifeController@index']);
$app->get('/socket', ['as' => 'game-of-life.socket', 'uses' => 'GameOfLifeController@socket']);

/**
 * Cached routes
 * It uses Lumen to add routes.
 */
//$app->setDispatcher(FastRoute\cachedDispatcher(function (FastRoute\RouteCollector $r) use ($app) {
//    foreach ($app->getRoutes() as $route) {
//        $r->addRoute($route['method'], $route['uri'], $route['action']);
//    }
//}, [
//    'cacheFile'     => __DIR__ . '/route.cache', /* required */
//    'cacheDisabled' => env('IS_DEBUG_ENABLED', true), /* optional, enabled by default */
//]));
