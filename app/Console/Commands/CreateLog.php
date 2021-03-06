<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;

class CreateLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hits the url and appends a log data in log file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // exec("curl -XGET 'http://localhost:8000'");
        $ip = array('14.141.162.161','172.30.0.91','192.30.0.30','172.32.0.247','172.30.0.13','172.30.0.209','172.30.0.209',);
        $httpMethods = array('GET','POST','PUT');
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
            '/flight-booking/air-arabia-multan-sharjah-flights.html',
            '/ar/flight-booking/american-airlines-charlotte-jacksonville-flights.html',
            '/flight-schedule/poznan-paris-flights.html',
            '/flight-schedule/jeddah-riyadh-flights.html',
            '/flight-schedule/poznan-paris-flights.html'
        );
        $statusCode = array(200, 300, 404, 500);
        $agent = array(
            '"Mozilla/5.0 (compatible; AhrefsBot/5.2; +http://ahrefs.com/robot/)"',
            '"Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"',
            '"Mozilla/5.0 (compatible; Qwantify/2.4w; +https://www.qwant.com/)"',
            '"Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"',
            '"Mozilla/5.0 (compatible; AhrefsBot/5.2; +http://ahrefs.com/robot/)"',
            '"Mozilla/5.0 (compatible; SemrushBot/2~bl; +http://www.semrush.com/bot.html)"',
            '"Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.html)"',
            );


        $logger = new Logger('my_logger');
        // $dateFormat = "j/m/Y:H:i:s O";
        // $dateFormat = "Y-m-d\TH:i.s\Z";
        // $dateFormat = "DATE_W3C";
        
        //Log data
        $randIp = $ip[rand(0,6)];
        $randHttpMethod = $httpMethods[rand(0,2)];
        $randURL = $url[rand(0,14)];
        $randResponseTime = rand(200, 2000);
        $randStatusCode = $statusCode[rand(0,3)];
        $randAgent = $agent[rand(0,6)];
        $m = new \Moment\Moment('now','Asia/Kolkata');
        $datetime = $m->format();
        $output = "{$randIp} - - [{$datetime}] \"{$randHttpMethod} {$randURL} HTTP/1.1\" $randStatusCode $randResponseTime \"-\" $randAgent\n";

        
        $formatter = new LineFormatter($output);
        // $dateFormat);
        $stream = new StreamHandler(__DIR__.'/../../../logs/my_app.log', Logger::DEBUG);
        $stream->setFormatter($formatter);
        $logger->pushHandler($stream);
        $logger->info('abc');
        echo "executed\n";
    }
}
