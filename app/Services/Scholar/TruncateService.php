<?php

namespace App\Services\Scholar;

use DB;
use App\Models\Scholar;
use App\Models\ScholarProfile;
use App\Models\ScholarAddress;
use App\Models\ScholarEducation;
use App\Models\ScholarEnrollment;
use App\Models\ScholarEnrollmentSubject;
use App\Models\ScholarEnrollmentBenefit;
use App\Models\Release;
use App\Models\AccountingAllotment;
use App\Models\AccountingAllotmentList;
use App\Models\AccountingBalance;
use App\Models\AccountingDisbursement;
use App\Models\AccountingRealignment;
use App\Models\AccountingReports;

class TruncateService
{
    public function truncate($request){
        $type = $request->type;

        switch($type){
            case 'scholars':
                $this->scholars();
            break;
            case 'enrollments':
                $this->enrollements();
            break;
            case 'semesters':
                $this->semesters();
            break;
            case 'accounting':
                $this->accounting();
            break;
        }
    }

    public function scholars(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ScholarEducation::truncate();
        ScholarAddress::truncate();
        ScholarProfile::truncate();
        // ScholarTracer::truncate();
        $this->enrollment();
        Scholar::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return back()->with([
            'data' => true,
            'message' => 'Database Truncated Succesfully',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }

    public function enrollments(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $this->enrollment();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return back()->with([
            'data' => true,
            'message' => 'Enrollments Truncated Succesfully',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }

    public function enrollment(){
        ScholarEnrollment::truncate();
        ScholarEnrollmentSubject::truncate();
        ScholarEnrollmentBenefit::truncate();
        Release::truncate();
    }
    
    public function semesters(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        SchoolSemester::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return back()->with([
            'data' => true,
            'message' => 'Semester Truncated Succesfully',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }

    public function accounting(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        AccountAllotment::truncate();
        AccountAllotmentList::truncate();
        AccountBalance::truncate();
        AccountDisbursement::truncate();
        AccountRealignment::truncate();
        AccountReports::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return back()->with([
            'data' => true,
            'message' => 'Accounting Truncated Succesfully',
            'type' => 'bxs-check-circle',
            'color' => 'success'
        ]);
    }
}
