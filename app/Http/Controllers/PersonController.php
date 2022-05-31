<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Person;
use App\Models\Adduser;
use Carbon\Carbon;



class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function infouser(Request $request,$iduser)
    {
       
        //$email = Auth::user()->email;

        $inforpersonuser =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $inforadd2 =  Person::leftJoin('hrd_tumbon','hrd_person.TUMBON_ID_1','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID_1','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID_1','=','hrd_province.ID')
        ->where('hrd_person.ID','=',$iduser)->first();

        $userid =  Person::where('hrd_person.ID','=',$iduser)->first();

        $name_userdetail = DB::table('users')->where('PERSON_ID','=',$iduser)->first();
        if($name_userdetail <> null){
            $name_user = $name_userdetail->username;
        }else{
            $name_user = '';
        }

        return view('person.personinfouser',[
            'inforpersonuser' => $inforpersonuser, 
            'userid' =>  $userid,
            'name_user' =>  $name_user,
            'inforadd2' =>$inforadd2
        ]);
    }


    public function infousereducat()
    {
        $email = Auth::user()->email;

        $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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
        ->where('HR_EMAIL','=',$email)->first();


        return view('person.personinfousereducat',[
            'inforpersonusereducat' => $inforpersonusereducat 
        ]);
    }




    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$iduser)
    {
        $inforperson =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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

        $inforperson_add1 =  Person::leftJoin('hrd_tumbon','hrd_person.TUMBON_ID_1','=','hrd_tumbon.ID')
        ->leftJoin('hrd_amphur','hrd_person.AMPHUR_ID_1','=','hrd_amphur.ID')
        ->leftJoin('hrd_province','hrd_person.PROVINCE_ID_1','=','hrd_province.ID')
        ->where('hrd_person.ID','=',$iduser)->first();


        $infoprefix =  DB::table('hrd_prefix')->get();
        $infomarry =  DB::table('hrd_marry_status')->get();
        $inforeligion =  DB::table('hrd_religion')->get();
        $infonation =  DB::table('hrd_nationality')->get();
        $infocitizen =  DB::table('hrd_citizenship')->get();
        $infosex =  DB::table('hrd_sex')->get();
        $infoblood =  DB::table('hrd_bloodgroup')->get();

        $infoprovince =  DB::table('hrd_province')->get();

        $infoid =  DB::table('hrd_person')->where('hrd_person.ID','=',$iduser)->first();

        $infodepartment =  DB::table('hrd_department')->get();
        $infodepartment_sub =  DB::table('hrd_department_sub')->get();
        $infodepartment_sub_sub =  DB::table('hrd_department_sub_sub')->get();
        $infolevel =  DB::table('hrd_level')->get();
        $infostatus =  DB::table('hrd_status')->get();
        $infokind =  DB::table('hrd_kind')->get();
        $infokind_type =  DB::table('hrd_kind_type')->get();    
        $infoperson_type =  DB::table('hrd_person_type')->get();
        $infoposition =  DB::table('hrd_position')->get();
        


        return view('person.infoperson',[
            'inforpersons' => $inforperson,
            'infoprefixs' => $infoprefix,
            'infomarrys' => $infomarry,
            'inforeligions' => $inforeligion,
            'infonations' => $infonation,
            'infocitizens' => $infocitizen,
            'infosexs' => $infosex,
            'infobloods' => $infoblood,
            'infoid' => $infoid,
            'infoprovinces' => $infoprovince,
            'inforperson_add1'=> $inforperson_add1,
            'infodepartments' => $infodepartment,
            'infodepartment_subs' => $infodepartment_sub,
            'infodepartment_sub_subs' => $infodepartment_sub_sub,  
            'infolevels' => $infolevel,
            'infostatuss' => $infostatus,
            'infokinds' => $infokind,
            'infokind_types' => $infokind_type,
            'infoperson_types' => $infoperson_type,
            'infopositions' => $infoposition

        ]);
    }
    function fetch(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('hrd_province')
      ->join('hrd_amphur','hrd_province.ID','=','hrd_amphur.PROVINCE_ID')
      ->select('hrd_amphur.AMPHUR_NAME','hrd_amphur.ID')
      ->where('hrd_province.ID',$id)
      ->groupBy('hrd_amphur.AMPHUR_NAME','hrd_amphur.ID')
      ->get();
      $output='<option value="">--กรุณาเลือกอำเภอ--</option>';
      
      foreach ($query as $row){

            $output.= '<option value="'.$row->ID.'">'.$row->AMPHUR_NAME.'</option>';
    }

    echo $output;
        
    }

    function fetchsub(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('hrd_amphur')
      ->join('hrd_tumbon','hrd_amphur.ID','=','hrd_tumbon.AMPHUR_ID')
      ->select('hrd_tumbon.TUMBON_NAME','hrd_tumbon.ID')
      ->where('hrd_amphur.ID',$id)
      ->groupBy('hrd_tumbon.TUMBON_NAME','hrd_tumbon.ID')
      ->get();
      $output='<option value="">--กรุณาเลือกตำบล--</option>';
      
      foreach ($query as $row){

            $output.= '<option value="'.$row->ID.'">'.$row->TUMBON_NAME.'</option>';
    }

    echo $output;
        
    }

    function checkhrid(Request $request)
    {
       
      $cid= $request->get('select');
      $count= DB::table('hrd_person')
            ->where('hrd_person.HR_CID',$cid) 
            ->count();

    
        $numlength = strlen((string)$cid);

            if($count >= 1){
                $output='*มีเลขประจำตัวดังกล่าวในระบบแล้ว
                <input type="hidden" name="checkcid" id="checkcid" value="notpass">';
                echo $output;
            }else if($numlength < 13){
                $output='*กรุณากรอกเลขบัตรให้ครบถ้วน
                <input type="hidden" name="checkcid" id="checkcid" value="notpass2">';
                echo $output;
            }      
                
    }

    function checkemail(Request $request)
    {
       
      $mail= $request->get('select');
      $count= DB::table('hrd_person')
            ->where('hrd_person.HR_EMAIL',$mail) 
            ->count();
            if($count== 1){
                $output='*มีอีเมลล์ดังกล่าวในระบบแล้ว';
                echo $output;
            }  
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $output='*กรุณาระบุอีเมล์ให้ถูกต้อง';
                echo $output;
              }
            
                
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $iduser)
    {
        $checkstart= $request->STARTWORK;
        $checkvcode=$request->VCODE_DATE;
   
          $BIRTHDAY = Carbon::createFromFormat('d/m/Y', $request->HR_BIRTHDAY)->format('Y-m-d');
          $date_arrary=explode("-",$BIRTHDAY);
          $y_sub = $date_arrary[0]; 
            
          if($y_sub >= 2500){
              $y = $y_sub-543;
          }else{
              $y = $y_sub;
          }  
     
          $m = $date_arrary[1];
          $d = $date_arrary[2];  
          $displaybirthdate= $y."-".$m."-".$d;



            if($checkstart != ''){
                $STARTDAY = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
                $date_arrary_st=explode("-",$STARTDAY);  
                $y_sub_st = $date_arrary_st[0]; 
                
                if($y_sub_st >= 2500){
                    $y_st = $y_sub_st-543;
                }else{
                    $y_st = $y_sub_st;
                }
                $m_st = $date_arrary_st[1];
                $d_st = $date_arrary_st[2];  
                $displaystartdate= $y_st."-".$m_st."-".$d_st;
                }else{
                $displaystartdate= null;
            }
            if($checkvcode != ''){
                $VCODEDAY = Carbon::createFromFormat('d/m/Y', $checkvcode)->format('Y-m-d');
                $date_arrary_v=explode("-",$VCODEDAY);  
                $y_sub_v = $date_arrary_v[0]; 
                
                if($y_sub_v >= 2500){
                    $y_v = $y_sub_v-543;
                }else{
                    $y_v = $y_sub_v;
                }
                 $m_v = $date_arrary_v[1];
                 $d_v = $date_arrary_v[2];  
                 $displayvcodedate= $y_v."-".$m_v."-".$d_v;
                    }else{
                 $displayvcodedate= null;
            }
          
          $inforpersonedit = Person::find($iduser);

         //$inforpersonedit->timestamps = false;
         $inforpersonedit->HR_PREFIX_ID = $request->HR_PREFIX;
         $inforpersonedit->HR_FNAME = $request->HR_FNAME;
         $inforpersonedit->HR_LNAME = $request->HR_LNAME; 
         $inforpersonedit->HR_EN_NAME = $request->HR_EN_NAME;
         $inforpersonedit->NICKNAME = $request->NICKNAME;
         $inforpersonedit->HR_BIRTHDAY = $displaybirthdate;  
         $inforpersonedit->HR_CID = $request->HR_CID;
         $inforpersonedit->HR_MARRY_STATUS_ID = $request->HR_MARRY_STATUS;
         $inforpersonedit->HR_RELIGION_ID = $request->HR_RELIGION;   
         $inforpersonedit->HR_NATIONALITY_ID = $request->HR_NATIONALITY;    
         $inforpersonedit->HR_CITIZENSHIP_ID = $request->HR_CITIZENSHIP; 
         $inforpersonedit->SEX = $request->SEX; 
         $inforpersonedit->HR_BLOODGROUP_ID = $request->HR_BLOODGROUP; 
         $inforpersonedit->HR_HIGH = $request->HR_HIGH;
         $inforpersonedit->HR_WEIGHT = $request->HR_WEIGHT;
         $inforpersonedit->HR_PHONE = $request->HR_PHONE;
         $inforpersonedit->HR_EMAIL = $request->HR_EMAIL;
         $inforpersonedit->HR_FACEBOOK = $request->HR_FACEBOOK;
         $inforpersonedit->HR_LINE = $request->HR_LINE;

         $inforpersonedit->HR_DEPARTMENT_ID = $request->HR_DEPARTMENT;
         $inforpersonedit->HR_DEPARTMENT_SUB_ID = $request->DEPARTMENT_SUB;
         $inforpersonedit->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB;
 
         $inforpersonedit->HR_STARTWORK_DATE = $displaystartdate;
 
         $inforpersonedit->HR_POSITION_NUM = $request->HR_POSITION_NUM;
         $inforpersonedit->VCODE = $request->VCODE;
 
         $inforpersonedit->VCODE_DATE =  $displayvcodedate;
         $inforpersonedit->HR_AGENCY_ID =  $request->HR_AGENCY_ID;
         
         if($request->POSITION_IN_WORK == null || $request->POSITION_IN_WORK == ''){
            $inforpersonedit->POSITION_IN_WORK = '';
         }else{

            
         $position =  DB::table('hrd_position')
         ->where('HR_POSITION_ID','=',$request->POSITION_IN_WORK)
         ->first();
         $inforpersonedit->POSITION_IN_WORK = $position->HR_POSITION_NAME;

         }

 
         $inforpersonedit->HR_POSITION_ID = $request->POSITION_IN_WORK;
         $inforpersonedit->HR_LEVEL_ID = $request->HR_LEVEL;
         $inforpersonedit->HR_STATUS_ID = $request->HR_STATUS;
         $inforpersonedit->HR_KIND_ID = $request->HR_KIND;
         $inforpersonedit->HR_KIND_TYPE_ID = $request->HR_KIND_TYPE;
         $inforpersonedit->HR_PERSON_TYPE_ID = $request->HR_PERSON_TYPE;
         $inforpersonedit->HR_SALARY = $request->HR_SALARY;
         $inforpersonedit->MONEY_POSITION = $request->MONEY_POSITION;

         $inforpersonedit->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
         $inforpersonedit->HR_VILLAGE_NO = $request->HR_VILLAGE_NO;
         $inforpersonedit->HR_ROAD_NAME = $request->HR_ROAD_NAME;
         $inforpersonedit->HR_SOI_NAME = $request->HR_SOI_NAME; 
         $inforpersonedit->PROVINCE_ID = $request->PROVINCE_NAME;
         $inforpersonedit->AMPHUR_ID = $request->AMPHUR_NAME;
         $inforpersonedit->TUMBON_ID = $request->TUMBON_NAME;
         $inforpersonedit->HR_ZIPCODE = $request->HR_ZIPCODE;

         $inforpersonedit->HR_HOME_NUMBER_1 = $request->HR_HOME_NUMBER_1;
         $inforpersonedit->HR_VILLAGE_NO_1 = $request->HR_VILLAGE_NO_1;
         $inforpersonedit->HR_ROAD_NAME_1 = $request->HR_ROAD_NAME_1;
         $inforpersonedit->PROVINCE_ID_1 = $request->PROVINCE_NAME_1;
         $inforpersonedit->AMPHUR_ID_1 = $request->AMPHUR_NAME_1;
         $inforpersonedit->TUMBON_ID_1 = $request->TUMBON_NAME_1; 
         $inforpersonedit->HR_ZIPCODE_1 = $request->HR_ZIPCODE_1;

         $inforpersonedit->BOOK_BANK_NUMBER = $request->BOOK_BANK_NUMBER;
         $inforpersonedit->BOOK_BANK_NAME = $request->BOOK_BANK_NAME;
         $inforpersonedit->BOOK_BANK = $request->BOOK_BANK;
         $inforpersonedit->BOOK_BANK_BRANCH = $request->BOOK_BANK_BRANCH;

         $inforpersonedit->BOOK_BANK_OT_NUMBER = $request->BOOK_BANK_OT_NUMBER;
         $inforpersonedit->BOOK_BANK_OT_NAME = $request->BOOK_BANK_OT_NAME;
         $inforpersonedit->BOOK_BANK_OT = $request->BOOK_BANK_OT;
         $inforpersonedit->BOOK_BANK_OT_BRANCH = $request->BOOK_BANK_OT_BRANCH;

         $picid = $request->HR_CID;

         if($request->hasFile('picture')){
            //$newFileName = $picid.'.'.$request->picture->extension();
            
            $file = $request->file('picture');  
            $contents = $file->openFile()->fread($file->getSize());
            $inforpersonedit->HR_IMAGE = $contents;   
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName; 
        }
       
         
        //dd($inforpersonedit);
         $inforpersonedit->save();

         $inforuserdit = Adduser::where('PERSON_ID', '=',$iduser)->first();
         $inforuserdit->name = $request->HR_FNAME.' '.$request->HR_LNAME;
         $inforuserdit->email = $request->HR_EMAIL;
         $inforuserdit->save(); 
    
         //dd($inforpersonedit);

       return redirect()->route('person.info',['iduser'=>  $iduser]);   
     
      //return $displaybirthdate;
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changpassworduser(Request $request,$iduser)
    {
        $inforpersonusereducat =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
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


        return view('person.changpassword_user',[
            'inforpersonusereducat' => $inforpersonusereducat 
        ]);

    }

    
    public function updatechangpassworduser(Request $request)
    {
        $id = $request->ID;
        $iduser = $request->PERSON_ID;
        $changpassword = $request->NEWPASSWORD;
        //dd($id);

        $updatechangpass= Adduser::where('id', '=',$id)->first();
        $updatechangpass->password = Hash::make($changpassword);
        $updatechangpass->save();

       
        return redirect()->route('user.dashboard',['iduser'=>  $iduser]);
        
    }

    function department(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('hrd_department')
      ->join('hrd_department_sub','hrd_department.HR_DEPARTMENT_ID','=','hrd_department_sub.HR_DEPARTMENT_ID')
      ->select('hrd_department_sub.HR_DEPARTMENT_SUB_NAME','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
      ->where('hrd_department.HR_DEPARTMENT_ID',$id)
      ->groupBy('hrd_department_sub.HR_DEPARTMENT_SUB_NAME','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
      ->get();
      $output='<option value="">--กรุณาเลือกฝ่าย/แผนก--</option>';
      
      foreach ($query as $row){

            $output.= '<option value="'.$row->HR_DEPARTMENT_SUB_ID.'">'.$row->HR_DEPARTMENT_SUB_NAME.'</option>';
    }

    echo $output;
        
    }

    function departmenthsub(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('hrd_department_sub')
      ->join('hrd_department_sub_sub','hrd_department_sub.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_ID')
      ->select('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
      ->where('hrd_department_sub.HR_DEPARTMENT_SUB_ID',$id)
      ->groupBy('hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_NAME','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
      ->get();
      $output='<option value="">--กรุณาเลือกหน่วยงาน--</option>';
      
      foreach ($query as $row){

            $output.= '<option value="'.$row->HR_DEPARTMENT_SUB_SUB_ID.'">'.$row->HR_DEPARTMENT_SUB_SUB_NAME.'</option>';
    }

    echo $output;
        
    }

}
