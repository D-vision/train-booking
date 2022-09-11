<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TrainsDemoApi
{
    protected $baseUrl = 'http://demo.divtech.kz/';
    protected $key = 'Alex_appkey';
    protected $secret= 'Alex111_appsecret';
    protected $token;

    public function __construct()
    {
        $this->token = Cache::get('trains-demo-api:token');
    }


    protected function post($action,$params=[])
    {
        $req = Http::withHeaders(['X-Requested-With'=>'XMLHttpRequest'])
            ->baseUrl($this->baseUrl)
            ->post($action,$params);

        return $this->handleResponse($req);
    }

    protected function handleResponse($req)
    {
        return $req;
    }

    public function getToken()
    {

    }

    public function search($data)
    {

    }

    public function order(User $user,$data)
    {

    }
}
