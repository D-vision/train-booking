<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\TrainOrderRequest;
use App\Http\Requests\TrainSearchRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function search(TrainSearchRequest $request)
    {

    }

    public function order(TrainOrderRequest $request)
    {
        Auth::user()->order($request->validated());
    }
}
