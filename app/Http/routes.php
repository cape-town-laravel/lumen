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

$app->get('/', function() use ($app) {
    return $app->welcome();
});

$app->get('/fast', function() {
    return 'Faster';
});

$app->get('/fast/{id:\d+}', function($id) {
    return 'Faster with id:' . $id;
});

/**
 * Resource routes
 */
$app->group(['prefix' => 'resources', 'namespace' => 'App\Http\Controllers'], function($app) {
    $app->get('/', ['as' => 'resources.index', 'uses' => 'ResourceController@index']);
    $app->post('/', ['as' => 'resources.store', 'uses' => 'ResourceController@store']);
    $app->get('/{resource:\d+}', ['as' => 'resources.show', 'uses' => 'ResourceController@show']);
    $app->put('/{resource:\d+}', ['as' => 'resources.replace', 'uses' => 'ResourceController@replace']);
    $app->patch('/{resource:\d+}', ['as' => 'resources.update', 'uses' => 'ResourceController@update']);
    $app->delete('/{resource:\d+}', ['as' => 'resources.destroy', 'uses' => 'ResourceController@destroy']);
    $app->options('/', ['as' => 'resources.options', 'uses' => 'ResourceController@options']);
});