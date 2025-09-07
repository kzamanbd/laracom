<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Add validation rules for filters, sorting, etc. if needed
        ];
    }
}
