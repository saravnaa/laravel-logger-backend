<?php

namespace App\Http\Controllers;
use Ixudra\Curl\Facades\Curl;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function getDiscoverLogs(Request $request)
    {
        $data = $request->all();
        $from = $data['from'];
        $to = $data['to'];
        $pageNumber = $data['pageNumber'];
        $body['query']['bool']['filter']['range']['datetime']['gte']=$from;
        $body['query']['bool']['filter']['range']['datetime']['lte']=$to;
        $body['from']=($pageNumber-1)*10;
        $body['size']=10;
        $response = Curl::to("http://localhost:9200/logger/_search")
                         ->withData($body)->asJson()->post();

        return json_encode($response,true);
    }

    public function searchLogs($query)
    {
        
        $response = Curl::to("http://localhost:9200/logger/_search?q=".$query)
                            ->get();
        return $response;
    }
    public function getVisualizeLogs(Request $request)
    {   
        $data = $request->all();
        $from = $data['from'];
        $to = $data['to'];
        $interval = $data['interval'];

        $data = array(
            "query" => array(
                "bool" => array(
                    "filter" => array(
                        "range" => [
                            "timestamp" => [
                                "gte" => $from,
                                "lte" => $to
                            ]
                        ]
                    )
                )
            ),
            "aggs" => [
                "typeCount" => [
                  "terms"=> [
                    "field" => "type.keyword"
                    ]
                ],
                "healthCount" => [
                  "terms" => [
                    "field"=> "airlineInfo.keyword",
                    "size"=> 30
                  ]
                ],
                "botCount" => [
                  "terms" => [
                    "field" => "spiderBot.keyword"
                  ]
                ],
                "responseCodeCount" =>[ 
                  "terms" => [
                    "field" => "status"
                  ]
                ],
                "dateAggregation"=> [
                    "date_histogram" => [
                        "field" => "timestamp",
                        "interval" => $interval,
                        "order" => [
                        "_key"=> "desc"
                        ]
                    ],
                    "aggs"=> [
                    "tags" => [
                      "terms"=> [
                        "field" => "spiderBot.keyword"
                      ]
                    ]
                    ]
                ]
            ], 
            "size" => 0
        );

        $response = Curl::to("http://localhost:9200/logger/_search")
                            ->withData($data)
                            ->asJson()
                            ->post();
        return json_encode($response, true);
    }
}
