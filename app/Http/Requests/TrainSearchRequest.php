<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class TrainSearchRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'depDate'=>Carbon::parse($this->depDate)->toDateString()
        ]);
    }

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
            "arrStationCode"=> ['required',Rule::in(Ticket::Cities)],
            "depDate"=> ['required','date','after:today']
        ];
    }
}
