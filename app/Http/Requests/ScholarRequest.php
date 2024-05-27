<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScholarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->option == 'scholar'){
            return [
                'status_id' => 'required'
            ];
        }else  if($this->option == 'prospectus'){
            return [    
                'subcourse_id' => 'required'
            ];  
        }
    }
}
