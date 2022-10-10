<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group([

    'middleware' => 'auth:api',
    'namespace' => 'App\Http\Controllers'

], function () {
    // Route::get('logout', 'ApiController@logout');

    // Route::get('tasks', 'TaskController@index');
    // Route::post('tasks', 'TaskController@store');
    // Route::put('tasks/{id}', 'TaskController@update');
    // Route::delete('tasks/{id}', 'TaskController@destroy');
});

// Route::get('tasks/{id}', 'TaskController@show');

$api = app('Dingo\Api\Routing\Router');

 

$api->version('v1',['namespace' => 'App\Http\Controllers'], function ($api) {
    $api->group(['middleware' => 'api.auth'], function ($api){

        $api->post('crearCandidato', 'APIController@crearCandidato');
        $api->get('consultarCandidato/{id}', 'APIController@consultarCandidato');
        $api->get('consultarTodos', 'APIController@consultarTodos');

    });

   $api->post('login', 'AuthController@login');
   $api->post('register', 'AuthController@register');
});