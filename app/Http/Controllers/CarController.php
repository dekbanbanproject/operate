<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Permislist;
use App\Models\Meetingroomindex;
use App\Models\Meetingroomservice;
use App\Models\Meetingroomfoodlist;
use App\Models\Meetingroomarticlelist;
use App\Models\Vehiclecarrefer;
use App\Models\Vehiclecarreserve;
use App\Models\Vehiclecarindex;
use App\Models\Vehiclecarindexperson;
use App\Models\Vehiclecarindexetc;
use App\Models\Vehiclecarindexwork;
use App\Models\Vehiclecarrefernurse;
use App\Models\Vehiclecarfanciness;
use App\Models\Vehiclecarreferwork;
use App\Models\Vehiclecarreferequipment;
use App\Models\Recordorglocation;
use PDF;




date_default_timezone_set("Asia/Bangkok");

class CarController extends Controller
{
    public function infoindex(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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

        $infocarnimal1 = DB::table('vehicle_car_reserve')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_reserve.STATUS','=','REGROUP')
        ->orwhere('vehicle_car_reserve.STATUS','=','SUCCESS')
        ->orwhere('vehicle_car_reserve.STATUS','=','LASTAPP')
        ->orwhere('vehicle_car_reserve.STATUS','=','RECERVE')
        ->get();



        $infocarrefer = DB::table('vehicle_car_refer')
        ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_refer.STATUS','<>','CANCEL')
        ->get();
        


        return view('general_car.geninfocarindex',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infocarnimal1s' => $infocarnimal1,
            'infocarrefers' => $infocarrefer
         
            
        ]);
    }


    public function infotype(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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


        return view('general_car.geninfocartype',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
         
            
        ]);
    }

    public function infonomal(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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


        $infocar = Vehiclecarreserve::leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
        ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('vehicle_car_appoint_locate','vehicle_car_appoint_locate.APPOINT_LOCATE_ID','=','vehicle_car_reserve.APPOINT_LOCATE_ID')    
        ->where('RESERVE_BEGIN_DATE','=',date('Y-m-d'))
        ->orderBy('RESERVE_ID', 'desc') 
        ->get();


        $infocar_sendstatus = DB::table('vehicle_car_request_status')->get();

       

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;


       
      

        return view('general_car.geninfocarnomal',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'infonomals' => $infocar,
            'infocar_sendstatuss' => $infocar_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,

        ]);
    }


    public function infocarnomalsearch(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

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



        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);




            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

            if($status == null){

                $infocar = Vehiclecarreserve::leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('vehicle_car_appoint_locate','vehicle_car_appoint_locate.APPOINT_LOCATE_ID','=','vehicle_car_reserve.APPOINT_LOCATE_ID')    
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                    $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                    $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');

                })
                ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
                ->orderBy('RESERVE_ID', 'desc') 
                ->get();


            }else{

                $infocar = Vehiclecarreserve::leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
                ->leftJoin('vehicle_car_fanciness','vehicle_car_reserve.RESERVE_ID','=','vehicle_car_fanciness.FANCINESS_RESERRVE_ID')
                ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_reserve.CAR_DRIVER_SET_ID')
                ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->leftJoin('vehicle_car_appoint_locate','vehicle_car_appoint_locate.APPOINT_LOCATE_ID','=','vehicle_car_reserve.APPOINT_LOCATE_ID')    
                ->where('STATUS','=',$status)
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('LOCATION_ORG_NAME','like','%'.$search.'%');  
                    $q->orwhere('RESERVE_NAME','like','%'.$search.'%');
                    $q->orwhere('RESERVE_PERSON_NAME','like','%'.$search.'%');

                })
                ->WhereBetween('RESERVE_BEGIN_DATE',[$from,$to]) 
                ->orderBy('RESERVE_ID', 'desc') 
                ->get();


            }
    

    

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $infocar_sendstatus = DB::table('vehicle_car_request_status')->get();


        return view('general_car.geninfocarnomal',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'infonomals' => $infocar,
            'infocar_sendstatuss' => $infocar_sendstatus, 
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
        ]);
    }




    public function carfansave(Request $request)
    {
           
        Vehiclecarfanciness::where('FANCINESS_RESERRVE_ID','=',$request->FANCINESS_RESERRVE_ID)->delete();   

        

            $addfancarnomal = new Vehiclecarfanciness(); 
            $addfancarnomal->FANCINESS_RESERRVE_ID = $request->FANCINESS_RESERRVE_ID;
            $addfancarnomal->FANCINESS_SCORE = $request->FANCINESS_SCORE;
            $addfancarnomal->FANCINESS_REMARK = $request->FANCINESS_REMARK;
            $addfancarnomal->FANCINESS_PERSON_ID = $request->FANCINESS_PERSON_ID;
            $addfancarnomal->FANCINESS_DATE = date('Y-m-d H:i:s');
            $addfancarnomal->save();


            return redirect()->route('car.infonomal',[
                'iduser' => $request->FANCINESS_PERSON_ID]); 

    }



    public function createcarnomal(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        $id = $inforpersonuserid->ID;

         $m_budget = date("m");
        if($m_budget>9){
          $yearbudget = date("Y")+544;
        }else{
          $yearbudget = date("Y")+543;
        }

    
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
  

        $priority =  DB::table('vehicle_car_priority')->get();

        $location =  DB::table('grecord_org_location')->get();


        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $car =  DB::table('vehicle_car_index')->where('CAR_TYPE_ID','<>',2)->where('ACTIVE','=','true')->get();

        $book =  DB::table('gbook_index')
        ->select('BOOK_NAME','BOOK_NUMBER','BOOK_DATE','BOOK_ID')
        ->where('BOOK_YEAR_ID','=',$yearbudget)
        ->orderBy('gbook_index.BOOK_ID', 'desc') 
        ->get();

        $PERSONALL =  DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

        $LEADER =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->leftJoin('hrd_person','gleave_leader_person.LEADER_ID','=','hrd_person.ID')
        ->where('gleave_leader_person.PERSON_ID','=',$iduser)
        ->get();

        return view('general_car.geninfocarnomal_add',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
            'drivers' => $driver, 
            'cars' => $car, 
            'books' => $book, 
            'PERSONALLs' => $PERSONALL,
            'LEADERS' => $LEADER,
            'prioritys' =>  $priority  
      
         
            
        ]);
    }



    

    public function carnomalsave(Request $request)
    {
       // return $request->all();
        
       $BOOK_REFER_DATE_1 = $request->RESERVE_BEGIN_DATE;
       $BOOK_REFER_DATE_2 = $request->RESERVE_END_DATE;

       $BOOK_REFER_DATE_3 = $request->BOOK_DATE_REG;

       if($BOOK_REFER_DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_1= null;
    }

    if($BOOK_REFER_DATE_2 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_2= null;
    }
      

    if($BOOK_REFER_DATE_3 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_3)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_3= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_3= null;
    }

            $addcarnomal = new Vehiclecarreserve(); 

            $addcarnomal->RESERVE_PERSON_ID = $request->RESERVE_PERSON_ID;
            //----------------------------------
            $RESERVE_PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->RESERVE_PERSON_ID)->first();
            
            $addcarnomal->RESERVE_PERSON_NAME   = $RESERVE_PERSON->HR_PREFIX_NAME.''.$RESERVE_PERSON->HR_FNAME.' '.$RESERVE_PERSON->HR_LNAME;
            $addcarnomal->RESERVE_PERSON_POSITION = $RESERVE_PERSON->HR_POSITION_NAME;
            //----------------------------------

            $addcarnomal->RESERVE_NAME = $request->RESERVE_NAME;
            $addcarnomal->RESERVE_LOCATION_ID = $request->RESERVE_LOCATION_ID;

               $addcarnomal->CAR_DRIVER_ID = $request->CAR_DRIVER_ID;
               //----------------------------------
               $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->CAR_DRIVER_ID)->first();
               $addcarnomal->CAR_DRIVER_NAME    = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;

               //----------------------------------


            $addcarnomal->RESERVE_BEGIN_DATE = $BOOK_REFER_DATE_1;
            $addcarnomal->RESERVE_BEGIN_TIME = $request->RESERVE_BEGIN_TIME;
            $addcarnomal->RESERVE_END_DATE = $BOOK_REFER_DATE_2;
            $addcarnomal->RESERVE_END_TIME = $request->RESERVE_END_TIME;

            $addcarnomal->LEADER_PERSON_ID = $request->LEADER_PERSON_ID;
               //----------------------------------
               $LEADER_PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->LEADER_PERSON_ID)->first();
               $addcarnomal->LEADER_PERSON_NAME  = $LEADER_PERSON->HR_PREFIX_NAME.''.$LEADER_PERSON->HR_FNAME.' '.$LEADER_PERSON->HR_LNAME;
               $addcarnomal->LEADER_PERSON_POSITION = $LEADER_PERSON->HR_POSITION_NAME;
               //----------------------------------

          
            $addcarnomal->STATUS = 'RECERVE';
            $addcarnomal->PRIORITY_ID = $request->PRIORITY_ID;
            

            $addcarnomal->RESERVE_COMMENT = $request->RESERVE_COMMENT;

            $addcarnomal->CAR_REQUEST_ID = $request->CAR_REQUEST_ID;


            $addcarnomal->CAR_OWNER = $request->CAR_OWNER;

            $addcarnomal->BOOK_ID = $request->BOOK_ID;
            $addcarnomal->BOOK_NAME = $request->BOOK_NAME;
            $addcarnomal->BOOK_NUM = $request->BOOK_NUM;
            $addcarnomal->BOOK_DATE_REG = $BOOK_REFER_DATE_3;

          
            $addcarnomal->save();


              

            $RESERVE_ID = Vehiclecarreserve::max('RESERVE_ID');

             //----------------------------------


            if($request->PERSON_ID != '' || $request->PERSON_ID != null){
                $PERSON_ID = $request->PERSON_ID;
                $number_3 =count($PERSON_ID);
                $count_3 = 0;
                for($count_3 = 0; $count_3 < $number_3; $count_3++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_3 = new Vehiclecarindexperson();
                   $add_3->RESERVE_ID = $RESERVE_ID;


                   $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                   ->where('hrd_person.ID','=',$PERSON_ID[$count_3])->first();

                   $add_3->HR_PERSON_ID =  $PERSON->ID;
                   $add_3->HR_FULLNAME =  $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;
                   $add_3->HR_POSITION =  $PERSON->POSITION_IN_WORK;
                   $add_3->HR_DEPARTMENT_ID = $PERSON->HR_DEPARTMENT_ID;
                   $add_3->HR_LEVEL = $PERSON->HR_LEVEL_ID;

                   $add_3->save(); 
                 
         
         
                }
            }


            if($request->PERSON_OTHER != '' || $request->PERSON_OTHER != null){
                $PERSON_OTHER = $request->PERSON_OTHER;
                $number_4 =count($PERSON_OTHER);
                $count_4 = 0;
                for($count_4 = 0; $count_4 < $number_4; $count_4++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_4 = new Vehiclecarindexetc();
                   $add_4->RESERVE_ID = $RESERVE_ID;
                   $add_4->FULLNAME = $PERSON_OTHER[$count_4];

                   $add_4->save(); 
                 
         
                }
            }

            if($request->CARWORK_LOCATION_ID != '' || $request->CARWORK_LOCATION_ID != null){

                $CARWORK_LOCATION_ID = $request->CARWORK_LOCATION_ID;
                $CARWORK_DETAIL = $request->CARWORK_DETAIL;

                $number_5 =count($CARWORK_LOCATION_ID);
                $count_5 = 0;
                for($count_5 = 0; $count_5 < $number_5; $count_5++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_5 = new Vehiclecarindexwork();
                   $add_5->CARWORK_RESERVE_ID = $RESERVE_ID;
                   $add_5->CARWORK_LOCATION_ID = $CARWORK_LOCATION_ID[$count_5];
                   $add_5->CARWORK_DETAIL = $CARWORK_DETAIL[$count_5];

                   $add_5->save(); 
                 
         
                }
            }



            $carlocation = DB::table('grecord_org_location')->where('LOCATION_ID','=',$request->RESERVE_LOCATION_ID)->first();
            
            if( $request->CAR_OWNER=='' ||  $request->CAR_OWNER==null){
                $carreg = DB::table('vehicle_car_index')->where('CAR_ID','=',$request->CAR_REQUEST_ID)->first();
                $carid = $carreg->CAR_REG; 
            }else{
              
                $carid = $request->CAR_OWNER; 
            } 

            $RESERVE_PERSON_NAME = $RESERVE_PERSON->HR_PREFIX_NAME.''.$RESERVE_PERSON->HR_FNAME.' '.$RESERVE_PERSON->HR_LNAME;
             
           

            $header = "แจ้งขอใช้รถยนต์";
           
            $reservename = $request->RESERVE_NAME; 

            
             function DateThailinecar($strDate)
            {
              $strYear = date("Y",strtotime($strDate))+543;
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));
      
              $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
              $strMonthThai=$strMonthCut[$strMonth];
              return "$strDay $strMonthThai $strYear";
              }

             $datebegin = DateThailinecar($BOOK_REFER_DATE_1).' '.date("H:i",strtotime("$request->RESERVE_BEGIN_TIME")); 
             $backtime = DateThailinecar($BOOK_REFER_DATE_2).' '.date("H:i",strtotime("$request->RESERVE_END_TIME"));           
            
             $referlocation = $carlocation->LOCATION_ORG_NAME;          
             
             $vehicle_car_index_works = DB::table('vehicle_car_index_work')->where('CARWORK_RESERVE_ID','=',$RESERVE_ID)->get();
        
            $message = $header.
                "\n"."ทะเบียนรถ : " . $carid .
                "\n"."เหตุผลการขอรถ : " . $reservename .
                "\n"."ผู้ร้องขอ : " . $RESERVE_PERSON_NAME .
                "\n"."โทร : " . $RESERVE_PERSON->HR_PHONE.
                "\n"."วันที่ไป : " . $datebegin .               
                "\n"."วันกลับ : " . $backtime .               
                "\n"."สถานที่ไป : " . $referlocation. 
                "\n"."งานฝาก : "; 
                foreach ($vehicle_car_index_works as $vehicle_car_index_work){
                    $message.="\n".$vehicle_car_index_work->CARWORK_DETAIL;
                }
                $message.="\n";

                    $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',2)->first();        
                    $test =$name->LINE_TOKEN;
        
                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $chOne );
                    if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                    else { $result_ = json_decode($result, true);
                    echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                    curl_close( $chOne );

            

                         //แจ้งเตือนกลุ่มหน่วยงาน
                $name_re = DB::table('hrd_person')->where('ID','=',$request->RESERVE_PERSON_ID)->first();  
                $name_request = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$name_re->HR_DEPARTMENT_SUB_SUB_ID)->first();        
                $tokendepsubsub =$name_request->LINE_TOKEN;

                $chOne3 = curl_init();
              curl_setopt( $chOne3, CURLOPT_URL, "https://notify-api.line.me/api/notify");
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt( $chOne3, CURLOPT_SSL_VERIFYPEER, 0);
              curl_setopt( $chOne3, CURLOPT_POST, 1);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, $message);
              curl_setopt( $chOne3, CURLOPT_POSTFIELDS, "message=$message");
              curl_setopt( $chOne3, CURLOPT_FOLLOWLOCATION, 1);
              $headers3 = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$tokendepsubsub.'', );
              curl_setopt($chOne3, CURLOPT_HTTPHEADER, $headers3);
              curl_setopt( $chOne3, CURLOPT_RETURNTRANSFER, 1);
              $result3 = curl_exec( $chOne3 );
              if(curl_error($chOne3)) { echo 'error:' . curl_error($chOne3); }
              else { $result_ = json_decode($result3, true);
              echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
              curl_close( $chOne3 );



             // dd($addinfocar);

            return redirect()->route('car.infonomal',[
                'iduser' => $request->RESERVE_PERSON_ID]); 
            
    }


    //==========================แก้ไข

    public function editcarnomal(Request $request,$id,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
       

         $m_budget = date("m");
        if($m_budget>9){
          $yearbudget = date("Y")+544;
        }else{
          $yearbudget = date("Y")+543;
        }

    
        
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
  

        $priority =  DB::table('vehicle_car_priority')->get();

        $location =  DB::table('grecord_org_location')->get();


        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $car =  DB::table('vehicle_car_index')->where('CAR_TYPE_ID','<>',2)->where('ACTIVE','=','true')->get();

        $book =  DB::table('gbook_index')
        ->select('BOOK_NAME','BOOK_NUMBER','BOOK_DATE','BOOK_ID')
        ->where('BOOK_YEAR_ID','=',$yearbudget)
        ->orderBy('gbook_index.BOOK_ID', 'desc') 
        ->get();

        $PERSONALL =  DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->get();

        $LEADER =  DB::table('gleave_leader_person')
        ->leftJoin('gleave_leader','gleave_leader.LEADER_ID','=','gleave_leader_person.LEADER_ID')
        ->leftJoin('hrd_person','gleave_leader_person.LEADER_ID','=','hrd_person.ID')
        ->where('PERSON_ID','=',$iduser)
        ->get();


        $infocarreserve =  DB::table('vehicle_car_reserve')
        ->leftJoin('vehicle_car_index','vehicle_car_index.CAR_ID','=','vehicle_car_reserve.CAR_REQUEST_ID')
        ->where('RESERVE_ID','=',$id)->first();



        $infoconcludeperson = Vehiclecarindexperson::where('RESERVE_ID','=',$id)->get();

        $infocarindexetc = Vehiclecarindexetc::where('RESERVE_ID','=',$id)->get();
        $infocarindexwork = Vehiclecarindexwork::where('CARWORK_RESERVE_ID','=',$id)->get();


        return view('general_car.geninfocarnomal_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
            'drivers' => $driver, 
            'cars' => $car, 
            'books' => $book, 
            'PERSONALLs' => $PERSONALL,
            'LEADERS' => $LEADER,
            'prioritys' =>  $priority, 
            'infocarreserve' =>  $infocarreserve,  
            'infoconcludepersons' =>  $infoconcludeperson,
            'infocarindexetcs' =>  $infocarindexetc, 
            'infocarindexworks' =>  $infocarindexwork,   
      
         
            
        ]);
    }


    public function carnomalupdate(Request $request)
    {
       // return $request->all();
        
       $BOOK_REFER_DATE_1 = $request->RESERVE_BEGIN_DATE;
       $BOOK_REFER_DATE_2 = $request->RESERVE_END_DATE;

       $BOOK_REFER_DATE_3 = $request->BOOK_DATE_REG;

       if($BOOK_REFER_DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_1= null;
    }

    if($BOOK_REFER_DATE_2 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_2= null;
    }
      

    if($BOOK_REFER_DATE_3 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_3)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_3= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_3= null;
    }

            $RESERVE_ID = $request->RESERVE_ID;

            $addcarnomal = Vehiclecarreserve::find($RESERVE_ID);

            $addcarnomal->RESERVE_PERSON_ID = $request->RESERVE_PERSON_ID;
            //----------------------------------
            $RESERVE_PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->RESERVE_PERSON_ID)->first();
            
            $addcarnomal->RESERVE_PERSON_NAME   = $RESERVE_PERSON->HR_PREFIX_NAME.''.$RESERVE_PERSON->HR_FNAME.' '.$RESERVE_PERSON->HR_LNAME;
            $addcarnomal->RESERVE_PERSON_POSITION = $RESERVE_PERSON->HR_POSITION_NAME;
            //----------------------------------

            $addcarnomal->RESERVE_NAME = $request->RESERVE_NAME;
            $addcarnomal->RESERVE_LOCATION_ID = $request->RESERVE_LOCATION_ID;

               $addcarnomal->CAR_DRIVER_ID = $request->CAR_DRIVER_ID;
               //----------------------------------
               $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->CAR_DRIVER_ID)->first();
               $addcarnomal->CAR_DRIVER_NAME    = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;

               //----------------------------------


            $addcarnomal->RESERVE_BEGIN_DATE = $BOOK_REFER_DATE_1;
            $addcarnomal->RESERVE_BEGIN_TIME = $request->RESERVE_BEGIN_TIME;
            $addcarnomal->RESERVE_END_DATE = $BOOK_REFER_DATE_2;
            $addcarnomal->RESERVE_END_TIME = $request->RESERVE_END_TIME;

            $addcarnomal->LEADER_PERSON_ID = $request->LEADER_PERSON_ID;
               //----------------------------------
               $LEADER_PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
               ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
               ->where('hrd_person.ID','=',$request->LEADER_PERSON_ID)->first();
               $addcarnomal->LEADER_PERSON_NAME  = $LEADER_PERSON->HR_PREFIX_NAME.''.$LEADER_PERSON->HR_FNAME.' '.$LEADER_PERSON->HR_LNAME;
               $addcarnomal->LEADER_PERSON_POSITION = $LEADER_PERSON->HR_POSITION_NAME;
               //----------------------------------

          
            $addcarnomal->PRIORITY_ID = $request->PRIORITY_ID;
            

            $addcarnomal->RESERVE_COMMENT = $request->RESERVE_COMMENT;

            $addcarnomal->CAR_REQUEST_ID = $request->CAR_REQUEST_ID;


            $addcarnomal->CAR_OWNER = $request->CAR_OWNER;

            $addcarnomal->BOOK_ID = $request->BOOK_ID;
            $addcarnomal->BOOK_NAME = $request->BOOK_NAME;
            $addcarnomal->BOOK_NUM = $request->BOOK_NUM;
            $addcarnomal->BOOK_DATE_REG = $BOOK_REFER_DATE_3;

          
            $addcarnomal->save();


              

         

             //----------------------------------

             Vehiclecarindexperson::where('RESERVE_ID','=',$RESERVE_ID)->delete();  

            if($request->PERSON_ID != '' || $request->PERSON_ID != null){
                $PERSON_ID = $request->PERSON_ID;
                $number_3 =count($PERSON_ID);
                $count_3 = 0;
                for($count_3 = 0; $count_3 < $number_3; $count_3++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_3 = new Vehiclecarindexperson();
                   $add_3->RESERVE_ID = $RESERVE_ID;


                   $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                   ->where('hrd_person.ID','=',$PERSON_ID[$count_3])->first();

                   $add_3->HR_PERSON_ID =  $PERSON->ID;
                   $add_3->HR_FULLNAME =  $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;
                   $add_3->HR_POSITION =  $PERSON->POSITION_IN_WORK;
                   $add_3->HR_DEPARTMENT_ID = $PERSON->HR_DEPARTMENT_ID;
                   $add_3->HR_LEVEL = $PERSON->HR_LEVEL_ID;

                   $add_3->save(); 
                 
         
         
                }
            }

            Vehiclecarindexetc::where('RESERVE_ID','=',$RESERVE_ID)->delete();  

            if($request->PERSON_OTHER != '' || $request->PERSON_OTHER != null){
                $PERSON_OTHER = $request->PERSON_OTHER;
                $number_4 =count($PERSON_OTHER);
                $count_4 = 0;
                for($count_4 = 0; $count_4 < $number_4; $count_4++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_4 = new Vehiclecarindexetc();
                   $add_4->RESERVE_ID = $RESERVE_ID;
                   $add_4->FULLNAME = $PERSON_OTHER[$count_4];
                   $add_4->save(); 
                 

                //dd($PERSON_OTHER[$count_4]);
         
                }
            }



            Vehiclecarindexwork::where('CARWORK_RESERVE_ID','=',$RESERVE_ID)->delete();  

            if($request->CARWORK_LOCATION_ID != '' || $request->CARWORK_LOCATION_ID != null){

                $CARWORK_LOCATION_ID = $request->CARWORK_LOCATION_ID;
                $CARWORK_DETAIL = $request->CARWORK_DETAIL;

                $number_5 =count($CARWORK_LOCATION_ID);
                $count_5 = 0;
                for($count_5 = 0; $count_5 < $number_5; $count_5++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_5 = new Vehiclecarindexwork();
                   $add_5->CARWORK_RESERVE_ID = $RESERVE_ID;
                   $add_5->CARWORK_LOCATION_ID = $CARWORK_LOCATION_ID[$count_5];
                   $add_5->CARWORK_DETAIL = $CARWORK_DETAIL[$count_5];

                   $add_5->save(); 
                 
         
                }
            }



            

             // dd($addinfocar);

            return redirect()->route('car.infonomal',[
                'iduser' => $request->RESERVE_PERSON_ID]); 

    }


    //==========================แจ้งยกเลิก=======================================
    public function cancelnomal(Request $request,$id,$iduser)
    {

        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
       
        
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

            $infocarnimal = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
            ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
            ->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
            ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->where('RESERVE_ID','=',$id)
            ->first();

            if($infocarnimal->CAR_DRIVER_SET_ID != '' || $infocarnimal->CAR_DRIVER_SET_ID != null){
                $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('hrd_person.ID','=',$infocarnimal->CAR_DRIVER_SET_ID)->first();
            }else{
                $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                ->where('hrd_person.ID','=',$infocarnimal->CAR_DRIVER_ID)->first();
            }


            return view('general_car.geninfocarnomalcancel',[
                'inforpersonuser' => $inforpersonuser,
                'inforpersonuserid' => $inforpersonuserid,
                'infocarnimal' => $infocarnimal,
                'CAR_DRIVER' => $CAR_DRIVER,
                
            ]);
        }


        

        public function updatecancelnomal(Request $request)
        {
    
                $RESERVE_ID = $request->RESERVE_ID;
                $addcarnomal = Vehiclecarreserve::find($RESERVE_ID);
                $addcarnomal->STATUS = 'CANCEL';
                $addcarnomal->save();
    
                return redirect()->route('car.infonomal',[
                    'iduser' => $request->RESERVE_PERSON_ID]); 
    
        }

    //===========================================================================


    
    public function inforefer(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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
  
        $inforefer = DB::table('vehicle_car_refer')
        ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
        ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')    
        ->where('OUT_DATE','=',date('Y-m-d'))
        ->orderBy('vehicle_car_refer.ID', 'desc')  
        ->get();


        $inforefer_sendstatus = DB::table('vehicle_car_refer_type')->get();

    

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';
        $status = '';
        $search = '';
        $year_id = $yearbudget;
       

        return view('general_car.geninfocarrefer',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'inforefers' => $inforefer,
            'inforefer_sendstatuss' => $inforefer_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id, 
            
        ]);
    }


    
    public function infocarrefersearch(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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
        $status = $request->SEND_STATUS;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

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



        $date = date('Y-m-d');
        $date_bigen_checks = strtotime($displaydate_bigen);
        $date_end_checks =  strtotime($displaydate_end);
        $dates =  strtotime($date);


        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

      

            if($status == null){
      

                $inforefer = DB::table('vehicle_car_refer')
                ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID') 
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('DRIVER_NAME','like','%'.$search.'%');  
                    $q->orwhere('USER_REQUEST_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('OUT_DATE',[$from,$to]) 
                ->orderBy('vehicle_car_refer.ID', 'desc')  
                ->get();


            }else{


                $inforefer = DB::table('vehicle_car_refer')
                ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
                ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID') 
                ->where('REFER_TYPE_ID','=',$status)
                ->where(function($q) use ($search){
                    $q->where('CAR_REG','like','%'.$search.'%');
                    $q->orwhere('DRIVER_NAME','like','%'.$search.'%');  
                    $q->orwhere('USER_REQUEST_NAME','like','%'.$search.'%');
                })
                ->WhereBetween('OUT_DATE',[$from,$to]) 
                ->orderBy('vehicle_car_refer.ID', 'desc')  
                ->get();

            }
    



        $inforefer_sendstatus = DB::table('vehicle_car_refer_type')->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        return view('general_car.geninfocarrefer',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'inforefers' => $inforefer,
            'inforefer_sendstatuss' => $inforefer_sendstatus,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'status_check'=> $status,
            'search'=> $search,
            'year_id'=>$year_id,
         
            
        ]);
    }



    public function createcarrefer(Request $request,$iduser)
    {
        //$email = Auth::user()->email;
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
       
        $refertype  =  DB::table('vehicle_car_refer_type')->get(); 

        $location =  DB::table('grecord_org_location')->get();

        $equipment =  DB::table('vehicle_car_equipment')->get();

        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $car =  DB::table('vehicle_car_index')->where('CAR_STYLE_ID','=',1)->where('ACTIVE','=','true')->get();

        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();

        $nationality =  DB::table('hrd_nationality')->get();

        $citizenship =  DB::table('hrd_citizenship')->get();
  

        return view('general_car.geninfocarrefer_add',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
            'drivers' => $driver, 
            'cars' => $car, 
            'PERSONALLs' => $PERSONALL,  
            'nationalitys' => $nationality, 
            'citizenships' => $citizenship,
            'refertypes' => $refertype, 
            'equipments' => $equipment     
           
         
            
        ]);
    }

   

    public function carrefersave(Request $request)
    {
        function DateThailine($strDate)
        {
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
  
          $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
          }
       // return $request->all();
        
       $BOOK_REFER_DATE_1 = $request->OUT_DATE;
       $BOOK_REFER_DATE_2 = $request->BACK_DATE;

       if($BOOK_REFER_DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_1= null;
    }

    if($BOOK_REFER_DATE_2 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_2= null;
    }
      

            $addcarrefer = new Vehiclecarrefer(); 

            $addcarrefer->CAR_ID = $request->CAR_ID;
            $addcarrefer->OUT_DATE = $BOOK_REFER_DATE_1;
            $addcarrefer->OUT_TIME = $request->OUT_TIME;
            $addcarrefer->BACK_DATE = $BOOK_REFER_DATE_2;
            $addcarrefer->BACK_TIME = $request->BACK_TIME;

            $addcarrefer->REFER_LOCATION_GO_ID = $request->REFER_LOCATION_GO_ID;

            
            $addcarrefer->DRIVER_ID = $request->DRIVER_ID;
            //----------------------------------
            $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->DRIVER_ID)->first();
            $addcarrefer->DRIVER_NAME    = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;

            //----------------------------------
           
            $addcarrefer->CAR_GO_MILE = $request->CAR_GO_MILE;
            $addcarrefer->ADD_OIL_BATH = $request->ADD_OIL_BATH;
            $addcarrefer->ADD_OIL_LIT = $request->ADD_OIL_LIT;
            $addcarrefer->CAR_BACK_MILE = $request->CAR_BACK_MILE;
            $addcarrefer->OIL_PRICE = $request->OIL_PRICE;
            $addcarrefer->ORG_ID = $request->ORG_ID;
            $addcarrefer->COMMENT = $request->COMMENT;

            $addcarrefer->HOS_FULLNAME = $request->HOS_FULLNAME;
            $addcarrefer->HOS_AGE = $request->HOS_AGE;
            $addcarrefer->HOS_HN = $request->HOS_HN;
            $addcarrefer->HOS_CID = $request->HOS_CID;
            
            $addcarrefer->NATIONNALITY_ID = $request->NATIONNALITY_ID;
            $addcarrefer->CITIZENSHIP_ID = $request->CITIZENSHIP_ID;


            
            $addcarrefer->USER_REQUEST_ID = $request->USER_REQUEST_ID;
            //----------------------------------
            $USER_REQUEST =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
            $addcarrefer->USER_REQUEST_NAME    = $USER_REQUEST->HR_PREFIX_NAME.''.$USER_REQUEST->HR_FNAME.' '.$USER_REQUEST->HR_LNAME;

            
            $addcarrefer->REFER_TYPE_ID = $request->REFER_TYPE_ID;

            $addcarrefer->HOS_HOSPNAME = $request->HOS_HOSPNAME;
            $addcarrefer->STATUS = 'FORWARD';


            $addcarrefer->save();

             // dd($addinfocar);

             $REFER_ID = Vehiclecarrefer::max('ID');

             //----------------------------------

          

            if($request->PERSON_ID[0] != '' || $request->PERSON_ID[0] != null){
                $PERSON_ID = $request->PERSON_ID;
                $number_3 =count($PERSON_ID);
                $count_3 = 0;
                for($count_3 = 0; $count_3 < $number_3; $count_3++)
                {  
                  //echo $row3[$count_3]."<br>";
                   $add_3 = new Vehiclecarrefernurse();
                   $add_3->REFER_ID = $REFER_ID;

                   $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                   ->where('hrd_person.ID','=',$PERSON_ID[$count_3])->first();

                   $add_3->NURSE_HR_ID =  $PERSON->ID;
                   $add_3->NURSE_HR_NAME =  $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;
                   $add_3->NURSE_HR_POSITION =  $PERSON->POSITION_IN_WORK;
              
                   $add_3->save(); 
                 
         
         
                }
            }

        
            if($request->CARWORK_REFER_LOCATION_ID[0] != '' || $request->CARWORK_REFER_LOCATION_ID[0] != null){

                $CARWORK_REFER_LOCATION_ID = $request->CARWORK_REFER_LOCATION_ID;
                $CARWORK_REFER_DETAIL = $request->CARWORK_REFER_DETAIL;

                $number_4 =count($CARWORK_REFER_LOCATION_ID);
                $count_4 = 0;
                for($count_4 = 0; $count_4 < $number_4; $count_4++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_4 = new Vehiclecarreferwork();
                   $add_4->REFER_ID = $REFER_ID;
                   $add_4->CARWORK_REFER_LOCATION_ID = $CARWORK_REFER_LOCATION_ID[$count_4];
                   $add_4->CARWORK_REFER_DETAIL = $CARWORK_REFER_DETAIL[$count_4];

                   $add_4->save(); 
                 
         
                }
            }

            
           
            if($request->EQUIPMENT_ID[0] != '' || $request->EQUIPMENT_ID[0] != null){

                $EQUIPMENT_ID = $request->EQUIPMENT_ID;
                $EQUIPMENT_AMOUNT = $request->EQUIPMENT_AMOUNT;

                $number_5 =count($EQUIPMENT_ID);
                $count_5= 0;
                for($count_5 = 0; $count_5 < $number_5; $count_5++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_5 = new Vehiclecarreferequipment();
                   $add_5->REFER_ID = $REFER_ID;
                   $add_5->EQUIPMENT_ID = $EQUIPMENT_ID[$count_5];
                   $add_5->EQUIPMENT_AMOUNT = $EQUIPMENT_AMOUNT[$count_5];

                   $add_5->save(); 
                 
         
                }
            }

            // $addcarrefer->CAR_ID = $request->CAR_ID;
            // $addcarrefer->OUT_DATE = $BOOK_REFER_DATE_1;
            // $addcarrefer->OUT_TIME = $request->OUT_TIME;
            // $addcarrefer->BACK_DATE = $BOOK_REFER_DATE_2;
            // $addcarrefer->BACK_TIME = $request->BACK_TIME;
            // $addcarrefer->REFER_LOCATION_GO_ID = $request->REFER_LOCATION_GO_ID;
                        
            // $addcarrefer->DRIVER_ID = $request->DRIVER_ID;          
            // $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            // ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            // ->where('hrd_person.ID','=',$request->DRIVER_ID)->first();
            // $addcarrefer->DRIVER_NAME    = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;

             $carlocation = DB::table('grecord_org_location')->where('LOCATION_ID','=',$request->REFER_LOCATION_GO_ID)->first();
             $carreg = DB::table('vehicle_car_index')->where('CAR_ID','=',$request->CAR_ID)->first();


            $header = "ระบบจองรถพยาบาล";
            $carid = $carreg->CAR_REG;            
             $datebegin = DateThailine($BOOK_REFER_DATE_1).' '.date("H:i",strtotime("$request->OUT_TIME")); 
             $backtime = DateThailine($BOOK_REFER_DATE_2).' '.date("H:i",strtotime("$request->BACK_TIME"));           
            $referlocation = $carlocation->LOCATION_ORG_NAME;          
            
            $inforefer_type = DB::table('vehicle_car_refer_type')->where('REFER_TYPE_ID','=',$request->REFER_TYPE_ID)->first();
            $inforefer_nurse = DB::table('vehicle_car_refer_nurse')->where('REFER_ID','=',$REFER_ID)->first();
           
            $message = $header.
                "\n"."ทะเบียนรถ : " . $carid .
                "\n"."ประเภท : " . $inforefer_type->REFER_TYPE_NAME . 
                "\n"."พนักงานขับรถ : " .$CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME  . 
                "\n"."โทร : " .$CAR_DRIVER->HR_PHONE . 
                "\n"."วันที่ไป : " . $datebegin .               
                "\n"."วันกลับ : " . $backtime .               
                "\n"."สถานที่ไป : " . $referlocation .
                "\n"."จนท.ไป : " .$inforefer_nurse->NURSE_HR_NAME   . 
                "\n"."หมายเหตุ : " . $request->COMMENT . 
                "\n"."อุปกรณ์อื่นๆ : "; 
                

           

                    $name = DB::table('line_token')->where('ID_LINE_TOKEN','=',3)->first();        
                    $test =$name->LINE_TOKEN;
        
                    $chOne = curl_init();
                    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt( $chOne, CURLOPT_POST, 1);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                    curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec( $chOne );
                    if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                    else { $result_ = json_decode($result, true);
                    echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                    curl_close( $chOne );


            return redirect()->route('car.inforefer',[
                'iduser' => $request->USER_REQUEST_ID]); 

    }


//=========================แก้ไขรายละเอียด===============

public function editcarrefer(Request $request,$id,$iduser)
    {
        //$email = Auth::user()->email;
        $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        

        
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
       
        $refertype  =  DB::table('vehicle_car_refer_type')->get(); 

        $location =  DB::table('grecord_org_location')->get();

        $equipment =  DB::table('vehicle_car_equipment')->get();

        $driver =  DB::table('vehicle_car_driver')
        ->leftJoin('hrd_person','vehicle_car_driver.PERSON_ID','=','hrd_person.ID')
        ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('vehicle_car_driver.ACTIVE','=','true')->get();

        $car =  DB::table('vehicle_car_index')->where('CAR_STYLE_ID','=',1)->where('ACTIVE','=','true')->get();

        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();

        $nationality =  DB::table('hrd_nationality')->get();

        $citizenship =  DB::table('hrd_citizenship')->get();


        $inforefer =  DB::table('vehicle_car_refer')
        ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
        ->where('ID','=',$id)->first();

        
        $infoconcludeperson = Vehiclecarrefernurse::where('REFER_ID','=',$id)->get();
        $inforeferwork = Vehiclecarreferwork::where('REFER_ID','=',$id)->get();
        $inforeferequipment = Vehiclecarreferequipment::where('REFER_ID','=',$id)->get();
  
 

        return view('general_car.geninfocarrefer_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid,
            'locations' => $location,
            'drivers' => $driver, 
            'cars' => $car, 
            'PERSONALLs' => $PERSONALL,  
            'nationalitys' => $nationality, 
            'citizenships' => $citizenship,
            'refertypes' => $refertype, 
            'equipments' => $equipment,  
            'inforefer' => $inforefer,  
            'infoconcludepersons' => $infoconcludeperson, 
            'inforeferworks' => $inforeferwork, 
            'inforeferequipments' => $inforeferequipment,   
           
         
            
        ]);
    }


    
    public function carreferupdate(Request $request)
    {
       // return $request->all();
        
       $BOOK_REFER_DATE_1 = $request->OUT_DATE;
       $BOOK_REFER_DATE_2 = $request->BACK_DATE;

       if($BOOK_REFER_DATE_1 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_1)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_1= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_1= null;
    }

    if($BOOK_REFER_DATE_2 != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $BOOK_REFER_DATE_2)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $BOOK_REFER_DATE_2= $y_st."-".$m_st."-".$d_st;
        }else{
        $BOOK_REFER_DATE_2= null;
    }
      

            $ID = $request->ID;

         

            $addcarrefer = Vehiclecarrefer::find($ID);
            $addcarrefer->CAR_ID = $request->CAR_ID;
            $addcarrefer->OUT_DATE = $BOOK_REFER_DATE_1;
            $addcarrefer->OUT_TIME = $request->OUT_TIME;
            $addcarrefer->BACK_DATE = $BOOK_REFER_DATE_2;
            $addcarrefer->BACK_TIME = $request->BACK_TIME;

            $addcarrefer->REFER_LOCATION_GO_ID = $request->REFER_LOCATION_GO_ID;

            
            $addcarrefer->DRIVER_ID = $request->DRIVER_ID;
            //----------------------------------
            $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->DRIVER_ID)->first();
            $addcarrefer->DRIVER_NAME    = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;

            //----------------------------------
           
            $addcarrefer->CAR_GO_MILE = $request->CAR_GO_MILE;
            $addcarrefer->ADD_OIL_BATH = $request->ADD_OIL_BATH;
            $addcarrefer->ADD_OIL_LIT = $request->ADD_OIL_LIT;
            $addcarrefer->CAR_BACK_MILE = $request->CAR_BACK_MILE;
            $addcarrefer->OIL_PRICE = $request->OIL_PRICE;
            $addcarrefer->ORG_ID = $request->ORG_ID;
            $addcarrefer->COMMENT = $request->COMMENT;

            $addcarrefer->HOS_FULLNAME = $request->HOS_FULLNAME;
            $addcarrefer->HOS_AGE = $request->HOS_AGE;
            $addcarrefer->HOS_HN = $request->HOS_HN;
            $addcarrefer->HOS_CID = $request->HOS_CID;
            
            $addcarrefer->NATIONNALITY_ID = $request->NATIONNALITY_ID;
            $addcarrefer->CITIZENSHIP_ID = $request->CITIZENSHIP_ID;


            
            $addcarrefer->USER_REQUEST_ID = $request->USER_REQUEST_ID;
            //----------------------------------
            $USER_REQUEST =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->USER_REQUEST_ID)->first();
            $addcarrefer->USER_REQUEST_NAME    = $USER_REQUEST->HR_PREFIX_NAME.''.$USER_REQUEST->HR_FNAME.' '.$USER_REQUEST->HR_LNAME;

            
            $addcarrefer->REFER_TYPE_ID = $request->REFER_TYPE_ID;

            $addcarrefer->HOS_HOSPNAME = $request->HOS_HOSPNAME;
      


            $addcarrefer->save();

          
             $REFER_ID =$ID ;

             //----------------------------------

             Vehiclecarrefernurse::where('REFER_ID','=',$REFER_ID)->delete(); 
          

            if($request->PERSON_ID[0] != '' || $request->PERSON_ID[0] != null){

                //dd(123541);

                $PERSON_ID = $request->PERSON_ID;
                $number_3 =count($PERSON_ID);

                $count_3 = 0;
                for($count_3 = 0; $count_3 < $number_3; $count_3++)
                {  
                  //echo $row3[$count_3]."<br>";
                   $add_3 = new Vehiclecarrefernurse();
                   $add_3->REFER_ID = $REFER_ID;

                   $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
                   ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
                   ->where('hrd_person.ID','=',$PERSON_ID[$count_3])->first();

                   $add_3->NURSE_HR_ID =  $PERSON->ID;
                   $add_3->NURSE_HR_NAME =  $PERSON->HR_PREFIX_NAME.''.$PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;
                   $add_3->NURSE_HR_POSITION =  $PERSON->POSITION_IN_WORK;
              
                   $add_3->save(); 
                 
         
         
                }
            }

            Vehiclecarreferwork::where('REFER_ID','=',$REFER_ID)->delete(); 
            if($request->CARWORK_REFER_LOCATION_ID[0] != '' || $request->CARWORK_REFER_LOCATION_ID[0] != null){

                $CARWORK_REFER_LOCATION_ID = $request->CARWORK_REFER_LOCATION_ID;
                $CARWORK_REFER_DETAIL = $request->CARWORK_REFER_DETAIL;

                $number_4 =count($CARWORK_REFER_LOCATION_ID);
                $count_4 = 0;
                for($count_4 = 0; $count_4 < $number_4; $count_4++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_4 = new Vehiclecarreferwork();
                   $add_4->REFER_ID = $REFER_ID;
                   $add_4->CARWORK_REFER_LOCATION_ID = $CARWORK_REFER_LOCATION_ID[$count_4];
                   $add_4->CARWORK_REFER_DETAIL = $CARWORK_REFER_DETAIL[$count_4];

                   $add_4->save(); 
                 
         
                }
            }

            Vehiclecarreferequipment::where('REFER_ID','=',$REFER_ID)->delete(); 
            if($request->EQUIPMENT_ID[0] != '' || $request->EQUIPMENT_ID[0] != null){

                $EQUIPMENT_ID = $request->EQUIPMENT_ID;
                $EQUIPMENT_AMOUNT = $request->EQUIPMENT_AMOUNT;

                $number_5 =count($EQUIPMENT_ID);
                $count_5= 0;
                for($count_5 = 0; $count_5 < $number_5; $count_5++)
                {  
                  //echo $row3[$count_3]."<br>";
                 
                   $add_5 = new Vehiclecarreferequipment();
                   $add_5->REFER_ID = $REFER_ID;
                   $add_5->EQUIPMENT_ID = $EQUIPMENT_ID[$count_5];
                   $add_5->EQUIPMENT_AMOUNT = $EQUIPMENT_AMOUNT[$count_5];

                   $add_5->save(); 
                 
         
                }
            }



            return redirect()->route('car.inforefer',[
                'iduser' => $request->USER_REQUEST_ID]); 

    }


  

     //==========================แจ้งยกเลิก=======================================
     public function cancelrefer(Request $request,$id,$iduser)
     {
 
         $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
        
         
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
 
         $infocarrefer = DB::table('vehicle_car_refer')->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
         ->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
         ->leftJoin('hrd_person','vehicle_car_refer.USER_REQUEST_ID','=','hrd_person.ID')
         ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('vehicle_car_refer.ID','=',$request->id)
         ->first();
         
         $CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
         ->where('hrd_person.ID','=',$infocarrefer->DRIVER_ID)->first();
 
        
 
 
             return view('general_car.geninfocarrefercancel',[
                 'inforpersonuser' => $inforpersonuser,
                 'inforpersonuserid' => $inforpersonuserid,
                 'infocarrefer' => $infocarrefer,
                 'CAR_DRIVER' => $CAR_DRIVER,
                 'REFER_ID' => $request->id,

                 
             ]);
         }
 
 
         
 
         public function updatecancelrefer(Request $request)
         {
     
                 $REFER_ID = $request->REFER_ID;

                 $addcarrefer = Vehiclecarrefer::find($REFER_ID);
                 $addcarrefer->STATUS = 'CANCEL';
                 $addcarrefer->save();
     
                 return redirect()->route('car.inforefer',[
                     'iduser' => $request->PERSON_ID]); 
     
         }
 
     //===========================================================================

//=======================================================================

public function selectcarno(Request $request)
{
 
    $detail = Vehiclecarindex::where('CAR_ID','=',$request->car_id)->first();
 

    $output='
    <input type="hidden" name="CAR_REQUEST_ID" id="CAR_REQUEST_ID" value="'.$detail->CAR_ID.'">
    <div class="col-sm-2">
    <label>รถโรงพยาบาลทะเบียน :</label>
    </div> 
    <div class="col-lg-2">
    <input name="" id="" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->CAR_REG.'"  readonly>
    </div> 
    <div class="col-sm-2">
    <label>รายละเอียด :</label>
    </div> 
    <div class="col-lg-4">
    <input name="" id="" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->CAR_DETAIL.'" readonly>
    </div> 
    
    <div class="col-lg-2">
    <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">เลือกรถที่ต้องการใช้</button>
    </div> 
    ';

     
    echo $output;

}

public function selectcarrefer(Request $request)
{
 
    $detail = Vehiclecarindex::where('CAR_ID','=',$request->car_id)->first();
 

    $output='
    <input type="hidden" name="CAR_ID" id="CAR_ID" value="'.$detail->CAR_ID.'">
    <div class="col-sm-2">
    <label>ทะเบียน :</label>
    </div> 
    <div class="col-lg-2">
    <input name="" id="" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->CAR_REG.'"  readonly>
    </div> 
    <div class="col-sm-2">
    <label>รายละเอียด :</label>
    </div> 
    <div class="col-lg-4">
    <input name="" id="" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->CAR_DETAIL.'" readonly>
    </div> 
    
    <div class="col-lg-2">
    <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add" style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">เลือกรถที่ต้องการใช้</button>
    </div> 
    ';

     
    echo $output;

}


public function selectbookname(Request $request)
{
 
    $detail = DB::table('gbook_index')->where('BOOK_ID','=',$request->book_id)->first();
 

    $output='
    <input type="hidden" name="BOOK_ID" id="BOOK_ID" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$request->book_id.'" >
    <input name="BOOK_NAME" id="BOOK_NAME" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;" value="'.$detail->BOOK_NAME.'" readonly>';

     
    echo $output;

}



public function selectbooknum(Request $request)
{
 
    $detail = DB::table('gbook_index')->where('BOOK_ID','=',$request->book_id)->first();

    $output='<input name="BOOK_NUM" id="BOOK_NUM" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;"  value="'.$detail->BOOK_NUMBER.'" readonly>';

     
    echo $output;

}

public function selectbookdate(Request $request)
{
    function formate($strDate)
    {
      $strYear = date("Y",strtotime($strDate))+543;
      $strMonth= date("m",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));
    
      return $strDay."/".$strMonth."/".$strYear;
      }
 
    $detail = DB::table('gbook_index')->where('BOOK_ID','=',$request->book_id)->first();

    if($detail->BOOK_DATE== '' || $detail->BOOK_DATE==null ){
        $detaildate = '';
    }else{
        $detaildate = formate($detail->BOOK_DATE);
    }


    $output='<input name="BOOK_DATE_REG" id="BOOK_DATE_REG" class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  style=" font-family: \'Kanit\', sans-serif;" value="'.$detaildate.'" readonly>';

     
    echo $output;

}


public function detailcar(Request $request)
{


    function formatetime($strtime)
    {
        $H = substr($strtime,0,5);
        return $H;
        }

if($request->type=='nomal'){
$infocarnimal = Vehiclecarreserve::leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
->leftJoin('hrd_person','vehicle_car_reserve.RESERVE_PERSON_ID','=','hrd_person.ID')
->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
->where('RESERVE_ID','=',$request->id)
->first();


if($infocarnimal->CAR_DRIVER_SET_ID != '' || $infocarnimal->CAR_DRIVER_SET_ID != null){
$CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
->where('hrd_person.ID','=',$infocarnimal->CAR_DRIVER_SET_ID)->first();

$CAR_DRIVER_NAME = $CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME;
$CAR_DRIVER_PHONE = $CAR_DRIVER->HR_PHONE;
$CAR_DRIVER_IMAGE = $CAR_DRIVER->HR_IMAGE;

}else{
    $CAR_DRIVER_NAME = '';
    $CAR_DRIVER_PHONE = '';
    $CAR_DRIVER_IMAGE = '';
}

$output='    



<div class="row push" style="font-family: \'Kanit\', sans-serif;">

<div class="col-sm-9">

  <div class="row">
      <div class="col-lg-2" align="right">
      <label>ขอใช้รถ :</label>
      </div> 
      <div class="col-lg-8" align="left">
      '.$infocarnimal->RESERVE_NAME.'
      </div> 
  </div>    
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>สถานที่ไป :</label>
      </div> 
      <div class="col-lg-8" align="left">
      '.$infocarnimal->LOCATION_ORG_NAME.'
      </div> 
  </div>    
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>ผู้ขอ :</label>
      </div> 
      <div class="col-lg-6" align="left">
      '.$infocarnimal->HR_PREFIX_NAME.''.$infocarnimal->HR_FNAME.' '.$infocarnimal->HR_LNAME.'
      </div> 
      <div class="col-lg-1" align="right">
      <label>โทร :</label>
      </div> 
      <div class="col-lg-3" align="left">
        '.$infocarnimal->HR_PHONE.'
      </div> 
  </div>    
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>วันที่ :</label>
      </div> 
      <div class="col-lg-6" align="left">
      '.DateThai($infocarnimal->RESERVE_BEGIN_DATE).'
      </div> 
      <div class="col-lg-1" align="right">
      <label>เวลา :</label>
      </div> 
      <div class="col-lg-3" align="left">
      '.formatetime($infocarnimal->RESERVE_BEGIN_TIME).'
      </div> 
  </div>    

</div>

<div class="col-sm-3">

<div class="form-group">

<img src="data:image/png;base64,'. chunk_split(base64_encode($infocarnimal->HR_IMAGE)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="100px" width="100px"/>
</div>

</div>
</div>
<BR>

<div class="row" style="font-family: \'Kanit\', sans-serif;">

<div class="col-sm-9">

<div class="row push">
      <div class="col-lg-2" align="right">
      <label>ยานพาหนะ :</label>
      </div> 
      <div class="col-lg-2" align="left">
      '.$infocarnimal->CAR_REG.'
      </div> 
      <div class="col-lg-2" align="right">
      <label>รายละเอียด :</label>
      </div> 
      <div class="col-lg-6" align="left">
      '.$infocarnimal->CAR_DETAIL.'
      </div> 
  </div> 
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>พนักงานขับรถ :</label>
      </div> 
      <div class="col-lg-6" align="left">
   
      '.$CAR_DRIVER_NAME.'
      </div> 
      <div class="col-lg-1" align="right">
      <label>โทร :</label>
      </div> 
      <div class="col-lg-3" align="left">
      '.$CAR_DRIVER_PHONE.'
      </div> 
  </div>    

  <div class="row">
      <div class="col-lg-2" align="right">
      <label>สถานที่นัด :</label>
      </div> 
      <div class="col-lg-6" align="left">
      '.$infocarnimal->APPOINT_LOCATE_NAME.'
      </div> 
      <div class="col-lg-1" align="right">
      <label>เวลา :</label>
      </div> 
      <div class="col-lg-3" align="left">
      '.formatetime($infocarnimal->APPOINT_TIME).'
      </div> 
  </div> 
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>งานฝาก :</label>
      </div> 
      <div class="col-lg-10" align="left">
      
      </div> 
    
  </div>  
  <div class="row">
      <div class="col-lg-2" align="right">
      <label>หมายเหตุ :</label>
      </div> 
      <div class="col-lg-10" align="left">
      '.$infocarnimal->COMMENT.'
      </div> 
    
  </div>    



</div>

<div class="col-sm-3">

<img src="data:image/png;base64,'. chunk_split(base64_encode($CAR_DRIVER_IMAGE)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="100px" width="100px"/>
</div>
</div>

';
}else{


$infocarrefer = DB::table('vehicle_car_refer')->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
->leftJoin('vehicle_car_index','vehicle_car_refer.CAR_ID','=','vehicle_car_index.CAR_ID')
->leftJoin('hrd_person','vehicle_car_refer.USER_REQUEST_ID','=','hrd_person.ID')
->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
->where('vehicle_car_refer.ID','=',$request->id)
->first();

$CAR_DRIVER =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
->where('hrd_person.ID','=',$infocarrefer->DRIVER_ID)->first();


$output='    



<div class="row push" style="font-family: \'Kanit\', sans-serif;">

<div class="col-sm-9">


<div class="row">
  <div class="col-lg-2" align="right">
  <label>สถานที่ไป :</label>
  </div> 
  <div class="col-lg-8" align="left">
  '.$infocarrefer->LOCATION_ORG_NAME.'
  </div> 
</div>    
<div class="row">
  <div class="col-lg-2" align="right">
  <label>ผู้ขอ :</label>
  </div> 
  <div class="col-lg-6" align="left">
  '.$infocarrefer->HR_PREFIX_NAME.''.$infocarrefer->HR_FNAME.' '.$infocarrefer->HR_LNAME.'
  </div> 
  <div class="col-lg-1" align="right">
  <label>โทร :</label>
  </div> 
  <div class="col-lg-3" align="left">
  '.$infocarrefer->HR_PHONE.'
  </div> 
</div>    
<div class="row">
<div class="col-lg-2" align="right">
<label>วันที่ :</label>
</div> 
<div class="col-lg-6" align="left">
'.DateThai($infocarrefer->OUT_DATE).'
</div> 
<div class="col-lg-1" align="right">
<label>เวลา :</label>
</div> 
<div class="col-lg-3" align="left">
'.formatetime($infocarrefer->OUT_TIME).'
</div> 
</div>    

</div>

<div class="col-sm-3">

<div class="form-group">

<img src="data:image/png;base64,'. chunk_split(base64_encode($infocarrefer->HR_IMAGE)) .'" id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="100px" width="100px"/>
</div>

</div>
</div>
<BR>

<div class="row" style="font-family: \'Kanit\', sans-serif;">

<div class="col-sm-9">

<div class="row">
<div class="col-lg-2" align="right">
<label>ยานพาหนะ :</label>
</div> 
<div class="col-lg-2" align="left">
'.$infocarrefer->CAR_REG.'
</div> 
<div class="col-lg-2" align="right">
<label>รายละเอียด :</label>
</div> 
<div class="col-lg-6" align="left">
'.$infocarrefer->CAR_DETAIL.'
</div> 
</div> 
<div class="row">
<div class="col-lg-2" align="right">
<label>พนักงานขับรถ :</label>
</div> 
<div class="col-lg-6" align="left">
'.$CAR_DRIVER->HR_PREFIX_NAME.''.$CAR_DRIVER->HR_FNAME.' '.$CAR_DRIVER->HR_LNAME.'
</div> 
<div class="col-lg-1" align="right">
<label>โทร :</label>
</div> 
<div class="col-lg-3" align="left">
'.$CAR_DRIVER->HR_PHONE.'
</div> 
</div>    


<div class="row">
  <div class="col-lg-2" align="right">
  <label>งานฝาก :</label>
  </div> 
  <div class="col-lg-10" align="left">
  
  </div> 

</div>  
<div class="row">
  <div class="col-lg-2" align="right">
  <label>หมายเหตุ :</label>
  </div> 
  <div class="col-lg-10" align="left">
  '.$infocarrefer->COMMENT.'
  </div> 

</div>    



</div>

<div class="col-sm-3">

<div class="form-group">

<img src="data:image/png;base64,'. chunk_split(base64_encode($CAR_DRIVER->HR_IMAGE)) .'"  height="100px" width="100px"/>
</div>


</div>
</div>


';

}

echo $output;



}

function addorglocation(Request $request)
{
 
 if($request->record_org!= null || $request->record_org != ''){

     $count_check = Recordorglocation::where('LOCATION_ORG_NAME','=',$request->record_org)->count();
       
        if($count_check == 0){

    $addrecord = new Recordorglocation(); 
    $addrecord->LOCATION_ORG_NAME = $request->record_org;
    $addrecord->save(); 
        }
 }
    $query =  DB::table('grecord_org_location')->get();
 
    $output='<option value="">--กรุณาเลือกสถานที่--</option>';
    
    foreach ($query as $row){
          if($request->record_org == $row->LOCATION_ORG_NAME){
            $output.= '<option value="'.$row->LOCATION_ID.'" selected>'.$row->LOCATION_ORG_NAME.'</option>';
          }else{
            $output.= '<option value="'.$row->LOCATION_ID.'">'.$row->LOCATION_ORG_NAME.'</option>';
          }

          
  }

    echo $output;
    
}

    //=======================================================

    
function pdf3(Request $request,$id)
{
    $orgname =  DB::table('info_org')
    ->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    
    $inforcar = DB::table('vehicle_car_reserve')
    ->leftJoin('vehicle_car_index','vehicle_car_reserve.CAR_SET_ID','=','vehicle_car_index.CAR_ID')
    ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
    ->where('RESERVE_ID','=',$id)->first();
    
    
    $iduser = $inforcar->RESERVE_PERSON_ID;
    $inforperson=  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$iduser)->first();

    $idcon = $inforcar->LEADER_PERSON_ID;
    $infocon =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('hrd_person.ID','=',$idcon)->first();

 

    

    $indexperson = DB::table('vehicle_car_index_person')
    ->leftJoin('hrd_person','hrd_person.ID','=','vehicle_car_index_person.HR_PERSON_ID')
    ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    ->where('RESERVE_ID','=',$id)->get();


    $indexpersoncount = DB::table('vehicle_car_index_person')->where('RESERVE_ID','=',$id)->count();
//     $html =  view('general_car.pdf3',[
//         'orgname' => $orgname,
//         'inforcar' => $inforcar,
//         'inforperson' => $inforperson,
//         'infocon' => $infocon,
//         'indexpersons' => $indexperson,
//     ]);
//     return viewPdf($html);
// }
$checksig = DB::table('gleave_function')->where('FUNCTION_ID','=',1)->where('ACTIVE','=','True')->count();
$orgname =  DB::table('info_org')
->leftJoin('hrd_person','info_org.ORG_LEADER_ID','=','hrd_person.ID')
->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
->first();

$debsub =  DB::table('hrd_department_sub')
->leftJoin('hrd_person','hrd_department_sub.LEADER_HR_ID','=','hrd_person.ID')
->first();


$siginper = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->RESERVE_PERSON_ID)->first();

$siginsub = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$inforcar->LEADER_PERSON_ID)->first();

$sigin = DB::table('hrd_tr_signature')->where('PERSON_ID','=',$orgname->ORG_LEADER_ID)->first();


if($siginper !== null){
    $sigper =  $siginper->FILE_NAME;
}else{ $sigper = '';}

if($siginsub !== null){
    $sigsub =  $siginsub->FILE_NAME;
}else{ $sigsub = '';}

if($sigin !== null){
    $sig =  $sigin->FILE_NAME;
}else{ $sig = '';}

$func = DB::table('vehicle_car_function')->where('CAR_FUNCTION_STATUS','=','True')->first();

if ($func == null || $func == '') {
    $f = 'ใบขออนุญาตใช้รถยนต์';
} else {
    $f = $func->CAR_FUNCTION_NAME;
}

// dd($f);

$pdf = PDF::loadView('general_car.pdf3',[
    'orgname' => $orgname,
    'inforcar' => $inforcar,
    'inforperson' => $inforperson,
    'infocon' => $infocon,
    'indexpersons' => $indexperson,
    'indexpersoncount' => $indexpersoncount,
    'sig' => $sig,
    'sigper' => $sigper,
    'sigsub' => $sigsub,
    'checksig' => $checksig,
    'func' => $func,
    'f' => $f,
    ]);
    return @$pdf->stream();
}

}
