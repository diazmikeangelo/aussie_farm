<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Gender;
use App\Enums\FriendlinessLevel;

class StoreKangarooRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:kangaroos,name', 
            'nickname' => 'sometimes|nullable', 
            'weight' => 'required|numeric|gte:0', 
            'height' => 'required|numeric|gte:0', 
            'gender' => 'required|in:' . implode(',', Gender::all()), 
            'color' => 'sometimes|nullable', 
            'friendliness' => 'sometimes|nullable|in:' . implode(',', FriendlinessLevel::all()), 
            'birthday' => 'required|date_format:Y-m-d|before_or_equal:today', 
        ];
    }
}
