<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255'
            ],
            'url' => [
                'required',
                'url',
                'regex:/^https?:\/\/(www\.)?olx\.ua\/d\/(uk|ru)\/obyavlenie\/.+/',
                'max:2048'
            ],
        ];
    }
}
