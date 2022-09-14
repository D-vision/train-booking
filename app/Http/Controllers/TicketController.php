<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\TrainOrderRequest;
use App\Http\Requests\TrainSearchRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function search(TrainSearchRequest $request)
    {
        $api = new \App\Services\TrainsDemoApi();

        return $api->search($request->validated());
    }

    public function order(TrainOrderRequest $request)
    {
        return Auth::user()->order($request->validated());
    }

    public function cities()
    {
        return Ticket::Cities;
    }

    public function tickets()
    {
        return TicketResource::collection(Auth::user()->tickets()->paginate(3));
    }
}
