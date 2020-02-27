<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceBidRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $placedBidTimes = $this->car
                ->bids()
                ->where('user_id', $this->user()->id)
                ->count();

            if ($placedBidTimes >= 20) {
                $validator->errors()->add('bid', 'Sorry, you can only place bids not more than 20 times on a model.');
            }
        });
    }
}
