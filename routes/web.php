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
    $ip = array('14.141.162.161','172.30.0.91','192.30.0.30','172.32.0.247','172.30.0.13');
    $httpMethods = array('GET','POST','PATCH','DELETE','PUT');
    $url = array(
        '/flight-schedule/kano-khartoum-flights.html', 
        '/ar/flight-schedule/cairo-jakarta-flights.html',
        '/ar/flight-booking/doha-cairo-flights.html',
        '/flight-schedule/ahmedabad-dehradun-flights.html',
        '/healthCheck.html',
        '/flight-schedule/olbia-cologne-flights.html',
        '/flight-booking/air-europa-madrid-new-york-flights.html',
        '/ar/flight-schedule/istanbul-hatay-flights.html',
        '/flight-schedule/dehradun-lucknow-flights.html',
        '/ar/flight-schedule/mumbai-new-york-flights.html',
        '/flight-booking/air-arabia-multan-sharjah-flights.html'
    );
    $statusCode = array(200, 302, 201, 300, 404, 500);
    $agent = array(
        '"Mozilla/5.0 (compatible; AhrefsBot/5.2; +http://ahrefs.com/robot/)"',
        '"Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"',
        '"Mozilla/5.0 (compatible; Qwantify/2.4w; +https://www.qwant.com/)/2.4w"',
        '"Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2476.463 Mobile Safari/537.36"',
        '"Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"',
        '"Mozilla/5.0 (compatible; AhrefsBot/5.2; +http://ahrefs.com/robot/)"',
        '"Mozilla/5.0 (compatible; SemrushBot/2~bl; +http://www.semrush.com/bot.html)"',
        '"Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)"'
        );


    $logger = new Logger('my_logger');
    $dateFormat = "[j/M/Y:H:i:s O]";
    
    //Log data
    $randIp = $ip[rand(0,4)];
    $randHttpMethod = $httpMethods[rand(0,3)];
    $randURL = $url[rand(0,11)];
    $randResponseTime = rand(200, 20000);
    $randStatusCode = $statusCode[rand(0,5)];
    $randAgent = $agent[rand(0,7)];
    $output = "{$randIp} - - %datetime% \"{$randHttpMethod} {$randURL} HTTP/1.1\" $randStatusCode $randResponseTime \"-\" $randAgent\n";

    
    $formatter = new LineFormatter($output, $dateFormat);
    $stream = new StreamHandler(__DIR__.'/../logs/my_app.log', Logger::DEBUG);
    $stream->setFormatter($formatter);
    $logger->pushHandler($stream);
    $logger->info('abc');
    
    return view('welcome');
});

