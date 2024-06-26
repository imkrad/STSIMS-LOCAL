<?php

namespace App\Services\Qualifier;

class SaveService
{
    public function __construct()
    {
        $this->link = config('app.api_link');
        $this->api = config('app.api_key');
    }

    public function enroll($request){
        $request->validate([
            'school_id' => 'sometimes|required',
            'course_id' => 'sometimes|required',
        ]);
        $postData = array(
            'user' => $request->user,
            'school_id' => $request->school_id,
            'course_id' => $request->course_id,
            'option' => $request->type
        );
        $data = $this->sender($postData);
        return back()->with([
            'data' => ($data) ? $data : 'Nothing found.',
            'message' => 'Qualifier updated successfully. Thanks',
            'info' => '-',
            'status' => true,
        ]); 
    }

    public function endorse($request){
        $request->validate([
            'school_id' => 'sometimes|required',
            'course_id' => 'sometimes|required',
        ]);
        $postData = array(
            'user' => $request->user,
            'school_id' => $request->school_id,
            'course_id' => $request->course_id,
            'option' => $request->type,
        );
        $data = $this->sender($postData);
        return back()->with([
            'data' => ($data) ? $data : 'Nothing found.',
            'message' => 'Endorsed successfully. Thanks',
            'info' => '-',
            'status' => true,
        ]); 
    }

    public function endorsed($request){
        $request->validate([
            'school_id' => 'sometimes|required',
            'course_id' => 'sometimes|required',
        ]);
        $postData = array(
            'id' => $request->id,
            'user' => $request->user,
            'school_id' => $request->school_id,
            'course_id' => $request->course_id,
            'option' => $request->type,
        );
        $data = $this->sender($postData);
        return back()->with([
            'data' => ($data) ? $data : 'Nothing found.',
            'message' => 'Endorsed successfully. Thanks',
            'info' => '-',
            'status' => true,
        ]); 
        
    }

    public function update($request){
        $request->validate([
            'municipality_code' => 'sometimes|required',
            'barangay_code' => 'sometimes|required',
        ]);
        $postData = array(
            'id' => $request->id,
            'is_completed' => 1,
            'address_id' => $request->address_id,
            'option' => 'update'
        );
        ($request->municipality_code != null && $request->municipality_code != 'n/a' ) ? $postData['municipality_code'] = $request->municipality_code : '';
        ($request->barangay_code) ? $postData['barangay_code'] = $request->barangay_code : '';
        $data = $this->sender($postData);
        return back()->with([
            'data' => ($data) ? $data : 'Nothing found.',
            'message' => 'Qualifier updated successfully. Thanks',
            'info' => '-',
            'status' => true,
        ]); 
    }

    public function edit($request){
        $request->validate([
            'status_id' => 'sometimes|required',
            'reason' => 'sometimes|required',
        ]);
        $postData = array(
            'id' => $request->id,
            'status_id' => $request->status_id,
            'reason' => $request->reason,
            'option' => 'edit'
        );
        $data = $this->sender($postData);
        return back()->with([
            'data' => ($data) ? $data : 'Nothing found.',
            'message' => 'Qualifier updated successfully. Thanks',
            'info' => '-',
            'status' => true,
        ]); 
    }

    public function sender($postData){
        try{
            $url = $this->link.'/api/01101011%2001110010%2001100001%2001100100/qualifiers';
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$this->api,
                'Content-Type: application/json',
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $datas = json_decode($response);
            return $datas;

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
