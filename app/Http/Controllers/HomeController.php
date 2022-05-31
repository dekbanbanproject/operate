<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');

        $status = Auth::user()->status; 
        if($status=='ADMIN'){
        return view('dashboard_admin');
        }else if($status=='NOTUSER'){
            return view('notuser'); 
        }else{
        return view('dashboard');
        }
    }


    public function addmindashboard()
    {
        
          $amount_1 = DB::table('hrd_person')->where('HR_STATUS_ID','=',1)->count();
          $amount_2 = DB::table('hrd_person')->where('HR_STATUS_ID','=',2)->count();
          $amount_3 = DB::table('hrd_person')->where('HR_STATUS_ID','=',3)->count();
          $amount_4 = DB::table('hrd_person')->where('HR_STATUS_ID','=',4)->count();

          $leave_amount_1 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',1)->count();
          $leave_amount_2 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',3)->count();
          $leave_amount_3 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',4)->count();
          $leave_amount_4 = DB::table('gleave_register')->where('LEAVE_TYPE_CODE','=',6)->count();

          $perdev_amount_1 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',1)->count();
          $perdev_amount_2 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',2)->count();
          $perdev_amount_3 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',3)->count();
          $perdev_amount_4 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',4)->count();
          $perdev_amount_5 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',5)->count();
          $perdev_amount_6 = DB::table('grecord_index')->where('RECORD_TYPE_ID','=',6)->count();

          $man  = DB::table('hrd_person')
          ->where('SEX','=','M')
          ->where('HR_STATUS_ID','<>',5)
          ->where('HR_STATUS_ID','<>',6)
          ->where('HR_STATUS_ID','<>',7)
          ->where('HR_STATUS_ID','<>',8)
          ->count();

          $women  = DB::table('hrd_person')
          ->where('SEX','=','F')
          ->where('HR_STATUS_ID','<>',5)
          ->where('HR_STATUS_ID','<>',6)
          ->where('HR_STATUS_ID','<>',7)
          ->where('HR_STATUS_ID','<>',8)
          ->count();
         

          $groupwork = DB::table('hrd_person')
                        ->select(DB::raw('count(*) as person_count,HR_DEPARTMENT_NAME'),'HR_DEPARTMENT_NAME')
                        ->leftJoin('hrd_department','hrd_person.HR_DEPARTMENT_ID','=','hrd_department.HR_DEPARTMENT_ID')
                        ->groupBy('HR_DEPARTMENT_NAME')
                        ->get();

          $groupperson = DB::table('hrd_person')
                        ->select(DB::raw('count(*) as person_count,HR_PERSON_TYPE_NAME'),'HR_PERSON_TYPE_NAME')
                        ->leftJoin('hrd_person_type','hrd_person.HR_PERSON_TYPE_ID','=','hrd_person_type.HR_PERSON_TYPE_ID')
                        ->groupBy('HR_PERSON_TYPE_NAME')
                        ->get();


                        date_default_timezone_set("Asia/Bangkok");
                        $date_now = date('Y-m-d'); 

            $meetingroom = DB::table('meetingroom_service')
            ->leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
            ->where('DATE_BEGIN','=',$date_now)
            ->get();  
            
            $meetingcar = DB::table('vehicle_car_reserve')
            ->leftJoin('vehicle_car_index','vehicle_car_index.CAR_ID','=','vehicle_car_reserve.CAR_REQUEST_ID')
            ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','vehicle_car_reserve.RESERVE_LOCATION_ID')
            ->where('RESERVE_BEGIN_DATE','=',$date_now)         
            ->get(); 

            $imgpresent = DB::table('info_publicity_image')->where('ACTIVE','=','True')->get(); 
    
        return view('dashboard_admin',[
            'imgpresents' => $imgpresent,
            'amount_1' => $amount_1,
            'amount_2' => $amount_2,
            'amount_3' => $amount_3,
            'amount_4' => $amount_4,
            'leave_amount_1' => $leave_amount_1,
            'leave_amount_2' => $leave_amount_2,
            'leave_amount_3' => $leave_amount_3,
            'leave_amount_4' => $leave_amount_4,     
            'perdev_amount_1' => $perdev_amount_1,
            'perdev_amount_2' => $perdev_amount_2,
            'perdev_amount_3' => $perdev_amount_3,
            'perdev_amount_4' => $perdev_amount_4,
            'perdev_amount_5' => $perdev_amount_5,
            'perdev_amount_6' => $perdev_amount_6,
            'groupworks' => $groupwork,
            'grouppersons' => $groupperson,
            'meetingrooms' => $meetingroom,
            'meetingcars' => $meetingcar,
            'man' => $man,
            'women' => $women
        ]);
      
    }


    public function userdashboard()
    {

        date_default_timezone_set("Asia/Bangkok");
                        $date_now = date('Y-m-d'); 
        
        $meetingroom = DB::table('meetingroom_service')
        ->leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
        ->where('DATE_BEGIN','=',$date_now)
        ->get();  
        
        $meetingcar = DB::table('vehicle_car_reserve')
        ->leftJoin('vehicle_car_index','vehicle_car_index.CAR_ID','=','vehicle_car_reserve.CAR_REQUEST_ID')
        ->leftJoin('grecord_org_location','grecord_org_location.LOCATION_ID','=','vehicle_car_reserve.RESERVE_LOCATION_ID')
        ->where('RESERVE_BEGIN_DATE','=',$date_now)         
        ->get(); 

        $imgpresent = DB::table('info_publicity_image')->where('ACTIVE','=','True')->get(); 
    
        return view('dashboard',[
            'meetingrooms' => $meetingroom,
            'meetingcars' => $meetingcar,
            'imgpresents' => $imgpresent,
        ]);
       
    }


    public function carcalendar()
    {


        $infocarnimal1 = DB::table('vehicle_car_reserve')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_reserve.STATUS','=','REGROUP')
        ->orwhere('vehicle_car_reserve.STATUS','=','SUCCESS')
        ->get();


        $infocarnimal2 = DB::table('vehicle_car_reserve')
        ->leftJoin('grecord_org_location','vehicle_car_reserve.RESERVE_LOCATION_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_reserve.STATUS','=','RECERVE')
        ->get();

        $infocarrefer = DB::table('vehicle_car_refer')
        ->leftJoin('grecord_org_location','vehicle_car_refer.REFER_LOCATION_GO_ID','=','grecord_org_location.LOCATION_ID')
        ->where('vehicle_car_refer.STATUS','<>','CANCEL')
        ->get();
        
    
        return view('carcalendar_car',[
            'infocarnimal1s' => $infocarnimal1,
            'infocarnimal2s' => $infocarnimal2,
            'infocarrefers' => $infocarrefer   
        ]);
    }



         
  public function meetcalendar()
  {      
              $infoservice =  Meetingroomservice::leftJoin('meetingroom_index','meetingroom_index.ROOM_ID','=','meetingroom_service.ROOM_ID')
              ->leftJoin('meetingroom_service_status','meetingroom_service_status.STATUS_CODE','=','meetingroom_service.STATUS')
              ->where('meetingroom_service.STATUS','<>','CANCEL')
              ->orderBy('meetingroom_service.ID', 'desc')  
              ->get();
        return view('meetcalendar',[           
            'infoservices' => $infoservice
            
        ]);
  }




}
