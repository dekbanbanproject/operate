<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Person;
use App\Models\Supplies;
use App\Models\Warehouserequest;
use App\Models\Warehouserequestsub;
use App\Models\Warehousetreasurypay;
use App\Models\Warehousetreasuryexportsub;
use PDF;

date_default_timezone_set("Asia/Bangkok");

class WarehouseController extends Controller
{

            public function dashboard(Request $request,$iduser)
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


                $count1 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->count();
                $count2 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('WAREHOUSE_STATUS','=','Approve')->count();
                $count3 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('WAREHOUSE_STATUS','=','Verify')->count();
                $count4 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('WAREHOUSE_STATUS','=','Allow')->count();

                $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }
                
                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                $year_id = $yearbudget;

                $year = $year_id - 543;

                $m1_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-01%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m2_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-02%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m3_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-03%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m4_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-04%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m5_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-05%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m6_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-06%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m7_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-07%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m8_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-08%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m9_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-09%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m10_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-10%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m11_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-11%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m12_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-12%')->sum('TREASURY_RECEIVE_SUB_VALUE');

                $m1_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-01%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m2_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-02%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m3_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-03%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m4_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-04%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m5_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-05%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m6_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-06%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m7_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-07%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m8_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-08%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m9_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-09%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m10_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-10%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m11_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-11%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m12_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-12%')->sum('TREASURY_EXPORT_SUB_VALUE');




                return view('general_warehouse.dashboard_genwarehouse',[
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'count1' => $count1,
                    'count2' => $count2,
                    'count3' => $count3,
                    'count4' => $count4,
                    'm1_1' => $m1_1,
            'm2_1' => $m2_1,
            'm3_1' => $m3_1,
            'm4_1' => $m4_1,
            'm5_1' => $m5_1,
            'm6_1' => $m6_1,
            'm7_1' => $m7_1,
            'm8_1' => $m8_1,
            'm9_1' => $m9_1,
            'm10_1' => $m10_1,
            'm11_1' => $m11_1,
            'm12_1' => $m12_1,
            'm1_2' => $m1_2,
            'm2_2' => $m2_2,
            'm3_2' => $m3_2,
            'm4_2' => $m4_2,
            'm5_2' => $m5_2,
            'm6_2' => $m6_2,
            'm7_2' => $m7_2,
            'm8_2' => $m8_2,
            'm9_2' => $m9_2,
            'm10_2' => $m10_2,
            'm11_2' => $m11_2,
            'm12_2' => $m12_2,
                    'budgets' =>  $budget,
                    'year_id'=>$year_id  
                ]);
            }



            public function dashboardsearch(Request $request,$iduser)
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

                  //=====================================================
                  $year_id = $request->STATUS_CODE;

                  $yearbudget = $year_id;

                $count1 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->count();
                $count2 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('WAREHOUSE_STATUS','=','Approve')->count();
                $count3 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('WAREHOUSE_STATUS','=','Verify')->count();
                $count4 = Warehouserequest::where('WAREHOUSE_DEP_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->where('WAREHOUSE_STATUS','=','Allow')->count();

           
                
                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
                $year_id = $yearbudget;

                $year = $year_id - 543;

                $m1_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-01%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m2_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-02%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m3_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-03%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m4_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-04%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m5_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-05%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m6_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-06%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m7_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-07%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m8_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-08%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m9_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-09%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m10_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-10%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m11_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-11%')->sum('TREASURY_RECEIVE_SUB_VALUE');
                $m12_1 = DB::table('warehouse_treasury_receive_sub')->where('created_at','like',$year.'-12%')->sum('TREASURY_RECEIVE_SUB_VALUE');

                $m1_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-01%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m2_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-02%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m3_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-03%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m4_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-04%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m5_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-05%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m6_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-06%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m7_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-07%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m8_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-08%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m9_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-09%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m10_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-10%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m11_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-11%')->sum('TREASURY_EXPORT_SUB_VALUE');
                $m12_2 = DB::table('warehouse_treasury_export_sub')->where('created_at','like',$year.'-12%')->sum('TREASURY_EXPORT_SUB_VALUE');




                return view('general_warehouse.dashboard_genwarehouse',[
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'count1' => $count1,
                    'count2' => $count2,
                    'count3' => $count3,
                    'count4' => $count4,
                    'm1_1' => $m1_1,
            'm2_1' => $m2_1,
            'm3_1' => $m3_1,
            'm4_1' => $m4_1,
            'm5_1' => $m5_1,
            'm6_1' => $m6_1,
            'm7_1' => $m7_1,
            'm8_1' => $m8_1,
            'm9_1' => $m9_1,
            'm10_1' => $m10_1,
            'm11_1' => $m11_1,
            'm12_1' => $m12_1,
            'm1_2' => $m1_2,
            'm2_2' => $m2_2,
            'm3_2' => $m3_2,
            'm4_2' => $m4_2,
            'm5_2' => $m5_2,
            'm6_2' => $m6_2,
            'm7_2' => $m7_2,
            'm8_2' => $m8_2,
            'm9_2' => $m9_2,
            'm10_2' => $m10_2,
            'm11_2' => $m11_2,
            'm12_2' => $m12_2,
                    'budgets' =>  $budget,
                    'year_id'=>$year_id  
                ]);
            }


//====================================================รายการสิ่งของคงคลังในหน่วยงาน

            public function infostockcard(Request $request,$iduser)
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


                $infowarehousetreasury= DB::table('warehouse_treasury')
                ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
                ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)    
                ->orderBy('TREASURY_ID', 'desc') 
                ->get();

                $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();

                $balance1  =  DB::table('warehouse_treasury_receive_sub')
                ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
                ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->sum('TREASURY_RECEIVE_SUB_VALUE');
       
       
                $balance2  =  DB::table('warehouse_treasury_export_sub')
                ->leftJoin('warehouse_treasury','warehouse_treasury_export_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
                ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                ->sum('TREASURY_EXPORT_SUB_VALUE');
           
                $balance = $balance1 - $balance2;

 
                $STATUS_CODE = '';

             
                $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }
            
                
                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
              
                 $info_sendstatus = DB::table('warehouse_request_status')->get();
        
                $displaydate_bigen = ($yearbudget-544).'-10-01';
                $displaydate_end = ($yearbudget-543).'-09-30';
                $status = '';
                $search = '';
                $year_id = $yearbudget;

                return view('general_warehouse.stockcard_genwarehouse',[
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'infowarehousetreasurys' => $infowarehousetreasury,
                    'suppliestypes' => $suppliestype,
                    'STATUS_CODE' => $STATUS_CODE,
                    'search' => $search,
                    'balance' => $balance,
                    'budgets' =>  $budget,
                    'displaydate_bigen'=> $displaydate_bigen,
                    'displaydate_end'=> $displaydate_end,
                    // 'status_check'=> $status,
                    'search'=> $search,
                    'year_id'=>$year_id, 
                ]);
            }

            public function infostockcardsearch(Request $request,$iduser)
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


                $STATUS_CODE = $request->STATUS_CODE;
                $search = $request->get('search');
                $datebigin = $request->get('DATE_BIGIN');
                $dateend = $request->get('DATE_END');
        
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
                                  
                    $from = date($displaydate_bigen);
                    $to = date($displaydate_end);


                
            if($STATUS_CODE == null){

                            $infowarehousetreasury= DB::table('warehouse_treasury')
                            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                            ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
                            ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                            ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)   
                            ->where(function($q) use ($search){
                                $q->where('TREASURY_CODE','like','%'.$search.'%');
                                $q->orwhere('TREASURY_NAME','like','%'.$search.'%');
                                $q->orwhere('SUP_UNIT_NAME','like','%'.$search.'%');
                        }) 
                            ->orderBy('TREASURY_ID', 'desc') 
                            ->get();

                            $balance1  =  DB::table('warehouse_treasury_receive_sub')
                            ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
                            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                            ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
                            ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                            ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)          
                            ->where(function($q) use ($search){
                                $q->where('warehouse_treasury.TREASURY_CODE','like','%'.$search.'%');
                                $q->orwhere('warehouse_treasury.TREASURY_NAME','like','%'.$search.'%');
                                $q->orwhere('supplies_unit_ref.SUP_UNIT_NAME','like','%'.$search.'%');
                        }) 
                        
                            ->sum('TREASURY_RECEIVE_SUB_VALUE');                
                
                            $balance2  =  DB::table('warehouse_treasury_export_sub')
                            ->leftJoin('warehouse_treasury','warehouse_treasury_export_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
                            ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID') 
                            ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
                            ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                            ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)                        
                            ->where(function($q) use ($search){
                                $q->where('warehouse_treasury.TREASURY_CODE','like','%'.$search.'%');
                                $q->orwhere('warehouse_treasury.TREASURY_NAME','like','%'.$search.'%');
                                $q->orwhere('supplies_unit_ref.SUP_UNIT_NAME','like','%'.$search.'%');
                        }) 
                            ->sum('TREASURY_EXPORT_SUB_VALUE');
                    
                            $balance = $balance1 - $balance2;                

            }else{

                
         
                        $infowarehousetreasury= DB::table('warehouse_treasury')
                        ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                        ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
                        ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                        ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                        ->where('supplies_type.SUP_TYPE_ID','=',$STATUS_CODE )   
                        ->where(function($q) use ($search){
                            $q->where('warehouse_treasury.TREASURY_CODE','like','%'.$search.'%');
                            $q->orwhere('warehouse_treasury.TREASURY_NAME','like','%'.$search.'%');
                            $q->orwhere('supplies_unit_ref.SUP_UNIT_NAME','like','%'.$search.'%');
                    }) 
                   
                    ->get();

                    

                        $balance1  =  DB::table('warehouse_treasury_receive_sub')
                        ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
                        ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID')
                        ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
                        ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
                        ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                        ->where('supplies_type.SUP_TYPE_ID','=',$STATUS_CODE )   
                        ->where(function($q) use ($search){
                            $q->where('warehouse_treasury.TREASURY_CODE','like','%'.$search.'%');
                            $q->orwhere('warehouse_treasury.TREASURY_NAME','like','%'.$search.'%');
                            $q->orwhere('supplies_unit_ref.SUP_UNIT_NAME','like','%'.$search.'%');
                    }) 
                   
                        ->sum('TREASURY_RECEIVE_SUB_VALUE');
            
            
                        $balance2  =  DB::table('warehouse_treasury_export_sub')
                        ->leftJoin('warehouse_treasury','warehouse_treasury_export_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
                        ->leftJoin('supplies_unit_ref','warehouse_treasury.TREASURY_UNIT','=','supplies_unit_ref.ID') 
                        ->leftJoin('supplies','warehouse_treasury.TREASURY_CODE','=','supplies.SUP_FSN_NUM')
                        ->leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')

                        ->where('TREASURY_TYPE','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
                        ->where('supplies_type.SUP_TYPE_ID','=',$STATUS_CODE )   
                        ->where(function($q) use ($search){
                            $q->where('warehouse_treasury.TREASURY_CODE','like','%'.$search.'%');
                            $q->orwhere('warehouse_treasury.TREASURY_NAME','like','%'.$search.'%');
                            $q->orwhere('supplies_unit_ref.SUP_UNIT_NAME','like','%'.$search.'%');
                    }) 
                    
                        ->sum('TREASURY_EXPORT_SUB_VALUE');
                
                        $balance = $balance1 - $balance2;
                

            }


                $suppliestype = DB::table('supplies_type')->where('SUP_TYPE_MASTER_ID','=',1)->get();
                $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }
            
                
                $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

                $displaydate_bigen = ($yearbudget-544).'-10-01';
                $displaydate_end = ($yearbudget-543).'-09-30';
              
               
                $year_id = $yearbudget;

                return view('general_warehouse.stockcard_genwarehouse',[
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'infowarehousetreasurys' => $infowarehousetreasury,
                    'suppliestypes' => $suppliestype,
                    'STATUS_CODE' => $STATUS_CODE,
                    'balance' => $balance,
                    'budgets' =>  $budget,

                    'displaydate_bigen'=> $displaydate_bigen,
                    'displaydate_end'=> $displaydate_end,
                    // 'status_check'=> $status,
                    'search'=> $search,
                    'year_id'=>$year_id, 
                ]);
            }

            public function infostockcardsub(Request $request,$id,$iduser)
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


                $storereceivesub= DB::table('warehouse_treasury_receive_sub')
                ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_sub.WAREHOUSE_REQUEST_SUB_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
                ->leftJoin('warehouse_request','warehouse_request_sub.WAREHOUSE_REQUEST_ID','=','warehouse_request.WAREHOUSE_ID')
                ->leftJoin('warehouse_disburse_cycle','warehouse_request.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
                ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
                ->where('TREASURY_ID','=',$id)
                ->orderBy ('TREASURY_RECEIVE_SUB_ID','asc')
                ->get();
                
        
        
                $storeexportsub= DB::table('warehouse_treasury_export_sub')
                ->leftJoin('warehouse_treasury_pay','warehouse_treasury_pay.TREASURT_PAY_ID','=','warehouse_treasury_export_sub.TREASURT_PAY_ID')      
                ->leftJoin('supplies_unit_ref','warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
                ->where('TREASURY_ID','=',$id)
                ->orderBy ('TREASURY_EXPORT_SUB_ID','desc')
                ->get();
        
                $warehousetreasury= DB::table('warehouse_treasury')->where('TREASURY_ID','=',$id)->first();
               
                $m_budget = date("m");
                if($m_budget>9){
                $yearbudget = date("Y")+544;
                }else{
                $yearbudget = date("Y")+543;
                }

                $displaydate_bigen = ($yearbudget-544).'-10-01';
                $displaydate_end = ($yearbudget-543).'-09-30';

                //=================================
                $balance1  =  DB::table('warehouse_treasury_receive_sub')->where('TREASURY_ID','=',$id)->sum('TREASURY_RECEIVE_SUB_VALUE');
                $balance2  =  DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$id)->sum('TREASURY_EXPORT_SUB_VALUE');
           
                $balance = $balance1 - $balance2;



                return view('general_warehouse.stockcardsub_genwarehouse',[
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'storereceivesubs' => $storereceivesub,
                    'storeexportsubs' => $storeexportsub,
                    'warehousetreasury' => $warehousetreasury,
                    'displaydate_bigen'=> $displaydate_bigen,
                    'displaydate_end'=> $displaydate_end,
                    'balance2'=> $balance2,
                    'balance'=> $balance,
                    'idtreasury' => $id
                ]);
            }
        
            public function infostockcardsubsearch(Request $request,$id,$iduser)
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

                $datebigin = $request->get('DATE_BIGIN');
                $dateend = $request->get('DATE_END');

             
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
              
             
              
                    $from = date($displaydate_bigen);
                    $to = date($displaydate_end);

                $storereceivesub= DB::table('warehouse_treasury_receive_sub')
                ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_sub.WAREHOUSE_REQUEST_SUB_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
                ->leftJoin('warehouse_request','warehouse_request_sub.WAREHOUSE_REQUEST_ID','=','warehouse_request.WAREHOUSE_ID')
                ->leftJoin('warehouse_disburse_cycle','warehouse_request.WAREHOUSE_TYPE_CYCLE','=','warehouse_disburse_cycle.ID_CYCLE')
                ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
                ->WhereBetween('TREASURY_RECEIVE_SUB_GEN_DATE',[$from,$to])
                ->where('TREASURY_ID','=',$id)
                ->orderBy ('TREASURY_RECEIVE_SUB_ID','asc')
                ->get();
                
                $storeexportsub= DB::table('warehouse_treasury_export_sub')
                ->leftJoin('warehouse_treasury_pay','warehouse_treasury_pay.TREASURT_PAY_ID','=','warehouse_treasury_export_sub.TREASURT_PAY_ID')      
                ->leftJoin('supplies_unit_ref','warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
                ->where('TREASURY_ID','=',$id)
                ->WhereBetween('TREASURT_PAY_DATE',[$from,$to])
                ->orderBy ('TREASURY_EXPORT_SUB_ID','desc')
                ->get();
        
                $warehousetreasury= DB::table('warehouse_treasury')->where('TREASURY_ID','=',$id)->first();
               

                //=============================================

                $balance1  =  DB::table('warehouse_treasury_receive_sub')->where('TREASURY_ID','=',$id)
                ->leftJoin('warehouse_request_sub','warehouse_treasury_receive_sub.WAREHOUSE_REQUEST_SUB_ID','=','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_ID')
                ->WhereBetween('TREASURY_RECEIVE_SUB_GEN_DATE',[$from,$to])
                ->sum('TREASURY_RECEIVE_SUB_VALUE');
                $balance2  =  DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$id)
                ->leftJoin('warehouse_treasury_pay','warehouse_treasury_pay.TREASURT_PAY_ID','=','warehouse_treasury_export_sub.TREASURT_PAY_ID')  
                ->WhereBetween('TREASURT_PAY_DATE',[$from,$to])
                ->sum('TREASURY_EXPORT_SUB_VALUE');
           
                $balance = $balance1 - $balance2;



                return view('general_warehouse.stockcardsub_genwarehouse',[
                    'inforpersonuserid' => $inforpersonuserid,
                    'inforpersonuser' => $inforpersonuser,
                    'storereceivesubs' => $storereceivesub,
                    'storeexportsubs' => $storeexportsub,
                    'warehousetreasury' => $warehousetreasury,
                    'displaydate_bigen'=> $displaydate_bigen,
                    'displaydate_end'=> $displaydate_end,
                    'balance2'=> $balance2,
                    'balance'=> $balance,
                    'idtreasury' => $id
                ]);
            }

//====================================================approve======================

        public function infoapp(Request $request,$iduser)
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

            $m_budget = date("m");
            if($m_budget>9){
            $yearbudget = date("Y")+544;
            }else{
            $yearbudget = date("Y")+543;
            }
        
            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $info_sendstatus = DB::table('supplies_request_status')->get();
            $displaydate_bigen = ($yearbudget-544).'-10-01';
            $displaydate_end = ($yearbudget-543).'-09-30';
            $status = 'Pending';
            $search = '';
            $year_id = $yearbudget;

            $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
            ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('WAREHOUSE_STATUS','=','Pending')
            ->orderBy ('WAREHOUSE_ID','desc')
            ->get();

            return view('general_warehouse.infowithdrawapp',[
                'inforpersonuserid' => $inforpersonuserid,
                'inforpersonuser' => $inforpersonuser,
                'info_sendstatuss' => $info_sendstatus,
                'displaydate_bigen'=> $displaydate_bigen,
                'displaydate_end'=> $displaydate_end,
                'status_check'=> $status,
                'search'=> $search,
                'year_id'=>$year_id,
                'budgets' =>  $budget,
                'inforwarehouserequests' => $inforwarehouserequest,
            
            ]);

        }

        public function infoappsearch(Request $request,$iduser)
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
            $yearbudget = $request->YEAR_ID;
            $datebigin = $request->get('DATE_BIGIN');
            $dateend = $request->get('DATE_END');

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
        

        

                $from = date($displaydate_bigen);
                $to = date($displaydate_end);

                if($status == null){

                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->orderBy ('WAREHOUSE_ID','desc')
                    ->get();


                }else{

        

                    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
                    ->leftJoin('hrd_department_sub_sub','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID','=','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('WAREHOUSE_STATUS','=',$status)
                    ->where(function($q) use ($search){
                        $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                        $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
                    })
                    ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
                    ->orderBy ('WAREHOUSE_ID','desc')
                    ->get();
                }
        

            $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
            $info_sendstatus = DB::table('supplies_request_status')->get();
            $year_id = $yearbudget;

        

    

            return view('general_warehouse.infowithdrawapp',[
                'inforpersonuserid' => $inforpersonuserid,
                'inforpersonuser' => $inforpersonuser,
                'info_sendstatuss' => $info_sendstatus,
                'displaydate_bigen'=> $displaydate_bigen,
                'displaydate_end'=> $displaydate_end,
                'status_check'=> $status,
                'search'=> $search,
                'year_id'=>$year_id,
                'budgets' =>  $budget,
                'inforwarehouserequests' => $inforwarehouserequest,
            
            ]);

        }
    
        public function infoappappupdate(Request $request)
        {
    
            $id = $request->ID;

            $check =  $request->SUBMIT;

            if($check == 'approved'){
            $statuscode = 'Approve';
            }else{
            $statuscode = 'Disapprove';
            }


            $updateapp = Warehouserequest::find($id);
            $updateapp->WAREHOUSE_AGREE_COMMENT = $request->WAREHOUSE_AGREE_COMMENT;
            $updateapp->WAREHOUSE_STATUS = $statuscode;

            $updateapp->WAREHOUSE_AGREE_HR_ID = $request->WAREHOUSE_AGREE_HR_ID;
            //----------------------------------
            $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->WAREHOUSE_AGREE_HR_ID)->first();

                $updateapp->WAREHOUSE_AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
                $updateapp->WAREHOUSE_AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;


                //----------------------------------



            //dd($educationedit);

            $updateapp->save();

                //
                //return redirect()->action('OtherController@infouserother');
                return redirect()->route('warehouse.infoapp',['iduser'=>  $request->WAREHOUSE_AGREE_HR_ID]);

        }

//====================================================lastapp======================
    public function infolastapp(Request $request,$iduser)
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

    

        $info_sendstatus = DB::table('supplies_request_status')->get();
            $displaydate_bigen = '';
            $displaydate_end = '';
            $status = '';
            $search = '';


            $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')
            ->get();

        return view('general_warehouse.infowithdrawlastapp',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            
            'info_sendstatuss' => $info_sendstatus,
                'displaydate_bigen'=> $displaydate_bigen,
                'displaydate_end'=> $displaydate_end,
                'status_check'=> $status,
                'search'=> $search,
                'inforwarehouserequests' => $inforwarehouserequest,
        ]);

    }

    function detailappall(Request $request)
    {




    $id = $request->get('id');

    $detail = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$id)->first();

    $detailperson = DB::table('hrd_person')->where('ID','=',$detail->WAREHOUSE_SAVE_HR_ID)->first();

    $output ='
    <div class="row push" style="font-family: \'Kanit\', sans-serif;">
    <input type="hidden"  name="ID" value="'.$id.'"/>
    <div class="col-sm-10">
    <div class="row">

    <div class="col-sm-2">
        <div class="form-group">
        <label >ลงวันที่ :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group" >
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.DateThai($detail -> WAREHOUSE_DATE_WANT).'</h1>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
        <label >เพื่อจัดซื้อ/ซ่อมแซม  :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> WAREHOUSE_REQUEST_FOR.'</h1>
        </div>
    </div>

    </div>

    <div class="row">

    <div class="col-sm-2">
        <div class="form-group">
        <label >ผู้แจ้งขอซื้อ/ขอจ้าง :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group" >
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detail -> WAREHOUSE_SAVE_HR_NAME.'</h1>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
        <label >หน่วยงานที่ร้องขอ  :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> WAREHOUSE_SAVE_HR_DEP_SUB_NAME.'</h1>
        </div>
    </div>

    </div>


    <div class="row">

    <div class="col-sm-2">
        <div class="form-group">
        <label >เบอร์โทร :</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group" >
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;">'.$detailperson -> HR_PHONE.'</h1>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
        <label >เบอร์โทรหน่วยงาน:</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
        <h1 style="text-align: left;font-family: \'Kanit\', sans-serif; font-size:10px;font-size: 1.0rem;font-weight:normal;color:#778899;" >'.$detail -> WAREHOUSE_DEP_SUB_SUB_PHONE.'</h1>
        </div>
    </div>


        </div>
        </div>

        <div class="col-sm-2">
                
        <div class="form-group">
        <img src="data:image/png;base64,'. chunk_split(base64_encode($detailperson->HR_IMAGE)) .'"  height="100px" width="100px"/>

        </div>

        </div>

        </div>
        ';

        $detail_subs_sum = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');

        $output.=' 
        <div align="right">จำนวนเงินรวม '.number_format($detail_subs_sum,2).'  บาท</div>
        <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
        <thead style="background-color: #FFEBCD;">
            <tr height="40">
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">ลำดับ</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">รายละเอียด</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">จำนวนเบิก</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">จำนวนจ่าย</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">หน่วย</th>
            

            </tr >
        </thead>
        <tbody>     ';

            $detail_subs = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)
            ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
            ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
            ->get();

            $count = 1;
            foreach ($detail_subs as $detailsub){
            $output.='  <tr height="20">
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$count.'</td>
            <td class="text-font text-pedding" style="border: 1px solid black;" >'.$detailsub->SUP_NAME.'</td>
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->WAREHOUSE_REQUEST_SUB_AMOUNT.'</td>
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY.'</td>
            <td class="text-font" align="center" style="border: 1px solid black;" >'.$detailsub->SUP_UNIT_NAME.'</td>
            
            </tr>';

            $count++;
            }



            $output.=' </tbody>
            </table><br>
            <label style="float:left;">ความเห็นผู้เห็นชอบ</label><br>
            <B style="float:left;">'.$detail -> WAREHOUSE_AGREE_COMMENT.'</B><br>
            <B style="float:left;">ผู้เห็นชอบ  '.$detail -> WAREHOUSE_AGREE_HR_NAME.'</B><br><br>   
            <B style="float:left;">ผู้ตรวจสอบ  '.$detail -> WAREHOUSE_USER_CONFIRM_CHECK_NAME.'</B><br><br>   

            ';

            echo $output;


    }



//====================================================ขอเบิกวัสดุ =================================================

public function infowithdrawindex(Request $request,$iduser)
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

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

      $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
      ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
      ->where('WAREHOUSE_DEP_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
      ->orwhere('WAREHOUSE_SAVE_HR_ID','=', $iduser)
      ->orderBy('WAREHOUSE_ID', 'desc')
      ->get();

      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

      $info_sendstatus = DB::table('warehouse_request_status')->get();

      $displaydate_bigen = ($yearbudget-544).'-10-01';
      $displaydate_end = ($yearbudget-543).'-09-30';
      $status = '';
      $search = '';
      $year_id = $yearbudget;

    return view('general_warehouse.infowithdrawindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforwarehouserequests' => $inforwarehouserequest,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 

    ]);

}


public function infowithdrawindexsearch(Request $request,$iduser)
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
    $yearbudget = $request->YEAR_ID;
    $datebigin = $request->get('DATE_BIGIN');
    $dateend = $request->get('DATE_END');

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


  

        $from = date($displaydate_bigen);
        $to = date($displaydate_end);

        if($status == null){

   

            $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
            ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
            ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
            ->where('WAREHOUSE_DEP_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
            ->orwhere('WAREHOUSE_SAVE_HR_ID','=', $iduser)
            ->where(function($q) use ($search){
                $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                $q->orwhere('INVEN_NAME','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
            ->orderBy('WAREHOUSE_ID', 'desc')
            ->get();


        }else{

            $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
            ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
            ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
            ->where('WAREHOUSE_DEP_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
            ->orwhere('WAREHOUSE_SAVE_HR_ID','=', $iduser)
            ->where('WAREHOUSE_STATUS','=', $status)
            ->where(function($q) use ($search){
                $q->where('WAREHOUSE_REQUEST_CODE','like','%'.$search.'%');
                $q->orwhere('WAREHOUSE_REQUEST_BUY_COMMENT','like','%'.$search.'%');
                $q->orwhere('INVEN_NAME','like','%'.$search.'%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME','like','%'.$search.'%');
                $q->orwhere('WAREHOUSE_SAVE_HR_NAME','like','%'.$search.'%');
            })
            ->WhereBetween('WAREHOUSE_DATE_WANT',[$from,$to])
            ->orderBy('WAREHOUSE_ID', 'desc')
            ->get();
         
        }


      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
      $info_sendstatus = DB::table('warehouse_request_status')->get();
      $year_id = $yearbudget;

    return view('general_warehouse.infowithdrawindex',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforwarehouserequests' => $inforwarehouserequest,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 

    ]);

}


public function infowithdrawindex_add(Request $request,$iduser)
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


    $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();

    $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

    $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();

    $orgname = DB::table('info_org')->first();

    //dd($orgname->ORG_NAME);

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $infosupplies= Supplies::leftJoin('supplies_type','supplies.SUP_TYPE_ID','=','supplies_type.SUP_TYPE_ID')
    ->leftJoin('supplies_type_kind','supplies.SUP_TYPE_KIND_ID','=','supplies_type_kind.SUP_TYPE_KIND_ID')
    ->where('supplies_type_kind.SUP_TYPE_MASTER_ID','=',1)
    ->orderBy('ID', 'desc') 
    ->get();

    $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

    $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $infostore = DB::table('supplies_inven')->where('ACTIVE','=','True')->get();

    $smallhos = DB::table('warehouse_smallhos')->get();

    $headdepartmentsubsub = DB::table('hrd_department_sub_sub')->where('HR_DEPARTMENT_SUB_SUB_ID','=',$inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)->first();

    return view('general_warehouse.infowithdrawindex_add',[
        'budgets' => $budget,
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'suppliestypes' => $suppliestype,
        'pessonalls' => $pessonall,
        'infosuppliess' => $infosupplies, 
        'departmentsubsubs' => $departmentsubsub,
        'infosuppliesunitrefs' => $infosuppliesunitref, 
        'orgname' => $orgname->ORG_NAME,
        'year_id' => $yearbudget,
        'infostores' => $infostore,
        'smallhoss' => $smallhos,
        'headdepartmentsubsub' => $headdepartmentsubsub,

    ]);

}


public function saveinforequestwithdrawindex(Request $request)
{

         $DATEWANT = $request->WAREHOUSE_DATE_WANT;

// dd($DATEWANT);

         if($DATEWANT != ''){
            $DAY = Carbon::createFromFormat('d/m/Y', $DATEWANT)->format('Y-m-d');
            $date_arrary_st=explode("-",$DAY);
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

        //=========================

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

   $maxnumber = DB::table('warehouse_request')->where('WAREHOUSE_BUDGET_YEAR','=',$yearbudget)->max('WAREHOUSE_ID');  

   if($maxnumber != '' ||  $maxnumber != null){
       
       $refmax = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$maxnumber)->first();  

     

       if($refmax->WAREHOUSE_REQUEST_CODE != '' ||  $refmax->WAREHOUSE_REQUEST_CODE != null){
           $maxref = substr($refmax->WAREHOUSE_REQUEST_CODE, -4)+1;
        }else{
           $maxref = 1;
        }

       $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
  
   }else{
       
       $ref = '0001';
   }


   $y = substr($yearbudget, -2);
  

$refnumber ='RE-'.$y.''.$ref;

//==========================

     $infocheck =  Warehouserequest::where('WAREHOUSE_ID','=',$maxnumber)->first();

 
  
   if($DATEWANT == $infocheck->WAREHOUSE_DATE_WANT && $request->WAREHOUSE_DEP_SUB_SUB_ID == $infocheck->WAREHOUSE_DEP_SUB_SUB_ID && $request->WAREHOUSE_SAVE_HR_ID == $infocheck->WAREHOUSE_SAVE_HR_ID  && $request->WAREHOUSE_REQUEST_BUY_COMMENT == $infocheck->WAREHOUSE_REQUEST_BUY_COMMENT  && $request->WAREHOUSE_INVEN_ID == $infocheck->WAREHOUSE_INVEN_ID ){
   }else{

        $addinforequest = new Warehouserequest();

        $addinforequest->WAREHOUSE_REQUEST_CODE = $refnumber;
        $addinforequest->WAREHOUSE_DATE_WANT = $DATEWANT;
        $addinforequest->WAREHOUSE_DATE_TIME_SAVE = date('Y-m-d H:i:s');

        $addinforequest->WAREHOUSE_DEP_SUB_SUB_ID = $request->WAREHOUSE_DEP_SUB_SUB_ID;
    
        $addinforequest->WAREHOUSE_SAVE_HR_ID = $request->WAREHOUSE_SAVE_HR_ID;

          //----------------------------------
          $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
          ->where('hrd_person.ID','=',$request->WAREHOUSE_SAVE_HR_ID)->first();

                $addinforequest->WAREHOUSE_SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
                $addinforequest->WAREHOUSE_SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
                $addinforequest->WAREHOUSE_SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

           //----------------------------------

                $addinforequest->WAREHOUSE_AGREE_HR_ID = $request->WAREHOUSE_AGREE_HR_ID;

             //----------------------------------
             $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->WAREHOUSE_AGREE_HR_ID)->first();

                $addinforequest->WAREHOUSE_AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
                $addinforequest->WAREHOUSE_AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

              //----------------------------------

                $addinforequest->WAREHOUSE_REQUEST_BUY_COMMENT = $request->WAREHOUSE_REQUEST_BUY_COMMENT;

                $addinforequest->WAREHOUSE_INVEN_ID = $request->WAREHOUSE_INVEN_ID;

                $addinforequest->WAREHOUSE_STATUS = 'Pending';

                $addinforequest->WAREHOUSE_BUDGET_YEAR = $request->WAREHOUSE_BUDGET_YEAR;

                $addinforequest->WAREHOUSE_SMALLHOS = $request->WAREHOUSE_SMALLHOS;
     
                $addinforequest->save();

                $WAREHOUSE_REQUEST_ID = Warehouserequest::max('WAREHOUSE_ID');

        if($request->WAREHOUSE_REQUEST_SUB_AMOUNT != '' || $request->WAREHOUSE_REQUEST_SUB_AMOUNT != null){

            $WAREHOUSE_REQUEST_SUB_DETAIL_ID = $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID;
            $WAREHOUSE_REQUEST_SUB_AMOUNT = $request->WAREHOUSE_REQUEST_SUB_AMOUNT;
            $WAREHOUSE_REQUEST_SUB_UNIT = $request->WAREHOUSE_REQUEST_SUB_UNIT;

            $number =count($WAREHOUSE_REQUEST_SUB_DETAIL_ID);
            $count = 0;
            for($count = 0; $count< $number; $count++)
            {
               $add = new Warehouserequestsub();
               $add->WAREHOUSE_REQUEST_ID = $WAREHOUSE_REQUEST_ID;
               $add->WAREHOUSE_REQUEST_SUB_DETAIL_ID = $WAREHOUSE_REQUEST_SUB_DETAIL_ID[$count];
               $add->WAREHOUSE_REQUEST_SUB_AMOUNT = $WAREHOUSE_REQUEST_SUB_AMOUNT[$count];
               $add->WAREHOUSE_REQUEST_SUB_UNIT = $WAREHOUSE_REQUEST_SUB_UNIT[$count];
               $add->save();
            }
        }
        
        
   }

        return redirect()->route('warehouse.infowithdrawindex',[
            'iduser' => $request->WAREHOUSE_SAVE_HR_ID,

        ]);
}

public function infowithdrawindex_edit(Request $request,$id,$iduser)
{
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
    $idu = $inforpersonuserid->ID;

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


    $suppliestype = DB::table('supplies_type')->where('ACTIVE','=','True')->get();

    $pessonall = Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')->orderBy('hrd_person.HR_FNAME', 'asc')->get();

    $departmentsubsub = DB::table('hrd_department_sub_sub')->where('ACTIVE','=','True')->get();

    $orgname = DB::table('info_org')->first();

    $m_budget = date("m");
    if($m_budget>9){
    $yearbudget = date("Y")+544;
    }else{
    $yearbudget = date("Y")+543;
    }

    $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
    ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
    ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')
    // ->where('WAREHOUSE_DEP_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
    ->where('warehouse_request.WAREHOUSE_ID','=', $id)
    ->first();


    $infosuppliesunitref = DB::table('supplies_unit_ref')->get();

    $budget = DB::table('budget_year')->where('ACTIVE','=','True')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

    $infostore = DB::table('supplies_inven')->where('ACTIVE','=','True')->get();

    $countcheck = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)->count();

    $inforequestsub = DB::table('warehouse_request_sub')->where('WAREHOUSE_REQUEST_ID','=',$id)
    ->leftJoin('warehouse_store','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','warehouse_store.STORE_SUP_ID')
    ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID')
    ->get();
   
    $smallhos = DB::table('warehouse_smallhos')->get();
    
    return view('general_warehouse.infowithdrawindex_edit',[
        'budgets' => $budget,
        'inforpersonuser' => $inforpersonuser,
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'suppliestypes' => $suppliestype,
        'pessonalls' => $pessonall,
        'inforwarehouserequests' => $inforwarehouserequest, 
        'departmentsubsubs' => $departmentsubsub,
        'infosuppliesunitrefs' => $infosuppliesunitref, 
        'orgname' => $orgname->ORG_NAME,
        'year_id' => $yearbudget,
        'infostores' => $infostore,
        'countcheck' => $countcheck,
        'inforequestsubs' => $inforequestsub,
        'smallhoss' => $smallhos,


    ]);

}

public function infowithdrawindex_update(Request $request)
{

         $DATEWANT = $request->WAREHOUSE_DATE_WANT;

         if($DATEWANT != ''){
            $DAY = Carbon::createFromFormat('d/m/Y', $DATEWANT)->format('Y-m-d');
            $date_arrary_st=explode("-",$DAY);
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

        $id = $request->WAREHOUSE_ID;

        $update = Warehouserequest::find($id);

        $update->WAREHOUSE_REQUEST_CODE = $request->WAREHOUSE_REQUEST_CODE;
        $update->WAREHOUSE_DATE_WANT = $DATEWANT;
        $update->WAREHOUSE_DATE_TIME_SAVE = date('Y-m-d H:i:s');

        $update->WAREHOUSE_DEP_SUB_SUB_ID = $request->WAREHOUSE_DEP_SUB_SUB_ID;
    
        $update->WAREHOUSE_SAVE_HR_ID = $request->WAREHOUSE_SAVE_HR_ID;

          //----------------------------------
          $SAVEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
          ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
          ->leftJoin('hrd_department_sub','hrd_person.HR_DEPARTMENT_SUB_ID','=','hrd_department_sub.HR_DEPARTMENT_SUB_ID')
          ->where('hrd_person.ID','=',$request->WAREHOUSE_SAVE_HR_ID)->first();

                $update->WAREHOUSE_SAVE_HR_NAME = $SAVEHR->HR_PREFIX_NAME.''.$SAVEHR->HR_FNAME.' '.$SAVEHR->HR_LNAME;
                $update->WAREHOUSE_SAVE_HR_POSITION = $SAVEHR->HR_POSITION_NAME;
                $update->WAREHOUSE_SAVE_HR_DEP_SUB_NAME = $SAVEHR->HR_DEPARTMENT_SUB_NAME;

           //----------------------------------

                $update->WAREHOUSE_AGREE_HR_ID = $request->WAREHOUSE_AGREE_HR_ID;

             //----------------------------------
             $AGREEHR =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
             ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
             ->where('hrd_person.ID','=',$request->WAREHOUSE_AGREE_HR_ID)->first();

                $update->WAREHOUSE_AGREE_HR_NAME = $AGREEHR->HR_PREFIX_NAME.''.$AGREEHR->HR_FNAME.' '.$AGREEHR->HR_LNAME;
                $update->WAREHOUSE_AGREE_HR_POSITION = $AGREEHR->HR_POSITION_NAME;

              //----------------------------------

                $update->WAREHOUSE_REQUEST_BUY_COMMENT = $request->WAREHOUSE_REQUEST_BUY_COMMENT;

                $update->WAREHOUSE_INVEN_ID = $request->WAREHOUSE_INVEN_ID;

                $update->WAREHOUSE_STATUS = 'Pending';

                $update->WAREHOUSE_BUDGET_YEAR = $request->WAREHOUSE_BUDGET_YEAR;
                $update->WAREHOUSE_SMALLHOS = $request->WAREHOUSE_SMALLHOS;

                $update->save();

              
                Warehouserequestsub::where('WAREHOUSE_REQUEST_ID','=',$id)->delete(); 

                if($request->WAREHOUSE_REQUEST_SUB_DETAIL_ID != '' || $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID != null){

                    $WAREHOUSE_REQUEST_SUB_DETAIL_ID = $request->WAREHOUSE_REQUEST_SUB_DETAIL_ID;
                    $WAREHOUSE_REQUEST_SUB_AMOUNT = $request->WAREHOUSE_REQUEST_SUB_AMOUNT;
                    $WAREHOUSE_REQUEST_SUB_UNIT = $request->WAREHOUSE_REQUEST_SUB_UNIT;
                    $WAREHOUSE_REQUEST_SUB_PRICE = $request->WAREHOUSE_REQUEST_SUB_PRICE;
                    $WAREHOUSE_REQUEST_SUB_REMARK = $request->WAREHOUSE_REQUEST_SUB_REMARK;
        
                    $number =count($WAREHOUSE_REQUEST_SUB_DETAIL_ID);
                    $count = 0;
                    for($count = 0; $count< $number; $count++)
                    {
                       $add = new Warehouserequestsub();
                       $add->WAREHOUSE_REQUEST_ID = $id;
                       $add->WAREHOUSE_REQUEST_SUB_DETAIL_ID = $WAREHOUSE_REQUEST_SUB_DETAIL_ID[$count];
                       $add->WAREHOUSE_REQUEST_SUB_AMOUNT = $WAREHOUSE_REQUEST_SUB_AMOUNT[$count];
                       $add->WAREHOUSE_REQUEST_SUB_UNIT = $WAREHOUSE_REQUEST_SUB_UNIT[$count];
                       $add->save();
                    }
                }     
         

        return redirect()->route('warehouse.infowithdrawindex',[
            'iduser' => $request->WAREHOUSE_SAVE_HR_ID,

        ]);
}
public function infowithdrawindex_billpaypdf(Request $request,$id,$iduser)
{
    $inforpersonuserid =  Person::where('ID','=',$iduser)->first();
    // $idp = $inforpersonuserid->ID;

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

      $inforwarehouserequest = Warehouserequest::leftJoin('warehouse_request_status','warehouse_request_status.STATUS_CODE','=','warehouse_request.WAREHOUSE_STATUS')  
      ->leftJoin('supplies_inven','supplies_inven.INVEN_ID','=','warehouse_request.WAREHOUSE_INVEN_ID')
      ->leftJoin('hrd_department_sub_sub','hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID','=','warehouse_request.WAREHOUSE_DEP_SUB_SUB_ID')     
      ->where('WAREHOUSE_ID','=', $id)
      ->first();

   

      $warehouserequest = DB::table('warehouse_request_sub')
      ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
      ->leftJoin('supplies_unit_ref','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_UNIT','=','supplies_unit_ref.ID') 
      ->where('WAREHOUSE_REQUEST_ID','=', $id) 
      ->get();

      $warehouserequest_sum = DB::table('warehouse_request_sub')
      ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
      ->where('WAREHOUSE_REQUEST_ID','=', $id) 
      ->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');


      $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

      $info_sendstatus = DB::table('warehouse_request_status')->get();
      $info_org = DB::table('info_org')->get();

      $displaydate_bigen = ($yearbudget-544).'-10-01';
      $displaydate_end = ($yearbudget-543).'-09-30';
      $status = '';
      $search = '';
      $year_id = $yearbudget;

    $pdf = PDF::loadView('general_warehouse.infowithdrawindex_billpaypdf',[
        'inforpersonuserid' => $inforpersonuserid,
        'inforpersonuser' => $inforpersonuser,
        'inforwarehouserequests' => $inforwarehouserequest,
        'warehouserequests' => $warehouserequest,
        'warehouserequest_sum' => $warehouserequest_sum,
        'info_sendstatuss' => $info_sendstatus,
        'budgets' =>  $budget,
        'displaydate_bigen'=> $displaydate_bigen,
        'displaydate_end'=> $displaydate_end,
        'status_check'=> $status,
        'search'=> $search,
        'year_id'=>$year_id, 
        'info_orgs'=>$info_org,
    ]);

    return @$pdf->stream();
}

public function infowithdrawindex_stockcardpdf(Request $request,$id,$iduser)
{
    $info_org = DB::table('info_org')->get();

    $pdf = PDF::loadView('general_warehouse.infowithdrawindex_stockcardpdf',[
        'info_orgs'=>$info_org,
    ]);
    return @$pdf->stream();
}



//======================================================จ่ายวัสดุ==============================

    public function infopayindex(Request $request,$iduser)
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

        $m_budget = date("m");
        if($m_budget>9){
        $yearbudget = date("Y")+544;
        }else{
        $yearbudget = date("Y")+543;
        }
        
        $inforwarehousetreasurypay = Warehousetreasurypay::where('TREASURT_PAY_REQUEST_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->orderBy('TREASURT_PAY_ID', 'desc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget-544).'-10-01';
        $displaydate_end = ($yearbudget-543).'-09-30';

        $search = '';
        $year_id = $yearbudget;


        return view('general_warehouse.infopayindex',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforwarehousetreasurypays' => $inforwarehousetreasurypay,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id, 

        ]);

    }

    public function infopayindexsearch(Request $request,$iduser)
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
        $yearbudget = $request->YEAR_ID;
        $datebigin = $request->get('DATE_BIGIN');
        $dateend = $request->get('DATE_END');

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


    

            $from = date($displaydate_bigen);
            $to = date($displaydate_end);

        
        $inforwarehousetreasurypay = Warehousetreasurypay::where('TREASURT_PAY_REQUEST_SUB_SUB_ID','=', $inforpersonuser->HR_DEPARTMENT_SUB_SUB_ID)
        ->where(function($q) use ($search){
            $q->where('TREASURT_PAY_CODE','like','%'.$search.'%');
            $q->orwhere('TREASURT_PAY_COMMENT','like','%'.$search.'%');
            $q->orwhere('TREASURT_PAY_SAVE_HR_NAME','like','%'.$search.'%');
            $q->orwhere('TREASURT_PAY_REQUEST_HR_NAME','like','%'.$search.'%');
            $q->orwhere('TREASURT_PAY_NAME','like','%'.$search.'%');
        })
        ->WhereBetween('TREASURT_PAY_DATE',[$from,$to])
        ->orderBy('TREASURT_PAY_ID', 'desc')
        ->get();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        
        $year_id = $yearbudget;


        return view('general_warehouse.infopayindex',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'inforwarehousetreasurypays' => $inforwarehousetreasurypay,
            'budgets' =>  $budget,
            'displaydate_bigen'=> $displaydate_bigen,
            'displaydate_end'=> $displaydate_end,
            'search'=> $search,
            'year_id'=>$year_id, 

        ]);

    }

    public function infopayindexadd(Request $request,$iduser)
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

    
        $infoperson = DB::table('hrd_person')
        ->orderBy('hrd_person.HR_FNAME', 'asc')  
        ->get();

        return view('general_warehouse.infopayindex_add',[
            'inforpersonuserid' => $inforpersonuserid,
            'inforpersonuser' => $inforpersonuser,
            'infopersons' => $infoperson
        
        ]);

    }


    public function saveinfopay(Request $request)
    {
        $TREASURT_PAY_DATE = $request->TREASURT_PAY_DATE;
        if($TREASURT_PAY_DATE != ''){
            $DAY = Carbon::createFromFormat('d/m/Y',$TREASURT_PAY_DATE)->format('Y-m-d');
            $date_arrary_st=explode("-",$DAY);
            $y_sub_st = $date_arrary_st[0];

            if($y_sub_st >= 2500){
                $y_st = $y_sub_st-543;
            }else{
                $y_st = $y_sub_st;
            }
            $m_st = $date_arrary_st[1];
            $d_st = $date_arrary_st[2];
            $TREASURTPAYDATE= $y_st."-".$m_st."-".$d_st;
            }else{
            $TREASURTPAYDATE= null;
        }

           $codepay = Warehousetreasurypay::max('TREASURT_PAY_ID');
           $TREASURT_PAY_CODE = $codepay+1;
            
           $infocheck =  Warehousetreasurypay::where('TREASURT_PAY_ID','=',$codepay)->first();

 
  
   if($TREASURTPAYDATE == $infocheck->TREASURT_PAY_DATE && $request->TREASURT_PAY_SAVE_HR_ID == $infocheck->TREASURT_PAY_SAVE_HR_ID && $request->TREASURT_PAY_SAVE_HR_NAME == $infocheck->TREASURT_PAY_SAVE_HR_NAME  && $request->TREASURT_PAY_REQUEST_HR_ID == $infocheck->TREASURT_PAY_REQUEST_HR_ID){
   }else{
            $addsaveinfopay = new Warehousetreasurypay();
            $addsaveinfopay->TREASURT_PAY_CODE = $TREASURT_PAY_CODE;
            $addsaveinfopay->TREASURT_PAY_DATE = $TREASURTPAYDATE;
            $addsaveinfopay->TREASURT_PAY_COMMENT = $request->TREASURT_PAY_COMMENT;
            $addsaveinfopay->TREASURT_PAY_SAVE_HR_ID = $request->TREASURT_PAY_SAVE_HR_ID;
            $addsaveinfopay->TREASURT_PAY_SAVE_HR_NAME = $request->TREASURT_PAY_SAVE_HR_NAME;
            $addsaveinfopay->TREASURT_PAY_REQUEST_HR_ID = $request->TREASURT_PAY_REQUEST_HR_ID;

            $PERSON_SAVE = Person::where('hrd_person.ID','=',$request->TREASURT_PAY_SAVE_HR_ID)->first();
            $addsaveinfopay->TREASURT_PAY_REQUEST_SUB_SUB_ID = $PERSON_SAVE->HR_DEPARTMENT_SUB_SUB_ID;

            $PERSON =  Person::leftJoin('hrd_prefix','hrd_person.HR_PREFIX_ID','=','hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_position','hrd_person.HR_POSITION_ID','=','hrd_position.HR_POSITION_ID')
            ->where('hrd_person.ID','=',$request->TREASURT_PAY_REQUEST_HR_ID)->first();
            $addsaveinfopay->TREASURT_PAY_REQUEST_HR_NAME = $PERSON->HR_FNAME.' '.$PERSON->HR_LNAME;   
        
    
            $addsaveinfopay->TREASURT_PAY_NAME = $request->TREASURT_PAY_NAME;
        

            $addsaveinfopay->save();

            $TREASURT_PAY_ID = Warehousetreasurypay::max('TREASURT_PAY_ID');
        

            if($request->TREASURY_RECEIVE_ID != '' || $request->TREASURY_RECEIVE_ID != null){

                $TREASURY_RECEIVE_ID = $request->TREASURY_RECEIVE_ID;
                $TREASURY_EXPORT_SUB_NAME = $request->TREASURY_EXPORT_SUB_NAME;
                $TREASURY_EXPORT_SUB_LOT = $request->TREASURY_EXPORT_SUB_LOT;
                $TREASURY_EXPORT_SUB_UNIT = $request->TREASURY_EXPORT_SUB_UNIT;
                $TREASURY_EXPORT_SUB_PICE_UNIT = $request->TREASURY_EXPORT_SUB_PICE_UNIT;
                
            
                $TREASURY_EXPORT_SUB_GEN_DATE = $request->TREASURY_EXPORT_SUB_GEN_DATE;
                $TREASURY_EXPORT_SUB_EXP_DATE = $request->TREASURY_EXPORT_SUB_EXP_DATE;
                $TREASURY_EXPORT_SUB_AMOUNT = $request->TREASURY_EXPORT_SUB_AMOUNT;
                
                $TREASURY_RECEIVE_SUB_ID = $request->TREASURY_RECEIVE_SUB_ID;
                $TREASURY_ID = $request->TREASURY_ID;
                
            

                $number =count($TREASURY_RECEIVE_ID);
                $count = 0;
                for($count = 0; $count< $number; $count++)
                {
                //echo $row3[$count_3]."<br>";

                
    
                if($TREASURY_EXPORT_SUB_GEN_DATE[$count] != ''){
                    $DAY =$TREASURY_EXPORT_SUB_GEN_DATE[$count];
                    $date_arrary_st=explode("-",$DAY);
                    $y_sub_st = $date_arrary_st[0];
    
                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];
                    $GENDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $GENDATE= null;
                }

                // dd($GENDATE);

                if($TREASURY_EXPORT_SUB_EXP_DATE[$count] != ''){
                    $DAY = $TREASURY_EXPORT_SUB_EXP_DATE[$count];
                    $date_arrary_st=explode("-",$DAY);
                    $y_sub_st = $date_arrary_st[0];

                    if($y_sub_st >= 2500){
                        $y_st = $y_sub_st-543;
                    }else{
                        $y_st = $y_sub_st;
                    }
                    $m_st = $date_arrary_st[1];
                    $d_st = $date_arrary_st[2];
                    $EXPDATE= $y_st."-".$m_st."-".$d_st;
                    }else{
                    $EXPDATE= null;
                }

          
                    $add = new Warehousetreasuryexportsub();
                    $add->TREASURT_PAY_ID = $TREASURT_PAY_ID;
                
                $add->TREASURY_RECEIVE_ID = $TREASURY_RECEIVE_ID[$count];

                $add->TREASURY_EXPORT_SUB_NAME = $TREASURY_EXPORT_SUB_NAME[$count];
                $add->TREASURY_EXPORT_SUB_LOT = $TREASURY_EXPORT_SUB_LOT[$count];
                $add->TREASURY_EXPORT_SUB_UNIT = $TREASURY_EXPORT_SUB_UNIT[$count];

                $add->TREASURY_EXPORT_SUB_AMOUNT = $TREASURY_EXPORT_SUB_AMOUNT[$count];
                $add->TREASURY_EXPORT_SUB_VALUE = $TREASURY_EXPORT_SUB_AMOUNT[$count] * $TREASURY_EXPORT_SUB_PICE_UNIT[$count];
                $add->TREASURY_EXPORT_SUB_PICE_UNIT = $TREASURY_EXPORT_SUB_PICE_UNIT[$count];
               
           
                

                $add->TREASURY_EXPORT_SUB_GEN_DATE = $GENDATE;
                $add->TREASURY_EXPORT_SUB_EXP_DATE = $EXPDATE;
               

            
                $add->TREASURY_RECEIVE_SUB_ID = $TREASURY_RECEIVE_SUB_ID[$count];
                $add->TREASURY_ID = $TREASURY_ID[$count];


            //---------------ตรวจสอบจำนวนของที่เหลือ
                $inforecheckre = DB::table('warehouse_treasury_receive_sub')->where('TREASURY_ID','=',$TREASURY_ID[$count])->where('TREASURY_RECEIVE_ID','=',$TREASURY_RECEIVE_ID[$count])->sum('TREASURY_RECEIVE_SUB_AMOUNT');
                $inforecheckex = DB::table('warehouse_treasury_export_sub')->where('TREASURY_ID','=',$TREASURY_ID[$count])->where('TREASURY_RECEIVE_ID','=',$TREASURY_RECEIVE_ID[$count])->sum('TREASURY_EXPORT_SUB_AMOUNT');

                $totalsumpay = $inforecheckex  + $TREASURY_EXPORT_SUB_AMOUNT[$count];
             
                if( $inforecheckre >= $totalsumpay){
                $add->save();
                }

                }
            }
    }

            return redirect()->route('warehouse.infopayindex',['iduser' => $request->TREASURT_PAY_SAVE_HR_ID]);
    }

//=======================================================ฟังชั่น===============

    function detailsup(Request $request)
        {


                    $iddep = $request->get('iddep');

                    $count = $request->get('count');

                    $detailwarehousestorereceivesubs = DB::table('warehouse_treasury_receive_sub')
                    ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')
                    ->where('warehouse_treasury.TREASURY_TYPE','=',$iddep)->get();


                    $output ='
                    <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                    <thead style="background-color: #FFEBCD;">
                    <tr>
                        <td style="text-align: center;" width="30%">รายละเอียด</td>
                        <td style="text-align: center;">ล็อต</th>
                        <td style="text-align: center;" >จำนวนคงเหลือ</td>
                        <td style="text-align: center;" >ราคาต่อหน่วย</td>
                        <td style="text-align: center;" width="5%">เลือก</td>
                    </tr>
                    </thead>
                    <tbody id="myTable">';

                            
                            foreach ($detailwarehousestorereceivesubs as $detailwarehousestorereceivesub){

                                $lotreceive =  DB::table('warehouse_treasury_receive_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$detailwarehousestorereceivesub->TREASURY_RECEIVE_SUB_ID)->first();
                            
                                $sumlotexport = DB::table('warehouse_treasury_export_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$detailwarehousestorereceivesub->TREASURY_RECEIVE_SUB_ID)->sum('TREASURY_EXPORT_SUB_AMOUNT');

                            
                                $amountlot = $lotreceive->TREASURY_RECEIVE_SUB_AMOUNT;
                                $amountexport = $sumlotexport; 

                                $total = $amountlot - $amountexport; 

                                if($total != 0){
                                $output.='  <tr height="20">
                                <td class="text-font text-pedding" >'.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SUB_NAME.'</td>
                                <td class="text-font" align="center" >'.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SUB_LOT.'</td>
                                <td class="text-font" style="padding-right:10px;" align="right" >'.$total.'</td>
                                <td class="text-font text-pedding" align="center" >'.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SUB_PICE_UNIT.'</td>
                                <td class="text-font text-pedding" align="center" ><button type="button" class="btn btn-hero-sm btn-hero-info"  style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="selectsup('.$detailwarehousestorereceivesub->TREASURY_RECEIVE_SUB_ID.','.$count.')">เลือก</button></td> 
                            </tr>';
                                }


                            }
                                $output.='</tbody>
                                </table>';


                                echo $output;


        }



    function selectsup(Request $request)
    {
    
        $idsup = $request->get('idsup');
        //dd($idsup);

        $inforeceive_sub = DB::table('warehouse_treasury_receive_sub')
        ->leftJoin('warehouse_treasury','warehouse_treasury_receive_sub.TREASURY_ID','=','warehouse_treasury.TREASURY_ID')  
        ->where('warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_ID','=',$idsup)->first();

        $output = $inforeceive_sub->TREASURY_RECEIVE_SUB_NAME.' 
        <input  type="hidden"  name="TREASURY_RECEIVE_ID[]" id="TREASURY_RECEIVE_ID" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_ID.'">
        <input  type="hidden"  name="TREASURY_EXPORT_SUB_NAME[]" id="TREASURY_EXPORT_SUB_NAME" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SUB_NAME.'"> 
        <input  type="hidden"  name="TREASURY_ID[]" id="TREASURY_ID" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_ID.'">
        <input  type="hidden"  name="TREASURY_RECEIVE_SUB_ID[]" id="TREASURY_RECEIVE_SUB_ID" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SUB_ID.'">';
        
        echo $output;
    }


    function selectsuplot(Request $request)
    {
        
        $idsup = $request->get('idsup');

        $inforeceive_sub = DB::table('warehouse_treasury_receive_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$idsup)->first();

        $output = $inforeceive_sub->TREASURY_RECEIVE_SUB_LOT.'<input  type="hidden" name="TREASURY_EXPORT_SUB_LOT[]" id="TREASURY_EXPORT_SUB_LOT" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SUB_LOT.'">';
        echo $output;
    }

    function selectsuptotal(Request $request)
    {

        $idsup = $request->get('idsup');
        $count = $request->get('count');

        $inforeceive_sub = DB::table('warehouse_treasury_receive_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$idsup)->first();

        $lotreceive =  DB::table('warehouse_treasury_receive_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$inforeceive_sub->TREASURY_RECEIVE_SUB_ID)->first();
    
        $sumlotexport = DB::table('warehouse_treasury_export_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$inforeceive_sub->TREASURY_RECEIVE_SUB_ID)->sum('TREASURY_EXPORT_SUB_AMOUNT');

    
        $amountlot = $lotreceive->TREASURY_RECEIVE_SUB_AMOUNT;
        $amountexport = $sumlotexport; 

        $total = $amountlot - $amountexport; 

        $output =  $total.'<input type="hidden" name="TREASURY_EXPORT_SUB_VALUE[]" id="TREASURY_EXPORT_SUB_VALUE'.$count.'" class="form-control input-sm" value="'.$total.'">';
        echo $output;
    }


    function selectsupunit(Request $request)
    {
    
        $idsup = $request->get('idsup');

        $inforeceive_sub = DB::table('warehouse_treasury_receive_sub')
        ->leftJoin('supplies_unit_ref','warehouse_treasury_receive_sub.TREASURY_RECEIVE_SUB_UNIT','=','supplies_unit_ref.ID')
        ->where('TREASURY_RECEIVE_SUB_ID','=',$idsup)->first();

        $output = $inforeceive_sub->SUP_UNIT_NAME.'<input type="hidden" name="TREASURY_EXPORT_SUB_UNIT[]" id="TREASURY_EXPORT_SUB_UNIT" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SUB_UNIT.'">';
        echo $output;
    }

    function selectsuppiceunit(Request $request)
    {
    
        $idsup = $request->get('idsup');
        $count = $request->get('count');

        $inforeceive_sub = DB::table('warehouse_treasury_receive_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$idsup)->first();

        $output = number_format($inforeceive_sub->TREASURY_RECEIVE_SUB_PICE_UNIT,5).'<input type="hidden" name="TREASURY_EXPORT_SUB_PICE_UNIT[]" id="RECEIVE_SUB_PICE_UNIT'.$count.'" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SUB_PICE_UNIT.'">';
        echo $output;
    }

    function selectsupdatget(Request $request)
    {



        $idsup = $request->get('idsup');

        $inforeceive_sub = DB::table('warehouse_treasury_receive_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$idsup)->first();

        $output = DateThai($inforeceive_sub->TREASURY_RECEIVE_SUB_GEN_DATE).'<input type="hidden" name="TREASURY_EXPORT_SUB_GEN_DATE[]" id="WAREHOUSE_REQUEST_SUB_GEN_DATE" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SUB_GEN_DATE.'">';
        echo $output;
    }

    function selectsupdatexp(Request $request)
    {


    
        $idsup = $request->get('idsup');

        $inforeceive_sub = DB::table('warehouse_treasury_receive_sub')->where('TREASURY_RECEIVE_SUB_ID','=',$idsup)->first();

        $output = DateThai($inforeceive_sub->TREASURY_RECEIVE_SUB_EXP_DATE).'<input type="hidden" name="TREASURY_EXPORT_SUB_EXP_DATE[]" id="WAREHOUSE_REQUEST_SUB_EXP_DATE" class="form-control input-sm" value="'.$inforeceive_sub->TREASURY_RECEIVE_SUB_EXP_DATE.'">';
        echo $output;
    }


//--------------------------------------------------ฟังชั่นการขอเบิกวัสดุ-----


function detailsupselect(Request $request)
{


  $idinven = $request->get('idinven');

  $count = $request->get('count');

  $detailwarehousestorereceivesubs = DB::table('warehouse_store')
  
  ->where('STORE_TYPE','=',$idinven)->get();


  $output ='
  <table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">

  <thead style="background-color: #FFEBCD;">
      <tr>
           <td style="text-align: center;border: 1px solid black;" width="20%">รหัส</td>
   
          <td style="text-align: center;border: 1px solid black;" >รายละเอียด</td>
          <td style="text-align: center;border: 1px solid black;" width="20%">คงเหลือ</td>
        
          <td style="text-align: center;border: 1px solid black;" width="10%">เลือก</td>
      </tr>
  </thead>
  <tbody id="myTable">';

  
  foreach ($detailwarehousestorereceivesubs as $detailwarehousestorereceivesub){

    $lotreceive =  DB::table('warehouse_store_receive_sub')->where('STORE_ID','=',$detailwarehousestorereceivesub->STORE_ID)->sum('RECEIVE_SUB_AMOUNT');
   
    $sumlotexport = DB::table('warehouse_store_export_sub')->where('STORE_ID','=',$detailwarehousestorereceivesub->STORE_ID)->sum('EXPORT_SUB_AMOUNT');

  
    $amountlot = $lotreceive;
    $amountexport = $sumlotexport; 

    $total = $amountlot - $amountexport; 

    $output.='  <tr height="20">
    <td class="text-font text-pedding" style="border: 1px solid black;">'.$detailwarehousestorereceivesub->STORE_CODE.'</td>
    <td class="text-font text-pedding" style="border: 1px solid black;" align="left" >'.$detailwarehousestorereceivesub->STORE_NAME.'</td>
    <td class="text-font" style="border: 1px solid black;padding-right:10px;" align="right" >'.$total.'</td>

    <td class="text-font" style="border: 1px solid black;" align="center" ><button type="button" class="btn btn-hero-sm btn-hero-info"  style="font-family: \'Kanit\', sans-serif; font-size: 10px;font-weight:normal;"  onclick="selectsupreq('.$detailwarehousestorereceivesub->STORE_ID.','.$count.')">เลือก</button></td> 
  </tr>';
     }


   
$output.='</tbody>
</table>';


 echo $output;


}


function selectsupreq(Request $request)
{
  
    $idinven = $request->get('idinven');
    $count = $request->get('count');

    $infowarehousestore = DB::table('warehouse_store')->where('STORE_ID','=',$idinven)->first();

    $output = $infowarehousestore->STORE_NAME.'<input type="hidden" name="WAREHOUSE_REQUEST_SUB_DETAIL_ID[]" id="WAREHOUSE_REQUEST_SUB_DETAIL_ID'.$count.'" class="form-control input-sm" value="'.$infowarehousestore->STORE_SUP_ID.'">';
    echo $output;
}

function selectsupunitname(Request $request)
{
  
    $idinven = $request->get('idinven');
    $count = $request->get('count');

    $infowarehousestore = DB::table('warehouse_store')
    ->leftJoin('supplies_unit_ref','warehouse_store.STORE_UNIT','=','supplies_unit_ref.ID')
    ->where('STORE_ID','=',$idinven)->first();

    $output = $infowarehousestore->SUP_UNIT_NAME.'<input type="hidden" name="WAREHOUSE_REQUEST_SUB_UNIT[]" id="WAREHOUSE_REQUEST_SUB_UNIT'.$count.'" class="form-control input-sm" value="'.$infowarehousestore->STORE_UNIT.'">';
    echo $output;
}




public static function refnumberRe()
{

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

    

    $maxnumber = DB::table('warehouse_request')->where('WAREHOUSE_BUDGET_YEAR','=',$yearbudget)->max('WAREHOUSE_ID');  



    if($maxnumber != '' ||  $maxnumber != null){
        
        $refmax = DB::table('warehouse_request')->where('WAREHOUSE_ID','=',$maxnumber)->first();  

      

        if($refmax->WAREHOUSE_REQUEST_CODE != '' ||  $refmax->WAREHOUSE_REQUEST_CODE != null){
            $maxref = substr($refmax->WAREHOUSE_REQUEST_CODE, -4)+1;
         }else{
            $maxref = 1;
         }

        $ref = str_pad($maxref, 4, "0", STR_PAD_LEFT);
   
    }else{
        $ref = '0001';
    }


    $y = substr($yearbudget, -2);
   

 $refnumber ='RE-'.$y.''.$ref;



 return $refnumber;
}



        public static function agree($id_user)
        {

            $count =  DB::table('warehouse_request')->where('WAREHOUSE_AGREE_HR_ID','=',$id_user)->count();   

        return $count;
        }


        //=============================================รายละเอียดการจ่ายจากคลังย่อย

        
    function detailpay(Request $request)
    {




    $id = $request->get('id');


    $output='<table class="table-bordered table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
        <thead style="background-color: #FFEBCD;">
            <tr height="40">
            <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="5%">ลำดับ</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;">รายละเอียด</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">จำนวนจ่าย</th>
                <th  class="text-font" style="border-color:#F0FFFF;text-align: center;" width="15%">หน่วย</th>
            

            </tr >
        </thead>
        <tbody>     ';

            $detail_subs = DB::table('warehouse_treasury_export_sub')->where('TREASURT_PAY_ID','=',$id)
            ->leftJoin('supplies_unit_ref','warehouse_treasury_export_sub.TREASURY_EXPORT_SUB_UNIT','=','supplies_unit_ref.ID')
            ->get();

            $count = 1;
            foreach ($detail_subs as $detailsub){
            $output.='  <tr height="20">
            <td class="text-font" align="center" >'.$count.'</td>
            <td class="text-font text-pedding" >'.$detailsub->TREASURY_EXPORT_SUB_NAME.'</td>
            <td class="text-font" align="center" >'.$detailsub->TREASURY_EXPORT_SUB_AMOUNT.'</td>
            <td class="text-font" align="center" >'.$detailsub->SUP_UNIT_NAME.'</td>
            
            </tr>';

            $count++;
            }



            $output.=' </tbody>
            </table><br>';

            echo $output;


    }


}
