<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidation;


class InvoiceRequest extends FormRequest
{
    use FailedValidation;
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
            'item' => 'required',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'tax' => 'required|in:0%,1%,5%,10%',
        ];
    }
}
