<?php

use Illuminate\Support\Facades\Route;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return "Hello";
});

Route::post('/getdiscoverlogs', 'LogsController@getDiscoverLogs');

Route::get('/search/{query}', 'LogsController@searchLogs');

Route::post('/getvisualizelogs', 'LogsController@getVisualizeLogs');