<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrainOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "depStationCode"=> ['required',Rule::in(Ticket::Cities)],
            "arrStationCode"=>['required',Rule::in(Ticket::Cities)],
            "depDate"=>['required','date','after:today'],
            "trainNumber"=>['required'],
            "carNumber"=>['required'],
            "carType"=>['required',Rule::in([1,2])],
            "placeNumber"=>['required'],
            "departureDatetime"=>['required'],
            "arrivalDatetime"=>['required'],
        ];
    }
}
