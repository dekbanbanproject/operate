<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Infoworkcorcomsetup;

use App\Models\Infoworkfunctionsetup;
use App\Models\Healthscreen;
use PDF;


class AbilityController extends Controller
{
    public function infoability(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);
      

       $infocapa = DB::table('infowork_capacity')->where('CAPACITY_PERSON_ID','=',$iduser)->get();

        return view('person_work.personinfoworkability',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infocapas' => $infocapa,
            
        ]);
    }

    public function detail(Request $request,$iduser,$idref)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);3


       $infocapacity = DB::table('infowork_capacity')->where('CAPACITY_ID','=',$idref)->first();
       $infouser = DB::table('hrd_person')->where('ID','=',$iduser)->first();
     
      
        return view('person_work.personinfoworkabilitydetail',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'infocapacity'=>$infocapacity,  
            'infouser'=>$infouser, 
            
        ]);
    }




    public function screen(Request $request,$idref,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$idref)->first();
      
        $infolab =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->get();
        $sumamount =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $inforbody = DB::table('health_body')->where('HEALTH_SCREEN_ID','=',$idref)->first();

        $check = DB::table('health_body')->where('HEALTH_SCREEN_ID','=',$idref)->count();

        return view('person_work.personinfoworkscreen',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'idref' =>  $idref,
            'inforef' =>  $inforef,
            'infolabs' =>  $infolab,
            'sumamount' =>  $sumamount,
            'inforbody' =>  $inforbody,
            'check' =>  $check,
           
            
        ]);
    }


    public function screen_sub_save(Request $request)
    {


    

        $id = $request->idref;

        $addinfo =  Healthscreen::find($id); 
        $addinfo->HEALTH_SCREEN_HEIGHT = $request->HEALTH_SCREEN_HEIGHT;
        $addinfo->HEALTH_SCREEN_WEIGHT = $request->HEALTH_SCREEN_WEIGHT;
        $addinfo->HEALTH_SCREEN_BODY =  $request->HEALTH_SCREEN_BODY;
        
        $addinfo->HEALTH_SCREEN_FM_DIA =  $request->HEALTH_SCREEN_FM_DIA;
        $addinfo->HEALTH_SCREEN_FM_BLOOD =  $request->HEALTH_SCREEN_FM_BLOOD;
        $addinfo->HEALTH_SCREEN_FM_GOUT =  $request->HEALTH_SCREEN_FM_GOUT;
        $addinfo->HEALTH_SCREEN_FM_KIDNEY =  $request->HEALTH_SCREEN_FM_KIDNEY;
        $addinfo->HEALTH_SCREEN_FM_HEART =  $request->HEALTH_SCREEN_FM_HEART;
        $addinfo->HEALTH_SCREEN_FM_BRAIN =  $request->HEALTH_SCREEN_FM_BRAIN;
        $addinfo->HEALTH_SCREEN_FM_EMPHY =  $request->HEALTH_SCREEN_FM_EMPHY;
        $addinfo->HEALTH_SCREEN_FM_UNKNOW =  $request->HEALTH_SCREEN_FM_UNKNOW;
        $addinfo->HEALTH_SCREEN_FM_OTHER =  $request->HEALTH_SCREEN_FM_OTHER;

        $addinfo->HEALTH_SCREEN_BS_DIA =  $request->HEALTH_SCREEN_BS_DIA;
        $addinfo->HEALTH_SCREEN_BS_BLOOD =  $request->HEALTH_SCREEN_BS_BLOOD;
        $addinfo->HEALTH_SCREEN_BS_GOUT =  $request->HEALTH_SCREEN_BS_GOUT;
        $addinfo->HEALTH_SCREEN_BS_KIDNEY =  $request->HEALTH_SCREEN_BS_KIDNEY;
        $addinfo->HEALTH_SCREEN_BS_HEART =  $request->HEALTH_SCREEN_BS_HEART;
        $addinfo->HEALTH_SCREEN_BS_BRAIN =  $request->HEALTH_SCREEN_BS_BRAIN;
        $addinfo->HEALTH_SCREEN_BS_EMPHY =  $request->HEALTH_SCREEN_BS_EMPHY;
        $addinfo->HEALTH_SCREEN_BS_UNKNOW =  $request->HEALTH_SCREEN_BS_UNKNOW;
        $addinfo->HEALTH_SCREEN_BS_OTHER =  $request->HEALTH_SCREEN_BS_OTHER;

        $addinfo->HEALTH_SCREEN_H_1 =  $request->HEALTH_SCREEN_H_1;
        $addinfo->HEALTH_SCREEN_H_2 =  $request->HEALTH_SCREEN_H_2;
        $addinfo->HEALTH_SCREEN_H_3 =  $request->HEALTH_SCREEN_H_3;
        $addinfo->HEALTH_SCREEN_H_4=  $request->HEALTH_SCREEN_H_4;
        $addinfo->HEALTH_SCREEN_H_5 =  $request->HEALTH_SCREEN_H_5;
        $addinfo->HEALTH_SCREEN_H_6 =  $request->HEALTH_SCREEN_H_6;
        $addinfo->HEALTH_SCREEN_H_7 =  $request->HEALTH_SCREEN_H_7;
        $addinfo->HEALTH_SCREEN_H_8 =  $request->HEALTH_SCREEN_H_8;
        $addinfo->HEALTH_SCREEN_H_9 =  $request->HEALTH_SCREEN_H_9;
        $addinfo->HEALTH_SCREEN_H_10 =  $request->HEALTH_SCREEN_H_10;
        $addinfo->HEALTH_SCREEN_H_11 =  $request->HEALTH_SCREEN_H_11;
        $addinfo->HEALTH_SCREEN_H_12 =  $request->HEALTH_SCREEN_H_12;
        $addinfo->HEALTH_SCREEN_H_13 =  $request->HEALTH_SCREEN_H_13;
        $addinfo->HEALTH_SCREEN_H_14 =  $request->HEALTH_SCREEN_H_14;
        $addinfo->HEALTH_SCREEN_H_15 =  $request->HEALTH_SCREEN_H_15;
        $addinfo->HEALTH_SCREEN_H_16 =  $request->HEALTH_SCREEN_H_16;
        $addinfo->HEALTH_SCREEN_H_17 =  $request->HEALTH_SCREEN_H_17;
        $addinfo->HEALTH_SCREEN_H_18 =  $request->HEALTH_SCREEN_H_18;
        $addinfo->HEALTH_SCREEN_H_19 =  $request->HEALTH_SCREEN_H_19;
        $addinfo->HEALTH_SCREEN_H_20 =  $request->HEALTH_SCREEN_H_20;
        $addinfo->HEALTH_SCREEN_H_21 =  $request->HEALTH_SCREEN_H_21;
        $addinfo->HEALTH_SCREEN_H_22 =  $request->HEALTH_SCREEN_H_22;
        $addinfo->HEALTH_SCREEN_H_23 =  $request->HEALTH_SCREEN_H_23;
        $addinfo->HEALTH_SCREEN_H_24 =  $request->HEALTH_SCREEN_H_24;
        $addinfo->HEALTH_SCREEN_H_25 =  $request->HEALTH_SCREEN_H_25;
        $addinfo->HEALTH_SCREEN_H_26 =  $request->HEALTH_SCREEN_H_26;
        $addinfo->HEALTH_SCREEN_H_27 =  $request->HEALTH_SCREEN_H_27;
        $addinfo->HEALTH_SCREEN_H_28 =  $request->HEALTH_SCREEN_H_28;
        $addinfo->HEALTH_SCREEN_H_HAVE =  $request->HEALTH_SCREEN_H_HAVE;


        $addinfo->HEALTH_SCREEN_SMOK =  $request->HEALTH_SCREEN_SMOK;
        $addinfo->HEALTH_SCREEN_SMOK_AMOUNT =  $request->HEALTH_SCREEN_SMOK_AMOUNT;
        $addinfo->HEALTH_SCREEN_SMOK_TYPE =  $request->HEALTH_SCREEN_SMOK_TYPE;
        $addinfo->HEALTH_SCREEN_SMOK_TIME =  $request->HEALTH_SCREEN_SMOK_TIME;


        $addinfo->HEALTH_SCREEN_DRINK =  $request->HEALTH_SCREEN_DRINK;
        $addinfo->HEALTH_SCREEN_DRINK_AMOUNT =  $request->HEALTH_SCREEN_DRINK_AMOUNT;
      

        $addinfo->HEALTH_SCREEN_EXERCISE=  $request->HEALTH_SCREEN_EXERCISE;

        $addinfo->HEALTH_SCREEN_FOOD_1 =  $request->HEALTH_SCREEN_FOOD_1;
        $addinfo->HEALTH_SCREEN_FOOD_2 =  $request->HEALTH_SCREEN_FOOD_2;
        $addinfo->HEALTH_SCREEN_FOOD_3 =  $request->HEALTH_SCREEN_FOOD_3;
        $addinfo->HEALTH_SCREEN_FOOD_4 =  $request->HEALTH_SCREEN_FOOD_4;
        $addinfo->HEALTH_SCREEN_FOOD_5 =  $request->HEALTH_SCREEN_FOOD_5;

        $addinfo->HEALTH_SCREEN_DRIVE =  $request->HEALTH_SCREEN_DRIVE;
        $addinfo->HEALTH_SCREEN_SEX =  $request->HEALTH_SCREEN_SEX;

        $addinfo->HEALTH_SCREEN_AGE =  $request->HEALTH_SCREEN_AGE;
       

        $addinfo->save();
     

        return redirect()->route('health.checkup',['iduser'=>  $request->HEALTH_SCREEN_PERSON_ID]);
    }



    public function checkup(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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


        $budgetyear =  DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

         $infoscreen = DB::table('health_screen')->where('HEALTH_SCREEN_PERSON_ID','=',$iduser)
         ->orderBy('HEALTH_SCREEN_ID', 'desc')->get();

        return view('person_work.personinfoworkcheckup',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
            'budgetyears' => $budgetyear,
            'infoscreens' => $infoscreen,

            
        ]);
    }




    public function screen_add(Request $request,$iduser)
    {
       
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

      

        return view('person_work.personinfoworkscreen_add',[
            'inforperson' => $inforperson,
            'inforpersonid' => $inforpersonid,
           
            
        ]);
    }


    public function screen_save(Request $request)
    {

        $DATE_WANT = $request->HEALTH_SCREEN_DATE;

        if($DATE_WANT != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_WANT)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $DATEWANT= $y_st."-".$m_st."-".$d_st;
        }else{
        $DATEWANT= null;
    }



        $addinfo = new Healthscreen(); 
        $addinfo->HEALTH_SCREEN_YEAR = $request->HEALTH_SCREEN_YEAR;
        $addinfo->HEALTH_SCREEN_PERSON_ID = $request->HEALTH_SCREEN_PERSON_ID;
        $addinfo->HEALTH_SCREEN_HEIGHT = $request->HEALTH_SCREEN_HEIGHT;
        $addinfo->HEALTH_SCREEN_WEIGHT = $request->HEALTH_SCREEN_WEIGHT;
        $addinfo->HEALTH_SCREEN_BODY =  $request->HEALTH_SCREEN_BODY;
        
        $addinfo->HEALTH_SCREEN_FM_DIA =  $request->HEALTH_SCREEN_FM_DIA;
        $addinfo->HEALTH_SCREEN_FM_BLOOD =  $request->HEALTH_SCREEN_FM_BLOOD;
        $addinfo->HEALTH_SCREEN_FM_GOUT =  $request->HEALTH_SCREEN_FM_GOUT;
        $addinfo->HEALTH_SCREEN_FM_KIDNEY =  $request->HEALTH_SCREEN_FM_KIDNEY;
        $addinfo->HEALTH_SCREEN_FM_HEART =  $request->HEALTH_SCREEN_FM_HEART;
        $addinfo->HEALTH_SCREEN_FM_BRAIN =  $request->HEALTH_SCREEN_FM_BRAIN;
        $addinfo->HEALTH_SCREEN_FM_EMPHY =  $request->HEALTH_SCREEN_FM_EMPHY;
        $addinfo->HEALTH_SCREEN_FM_UNKNOW =  $request->HEALTH_SCREEN_FM_UNKNOW;
        $addinfo->HEALTH_SCREEN_FM_OTHER =  $request->HEALTH_SCREEN_FM_OTHER;

        $addinfo->HEALTH_SCREEN_BS_DIA =  $request->HEALTH_SCREEN_BS_DIA;
        $addinfo->HEALTH_SCREEN_BS_BLOOD =  $request->HEALTH_SCREEN_BS_BLOOD;
        $addinfo->HEALTH_SCREEN_BS_GOUT =  $request->HEALTH_SCREEN_BS_GOUT;
        $addinfo->HEALTH_SCREEN_BS_KIDNEY =  $request->HEALTH_SCREEN_BS_KIDNEY;
        $addinfo->HEALTH_SCREEN_BS_HEART =  $request->HEALTH_SCREEN_BS_HEART;
        $addinfo->HEALTH_SCREEN_BS_BRAIN =  $request->HEALTH_SCREEN_BS_BRAIN;
        $addinfo->HEALTH_SCREEN_BS_EMPHY =  $request->HEALTH_SCREEN_BS_EMPHY;
        $addinfo->HEALTH_SCREEN_BS_UNKNOW =  $request->HEALTH_SCREEN_BS_UNKNOW;
        $addinfo->HEALTH_SCREEN_BS_OTHER =  $request->HEALTH_SCREEN_BS_OTHER;

        $addinfo->HEALTH_SCREEN_H_1 =  $request->HEALTH_SCREEN_H_1;
        $addinfo->HEALTH_SCREEN_H_2 =  $request->HEALTH_SCREEN_H_2;
        $addinfo->HEALTH_SCREEN_H_3 =  $request->HEALTH_SCREEN_H_3;
        $addinfo->HEALTH_SCREEN_H_4=  $request->HEALTH_SCREEN_H_4;
        $addinfo->HEALTH_SCREEN_H_5 =  $request->HEALTH_SCREEN_H_5;
        $addinfo->HEALTH_SCREEN_H_6 =  $request->HEALTH_SCREEN_H_6;
        $addinfo->HEALTH_SCREEN_H_7 =  $request->HEALTH_SCREEN_H_7;
        $addinfo->HEALTH_SCREEN_H_8 =  $request->HEALTH_SCREEN_H_8;
        $addinfo->HEALTH_SCREEN_H_9 =  $request->HEALTH_SCREEN_H_9;
        $addinfo->HEALTH_SCREEN_H_10 =  $request->HEALTH_SCREEN_H_10;
        $addinfo->HEALTH_SCREEN_H_11 =  $request->HEALTH_SCREEN_H_11;
        $addinfo->HEALTH_SCREEN_H_12 =  $request->HEALTH_SCREEN_H_12;
        $addinfo->HEALTH_SCREEN_H_13 =  $request->HEALTH_SCREEN_H_13;
        $addinfo->HEALTH_SCREEN_H_14 =  $request->HEALTH_SCREEN_H_14;
        $addinfo->HEALTH_SCREEN_H_15 =  $request->HEALTH_SCREEN_H_15;
        $addinfo->HEALTH_SCREEN_H_16 =  $request->HEALTH_SCREEN_H_16;
        $addinfo->HEALTH_SCREEN_H_17 =  $request->HEALTH_SCREEN_H_17;
        $addinfo->HEALTH_SCREEN_H_18 =  $request->HEALTH_SCREEN_H_18;
        $addinfo->HEALTH_SCREEN_H_19 =  $request->HEALTH_SCREEN_H_19;
        $addinfo->HEALTH_SCREEN_H_20 =  $request->HEALTH_SCREEN_H_20;
        $addinfo->HEALTH_SCREEN_H_21 =  $request->HEALTH_SCREEN_H_21;
        $addinfo->HEALTH_SCREEN_H_22 =  $request->HEALTH_SCREEN_H_22;
        $addinfo->HEALTH_SCREEN_H_23 =  $request->HEALTH_SCREEN_H_23;
        $addinfo->HEALTH_SCREEN_H_24 =  $request->HEALTH_SCREEN_H_24;
        $addinfo->HEALTH_SCREEN_H_25 =  $request->HEALTH_SCREEN_H_25;
        $addinfo->HEALTH_SCREEN_H_26 =  $request->HEALTH_SCREEN_H_26;
        $addinfo->HEALTH_SCREEN_H_27 =  $request->HEALTH_SCREEN_H_27;
        $addinfo->HEALTH_SCREEN_H_28 =  $request->HEALTH_SCREEN_H_28;
        $addinfo->HEALTH_SCREEN_H_HAVE =  $request->HEALTH_SCREEN_H_HAVE;


        $addinfo->HEALTH_SCREEN_SMOK =  $request->HEALTH_SCREEN_SMOK;
        $addinfo->HEALTH_SCREEN_SMOK_AMOUNT =  $request->HEALTH_SCREEN_SMOK_AMOUNT;
        $addinfo->HEALTH_SCREEN_SMOK_TYPE =  $request->HEALTH_SCREEN_SMOK_TYPE;
        $addinfo->HEALTH_SCREEN_SMOK_TIME =  $request->HEALTH_SCREEN_SMOK_TIME;


        $addinfo->HEALTH_SCREEN_DRINK =  $request->HEALTH_SCREEN_DRINK;
        $addinfo->HEALTH_SCREEN_DRINK_AMOUNT =  $request->HEALTH_SCREEN_DRINK_AMOUNT;
      

        $addinfo->HEALTH_SCREEN_EXERCISE=  $request->HEALTH_SCREEN_EXERCISE;
     

        $addinfo->HEALTH_SCREEN_FOOD_1 =  $request->HEALTH_SCREEN_FOOD_1;
        $addinfo->HEALTH_SCREEN_FOOD_2 =  $request->HEALTH_SCREEN_FOOD_2;
        $addinfo->HEALTH_SCREEN_FOOD_3 =  $request->HEALTH_SCREEN_FOOD_3;
        $addinfo->HEALTH_SCREEN_FOOD_4 =  $request->HEALTH_SCREEN_FOOD_4;
        $addinfo->HEALTH_SCREEN_FOOD_5 =  $request->HEALTH_SCREEN_FOOD_5;

        $addinfo->HEALTH_SCREEN_DRIVE =  $request->HEALTH_SCREEN_DRIVE;
        $addinfo->HEALTH_SCREEN_SEX =  $request->HEALTH_SCREEN_SEX;

        $addinfo->HEALTH_SCREEN_DATE =  $DATEWANT;
        $addinfo->HEALTH_SCREEN_AGE =  $request->HEALTH_SCREEN_AGE;
        $addinfo->HEALTH_SCREEN_STATUS =  'SCREEN';

        $addinfo->save();
     

        return redirect()->route('health.checkup',['iduser'=>  $request->HEALTH_SCREEN_PERSON_ID]);
    
           

    }



    //============================================================================================================


    public function jobdescription(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);

       $infojobdis = DB::table('infowork_job_dis_position')
       ->leftJoin('infowork_job_dis','infowork_job_dis.JOD_DIS_ID','=','infowork_job_dis_position.JOD_DIS_ID')
       ->where('JOD_POSITION_ID','=', $inforperson->HR_POSITION_ID )->get();
      

        return view('person_work.personinfoworkjobdescription',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infojobdiss' => $infojobdis
            
        ]);
    }



    public function corecompetency_detail(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid = Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);

       $infoworkcorcom = DB::table('infowork_cor_com')->get();
      
       $corecompetency = DB::table('infowork_cor_result')->where('COR_RESULT_PERSON_ID','=',$iduser)->get();

        return view('person_work.personinfoworkcorecompetency_detail',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkcorcoms'=> $infoworkcorcom,
            'corecompetencys'=> $corecompetency
            
        ]);
    }


    public function personworkcorecompetency_detail_sub(Request $request,$idref,$idhr)
    {


       $infoworkcorcom = DB::table('infowork_cor_com')->get();
      
   
       $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();

       $infocorresult = DB::table('infowork_cor_result')->where('COR_RESULT_ID','=',$idref)->first(); 


        return view('person_work.personworkcorecompetency_detail_sub',[
            'infoworkcorcoms'=> $infoworkcorcom,
            'infoperson'=> $infoperson,
            'infocorresult'=>$infocorresult
            
        ]);
    }

    


    public function corecompetency(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid = Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);

       $infoworkcorcom = DB::table('infowork_cor_com')->get();
      

        return view('person_work.personinfoworkcorecompetency',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkcorcoms'=> $infoworkcorcom
            
        ]);
    }



    public function funtionalcompetency_detail(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);
       $infoworkfuntion = DB::table('infowork_funtion')->get();

       $infoperson = DB::table('hrd_person')->where('ID','=',$iduser)->first();

       $corecompetency = DB::table('infowork_fun_result')->where('FUN_RESULT_PERSON_ID','=',$iduser)->get();
       


        return view('person_work.personinfoworkfuntionalcompetency_detail',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkfuntions'=> $infoworkfuntion,
            'infoperson'=> $infoperson,
            'corecompetencys'=> $corecompetency
            
        ]);
    }


    
    public function personworkfuntionalcompetency_detail_sub(Request $request,$idref,$idhr)
    {


        $infoworkfuntion = DB::table('infowork_funtion')->get();
      
   
        $infoperson = DB::table('hrd_person')->where('ID','=',$idhr)->first();
 
        $infocorresult = DB::table('infowork_fun_result')->where('FUN_RESULT_ID','=',$idref)->first(); 
 


        return view('person_work.personworkfuntionalcompetency_detail_sub',[
            'infoworkfuntions'=> $infoworkfuntion,
            'infoperson'=> $infoperson,
            'infocorresult'=>$infocorresult
            
        ]);
    }

    

    public function funtionalcompetency(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);
       $infoworkfuntion = DB::table('infowork_funtion')->get();


        return view('person_work.personinfoworkfuntionalcompetency',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infoworkfuntions'=> $infoworkfuntion
            
        ]);
    }


    

    public function kpis(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);
       
       $infokpiorg = DB::table('plan_kpi')->get();

       $infokpiperson = DB::table('infowork_kpis')->get();
      
      

        return view('person_work.personinfoworkkpis',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infokpiorgs'=> $infokpiorg,
            'infokpipersons'=> $infokpiperson,
            
        ]);
    }


     

    public function personworkkpis_detail(Request $request,$iduser)
    {
        $email = Auth::user()->email;
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

       //dd($infoeducation);
       
       $infokpiorg = DB::table('plan_kpi')->get();

       $infokpiperson = DB::table('infowork_kpis')->get();
      
      

        return view('person_work.personinfoworkkpis_detail',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infokpiorgs'=> $infokpiorg,
            'infokpipersons'=> $infokpiperson,
            
        ]);
    }




    //========================ตั้งค่าระดับการประเมิน=====


    
    public function personworkcorecompetency_setup(Request $request,$iduser)
    {
       
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

     
        $infocom = DB::table('infowork_cor_com')->get();

        return view('person_work.personworkcorecompetency_setup',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infocoms' => $infocom,
            
        ]);
    }


    public function personworkcorecompetency_setupupdate(Request $request)
    {

            $COR_COM_SET_PERSON_ID = $request->COR_COM_SET_PERSON_ID;
            $COR_COM_SET_YEAR = $request->COR_COM_SET_YEAR;
            $COR_COM_SET_LEVEL_ID = $request->COR_COM_SET_LEVEL_ID;
            $COR_COM_SET_LEVEL_SUB_MAX = $request->COR_COM_SET_LEVEL_SUB_MAX;

            $number =count($COR_COM_SET_LEVEL_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
          
               $addsup = new Infoworkcorcomsetup();
               $addsup->COR_COM_SET_PERSON_ID = $COR_COM_SET_PERSON_ID;
               $addsup->COR_COM_SET_YEAR = $COR_COM_SET_YEAR;
               $addsup->COR_COM_SET_LEVEL_ID = $COR_COM_SET_LEVEL_ID[$count];
               $addsup->COR_COM_SET_LEVEL_SUB_MAX = $COR_COM_SET_LEVEL_SUB_MAX[$count];
               $addsup->save(); 
             
               
            }
        
    
        return redirect()->action('AbilityController@corecompetency_detail',[
            'iduser' => $COR_COM_SET_PERSON_ID
        ]);  
    }


    public function personworkfuntionalcompetency_setup(Request $request,$iduser)
    {
     
        $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

     
      $infofun = DB::table('infowork_funtion')->get();

        return view('person_work.personworkfuntionalcompetency_setup',[
            'inforpersonuser' => $inforperson,
            'inforpersonuserid' => $inforpersonid,
            'infofuns' => $infofun,
            
        ]);
    }



    public function carcalendarhealth(Request $request,$iduser)
{

    $inforpersonid =  Person::where('ID','=',$iduser)->first();
            
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

    $daycheck = Healthscreen::leftJoin('hrd_person','hrd_person.ID','=','health_screen.HEALTH_SCREEN_PERSON_ID')
    ->get();
   

  
    
    return view('person_work.carcalendarhealth',[
        'inforperson' => $inforperson,
        'inforpersonid' => $inforpersonid,
        'daychecks' => $daycheck,
        
    ]);
}



    
    public function personworkfuntionalcompetency_setupupdate(Request $request)
    {

            $FUNTION_SET_PERSON_ID = $request->FUNTION_SET_PERSON_ID;
            $FUNTION_SET_YEAR = $request->FUNTION_SET_YEAR;
            $FUNTION_SET_LEVEL_ID = $request->FUNTION_SET_LEVEL_ID;
            $FUNTION_SET_LEVEL_SUB_MAX = $request->FUNTION_SET_LEVEL_SUB_MAX;

            $number =count($FUNTION_SET_LEVEL_ID);
            $count = 0;
            for($count = 0; $count < $number; $count++)
            {  
          
               $addsup = new Infoworkfunctionsetup();
               $addsup->FUNTION_SET_PERSON_ID = $FUNTION_SET_PERSON_ID;
               $addsup->FUNTION_SET_YEAR = $FUNTION_SET_YEAR;
               $addsup->FUNTION_SET_LEVEL_ID = $FUNTION_SET_LEVEL_ID[$count];
               $addsup->FUNTION_SET_LEVEL_SUB_MAX = $FUNTION_SET_LEVEL_SUB_MAX[$count];
               $addsup->save(); 
             
               
            }
        
    
        return redirect()->action('AbilityController@funtionalcompetency_detail',[
            'iduser' => $FUNTION_SET_PERSON_ID
        ]);  
    }

    public function healthpdf($idref)
    {     
        
        $infomation = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$idref)->first();
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
        ->where('hrd_person.ID','=',$infomation->HEALTH_SCREEN_PERSON_ID)->first();

        $org = DB::table('info_org')->where('ORG_ID','=','1')->first();

        $infolab =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->get();
        $sumamount =  DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID','=',$idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $pdf = PDF::loadView('person_work.healthpdf',[
            'infomation' =>   $infomation,
            'inforperson' =>   $inforperson,
            'org' =>   $org,
            'sumamount' =>   $sumamount,
            'infolabs' =>   $infolab, 
        ]);
        $pdf->setOptions([
            'mode' => 'utf-8',           
            'default_font_size' => 17,
            'defaultFont' => 'THSarabunNew'                       
            ]);
        // $pdf->setPaper('a4', 'landscape');

      return @$pdf->stream();

    }




    public static function checkfamily($id)
{
    $check1 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_DIA','=','on')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_BLOOD','=','on')->count();
    $check3 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_GOUT','=','on')->count();
    $check4 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_KIDNEY','=','on')->count();
    $check5 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_HEART','=','on')->count();
    $check6 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_BRAIN','=','on')->count();
    $check7 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_EMPHY','=','on')->count();
    $check8 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_UNKNOW','=','on')->count();
    $check9 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FM_OTHER','=','on')->count();
    $check10 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_DIA','=','on')->count();
    $check11 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_BLOOD','=','on')->count();
    $check12 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_GOUT','=','on')->count();
    $check13 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_KIDNEY','=','on')->count();
    $check14 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_HEART','=','on')->count();
    $check15 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_BRAIN','=','on')->count();
    $check16 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_EMPHY','=','on')->count();
    $check17 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_UNKNOW','=','on')->count();
    $check18 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_BS_OTHER','=','on')->count();
    
    
    $check = $check1+$check2+$check3+$check4+$check5+$check6+$check7+$check8+$check9+$check10+$check11+$check12+$check13+$check14+$check15+$check16+$check17+$check18;
  
   

   if($check != 0){
    $echo =  'เสี่ยง';
   }else{
    $echo =  'ไม่เสี่ยง';
   }    
    



    return $echo;
}




public static function checkillness($id)
{
    $check1 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_1','=','have')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_2','=','have')->count();
    $check3 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_3','=','have')->count();
    $check4 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_4','=','have')->count();
    $check5 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_5','=','have')->count();
    $check6 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_6','=','have')->count();
    $check7 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_7','=','have')->count();
    $check8 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_8','=','have')->count();
    $check9 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_9','=','have')->count();
    $check10 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_10','=','have')->count();
    $check11 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_11','=','have')->count();
    $check12 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_12','=','have')->count();
    $check13 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_13','=','have')->count();
    $check14 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_14','=','have')->count();
    $check15 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_15','=','have')->count();
    $check16 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_16','=','have')->count();
    $check17 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_17','=','have')->count();
    $check18 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_18','=','have')->count();
    $check19 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_19','=','have')->count();
    $check20 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_20','=','have')->count();
    $check21 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_21','=','have')->count();
    $check22 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_22','=','have')->count();
    $check23 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_23','=','have')->count();
    $check24 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_24','=','have')->count();
    $check25 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_25','=','have')->count();
    $check26 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_26','=','have')->count();
    $check27 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_27','=','have')->count();
    $check28 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_H_28','=','have')->count();

    
    
    $check = $check1+$check2+$check3+$check4+$check5+$check6+$check7+$check8+$check9+$check10+$check11+$check12+$check13+$check14+$check15+$check16+$check17+$check18+$check19+$check20+$check21+$check22+$check23+$check24+$check25+$check26+$check27+$check28;
  
   

   if($check != 0){
    $echo =  'เสี่ยง';
   }else{
    $echo =  'ไม่เสี่ยง';
   }    


    return $echo;
}


public static function checksmok($id)
{
    $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_SMOK','=','smok')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_SMOK','=','usesmok')->count();
   
    if($check != 0){
        $echo =  'สูบ';
       }else if($check2 != 0){
        $echo =  'เคยสูบ';
       }else{
        $echo =  'ไม่สูบ';
       }    
        return $echo;

}  

public static function checkdrink($id)
{
    $check = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_DRINK','=','drink')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_DRINK','=','usedrink')->count();

    if($check != 0){
        $echo =  'ดื่ม';
     }else if($check2 != 0){
        $echo =  'เคยดื่ม';
       }else{
        $echo =  'ไม่ดื่ม';
       }    
        return $echo;

} 


public static function checkex($id)
{
    $check1 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_EXERCISE','=','3')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_EXERCISE','=','4')->count();

    $check =  $check1+ $check2;

    if($check != 0){
        $echo =  'เสี่ยง';
       }else{
        $echo =  'ไม่เสี่ยง';
       }    
        return $echo;

} 



public static function checklike($id)
{
    $check1 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FOOD_1','=','on')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FOOD_2','=','on')->count();
    $check3 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FOOD_3','=','on')->count();
    $check4 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_FOOD_4','=','on')->count();

    $check =  $check1+$check2+$check3+$check4;
    
    if($check != 0){
        $echo =  'เสี่ยง';
       }else{
        $echo =  'ไม่เสี่ยง';
       }    
        return $echo;

} 


public static function checkcar($id)
{
    $check1 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_DRIVE','=','3')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_DRIVE','=','4')->count();

    $check =  $check1+$check2;

    if($check != 0){
        $echo =  'เสี่ยง';
       }else{
        $echo =  'ไม่เสี่ยง';
       }    
        return $echo;

} 

public static function checksex($id)
{
    $check1 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_SEX','=','4')->count();
    $check2 = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->where('HEALTH_SCREEN_SEX','=','5')->count();

    $check =  $check1+ $check2;
    if($check != 0){
        $echo =  'ไม่เสี่ยง';
       }else{
        $echo =  'เสี่ยง';
       }    
        return $echo;

} 


public static function checkbmi($id)
{
    $bmi = DB::table('health_screen')->where('HEALTH_SCREEN_ID','=',$id)->first();

    $HEALTH_SCREEN_HEIGHT = $bmi->HEALTH_SCREEN_HEIGHT;
    $HEALTH_SCREEN_WEIGHT = $bmi->HEALTH_SCREEN_WEIGHT;
  
    if($HEALTH_SCREEN_HEIGHT !== '' && $HEALTH_SCREEN_HEIGHT !== null && $HEALTH_SCREEN_WEIGHT  !== '' && $HEALTH_SCREEN_WEIGHT !== null){
    $output = $HEALTH_SCREEN_WEIGHT/(($HEALTH_SCREEN_HEIGHT/100)*($HEALTH_SCREEN_HEIGHT/100));
    $resualbmi = number_format($output,2);
    }else{
        $resualbmi ='';
    }

    if($resualbmi < 18.50){
        $result =  'นน. ต่ำกว่าเกณฑ์';
       }else if($resualbmi >= 18.50 && $resualbmi <= 22.99){
        $result =  'สมส่วน';
       }else if($resualbmi > 22.99 && $resualbmi <= 24.99){
        $result =  'น้ำหนักเกิน';
       }else if($resualbmi > 24.99 && $resualbmi <= 29.99){
        $result =  'โรคอ้วน';
       }else if($resualbmi > 29.99){
        $result =  'โรคอ้วนอันตราย';
       }else{
        $result = '';
       }
       

      

        return $result;

}  



function checkdateyear(Request $request)
{
  $IDUSER = $request->get('IDUSER');
  $DATE_WANT = $request->get('HEALTH_SCREEN_DATE');
  $HEALTH_SCREEN_YEAR = $request->get('HEALTH_SCREEN_YEAR');

  if($DATE_WANT != ''){
    $STARTDAY = Carbon::createFromFormat('d/m/Y', $DATE_WANT)->format('Y-m-d');
    $date_arrary_st=explode("-",$STARTDAY);  
    $y_sub_st = $date_arrary_st[0]; 
    
    if($y_sub_st >= 2500){
        $y_st = $y_sub_st-543;
    }else{
        $y_st = $y_sub_st;
    }
    $m_st = $date_arrary_st[1];
    $d_st = $date_arrary_st[2];  
    $DATEWANT= $y_st."-".$m_st."-".$d_st;
    }else{
    $DATEWANT= '';
}


  $checkyear = DB::table('health_screen')->where('HEALTH_SCREEN_DATE','=',$DATEWANT)->where('HEALTH_SCREEN_PERSON_ID','=',$IDUSER)->count();



        if($checkyear > 0){
            $result = '<p style="color:red;font-size: 19px;">ท่านได้ทำการบึนทึกการคัดกรองในวันดังกล่าวแล้ว !! </p>';
    
        }else{
            $result = '';

        }

        
  
  echo $result;

}


//คำนวณดัชนีมวลกาย


function calbmi(Request $request)
{

  $HEALTH_SCREEN_HEIGHT = $request->get('HEALTH_SCREEN_HEIGHT');
  $HEALTH_SCREEN_WEIGHT = $request->get('HEALTH_SCREEN_WEIGHT');

  $output = $HEALTH_SCREEN_WEIGHT/(($HEALTH_SCREEN_HEIGHT/100)*($HEALTH_SCREEN_HEIGHT/100));
  $bmi = number_format($output,2);

  
  $result = $bmi.'<input type="hidden" name = "HEALTH_SCREEN_BODY"  id="HEALTH_SCREEN_BODY" value= "'.$bmi.'"class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >';

  
  echo $result;

}



function bodysize(Request $request)
{

  $resualbmi = $request->get('HEALTH_SCREEN_BODY');
 


  if($resualbmi < 18.50){
    $result =  '<p >นน. ต่ำกว่าเกณฑ์</p>';
   }else if($resualbmi >= 18.50 && $resualbmi <= 22.99){
    $result =  '<p style="color:#228B22">สมส่วน</p>';
   }else if($resualbmi > 22.99 && $resualbmi <= 24.99){
    $result =  '<p style="color:#FFD700">น้ำหนักเกิน</p>';
   }else if($resualbmi > 24.99 && $resualbmi <= 29.99){
    $result =  '<p style="color:#FF8C00">โรคอ้วน</p>';
   }else if($resualbmi > 29.99){
    $result =  '<p style="color:#FF4500">โรคอ้วนอันตราย</p>';
   }else{
    $result = '';
   }
  

  
  echo $result;

}


}
