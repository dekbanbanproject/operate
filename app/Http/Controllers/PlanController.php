<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;

use App\Models\Planvision;
use App\Models\Planmission;
use App\Models\Planstrategic;
use App\Models\Plantarget;
use App\Models\Plankpi;
use App\Models\Plantype;

use App\Models\Planproject;
use App\Models\Planhumandev;
use App\Models\Plandurable;
use App\Models\Plankpilevel;
use App\Models\Plankpiperson;

use App\Models\Planyear;
use App\Models\Planrepair;


date_default_timezone_set("Asia/Bangkok");

class PlanController extends Controller
{
   
    public function geninfoplanindex(Request $request,$iduser)
    {
       
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }


         $countplan_1 = DB::table('plan_project')->where('BUDGET_YEAR','=',$yearbudget)->count();
         $sumpiceplan_1  =  DB::table('plan_project')->where('BUDGET_YEAR','=',$yearbudget)->sum('BUDGET_PICE');
         $countsucces_1  =  DB::table('plan_project')->where('BUDGET_YEAR','=',$yearbudget)->where('BUDGET_PICE_REAL','<>',0)->count();
         $sumpicesucces_1  =  DB::table('plan_project')->where('BUDGET_YEAR','=',$yearbudget)->where('BUDGET_PICE_REAL','<>',0)->sum('BUDGET_PICE_REAL');

         $countplan_2 = DB::table('plan_humandev')->where('BUDGET_YEAR','=',$yearbudget)->count();
         $sumpiceplan_2  =  DB::table('plan_humandev')->where('BUDGET_YEAR','=',$yearbudget)->sum('BUDGET_PICE');
         $countsucces_2  =  DB::table('plan_humandev')->where('BUDGET_YEAR','=',$yearbudget)->where('BUDGET_PICE_REAL','<>',0)->count();
         $sumpicesucces_2  =  DB::table('plan_humandev')->where('BUDGET_YEAR','=',$yearbudget)->where('BUDGET_PICE_REAL','<>',0)->sum('BUDGET_PICE_REAL');

         $countplan_3 = DB::table('plan_durable')->where('BUDGET_YEAR','=',$yearbudget)->count();
         $sumpiceplan_3  =  DB::table('plan_durable')->where('BUDGET_YEAR','=',$yearbudget)->sum('DUR_PICE_SUM');
         $countsucces_3  =  DB::table('plan_durable')->where('BUDGET_YEAR','=',$yearbudget)->where('BUDGET_PICE_REAL','<>',0)->count();
         $sumpicesucces_3  =  DB::table('plan_durable')->where('BUDGET_YEAR','=',$yearbudget)->where('BUDGET_PICE_REAL','<>',0)->sum('BUDGET_PICE_REAL');

         $countplan_4 = DB::table('plan_repair')->where('BUDGET_YEAR','=',$yearbudget)->count();
         $sumpiceplan_4  =  DB::table('plan_repair')->where('BUDGET_YEAR','=',$yearbudget)->sum('REPAIR_PICE_SUM');
         $countsucces_4  =  DB::table('plan_repair')->where('BUDGET_YEAR','=',$yearbudget)->where('REPAIR_PICE_REAL','<>',0)->count();
         $sumpicesucces_4  =  DB::table('plan_repair')->where('BUDGET_YEAR','=',$yearbudget)->where('REPAIR_PICE_REAL','<>',0)->sum('REPAIR_PICE_REAL');

         


         if($countplan_1 != 0 && $countplan_1 != null){
            $persen_1 = ($countsucces_1 /$countplan_1)*100;
        }else{
            $persen_1 = 0;
        }

        if($countplan_2 != 0 && $countplan_2 != null){
            $persen_2 = ($countsucces_2 /$countplan_2)*100; 
        }else{
            $persen_2 = 0;
        }

        if($countplan_3 != 0 && $countplan_3 != null){
            $persen_3 = ($countsucces_3 /$countplan_3)*100;
        }else{
            $persen_3 = 0;
        }


        
        if($countplan_4 != 0 && $countplan_4 != null){
            $persen_4 = ($countsucces_4 /$countplan_4)*100;
        }else{
            $persen_4 = 0;
        }


         $sum_1 = $countplan_1 + $countplan_2 + $countplan_3 + $countplan_4;
         $sum_2 = $sumpiceplan_1 + $sumpiceplan_2 + $sumpiceplan_3 + $sumpiceplan_4;
         $sum_3 = $countsucces_1 + $countsucces_2 + $countsucces_3 + $countsucces_4;
         $sum_4 = $sumpicesucces_1 + $sumpicesucces_2 + $sumpicesucces_3 + $sumpicesucces_4;  
         
         if($sum_1 != 0 && $sum_1 != null){
         $sum_5 = ($sum_3 /$sum_1)*100;
         }else{
            $sum_5 = 0;
        }

         if($sum_2 != 0 && $sum_2 != null){
         $sum_6 = ($sum_4 /$sum_2)*100;
         }else{
            $sum_6 = 0;
        }

         $year_id = $yearbudget;

         $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

 


        return view('general_plan.geninfoplanindex',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'countplan_1'=> $countplan_1,
            'sumpiceplan_1'=> $sumpiceplan_1,
            'countsucces_1'=> $countsucces_1,
            'sumpicesucces_1'=> $sumpicesucces_1,
            'countplan_2'=> $countplan_2,
            'sumpiceplan_2'=> $sumpiceplan_2,
            'countsucces_2'=> $countsucces_2,
            'sumpicesucces_2'=> $sumpicesucces_2,
            'countplan_3'=> $countplan_3,
            'sumpiceplan_3'=> $sumpiceplan_3,
            'countsucces_3'=> $countsucces_3,
            'sumpicesucces_3'=> $sumpicesucces_3,
            'countplan_4'=> $countplan_4,
            'sumpiceplan_4'=> $sumpiceplan_4,
            'countsucces_4'=> $countsucces_4,
            'sumpicesucces_4'=> $sumpicesucces_4,
            'persen_1'=> $persen_1,
            'persen_2'=> $persen_2,
            'persen_3'=> $persen_3,
            'persen_4'=> $persen_4,
            'sum_1'=> $sum_1,
            'sum_2'=> $sum_2,
            'sum_3'=> $sum_3,
            'sum_4'=> $sum_4,
            'sum_5'=> $sum_5,
            'sum_6'=> $sum_6,
            'budgets' =>  $budget,
            'year_id'=>$year_id,
         
            
        ]);
    }


    public function geninfoplan_project(Request $request,$iduser)
    {
       
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $infoyear = DB::table('plan_year')->first();

        if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
           $yearbudget = $infoyear->PLAN_YEAR;
        }else{
           $m_budget = date("m");
           if($m_budget>9){
           $yearbudget = date("Y")+544;
           }else{
           $yearbudget = date("Y")+543;
           }
   
        }

       $infoproject = DB::table('plan_project')
       ->leftJoin('plan_target','plan_project.TARGET_ID','=','plan_target.TARGET_ID')
       ->leftJoin('plan_kpi','plan_project.KPI_ID','=','plan_kpi.KPI_ID')
       ->leftJoin('plan_type','plan_project.PLAN_TYPE_ID','=','plan_type.PLAN_TYPE_ID')
       ->leftJoin('supplies_budget','plan_project.BUDGET_ID','=','supplies_budget.BUDGET_ID')
       ->leftJoin('plan_tracking','plan_project.PLAN_TRACKING_ID','=','plan_tracking.PLAN_TRACKING_ID')
       ->where('BUDGET_YEAR','=', $yearbudget)
       ->orderBy('PRO_ID', 'asc')->get();


       
       $sumbudget  = DB::table('plan_project')
       ->leftJoin('plan_target','plan_project.TARGET_ID','=','plan_target.TARGET_ID')
       ->leftJoin('plan_kpi','plan_project.KPI_ID','=','plan_kpi.KPI_ID')
       ->leftJoin('plan_type','plan_project.PLAN_TYPE_ID','=','plan_type.PLAN_TYPE_ID')
       ->where('BUDGET_YEAR','=', $yearbudget)
       ->sum('BUDGET_PICE');

       $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
       $search = '';
       $year_id =  $yearbudget;
       $type ='';
       $displaydate_bigen = ($yearbudget-544).'-10-01';
       $displaydate_end = ($yearbudget-543).'-09-30';


        return view('general_plan.geninfoplan_project',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infoprojects' => $infoproject,
            'sumbudget' => $sumbudget,
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'type'=>$type,  
         
            
        ]);
    }


    public function project_search(Request $request,$iduser)
    {      

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');  
        $type = $request->SEND_TYPE;
    
      
        if($search==''){
            $search="";
        }


        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
  
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
     

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        if($type == null || $type == ''){

          

            $infoproject = DB::table('plan_project')
            ->leftJoin('plan_target','plan_project.TARGET_ID','=','plan_target.TARGET_ID')
            ->leftJoin('plan_kpi','plan_project.KPI_ID','=','plan_kpi.KPI_ID')
            ->leftJoin('plan_type','plan_project.PLAN_TYPE_ID','=','plan_type.PLAN_TYPE_ID')
            ->leftJoin('supplies_budget','plan_project.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->leftJoin('plan_tracking','plan_project.PLAN_TRACKING_ID','=','plan_tracking.PLAN_TRACKING_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                 $q->where('PRO_NUMBER','like','%'.$search.'%');
                 $q->orwhere('PRO_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('TARGET_CODE','like','%'.$search.'%');
                 $q->orwhere('KPI_CODE','like','%'.$search.'%');
                 $q->orwhere('PLAN_TYPE_NAME','like','%'.$search.'%');
                 $q->orwhere('PRO_NAME','like','%'.$search.'%');
                 $q->orwhere('PRO_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
                 $q->orwhere('PLAN_TRACKING_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('PRO_BEGIN_DATE',[$from,$to]) 
            ->orderBy('PRO_ID', 'asc')->get();
                
            
            $sumbudget  = DB::table('plan_project')
            ->leftJoin('plan_target','plan_project.TARGET_ID','=','plan_target.TARGET_ID')
            ->leftJoin('plan_kpi','plan_project.KPI_ID','=','plan_kpi.KPI_ID')
            ->leftJoin('plan_type','plan_project.PLAN_TYPE_ID','=','plan_type.PLAN_TYPE_ID')
            ->leftJoin('supplies_budget','plan_project.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->leftJoin('plan_tracking','plan_project.PLAN_TRACKING_ID','=','plan_tracking.PLAN_TRACKING_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                $q->where('PRO_NUMBER','like','%'.$search.'%');
                $q->orwhere('PRO_TEAM_NAME','like','%'.$search.'%');
                $q->orwhere('TARGET_CODE','like','%'.$search.'%');
                $q->orwhere('KPI_CODE','like','%'.$search.'%');
                $q->orwhere('PLAN_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('PRO_NAME','like','%'.$search.'%');
                $q->orwhere('PRO_TEAM_HR_NAME','like','%'.$search.'%');
                $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
                $q->orwhere('PLAN_TRACKING_NAME','like','%'.$search.'%');
           })
           ->WhereBetween('PRO_BEGIN_DATE',[$from,$to]) 
            ->sum('BUDGET_PICE');



        }else{

            $infoproject = DB::table('plan_project')
            ->leftJoin('plan_target','plan_project.TARGET_ID','=','plan_target.TARGET_ID')
            ->leftJoin('plan_kpi','plan_project.KPI_ID','=','plan_kpi.KPI_ID')
            ->leftJoin('plan_type','plan_project.PLAN_TYPE_ID','=','plan_type.PLAN_TYPE_ID')
            ->leftJoin('supplies_budget','plan_project.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->leftJoin('plan_tracking','plan_project.PLAN_TRACKING_ID','=','plan_tracking.PLAN_TRACKING_ID')
            ->where('PRO_TYPE','=',$type)
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                $q->where('PRO_NUMBER','like','%'.$search.'%');
                $q->orwhere('PRO_TEAM_NAME','like','%'.$search.'%');
                $q->orwhere('TARGET_CODE','like','%'.$search.'%');
                $q->orwhere('KPI_CODE','like','%'.$search.'%');
                $q->orwhere('PLAN_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('PRO_NAME','like','%'.$search.'%');
                $q->orwhere('PRO_TEAM_HR_NAME','like','%'.$search.'%');
                $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
                $q->orwhere('PLAN_TRACKING_NAME','like','%'.$search.'%');
           })
           ->WhereBetween('PRO_BEGIN_DATE',[$from,$to]) 
            ->orderBy('PRO_ID', 'asc')->get();
                
            
            $sumbudget  = DB::table('plan_project')
            ->leftJoin('plan_target','plan_project.TARGET_ID','=','plan_target.TARGET_ID')
            ->leftJoin('plan_kpi','plan_project.KPI_ID','=','plan_kpi.KPI_ID')
            ->leftJoin('plan_type','plan_project.PLAN_TYPE_ID','=','plan_type.PLAN_TYPE_ID')
            ->leftJoin('supplies_budget','plan_project.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->leftJoin('plan_tracking','plan_project.PLAN_TRACKING_ID','=','plan_tracking.PLAN_TRACKING_ID')
            ->where('PRO_TYPE','=',$type)
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                $q->where('PRO_NUMBER','like','%'.$search.'%');
                $q->orwhere('PRO_TEAM_NAME','like','%'.$search.'%');
                $q->orwhere('TARGET_CODE','like','%'.$search.'%');
                $q->orwhere('KPI_CODE','like','%'.$search.'%');
                $q->orwhere('PLAN_TYPE_NAME','like','%'.$search.'%');
                $q->orwhere('PRO_NAME','like','%'.$search.'%');
                $q->orwhere('PRO_TEAM_HR_NAME','like','%'.$search.'%');
                $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
                $q->orwhere('PLAN_TRACKING_NAME','like','%'.$search.'%');
           })
           ->WhereBetween('PRO_BEGIN_DATE',[$from,$to]) 
            ->sum('BUDGET_PICE');

        }

        

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id =  $yearbudget;
      
        return view('general_plan.geninfoplan_project',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infoprojects' => $infoproject,
            'sumbudget' => $sumbudget,
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'type'=>$type,  
         
            
        ]);
    }


    public function project_add(Request $request,$iduser)
    {      

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        $infoyear = DB::table('plan_year')->first();

         if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
            $yearbudget = $infoyear->PLAN_YEAR;
         }else{
            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
    
         }

      

        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;


        $infoplantype =  DB::table('plan_type')->get();

        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();

        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();

        return view('general_plan.geninfoplan_project_add',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'infoplantypes'=>$infoplantype,
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,

        ]);
    }


    public function project_save(Request $request)
    {

                        $BEGIN_DATE = $request->BEGIN_DATE;


                        if($BEGIN_DATE != ''){
                        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BEGIN_DATE)->format('Y-m-d');
                        $date_arrary_st=explode("-",$STARTDAY);  
                        $y_sub_st = $date_arrary_st[0]; 
                        
                        if($y_sub_st >= 2500){
                            $y_st = $y_sub_st-543;
                        }else{
                            $y_st = $y_sub_st;
                        }
                        $m_st = $date_arrary_st[1];
                        $d_st = $date_arrary_st[2];  
                        $BEGINDATE= $y_st."-".$m_st."-".$d_st;
                        }else{
                        $BEGINDATE= null;
                    }

                    $END_DATE = $request->END_DATE;


                    if($END_DATE != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $END_DATE)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $ENDDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $ENDDATE= null;
                }


                $PRO_BEGIN_DATE = $request->PRO_BEGIN_DATE;


                if($PRO_BEGIN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $PRO_BEGIN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $PROBEGINDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $PROBEGINDATE= null;
                }

                $PRO_END_DATE = $request->PRO_END_DATE;


                if($PRO_END_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $PRO_END_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $PROENDDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $PROENDDATE= null;
                }
               
                     //================สร้ารหัสโปรเจค==================================

                     $infoyear = DB::table('plan_year')->first();

                     if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
                        $yearbudget = $infoyear->PLAN_YEAR;
                     }else{
                        $m_budget = date("m");
                        if($m_budget>9){
                        $yearbudget = date("Y")+544;
                        }else{
                        $yearbudget = date("Y")+543;
                        }
                
                     }
             
                     $maxnumber = DB::table('plan_project')->where('BUDGET_YEAR','=',$yearbudget)->max('PRO_ID');  
             
                  
             
                     if($maxnumber != '' ||  $maxnumber != null){
                         
                         $refmax = DB::table('plan_project')->where('PRO_ID','=',$maxnumber)->first();  
             
             
                         if($refmax->PRO_NUMBER != '' ||  $refmax->PRO_NUMBER != null){
                             $maxref = substr($refmax->PRO_NUMBER, -4)+1;
                          }else{
                             $maxref = 1;
                          }
             
                         $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
                    
                     }else{
                         $ref = '0001';
                     }
             
                     
                     $y = substr($yearbudget, -2);
                    
             
                     $PRO_NUMBER ='P-'.$y.''.$ref;
             
     
                     //==================================================






                    $add = new Planproject();
                    $add->PRO_SAVE_HR_ID = $request->PRO_SAVE_HR_ID;
                    $add->PRO_TYPE = $request->PRO_TYPE;

                    $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->PRO_SAVE_HR_ID)->first();
                    $add->PRO_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->BUDGET_YEAR = $request->BUDGET_YEAR;
                   
                    if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
                        $add->STRATEGIC_ID = $request->STRATEGIC_ID;
                    }

                    if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
                        $add->TARGET_ID = $request->TARGET_ID;
                    }

                    if($request->KPI_ID !== '' || $request->KPI_ID !== null){
                        $add->KPI_ID = $request->KPI_ID;
                    }
                   
                    $add->PRO_NUMBER = $PRO_NUMBER;
                    $add->PRO_NAME = $request->PRO_NAME;
                    $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
                    $add->BUDGET_ID = $request->BUDGET_ID;
                    $add->BUDGET_PICE = $request->BUDGET_PICE;
                    $add->BUDGET_PICE_REAL = $request->BUDGET_PICE_REAL;

                    $add->PRO_BEGIN_DATE = $PROBEGINDATE;
                    $add->PRO_END_DATE = $PROENDDATE;

                    $add->PRO_TEAM_NAME = $request->PRO_TEAM_NAME;

                    $add->PRO_TEAM_HR_ID = $request->PRO_TEAM_HR_ID;
                    $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->PRO_TEAM_HR_ID)->first();
                    $add->PRO_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->PRO_COMMENT = $request->PRO_COMMENT;

                    $add->PRO_STATUS = 'WAIT';
                
                    $add->save();

                
                    return redirect()->route('guest.geninfoplan_project',[
                        'iduser' => $request->PRO_SAVE_HR_ID,
        
                    ]);
 


    }


    
    public function project_edit(Request $request,$idref,$iduser)
    {      


        
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;


        $infoplantype =  DB::table('plan_type')->get();

        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();

        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();


        $infoproject =  Planproject::leftjoin('plan_target','plan_target.TARGET_ID','=','plan_project.TARGET_ID')
        ->leftjoin('plan_kpi','plan_kpi.KPI_ID','=','plan_project.KPI_ID')
        ->leftjoin('hrd_person','plan_project.PRO_TEAM_HR_ID','=','hrd_person.ID')
        ->where('PRO_ID','=',$idref)
        ->first();


        return view('general_plan.geninfoplan_project_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'infoplantypes'=>$infoplantype,
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,
            'infoproject'=>$infoproject,


        ]);
    }


    public function project_update(Request $request)
    {

                        $BEGIN_DATE = $request->BEGIN_DATE;


                        if($BEGIN_DATE != ''){
                        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BEGIN_DATE)->format('Y-m-d');
                        $date_arrary_st=explode("-",$STARTDAY);  
                        $y_sub_st = $date_arrary_st[0]; 
                        
                        if($y_sub_st >= 2500){
                            $y_st = $y_sub_st-543;
                        }else{
                            $y_st = $y_sub_st;
                        }
                        $m_st = $date_arrary_st[1];
                        $d_st = $date_arrary_st[2];  
                        $BEGINDATE= $y_st."-".$m_st."-".$d_st;
                        }else{
                        $BEGINDATE= null;
                    }

                    $END_DATE = $request->END_DATE;


                    if($END_DATE != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $END_DATE)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $ENDDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $ENDDATE= null;
                }


                $PRO_BEGIN_DATE = $request->PRO_BEGIN_DATE;


                if($PRO_BEGIN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $PRO_BEGIN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $PROBEGINDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $PROBEGINDATE= null;
                }

                $PRO_END_DATE = $request->PRO_END_DATE;


                if($PRO_END_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $PRO_END_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $PROENDDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $PROENDDATE= null;
                }


                  $id = $request->PRO_ID;


                    $add = Planproject::find($id);
                    $add->PRO_SAVE_HR_ID = $request->PRO_SAVE_HR_ID;
                    $add->PRO_TYPE = $request->PRO_TYPE;

                    $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->PRO_SAVE_HR_ID)->first();
                    $add->PRO_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->BUDGET_YEAR = $request->BUDGET_YEAR;
                   
                    if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
                        $add->STRATEGIC_ID = $request->STRATEGIC_ID;
                    }

                    if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
                        $add->TARGET_ID = $request->TARGET_ID;
                    }

                    if($request->KPI_ID !== '' || $request->KPI_ID !== null){
                        $add->KPI_ID = $request->KPI_ID;
                    }
                   
                    $add->PRO_NUMBER = $request->PRO_NUMBER;
                    $add->PRO_NAME = $request->PRO_NAME;
                    $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
                    $add->BUDGET_ID = $request->BUDGET_ID;
                    $add->BUDGET_PICE = $request->BUDGET_PICE;
                    $add->BUDGET_PICE_REAL = $request->BUDGET_PICE_REAL;

                    $add->PRO_BEGIN_DATE = $PROBEGINDATE;
                    $add->PRO_END_DATE = $PROENDDATE;

                    $add->PRO_TEAM_NAME = $request->PRO_TEAM_NAME;

                    $add->PRO_TEAM_HR_ID = $request->PRO_TEAM_HR_ID;
                    $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->PRO_TEAM_HR_ID)->first();
                    $add->PRO_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->PRO_COMMENT = $request->PRO_COMMENT;
                
                    $add->save();

                
                    return redirect()->route('guest.geninfoplan_project',[
                        'iduser' => $request->PRO_SAVE_HR_ID,
        
                    ]);
 
 


    }




    //-----------------------------


    public function geninfoplan_humandev(Request $request,$iduser)
    {
       
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $infoyear = DB::table('plan_year')->first();

        if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
           $yearbudget = $infoyear->PLAN_YEAR;
        }else{
           $m_budget = date("m");
           if($m_budget>9){
           $yearbudget = date("Y")+544;
           }else{
           $yearbudget = date("Y")+543;
           }
   
        }

        $infohumandev = DB::table('plan_humandev')->where('BUDGET_YEAR','=', $yearbudget)
        ->leftjoin('plan_humandev_type','plan_humandev.HUM_TYPE_NAME','=','plan_humandev_type.PLAN_HUMANDEV_TYPE_ID')
        ->leftJoin('supplies_budget','plan_humandev.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->orderBy('HUM_ID', 'asc')->get();
        
        $sumbudget = DB::table('plan_humandev')->where('BUDGET_YEAR','=', $yearbudget)->SUM('BUDGET_PICE');

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $search = '';
        $year_id =  $yearbudget;
        $type ='';
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
 


        return view('general_plan.geninfoplan_humandev',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infohumandevs' => $infohumandev,
            'sumbudget' => $sumbudget,
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id, 
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'type'=>$type,  
         
            
        ]);
    }



    
    public function humandev_search(Request $request,$iduser)
    {      


        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $type = $request->SEND_TYPE;
    
      
        if($search==''){
            $search="";
        }


        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
  
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
     

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);


        if($type == null || $type == ''){

            $infohumandev = DB::table('plan_humandev')
            ->leftjoin('plan_humandev_type','plan_humandev.HUM_TYPE_NAME','=','plan_humandev_type.PLAN_HUMANDEV_TYPE_ID')
            ->leftJoin('supplies_budget','plan_humandev.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                 $q->where('HUM_NUMBER','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TYPE_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('HUM_BEGIN_DATE',[$from,$to]) 
            ->orderBy('HUM_ID', 'asc')->get();
     
            $sumbudget = DB::table('plan_humandev')
            ->leftjoin('plan_humandev_type','plan_humandev.HUM_TYPE_NAME','=','plan_humandev_type.PLAN_HUMANDEV_TYPE_ID')
            ->leftJoin('supplies_budget','plan_humandev.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                 $q->where('HUM_NUMBER','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TYPE_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
               
            })
            ->WhereBetween('HUM_BEGIN_DATE',[$from,$to]) 
            ->SUM('BUDGET_PICE');
    

         


        }else{



             
            $infohumandev = DB::table('plan_humandev')
            ->leftjoin('plan_humandev_type','plan_humandev.HUM_TYPE_NAME','=','plan_humandev_type.PLAN_HUMANDEV_TYPE_ID')
            ->leftJoin('supplies_budget','plan_humandev.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('HUM_TYPE','=',$type)
            ->where(function($q) use ($search){
                 $q->where('HUM_NUMBER','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TYPE_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('HUM_BEGIN_DATE',[$from,$to]) 
            ->orderBy('HUM_ID', 'asc')->get();
     
            $sumbudget = DB::table('plan_humandev')
            ->leftjoin('plan_humandev_type','plan_humandev.HUM_TYPE_NAME','=','plan_humandev_type.PLAN_HUMANDEV_TYPE_ID')
            ->leftJoin('supplies_budget','plan_humandev.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('HUM_TYPE','=',$type)
            ->where(function($q) use ($search){
                 $q->where('HUM_NUMBER','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TYPE_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_NAME','like','%'.$search.'%');
                 $q->orwhere('HUM_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
               
            })
            ->WhereBetween('HUM_BEGIN_DATE',[$from,$to]) 
            ->SUM('BUDGET_PICE');
        
        }
       

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id =  $yearbudget;
        
        
        return view('general_plan.geninfoplan_humandev',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infohumandevs' => $infohumandev,
            'sumbudget' => $sumbudget,
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id, 
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'type'=>$type,  
         
            
        ]);
    }


  
    public function humandev_add(Request $request,$iduser)
    {      


        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $infoyear = DB::table('plan_year')->first();

        if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
           $yearbudget = $infoyear->PLAN_YEAR;
        }else{
           $m_budget = date("m");
           if($m_budget>9){
           $yearbudget = date("Y")+544;
           }else{
           $yearbudget = date("Y")+543;
           }
   
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;


        $infoplantype =  DB::table('plan_type')->get();

        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();

        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();


        $infohumandevtype =  DB::table('plan_humandev_type')->get();
        
        return view('general_plan.geninfoplan_humandev_add',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'infoplantypes'=>$infoplantype,
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,
            'infohumandevtypes'=>$infohumandevtype,


        ]);
    }



    public function humandev_save(Request $request)
    {

                        $BEGIN_DATE = $request->BEGIN_DATE;


                        if($BEGIN_DATE != ''){
                        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BEGIN_DATE)->format('Y-m-d');
                        $date_arrary_st=explode("-",$STARTDAY);  
                        $y_sub_st = $date_arrary_st[0]; 
                        
                        if($y_sub_st >= 2500){
                            $y_st = $y_sub_st-543;
                        }else{
                            $y_st = $y_sub_st;
                        }
                        $m_st = $date_arrary_st[1];
                        $d_st = $date_arrary_st[2];  
                        $BEGINDATE= $y_st."-".$m_st."-".$d_st;
                        }else{
                        $BEGINDATE= null;
                    }

                    $END_DATE = $request->END_DATE;


                    if($END_DATE != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $END_DATE)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $ENDDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $ENDDATE= null;
                }


                $HUM_BEGIN_DATE = $request->HUM_BEGIN_DATE;


                if($HUM_BEGIN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $HUM_BEGIN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $HUMBEGINDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $HUMBEGINDATE= null;
                }

                $HUM_END_DATE = $request->HUM_END_DATE;


                if($HUM_END_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $HUM_END_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $HUMENDDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $HUMENDDATE= null;
                }


                       //==============================สร้างรหัส=====

                       $infoyear = DB::table('plan_year')->first();

                       if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
                          $yearbudget = $infoyear->PLAN_YEAR;
                       }else{
                          $m_budget = date("m");
                          if($m_budget>9){
                          $yearbudget = date("Y")+544;
                          }else{
                          $yearbudget = date("Y")+543;
                          }
                  
                       }
               
                       $maxnumber = DB::table('plan_humandev')->where('BUDGET_YEAR','=',$yearbudget)->max('HUM_ID');  
               
                    
               
                       if($maxnumber != '' ||  $maxnumber != null){
                           
                           $refmax = DB::table('plan_humandev')->where('HUM_ID','=',$maxnumber)->first();  
               
               
                           if($refmax->HUM_NUMBER != '' ||  $refmax->HUM_NUMBER != null){
                               $maxref = substr($refmax->HUM_NUMBER, -4)+1;
                            }else{
                               $maxref = 1;
                            }
               
                           $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
                      
                       }else{
                           $ref = '0001';
                       }
               
                       $y = substr($yearbudget, -2);
                      
               
                    $HUM_NUMBER ='H-'.$y.''.$ref;
       
                       //==========================================



                    $add = new Planhumandev();
                    $add->HUM_SAVE_HR_ID = $request->HUM_SAVE_HR_ID;
                    $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
                    $add->HUM_TYPE = $request->HUM_TYPE;

                    $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->HUM_SAVE_HR_ID)->first();
                    $add->HUM_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->BUDGET_YEAR = $request->BUDGET_YEAR;


                    if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
                        $add->STRATEGIC_ID = $request->STRATEGIC_ID;
                    }

                    if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
                        $add->TARGET_ID = $request->TARGET_ID;
                    }

                    if($request->KPI_ID !== '' || $request->KPI_ID !== null){
                        $add->KPI_ID = $request->KPI_ID;
                    }
                   


                    $add->HUM_NUMBER = $HUM_NUMBER;
                    $add->HUM_NAME = $request->HUM_NAME;
                    $add->HUM_TYPE_NAME = $request->HUM_TYPE_NAME;
                    $add->BUDGET_ID = $request->BUDGET_ID;
                    $add->BUDGET_PICE = $request->BUDGET_PICE;
                    $add->BUDGET_PICE_REAL = $request->BUDGET_PICE_REAL;

                    $add->BEGIN_DATE = $BEGINDATE;
                    $add->END_DATE = $ENDDATE;
                    $add->HUM_BEGIN_DATE = $HUMBEGINDATE;
                    $add->HUM_END_DATE = $HUMENDDATE;

                    $add->HUM_GROUP = $request->HUM_GROUP;
                    $add->HUM_LOCATION = $request->HUM_LOCATION;
                    $add->HUM_EXPERT = $request->HUM_EXPERT;
                    
                    $add->HUM_TEAM_NAME = $request->HUM_TEAM_NAME;

                    $add->HUM_TEAM_HR_ID = $request->HUM_TEAM_HR_ID;
                    $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->HUM_TEAM_HR_ID)->first();
                    $add->HUM_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->HUM_COMMENT = $request->HUM_COMMENT;
                    $add->HUM_STATUS = 'WAIT';
                
                    $add->save();

                
                    return redirect()->route('guest.geninfoplan_humandev',[
                        'iduser' => $request->HUM_SAVE_HR_ID,
        
                    ]);
 


    }

     
    
    
    public function humandev_edit(Request $request,$idref,$iduser)
    {      

        
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;


        $infoplantype =  DB::table('plan_type')->get();

        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();

        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();

        $infohum =  Planhumandev::leftjoin('plan_target','plan_target.TARGET_ID','=','plan_humandev.TARGET_ID')
        ->leftjoin('plan_kpi','plan_kpi.KPI_ID','=','plan_humandev.KPI_ID')
        ->leftjoin('hrd_person','plan_humandev.HUM_TEAM_HR_ID','=','hrd_person.ID')
        ->where('HUM_ID','=',$idref)
        ->first();


        $infohumandevtype =  DB::table('plan_humandev_type')->get();
         
        return view('general_plan.geninfoplan_humandev_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'infoplantypes'=>$infoplantype,
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,
            'infohum'=>$infohum,
            'infohumandevtypes'=>$infohumandevtype,



        ]);
    }



    public function humandev_update(Request $request)
    {

                        $BEGIN_DATE = $request->BEGIN_DATE;


                        if($BEGIN_DATE != ''){
                        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BEGIN_DATE)->format('Y-m-d');
                        $date_arrary_st=explode("-",$STARTDAY);  
                        $y_sub_st = $date_arrary_st[0]; 
                        
                        if($y_sub_st >= 2500){
                            $y_st = $y_sub_st-543;
                        }else{
                            $y_st = $y_sub_st;
                        }
                        $m_st = $date_arrary_st[1];
                        $d_st = $date_arrary_st[2];  
                        $BEGINDATE= $y_st."-".$m_st."-".$d_st;
                        }else{
                        $BEGINDATE= null;
                    }

                    $END_DATE = $request->END_DATE;


                    if($END_DATE != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $END_DATE)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $ENDDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $ENDDATE= null;
                }


                $HUM_BEGIN_DATE = $request->HUM_BEGIN_DATE;


                if($HUM_BEGIN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $HUM_BEGIN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $HUMBEGINDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $HUMBEGINDATE= null;
                }

                $HUM_END_DATE = $request->HUM_END_DATE;


                if($HUM_END_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $HUM_END_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $HUMENDDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $HUMENDDATE= null;
                }


                        $id = $request->HUM_ID;

                    $add = Planhumandev::find($id);
                    $add->HUM_SAVE_HR_ID = $request->HUM_SAVE_HR_ID;
                    $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
                    $add->HUM_TYPE = $request->HUM_TYPE;

                    $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->HUM_SAVE_HR_ID)->first();
                    $add->HUM_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->BUDGET_YEAR = $request->BUDGET_YEAR;


                    if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
                        $add->STRATEGIC_ID = $request->STRATEGIC_ID;
                    }

                    if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
                        $add->TARGET_ID = $request->TARGET_ID;
                    }

                    if($request->KPI_ID !== '' || $request->KPI_ID !== null){
                        $add->KPI_ID = $request->KPI_ID;
                    }
                   


                    $add->HUM_NUMBER = $request->HUM_NUMBER;
                    $add->HUM_NAME = $request->HUM_NAME;
                    $add->HUM_TYPE_NAME = $request->HUM_TYPE_NAME;
                    $add->BUDGET_ID = $request->BUDGET_ID;
                    $add->BUDGET_PICE = $request->BUDGET_PICE;
                    $add->BUDGET_PICE_REAL = $request->BUDGET_PICE_REAL;

                    $add->BEGIN_DATE = $BEGINDATE;
                    $add->END_DATE = $ENDDATE;
                    $add->HUM_BEGIN_DATE = $HUMBEGINDATE;
                    $add->HUM_END_DATE = $HUMENDDATE;

                    $add->HUM_GROUP = $request->HUM_GROUP;
                    $add->HUM_LOCATION = $request->HUM_LOCATION;
                    $add->HUM_EXPERT = $request->HUM_EXPERT;
                    
                    $add->HUM_TEAM_NAME = $request->HUM_TEAM_NAME;

                    $add->HUM_TEAM_HR_ID = $request->HUM_TEAM_HR_ID;
                    $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->HUM_TEAM_HR_ID)->first();
                    $add->HUM_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->HUM_COMMENT = $request->HUM_COMMENT;
                
                    $add->save();

                
                    return redirect()->route('guest.geninfoplan_humandev',[
                        'iduser' => $request->HUM_SAVE_HR_ID,
        
                    ]);
 


    }




    //-----------------------------

    public function geninfoplan_durable(Request $request,$iduser)
    {
       
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

 
        $infoyear = DB::table('plan_year')->first();

        if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
           $yearbudget = $infoyear->PLAN_YEAR;
        }else{
           $m_budget = date("m");
           if($m_budget>9){
           $yearbudget = date("Y")+544;
           }else{
           $yearbudget = date("Y")+543;
           }
   
        }
        
        $infodurable = DB::table('plan_durable')
        ->leftJoin('supplies_budget','plan_durable.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('BUDGET_YEAR','=', $yearbudget)
        ->orderBy('DUR_ID', 'asc')->get();

        $sumbudget = DB::table('plan_durable')->SUM('DUR_PICE_SUM');

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $search = '';
        $year_id =  $yearbudget;
        $type ='';
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';

        return view('general_plan.geninfoplan_durable',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infodurables' =>  $infodurable,
            'sumbudget' => $sumbudget,
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id,  
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'type'=>$type,   
         
            
        ]);
    }


    
    public function durable_search(Request $request,$iduser)
    {      
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $type = $request->SEND_TYPE;
    
      
        if($search==''){
            $search="";
        }


        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
        $date_arrary=explode("-",$date_bigen_c);
        $y_sub_st = $date_arrary[0];

        if($y_sub_st >= 2500){
            $y = $y_sub_st-543;
        }else{
            $y = $y_sub_st;
        }

        $m = $date_arrary[1];
        $d = $date_arrary[2];  
        $displaydate_bigen= $y."-".$m."-".$d;
  
        $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
        $date_arrary_e=explode("-",$date_end_c); 

        $y_sub_e = $date_arrary_e[0];

        if($y_sub_e >= 2500){
            $y_e = $y_sub_e-543;
        }else{
            $y_e = $y_sub_e;
        }
        $m_e = $date_arrary_e[1];
        $d_e = $date_arrary_e[2];  
        $displaydate_end= $y_e."-".$m_e."-".$d_e;
     

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);


        if($type == null || $type == ''){


            $infodurable = DB::table('plan_durable')
            ->leftJoin('supplies_budget','plan_durable.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                 $q->where('DUR_NUMBER','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_ASS_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('DUR_ASS_BEGIN_DATE',[$from,$to]) 
            ->orderBy('DUR_ID', 'asc')->get();

            $sumbudget = DB::table('plan_durable')
            ->leftJoin('supplies_budget','plan_durable.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                 $q->where('DUR_NUMBER','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_ASS_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('DUR_ASS_BEGIN_DATE',[$from,$to]) 
            ->SUM('DUR_PICE_SUM');


        }else{

           

            $infodurable = DB::table('plan_durable')
            ->leftJoin('supplies_budget','plan_durable.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('DUR_TYPE','=',$type)
            ->where(function($q) use ($search){
                 $q->where('DUR_NUMBER','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_ASS_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('DUR_ASS_BEGIN_DATE',[$from,$to]) 
            ->orderBy('DUR_ID', 'asc')->get();

            $sumbudget = DB::table('plan_durable')
            ->leftJoin('supplies_budget','plan_durable.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('DUR_TYPE','=',$type)
            ->where(function($q) use ($search){
                $q->where('DUR_NUMBER','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_ASS_NAME','like','%'.$search.'%');
                 $q->orwhere('DUR_TEAM_HR_NAME','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
                })
            ->WhereBetween('DUR_ASS_BEGIN_DATE',[$from,$to]) 
            ->SUM('DUR_PICE_SUM');

        
    }

        

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id =  $yearbudget;
        
        
        return view('general_plan.geninfoplan_durable',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infodurables' =>  $infodurable,
            'sumbudget' => $sumbudget,
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id,  
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,  
            'type'=>$type,   
         
            
        ]);
    }


    public function durable_add(Request $request,$iduser)
    {      

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $infoyear = DB::table('plan_year')->first();

        if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
           $yearbudget = $infoyear->PLAN_YEAR;
        }else{
           $m_budget = date("m");
           if($m_budget>9){
           $yearbudget = date("Y")+544;
           }else{
           $yearbudget = date("Y")+543;
           }
   
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;



        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();
        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();

        $infoplantype =  DB::table('plan_type')->get();

        $suppliesprop = DB::table('supplies_prop')->get();

        $assetarticle = DB::table('asset_article')->get();


        return view('general_plan.geninfoplan_durable_add',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'infoplantypes'=>$infoplantype,
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,
            'suppliesprops'=>$suppliesprop,
            'assetarticles'=>$assetarticle



        ]);
    }


    

    public function durable_save(Request $request)
    {


                    $DUR_ASS_BEGIN_DATE = $request->DUR_ASS_BEGIN_DATE;


                    if($DUR_ASS_BEGIN_DATE != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $DUR_ASS_BEGIN_DATE)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $DURASSBEGINDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DURASSBEGINDATE= null;
                    }

                    $DUR_ASS_END_DATE = $request->DUR_ASS_END_DATE;


                    if($DUR_ASS_END_DATE != ''){
                    $STARTDAY = Carbon::createFromFormat('d/m/Y', $DUR_ASS_END_DATE)->format('Y-m-d');
                    $date_arrary_st=explode("-",$STARTDAY);  
                    $y_sub_st = $date_arrary_st[0]; 
                    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];  
                    $DURASSENDDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $DURASSENDDATE= null;
                    }


                         //========================สร้างรหัส======================
                         $infoyear = DB::table('plan_year')->first();

                         if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
                            $yearbudget = $infoyear->PLAN_YEAR;
                         }else{
                            $m_budget = date("m");
                            if($m_budget>9){
                            $yearbudget = date("Y")+544;
                            }else{
                            $yearbudget = date("Y")+543;
                            }
                    
                         }
                 
                         $maxnumber = DB::table('plan_durable')->where('BUDGET_YEAR','=',$yearbudget)->max('DUR_ID');  
                 
                      
                 
                         if($maxnumber != '' ||  $maxnumber != null){
                             
                             $refmax = DB::table('plan_durable')->where('DUR_ID','=',$maxnumber)->first();  
                 
                 
                             if($refmax->DUR_NUMBER != '' ||  $refmax->DUR_NUMBER != null){
                                 $maxref = substr($refmax->DUR_NUMBER, -4)+1;
                              }else{
                                 $maxref = 1;
                              }
                 
                             $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
                        
                         }else{
                             $ref = '0001';
                         }
                 
             
                         $y = substr($yearbudget, -2);
                        
                 
                      $DUR_NUMBER ='A-'.$y.''.$ref;
     
                         //==================================================

                    $add = new Plandurable();
                    $add->DUR_SAVE_HR_ID = $request->DUR_SAVE_HR_ID;
                    $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
                    $add->DUR_TYPE = $request->DUR_TYPE;

                    

                    $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->DUR_SAVE_HR_ID)->first();
                    $add->DUR_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->BUDGET_YEAR = $request->BUDGET_YEAR;
              
                    if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
                        $add->STRATEGIC_ID = $request->STRATEGIC_ID;
                    }

                    if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
                        $add->TARGET_ID = $request->TARGET_ID;
                    }

                    if($request->KPI_ID !== '' || $request->KPI_ID !== null){
                        $add->KPI_ID = $request->KPI_ID;
                    }

                    $add->DUR_NUMBER = $request->DUR_NUMBER;
                    $add->DUR_NAME = $request->DUR_NAME;
                    $add->DUR_ASS_NAME = $request->DUR_ASS_NAME;
                    $add->DUR_ASS_PICE_UNIT = $request->DUR_ASS_PICE_UNIT;


                    $add->BUDGET_ID = $request->BUDGET_ID;
                    $add->BUDGET_PICE = $request->BUDGET_PICE;

                    $add->DUR_ASS_BEGIN_DATE = $DURASSBEGINDATE;
                    $add->DUR_ASS_END_DATE = $DURASSENDDATE; 
                    
                    $add->DUR_TEAM_NAME = $request->DUR_TEAM_NAME;

                    $add->DUR_TEAM_HR_ID = $request->DUR_TEAM_HR_ID;
                    $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                    ->where('hrd_person.ID','=',$request->DUR_TEAM_HR_ID)->first();
                    $add->DUR_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;
        
                    //----------------------------------

                    $add->DUR_COMMENT = $request->DUR_COMMENT;


                    $add->DUR_FSN = $request->DUR_FSN;
                    $add->DUR_REF = $request->DUR_REF;
                    $add->DUR_REF_CODE = $request->DUR_REF_CODE;
                    $add->DUR_SERVICE = $request->DUR_SERVICE;
                    $add->DUR_HASTE = $request->DUR_HASTE;
                    $add->DUR_REASON_ID = $request->DUR_REASON_ID;
                    $add->DUR_ASS_OLD = $request->DUR_ASS_OLD;
                    $add->DUR_ASS_AMOUNT = $request->DUR_ASS_AMOUNT;
                    $add->BUDGET_PICE_REAL = $request->BUDGET_PICE_REAL;

                    $add->DUR_PICE_SUM = $request->DUR_ASS_AMOUNT*$request->DUR_ASS_PICE_UNIT;
                    $add->DUR_STATUS = 'WAIT';
                    $add->save();

                
                    return redirect()->route('guest.geninfoplan_durable',[
                        'iduser'=>$request->DUR_SAVE_HR_ID,
                    ]);
 


    }


    

    public function durable_edit(Request $request,$idref,$iduser)
    {   
        
        
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;



        $infobudgettype =  DB::table('supplies_budget')->get();

        $infotream =  DB::table('hrd_team')->get();

        $infotreamperson =  DB::table('hrd_team_list')->get();
        $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();

        $infoplantype =  DB::table('plan_type')->get();

        $suppliesprop = DB::table('supplies_prop')->get();

        $assetarticle = DB::table('asset_article')->get();


        $infodurable = Plandurable::leftjoin('plan_target','plan_target.TARGET_ID','=','plan_durable.TARGET_ID')
        ->leftjoin('plan_kpi','plan_kpi.KPI_ID','=','plan_durable.KPI_ID')
        ->leftjoin('hrd_person','plan_durable.DUR_TEAM_HR_ID','=','hrd_person.ID')    
        ->where('DUR_ID','=',$idref)    
        ->first();


        return view('general_plan.geninfoplan_durable_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'year_id'=>$year_id,
            'infoplantypes'=>$infoplantype,
            'infobudgettypes'=>$infobudgettype,
            'infotreams'=>$infotream,
            'infotreampersons'=>$infotreamperson,
            'infostrategics'=>$infostrategic,
            'suppliesprops'=>$suppliesprop,
            'assetarticles'=>$assetarticle,
            'infodurable'=>$infodurable,
            'idref'=>$idref



        ]);
    }


    

    public function durable_update(Request $request)
    {

       $DUR_ASS_BEGIN_DATE = $request->DUR_ASS_BEGIN_DATE;


       if($DUR_ASS_BEGIN_DATE != ''){
       $STARTDAY = Carbon::createFromFormat('d/m/Y', $DUR_ASS_BEGIN_DATE)->format('Y-m-d');
       $date_arrary_st=explode("-",$STARTDAY);  
       $y_sub_st = $date_arrary_st[0]; 
       
       if($y_sub_st >= 2500){
           $y_st = $y_sub_st-543;
       }else{
           $y_st = $y_sub_st;
       }
       $m_st = $date_arrary_st[1];
       $d_st = $date_arrary_st[2];  
       $DURASSBEGINDATE= $y_st."-".$m_st."-".$d_st;
       }else{
       $DURASSBEGINDATE= null;
       }

       $DUR_ASS_END_DATE = $request->DUR_ASS_END_DATE;


       if($DUR_ASS_END_DATE != ''){
       $STARTDAY = Carbon::createFromFormat('d/m/Y', $DUR_ASS_END_DATE)->format('Y-m-d');
       $date_arrary_st=explode("-",$STARTDAY);  
       $y_sub_st = $date_arrary_st[0]; 
       
       if($y_sub_st >= 2500){
           $y_st = $y_sub_st-543;
       }else{
           $y_st = $y_sub_st;
       }
       $m_st = $date_arrary_st[1];
       $d_st = $date_arrary_st[2];  
       $DURASSENDDATE= $y_st."-".$m_st."-".$d_st;
       }else{
       $DURASSENDDATE= null;
       }

       $id = $request->DUR_ID;
       $add =  Plandurable::find($id);
       $add->DUR_SAVE_HR_ID = $request->DUR_SAVE_HR_ID;
       $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
       $add->DUR_TYPE = $request->DUR_TYPE;

       

       $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
       ->where('hrd_person.ID','=',$request->DUR_SAVE_HR_ID)->first();
       $add->DUR_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;

       //----------------------------------

       $add->BUDGET_YEAR = $request->BUDGET_YEAR;
 
       if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
           $add->STRATEGIC_ID = $request->STRATEGIC_ID;
       }

       if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
           $add->TARGET_ID = $request->TARGET_ID;
       }

       if($request->KPI_ID !== '' || $request->KPI_ID !== null){
           $add->KPI_ID = $request->KPI_ID;
       }

       $add->DUR_NUMBER = $request->DUR_NUMBER;
       $add->DUR_NAME = $request->DUR_NAME;
       $add->DUR_ASS_NAME = $request->DUR_ASS_NAME;
       $add->DUR_ASS_PICE_UNIT = $request->DUR_ASS_PICE_UNIT;


       $add->BUDGET_ID = $request->BUDGET_ID;
       $add->BUDGET_PICE = $request->BUDGET_PICE;

       $add->DUR_ASS_BEGIN_DATE = $DURASSBEGINDATE;
       $add->DUR_ASS_END_DATE = $DURASSENDDATE; 
       
       $add->DUR_TEAM_NAME = $request->DUR_TEAM_NAME;

       $add->DUR_TEAM_HR_ID = $request->DUR_TEAM_HR_ID;
       $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
       ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
       ->where('hrd_person.ID','=',$request->DUR_TEAM_HR_ID)->first();
       $add->DUR_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;

       //----------------------------------

       $add->DUR_COMMENT = $request->DUR_COMMENT;


       $add->DUR_FSN = $request->DUR_FSN;
       $add->DUR_REF = $request->DUR_REF;
       $add->DUR_REF_CODE = $request->DUR_REF_CODE;
       $add->DUR_SERVICE = $request->DUR_SERVICE;
       $add->DUR_HASTE = $request->DUR_HASTE;
       $add->DUR_REASON_ID = $request->DUR_REASON_ID;
       $add->DUR_ASS_OLD = $request->DUR_ASS_OLD;
       $add->DUR_ASS_AMOUNT = $request->DUR_ASS_AMOUNT;
       $add->BUDGET_PICE_REAL = $request->BUDGET_PICE_REAL;

       $add->DUR_PICE_SUM = $request->DUR_ASS_AMOUNT*$request->DUR_ASS_PICE_UNIT;
   
       $add->save();
                
                    return redirect()->route('guest.geninfoplan_durable',[
                        'iduser' => $request->DUR_SAVE_HR_ID
                    ]);
 


    }


    //===============================


    public function geninfoplan_repair(Request $request,$iduser)
    {
       
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

 
        $infoyear = DB::table('plan_year')->first();

        if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
           $yearbudget = $infoyear->PLAN_YEAR;
        }else{
           $m_budget = date("m");
           if($m_budget>9){
           $yearbudget = date("Y")+544;
           }else{
           $yearbudget = date("Y")+543;
           }
   
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $search = '';
        $year_id =  $yearbudget;
        $type ='';
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
   
        $inforepair  = DB::table('plan_repair')
        ->leftJoin('supplies_budget','plan_repair.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('BUDGET_YEAR','=',$year_id )->get();
      
          
        
        $sumbudget  = DB::table('plan_repair')
        ->leftJoin('supplies_budget','plan_repair.BUDGET_ID','=','supplies_budget.BUDGET_ID')
        ->where('BUDGET_YEAR','=',$year_id )->SUM('REPAIR_PICE_SUM');
   


        return view('general_plan.geninfoplan_repair',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id,  
            'type'=>$type, 
            'inforepairs'=>$inforepair, 
            'sumbudget'=>$sumbudget, 
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,     
         
            
        ]);
    }


    public function repair_search(Request $request,$iduser)
    {      

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

        
        $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
        ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
        ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
        ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
        ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
        ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
        ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
        ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
        ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        
        $search = $request->get('search');
        $yearbudget = $request->BUDGET_YEAR;
        $datebigin = $request->get('DATE_BIGIN');
       $dateend = $request->get('DATE_END');
        $type = $request->SEND_TYPE;
    
      
        if($search==''){
            $search="";
        }
   
        $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
           $date_arrary=explode("-",$date_bigen_c);
           $y_sub_st = $date_arrary[0];
   
           if($y_sub_st >= 2500){
               $y = $y_sub_st-543;
           }else{
               $y = $y_sub_st;
           }
   
           $m = $date_arrary[1];
           $d = $date_arrary[2];  
           $displaydate_bigen= $y."-".$m."-".$d;
     
           $date_end_c = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
           $date_arrary_e=explode("-",$date_end_c); 
   
           $y_sub_e = $date_arrary_e[0];
   
           if($y_sub_e >= 2500){
               $y_e = $y_sub_e-543;
           }else{
               $y_e = $y_sub_e;
           }
           $m_e = $date_arrary_e[1];
           $d_e = $date_arrary_e[2];  
           $displaydate_end= $y_e."-".$m_e."-".$d_e;
        
   
           $from = date($displaydate_bigen);
           $to = date($displaydate_end);
   
   
        if($type == null || $type == ''){
   
   
           $inforepair  = DB::table('plan_repair')
        ->leftJoin('supplies_budget','plan_repair.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
                 $q->where('REPAIR_NUMBER','like','%'.$search.'%');
                 $q->orwhere('REPAIR_TEAM_NAME','like','%'.$search.'%');
                 $q->orwhere('REPAIR_PLAN_DETAIL','like','%'.$search.'%');
                 $q->orwhere('REPAIR_PLAN_FROM','like','%'.$search.'%');
                 $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('REPAIR_BEGIN_DATE',[$from,$to]) 
            ->orderBy('REPAIR_PLAN_ID', 'asc')->get();
   
            $sumbudget  = DB::table('plan_repair')
            ->leftJoin('supplies_budget','plan_repair.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where(function($q) use ($search){
               $q->where('REPAIR_NUMBER','like','%'.$search.'%');
               $q->orwhere('REPAIR_TEAM_NAME','like','%'.$search.'%');
               $q->orwhere('REPAIR_PLAN_DETAIL','like','%'.$search.'%');
               $q->orwhere('REPAIR_PLAN_FROM','like','%'.$search.'%');
               $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('REPAIR_BEGIN_DATE',[$from,$to]) 
            ->SUM('REPAIR_PICE_SUM');
   
   
        }else{
   
           
   
           $inforepair  = DB::table('plan_repair')
        ->leftJoin('supplies_budget','plan_repair.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('REPAIR_TYPE','=',$type)
            ->where(function($q) use ($search){
               $q->where('REPAIR_NUMBER','like','%'.$search.'%');
               $q->orwhere('REPAIR_TEAM_NAME','like','%'.$search.'%');
               $q->orwhere('REPAIR_PLAN_DETAIL','like','%'.$search.'%');
               $q->orwhere('REPAIR_PLAN_FROM','like','%'.$search.'%');
               $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('REPAIR_BEGIN_DATE',[$from,$to]) 
            ->orderBy('REPAIR_PLAN_ID', 'asc')->get();
   
            $sumbudget  = DB::table('plan_repair')
        ->leftJoin('supplies_budget','plan_repair.BUDGET_ID','=','supplies_budget.BUDGET_ID')
            ->where('BUDGET_YEAR','=', $yearbudget)
            ->where('REPAIR_TYPE','=',$type)
            ->where(function($q) use ($search){
               $q->where('REPAIR_NUMBER','like','%'.$search.'%');
               $q->orwhere('REPAIR_TEAM_NAME','like','%'.$search.'%');
               $q->orwhere('REPAIR_PLAN_DETAIL','like','%'.$search.'%');
               $q->orwhere('REPAIR_PLAN_FROM','like','%'.$search.'%');
               $q->orwhere('BUDGET_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('REPAIR_BEGIN_DATE',[$from,$to]) 
            ->SUM('REPAIR_PICE_SUM');
   
        
    }
   
        
   
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id =  $yearbudget;
        
        
        return view('general_plan.geninfoplan_repair',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'budgets' =>  $budget,
            'search'=> $search,
            'year_id'=>$year_id,  
            'type'=>$type, 
            'inforepairs'=>$inforepair, 
            'sumbudget'=>$sumbudget, 
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,     
         
            
        ]);
    }

    

 public function repair_add(Request $request,$iduser)
 {      

    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
    $id = $inforpersonuserid->ID;

    
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
    ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
    ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
    ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
    ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
    ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
    ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
    ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
    ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
    ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

     $infoyear = DB::table('plan_year')->first();

     if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
        $yearbudget = $infoyear->PLAN_YEAR;
     }else{
        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

     }
     
     $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
     $year_id = $yearbudget;



     $infobudgettype =  DB::table('supplies_budget')->get();

     $infotream =  DB::table('hrd_team')->get();

     $infotreamperson =  DB::table('hrd_team_list')->get();
     $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();

     $infoplantype =  DB::table('plan_type')->get();

     $suppliesprop = DB::table('supplies_prop')->get();

     $assetarticle = DB::table('asset_article')->get();


     return view('general_plan.geninfoplan_repair_add',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
         'budgets' =>  $budget,
         'year_id'=>$year_id,
         'infoplantypes'=>$infoplantype,
         'infobudgettypes'=>$infobudgettype,
         'infotreams'=>$infotream,
         'infotreampersons'=>$infotreamperson,
         'infostrategics'=>$infostrategic,
         'suppliesprops'=>$suppliesprop,
         'assetarticles'=>$assetarticle



     ]);
 }


 

 public function repair_save(Request $request)
 {


                 $REPAIR_BEGIN_DATE = $request->REPAIR_BEGIN_DATE;


                 if($REPAIR_BEGIN_DATE != ''){
                 $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_BEGIN_DATE)->format('Y-m-d');
                 $date_arrary_st=explode("-",$STARTDAY);  
                 $y_sub_st = $date_arrary_st[0]; 
                 
                 if($y_sub_st >= 2500){
                     $y_st = $y_sub_st-543;
                 }else{
                     $y_st = $y_sub_st;
                 }
                 $m_st = $date_arrary_st[1];
                 $d_st = $date_arrary_st[2];  
                 $REPAIRBEGINDATE= $y_st."-".$m_st."-".$d_st;
                 }else{
                 $REPAIRBEGINDATE= null;
                 }

                 $REPAIR_END_DATE = $request->REPAIR_END_DATE;


                 if($REPAIR_END_DATE != ''){
                 $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_END_DATE)->format('Y-m-d');
                 $date_arrary_st=explode("-",$STARTDAY);  
                 $y_sub_st = $date_arrary_st[0]; 
                 
                 if($y_sub_st >= 2500){
                     $y_st = $y_sub_st-543;
                 }else{
                     $y_st = $y_sub_st;
                 }
                 $m_st = $date_arrary_st[1];
                 $d_st = $date_arrary_st[2];  
                 $REPAIRENDDATE= $y_st."-".$m_st."-".$d_st;
                 }else{
                 $REPAIRENDDATE= null;
                 }


                       //=================สร้างรหัส========
                       $infoyear = DB::table('plan_year')->first();

                       if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
                          $yearbudget = $infoyear->PLAN_YEAR;
                       }else{
                          $m_budget = date("m");
                          if($m_budget>9){
                          $yearbudget = date("Y")+544;
                          }else{
                          $yearbudget = date("Y")+543;
                          }
                  
                       }
               
                       $maxnumber = DB::table('plan_repair')->where('BUDGET_YEAR','=',$yearbudget)->max('REPAIR_PLAN_ID');  
               
                    
               
                       if($maxnumber != '' ||  $maxnumber != null){
                           
                           $refmax = DB::table('plan_repair')->where('REPAIR_PLAN_ID','=',$maxnumber)->first();  
               
               
                           if($refmax->REPAIR_NUMBER != '' ||  $refmax->REPAIR_NUMBER != null){
                               $maxref = substr($refmax->REPAIR_NUMBER, -4)+1;
                            }else{
                               $maxref = 1;
                            }
               
                           $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
                      
                       }else{
                           $ref = '0001';
                       }
               
           
                       $y = substr($yearbudget, -2);
                      
               
                      $REPAIR_NUMBER ='B-'.$y.''.$ref;
      
                       //===============================
      

                 $add = new Planrepair();
                 $add->REPAIR_SAVE_HR_ID = $request->REPAIR_SAVE_HR_ID;
                 $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
              

                 $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                 ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                 ->where('hrd_person.ID','=',$request->REPAIR_SAVE_HR_ID)->first();
                 $add->REPAIR_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;
     
                 //----------------------------------

                 $add->BUDGET_YEAR = $request->BUDGET_YEAR;
           
                 if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
                     $add->STRATEGIC_ID = $request->STRATEGIC_ID;
                 }

                 if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
                     $add->TARGET_ID = $request->TARGET_ID;
                 }

                 if($request->KPI_ID !== '' || $request->KPI_ID !== null){
                     $add->KPI_ID = $request->KPI_ID;
                 }

                 $add->REPAIR_NUMBER = $REPAIR_NUMBER ;
                 $add->REPAIR_SERVICE = $request->REPAIR_SERVICE;
                 $add->BUDGET_ID = $request->BUDGET_ID;
                 $add->REPAIR_PLAN_TYPE = $request->REPAIR_PLAN_TYPE;

                 $add->REPAIR_PLAN_DETAIL = $request->REPAIR_PLAN_DETAIL;
                 $add->REPAIR_PLAN_REASON = $request->REPAIR_PLAN_REASON;
                 $add->REPAIR_PLAN_FROM = $request->REPAIR_PLAN_FROM;
                 $add->REPAIR_AMOUNT = $request->REPAIR_AMOUNT;
                 $add->REPAIR_PICE_UNIT = $request->REPAIR_PICE_UNIT;
                 $add->REPAIR_PICE_REAL = $request->REPAIR_PICE_REAL;
                 $add->REPAIR_TYPE = $request->REPAIR_TYPE;
                 $add->REPAIR_BEGIN_DATE = $REPAIRBEGINDATE;
                 $add->REPAIR_END_DATE = $REPAIRENDDATE;   
                 $add->REPAIR_TEAM_NAME = $request->REPAIR_TEAM_NAME;

                 $add->REPAIR_TEAM_HR_ID = $request->REPAIR_TEAM_HR_ID;
                 $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                 ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                 ->where('hrd_person.ID','=',$request->REPAIR_TEAM_HR_ID)->first();
                 $add->REPAIR_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;
     
             
                 //----------------------------------

                 $add->REPAIR_COMMENT = $request->REPAIR_COMMENT;
                 $add->REPAIR_PICE_SUM = $request->REPAIR_AMOUNT*$request->REPAIR_PICE_UNIT;      
                 $add->REPAIR_STATUS = 'WAIT';
                 $add->save();

             
                 return redirect()->route('guest.geninfoplan_repair',[
                    'iduser'=>$request->REPAIR_SAVE_HR_ID
                 ]);



 }


 

 public function repair_edit(Request $request,$idref,$iduser)
 {      

    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
    $id = $inforpersonuserid->ID;

    
    $inforpersonuser=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_sex','hrd_person.SEX','=','hrd_sex.SEX_ID')
    ->leftJoin('hrd_status','hrd_person.HR_STATUS_ID','=','hrd_status.HR_STATUS_ID')
    ->leftJoin('hrd_level','hrd_person.HR_LEVEL_ID','=','hrd_level.HR_LEVEL_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_person.HR_DEPARTMENT_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->leftJoin('hrd_bloodgroup','hrd_person.HR_BLOODGROUP_ID','=','hrd_bloodgroup.HR_BLOODGROUP_ID')
    ->leftJoin('hrd_marry_status','hrd_person.HR_MARRY_STATUS_ID','=','hrd_marry_status.HR_MARRY_STATUS_ID')
    ->leftJoin('hrd_religion','hrd_person.HR_RELIGION_ID','=','hrd_religion.HR_RELIGION_ID')
    ->leftJoin('hrd_nationality','hrd_person.HR_NATIONALITY_ID','=','hrd_nationality.HR_NATIONALITY_ID')
    ->leftJoin('hrd_citizenship','hrd_person.HR_CITIZENSHIP_ID','=','hrd_citizenship.HR_CITIZENSHIP_ID')
    ->leftJoin('hrd_tumbon','hrd_person.TUMBON_ID','=','hrd_tumbon.ID')
    ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID','=','hrd_amphur.ID')
    ->leftJoin('hrd_province','hrd_person.PROVINCE_ID','=','hrd_province.ID')
    ->leftJoin('hrd_kind','hrd_person.HR_KIND_ID','=','hrd_kind.HR_KIND_ID')
    ->leftJoin('hrd_kind_type','hrd_person.HR_KIND_TYPE_ID','=','hrd_kind_type.HR_KIND_TYPE_ID')
    ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    
    $infoyear = DB::table('plan_year')->first();

    if($infoyear->PLAN_YEAR !== '' && $infoyear->PLAN_YEAR !== null){
       $yearbudget = $infoyear->PLAN_YEAR;
    }else{
       $m_budget = date("m");
       if($m_budget>9){
       $yearbudget = date("Y")+544;
       }else{
       $yearbudget = date("Y")+543;
       }

    }
    
    $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
    $year_id = $yearbudget;



    $infobudgettype =  DB::table('supplies_budget')->get();

    $infotream =  DB::table('hrd_team')->get();

    $infotreamperson =  DB::table('hrd_team_list')->get();
    $infostrategic =  DB::table('plan_strategic')->where('ACTIVE','=','TRUE')->get();

    $infoplantype =  DB::table('plan_type')->get();

    $suppliesprop = DB::table('supplies_prop')->get();

    $assetarticle = DB::table('asset_article')->get();


     $infoplanrepair = Planrepair::leftjoin('plan_target','plan_target.TARGET_ID','=','plan_repair.TARGET_ID')
     ->leftjoin('plan_kpi','plan_kpi.KPI_ID','=','plan_repair.KPI_ID')
     ->leftjoin('hrd_person','plan_repair.REPAIR_TEAM_HR_ID','=','hrd_person.ID')    
     ->where('REPAIR_PLAN_ID','=',$idref)    
     ->first();



     return view('general_plan.geninfoplan_repair_edit',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'budgets' =>  $budget,
        'year_id'=>$year_id,
        'infoplantypes'=>$infoplantype,
        'infobudgettypes'=>$infobudgettype,
        'infotreams'=>$infotream,
        'infotreampersons'=>$infotreamperson,
        'infostrategics'=>$infostrategic,
        'suppliesprops'=>$suppliesprop,
        'assetarticles'=>$assetarticle,
        'infoplanrepair'=>$infoplanrepair,

     ]);
 }


 

 public function repair_update(Request $request)
 {

                $id = $request->REPAIR_PLAN_ID;
                $REPAIR_BEGIN_DATE = $request->REPAIR_BEGIN_DATE;


                if($REPAIR_BEGIN_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_BEGIN_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $REPAIRBEGINDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $REPAIRBEGINDATE= null;
                }

                $REPAIR_END_DATE = $request->REPAIR_END_DATE;


                if($REPAIR_END_DATE != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $REPAIR_END_DATE)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $REPAIRENDDATE= $y_st."-".$m_st."-".$d_st;
                }else{
                $REPAIRENDDATE= null;
                }

                $add = Planrepair::find($id);
                $add->REPAIR_SAVE_HR_ID = $request->REPAIR_SAVE_HR_ID;
                $add->PLAN_TYPE_ID = $request->PLAN_TYPE_ID;
             

                $SAVE_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                ->where('hrd_person.ID','=',$request->REPAIR_SAVE_HR_ID)->first();
                $add->REPAIR_SAVE_HR_NAME   = $SAVE_HR_NAME->HR_PREFIX_NAME.''.$SAVE_HR_NAME->HR_FNAME.' '.$SAVE_HR_NAME->HR_LNAME;
    
                //----------------------------------

                $add->BUDGET_YEAR = $request->BUDGET_YEAR;
          
                if($request->STRATEGIC_ID !== '' || $request->STRATEGIC_ID !== null){
                    $add->STRATEGIC_ID = $request->STRATEGIC_ID;
                }

                if($request->TARGET_ID !== '' || $request->TARGET_ID !== null){
                    $add->TARGET_ID = $request->TARGET_ID;
                }

                if($request->KPI_ID !== '' || $request->KPI_ID !== null){
                    $add->KPI_ID = $request->KPI_ID;
                }

                $add->REPAIR_NUMBER = $request->REPAIR_NUMBER;
                $add->REPAIR_SERVICE = $request->REPAIR_SERVICE;
                $add->BUDGET_ID = $request->BUDGET_ID;
                $add->REPAIR_PLAN_TYPE = $request->REPAIR_PLAN_TYPE;

                $add->REPAIR_PLAN_DETAIL = $request->REPAIR_PLAN_DETAIL;
                $add->REPAIR_PLAN_REASON = $request->REPAIR_PLAN_REASON;
                $add->REPAIR_PLAN_FROM = $request->REPAIR_PLAN_FROM;
                $add->REPAIR_AMOUNT = $request->REPAIR_AMOUNT;
                $add->REPAIR_PICE_UNIT = $request->REPAIR_PICE_UNIT;
                $add->REPAIR_PICE_REAL = $request->REPAIR_PICE_REAL;
                $add->REPAIR_TYPE = $request->REPAIR_TYPE;
                $add->REPAIR_BEGIN_DATE = $REPAIRBEGINDATE;
                $add->REPAIR_END_DATE = $REPAIRENDDATE;   
                $add->REPAIR_TEAM_NAME = $request->REPAIR_TEAM_NAME;

                $add->REPAIR_TEAM_HR_ID = $request->REPAIR_TEAM_HR_ID;
                $TEAM_HR_NAME =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                ->where('hrd_person.ID','=',$request->REPAIR_TEAM_HR_ID)->first();
                $add->REPAIR_TEAM_HR_NAME   = $TEAM_HR_NAME->HR_PREFIX_NAME.''.$TEAM_HR_NAME->HR_FNAME.' '.$TEAM_HR_NAME->HR_LNAME;
    
            
                //----------------------------------

                $add->REPAIR_COMMENT = $request->REPAIR_COMMENT;
                $add->REPAIR_PICE_SUM = $request->REPAIR_AMOUNT*$request->REPAIR_PICE_UNIT;      
                $add->save();

            
                return redirect()->route('guest.geninfoplan_repair',[
                   'iduser' => $request->REPAIR_SAVE_HR_ID
                ]);


 }


 



    //===============================

    


    public function project_destroy(Request $request,$idref,$iduser) {

        Planproject::destroy($idref);
        return redirect()->route('guest.geninfoplan_project',[
            'iduser'=>$iduser
        ]);
      }


      
    public function humandev_destroy(Request $request,$idref,$iduser) {

        Planhumandev::destroy($idref);
        return redirect()->route('guest.geninfoplan_humandev',[
            'iduser'=>$iduser
        ]);
      }



      
    public function durable_destroy(Request $request,$idref,$iduser) {

        Plandurable::destroy($idref);
        return redirect()->route('guest.geninfoplan_durable',[
            'iduser'=>$iduser
        ]);
      }


      
        public function repair_destroy(Request $request,$idref,$iduser)
        {

            Planrepair::destroy($idref);  

            return redirect()->route('guest.geninfoplan_repair',[
                'iduser'=>$iduser
            ]);


        }

    //===============================
  




}
