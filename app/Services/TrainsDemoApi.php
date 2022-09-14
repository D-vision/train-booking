<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrainsDemoApi
{
    protected $baseUrl;
    protected $key;
    protected $secret;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('DEMO_URL','http://demo.divtech.kz/api');
        $this->key = env('DEMO_KEY');
        $this->secret = env('DEMO_SECRET');
        $this->token = (Cache::get('trains-demo-api:token')??$this->getToken());
    }


    protected function post($action,$params=[],$sign=true)
    {
        $req = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'X-Requested-With'=>'XMLHttpRequest',
                'Accept'=>'application/json'
            ]);

        $sign && $req = $req->withToken($this->token);

        $res = $req->post($action,$params);
        $data = $this->handleResponse($res);

        return $data=='retry'?$this->post($action,$params,$sign):$data;
    }

    protected function handleResponse(Response $res)
    {
        // code 401 - refresh token
        // code 400 - result failed
        // code 422 - field validation
        // code 404,500 - system failed
        if($res->successful())
            return $res->json();

        if($res->status()==401){
            $this->getToken();
            return 'retry';
        }

        if(preg_match('/404|5../',$res->status())){
            $error = [
                'status'=>$res->status(),
                'reason'=>$res->reason(),
                'url'=>(string)$res->effectiveUri()
            ];

            Log::alert('Demo API error',$error);
            app()->runningInConsole()? dd($error):abort(500,'Server error');
        }
;
        app()->runningInConsole()
            ?dd($res->status(),$res->reason(),$res->json(),$res->effectiveUri())
            :abort($res->status(),$res->reason());


    }

    public function getToken()
    {
        $token = $this->post('auth/get-token',
            [
                'app_key'=>$this->key,
                'app_secret'=>$this->secret
            ],
            false
        );
        Cache::forever('trains-demo-api:token',$token['token']);
        return ($this->token = $token['token']);
    }

    public function search($data)
    {
        return $this->post('search-trains',$data);
    }

    public function order(User $user,$data)
    {
        $data['passenger'] = [
            "firstName"=> $user->firstName,
            "lastName"=> $user->lastName
        ];

        $ticket = $this->post('issue-ticket',$data);

        return $user->tickets()->create([
            'order_id'=>$ticket["orderId"],
            'from'=>$data['depStationCode'],
            'to'=>$data['arrStationCode'],
            'train'=>$data['trainNumber'],
            'cart'=>$data['carNumber'],
            'place'=>$data['placeNumber'],
            'departure_at'=>$data['depDate']
        ]);
    }
}
