<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->type == 'prospectus'){
            return [
                'school_year' => 'required|integer',
            ];
        }else{
            return [];
        }
    }
}
