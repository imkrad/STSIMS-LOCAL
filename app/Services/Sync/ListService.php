<?php

namespace App\Services\Sync;

use App\Models\ListAgency;
use App\Models\ListDropdown;
use App\Models\ListPrivilege;
use App\Models\ListProgram;
use App\Models\ListStatus;
use App\Models\ListCourse;
use App\Traits\HandlesCurl;

class ListService
{
    use HandlesCurl;

    public function fetchCount(){
        $response = $this->handleCurl('lists','count');
        return json_decode($response);
    }

    public function fetch(){
        set_time_limit(0);
        $arrays = ['agencies','dropdowns','programs','privileges','courses','statuses'];
        try {
            foreach($arrays as $array){
                $response = $this->handleCurl('lists',$array);
                $lists = json_decode($response);
                
                if($array == 'settings'){
                    $this->set($lists);
                }else{
                    foreach($lists as $data){
                        switch($array){
                            case 'agencies':
                                ListAgency::insertOrIgnore((array)$data); 
                            break;
                            case 'dropdowns':
                                ListDropdown::insertOrIgnore((array)$data); 
                            break;
                            case 'courses':
                                ListCourse::insertOrIgnore((array)$data); 
                            break;
                            case 'statuses':
                                ListStatus::insertOrIgnore((array)$data); 
                            break;
                            case 'programs':
                                ListProgram::insertOrIgnore((array)$data); 
                            break;
                            case 'privileges':
                                $arr = (array)$data;
                                $arr['regular_amount'] = trim(str_replace(',','',$arr['regular_amount']),'₱ ');
                                $arr['summer_amount'] = trim(str_replace(',','',$arr['summer_amount']),'₱ ');
                                ListPrivilege::insertOrIgnore($arr); 
                            break;
                        }
                    }
                }
            }
            $response = true;
        }catch (Exception $e){
            $response = 'Caught exception: '.$e->getMessage();
        }
        return $response;
    }
}
