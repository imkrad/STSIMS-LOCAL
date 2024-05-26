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
        }else if($this->type == 'semester'){    
            return [
                'academic_year' => 'required',
                'semester_id' => 'required|unique:school_semesters,semester_id,NULL,id,school_id,' . $this->school_id . ',academic_year,' . $this->academic_year,
                'start_at' => 'required',
                'end_at' => 'required',
                'school_id' => 'required'
            ];
        }else if($this->type == 'grading'){
            return [
                'grade' => 'sometimes|required',
                'lower_limit' => 'sometimes|required',
                'upper_limit' => 'sometimes|required'
            ];
        }else if($this->type == 'truncate'){
            return [];
        }else{
            return [];
        }
    }
}
