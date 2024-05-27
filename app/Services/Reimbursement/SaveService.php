<?php

namespace App\Services\Reimbursement;

use App\Models\ScholarEnrollmentBenefit;
use App\Http\Resources\Reimbursement\IndexResource;

class SaveService
{
   
    public function reimburse($request){
        $attachments = [
            $this->upload($request)
        ];

        $data = ScholarEnrollmentBenefit::create(array_merge($request->all(),[
            'attachment' => json_encode($attachments),
            'release_type' => 'Full', 
            'month' => now(), 
            'status_id' => 11,
            'enrollment_id' => $request->enrollment_id,
            'amount' => trim(str_replace(',','',$request->amount),'₱ ')
        ]));

        return [
            'data' => new IndexResource($data),
            'message' => 'Reimbursement was successfully!', 
            'info' => "You've successfully reimburse.",
        ];
    }

    public function upload($request){
        if($request->hasFile('files'))
        {   
            $code = $request->scholar_id;
            $files = $request->file('files');   
            foreach ($files as $key=>$file) {
                if($key == 0){
                    $file_name = 'reimbursement_'.date("y-m-dhis").'.'.$file->getClientOriginalExtension();
                }else{
                    $file_name = 'reimbursement_'.date("y-m-dhis").'.'.$file->getClientOriginalExtension();
                }
              
                $file_path = $file->storeAs('/reimbursements', $file_name, 'public');
            }
            return $attachment = [
                'name' => $file_name,
                'file' => $file_path,
                'added_by' => \Auth::user()->id,
                'created_at' => date('M d, Y g:i a', strtotime(now()))
            ];
        }
    }
}
