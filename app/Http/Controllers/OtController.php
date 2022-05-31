<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Otindexsub;
use App\Models\Otindex;
use App\Models\Otcommand;
use PDF;


class OtController extends Controller
{
   
public function geotindex(Request $request,$iduser)
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

            
          $infomationot = Otindex::leftjoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','ot_index.OT_DEP_SUB_SUB')
          ->get();
             
        return view('general_ot.geotindex',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'infomationots' => $infomationot, 
            
        ]);
    }


      
public function geotsetdetail_add(Request $request,$iduser)
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

             
    $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('HR_STATUS_ID','=',1)
    ->get();

    $operat = DB::table('operate_job')->get();

    $hrdsubsub = DB::table('hrd_department_sub_sub')->get();

         
    return view('general_ot.geotsetdetail_add',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'hrdsubsubs' => $hrdsubsub,
        'operats' => $operat, 
        'PERSONALLs' => $PERSONALL, 
        
    ]);
}



public function geotsetdetail_save(Request $request)
    {

        $idusersave = $request->OT_INDEX_PERSON_ID;
        $addhead = new Otindex();
        $addhead->OT_YEAR =  $request->OT_YEAR;  
        $addhead->OT_MONTH =  $request->OT_MONTH;  
        $addhead->OT_DEP_SUB_SUB =  $request->OT_DEP_SUB_SUB;   
        $addhead->OT_TYPE =  $request->OT_TYPE;    
        $addhead->OT_INDEX_PERSON_ID =  $request->OT_INDEX_PERSON_ID;    
        $addhead->OT_PERSON_NAME =  $request->OT_PERSON_NAME;
        $addhead->OT_STATUS =  'Wait';
        $addhead->save(); 

        $maxid = DB::table('ot_index')->max('OT_INDEX_ID');
         if($request->OT_PERSON_ID[0] != '' || $request->OT_PERSON_ID[0] != null){

         $OT_PERSON_ID = $request->OT_PERSON_ID;
         $OT_JOB = $request->OT_JOB;
         $OT_RATE = $request->OT_RATE;
         $OT_1DAY = $request->OT_1DAY;
         $OT_2DAY = $request->OT_2DAY;
         $OT_3DAY = $request->OT_3DAY;
         $OT_4DAY = $request->OT_4DAY;
         $OT_5DAY = $request->OT_5DAY;
         $OT_6DAY = $request->OT_6DAY;
         $OT_7DAY = $request->OT_7DAY;
         $OT_8DAY = $request->OT_8DAY;
         $OT_9DAY = $request->OT_9DAY;
         $OT_10DAY = $request->OT_10DAY;
         $OT_11DAY = $request->OT_11DAY;
         $OT_12DAY = $request->OT_12DAY;
         $OT_13DAY = $request->OT_13DAY;
         $OT_14DAY = $request->OT_14DAY;
         $OT_15DAY = $request->OT_15DAY;
         $OT_16DAY = $request->OT_16DAY;
         $OT_17DAY = $request->OT_17DAY;
         $OT_18DAY = $request->OT_18DAY;
         $OT_19DAY = $request->OT_19DAY;
         $OT_20DAY = $request->OT_20DAY;
         $OT_21DAY = $request->OT_21DAY;
         $OT_22DAY = $request->OT_22DAY;
         $OT_23DAY = $request->OT_23DAY;
         $OT_24DAY = $request->OT_24DAY;
         $OT_25DAY = $request->OT_25DAY;
         $OT_26DAY = $request->OT_26DAY;
         $OT_27DAY = $request->OT_27DAY;
         $OT_28DAY = $request->OT_28DAY;
         $OT_29DAY = $request->OT_29DAY;
         $OT_30DAY = $request->OT_30DAY;
         $OT_31DAY = $request->OT_31DAY;
        

         $number =count($OT_PERSON_ID);
         
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
    
            if($OT_RATE[$count] <> false){$amountOT_RATE = $OT_RATE[$count];}else{$amountOT_RATE = 0;}
             
            if(isset($OT_1DAY[$count]) <> false){$amountOT_1DAY = $OT_1DAY[$count];}else{$amountOT_1DAY = 0;}
            if(isset($OT_2DAY[$count]) <> false){$amountOT_2DAY = $OT_2DAY[$count];}else{$amountOT_2DAY = 0;}
            if(isset($OT_3DAY[$count]) <> false){$amountOT_3DAY = $OT_3DAY[$count];}else{$amountOT_3DAY = 0;}
            if(isset($OT_4DAY[$count]) <> false){$amountOT_4DAY = $OT_4DAY[$count];}else{$amountOT_4DAY = 0;}
            if(isset($OT_5DAY[$count]) <> false){$amountOT_5DAY = $OT_5DAY[$count];}else{$amountOT_5DAY = 0;}
            if(isset($OT_6DAY[$count]) <> false){$amountOT_6DAY = $OT_6DAY[$count];}else{$amountOT_6DAY = 0;}
            if(isset($OT_7DAY[$count]) <> false){$amountOT_7DAY = $OT_7DAY[$count];}else{$amountOT_7DAY = 0;}
            if(isset($OT_8DAY[$count]) <> false){$amountOT_8DAY = $OT_8DAY[$count];}else{$amountOT_8DAY = 0;}
            if(isset($OT_9DAY[$count]) <> false){$amountOT_9DAY = $OT_9DAY[$count];}else{$amountOT_9DAY = 0;}
            if(isset($OT_10DAY[$count]) <> false){$amountOT_10DAY = $OT_10DAY[$count];}else{$amountOT_10DAY = 0;}
            if(isset($OT_11DAY[$count]) <> false){$amountOT_11DAY = $OT_11DAY[$count];}else{$amountOT_11DAY = 0;}
            if(isset($OT_12DAY[$count]) <> false){$amountOT_12DAY = $OT_12DAY[$count];}else{$amountOT_12DAY = 0;}
            if(isset($OT_13DAY[$count]) <> false){$amountOT_13DAY = $OT_13DAY[$count];}else{$amountOT_13DAY = 0;}
            if(isset($OT_14DAY[$count]) <> false){$amountOT_14DAY = $OT_14DAY[$count];}else{$amountOT_14DAY = 0;}
            if(isset($OT_15DAY[$count]) <> false){$amountOT_15DAY = $OT_15DAY[$count];}else{$amountOT_15DAY = 0;}
            if(isset($OT_16DAY[$count]) <> false){$amountOT_16DAY = $OT_16DAY[$count];}else{$amountOT_16DAY = 0;}
            if(isset($OT_17DAY[$count]) <> false){$amountOT_17DAY = $OT_17DAY[$count];}else{$amountOT_17DAY = 0;}
            if(isset($OT_18DAY[$count]) <> false){$amountOT_18DAY = $OT_18DAY[$count];}else{$amountOT_18DAY = 0;}
            if(isset($OT_19DAY[$count]) <> false){$amountOT_19DAY = $OT_19DAY[$count];}else{$amountOT_19DAY = 0;}
            if(isset($OT_20DAY[$count]) <> false){$amountOT_20DAY = $OT_20DAY[$count];}else{$amountOT_20DAY = 0;}
            if(isset($OT_21DAY[$count]) <> false){$amountOT_21DAY = $OT_21DAY[$count];}else{$amountOT_21DAY = 0;}
            if(isset($OT_22DAY[$count]) <> false){$amountOT_22DAY = $OT_22DAY[$count];}else{$amountOT_22DAY = 0;}
            if(isset($OT_23DAY[$count]) <> false){$amountOT_23DAY = $OT_23DAY[$count];}else{$amountOT_23DAY = 0;}
            if(isset($OT_24DAY[$count]) <> false){$amountOT_24DAY = $OT_24DAY[$count];}else{$amountOT_24DAY = 0;}
            if(isset($OT_25DAY[$count]) <> false){$amountOT_25DAY = $OT_25DAY[$count];}else{$amountOT_25DAY = 0;}
            if(isset($OT_26DAY[$count]) <> false){$amountOT_26DAY = $OT_26DAY[$count];}else{$amountOT_26DAY = 0;}
            if(isset($OT_27DAY[$count]) <> false){$amountOT_27DAY = $OT_27DAY[$count];}else{$amountOT_27DAY = 0;}
            if(isset($OT_28DAY[$count]) <> false){$amountOT_28DAY = $OT_28DAY[$count];}else{$amountOT_28DAY = 0;}
            if(isset($OT_29DAY[$count]) <> false){$amountOT_29DAY = $OT_29DAY[$count];}else{$amountOT_29DAY = 0;}
            if(isset($OT_30DAY[$count]) <> false){$amountOT_30DAY = $OT_30DAY[$count];}else{$amountOT_30DAY = 0;}
            if(isset($OT_31DAY[$count]) <> false){$amountOT_31DAY = $OT_31DAY[$count];}else{$amountOT_31DAY = 0;}
          
            $sumtotal = $amountOT_RATE * ($amountOT_1DAY +  $amountOT_2DAY+ $amountOT_3DAY+ $amountOT_4DAY+ $amountOT_5DAY+ $amountOT_6DAY+ $amountOT_7DAY+ $amountOT_8DAY+ $amountOT_9DAY + $amountOT_10DAY+ $amountOT_11DAY+ $amountOT_12DAY+ $amountOT_13DAY+ $amountOT_14DAY+ $amountOT_15DAY+ $amountOT_16DAY+ $amountOT_17DAY+ $amountOT_18DAY+ $amountOT_19DAY+ $amountOT_20DAY+ $amountOT_21DAY+ $amountOT_22DAY+ $amountOT_23DAY+ $amountOT_24DAY+ $amountOT_25DAY+ $amountOT_26DAY+ $amountOT_27DAY +$amountOT_28DAY+ $amountOT_29DAY+ $amountOT_30DAY+ $amountOT_31DAY);
            
           
            
            $add = new Otindexsub();
            $add->OT_PERSON_ID = $OT_PERSON_ID[$count];
            $add->OT_JOB = $OT_JOB[$count];
            $add->OT_INDEX_ID = $maxid;
            $add->OT_RATE = $amountOT_RATE;
            $add->OT_1DAY = $amountOT_1DAY;
            $add->OT_2DAY = $amountOT_2DAY;
            $add->OT_3DAY = $amountOT_3DAY;
            $add->OT_4DAY = $amountOT_4DAY;
            $add->OT_5DAY = $amountOT_5DAY;
            $add->OT_6DAY = $amountOT_6DAY;
            $add->OT_7DAY = $amountOT_7DAY;
            $add->OT_8DAY = $amountOT_8DAY;
            $add->OT_9DAY = $amountOT_9DAY;
            $add->OT_10DAY = $amountOT_10DAY;
            $add->OT_11DAY = $amountOT_11DAY;
            $add->OT_12DAY = $amountOT_12DAY;
            $add->OT_13DAY = $amountOT_13DAY;
            $add->OT_14DAY = $amountOT_14DAY;
            $add->OT_15DAY = $amountOT_15DAY;
            $add->OT_16DAY = $amountOT_16DAY;
            $add->OT_17DAY = $amountOT_17DAY;
            $add->OT_18DAY = $amountOT_18DAY;
            $add->OT_19DAY = $amountOT_19DAY;
            $add->OT_20DAY = $amountOT_20DAY;
            $add->OT_21DAY = $amountOT_21DAY;
            $add->OT_22DAY = $amountOT_22DAY;
            $add->OT_23DAY = $amountOT_23DAY;
            $add->OT_24DAY = $amountOT_24DAY;
            $add->OT_25DAY = $amountOT_25DAY;
            $add->OT_26DAY = $amountOT_26DAY;
            $add->OT_27DAY = $amountOT_27DAY;
            $add->OT_28DAY = $amountOT_28DAY;
            $add->OT_29DAY = $amountOT_29DAY;
            $add->OT_30DAY = $amountOT_30DAY;
            $add->OT_31DAY = $amountOT_31DAY;
            $add->OT_SUM   = $sumtotal;
            $add->save(); 

         }

        }

        $infomaountsum = DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$maxid)->count();
        $infobudgetsum = DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$maxid)->sum('OT_SUM');
        
        $update = Otindex::find($maxid);
        $update->OT_AMOUNT_PERSON = $infomaountsum;
        $update->OT_BUGGET_SUM = $infobudgetsum;
        $update->save(); 

        
         return redirect()->route('ot.iduser',['iduser'=>$idusersave]);

}


  
public function geotsetdetail_edit(Request $request,$idref,$iduser)
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
    
                 
        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();
    
        $operat = DB::table('operate_job')->get();
    
        $hrdsubsub = DB::table('hrd_department_sub_sub')->get();
    
         $infomationot = DB::table('ot_index')->where('OT_INDEX_ID','=',$idref)->first();

         $infomationotsub =  DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$idref)->get();

             
        return view('general_ot.geotsetdetail_edit',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'hrdsubsubs' => $hrdsubsub,
            'operats' => $operat, 
            'PERSONALLs' => $PERSONALL, 
            'infomationot' => $infomationot, 
            'infomationotsubs' => $infomationotsub, 
            'idref' => $idref, 
            
        ]);
    }


  
    public function geotsetdetail_update(Request $request)
    {
  
        $idrefot = $request->idrefot;
        $idusersave = $request->OT_INDEX_PERSON_ID;

        
        $addhead = Otindex::find($idrefot);
        $addhead->OT_YEAR =  $request->OT_YEAR;  
        $addhead->OT_MONTH =  $request->OT_MONTH;  
        $addhead->OT_DEP_SUB_SUB =  $request->OT_DEP_SUB_SUB;   
        $addhead->OT_TYPE =  $request->OT_TYPE;    
        $addhead->OT_INDEX_PERSON_ID =  $request->OT_INDEX_PERSON_ID;    
        $addhead->OT_PERSON_NAME =  $request->OT_PERSON_NAME;
        $addhead->save(); 

     

        Otindexsub::where('OT_INDEX_ID','=',$idrefot)->delete(); 

         if($request->OT_PERSON_ID[0] != '' || $request->OT_PERSON_ID[0] != null){

         $OT_PERSON_ID = $request->OT_PERSON_ID;
         $OT_JOB = $request->OT_JOB;
         $OT_RATE = $request->OT_RATE;
         $OT_1DAY = $request->OT_1DAY;
         $OT_2DAY = $request->OT_2DAY;
         $OT_3DAY = $request->OT_3DAY;
         $OT_4DAY = $request->OT_4DAY;
         $OT_5DAY = $request->OT_5DAY;
         $OT_6DAY = $request->OT_6DAY;
         $OT_7DAY = $request->OT_7DAY;
         $OT_8DAY = $request->OT_8DAY;
         $OT_9DAY = $request->OT_9DAY;
         $OT_10DAY = $request->OT_10DAY;
         $OT_11DAY = $request->OT_11DAY;
         $OT_12DAY = $request->OT_12DAY;
         $OT_13DAY = $request->OT_13DAY;
         $OT_14DAY = $request->OT_14DAY;
         $OT_15DAY = $request->OT_15DAY;
         $OT_16DAY = $request->OT_16DAY;
         $OT_17DAY = $request->OT_17DAY;
         $OT_18DAY = $request->OT_18DAY;
         $OT_19DAY = $request->OT_19DAY;
         $OT_20DAY = $request->OT_20DAY;
         $OT_21DAY = $request->OT_21DAY;
         $OT_22DAY = $request->OT_22DAY;
         $OT_23DAY = $request->OT_23DAY;
         $OT_24DAY = $request->OT_24DAY;
         $OT_25DAY = $request->OT_25DAY;
         $OT_26DAY = $request->OT_26DAY;
         $OT_27DAY = $request->OT_27DAY;
         $OT_28DAY = $request->OT_28DAY;
         $OT_29DAY = $request->OT_29DAY;
         $OT_30DAY = $request->OT_30DAY;
         $OT_31DAY = $request->OT_31DAY;
        

         $number =count($OT_PERSON_ID);
         
         $count = 0;
         for($count = 0; $count < $number; $count++)
         {  
    
            if($OT_RATE[$count] <> false){$amountOT_RATE = $OT_RATE[$count];}else{$amountOT_RATE = 0;}
             
            if(isset($OT_1DAY[$count]) <> false){$amountOT_1DAY = $OT_1DAY[$count];}else{$amountOT_1DAY = 0;}
            if(isset($OT_2DAY[$count]) <> false){$amountOT_2DAY = $OT_2DAY[$count];}else{$amountOT_2DAY = 0;}
            if(isset($OT_3DAY[$count]) <> false){$amountOT_3DAY = $OT_3DAY[$count];}else{$amountOT_3DAY = 0;}
            if(isset($OT_4DAY[$count]) <> false){$amountOT_4DAY = $OT_4DAY[$count];}else{$amountOT_4DAY = 0;}
            if(isset($OT_5DAY[$count]) <> false){$amountOT_5DAY = $OT_5DAY[$count];}else{$amountOT_5DAY = 0;}
            if(isset($OT_6DAY[$count]) <> false){$amountOT_6DAY = $OT_6DAY[$count];}else{$amountOT_6DAY = 0;}
            if(isset($OT_7DAY[$count]) <> false){$amountOT_7DAY = $OT_7DAY[$count];}else{$amountOT_7DAY = 0;}
            if(isset($OT_8DAY[$count]) <> false){$amountOT_8DAY = $OT_8DAY[$count];}else{$amountOT_8DAY = 0;}
            if(isset($OT_9DAY[$count]) <> false){$amountOT_9DAY = $OT_9DAY[$count];}else{$amountOT_9DAY = 0;}
            if(isset($OT_10DAY[$count]) <> false){$amountOT_10DAY = $OT_10DAY[$count];}else{$amountOT_10DAY = 0;}
            if(isset($OT_11DAY[$count]) <> false){$amountOT_11DAY = $OT_11DAY[$count];}else{$amountOT_11DAY = 0;}
            if(isset($OT_12DAY[$count]) <> false){$amountOT_12DAY = $OT_12DAY[$count];}else{$amountOT_12DAY = 0;}
            if(isset($OT_13DAY[$count]) <> false){$amountOT_13DAY = $OT_13DAY[$count];}else{$amountOT_13DAY = 0;}
            if(isset($OT_14DAY[$count]) <> false){$amountOT_14DAY = $OT_14DAY[$count];}else{$amountOT_14DAY = 0;}
            if(isset($OT_15DAY[$count]) <> false){$amountOT_15DAY = $OT_15DAY[$count];}else{$amountOT_15DAY = 0;}
            if(isset($OT_16DAY[$count]) <> false){$amountOT_16DAY = $OT_16DAY[$count];}else{$amountOT_16DAY = 0;}
            if(isset($OT_17DAY[$count]) <> false){$amountOT_17DAY = $OT_17DAY[$count];}else{$amountOT_17DAY = 0;}
            if(isset($OT_18DAY[$count]) <> false){$amountOT_18DAY = $OT_18DAY[$count];}else{$amountOT_18DAY = 0;}
            if(isset($OT_19DAY[$count]) <> false){$amountOT_19DAY = $OT_19DAY[$count];}else{$amountOT_19DAY = 0;}
            if(isset($OT_20DAY[$count]) <> false){$amountOT_20DAY = $OT_20DAY[$count];}else{$amountOT_20DAY = 0;}
            if(isset($OT_21DAY[$count]) <> false){$amountOT_21DAY = $OT_21DAY[$count];}else{$amountOT_21DAY = 0;}
            if(isset($OT_22DAY[$count]) <> false){$amountOT_22DAY = $OT_22DAY[$count];}else{$amountOT_22DAY = 0;}
            if(isset($OT_23DAY[$count]) <> false){$amountOT_23DAY = $OT_23DAY[$count];}else{$amountOT_23DAY = 0;}
            if(isset($OT_24DAY[$count]) <> false){$amountOT_24DAY = $OT_24DAY[$count];}else{$amountOT_24DAY = 0;}
            if(isset($OT_25DAY[$count]) <> false){$amountOT_25DAY = $OT_25DAY[$count];}else{$amountOT_25DAY = 0;}
            if(isset($OT_26DAY[$count]) <> false){$amountOT_26DAY = $OT_26DAY[$count];}else{$amountOT_26DAY = 0;}
            if(isset($OT_27DAY[$count]) <> false){$amountOT_27DAY = $OT_27DAY[$count];}else{$amountOT_27DAY = 0;}
            if(isset($OT_28DAY[$count]) <> false){$amountOT_28DAY = $OT_28DAY[$count];}else{$amountOT_28DAY = 0;}
            if(isset($OT_29DAY[$count]) <> false){$amountOT_29DAY = $OT_29DAY[$count];}else{$amountOT_29DAY = 0;}
            if(isset($OT_30DAY[$count]) <> false){$amountOT_30DAY = $OT_30DAY[$count];}else{$amountOT_30DAY = 0;}
            if(isset($OT_31DAY[$count]) <> false){$amountOT_31DAY = $OT_31DAY[$count];}else{$amountOT_31DAY = 0;}
          
            $sumtotal = $amountOT_RATE * ($amountOT_1DAY +  $amountOT_2DAY+ $amountOT_3DAY+ $amountOT_4DAY+ $amountOT_5DAY+ $amountOT_6DAY+ $amountOT_7DAY+ $amountOT_8DAY+ $amountOT_9DAY + $amountOT_10DAY+ $amountOT_11DAY+ $amountOT_12DAY+ $amountOT_13DAY+ $amountOT_14DAY+ $amountOT_15DAY+ $amountOT_16DAY+ $amountOT_17DAY+ $amountOT_18DAY+ $amountOT_19DAY+ $amountOT_20DAY+ $amountOT_21DAY+ $amountOT_22DAY+ $amountOT_23DAY+ $amountOT_24DAY+ $amountOT_25DAY+ $amountOT_26DAY+ $amountOT_27DAY +$amountOT_28DAY+ $amountOT_29DAY+ $amountOT_30DAY+ $amountOT_31DAY);
            
           
            
            $add = new Otindexsub();
            $add->OT_PERSON_ID = $OT_PERSON_ID[$count];
            $add->OT_JOB = $OT_JOB[$count];
            $add->OT_INDEX_ID = $idrefot;
            $add->OT_RATE = $amountOT_RATE;
            $add->OT_1DAY = $amountOT_1DAY;
            $add->OT_2DAY = $amountOT_2DAY;
            $add->OT_3DAY = $amountOT_3DAY;
            $add->OT_4DAY = $amountOT_4DAY;
            $add->OT_5DAY = $amountOT_5DAY;
            $add->OT_6DAY = $amountOT_6DAY;
            $add->OT_7DAY = $amountOT_7DAY;
            $add->OT_8DAY = $amountOT_8DAY;
            $add->OT_9DAY = $amountOT_9DAY;
            $add->OT_10DAY = $amountOT_10DAY;
            $add->OT_11DAY = $amountOT_11DAY;
            $add->OT_12DAY = $amountOT_12DAY;
            $add->OT_13DAY = $amountOT_13DAY;
            $add->OT_14DAY = $amountOT_14DAY;
            $add->OT_15DAY = $amountOT_15DAY;
            $add->OT_16DAY = $amountOT_16DAY;
            $add->OT_17DAY = $amountOT_17DAY;
            $add->OT_18DAY = $amountOT_18DAY;
            $add->OT_19DAY = $amountOT_19DAY;
            $add->OT_20DAY = $amountOT_20DAY;
            $add->OT_21DAY = $amountOT_21DAY;
            $add->OT_22DAY = $amountOT_22DAY;
            $add->OT_23DAY = $amountOT_23DAY;
            $add->OT_24DAY = $amountOT_24DAY;
            $add->OT_25DAY = $amountOT_25DAY;
            $add->OT_26DAY = $amountOT_26DAY;
            $add->OT_27DAY = $amountOT_27DAY;
            $add->OT_28DAY = $amountOT_28DAY;
            $add->OT_29DAY = $amountOT_29DAY;
            $add->OT_30DAY = $amountOT_30DAY;
            $add->OT_31DAY = $amountOT_31DAY;
            $add->OT_SUM   = $sumtotal;
            $add->save(); 

         }

        }

        $infomaountsum = DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$idrefot)->count();
        $infobudgetsum = DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$idrefot)->sum('OT_SUM');
        
        $update = Otindex::find($idrefot);
        $update->OT_AMOUNT_PERSON = $infomaountsum;
        $update->OT_BUGGET_SUM = $infobudgetsum;
        $update->save(); 

        
         return redirect()->route('ot.iduser',['iduser'=>$idusersave]);

}

  



function selectoper(Request $request)
{
  

     $idfodep = $request->get('idfodep');
  
  function Monththai($strtime)
  {
    if($strtime == '1'){
        $month = 'มกราคม';
    }else if($strtime == '2'){
        $month = 'กุมภาพันธ์';
    }else if($strtime == '3'){
        $month = 'มีนาคม';
    }else if($strtime == '4'){
        $month = 'เมษายน';
    }else if($strtime == '5'){
        $month = 'พฤษภาคม';
    }else if($strtime == '6'){
        $month = 'มิถุนายน';
    }else if($strtime == '7'){
        $month = 'กรกฎาคม';
    }else if($strtime == '8'){
        $month = 'สิงหาคม';
    }else if($strtime == '9'){
        $month = 'กันยายน';
    }else if($strtime == '10'){
        $month = 'ตุลาคม';
    }else if($strtime == '11'){
        $month = 'พฤศจิกายน';
    }else if($strtime == '12'){
        $month = 'ธันวาคม';
    }else{
        $month = '';
    }

    return $month;
    }

    function Yearthai($strtime)
    {
      $year = $strtime+543;
      return $year;
    }



    $operateindexs = DB::table('operate_index')
    ->leftJoin('operate_status','operate_index.OPERATE_STATUS','=','operate_status.OPERATE_STATUS_CODE')
    ->leftJoin('hrd_department_sub_sub','operate_index.OPERATE_DEPARTMENT_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    ->leftJoin('operate_type','operate_type.OPERATE_TYPE_ID','=','operate_index.OPERATE_TYPE')
    ->where('operate_index.OPERATE_DEPARTMENT_ID','=',$idfodep)
    ->get();

    $output ='
    <table  class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
  
    <thead style="background-color: #FFEBCD;">
        <tr>
             <td style="text-align: center;border: 1px solid black;" width="8%">สถานะ</td>
             <td style="text-align: center;border: 1px solid black;" width="15%">ประจำเดือน</td>
             <td style="text-align: center;border: 1px solid black;" width="15%">ประจำปี</td>
            <td style="text-align: center;border: 1px solid black;" >หน่วยงาน</td>
            <td style="text-align: center;border: 1px solid black;" >ผู้จัดเวร</td>
            <td style="text-align: center;border: 1px solid black;" >ประเภทเวร</td>
            <td style="text-align: center;border: 1px solid black;" width="10%">เลือก</td>
        </tr>
    </thead>
    <tbody id="myTable">';
  

    $number = 0; 
    foreach ($operateindexs  as $operateindex){
    $number++;
                $status =  $operateindex->OPERATE_STATUS;

                if( $status === 'Pending'){
                   $statuscol =  "badge badge-danger";

               }else if($status === 'Approve'){
                  $statuscol =  "badge badge-warning";

               }else if($status === 'Verify'){
                   $statuscol =  "badge badge-info";
               }else if($status === 'Allow'){
                   $statuscol =  "badge badge-success";
               }else{
                   $statuscol =  "badge badge-secondary";
               }

  
        $output.='  <tr height="20">
        <td align="center" style="border: 1px solid black;"><span
                class="'.$statuscol.'">'.$operateindex->OPERATE_STATUS_NAME.'</span></td>
        <td class="text-font" style="text-align: center;border: 1px solid black;">
            '.Monththai($operateindex->OPERATE_INDEX_MONTH).'</td>
        <td class="text-font" style="text-align: center;border: 1px solid black;" >
            '.Yearthai($operateindex->OPERATE_INDEX_YEAR).'</td>
        <td class="text-font text-pedding" style="border: 1px solid black;">'.$operateindex->HR_DEPARTMENT_SUB_SUB_NAME.'</td>
        <td class="text-font text-pedding" style="border: 1px solid black;">'.$operateindex->OPERATE_ORGANIZER_NAME.'</td>
        <td class="text-font text-pedding" style="border: 1px solid black;">'.$operateindex->OPERATE_TYPE_NAME.'</td>
        <td class="text-font" style="border: 1px solid black;" align="center" ><button type="button" class="btn btn-hero-sm btn-hero-info"  style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="selectoperreq('.$operateindex->OPERATE_INDEX_ID.')"><i class="far fa-check-circle"></i> เลือก</button></td> 
        </tr>';
        }
    $output.='</tbody>
    </table>';
  
  
   echo $output;
}


function detailoperofot(Request $request)
{
 

     $idcpreot = $request->get('idcpreot');
     $number = 0;

                  
    $PERSONALLs =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('HR_STATUS_ID','=',1)
    ->get();

    $operats = DB::table('operate_job')->get();
  
    $infomation_activitys = DB::table('operate_activity')
    ->where('OPERATE_ACTIVITY_INDEX_ID','=',$idcpreot)
    ->get();

    $output ='';
    
    foreach ($infomation_activitys as $infomation_activity) {

        $txt_a = $infomation_activity->DATE_1.'|'.$infomation_activity->DATE_2.'|'.$infomation_activity->DATE_3.'|'.$infomation_activity->DATE_4.'|'.$infomation_activity->DATE_5.'|'.$infomation_activity->DATE_6.'|'.$infomation_activity->DATE_7.'|'.$infomation_activity->DATE_8.'|'.$infomation_activity->DATE_9.'|'.$infomation_activity->DATE_10.'|'.$infomation_activity->DATE_11.'|'.$infomation_activity->DATE_12.'|'.$infomation_activity->DATE_13.'|'.$infomation_activity->DATE_14.'|'.$infomation_activity->DATE_15.'|'.$infomation_activity->DATE_16.'|'.$infomation_activity->DATE_17.'|'.$infomation_activity->DATE_18.'|'.$infomation_activity->DATE_19.'|'.$infomation_activity->DATE_20.'|'.$infomation_activity->DATE_21.'|'.$infomation_activity->DATE_22.'|'.$infomation_activity->DATE_23.'|'.$infomation_activity->DATE_24.'|'.$infomation_activity->DATE_25.'|'.$infomation_activity->DATE_26.'|'.$infomation_activity->DATE_27.'|'.$infomation_activity->DATE_28.'|'.$infomation_activity->DATE_29.'|'.$infomation_activity->DATE_30.'|'.$infomation_activity->DATE_31;
        $data = explode("|", $txt_a);
        
        $n = array_count_values($data);
        arsort($n);
        
                    foreach ($n as $key => $value) {
                            if($key !== ''){

                                $inforate = DB::table('operate_job')->where('OPERATE_JOB_ID','=',$key)->first();
                                if($key == $infomation_activity->DATE_1){$d1 = '1';}else{$d1 = '0';}
                                if($key == $infomation_activity->DATE_2){$d2 = '1';}else{$d2 = '0';}
                                if($key == $infomation_activity->DATE_3){$d3 = '1';}else{$d3 = '0';}
                                if($key == $infomation_activity->DATE_4){$d4 = '1';}else{$d4 = '0';}
                                if($key == $infomation_activity->DATE_5){$d5 = '1';}else{$d5 = '0';}
                                if($key == $infomation_activity->DATE_6){$d6 = '1';}else{$d6 = '0';}
                                if($key == $infomation_activity->DATE_7){$d7 = '1';}else{$d7 = '0';}
                                if($key == $infomation_activity->DATE_8){$d8 = '1';}else{$d8 = '0';}
                                if($key == $infomation_activity->DATE_9){$d9 = '1';}else{$d9 = '0';}
                                if($key == $infomation_activity->DATE_10){$d10 = '1';}else{$d10 = '0';}
                                if($key == $infomation_activity->DATE_11){$d11 = '1';}else{$d11 = '0';}
                                if($key == $infomation_activity->DATE_12){$d12 = '1';}else{$d12 = '0';}
                                if($key == $infomation_activity->DATE_13){$d13 = '1';}else{$d13 = '0';}
                                if($key == $infomation_activity->DATE_14){$d14 = '1';}else{$d14 = '0';}
                                if($key == $infomation_activity->DATE_15){$d15 = '1';}else{$d15 = '0';}
                                if($key == $infomation_activity->DATE_16){$d16 = '1';}else{$d16 = '0';}
                                if($key == $infomation_activity->DATE_17){$d17 = '1';}else{$d17 = '0';}
                                if($key == $infomation_activity->DATE_18){$d18 = '1';}else{$d18 = '0';}
                                if($key == $infomation_activity->DATE_19){$d19 = '1';}else{$d19 = '0';}
                                if($key == $infomation_activity->DATE_20){$d20 = '1';}else{$d20 = '0';}
                                if($key == $infomation_activity->DATE_21){$d21 = '1';}else{$d21 = '0';}
                                if($key == $infomation_activity->DATE_22){$d22 = '1';}else{$d22 = '0';}
                                if($key == $infomation_activity->DATE_23){$d23 = '1';}else{$d23 = '0';}
                                if($key == $infomation_activity->DATE_24){$d24 = '1';}else{$d24 = '0';}
                                if($key == $infomation_activity->DATE_25){$d25 = '1';}else{$d25 = '0';}
                                if($key == $infomation_activity->DATE_26){$d26 = '1';}else{$d26 = '0';}
                                if($key == $infomation_activity->DATE_27){$d27 = '1';}else{$d27 = '0';}
                                if($key == $infomation_activity->DATE_28){$d28 = '1';}else{$d28 = '0';}
                                if($key == $infomation_activity->DATE_29){$d29 = '1';}else{$d29 = '0';}
                                if($key == $infomation_activity->DATE_30){$d30 = '1';}else{$d30 = '0';}
                                if($key == $infomation_activity->DATE_31){$d31 = '1';}else{$d31 = '0';}
                                $number++;
                                $output.='
                                <tr>
                                <td class="text-font" align="center" >'. $number.'</td>
                                <td class="text-font" align="center" >  
                                <select name="OT_PERSON_ID[]" id="OT_PERSON_ID'. $number.'" class="form-control input-lg js-example-basic-single" style=" font-family: Kanit, sans-serif;" >
                                <option value="">--กรุณาเลือกบุคคล--</option>';
                            
                                foreach ($PERSONALLs as $PERSONALL) {
                                    
                                    if( $PERSONALL ->ID == $infomation_activity->OPERATE_ACTIVITY_PERSON_ID){
                                        $output.='<option value="'.$PERSONALL ->ID.'" selected>'.$PERSONALL->HR_FNAME.' '.$PERSONALL->HR_LNAME.'</option>';
                                    
                                    }else{
                                        $output.='<option value="'.$PERSONALL ->ID.'">'.$PERSONALL->HR_FNAME.' '.$PERSONALL->HR_LNAME.'</option>';
                                    
                                    }
                                    
                                  
                                
                                    }
                            
                                $output.='</select> 
                                </td>
                                <td class="text-font" align="center" >
                                <select name="OT_JOB[]" id="่OT_JOB'.$number.'" class="form-control input-lg js-example-basic-single" style=" font-family: Kanit, sans-serif;" >
                                <option value="">--เวร--</option>';  
                            
                                 foreach ($operats as $operat) {
                                      if($key == $operat ->OPERATE_JOB_ID){
                                        $output.='<option value="'.$operat ->OPERATE_JOB_ID.'" selected>'.$operat->OPERATE_JOB_NAME.'</option>';
                                      }else{
                                        $output.='<option value="'.$operat ->OPERATE_JOB_ID.'">'.$operat->OPERATE_JOB_NAME.'</option>';
                                      }
                                 
                                    }
                            
                                $output.='</select>     
                                </td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_RATE'.$number.'" name="OT_RATE[]" style="font-size: 13px;width: 100px;" value="'.$inforate->OPERATE_JOB_MONEY.'"></td>
                                
                                <td class="text-font" align="center" ><input type="text"  id="่OT_1DAY'.$number.'" name="่OT_1DAY[]" style="font-size: 13px;width: 30px;" value="'.$d1.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_2DAY'.$number.'" name="OT_2DAY[]" style="font-size: 13px;width: 30px;" value="'.$d2.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_3DAY'.$number.'" name="่OT_3DAY[]" style="font-size: 13px;width: 30px;" value="'.$d3.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_4DAY'.$number.'" name="OT_4DAY[]" style="font-size: 13px;width: 30px;" value="'.$d4.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_5DAY'.$number.'" name="OT_5DAY[]" style="font-size: 13px;width: 30px;" value="'.$d5.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_6DAY'.$number.'" name="OT_6DAY[]" style="font-size: 13px;width: 30px;" value="'.$d6.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_7DAY'.$number.'" name="OT_7DAY[]" style="font-size: 13px;width: 30px;" value="'.$d7.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_8DAY'.$number.'" name="OT_8DAY[]" style="font-size: 13px;width: 30px;" value="'.$d8.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_9DAY'.$number.'" name="OT_9DAY[]" style="font-size: 13px;width: 30px;" value="'.$d9.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_10DAY'.$number.'" name="่OT_10DAY[]" style="font-size: 13px;width: 30px;" value="'.$d10.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_11DAY'.$number.'" name="OT_11DAY[]" style="font-size: 13px;width: 30px;" value="'.$d11.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_12DAY'.$number.'" name="OT_12DAY[]" style="font-size: 13px;width: 30px;" value="'.$d12.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_13DAY'.$number.'" name="OT_13DAY[]" style="font-size: 13px;width: 30px;" value="'.$d13.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_14DAY'.$number.'" name="OT_14DAY[]" style="font-size: 13px;width: 30px;" value="'.$d14.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_15DAY'.$number.'" name="OT_15DAY[]" style="font-size: 13px;width: 30px;" value="'.$d15.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_16DAY'.$number.'" name="OT_16DAY[]" style="font-size: 13px;width: 30px;" value="'.$d16.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_17DAY'.$number.'" name="OT_17DAY[]" style="font-size: 13px;width: 30px;" value="'.$d17.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_18DAY'.$number.'" name="OT_18DAY[]" style="font-size: 13px;width: 30px;" value="'.$d18.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_19DAY'.$number.'" name="OT_19DAY[]" style="font-size: 13px;width: 30px;" value="'.$d19.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_20DAY'.$number.'" name="OT_20DAY[]" style="font-size: 13px;width: 30px;" value="'.$d20.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_21DAY'.$number.'" name="OT_21DAY[]" style="font-size: 13px;width: 30px;" value="'.$d21.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_22DAY'.$number.'" name="OT_22DAY[]" style="font-size: 13px;width: 30px;" value="'.$d22.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_23DAY'.$number.'" name="OT_23DAY[]" style="font-size: 13px;width: 30px;" value="'.$d23.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_24DAY'.$number.'" name="OT_24DAY[]" style="font-size: 13px;width: 30px;" value="'.$d24.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_25DAY'.$number.'" name="OT_25DAY[]" style="font-size: 13px;width: 30px;" value="'.$d25.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_26DAY'.$number.'" name="OT_26DAY[]" style="font-size: 13px;width: 30px;" value="'.$d26.'"></td>
                                <td class="text-font" align="center" ><input type="text"  id="่OT_27DAY'.$number.'" name="OT_27DAY[]" style="font-size: 13px;width: 30px;" value="'.$d27.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_28DAY'.$number.'" name="OT_28DAY[]" style="font-size: 13px;width: 30px;" value="'.$d28.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_29DAY'.$number.'" name="OT_29DAY[]" style="font-size: 13px;width: 30px;" value="'.$d29.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_30DAY'.$number.'" name="OT_30DAY[]" style="font-size: 13px;width: 30px;" value="'.$d30.'"></td> 
                                <td class="text-font" align="center" ><input type="text"  id="่OT_31DAY'.$number.'" name="OT_31DAY[]" style="font-size: 13px;width: 30px;" value="'.$d31.'"></td>             
                                <td style="text-align: center;"><a class="btn btn-danger remove" style="color:#FFFFFF;"><i class="fa fa-trash-alt"></i></a></td>
                                </tr>';



                            }   
                }    

            }
        
        
        
        echo $output;
}


 public function geotsetdetail_app(Request $request,$idref,$iduser){

     
     $add = Otindex::find($idref);
     $add->OT_STATUS  =  'APP';
     $add->save(); 


     return redirect()->route('ot.iduser',['iduser'=>$iduser]);

 }


 //------ประกาศคำสั่ง
function pdfcommand_1(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $info = DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->first();

    $infomaion_command = $info->OT_DETAIL;


    $pdf = PDF::loadView('general_ot.pdfcommand_1',[
        'infoorg' => $infoorg, 
        'infomaion_command' => $infomaion_command,
        
    ]);
    return @$pdf->stream();

}

function pdfcommand_2(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $info = DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->first();

    $infomaion_command = $info->OT_DETAIL;


    $pdf = PDF::loadView('general_ot.pdfcommand_2',[
        'infoorg' => $infoorg, 
        'infomaion_command' => $infomaion_command,
        
    ]);
    return @$pdf->stream();

}


function pdfpersonwork(Request $request,$idref)
{
    $infoorg = DB::table('info_org')->where('ORG_ID','=',1)
    ->leftJoin('hrd_person','hrd_person.ID','=','info_org.ORG_LEADER_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->first();

    $infoperson = DB::table('ot_index_sub')
    ->leftJoin('hrd_person','hrd_person.ID','=','ot_index_sub.OT_PERSON_ID')
    ->leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
    ->where('OT_JOB','=',$idref)->get();


    $pdf = PDF::loadView('general_ot.pdfpersonwork',[
        'infoorg' => $infoorg, 
        'infopersons' => $infoperson, 
    
        
    ]);
    return @$pdf->stream();

}

public function geot_savemessage_pdf()
 {    
   
     $pdf = PDF::loadView('general_ot.geot_savemessage_pdf');
    //  $pdf->setOptions([
    //      'mode' => 'utf-8',           
    //      'default_font_size' => 17,
    //      'defaultFont' => 'THSarabunNew'                       
    //      ]);
    //  $pdf->setPaper('a4', 'portrait');

   return @$pdf->stream();
 }



 public function otexcel(Request $request,$idref,$iduser)
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
    
                 
        $PERSONALL =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
        ->where('HR_STATUS_ID','=',1)
        ->get();
    
        $operat = DB::table('operate_job')->get();
    
        $hrdsubsub = DB::table('hrd_department_sub_sub')->get();
    
         $infomationot = DB::table('ot_index')->where('OT_INDEX_ID','=',$idref)->first();

         $infomationotsub =  DB::table('ot_index_sub')->where('OT_INDEX_ID','=',$idref)->get();

             
        return view('general_ot.otexcel',[
            'inforpersonuser' => $inforpersonuser,
            'inforpersonuserid' => $inforpersonuserid, 
            'hrdsubsubs' => $hrdsubsub,
            'operats' => $operat, 
            'PERSONALLs' => $PERSONALL, 
            'infomationot' => $infomationot, 
            'infomationotsubs' => $infomationotsub, 
            'idref' => $idref, 
            
        ]);
    }


    
  
public function geotsetdetail_com(Request $request,$idref,$iduser)
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

             
    $check = DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->count();
    
    $info_detail =  DB::table('ot_command')->where('OT_INDEX_ID','=',$idref)->first();
   if($info_detail <> '' && $info_detail <> null){
    $detail = $info_detail->OT_DETAIL;
   }else{
    $detail = '';
   }
    

         
    return view('general_ot.geotsetdetail_com',[
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid, 
        'idref' => $idref,
        'check' => $check, 
        'detail' => $detail,  
        
    ]);
}

    

    public function geotsetdetail_comupdate(Request $request)
    {

        $idrefot = $request->idrefot;
        $idusersave = $request->idusersave;

        $check = DB::table('ot_command')->where('OT_INDEX_ID','=',$idrefot)->count();

        if($check <> 0){

          $idnumber_detail =  DB::table('ot_command')->where('OT_INDEX_ID','=',$idrefot)->first();
          $idnumber =  $idnumber_detail->OT_COMMAND_ID;
            $addhead = Otcommand::find($idnumber); 
            $addhead->OT_INDEX_ID =  $idrefot;   
            $addhead->OT_DETAIL =  $request->OT_DETAIL;    
            $addhead->save(); 
        }else{

            $addhead = new Otcommand();
            $addhead->OT_INDEX_ID =  $idrefot;   
            $addhead->OT_DETAIL =  $request->OT_DETAIL;    
            $addhead->save();
        
     

        }

        
         return redirect()->route('ot.iduser',['iduser'=>$idusersave]);

}

}
