<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Gender;
use App\Enums\FriendlinessLevel;

class UpdateKangarooRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|unique:kangaroos,name,' . $this->kangaroo->id, 
            'nickname' => 'sometimes|nullable', 
            'weight' => 'sometimes|numeric|gte:0', 
            'height' => 'sometimes|numeric|gte:0', 
            'gender' => 'sometimes|in:' . implode(',', Gender::all()), 
            'color' => 'sometimes|nullable', 
            'friendliness' => 'sometimes|nullable|in:' . implode(',', FriendlinessLevel::all()), 
            'birthday' => 'sometimes|date_format:Y-m-d|before_or_equal:today', 
        ];
    }
}
