<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Report\PersonReportController;
use App\Models\Adduser;
use App\Models\Healthbody;
use App\Models\Healthscreen;
use App\Models\Healthscreenconfirm;
use App\Models\Infoworkcapacity;
use App\Models\Infoworkcorcom;
use App\Models\Infoworkcorcomlevel;
use App\Models\Infoworkcorcomlevelsub;
use App\Models\Infoworkfuntion;
use App\Models\Infoworkfuntionlevel;
use App\Models\Infoworkfuntionlevelsub;
use App\Models\Infoworkfuntionposition;
use App\Models\Infoworkjobdis;
use App\Models\Infoworkjobdisposition;
use App\Models\Infoworkkpis;
use App\Models\Infoworktypescore;
use App\Models\Infoworktypescoresub;
use App\Models\Meetting_inside_type;
use App\Models\Person;
use App\Models\Recordindex;
use App\Models\Meetting_inside_index;
use App\Models\Meetting_inside_performancesub;
use App\Models\Meetting_inside_professionsub;
use App\Models\Meetting_inside_useroutsub;
use App\Models\Meetting_inside_usersub;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//class manager data in datatable
use Illuminate\Support\Facades\Hash;
use Session;
use Cookie;

date_default_timezone_set("Asia/Bangkok");

class ManagerpersonController extends Controller
{
    public function dashboard()
    {
        $data = array();

        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }

        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        // 1 ทำงานปกติ / 2 ลาศึกษา / 3 ช่วยราชการ / 4 พักราชการ / 5 ลาออกแล้ว / 6 ให้ออก / 7 ย้าย / 8 เกษียณ
        $data['person_status_count']       = $psreport->count_hrd_status([1, 2, 3, 4, 5, 6, 7, 8]);
        $data['person_status_count_total'] = $psreport->count_hrd_status([1, 2, 3, 4], 'total');
        //เลขเรียงตามรายชื่อ 24 > นายแพทย์ , 21 > ทันตแพทย์ , 26 > เภสัชกร , 23 > พยาบาลวิชาชีพ , 22 > นักเทคนิคการแพทย์ , 17 > นักกายภาพบำบัด , 30 > นักวิชาการสาธารณสุข
        // , 7 > นักวิชาการคอมพิวเตอร์ , 28 > นักรังสีการแพทย์
        $data['person_position_count'] = $psreport->count_hrd_position([24, 21, 26, 23, 22, 17, 30, 7, 28]);
        $data['person_sex_count']      = $psreport->count_hrd_sex(['F', 'M']);
        $data['person_type_count'][1]  = DB::table('hrd_person')->where('HR_STATUS_ID', 1)->where('HR_PERSON_TYPE_ID', 1)->count();
        $data['person_type_count'][2]  = DB::table('hrd_person')->where('HR_STATUS_ID', 1)->where('HR_PERSON_TYPE_ID', '<>', 1)->count();
        $data['person_Bydepartment'] = $psreport->getperson_Bydepartment_details();
        return view('manager_person.dashboard_person', $data);
    }
    public function ajax_getdepartment_sub_by_emptype(Request $req)
    {
        $personreport = new PersonReportController();
        $person_Bydepartment = $personreport->getperson_Bydepartment_sub_details($req->department_id);

        $result = '<table class="table table-striped mb-0">
                            <thead class="header-group bg-sl-y2" >
                                <tr>';
                                    foreach($person_Bydepartment['header'] as $value){
                                        $result .='<th class="py-2">'.$value.'</th>';
                                    }
                    $result .='</tr>
                            </thead>
                            <tbody>';
                                    foreach($person_Bydepartment as $key => $row){
                                    if($key == 'header'){
                                        continue;
                                    }
                                    $result .='<tr class="department_sub_row" data-id="'.$row['type_id'].'" onclick="showdepartment_sub_sub(this)" style="cursor:pointer">';
                                    $i = 1;
                                        foreach($row as $key => $col){
                                        if($key == 'type_id'){
                                            continue;
                                        }
                                        if($i == 1){
                                            $result .= '<td class="py-1">'.$col.'</td>';
                                            $i++;
                                        }else{
                                            $result .= '<td class="py-1 text-center">'.$col.'</td>';
                                        }
                                        }
                                    $result .= '</tr>';
                                    }
                            $result .= '</tbody>
                            </table>';
        echo $result;
    }
    public function ajax_getdepartment_sub_sub_by_emptype(Request $req)
    {
        $personreport = new PersonReportController();
        $person_Bydepartment = $personreport->getperson_Bydepartment_sub_sub_details($req->department_sub_id);
        $result = '<table class="table table-striped mb-0">
                            <thead class="header-group bg-sl-r1" >
                                <tr>';
                                    foreach($person_Bydepartment['header'] as $value){
                                        $result .='<th class="py-2">'.$value.'</th>';
                                    }
                    $result .='</tr>
                            </thead>
                            <tbody>';
                                    foreach($person_Bydepartment as $key => $row){
                                    if($key == 'header'){
                                        continue;
                                    }
                                    $result .='<tr class="department_sub_sub_row" data-id="'.$row['type_id'].'">';
                                    $i = 1;
                                        foreach($row as $key => $col){
                                        if($key == 'type_id'){
                                            continue;
                                        }
                                    if($i==1){
                                        $result .= '<td class="py-1">'.$col.'</td>';
                                        $i++;
                                    }else{
                                        $result .= '<td class="py-1 text-center">'.$col.'</td>';
                                    }
                                        }
                                    $result .= '</tr>';
                                    }
                            $result .= '</tbody>
                            </table>';
        echo $result;
    }

    public function dashboard_nw()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $psreport      = new PersonReportController();
        $data['year_'] = $year_;
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(1,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(1);
        return view('manager_person.dashboard_nw',$data);
    }

    public function dashboard_sl()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(2,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(2);

        return view('manager_person.dashboard_sl',$data);
    }

    public function dashboard_hgo()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(3,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(3);
        return view('manager_person.dashboard_hgo',$data);
    }

    public function dashboard_sis()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(4,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(4);
        return view('manager_person.dashboard_sis',$data);
    }

    public function dashboard_res()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(5,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(5);
        return view('manager_person.dashboard_res',$data);
    }

    public function dashboard_go()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(6,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(6);
        return view('manager_person.dashboard_go',$data);
    }

    public function dashboard_mo()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(7,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(7);
        return view('manager_person.dashboard_mo',$data);
    }

    public function dashboard_ret()
    {
        $data['year_select'] = '';
        if (isset($_GET['year_select'])) {
            $data['year_select'] = $_GET['year_select'];
        }
        
        $year_ = array();
        for ($i = date('Y'); $i >= date('Y') - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;
        $psreport      = new PersonReportController();
        //ประเภทการทำงาน 1 ข้าราชการ, 2 ลูกจ้างประจำ, 3 พนักงานราชการ, 4 พนักงานกระทรวงสาธารณสุข, 5 ลูกจ้างชั่วคราว, 6 ลูกจ้างรายวัน
        $data['pernw_type_count'] = $psreport->count_perstatus_pertype(8,[1,2,3,4,5,6]); //1 ทำงานปกติ , ประเภทการทำงาน 
        $data['person'] = $psreport->data_personstatus(8);
        return view('manager_person.dashboard_ret',$data);
    }


    public function carcalendar()
    {

        $birthday = Person::where('hrd_person.HR_STATUS_ID', '<>', 5)
        ->where('hrd_person.HR_STATUS_ID', '<>', 6)
        ->where('hrd_person.HR_STATUS_ID', '<>', 7)
        ->where('hrd_person.HR_STATUS_ID', '<>', 8)->get();

        return view('manager_person.carcalendar_person', [
            'birthdays' => $birthday

        ]);
    }

    public function inforperson(Request $request)
    {
        if(!empty($request->_token)){
            $search = $request->search;
            session(['manager_person.inforperson'=> $search]);
        }elseif(!empty(session('manager_person.inforperson'))){
            $search = session('manager_person.inforperson');
        }else{
            $search = '';
        }
        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.HR_STATUS_ID', '<>', 5)
            ->where('hrd_person.HR_STATUS_ID', '<>', 6)
            ->where('hrd_person.HR_STATUS_ID', '<>', 7)
            ->where('hrd_person.HR_STATUS_ID', '<>', 8)
            ->where(function ($q) use ($search) {
                $q->where('hrd_person.HR_CID', 'like', '%' . $search . '%');
                $q->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_FNAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                $q->orwhere('NICKNAME', 'like', '%' . $search . '%');
                $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%');
                $q->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%');
                $q->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_PERSON_TYPE_NAME', 'like', '%' . $search . '%');
            })
            ->orderBy('hrd_person.ID', 'desc')
            ->get();

        $count = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.HR_STATUS_ID', '<>', 5)
            ->where('hrd_person.HR_STATUS_ID', '<>', 6)
            ->where('hrd_person.HR_STATUS_ID', '<>', 7)
            ->where('hrd_person.HR_STATUS_ID', '<>', 8)
            ->where(function ($q) use ($search) {
                $q->where('hrd_person.HR_CID', 'like', '%' . $search . '%');
                $q->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_FNAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                $q->orwhere('NICKNAME', 'like', '%' . $search . '%');
                $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%');
                $q->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%');
                $q->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%');
                $q->orwhere('HR_PERSON_TYPE_NAME', 'like', '%' . $search . '%');
            })->count();

        return view('manager_person.inforperson', [
            'persons' => $person,
            'count'   => $count,
            'search'   => $search
        ]);
    }

    // public function search(Request $request)
    // {
    //     $search = $request->get('search');
    //     $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
    //         ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
    //         ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
    //         ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
    //         ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    //         ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
    //         ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    //         ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
    //         ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 5)
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 6)
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 7)
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 8)
    //         ->where(function ($q) use ($search) {
    //             $q->where('hrd_person.HR_CID', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_FNAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
    //             $q->orwhere('NICKNAME', 'like', '%' . $search . '%');
    //             $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_PERSON_TYPE_NAME', 'like', '%' . $search . '%');
    //         })
    //         ->orderBy('hrd_person.ID', 'desc')
    //         ->get();
    //     //dd($person);

    //     $count = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
    //         ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
    //         ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
    //         ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
    //         ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
    //         ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
    //         ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
    //         ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
    //         ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 5)
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 6)
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 7)
    //         ->where('hrd_person.HR_STATUS_ID', '<>', 8)
    //         ->where(function ($q) use ($search) {
    //             $q->where('hrd_person.HR_CID', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_FNAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
    //             $q->orwhere('NICKNAME', 'like', '%' . $search . '%');
    //             $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%');
    //             $q->orwhere('HR_PERSON_TYPE_NAME', 'like', '%' . $search . '%');
    //         })
    //         ->count();

    //     return view('manager_person.inforperson', [
    //         'persons' => $person,
    //         'count'   => $count
    //     ]);

    // }

    public function create()
    {

        $infoprefix             = DB::table('hrd_prefix')->get();
        $infomarry              = DB::table('hrd_marry_status')->get();
        $inforeligion           = DB::table('hrd_religion')->get();
        $infonation             = DB::table('hrd_nationality')->get();
        $infocitizen            = DB::table('hrd_citizenship')->get();
        $infosex                = DB::table('hrd_sex')->get();
        $infoblood              = DB::table('hrd_bloodgroup')->get();
        $infoprovince           = DB::table('hrd_province')->get();
        $infodepartment         = DB::table('hrd_department')->get();
        $infodepartment_sub     = DB::table('hrd_department_sub')->get();
        $infodepartment_sub_sub = DB::table('hrd_department_sub_sub')->get();
        $infolevel              = DB::table('hrd_level')->get();
        $infostatus             = DB::table('hrd_status')->get();
        $infokind               = DB::table('hrd_kind')->get();
        $infokind_type          = DB::table('hrd_kind_type')->get();
        $infoperson_type        = DB::table('hrd_person_type')->get();
        $infoposition           = DB::table('hrd_position')->get();

        return view('manager_person.adduser', [
            'infoprefixs'             => $infoprefix,
            'infomarrys'              => $infomarry,
            'inforeligions'           => $inforeligion,
            'infonations'             => $infonation,
            'infocitizens'            => $infocitizen,
            'infosexs'                => $infosex,
            'infobloods'              => $infoblood,
            'infoprovinces'           => $infoprovince,
            'infodepartments'         => $infodepartment,
            'infodepartment_subs'     => $infodepartment_sub,
            'infodepartment_sub_subs' => $infodepartment_sub_sub,
            'infolevels'              => $infolevel,
            'infostatuss'             => $infostatus,
            'infokinds'               => $infokind,
            'infokind_types'          => $infokind_type,
            'infoperson_types'        => $infoperson_type,
            'infopositions'           => $infoposition

        ]);

    }

    public function store(Request $request)
    {
        //return $request->all();
        $checkbirt  = $request->HR_BIRTHDAY;
        $checkstart = $request->STARTWORK;
        $checkvcode = $request->VCODE_DATE;

        if ($checkbirt != '') {
            $BIRTHDAY         = Carbon::createFromFormat('d/m/Y', $checkbirt)->format('Y-m-d');
            $date_arrary      = explode("-", $BIRTHDAY);
            $y                = $date_arrary[0] - 543;
            $m                = $date_arrary[1];
            $d                = $date_arrary[2];
            $displaybirthdate = $y . "-" . $m . "-" . $d;
        } else {
            $displaybirthdate = null;
        }

        if ($checkstart != '') {
            $STARTDAY         = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st   = explode("-", $STARTDAY);
            $y_st             = $date_arrary_st[0] - 543;
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $displaystartdate = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $displaystartdate = null;
        }
        if ($checkvcode != '') {
            $VCODEDAY         = Carbon::createFromFormat('d/m/Y', $checkvcode)->format('Y-m-d');
            $date_arrary_v    = explode("-", $VCODEDAY);
            $y_v              = $date_arrary_v[0] - 543;
            $m_v              = $date_arrary_v[1];
            $d_v              = $date_arrary_v[2];
            $displayvcodedate = $y_v . "-" . $m_v . "-" . $d_v;
        } else {
            $displayvcodedate = null;
        }

        $addperson                     = new Person();
        $addperson->HR_PREFIX_ID       = $request->HR_PREFIX;
        $addperson->HR_FNAME           = $request->HR_FNAME;
        $addperson->HR_LNAME           = $request->HR_LNAME;
        $addperson->HR_EN_NAME         = $request->HR_EN_NAME;
        $addperson->NICKNAME           = $request->NICKNAME;
        $addperson->HR_BIRTHDAY        = $displaybirthdate;
        $addperson->HR_CID             = $request->HR_CID;
        $addperson->HR_MARRY_STATUS_ID = $request->HR_MARRY_STATUS;
        $addperson->HR_RELIGION_ID     = $request->HR_RELIGION;
        $addperson->HR_NATIONALITY_ID  = $request->HR_NATIONALITY;
        $addperson->HR_CITIZENSHIP_ID  = $request->HR_CITIZENSHIP;
        $addperson->SEX                = $request->SEX;
        $addperson->HR_BLOODGROUP_ID   = $request->HR_BLOODGROUP;
        $addperson->HR_HIGH            = $request->HR_HIGH;
        $addperson->HR_WEIGHT          = $request->HR_WEIGHT;
        $addperson->HR_PHONE           = $request->HR_PHONE;
        $addperson->HR_EMAIL           = $request->HR_EMAIL;
        $addperson->HR_FACEBOOK        = $request->HR_FACEBOOK;
        $addperson->HR_LINE            = $request->HR_LINE;

        $addperson->HR_DEPARTMENT_ID         = $request->HR_DEPARTMENT;
        $addperson->HR_DEPARTMENT_SUB_ID     = $request->DEPARTMENT_SUB;
        $addperson->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB;

        $addperson->HR_STARTWORK_DATE = $displaystartdate;

        $addperson->HR_POSITION_NUM = $request->HR_POSITION_NUM;
        $addperson->VCODE           = $request->VCODE;

        $addperson->VCODE_DATE = $displayvcodedate;

        $position = DB::table('hrd_position')
            ->where('HR_POSITION_ID', '=', $request->POSITION_IN_WORK)
            ->first();
        $addperson->POSITION_IN_WORK = $position->HR_POSITION_NAME;

        $addperson->HR_POSITION_ID    = $request->POSITION_IN_WORK;
        $addperson->HR_LEVEL_ID       = $request->HR_LEVEL;
        $addperson->HR_STATUS_ID      = $request->HR_STATUS;
        $addperson->HR_KIND_ID        = $request->HR_KIND;
        $addperson->HR_KIND_TYPE_ID   = $request->HR_KIND_TYPE;
        $addperson->HR_PERSON_TYPE_ID = $request->HR_PERSON_TYPE;
        $addperson->HR_SALARY         = $request->HR_SALARY;
        $addperson->MONEY_POSITION    = $request->MONEY_POSITION;

        $addperson->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $addperson->HR_VILLAGE_NO  = $request->HR_VILLAGE_NO;
        $addperson->HR_ROAD_NAME   = $request->HR_ROAD_NAME;
        $addperson->HR_SOI_NAME    = $request->HR_SOI_NAME;
        $addperson->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $addperson->PROVINCE_ID    = $request->PROVINCE_NAME;
        $addperson->AMPHUR_ID      = $request->AMPHUR_NAME;
        $addperson->TUMBON_ID      = $request->TUMBON_NAME;
        $addperson->HR_ZIPCODE     = $request->HR_ZIPCODE;

        $addperson->HR_HOME_NUMBER_1 = $request->HR_HOME_NUMBER_1;
        $addperson->HR_VILLAGE_NO_1  = $request->HR_VILLAGE_NO_1;
        $addperson->HR_ROAD_NAME_1   = $request->HR_ROAD_NAME_1;
        $addperson->PROVINCE_ID_1    = $request->PROVINCE_NAME_1;
        $addperson->AMPHUR_ID_1      = $request->AMPHUR_NAME_1;
        $addperson->TUMBON_ID_1      = $request->TUMBON_NAME_1;
        $addperson->HR_ZIPCODE_1     = $request->HR_ZIPCODE_1;

        $addperson->BOOK_BANK_NUMBER = $request->BOOK_BANK_NUMBER;
        $addperson->BOOK_BANK_NAME   = $request->BOOK_BANK_NAME;
        $addperson->BOOK_BANK        = $request->BOOK_BANK;
        $addperson->BOOK_BANK_BRANCH = $request->BOOK_BANK_BRANCH;

        $addperson->BOOK_BANK_OT_NUMBER = $request->BOOK_BANK_OT_NUMBER;
        $addperson->BOOK_BANK_OT_NAME   = $request->BOOK_BANK_OT_NAME;
        $addperson->BOOK_BANK_OT        = $request->BOOK_BANK_OT;
        $addperson->BOOK_BANK_OT_BRANCH = $request->BOOK_BANK_OT_BRANCH;

        // $picid = $request->HR_CID;

        if ($request->hasFile('picture')) {
            //$newFileName = $picid.'.'.$request->picture->extension();

            $file                = $request->file('picture');
            $contents            = $file->openFile()->fread($file->getSize());
            $addperson->HR_IMAGE = $contents;
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName;
        }

        //dd($addperson);
        $addperson->save();

        $idperson = Person::max('ID');

        $password                = "123456";
        $adduser                 = new Adduser();
        $adduser->name           = $request->HR_FNAME . ' ' . $request->HR_LNAME;
        $adduser->email          = $request->HR_EMAIL;
        $adduser->password       = Hash::make($password);
        $adduser->remember_token = $request->_token;
        $adduser->status         = 'USER';
        $adduser->username       = $request->HR_USERNAME;
        $adduser->PERSON_ID      = $idperson;
        $adduser->save();
        //dd($adduser);

        // return redirect()->action('ManagerpersonController@inforperson');

        return redirect()->route('mperson.inforperson');
    }

    public function get_ajex_infouser(Request $request, $iduser)
    {
        $inforpersonuser = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $inforadd2 = Person::leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID_1', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID_1', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID_1', '=', 'hrd_province.ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $userid = Person::where('hrd_person.ID', '=', $iduser)->first();

        $str = '
    
        <div class="block-content">
            <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                    style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลส่วนตัว&nbsp;&nbsp;</span>
            </h2>
            <div class="row push">
                <div class="col-lg-4">
                    <div class="form-group">
    
                        <img src="data:image/png;base64,'.chunk_split(base64_encode($inforpersonuser->HR_IMAGE)).'"
                            height="80%" width="60%">
                    </div>
                </div>
                <div class="col-lg-4">
    
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>คำนำหน้า</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_PREFIX_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>ชื่อ</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_FNAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>นามสกุล</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_LNAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>ชื่ออังกฤษ</label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_EN_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>ชื่อเล่น </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> NICKNAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>วันเกิด </label>
                            </div>
                            <div class="col-lg-9">
                                '. DateThai($inforpersonuser -> HR_BIRTHDAY) .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-5">
                                <label>เลขประจำตัวประชาชน </label>
                            </div>
                            <div class="col-lg-7">
                                '. $inforpersonuser -> HR_CID .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-5">
                                <label>สถานะสมรส </label>
                            </div>
                            <div class="col-lg-7">
                                '. $inforpersonuser -> HR_MARRY_STATUS_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-5">
                                <label>ศาสนา </label>
                            </div>
                            <div class="col-lg-7">
                                '. $inforpersonuser -> HR_RELIGION_NAME .'
                            </div>
                        </div>
                    </div>
    
    
    
                </div>
                <div class="col-lg-4">
    
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>เชื้อชาติ </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_NATIONALITY_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>สัญชาติ </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_CITIZENSHIP_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>เพศ </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> SEX_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-3">
                                <label>กรุ๊ปเลือด </label>
                            </div>
                            <div class="col-lg-9">
                                '. $inforpersonuser -> HR_BLOODGROUP_NAME .'
                            </div>
                        </div>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-12">
                                <label>ส่วนสูง </label>
                                '. $inforpersonuser -> HR_HIGH .'
                                <label>เซนติเมตร</label>
                                <label>น้ำหนัก </label>
                                '. $inforpersonuser -> HR_WEIGHT .'
                                <label>กิโลกรัม</label>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>เบอร์โทร </label>
                                </div>
                                <div class="col-lg-9">
                                    '. $inforpersonuser -> HR_PHONE .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>อีเมลล์ </label>
                                </div>
                                <div class="col-lg-9">
                                    '. $inforpersonuser -> HR_EMAIL  .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Facebook </label>
                                </div>
                                <div class="col-lg-9">
                                    <p>'. $inforpersonuser -> HR_FACEBOOK .'
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Line </label>
                                </div>
                                <div class="col-lg-9">
                                    <p style="word-wrap: break-word;">
                                    '. $inforpersonuser->HR_LINE .'
                                    </p>
                                </div>
                            </div>
                        </div>
    
                    </div>
    
                </div>
    
            </div>
    
    
    
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลอาชีพ&nbsp;&nbsp;</span>
                </h2>
                <div class="row push">
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>กลุ่มงาน </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_DEPARTMENT_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>ฝ่าย/แผนก </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_DEPARTMENT_SUB_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>หน่วยงาน </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '.$inforpersonuser -> HR_DEPARTMENT_SUB_SUB_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>วันที่บรรจุ </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '.DateThai($inforpersonuser -> HR_STARTWORK_DATE).'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>เลขตำแหน่ง </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_POSITION_NUM .'
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>เลขใบประกอบวิชาชีพ
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> VCODE .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>วดป.รับใบประกอบ </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. DateThai($inforpersonuser -> VCODE_DATE) .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>ตำแหน่ง </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> POSITION_IN_WORK .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>ระดับ </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_LEVEL_NAME.'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>สถานะปัจจุบัน </label>
                                    </div>
                                    <div class="col-lg-8">
                                        '. $inforpersonuser -> HR_STATUS_NAME .'
                                    </div>
                                </div>
                            </div>
    
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>กลุ่มข้าราชการ </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_KIND_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ประเภทข้าราชการ </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_KIND_TYPE_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>กลุ่มบุคลากร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_PERSON_TYPE_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ต้นสังกัด </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> HR_AGENCY_ID .'
    
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เงินเดือน</label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. number_format($inforpersonuser -> HR_SALARY,2) .'
                                        <label>บาท</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เงินประจำตำแหน่ง</label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. number_format($inforpersonuser -> MONEY_POSITION,2) .'
                                        <label>บาท</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
    
            </div>
    
    
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยปัจจุบัน&nbsp;&nbsp;</span>
                </h2>
                <div class="row">
    
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>บ้านเลขที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser ->HR_HOME_NUMBER  .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ตำบล </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> TUMBON_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>หมู่ที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser ->HR_VILLAGE_NO  .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>อำเภอ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> AMPHUR_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ถนน </label>
                                </div>
                                <div class="col-lg-8">
                                    '.  $inforpersonuser -> HR_ROAD_NAME .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>จังหวัด </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> PROVINCE_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ซอย </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_SOI_NAME .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label>รหัสไปรษณีย์ </label>
                                </div>
                                <div class="col-lg-7">
                                    '. $inforpersonuser -> HR_ZIPCODE .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
    
    
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลที่อยู่อาศัยตามทะเบียนบ้าน&nbsp;&nbsp;</span>
                </h2>
                <div class="row push">
    
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>บ้านเลขที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_HOME_NUMBER_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ตำบล </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforadd2 -> TUMBON_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>หมู่ที่ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_VILLAGE_NO_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>อำเภอ </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforadd2 -> AMPHUR_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ถนน </label>
                                </div>
                                <div class="col-lg-8">
                                    '.  $inforpersonuser -> HR_ROAD_NAME_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>จังหวัด </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforadd2 -> PROVINCE_NAME .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="col-lg-3">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>ซอย </label>
                                </div>
                                <div class="col-lg-8">
                                    '. $inforpersonuser -> HR_SOI_NAME_1 .'
                                </div>
                            </div>
                        </div>
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-5">
                                    <label>รหัสไปรษณีย์ </label>
                                </div>
                                <div class="col-lg-7">
                                    '. $inforpersonuser -> HR_ZIPCODE_1 .'
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
            <div class="block-content">
                <h2 class="content-heading pt-0" style="font-family: &#39;Kanit&#39;, sans-serif;"><span
                        style="border-radius: 5px;font-size: 18px;">&nbsp;&nbsp;ข้อมูลบัญชีธนาคาร&nbsp;&nbsp;</span>
                </h2>
                <div class="row">
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
    
                                <label>เงินค่าตอบแทน </label>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เลขบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_NUMBER .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ชื่อบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>สาขา </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_BRANCH .'
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <form role="form">
                            <div class="form">
                                <label>เงินค่าตอบแทน OT</label>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>เลขบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT_NUMBER .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ชื่อบัญชีธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT_NAME .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>ธนาคาร </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT .'
                                    </div>
                                </div>
                            </div>
                            <div class="form">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label>สาขา </label>
                                    </div>
                                    <div class="col-lg-7">
                                        '. $inforpersonuser -> BOOK_BANK_OT_BRANCH .'
                                    </div>
                                </div>
                            </div>
    
                        </form>
                    </div>
                    <div class="col-lg-4">
                    </div>
                </div>
            </div>
        </div>';
        echo $str;
    }

    public function infouser(Request $request, $iduser)
    {

        //$email = Auth::user()->email;

        $inforpersonuser = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $inforadd2 = Person::leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID_1', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID_1', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID_1', '=', 'hrd_province.ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $userid = Person::where('hrd_person.ID', '=', $iduser)->first();

        return view('manager_person.detailuser', [
            'inforpersonuser' => $inforpersonuser,
            'userid'          => $userid,
            'inforadd2'       => $inforadd2
        ]);
    }

    public function editinfouser(Request $request, $iduser)
    {

        $inforperson = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $inforperson_add1 = Person::leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID_1', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID_1', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID_1', '=', 'hrd_province.ID')
            ->where('hrd_person.ID', '=', $iduser)->first();

        $infoprefix   = DB::table('hrd_prefix')->get();
        $infomarry    = DB::table('hrd_marry_status')->get();
        $inforeligion = DB::table('hrd_religion')->get();
        $infonation   = DB::table('hrd_nationality')->get();
        $infocitizen  = DB::table('hrd_citizenship')->get();
        $infosex      = DB::table('hrd_sex')->get();
        $infoblood    = DB::table('hrd_bloodgroup')->get();

        $infoprovince = DB::table('hrd_province')->get();

        $infoid = DB::table('hrd_person')->where('hrd_person.ID', '=', $iduser)->first();

        $infodepartment         = DB::table('hrd_department')->get();
        $infodepartment_sub     = DB::table('hrd_department_sub')->get();
        $infodepartment_sub_sub = DB::table('hrd_department_sub_sub')->get();
        $infolevel              = DB::table('hrd_level')->get();
        $infostatus             = DB::table('hrd_status')->get();
        $infokind               = DB::table('hrd_kind')->get();
        $infokind_type          = DB::table('hrd_kind_type')->get();
        $infoperson_type        = DB::table('hrd_person_type')->get();
        $infoposition           = DB::table('hrd_position')->get();

        $name_userdetail = DB::table('users')->where('PERSON_ID', '=', $iduser)->first();
        if ($name_userdetail != null) {
            $name_user = $name_userdetail->username;
        } else {
            $name_user = '';
        }

        return view('manager_person.edituser', [
            'inforpersons'            => $inforperson,
            'infoprefixs'             => $infoprefix,
            'infomarrys'              => $infomarry,
            'inforeligions'           => $inforeligion,
            'infonations'             => $infonation,
            'infocitizens'            => $infocitizen,
            'infosexs'                => $infosex,
            'infobloods'              => $infoblood,
            'infoid'                  => $infoid,
            'infoprovinces'           => $infoprovince,
            'inforperson_add1'        => $inforperson_add1,
            'infodepartments'         => $infodepartment,
            'infodepartment_subs'     => $infodepartment_sub,
            'infodepartment_sub_subs' => $infodepartment_sub_sub,
            'infolevels'              => $infolevel,
            'infostatuss'             => $infostatus,
            'infokinds'               => $infokind,
            'infokind_types'          => $infokind_type,
            'infoperson_types'        => $infoperson_type,
            'infopositions'           => $infoposition,
            'name_user'               => $name_user

        ]);
    }

    public function editinfouserupdate(Request $request)
    {
        $checkstart = $request->STARTWORK;
        $checkvcode = $request->VCODE_DATE;

        $iduser = $request->USER_ID;

        $BIRTHDAY    = Carbon::createFromFormat('d/m/Y', $request->HR_BIRTHDAY)->format('Y-m-d');
        $date_arrary = explode("-", $BIRTHDAY);
        $y_sub       = $date_arrary[0];

        if ($y_sub >= 2500) {
            $y = $y_sub - 543;
        } else {
            $y = $y_sub;
        }

        $m                = $date_arrary[1];
        $d                = $date_arrary[2];
        $displaybirthdate = $y . "-" . $m . "-" . $d;

        if ($checkstart != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $checkstart)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $displaystartdate = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $displaystartdate = null;
        }
        if ($checkvcode != '') {
            $VCODEDAY      = Carbon::createFromFormat('d/m/Y', $checkvcode)->format('Y-m-d');
            $date_arrary_v = explode("-", $VCODEDAY);
            $y_sub_v       = $date_arrary_v[0];

            if ($y_sub_v >= 2500) {
                $y_v = $y_sub_v - 543;
            } else {
                $y_v = $y_sub_v;
            }
            $m_v              = $date_arrary_v[1];
            $d_v              = $date_arrary_v[2];
            $displayvcodedate = $y_v . "-" . $m_v . "-" . $d_v;
        } else {
            $displayvcodedate = null;
        }

        $inforpersonedit = Person::find($iduser);

        //$inforpersonedit->timestamps = false;
        $inforpersonedit->HR_PREFIX_ID       = $request->HR_PREFIX;
        $inforpersonedit->HR_FNAME           = $request->HR_FNAME;
        $inforpersonedit->HR_LNAME           = $request->HR_LNAME;
        $inforpersonedit->HR_EN_NAME         = $request->HR_EN_NAME;
        $inforpersonedit->NICKNAME           = $request->NICKNAME;
        $inforpersonedit->HR_BIRTHDAY        = $displaybirthdate;
        $inforpersonedit->HR_CID             = $request->HR_CID;
        $inforpersonedit->HR_MARRY_STATUS_ID = $request->HR_MARRY_STATUS;
        $inforpersonedit->HR_RELIGION_ID     = $request->HR_RELIGION;
        $inforpersonedit->HR_NATIONALITY_ID  = $request->HR_NATIONALITY;
        $inforpersonedit->HR_CITIZENSHIP_ID  = $request->HR_CITIZENSHIP;
        $inforpersonedit->SEX                = $request->SEX;
        $inforpersonedit->HR_BLOODGROUP_ID   = $request->HR_BLOODGROUP;
        $inforpersonedit->HR_HIGH            = $request->HR_HIGH;
        $inforpersonedit->HR_WEIGHT          = $request->HR_WEIGHT;
        $inforpersonedit->HR_PHONE           = $request->HR_PHONE;
        $inforpersonedit->HR_EMAIL           = $request->HR_EMAIL;
        $inforpersonedit->HR_FACEBOOK        = $request->HR_FACEBOOK;
        $inforpersonedit->HR_LINE            = $request->HR_LINE;

        $inforpersonedit->HR_DEPARTMENT_ID         = $request->HR_DEPARTMENT;
        $inforpersonedit->HR_DEPARTMENT_SUB_ID     = $request->DEPARTMENT_SUB;
        $inforpersonedit->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB;

        $inforpersonedit->HR_STARTWORK_DATE = $displaystartdate;

        $inforpersonedit->HR_POSITION_NUM = $request->HR_POSITION_NUM;
        $inforpersonedit->VCODE           = $request->VCODE;

        $inforpersonedit->VCODE_DATE   = $displayvcodedate;
        $inforpersonedit->HR_AGENCY_ID = $request->HR_AGENCY_ID;

        $position = DB::table('hrd_position')
            ->where('HR_POSITION_ID', '=', $request->POSITION_IN_WORK)
            ->first();
        $inforpersonedit->POSITION_IN_WORK = $position->HR_POSITION_NAME;

        $inforpersonedit->HR_POSITION_ID    = $request->POSITION_IN_WORK;
        $inforpersonedit->HR_LEVEL_ID       = $request->HR_LEVEL;
        $inforpersonedit->HR_STATUS_ID      = $request->HR_STATUS;
        $inforpersonedit->HR_KIND_ID        = $request->HR_KIND;
        $inforpersonedit->HR_KIND_TYPE_ID   = $request->HR_KIND_TYPE;
        $inforpersonedit->HR_PERSON_TYPE_ID = $request->HR_PERSON_TYPE;
        $inforpersonedit->HR_SALARY         = $request->HR_SALARY;
        $inforpersonedit->MONEY_POSITION    = $request->MONEY_POSITION;

        $inforpersonedit->HR_HOME_NUMBER = $request->HR_HOME_NUMBER;
        $inforpersonedit->HR_VILLAGE_NO  = $request->HR_VILLAGE_NO;
        $inforpersonedit->HR_ROAD_NAME   = $request->HR_ROAD_NAME;
        $inforpersonedit->HR_SOI_NAME    = $request->HR_SOI_NAME;
        $inforpersonedit->PROVINCE_ID    = $request->PROVINCE_NAME;
        $inforpersonedit->AMPHUR_ID      = $request->AMPHUR_NAME;
        $inforpersonedit->TUMBON_ID      = $request->TUMBON_NAME;
        $inforpersonedit->HR_ZIPCODE     = $request->HR_ZIPCODE;

        $inforpersonedit->HR_HOME_NUMBER_1 = $request->HR_HOME_NUMBER_1;
        $inforpersonedit->HR_VILLAGE_NO_1  = $request->HR_VILLAGE_NO_1;
        $inforpersonedit->HR_ROAD_NAME_1   = $request->HR_ROAD_NAME_1;
        $inforpersonedit->PROVINCE_ID_1    = $request->PROVINCE_NAME_1;
        $inforpersonedit->AMPHUR_ID_1      = $request->AMPHUR_NAME_1;
        $inforpersonedit->TUMBON_ID_1      = $request->TUMBON_NAME_1;
        $inforpersonedit->HR_ZIPCODE_1     = $request->HR_ZIPCODE_1;

        $inforpersonedit->BOOK_BANK_NUMBER = $request->BOOK_BANK_NUMBER;
        $inforpersonedit->BOOK_BANK_NAME   = $request->BOOK_BANK_NAME;
        $inforpersonedit->BOOK_BANK        = $request->BOOK_BANK;
        $inforpersonedit->BOOK_BANK_BRANCH = $request->BOOK_BANK_BRANCH;

        $inforpersonedit->BOOK_BANK_OT_NUMBER = $request->BOOK_BANK_OT_NUMBER;
        $inforpersonedit->BOOK_BANK_OT_NAME   = $request->BOOK_BANK_OT_NAME;
        $inforpersonedit->BOOK_BANK_OT        = $request->BOOK_BANK_OT;
        $inforpersonedit->BOOK_BANK_OT_BRANCH = $request->BOOK_BANK_OT_BRANCH;

        $picid = $request->HR_CID;

        if ($request->hasFile('picture')) {
            //$newFileName = $picid.'.'.$request->picture->extension();

            $file                      = $request->file('picture');
            $contents                  = $file->openFile()->fread($file->getSize());
            $inforpersonedit->HR_IMAGE = $contents;
            //$request->picture->storeAs('images',$newFileName,'public');
            //$inforpersonedit->HR_IMAGE_NAME = $newFileName;
        }

        //dd($inforpersonedit);
        $inforpersonedit->save();

        $inforuserdit        = Adduser::where('PERSON_ID', '=', $iduser)->first();
        $inforuserdit->name  = $request->HR_FNAME . ' ' . $request->HR_LNAME;
        $inforuserdit->email = $request->HR_EMAIL;
        $inforuserdit->save();

        //dd($inforpersonedit);

        return redirect()->route('mperson.infouser', ['iduser' => $iduser]);

        //return $displaybirthdate;

    }

    //=========================

    public function setupjobdescription(Request $request)
    {

        $jobdescription = Infoworkjobdis::get();

        return view('manager_person.setupjobdescription', [
            'jobdescriptions' => $jobdescription
        ]);
    }

    public function setupjobdescription_add(Request $request)
    {

        return view('manager_person.setupjobdescription_add');
    }

    public function setupjobdescription_save(Request $request)
    {

        $add               = new Infoworkjobdis();
        $add->JOD_DIS_NAME = $request->JOD_DIS_NAME;
        $add->save();

        return redirect()->action('ManagerpersonController@setupjobdescription');
    }

    public function setupjobdescriptionposition(Request $request, $idref)
    {
        $infojob = Infoworkjobdis::where('JOD_DIS_ID', '=', $idref)->first();

        $jobposition = Infoworkjobdisposition::where('JOD_DIS_ID', '=', $idref)->get();

        $infoposition = DB::table('hrd_position')->get();

        return view('manager_person.setupjobdescription_position', [
            'jobpositions'  => $jobposition,
            'infojob'       => $infojob,
            'infopositions' => $infoposition
        ]);
    }

    public function setupjobdescriptionposition_save(Request $request)
    {

        $add                  = new Infoworkjobdisposition();
        $add->JOD_DIS_ID      = $request->JOD_DIS_ID;
        $add->JOD_POSITION_ID = $request->JOD_POSITION_ID;

        $infoposition           = DB::table('hrd_position')->where('HR_POSITION_ID', '=', $request->JOD_POSITION_ID)->first();
        $add->JOD_POSITION_NAME = $infoposition->HR_POSITION_NAME;
        $add->save();

        $idref = $request->JOD_DIS_ID;

        return redirect()->action('ManagerpersonController@setupjobdescriptionposition', [
            'idref' => $idref
        ]);
    }

    public function setupjobdescriptionposition_destroy($idref, $id)
    {

        Infoworkjobdisposition::destroy($id);
        //return redirect()->action('SalaryController@infousersalary');
        return redirect()->action('ManagerpersonController@setupjobdescriptionposition', [
            'idref' => $idref
        ]);
    }

    public function setupjobdescription_edit(Request $request, $idref)
    {
        $infojob = Infoworkjobdis::where('JOD_DIS_ID', '=', $idref)->first();

        return view('manager_person.setupjobdescription_edit', [
            'infojob' => $infojob
        ]);
    }

    public function setupjobdescription_update(Request $request)
    {

        $id                   = $request->JOD_DIS_ID;
        $update               = Infoworkjobdis::find($id);
        $update->JOD_DIS_NAME = $request->JOD_DIS_NAME;
        $update->save();

        return redirect()->action('ManagerpersonController@setupjobdescription');
    }

    public function setupjobdescription_destroy($idref)
    {

        Infoworkjobdis::destroy($idref);
        //return redirect()->action('SalaryController@infousersalary');
        return redirect()->action('ManagerpersonController@setupjobdescription');
    }

    //-------------------------------

    public function setupcorecompetency(Request $request)
    {

        $corecompetecy = Infoworkcorcom::get();

        return view('manager_person.setupcorecompetency', [
            'corecompetecys' => $corecompetecy
        ]);
    }

    public function setupcorecompetency_add(Request $request)
    {

        return view('manager_person.setupcorecompetency_add');
    }

    public function setupcorecompetency_save(Request $request)
    {

        $add                 = new Infoworkcorcom();
        $add->COR_COM_NAME   = $request->COR_COM_NAME;
        $add->COR_COM_DETAIL = $request->COR_COM_DETAIL;
        $add->save();

        return redirect()->action('ManagerpersonController@setupcorecompetency');
    }

    public function setupcorecompetency_edit(Request $request, $idref)
    {
        $infocorcom = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();

        return view('manager_person.setupcorecompetency_edit', [
            'infocorcom' => $infocorcom
        ]);
    }

    public function setupcorecompetency_update(Request $request)
    {

        $id                     = $request->COR_COM_ID;
        $update                 = Infoworkcorcom::find($id);
        $update->COR_COM_NAME   = $request->COR_COM_NAME;
        $update->COR_COM_DETAIL = $request->COR_COM_DETAIL;
        $update->save();

        return redirect()->action('ManagerpersonController@setupcorecompetency');
    }

    public function setupcorecompetency_destroy($idref)
    {

        Infoworkcorcom::destroy($idref);
        //return redirect()->action('SalaryController@infousersalary');
        return redirect()->action('ManagerpersonController@setupcorecompetency');
    }

    //----------------------------------เพิ่มระดับ

    public function setupcorecompetencylevel(Request $request, $idref)
    {
        $infocorcom = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();

        $infocorcomlevel = DB::table('infowork_cor_com_level')->where('COR_COM_ID', '=', $idref)->get();

        return view('manager_person.setupcorecompetencylevel', [
            'infocorcom'       => $infocorcom,
            'infocorcomlevels' => $infocorcomlevel
        ]);
    }

    public function setupcorecompetencylevel_add(Request $request, $idref)
    {

        $infoscoretype = DB::table('infowork_type_score')->get();

        $infocorcom = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();

        return view('manager_person.setupcorecompetencylevel_add', [
            'idref'          => $idref,
            'infocorcom'     => $infocorcom,
            'infoscoretypes' => $infoscoretype
        ]);
    }

    public function setupcorecompetencylevel_save(Request $request)
    {

        $add                       = new Infoworkcorcomlevel();
        $add->COR_COM_ID           = $request->COR_COM_ID;
        $add->COR_COM_LEVEL_DETAIL = $request->COR_COM_LEVEL_DETAIL;
        $add->save();

        $COR_COM_LEVEL_ID = Infoworkcorcomlevel::max('COR_COM_LEVEL_ID');

        if ($request->COR_COM_LEVEL_SUB_NUMBER[0] != '' || $request->COR_COM_LEVEL_SUB_NUMBER[0] != null) {

            $COR_COM_LEVEL_SUB_NUMBER = $request->COR_COM_LEVEL_SUB_NUMBER;
            $COR_COM_LEVEL_SUB_DETAIL = $request->COR_COM_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($COR_COM_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkcorcomlevelsub();
                $addsup->COR_COM_LEVEL_ID         = $COR_COM_LEVEL_ID;
                $addsup->COR_COM_LEVEL_SUB_NUMBER = $COR_COM_LEVEL_SUB_NUMBER[$count];
                $addsup->COR_COM_LEVEL_SUB_DETAIL = $COR_COM_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->COR_COM_ID;

        return redirect()->action('ManagerpersonController@setupcorecompetencylevel', [
            'idref' => $idref
        ]);
    }

    public function setupcorecompetencylevel_edit(Request $request, $idref, $id)
    {

        $infoscoretype      = DB::table('infowork_type_score')->get();
        $infocorcom         = Infoworkcorcom::where('COR_COM_ID', '=', $idref)->first();
        $infocorcomlevel    = Infoworkcorcomlevel::where('COR_COM_LEVEL_ID', '=', $id)->first();
        $infocorcomlevelsub = Infoworkcorcomlevelsub::where('COR_COM_LEVEL_ID', '=', $id)->get();

        return view('manager_person.setupcorecompetencylevel_edit', [
            'idref'               => $idref,
            'infocorcom'          => $infocorcom,
            'infoscoretypes'      => $infoscoretype,
            'infocorcomlevel'     => $infocorcomlevel,
            'infocorcomlevelsubs' => $infocorcomlevelsub
        ]);
    }

    public function setupcorecompetencylevel_update(Request $request)
    {

        $id = $request->COR_COM_LEVEL_ID;

        $update                       = Infoworkcorcomlevel::find($id);
        $update->COR_COM_ID           = $request->COR_COM_ID;
        $update->COR_COM_LEVEL_DETAIL = $request->COR_COM_LEVEL_DETAIL;
        $update->save();

        $COR_COM_LEVEL_ID = $id;

        Infoworkcorcomlevelsub::where('COR_COM_LEVEL_ID', '=', $id)->delete();

        if ($request->COR_COM_LEVEL_SUB_NUMBER[0] != '' || $request->COR_COM_LEVEL_SUB_NUMBER[0] != null) {

            $COR_COM_LEVEL_SUB_NUMBER = $request->COR_COM_LEVEL_SUB_NUMBER;
            $COR_COM_LEVEL_SUB_DETAIL = $request->COR_COM_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($COR_COM_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkcorcomlevelsub();
                $addsup->COR_COM_LEVEL_ID         = $COR_COM_LEVEL_ID;
                $addsup->COR_COM_LEVEL_SUB_NUMBER = $COR_COM_LEVEL_SUB_NUMBER[$count];
                $addsup->COR_COM_LEVEL_SUB_DETAIL = $COR_COM_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->COR_COM_ID;

        return redirect()->action('ManagerpersonController@setupcorecompetencylevel', [
            'idref' => $idref
        ]);
    }

    //------------------------------------------------
    public function setupfuntionalcompetency(Request $request)
    {

        $funtion = Infoworkfuntion::get();

        return view('manager_person.setupfuntionalcompetency', [
            'funtions' => $funtion
        ]);
    }

    public function setupfuntionalcompetency_add(Request $request)
    {
        return view('manager_person.setupfuntionalcompetency_add');
    }

    public function setupfuntionalcompetency_save(Request $request)
    {

        $add                 = new Infoworkfuntion();
        $add->FUNTION_NAME   = $request->FUNTION_NAME;
        $add->FUNTION_DETAIL = $request->FUNTION_DETAIL;
        $add->save();

        return redirect()->action('ManagerpersonController@setupfuntionalcompetency');
    }

    public function setupfuntionalcompetencyposition(Request $request, $idref)
    {
        $infofun = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();

        $funposition = Infoworkfuntionposition::where('FUNTION_ID', '=', $idref)->get();

        $infoposition = DB::table('hrd_position')->get();

        return view('manager_person.setupfuntionalcompetency_position', [
            'funpositions'  => $funposition,
            'infofun'       => $infofun,
            'infopositions' => $infoposition
        ]);
    }

    public function setupfuntionalcompetencyposition_save(Request $request)
    {

        $add                  = new Infoworkfuntionposition();
        $add->FUNTION_ID      = $request->FUNTION_ID;
        $add->FUN_POSITION_ID = $request->FUN_POSITION_ID;

        $infoposition           = DB::table('hrd_position')->where('HR_POSITION_ID', '=', $request->FUN_POSITION_ID)->first();
        $add->FUN_POSITION_NAME = $infoposition->HR_POSITION_NAME;
        $add->save();

        $idref = $request->FUNTION_ID;

        return redirect()->action('ManagerpersonController@setupfuntionalcompetencyposition', [
            'idref' => $idref
        ]);
    }

    public function setupfuntionalcompetencyposition_destroy($idref, $id)
    {

        Infoworkfuntionposition::destroy($id);
        //return redirect()->action('SalaryController@infousersalary');
        return redirect()->action('ManagerpersonController@setupfuntionalcompetencyposition', [
            'idref' => $idref
        ]);
    }

    public function setupfuntionalcompetency_edit(Request $request, $idref)
    {
        $infofuntion = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();

        return view('manager_person.setupfuntionalcompetency_edit', [
            'infofuntion' => $infofuntion
        ]);
    }

    public function setupfuntionalcompetency_update(Request $request)
    {

        $id                     = $request->FUNTION_ID;
        $update                 = Infoworkfuntion::find($id);
        $update->FUNTION_NAME   = $request->FUNTION_NAME;
        $update->FUNTION_DETAIL = $request->FUNTION_DETAIL;
        $update->save();

        return redirect()->action('ManagerpersonController@setupfuntionalcompetency');
    }

    public function setupfuntionalcompetency_destroy($idref)
    {

        Infoworkfuntion::destroy($idref);
        //return redirect()->action('SalaryController@infousersalary');
        return redirect()->action('ManagerpersonController@setupfuntionalcompetency');
    }

    //----------------------------------เพิ่มระดับ

    public function setupfuntionalcompetencylevel(Request $request, $idref)
    {
        $infofuntion = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();

        $infofuntionlevel = Infoworkfuntionlevel::where('FUNTION_ID', '=', $idref)->get();

        return view('manager_person.setupfuntionalcompetencylevel', [
            'infofuntion'       => $infofuntion,
            'infofuntionlevels' => $infofuntionlevel
        ]);
    }

    public function setupfuntionalcompetencylevel_add(Request $request, $idref)
    {
        $infoscoretype = DB::table('infowork_type_score')->get();

        return view('manager_person.setupfuntionalcompetencylevel_add', [
            'idref'          => $idref,
            'infoscoretypes' => $infoscoretype
        ]);
    }

    public function setupfuntionalcompetencylevel_save(Request $request)
    {

        $add                       = new Infoworkfuntionlevel();
        $add->FUNTION_ID           = $request->FUNTION_ID;
        $add->FUNTION_LEVEL_DETAIL = $request->FUNTION_LEVEL_DETAIL;
        $add->save();

        $FUNTION_LEVEL_ID = Infoworkfuntionlevel::max('FUNTION_LEVEL_ID');

        if ($request->FUNTION_LEVEL_SUB_NUMBER[0] != '' || $request->FUNTION_LEVEL_SUB_NUMBER[0] != null) {

            $FUNTION_LEVEL_SUB_NUMBER = $request->FUNTION_LEVEL_SUB_NUMBER;
            $FUNTION_LEVEL_SUB_DETAIL = $request->FUNTION_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($FUNTION_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkfuntionlevelsub();
                $addsup->FUNTION_LEVEL_ID         = $FUNTION_LEVEL_ID;
                $addsup->FUNTION_LEVEL_SUB_NUMBER = $FUNTION_LEVEL_SUB_NUMBER[$count];
                $addsup->FUNTION_LEVEL_SUB_DETAIL = $FUNTION_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->FUNTION_ID;

        return redirect()->action('ManagerpersonController@setupfuntionalcompetencylevel', [
            'idref' => $idref
        ]);
    }

    public function setupfuntionalcompetencylevel_edit(Request $request, $idref, $id)
    {

        $infoscoretype   = DB::table('infowork_type_score')->get();
        $infofun         = Infoworkfuntion::where('FUNTION_ID', '=', $idref)->first();
        $infofunlevel    = Infoworkfuntionlevel::where('FUNTION_LEVEL_ID', '=', $id)->first();
        $infofunlevelsub = Infoworkfuntionlevelsub::where('FUNTION_LEVEL_ID', '=', $id)->get();

        return view('manager_person.setupfuntionalcompetencylevel_edit', [
            'idref'            => $idref,
            'infofun'          => $infofun,
            'infoscoretypes'   => $infoscoretype,
            'infofunlevel'     => $infofunlevel,
            'infofunlevelsubs' => $infofunlevelsub

        ]);
    }

    public function setupfuntionalcompetencylevel_update(Request $request)
    {

        $id = $request->FUNTION_LEVEL_ID;

        $add                       = Infoworkfuntionlevel::find($id);
        $add->FUNTION_ID           = $request->FUNTION_ID;
        $add->FUNTION_LEVEL_DETAIL = $request->FUNTION_LEVEL_DETAIL;
        $add->save();

        Infoworkfuntionlevelsub::where('FUNTION_LEVEL_ID', '=', $id)->delete();

        $FUNTION_LEVEL_ID = $id;

        if ($request->FUNTION_LEVEL_SUB_NUMBER[0] != '' || $request->FUNTION_LEVEL_SUB_NUMBER[0] != null) {

            $FUNTION_LEVEL_SUB_NUMBER = $request->FUNTION_LEVEL_SUB_NUMBER;
            $FUNTION_LEVEL_SUB_DETAIL = $request->FUNTION_LEVEL_SUB_DETAIL;
            $TYPE_SCORE_ID            = $request->TYPE_SCORE_ID;

            $number = count($FUNTION_LEVEL_SUB_NUMBER);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                           = new Infoworkfuntionlevelsub();
                $addsup->FUNTION_LEVEL_ID         = $FUNTION_LEVEL_ID;
                $addsup->FUNTION_LEVEL_SUB_NUMBER = $FUNTION_LEVEL_SUB_NUMBER[$count];
                $addsup->FUNTION_LEVEL_SUB_DETAIL = $FUNTION_LEVEL_SUB_DETAIL[$count];
                $addsup->TYPE_SCORE_ID            = $TYPE_SCORE_ID[$count];
                $addsup->save();

            }
        }

        $idref = $request->FUNTION_ID;

        return redirect()->action('ManagerpersonController@setupfuntionalcompetencylevel', [
            'idref' => $idref
        ]);
    }

    //---------------------------------------------------------------------
    public function resultability(Request $request)
    {

        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->orderBy('hrd_person.ID', 'desc')
            ->get();

        return view('manager_person.resultability', [
            'persons' => $person

        ]);
    }

    public function setupsetscore(Request $request)
    {
        $typescore = Infoworktypescore::get();

        return view('manager_person.setupsetscore', [
            'typescores' => $typescore
        ]);
    }

    public function setupsetscore_add(Request $request)
    {

        return view('manager_person.setupsetscore_add');
    }

    public function setupsetscore_save(Request $request)
    {

        $add                  = new Infoworktypescore();
        $add->TYPE_SCORE_NAME = $request->TYPE_SCORE_NAME;
        $add->save();

        $TYPE_SCORE_ID = Infoworktypescore::max('TYPE_SCORE_ID');

        if ($request->TYPE_SCORE_SUB_TOTAL[0] != '' || $request->TYPE_SCORE_SUB_TOTAL[0] != null) {

            $TYPE_SCORE_SUB_TOTAL = $request->TYPE_SCORE_SUB_TOTAL;
            $TYPE_SCORE_SUB_NAME  = $request->TYPE_SCORE_SUB_NAME;

            $number = count($TYPE_SCORE_SUB_TOTAL);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                       = new Infoworktypescoresub();
                $addsup->TYPE_SCORE_ID        = $TYPE_SCORE_ID;
                $addsup->TYPE_SCORE_SUB_TOTAL = $TYPE_SCORE_SUB_TOTAL[$count];
                $addsup->TYPE_SCORE_SUB_NAME  = $TYPE_SCORE_SUB_NAME[$count];
                $addsup->save();

            }
        }

        return redirect()->action('ManagerpersonController@setupsetscore');
    }

    public function setupsetscore_edit(Request $request, $idref)
    {
        $infotypescore    = Infoworktypescore::where('TYPE_SCORE_ID', '=', $idref)->first();
        $infotypescoresub = Infoworktypescoresub::where('TYPE_SCORE_ID', '=', $idref)->get();

        return view('manager_person.setupsetscore_edit', [
            'infotypescore'     => $infotypescore,
            'infotypescoresubs' => $infotypescoresub

        ]);
    }

    public function setupsetscore_update(Request $request)
    {

        $id = $request->TYPE_SCORE_ID;

        $add                  = Infoworktypescore::find($id);
        $add->TYPE_SCORE_NAME = $request->TYPE_SCORE_NAME;
        $add->save();

        $TYPE_SCORE_ID = $id;

        Infoworktypescoresub::where('TYPE_SCORE_ID', '=', $id)->delete();

        if ($request->TYPE_SCORE_SUB_TOTAL[0] != '' || $request->TYPE_SCORE_SUB_TOTAL[0] != null) {

            $TYPE_SCORE_SUB_TOTAL = $request->TYPE_SCORE_SUB_TOTAL;
            $TYPE_SCORE_SUB_NAME  = $request->TYPE_SCORE_SUB_NAME;

            $number = count($TYPE_SCORE_SUB_TOTAL);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addsup                       = new Infoworktypescoresub();
                $addsup->TYPE_SCORE_ID        = $TYPE_SCORE_ID;
                $addsup->TYPE_SCORE_SUB_TOTAL = $TYPE_SCORE_SUB_TOTAL[$count];
                $addsup->TYPE_SCORE_SUB_NAME  = $TYPE_SCORE_SUB_NAME[$count];
                $addsup->save();

            }
        }

        return redirect()->action('ManagerpersonController@setupsetscore');
    }

    public function jobdescription(Request $request)
    {

        $infojabdis = DB::table('infowork_job_dis')->get();
        return view('manager_person.jobdescription', [
            'infojabdiss' => $infojabdis

        ]);
    }

    //----------------------------------------------

    public function setupkpis(Request $request)
    {
        $infoworkkpis = DB::table('infowork_kpis')->get();

        return view('manager_person.setupkpis', [
            'infoworkkpis' => $infoworkkpis
        ]);
    }

    public function setupkpis_add(Request $request)
    {

        return view('manager_person.setupkpis_add');
    }

    public function setupkpis_save(Request $request)
    {

        $add            = new Infoworkkpis();
        $add->KPIS_CODE = $request->KPIS_CODE;
        $add->KPIS_NAME = $request->KPIS_NAME;
        $add->save();

        return redirect()->action('ManagerpersonController@setupkpis');
    }

    public function setupkpis_edit(Request $request, $idref)
    {
        $infoworkkpis = DB::table('infowork_kpis')->where('KPIS_ID', '=', $idref)->first();

        return view('manager_person.setupkpis_edit', [
            'infokpis' => $infoworkkpis
        ]);
    }

    public function setupkpis_update(Request $request)
    {
        $id = $request->KPIS_ID;

        $add            = Infoworkkpis::find($id);
        $add->KPIS_CODE = $request->KPIS_CODE;
        $add->KPIS_NAME = $request->KPIS_NAME;
        $add->save();

        return redirect()->action('ManagerpersonController@setupkpis');
    }

    public function setupkpis_destroy($idref)
    {

        Infoworkkpis::destroy($idref);
        //return redirect()->action('SalaryController@infousersalary');
        return redirect()->action('ManagerpersonController@setupkpis');
    }

    //===============================================

    public function setupsetscoreweight(Request $request)
    {
        return view('manager_person.setupsetscoreweight');
    }

    public function setupsetscoreweight_add(Request $request)
    {
        return view('manager_person.setupsetscoreweight_add');
    }

    public function setupsetscoreweight_edit(Request $request)
    {
        return view('manager_person.setupsetscoreweight_edit');
    }

    //================================================

    public function kpis_detail(Request $request)
    {
        return view('manager_person.kpis_detail');
    }

    public function funtionalcompetency_detail(Request $request)
    {
        return view('manager_person.funtionalcompetency_detail');
    }

    public function corecompetency_detail(Request $request)
    {
        return view('manager_person.corecompetency_detail');
    }

    //===================================================

    public function kpis(Request $request)
    {

        $infokpiorg = DB::table('plan_kpi')->get();

        $infokpiperson = DB::table('infowork_kpis')->get();

        return view('manager_person.kpis', [
            'infokpiorgs'    => $infokpiorg,
            'infokpipersons' => $infokpiperson
        ]);
    }

    public function funtionalcompetency(Request $request)
    {
        $infoworkfuntion = DB::table('infowork_funtion')->get();

        return view('manager_person.funtionalcompetency', [
            'infoworkfuntions' => $infoworkfuntion
        ]);
    }

    public function corecompetency(Request $request)
    {
        $infoworkcorcom = DB::table('infowork_cor_com')->get();
        return view('manager_person.corecompetency', [
            'infoworkcorcoms' => $infoworkcorcom
        ]);
    }

    public function checkscore(Request $request)
    {
        $idscore = $request->SCORE;
        $idhead  = $request->idhead;

        $inforscore = DB::table('infowork_type_score_sub')->where('TYPE_SCORE_SUB_ID', '=', $idscore)->first();

        echo '<input type="hidden" name="sum' . $idhead . '" id="scorenum' . $idhead . '" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" value="' . $inforscore->TYPE_SCORE_SUB_TOTAL . '">' . $inforscore->TYPE_SCORE_SUB_TOTAL;

    }

    //=============================================

    public function capacity_main()
    {
        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->where('hrd_person.HR_STATUS_ID', '<>', 5)
            ->where('hrd_person.HR_STATUS_ID', '<>', 6)
            ->where('hrd_person.HR_STATUS_ID', '<>', 7)
            ->where('hrd_person.HR_STATUS_ID', '<>', 8)
            ->orderBy('hrd_person.ID', 'desc')
            ->get();

        return view('manager_person.capacity_main', [
            'persons' => $person

        ]);
    }

    public function capacity(Request $request, $iduser)
    {

        $infocapa = DB::table('infowork_capacity')->where('CAPACITY_PERSON_ID', '=', $iduser)->get();

        $infouser = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkcapacity', [
            'infouser'  => $infouser,
            'infocapas' => $infocapa

        ]);
    }

    public function capacity_detail(Request $request, $iduser, $idref)
    {

        $infocapacity = DB::table('infowork_capacity')->where('CAPACITY_ID', '=', $idref)->first();
        $infouser     = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkcapacity_detail', [
            'infocapacity' => $infocapacity,
            'infouser'     => $infouser
        ]);
    }

    public function capacity_add(Request $request, $iduser)
    {
        $infouser = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkcapacity_add', [
            'infouser' => $infouser
        ]);
    }

    public function capacity_save(Request $request)
    {

        $CAPACITY_TESTDATE = $request->CAPACITY_TEST_DATE;

        if ($CAPACITY_TESTDATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CAPACITY_TESTDATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $CAPACITYTESTDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CAPACITYTESTDATE = null;
        }

        $add                            = new Infoworkcapacity();
        $add->CAPACITY_PERSON_ID        = $request->CAPACITY_PERSON_ID;
        $add->CAPACITY_YEAR             = $request->CAPACITY_YEAR;
        $add->CAPACITY_HEIGHT           = $request->CAPACITY_HEIGHT;
        $add->CAPACITY_WEIGHT           = $request->CAPACITY_WEIGHT;
        $add->CAPACITY_TEST_DATE        = $CAPACITYTESTDATE;
        $add->CAPACITY_HEARTRATE_RESULT = $request->CAPACITY_HEARTRATE_RESULT;
        $add->CAPACITY_HEARTRATE_LEVEL  = $request->CAPACITY_HEARTRATE_LEVEL;
        $add->CAPACITY_HEARTRATE_AVG    = $request->CAPACITY_HEARTRATE_AVG;
        $add->CAPACITY_HEARTRATE_NOMAL  = $request->CAPACITY_HEARTRATE_NOMAL;
        $add->CAPACITY_BLOOD_RESULT     = $request->CAPACITY_BLOOD_RESULT;
        $add->CAPACITY_BLOOD_LEVEL      = $request->CAPACITY_BLOOD_LEVEL;
        $add->CAPACITY_BLOOD_AVG        = $request->CAPACITY_BLOOD_AVG;
        $add->CAPACITY_BLOOD_NOMAL      = $request->CAPACITY_BLOOD_NOMAL;
        $add->CAPACITY_BODY_RESULT      = $request->CAPACITY_BODY_RESULT;
        $add->CAPACITY_BODY_LEVEL       = $request->CAPACITY_BODY_LEVEL;
        $add->CAPACITY_BODY_AVG         = $request->CAPACITY_BODY_AVG;
        $add->CAPACITY_BODY_NOMAL       = $request->CAPACITY_BODY_NOMAL;
        $add->CAPACITY_WAISTLINE_RESULT = $request->CAPACITY_WAISTLINE_RESULT;
        $add->CAPACITY_WAISTLINE_LEVEL  = $request->CAPACITY_WAISTLINE_LEVEL;
        $add->CAPACITY_WAISTLINE_AVG    = $request->CAPACITY_WAISTLINE_AVG;
        $add->CAPACITY_WAISTLINE_NOMAL  = $request->CAPACITY_WAISTLINE_NOMAL;
        $add->CAPACITY_FAT_RESULT       = $request->CAPACITY_FAT_RESULT;
        $add->CAPACITY_FAT_LEVEL        = $request->CAPACITY_FAT_LEVEL;
        $add->CAPACITY_FAT_AVG          = $request->CAPACITY_FAT_AVG;
        $add->CAPACITY_FAT_NOMAL        = $request->CAPACITY_FAT_NOMAL;
        $add->CAPACITY_LUNG_RESULT      = $request->CAPACITY_LUNG_RESULT;
        $add->CAPACITY_LUNG_LEVEL       = $request->CAPACITY_LUNG_LEVEL;
        $add->CAPACITY_LUNG_AVG         = $request->CAPACITY_LUNG_AVG;
        $add->CAPACITY_LUNG_NOMAL       = $request->CAPACITY_LUNG_NOMAL;
        $add->CAPACITY_HAND_RESULT      = $request->CAPACITY_HAND_RESULT;
        $add->CAPACITY_HAND_LEVEL       = $request->CAPACITY_HAND_LEVEL;
        $add->CAPACITY_HAND_AVG         = $request->CAPACITY_HAND_AVG;
        $add->CAPACITY_LEG_RESULT       = $request->CAPACITY_LEG_RESULT;
        $add->CAPACITY_LEG_LEVEL        = $request->CAPACITY_LEG_LEVEL;
        $add->CAPACITY_LEG_AVG          = $request->CAPACITY_LEG_AVG;
        $add->CAPACITY_CULEDUP_RESULT   = $request->CAPACITY_CULEDUP_RESULT;
        $add->CAPACITY_CULEDUP_LEVEL    = $request->CAPACITY_CULEDUP_LEVEL;
        $add->CAPACITY_CULEDUP_AVG      = $request->CAPACITY_CULEDUP_AVG;
        $add->save();

        return redirect()->action('ManagerpersonController@capacity', [
            'iduser' => $request->CAPACITY_PERSON_ID
        ]);
    }

    public function capacity_update(Request $request)
    {

        $CAPACITY_TESTDATE = $request->CAPACITY_TEST_DATE;

        if ($CAPACITY_TESTDATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CAPACITY_TESTDATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st             = $date_arrary_st[1];
            $d_st             = $date_arrary_st[2];
            $CAPACITYTESTDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CAPACITYTESTDATE = null;
        }

        $id = $request->IDREF;

        $add                            = Infoworkcapacity::find($id);
        $add->CAPACITY_PERSON_ID        = $request->CAPACITY_PERSON_ID;
        $add->CAPACITY_YEAR             = $request->CAPACITY_YEAR;
        $add->CAPACITY_HEIGHT           = $request->CAPACITY_HEIGHT;
        $add->CAPACITY_WEIGHT           = $request->CAPACITY_WEIGHT;
        $add->CAPACITY_TEST_DATE        = $CAPACITYTESTDATE;
        $add->CAPACITY_HEARTRATE_RESULT = $request->CAPACITY_HEARTRATE_RESULT;
        $add->CAPACITY_HEARTRATE_LEVEL  = $request->CAPACITY_HEARTRATE_LEVEL;
        $add->CAPACITY_HEARTRATE_AVG    = $request->CAPACITY_HEARTRATE_AVG;
        $add->CAPACITY_HEARTRATE_NOMAL  = $request->CAPACITY_HEARTRATE_NOMAL;
        $add->CAPACITY_BLOOD_RESULT     = $request->CAPACITY_BLOOD_RESULT;
        $add->CAPACITY_BLOOD_LEVEL      = $request->CAPACITY_BLOOD_LEVEL;
        $add->CAPACITY_BLOOD_AVG        = $request->CAPACITY_BLOOD_AVG;
        $add->CAPACITY_BLOOD_NOMAL      = $request->CAPACITY_BLOOD_NOMAL;
        $add->CAPACITY_BODY_RESULT      = $request->CAPACITY_BODY_RESULT;
        $add->CAPACITY_BODY_LEVEL       = $request->CAPACITY_BODY_LEVEL;
        $add->CAPACITY_BODY_AVG         = $request->CAPACITY_BODY_AVG;
        $add->CAPACITY_BODY_NOMAL       = $request->CAPACITY_BODY_NOMAL;
        $add->CAPACITY_WAISTLINE_RESULT = $request->CAPACITY_WAISTLINE_RESULT;
        $add->CAPACITY_WAISTLINE_LEVEL  = $request->CAPACITY_WAISTLINE_LEVEL;
        $add->CAPACITY_WAISTLINE_AVG    = $request->CAPACITY_WAISTLINE_AVG;
        $add->CAPACITY_WAISTLINE_NOMAL  = $request->CAPACITY_WAISTLINE_NOMAL;
        $add->CAPACITY_FAT_RESULT       = $request->CAPACITY_FAT_RESULT;
        $add->CAPACITY_FAT_LEVEL        = $request->CAPACITY_FAT_LEVEL;
        $add->CAPACITY_FAT_AVG          = $request->CAPACITY_FAT_AVG;
        $add->CAPACITY_FAT_NOMAL        = $request->CAPACITY_FAT_NOMAL;
        $add->CAPACITY_LUNG_RESULT      = $request->CAPACITY_LUNG_RESULT;
        $add->CAPACITY_LUNG_LEVEL       = $request->CAPACITY_LUNG_LEVEL;
        $add->CAPACITY_LUNG_AVG         = $request->CAPACITY_LUNG_AVG;
        $add->CAPACITY_LUNG_NOMAL       = $request->CAPACITY_LUNG_NOMAL;
        $add->CAPACITY_HAND_RESULT      = $request->CAPACITY_HAND_RESULT;
        $add->CAPACITY_HAND_LEVEL       = $request->CAPACITY_HAND_LEVEL;
        $add->CAPACITY_HAND_AVG         = $request->CAPACITY_HAND_AVG;
        $add->CAPACITY_LEG_RESULT       = $request->CAPACITY_LEG_RESULT;
        $add->CAPACITY_LEG_LEVEL        = $request->CAPACITY_LEG_LEVEL;
        $add->CAPACITY_LEG_AVG          = $request->CAPACITY_LEG_AVG;
        $add->CAPACITY_CULEDUP_RESULT   = $request->CAPACITY_CULEDUP_RESULT;
        $add->CAPACITY_CULEDUP_LEVEL    = $request->CAPACITY_CULEDUP_LEVEL;
        $add->CAPACITY_CULEDUP_AVG      = $request->CAPACITY_CULEDUP_AVG;
        $add->save();

        return redirect()->action('ManagerpersonController@capacity', [
            'iduser' => $request->CAPACITY_PERSON_ID
        ]);
    }

    public function destroy_capacity($id, $iduser)
    {

        Infoworkcapacity::destroy($id);

        return redirect()->action('ManagerpersonController@capacity', [
            'iduser' => $iduser
        ]);

    }

//-----------------------------สุขภาพ--------------------
    public function healthdashboard()
    {

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $checkinfo = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

        if ($checkinfo != 0) {
            $countperson       = DB::table('hrd_person')->where('HR_STATUS_ID', '=', 1)->count();
            $countpersonscreen = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

            $amontpersonnot = $countperson - $countpersonscreen;

            $countpersonscon = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'CONFIRM')->count();
            $countpersonbody = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'SUCCESS')->count();

            $personscreens = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->get();

            $result_1 = 0;
            $result_2 = 0;
            $result_3 = 0;
            $result_4 = 0;
            $result_5 = 0;
            $result_6 = 0;

            foreach ($personscreens as $personscreen) {

                $resualbmi = $personscreen->HEALTH_SCREEN_BODY;

                if ($resualbmi < 18.50) {
                    $result_1++;
                } elseif ($resualbmi >= 18.50 && $resualbmi <= 22.99) {
                    $result_2++;
                } elseif ($resualbmi > 22.99 && $resualbmi <= 24.99) {
                    $result_3++;
                } elseif ($resualbmi > 24.99 && $resualbmi <= 29.99) {
                    $result_4++;
                } elseif ($resualbmi > 29.99) {
                    $result_5++;
                } else {
                    $result_6++;
                }

            }

        } else {

            $result_1          = 0;
            $result_2          = 0;
            $result_3          = 0;
            $result_4          = 0;
            $result_5          = 0;
            $result_6          = 0;
            $countperson       = 1;
            $amontpersonnot    = 0;
            $countpersonscreen = 1;
            $countpersonscon   = 0;
            $countpersonbody   = 0;
        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $groupwork = DB::table('hrd_department_sub_sub')->get();

        $totalhealth_1 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 1)->count();
        $totalhealth_2 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 2)->count();
        $totalhealth_3 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 3)->count();

        return view('manager_person.healthdashboard', [
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'countperson'       => $countperson,
            'amontpersonnot'    => $amontpersonnot,
            'countpersonscreen' => $countpersonscreen,
            'countpersonscon'   => $countpersonscon,
            'countpersonbody'   => $countpersonbody,
            'result_1'          => $result_1,
            'result_2'          => $result_2,
            'result_3'          => $result_3,
            'result_4'          => $result_4,
            'result_5'          => $result_5,
            'result_6'          => $result_6,
            'groupworks'        => $groupwork,
            'totalhealth_1'     => $totalhealth_1,
            'totalhealth_2'     => $totalhealth_2,
            'totalhealth_3'     => $totalhealth_3

        ]);
    }

    public function healthdashboard_search(Request $request)
    {

        $yearbudget = $request->LEAVE_YEAR_ID;

        $checkinfo = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

        if ($checkinfo != 0) {
            $countperson       = DB::table('hrd_person')->where('HR_STATUS_ID', '=', 1)->count();
            $countpersonscreen = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

            $amontpersonnot = $countperson - $countpersonscreen;

            $countpersonscon = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'CONFIRM')->count();
            $countpersonbody = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->where('HEALTH_SCREEN_STATUS', '=', 'SUCCESS')->count();

            $personscreens = DB::table('health_screen')->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->get();

            $result_1 = 0;
            $result_2 = 0;
            $result_3 = 0;
            $result_4 = 0;
            $result_5 = 0;
            $result_6 = 0;

            foreach ($personscreens as $personscreen) {

                $resualbmi = $personscreen->HEALTH_SCREEN_BODY;

                if ($resualbmi < 18.50) {
                    $result_1++;
                } elseif ($resualbmi >= 18.50 && $resualbmi <= 22.99) {
                    $result_2++;
                } elseif ($resualbmi > 22.99 && $resualbmi <= 24.99) {
                    $result_3++;
                } elseif ($resualbmi > 24.99 && $resualbmi <= 29.99) {
                    $result_4++;
                } elseif ($resualbmi > 29.99) {
                    $result_5++;
                } else {
                    $result_6++;
                }

            }

        } else {

            $result_1          = 0;
            $result_2          = 0;
            $result_3          = 0;
            $result_4          = 0;
            $result_5          = 0;
            $result_6          = 0;
            $countperson       = 1;
            $amontpersonnot    = 0;
            $countpersonscreen = 1;
            $countpersonscon   = 0;
            $countpersonbody   = 0;
        }

        $budget  = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $yearbudget;

        $groupwork = DB::table('hrd_department_sub_sub')->get();

        $totalhealth_1 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 1)->count();
        $totalhealth_2 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 2)->count();
        $totalhealth_3 = DB::table('health_body')->where('HEALTH_BODY_RESULT', '=', 3)->count();

        return view('manager_person.healthdashboard', [
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'countperson'       => $countperson,
            'amontpersonnot'    => $amontpersonnot,
            'countpersonscreen' => $countpersonscreen,
            'countpersonscon'   => $countpersonscon,
            'countpersonbody'   => $countpersonbody,
            'result_1'          => $result_1,
            'result_2'          => $result_2,
            'result_3'          => $result_3,
            'result_4'          => $result_4,
            'result_5'          => $result_5,
            'result_6'          => $result_6,
            'groupworks'        => $groupwork,
            'totalhealth_1'     => $totalhealth_1,
            'totalhealth_2'     => $totalhealth_2,
            'totalhealth_3'     => $totalhealth_3

        ]);
    }

    public function carcalendarhealth()
    {

        $daycheck = Healthscreen::leftJoin('hrd_person', 'hrd_person.ID', '=', 'health_screen.HEALTH_SCREEN_PERSON_ID')
            ->get();

        return view('manager_person.carcalendarhealth', [
            'daychecks' => $daycheck

        ]);
    }

    public function inforpersonhealth(Request $request)
    {
        if($request->method() === 'POST'){
            $search     = $request->get('search');
            $status     = $request->STATUS_CODE;
            $datebigin  = $request->get('DATE_BIGIN');
            $dateend    = $request->get('DATE_END');
            $yearbudget = $request->BUDGET_YEAR;
            $data_search = json_encode_u([
                'search' => $search,
                'yearbudget' => $yearbudget,
                'datebigin' => $datebigin,
                'dateend' => $dateend,
                'status' => $status,
            ]);
            Cookie::queue('data_search', $data_search, 120,$request->server('REQUEST_URI'));
        }elseif(!empty(Cookie::get('data_search'))){
            $data_search    = json_decode(Cookie::get('data_search'));
            $search     = $data_search->search;
            $yearbudget     = $data_search->yearbudget;
            $datebigin     = $data_search->datebigin;
            $dateend     = $data_search->dateend;
            $status     = $data_search->status;
        }else{
            $search     = '';
            $yearbudget = getBudgetYear();
            $datebigin  = date('01/10/'.($yearbudget-1));
            $dateend    = date('30/09/'.$yearbudget);
            $status       = '';
        }

        if ($datebigin != '' && $dateend != '') {
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);
            $y_sub_st     = $date_arrary[0];
            if ($y_sub_st >= 2500) {
                $y = $y_sub_st - 543;
            } else {
                $y = $y_sub_st;
            }
            $m                 = $date_arrary[1];
            $d                 = $date_arrary[2];
            $displaydate_bigen = $y . "-" . $m . "-" . $d;
            $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e = explode("-", $date_end_c);
            $y_sub_e = $date_arrary_e[0];
            if ($y_sub_e >= 2500) {
                $y_e = $y_sub_e - 543;
            } else {
                $y_e = $y_sub_e;
            }
            $m_e             = $date_arrary_e[1];
            $d_e             = $date_arrary_e[2];
            $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;
            $from = date($displaydate_bigen);
            $to   = date($displaydate_end);
            if ($status == null) {
                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();
            $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();
        } else {
            $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

            $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();
            }
        } else {
            if ($status == null) {
                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();
            $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();
        } else {
            $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();
            $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();
            }
        }
        $year_id = $yearbudget;
        $infostatus = DB::table('health_screen_status')->get();
        $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        return view('manager_person.inforpersonhealth', [
            'infos'             => $info,
            'infostatuss'       => $infostatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id,
            'amount'            => $amount,
            'budgets'           => $budget
        ]);
    }

    public function inforpersonhealth_search(Request $request)
    {

        $search     = $request->get('search');
        $status     = $request->STATUS_CODE;
        $datebigin  = $request->get('DATE_BIGIN');
        $dateend    = $request->get('DATE_END');
        $yearbudget = $request->BUDGET_YEAR;

        if ($search == '') {
            $search = "";
        }

        if ($datebigin != '' && $dateend != '') {

            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);
            $y_sub_st     = $date_arrary[0];

            if ($y_sub_st >= 2500) {
                $y = $y_sub_st - 543;
            } else {
                $y = $y_sub_st;
            }

            $m                 = $date_arrary[1];
            $d                 = $date_arrary[2];
            $displaydate_bigen = $y . "-" . $m . "-" . $d;

            $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e = explode("-", $date_end_c);

            $y_sub_e = $date_arrary_e[0];

            if ($y_sub_e >= 2500) {
                $y_e = $y_sub_e - 543;
            } else {
                $y_e = $y_sub_e;
            }
            $m_e             = $date_arrary_e[1];
            $d_e             = $date_arrary_e[2];
            $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

            $from = date($displaydate_bigen);
            $to   = date($displaydate_end);

            if ($status == null) {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            } else {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');

                    })
                    ->WhereBetween('HEALTH_SCREEN_DATE', [$from, $to])
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            }

        } else {

            if ($status == null) {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            } else {

                $info = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->get();

                $amount = DB::table('health_screen')
                    ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
                    ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
                    ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
                    ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
                    ->where('HEALTH_SCREEN_STATUS', '=', $status)
                    ->where(function ($q) use ($search) {
                        $q->where('HR_FNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_LNAME', 'like', '%' . $search . '%');
                        $q->orwhere('HEALTH_SCREEN_AGE', 'like', '%' . $search . '%');
                        $q->orwhere('SEX_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%');
                    })

                    ->orderBy('health_screen.HEALTH_SCREEN_ID', 'desc')
                    ->count();

            }

        }

        $year_id = $yearbudget;

        $infostatus = DB::table('health_screen_status')->get();
        $budget     = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        return view('manager_person.inforpersonhealth', [
            'infos'             => $info,
            'infostatuss'       => $infostatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'year_id'           => $year_id,
            'amount'            => $amount,
            'budgets'           => $budget
        ]);
    }

    public function excelinforpersonhealth()
    {

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $count      = Person::count();

        $info = DB::table('health_screen')
            ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)
            ->orderBy('HEALTH_SCREEN_ID', 'desc')
            ->get();

        $amount = DB::table('health_screen')
            ->leftJoin('hrd_person', 'health_screen.HEALTH_SCREEN_PERSON_ID', '=', 'hrd_person.ID')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('HEALTH_SCREEN_YEAR', '=', $yearbudget)->count();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $displaydate_bigen = ($yearbudget - 544) . '-10-01';
        $displaydate_end   = ($yearbudget - 543) . '-09-30';
        $search            = '';
        $year_id           = $yearbudget;

        $status     = '';
        $infostatus = DB::table('health_screen_status')->get();

        return view('manager_person.excelinforpersonhealth', [
            'infos'             => $info,
            'infostatuss'       => $infostatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'amount'            => $amount,
            'year_id'           => $year_id
        ]);
    }

    public function health(Request $request, $iduser)
    {

        $budgetyear = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $infoscreen = DB::table('health_screen')->where('HEALTH_SCREEN_PERSON_ID', '=', $iduser)->orderBy('HEALTH_SCREEN_ID', 'desc')->get();

        $infoperson = DB::table('hrd_person')->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkhealth', [
            'budgetyears' => $budgetyear,
            'infoscreens' => $infoscreen,
            'iduser'      => $iduser,
            'infoperson'  => $infoperson

        ]);
    }

    public function mana_screen_save(Request $request)
    {

        $addinfo                          = new Healthscreen();
        $addinfo->HEALTH_SCREEN_YEAR      = $request->HEALTH_SCREEN_YEAR;
        $addinfo->HEALTH_SCREEN_PERSON_ID = $request->HEALTH_SCREEN_PERSON_ID;
        $addinfo->HEALTH_SCREEN_HEIGHT    = '';
        $addinfo->HEALTH_SCREEN_WEIGHT    = '';
        $addinfo->HEALTH_SCREEN_BODY      = '';
        $addinfo->save();

        return redirect()->route('mperson.health', ['iduser' => $request->HEALTH_SCREEN_PERSON_ID]);
    }

    public function health_add(Request $request, $idref, $iduser)
    {

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->where('ID', '=', $inforef->HEALTH_SCREEN_PERSON_ID)->first();

        $infolab   = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $sumamount = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $inforbody = DB::table('health_body')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $check = DB::table('health_body')->where('HEALTH_SCREEN_ID', '=', $idref)->count();

        return view('manager_person.personinfoworkhealth_add', [
            'idref'      => $idref,
            'inforef'    => $inforef,
            'infoperson' => $infoperson,
            'infolabs'   => $infolab,
            'sumamount'  => $sumamount,
            'inforbody'  => $inforbody,
            'check'      => $check

        ]);
    }

    public function health_save(Request $request)
    {

        $id = $request->idref;

        $addinfo                       = Healthscreen::find($id);
        $addinfo->HEALTH_SCREEN_HEIGHT = $request->HEALTH_SCREEN_HEIGHT;
        $addinfo->HEALTH_SCREEN_WEIGHT = $request->HEALTH_SCREEN_WEIGHT;
        $addinfo->HEALTH_SCREEN_BODY   = $request->HEALTH_SCREEN_BODY;

        $addinfo->HEALTH_SCREEN_FM_DIA    = $request->HEALTH_SCREEN_FM_DIA;
        $addinfo->HEALTH_SCREEN_FM_BLOOD  = $request->HEALTH_SCREEN_FM_BLOOD;
        $addinfo->HEALTH_SCREEN_FM_GOUT   = $request->HEALTH_SCREEN_FM_GOUT;
        $addinfo->HEALTH_SCREEN_FM_KIDNEY = $request->HEALTH_SCREEN_FM_KIDNEY;
        $addinfo->HEALTH_SCREEN_FM_HEART  = $request->HEALTH_SCREEN_FM_HEART;
        $addinfo->HEALTH_SCREEN_FM_BRAIN  = $request->HEALTH_SCREEN_FM_BRAIN;
        $addinfo->HEALTH_SCREEN_FM_EMPHY  = $request->HEALTH_SCREEN_FM_EMPHY;
        $addinfo->HEALTH_SCREEN_FM_UNKNOW = $request->HEALTH_SCREEN_FM_UNKNOW;
        $addinfo->HEALTH_SCREEN_FM_OTHER  = $request->HEALTH_SCREEN_FM_OTHER;

        $addinfo->HEALTH_SCREEN_BS_DIA    = $request->HEALTH_SCREEN_BS_DIA;
        $addinfo->HEALTH_SCREEN_BS_BLOOD  = $request->HEALTH_SCREEN_BS_BLOOD;
        $addinfo->HEALTH_SCREEN_BS_GOUT   = $request->HEALTH_SCREEN_BS_GOUT;
        $addinfo->HEALTH_SCREEN_BS_KIDNEY = $request->HEALTH_SCREEN_BS_KIDNEY;
        $addinfo->HEALTH_SCREEN_BS_HEART  = $request->HEALTH_SCREEN_BS_HEART;
        $addinfo->HEALTH_SCREEN_BS_BRAIN  = $request->HEALTH_SCREEN_BS_BRAIN;
        $addinfo->HEALTH_SCREEN_BS_EMPHY  = $request->HEALTH_SCREEN_BS_EMPHY;
        $addinfo->HEALTH_SCREEN_BS_UNKNOW = $request->HEALTH_SCREEN_BS_UNKNOW;
        $addinfo->HEALTH_SCREEN_BS_OTHER  = $request->HEALTH_SCREEN_BS_OTHER;

        $addinfo->HEALTH_SCREEN_H_1    = $request->HEALTH_SCREEN_H_1;
        $addinfo->HEALTH_SCREEN_H_2    = $request->HEALTH_SCREEN_H_2;
        $addinfo->HEALTH_SCREEN_H_3    = $request->HEALTH_SCREEN_H_3;
        $addinfo->HEALTH_SCREEN_H_4    = $request->HEALTH_SCREEN_H_4;
        $addinfo->HEALTH_SCREEN_H_5    = $request->HEALTH_SCREEN_H_5;
        $addinfo->HEALTH_SCREEN_H_6    = $request->HEALTH_SCREEN_H_6;
        $addinfo->HEALTH_SCREEN_H_7    = $request->HEALTH_SCREEN_H_7;
        $addinfo->HEALTH_SCREEN_H_8    = $request->HEALTH_SCREEN_H_8;
        $addinfo->HEALTH_SCREEN_H_9    = $request->HEALTH_SCREEN_H_9;
        $addinfo->HEALTH_SCREEN_H_10   = $request->HEALTH_SCREEN_H_10;
        $addinfo->HEALTH_SCREEN_H_11   = $request->HEALTH_SCREEN_H_11;
        $addinfo->HEALTH_SCREEN_H_12   = $request->HEALTH_SCREEN_H_12;
        $addinfo->HEALTH_SCREEN_H_13   = $request->HEALTH_SCREEN_H_13;
        $addinfo->HEALTH_SCREEN_H_14   = $request->HEALTH_SCREEN_H_14;
        $addinfo->HEALTH_SCREEN_H_15   = $request->HEALTH_SCREEN_H_15;
        $addinfo->HEALTH_SCREEN_H_16   = $request->HEALTH_SCREEN_H_16;
        $addinfo->HEALTH_SCREEN_H_17   = $request->HEALTH_SCREEN_H_17;
        $addinfo->HEALTH_SCREEN_H_18   = $request->HEALTH_SCREEN_H_18;
        $addinfo->HEALTH_SCREEN_H_19   = $request->HEALTH_SCREEN_H_19;
        $addinfo->HEALTH_SCREEN_H_20   = $request->HEALTH_SCREEN_H_20;
        $addinfo->HEALTH_SCREEN_H_21   = $request->HEALTH_SCREEN_H_21;
        $addinfo->HEALTH_SCREEN_H_22   = $request->HEALTH_SCREEN_H_22;
        $addinfo->HEALTH_SCREEN_H_23   = $request->HEALTH_SCREEN_H_23;
        $addinfo->HEALTH_SCREEN_H_24   = $request->HEALTH_SCREEN_H_24;
        $addinfo->HEALTH_SCREEN_H_25   = $request->HEALTH_SCREEN_H_25;
        $addinfo->HEALTH_SCREEN_H_26   = $request->HEALTH_SCREEN_H_26;
        $addinfo->HEALTH_SCREEN_H_27   = $request->HEALTH_SCREEN_H_27;
        $addinfo->HEALTH_SCREEN_H_28   = $request->HEALTH_SCREEN_H_28;
        $addinfo->HEALTH_SCREEN_H_HAVE = $request->HEALTH_SCREEN_H_HAVE;

        $addinfo->HEALTH_SCREEN_SMOK        = $request->HEALTH_SCREEN_SMOK;
        $addinfo->HEALTH_SCREEN_SMOK_AMOUNT = $request->HEALTH_SCREEN_SMOK_AMOUNT;
        $addinfo->HEALTH_SCREEN_SMOK_TYPE   = $request->HEALTH_SCREEN_SMOK_TYPE;
        $addinfo->HEALTH_SCREEN_SMOK_TIME   = $request->HEALTH_SCREEN_SMOK_TIME;

        $addinfo->HEALTH_SCREEN_DRINK        = $request->HEALTH_SCREEN_DRINK;
        $addinfo->HEALTH_SCREEN_DRINK_AMOUNT = $request->HEALTH_SCREEN_DRINK_AMOUNT;

        $addinfo->HEALTH_SCREEN_EXERCISE = $request->HEALTH_SCREEN_EXERCISE;
        $addinfo->HEALTH_SCREEN_FOOD_1   = $request->HEALTH_SCREEN_FOOD_1;
        $addinfo->HEALTH_SCREEN_FOOD_2   = $request->HEALTH_SCREEN_FOOD_2;
        $addinfo->HEALTH_SCREEN_FOOD_3   = $request->HEALTH_SCREEN_FOOD_3;
        $addinfo->HEALTH_SCREEN_FOOD_4   = $request->HEALTH_SCREEN_FOOD_4;
        $addinfo->HEALTH_SCREEN_FOOD_5   = $request->HEALTH_SCREEN_FOOD_5;

        $addinfo->HEALTH_SCREEN_DRIVE = $request->HEALTH_SCREEN_DRIVE;
        $addinfo->HEALTH_SCREEN_SEX   = $request->HEALTH_SCREEN_SEX;

        $addinfo->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function destroy_screen($id, $iduser)
    {

        Healthscreen::destroy($id);

        return redirect()->route('mperson.health', ['iduser' => $iduser]);
    }

    public function healthConfirm(Request $request, $idref, $iduser)
    {
        $infoscreenlab = DB::table('health_screen_lab')->get();

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        if ($inforef->HEALTH_SCREEN_AGE < 35) {

            if ($infoperson->SEX == 'F') {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->count();
            } else {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->count();
            }

        } else {

            if ($infoperson->SEX == 'F') {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '2')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->count();
            } else {
                $infoscreenlabcon = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->get();
                $infosumlab       = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->sum('HEALTH_SCREEN_LAB_PICE');
                $infocountlab     = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_TYPE', '=', '1')->orwhere('HEALTH_SCREEN_LAB_TYPE', '=', '3')->count();
            }

        }

        return view('manager_person.personinfoworkhealthConfirm', [
            'infoscreenlabs'    => $infoscreenlab,
            'infoscreenlabcons' => $infoscreenlabcon,
            'inforef'           => $inforef,
            'infoperson'        => $infoperson,
            'infosumlab'        => $infosumlab,
            'infocountlab'      => $infocountlab
        ]);
    }

    public function healthConfirmsave(Request $request)
    {

        if ($request->HEALTH_SCREEN_LAB_ID[0] != '' || $request->HEALTH_SCREEN_LAB_ID[0] != null) {

            $HEALTH_SCREEN_ID         = $request->HEALTH_SCREEN_ID;
            $HEALTH_SCREEN_LAB_ID     = $request->HEALTH_SCREEN_LAB_ID;
            $HEALTH_SCREEN_CON_AMOUNT = $request->HEALTH_SCREEN_CON_AMOUNT;

            $number = count($HEALTH_SCREEN_LAB_ID);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addinfo                       = new Healthscreenconfirm();
                $addinfo->HEALTH_SCREEN_ID     = $request->HEALTH_SCREEN_ID[$count];
                $addinfo->HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID[$count];

                $infolab = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $request->HEALTH_SCREEN_LAB_ID[$count])->first();

                $addinfo->HEALTH_SCREEN_CON_CODE    = $infolab->HEALTH_SCREEN_LAB_CODE;
                $addinfo->HEALTH_SCREEN_CON_NAME    = $infolab->HEALTH_SCREEN_LAB_NAME;
                $addinfo->HEALTH_SCREEN_CON_PICE    = $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->HEALTH_SCREEN_CON_AMOUNT  = $request->HEALTH_SCREEN_CON_AMOUNT[$count];
                $addinfo->HEALTH_SCREEN_CON_SUMPICE = $request->HEALTH_SCREEN_CON_AMOUNT[$count] * $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->save();

            }
        }

        $CHECK_DATE = $request->HEALTH_SCREEN_CON_DATE;

        if ($CHECK_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CHECK_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st      = $date_arrary_st[1];
            $d_st      = $date_arrary_st[2];
            $CHECKDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CHECKDATE = null;
        }

        $id                                  = $request->HEALTH_SCREEN_ID_UP;
        $upstatus                            = Healthscreen::find($id);
        $upstatus->HEALTH_SCREEN_CON_DATE    = $CHECKDATE;
        $upstatus->HEALTH_SCREEN_CON_TIME    = $request->HEALTH_SCREEN_CON_TIME;
        $upstatus->HEALTH_SCREEN_CON_COMMENT = $request->HEALTH_SCREEN_CON_COMMENT;
        $upstatus->HEALTH_SCREEN_STATUS      = 'CONFIRM';
        $upstatus->save();

        $inforeport     = $request->inforeport;
        $inforeportname = DB::table('hrd_person')->where('ID', '=', $inforeport)->first();

        $infouser = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $id)->first();

        function DateThai($strDate)
        {
            $strYear  = date("Y", strtotime($strDate)) + 543;
            $strMonth = date("n", strtotime($strDate));
            $strDay   = date("j", strtotime($strDate));

            $strMonthCut  = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
        }

        $header  = "แจ้งนัดตรวจสุขภาพ";
        $message = $header .
        "\n" . "วันที่นัด : " . DateThai($CHECKDATE) .
        "\n" . "เวลา : " . $request->HEALTH_SCREEN_CON_TIME .
        "\n" . "ผู้แจ้ง : " . $inforeportname->HR_FNAME . '' . $inforeportname->HR_LNAME;

        $name = DB::table('hrd_person')->where('ID', '=', $infouser->HEALTH_SCREEN_PERSON_ID)->first();
        $test = $name->HR_LINE;

        $chOne = curl_init();
        curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
        curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($chOne, CURLOPT_POST, 1);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, $message);
        curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$message");
        curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);
        $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $test . '');
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($chOne);
        if (curl_error($chOne)) {echo 'error:' . curl_error($chOne);} else { $result_ = json_decode($result, true);
            echo "status : " . $result_['status'];
            echo "message : " . $result_['message'];}
        curl_close($chOne);

        return redirect()->route('health.inforpersonhealth');
    }

    public function healthConfirm_edit(Request $request, $idref, $iduser)
    {
        $infoscreenlab = DB::table('health_screen_lab')->get();

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        $infoscreenlabcon = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $infosumlab       = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->sum('HEALTH_SCREEN_CON_SUMPICE');

        return view('manager_person.personinfoworkhealthConfirm_edit', [
            'infoscreenlabs'    => $infoscreenlab,
            'infoscreenlabcons' => $infoscreenlabcon,
            'inforef'           => $inforef,
            'infoperson'        => $infoperson,
            'infosumlab'        => $infosumlab

        ]);
    }

    public function healthConfirmupdate(Request $request)
    {
        $id = $request->HEALTH_SCREEN_ID_UP;

        Healthscreenconfirm::where('HEALTH_SCREEN_ID', '=', $id)->delete();

        if ($request->HEALTH_SCREEN_LAB_ID[0] != '' || $request->HEALTH_SCREEN_LAB_ID[0] != null) {

            $HEALTH_SCREEN_LAB_ID     = $request->HEALTH_SCREEN_LAB_ID;
            $HEALTH_SCREEN_CON_AMOUNT = $request->HEALTH_SCREEN_CON_AMOUNT;

            $number = count($HEALTH_SCREEN_LAB_ID);
            $count  = 0;
            for ($count = 0; $count < $number; $count++) {

                $addinfo                       = new Healthscreenconfirm();
                $addinfo->HEALTH_SCREEN_ID     = $id;
                $addinfo->HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID[$count];

                $infolab = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $request->HEALTH_SCREEN_LAB_ID[$count])->first();

                $addinfo->HEALTH_SCREEN_CON_CODE    = $infolab->HEALTH_SCREEN_LAB_CODE;
                $addinfo->HEALTH_SCREEN_CON_NAME    = $infolab->HEALTH_SCREEN_LAB_NAME;
                $addinfo->HEALTH_SCREEN_CON_PICE    = $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->HEALTH_SCREEN_CON_AMOUNT  = $request->HEALTH_SCREEN_CON_AMOUNT[$count];
                $addinfo->HEALTH_SCREEN_CON_SUMPICE = $request->HEALTH_SCREEN_CON_AMOUNT[$count] * $infolab->HEALTH_SCREEN_LAB_PICE;
                $addinfo->save();

            }
        }

        $CHECK_DATE = $request->HEALTH_SCREEN_CON_DATE;

        if ($CHECK_DATE != '') {
            $STARTDAY       = Carbon::createFromFormat('d/m/Y', $CHECK_DATE)->format('Y-m-d');
            $date_arrary_st = explode("-", $STARTDAY);
            $y_sub_st       = $date_arrary_st[0];

            if ($y_sub_st >= 2500) {
                $y_st = $y_sub_st - 543;
            } else {
                $y_st = $y_sub_st;
            }
            $m_st      = $date_arrary_st[1];
            $d_st      = $date_arrary_st[2];
            $CHECKDATE = $y_st . "-" . $m_st . "-" . $d_st;
        } else {
            $CHECKDATE = null;
        }

        $upstatus                            = Healthscreen::find($id);
        $upstatus->HEALTH_SCREEN_CON_DATE    = $CHECKDATE;
        $upstatus->HEALTH_SCREEN_CON_TIME    = $request->HEALTH_SCREEN_CON_TIME;
        $upstatus->HEALTH_SCREEN_CON_COMMENT = $request->HEALTH_SCREEN_CON_COMMENT;
        $upstatus->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function reportinforpersonhealth()
    {

        return view('manager_person.reportinforpersonhealth');
    }

    public function healthBody(Request $request, $idref, $iduser)
    {

        $infosumlab = DB::table('health_screen_lab')->sum('HEALTH_SCREEN_LAB_PICE');

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infolab   = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $sumamount = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        return view('manager_person.personinfoworkhealthBody', [
            'infolabs'   => $infolab,
            'inforef'    => $inforef,
            'infoperson' => $infoperson,
            'infosumlab' => $infosumlab,
            'sumamount'  => $sumamount
        ]);

    }

    public function healthbodysave(Request $request)
    {

        $addinfo                      = new Healthbody();
        $addinfo->HEALTH_SCREEN_ID    = $request->HEALTH_SCREEN_ID;
        $addinfo->HEALTH_BODY_DATE    = date('Y-m-d');
        $addinfo->HEALTH_BODY_BLOOD11 = $request->HEALTH_BODY_BLOOD11;
        $addinfo->HEALTH_BODY_BLOOD12 = $request->HEALTH_BODY_BLOOD12;
        $addinfo->HEALTH_BODY_BLOOD21 = $request->HEALTH_BODY_BLOOD21;
        $addinfo->HEALTH_BODY_BLOOD22 = $request->HEALTH_BODY_BLOOD22;

        $addinfo->HEALTH_BODY_BLOOD_LOWER = number_format(($request->HEALTH_BODY_BLOOD11 + $request->HEALTH_BODY_BLOOD21) / 2);
        $addinfo->HEALTH_BODY_BLOOD_TOP   = number_format(($request->HEALTH_BODY_BLOOD12 + $request->HEALTH_BODY_BLOOD22) / 2);

        $addinfo->HEALTH_BODY_WAISTLINE  = $request->HEALTH_BODY_WAISTLINE;
        $addinfo->HEALTH_BODY_BEWAN      = $request->HEALTH_BODY_BEWAN;
        $addinfo->HEALTH_BODY_SUGAR      = $request->HEALTH_BODY_SUGAR;
        $addinfo->HEALTH_BODY_MG         = $request->HEALTH_BODY_MG;
        $addinfo->HEALTH_BODY_COMMENT    = $request->HEALTH_BODY_COMMENT;
        $addinfo->HEALTH_BODY_RISK       = $request->HEALTH_BODY_RISK;
        $addinfo->HEALTH_BODY_RISKDETAIL = $request->HEALTH_BODY_RISKDETAIL;
        $addinfo->HEALTH_BODY_ADVICE     = $request->HEALTH_BODY_ADVICE;
        $addinfo->HEALTH_BODY_SEND       = $request->HEALTH_BODY_SEND;
        $addinfo->HEALTH_BODY_RESULT     = $request->HEALTH_BODY_RESULT;
        $addinfo->save();

        $id = $request->HEALTH_SCREEN_ID;

        $upstatus                       = Healthscreen::find($id);
        $upstatus->HEALTH_BODY_DATE     = date('Y-m-d');
        $upstatus->HEALTH_SCREEN_STATUS = 'SUCCESS';
        $upstatus->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function healthBody_edit(Request $request, $idref, $iduser)
    {

        $infosumlab = DB::table('health_screen_lab')->sum('HEALTH_SCREEN_LAB_PICE');

        $inforef = DB::table('health_screen')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        $infolab   = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->get();
        $sumamount = DB::table('health_screen_confirm')->where('HEALTH_SCREEN_ID', '=', $idref)->SUM('HEALTH_SCREEN_CON_SUMPICE');

        $infoperson = DB::table('hrd_person')
            ->leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->where('ID', '=', $iduser)->first();

        $inforbody = DB::table('health_body')->where('HEALTH_SCREEN_ID', '=', $idref)->first();

        return view('manager_person.personinfoworkhealthBody_edit', [
            'inforef'    => $inforef,
            'sumamount'  => $sumamount,
            'infolabs'   => $infolab,
            'infoperson' => $infoperson,
            'infosumlab' => $infosumlab,
            'inforbody'  => $inforbody
        ]);

    }

    public function healthbodyupdate(Request $request)
    {

        $id = $request->HEALTH_BODY_ID;

        $addinfo = Healthbody::find($id);

        $addinfo->HEALTH_BODY_DATE    = date('Y-m-d');
        $addinfo->HEALTH_BODY_BLOOD11 = $request->HEALTH_BODY_BLOOD11;
        $addinfo->HEALTH_BODY_BLOOD12 = $request->HEALTH_BODY_BLOOD12;
        $addinfo->HEALTH_BODY_BLOOD21 = $request->HEALTH_BODY_BLOOD21;
        $addinfo->HEALTH_BODY_BLOOD22 = $request->HEALTH_BODY_BLOOD22;

        $addinfo->HEALTH_BODY_BLOOD_LOWER = number_format(($request->HEALTH_BODY_BLOOD11 + $request->HEALTH_BODY_BLOOD21) / 2);
        $addinfo->HEALTH_BODY_BLOOD_TOP   = number_format(($request->HEALTH_BODY_BLOOD12 + $request->HEALTH_BODY_BLOOD22) / 2);

        $addinfo->HEALTH_BODY_WAISTLINE  = $request->HEALTH_BODY_WAISTLINE;
        $addinfo->HEALTH_BODY_BEWAN      = $request->HEALTH_BODY_BEWAN;
        $addinfo->HEALTH_BODY_SUGAR      = $request->HEALTH_BODY_SUGAR;
        $addinfo->HEALTH_BODY_MG         = $request->HEALTH_BODY_MG;
        $addinfo->HEALTH_BODY_COMMENT    = $request->HEALTH_BODY_COMMENT;
        $addinfo->HEALTH_BODY_RISK       = $request->HEALTH_BODY_RISK;
        $addinfo->HEALTH_BODY_RISKDETAIL = $request->HEALTH_BODY_RISKDETAIL;
        $addinfo->HEALTH_BODY_ADVICE     = $request->HEALTH_BODY_ADVICE;
        $addinfo->HEALTH_BODY_SEND       = $request->HEALTH_BODY_SEND;
        $addinfo->HEALTH_BODY_RESULT     = $request->HEALTH_BODY_RESULT;
        $addinfo->save();

        return redirect()->route('health.inforpersonhealth');
    }

    public function health_destroy($idref, $iduser)
    {
        Healthscreen::destroy($idref);

        return redirect()->route('health.inforpersonhealth');

    }

    public function inforperson_meetinginside(Request $request)
    {
        if(!empty($request->get('DATE_BIGIN'))){
            $yearbudget = $request->get('BUDGET_YEAR');
            $displaydate_bigen = datepickerTodate($request->DATE_BIGIN);
            $displaydate_end   = datepickerTodate($request->DATE_END);
            $status            = $request->STATUS_CODE;
            $search            = $request->search;
            session([
                'manager_person.inforperson_meetinginside.yearbudget' => $yearbudget,
                'manager_person.inforperson_meetinginside.displaydate_bigen' => $displaydate_bigen,
                'manager_person.inforperson_meetinginside.displaydate_end' => $displaydate_end,
                'manager_person.inforperson_meetinginside.status' => $status,
                'manager_person.inforperson_meetinginside.search' => $search,
                ]);
        }elseif(!empty(session('manager_person.inforperson_meetinginside'))){
            $yearbudget = session('manager_person.inforperson_meetinginside.yearbudget');
            $displaydate_bigen = session('manager_person.inforperson_meetinginside.displaydate_bigen');
            $displaydate_end = session('manager_person.inforperson_meetinginside.displaydate_end');
            $status = session('manager_person.inforperson_meetinginside.status');
            $search = session('manager_person.inforperson_meetinginside.search');
        }else{
            $yearbudget = getBudgetYear();
            $displaydate_bigen = date('Y-m-1');
            $displaydate_end   = date('Y-m-d', strtotime(date('Y-m-1'). '+1month -1days'));
            $status            = '';
            $search            = '';
        }
            $datebigin_year = Carbon::createFromFormat('Y-m-d', $displaydate_bigen)->format('Y');
            if($datebigin_year >= 2500){
                $datebigin_month = Carbon::createFromFormat('Y-m-d', $displaydate_bigen)->format('-m-d');
                $displaydate_bigen = ($datebigin_year-543).$datebigin_month;
            }
            $dateend_year = Carbon::createFromFormat('Y-m-d', $displaydate_end)->format('Y');
            if($dateend_year >= 2500){
                $dateend_month = Carbon::createFromFormat('Y-m-d', $displaydate_end)->format('-m-d');
                $displaydate_end = ($dateend_year-543).$dateend_month;
            }
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $meettingstatus = DB::table('grecord_status')->get();
        $room = DB::table('meetingroom_index')->get();
        $infostatus = DB::table('health_screen_status')->get();
        $user1 = DB::table('meetting_inside_usersub')->count();
        $q = DB::table('meetting_inside_index')
            ->leftJoin('hrd_person', 'meetting_inside_index.MEETING_INSIDE_PRESIDENT', '=', 'hrd_person.ID')
            ->leftJoin('meetting_inside_type', 'meetting_inside_index.MEETING_INSIDE_TYPE', '=', 'meetting_inside_type.MEETTINGSIDE_ID')
            ->leftjoin('grecord_org_location', 'meetting_inside_index.MEETING_INSIDE_LOCATION', '=', 'grecord_org_location.LOCATION_ID')
            ->leftjoin('meetingroom_index', 'meetting_inside_index.ROOM_ID', '=', 'meetingroom_index.ROOM_ID')
            ->leftjoin('grecord_status', 'meetting_inside_index.MEETING_STATUS', '=', 'grecord_status.STATUS')
            ->whereBetween('meetting_inside_index.MEETING_INSIDE_DATE',[$displaydate_bigen,$displaydate_end]);
            if($status != '' || $status !== null){
                $q->where('MEETING_STATUS',$status);
            }
            if($search != '' || $search !== null){
                $q->where(function ($q) use ($search){
                    $q->where('meetting_inside_index.MEETING_INSIDE_TITLE','like','%'.$search.'%')
                    ->orwhere('meetting_inside_type.MEETTINGSIDE_NAME','like','%'.$search.'%')
                    ->orwhere('meetting_inside_index.MEETING_INSIDE_DATE','like','%'.$search.'%')
                    ->orwhere('meetingroom_index.ROOM_NAME','like','%'.$search.'%')
                    ->orwhere('meetting_inside_index.MEETING_INSIDE_STARTTIME','like','%'.$search.'%')
                    ->orwhere('meetting_inside_index.MEETING_INSIDE_ENDTIME','like','%'.$search.'%');
                });
            }
            $meetinginside = $q->get();
        // $user1 = DB::table('meetting_inside_usersub')->where('meetting_inside_usersub.MEETING_INSIDE_ID','=',$meetinginside->MEETING_INSIDE_ID)->count();
        return view('manager_person.inforperson_meetinginside', [
            'infostatuss'       => $infostatus,
            'rooms'             => $room,
            'meetinginsides'    => $meetinginside,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $yearbudget,
            'meettingstatuss'   => $meettingstatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'user1'             => $user1
        ]);
    }

   

    public function inforperson_meetinginside_add(Request $request)
    {

        $meetting_inside_type = DB::table('meetting_inside_type')->get();

        $infopresident = DB::table('hrd_person')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = ($yearbudget - 544) . '-10-01';
        $displaydate_end   = ($yearbudget - 543) . '-09-30';
        $status            = '';
        $search            = '';
        $year_id           = $yearbudget;

        $meetting_inside_type = DB::table('meetting_inside_type')->get();
        $location             = DB::table('grecord_org_location')->get();

        $infopresident = DB::table('hrd_person')->get();
        $room          = DB::table('meetingroom_index')->get();

        return view('manager_person.inforperson_meetinginside_add', [

            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
            'rooms'                 => $room,
            'locations'             => $location,
            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
            // 'inforpersonuser' => $inforpersonuser,
             // 'inforpersonuserid' => $inforpersonuserid,
             'displaydate_bigen'     => $displaydate_bigen,
            'displaydate_end'       => $displaydate_end,
            'status_check'          => $status,
            'search'                => $search,
            'budgets'               => $budget,
            'year_id'               => $year_id
        ]);
    }

    public function inforperson_meetinginside_save(Request $request)
    {
    
        $iduser = $request->iduser;
     
        $ic_date = $request->MEETING_INSIDE_DATE;
    
        if($ic_date != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $icontrol_date= $y_st."-".$m_st."-".$d_st;
        }else{
        $icontrol_date= null;
        }
    
        $usersave = Person::where('ID','=',$iduser)->first();
    
        // $id_metindex = Meetting_inside_index::max('MEETING_INSIDE_ID');
    
        $add = new Meetting_inside_index(); 
        $add->MEETING_INSIDE_CODE = $request->MEETING_INSIDE_CODE;
        $add->MEETING_INSIDE_NO = $request->MEETING_INSIDE_NO;
        $add->MEETING_INSIDE_BUDGET = $request->MEETING_INSIDE_BUDGET;
        $add->ROOM_ID = $request->ROOM_ID;
        $add->MEETING_INSIDE_DATE = $icontrol_date;
        $add->MEETING_INSIDE_STARTTIME = $request->MEETING_INSIDE_STARTTIME;
        $add->MEETING_INSIDE_ENDTIME = $request->MEETING_INSIDE_ENDTIME;
        $add->MEETING_INSIDE_TITLE = $request->MEETING_INSIDE_TITLE;
        $add->MEETING_INSIDE_PRESIDENT = $request->MEETING_INSIDE_PRESIDENT;
        $add->MEETING_INSIDE_TYPE = $request->MEETING_INSIDE_TYPE;
        $add->MEETING_INSIDE_LOCATION = $request->MEETING_INSIDE_LOCATION;
        $add->MEETING_INSIDE_USERSAVE = $usersave->ID;
        $add->MEETING_INSIDE_USERSAVE_NAME = $usersave->HR_FNAME.' ' .$usersave->HR_LNAME;
        $add->MEETING_STATUS = 'APPLY';
                            
        $maxid = Meetting_inside_index::max('MEETING_INSIDE_ID');    
        $idfile = $maxid+1;
    
        if($request->hasFile('pdfupload')){
            $newFileName = 'meetinside_'.$idfile.'.'.$request->pdfupload->extension();          
            $request->pdfupload->storeAs('meettinginsidepdf',$newFileName,'public');     
            $add->MEETING_INSIDE_FILE = $newFileName;        
        }
       
        $add->save();
    
        if($request->MEETING_INSIDE_USER != '' || $request->MEETING_INSIDE_USER != null)
        {        
            $MEETING_INSIDE_USER = $request->MEETING_INSIDE_USER;                         
            $number =count($MEETING_INSIDE_USER);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $usersub = Person::where('ID','=',$MEETING_INSIDE_USER[$count])->first();
    
                        $add_usersub = new Meetting_inside_usersub();    
                        $add_usersub->MEETING_INSIDE_ID = $idfile;   
                        $add_usersub->MEETING_INSIDE_USERSUB_IDNAME = $usersub->ID; 
                        $add_usersub->MEETING_INSIDE_USERSUB_FNAME = $usersub->HR_FNAME; 
                        $add_usersub->MEETING_INSIDE_USERSUB_LNAME = $usersub->HR_LNAME;
                        $add_usersub->save(); 
                    }
        } 
    
        if($request->MEETING_INSIDE_USEROUT != '' || $request->MEETING_INSIDE_USEROUT != null)
        {        
            $MEETING_INSIDE_USEROUT = $request->MEETING_INSIDE_USEROUT;                         
            $number =count($MEETING_INSIDE_USEROUT);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $add_useroutsub = new Meetting_inside_useroutsub();    
                        $add_useroutsub->MEETING_INSIDE_ID = $idfile;   
                        $add_useroutsub->MEETING_INSIDE_USEROUT_NAME = $MEETING_INSIDE_USEROUT[$count];   
                        $add_useroutsub->save(); 
                    }
        } 
        
        if($request->MEETING_INSIDE_PERFORMANCE != '' || $request->MEETING_INSIDE_PERFORMANCE != null)
        {        
            $MEETING_INSIDE_PERFORMANCE = $request->MEETING_INSIDE_PERFORMANCE;                         
            $number =count($MEETING_INSIDE_PERFORMANCE);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $add_performancesub = new Meetting_inside_performancesub();    
                        $add_performancesub->MEETING_INSIDE_ID = $idfile;   
                        $add_performancesub->MEETING_INSIDE_PERFORMANCE_NAME = $MEETING_INSIDE_PERFORMANCE[$count];   
                        $add_performancesub->save(); 
                    }
        }
    
        if($request->MEETING_INSIDE_PROFESSION != '' || $request->MEETING_INSIDE_PROFESSION != null)
        {        
            $MEETING_INSIDE_PROFESSION = $request->MEETING_INSIDE_PROFESSION;                         
            $number =count($MEETING_INSIDE_PROFESSION);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $add_performancesub = new Meetting_inside_professionsub();    
                        $add_performancesub->MEETING_INSIDE_ID = $idfile;   
                        $add_performancesub->MEETING_INSIDE_PROFESSION_NAME = $MEETING_INSIDE_PROFESSION[$count];   
                        $add_performancesub->save(); 
                    }
        }
    
    
    
    
        return redirect()->route('mperson.inforperson_meetinginside');
    }


    public function inforperson_meetinginside_edit(Request $request,$id)
    {

        $meetting_inside_type = DB::table('meetting_inside_type')->get();

        $infopresident = DB::table('hrd_person')->get();

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

        $meetting_inside_type = DB::table('meetting_inside_type')->get();
        $location             = DB::table('grecord_org_location')->get();    
        $room          = DB::table('meetingroom_index')->get();
        $infopresident =  DB::table('hrd_person')->get();

        $meetinginside = DB::table('meetting_inside_index')
        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
        ->where('meetting_inside_index.MEETING_INSIDE_ID','=',$id)->first();


        $inside_usersub =  DB::table('meetting_inside_usersub') ->where('meetting_inside_usersub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_useroutsub =  DB::table('meetting_inside_useroutsub') ->where('meetting_inside_useroutsub.MEETING_INSIDE_ID','=',$id)->get();


        $inside_performance =  DB::table('meetting_inside_performancesub') ->where('meetting_inside_performancesub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_professionsub =  DB::table('meetting_inside_professionsub') ->where('meetting_inside_professionsub.MEETING_INSIDE_ID','=',$id)->get();



        return view('manager_person.inforperson_meetinginside_edit', [
            'inside_usersubs' =>  $inside_usersub,
            'inside_useroutsubs' =>  $inside_useroutsub,
            'meetinginsides' =>  $meetinginside,
            'inside_performances' =>  $inside_performance,
            'inside_professionsubs' =>  $inside_professionsub,
            'rooms'                 => $room,
            'locations'             => $location,
            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
             'displaydate_bigen'     => $displaydate_bigen,
            'displaydate_end'       => $displaydate_end,
            'status_check'          => $status,
            'search'                => $search,
            'budgets'               => $budget,
            'year_id'               => $year_id
        ]);
    }


    public function inforperson_meetinginside_update(Request $request)
    {
        $iduser = $request->iduser;
        $id = $request->MEETING_INSIDE_ID;
     
        $ic_date = $request->MEETING_INSIDE_DATE;
    
        if($ic_date != ''){
        $STARTDAY = Carbon::createFromFormat('d/m/Y', $ic_date)->format('Y-m-d');
        $date_arrary_st=explode("-",$STARTDAY);  
        $y_sub_st = $date_arrary_st[0]; 
        
        if($y_sub_st >= 2500){
            $y_st = $y_sub_st-543;
        }else{
            $y_st = $y_sub_st;
        }
        $m_st = $date_arrary_st[1];
        $d_st = $date_arrary_st[2];  
        $icontrol_date= $y_st."-".$m_st."-".$d_st;
        }else{
        $icontrol_date= null;
        }
    
     
        $usersave = Person::where('ID','=',$iduser)->first();
    
        
        $update = Meetting_inside_index::find($id); 
        $update->MEETING_INSIDE_CODE = $request->MEETING_INSIDE_CODE;
        $update->MEETING_INSIDE_NO = $request->MEETING_INSIDE_NO;
        $update->MEETING_INSIDE_BUDGET = $request->MEETING_INSIDE_BUDGET;
        $update->MEETING_INSIDE_DATE = $icontrol_date;
        $update->MEETING_INSIDE_STARTTIME = $request->MEETING_INSIDE_STARTTIME;
        $update->MEETING_INSIDE_ENDTIME = $request->MEETING_INSIDE_ENDTIME;
        $update->MEETING_INSIDE_TITLE = $request->MEETING_INSIDE_TITLE;
        $update->MEETING_INSIDE_PRESIDENT = $request->MEETING_INSIDE_PRESIDENT;
        $update->MEETING_INSIDE_TYPE = $request->MEETING_INSIDE_TYPE;
        $update->MEETING_INSIDE_LOCATION = $request->MEETING_INSIDE_LOCATION;
        $update->ROOM_ID = $request->ROOM_ID;
        $update->MEETING_INSIDE_USERSAVE = $usersave->ID;
        $update->MEETING_INSIDE_USERSAVE_NAME = $usersave->HR_FNAME.' ' .$usersave->HR_LNAME;
        $update->MEETING_STATUS = 'APPLY';
    
        // $idfile = $request->MEETING_INSIDE_ID;
    
        if($request->hasFile('pdfupload')){
            $newFileName = 'meetinside_'.$id.'.'.$request->pdfupload->extension();          
            $request->pdfupload->storeAs('meettinginsidepdf',$newFileName,'public');     
            $update->MEETING_INSIDE_FILE = $newFileName;        
        }        
        $update->save();                     
       
        Meetting_inside_usersub::where('MEETING_INSIDE_ID','=',$id)->delete();
    
        if($request->MEETING_INSIDE_USER != '' || $request->MEETING_INSIDE_USER != null)
        {        
            $MEETING_INSIDE_USER = $request->MEETING_INSIDE_USER;                         
            $number =count($MEETING_INSIDE_USER);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $usersub = Person::where('ID','=',$MEETING_INSIDE_USER[$count])->first();
    
                        $update_usersub = new Meetting_inside_usersub();    
                        $update_usersub->MEETING_INSIDE_ID = $id;   
                        $update_usersub->MEETING_INSIDE_USERSUB_IDNAME = $usersub->ID; 
                        $update_usersub->MEETING_INSIDE_USERSUB_FNAME = $usersub->HR_FNAME; 
                        $update_usersub->MEETING_INSIDE_USERSUB_LNAME = $usersub->HR_LNAME;
                        $update_usersub->save(); 
                    }
        } 
    
        Meetting_inside_useroutsub::where('MEETING_INSIDE_ID','=',$id)->delete();
    
        if($request->MEETING_INSIDE_USEROUT != '' || $request->MEETING_INSIDE_USEROUT != null)
        {        
            $MEETING_INSIDE_USEROUT = $request->MEETING_INSIDE_USEROUT;                         
            $number =count($MEETING_INSIDE_USEROUT);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $update_useroutsub = new Meetting_inside_useroutsub();    
                        $update_useroutsub->MEETING_INSIDE_ID = $id;   
                        $update_useroutsub->MEETING_INSIDE_USEROUT_NAME = $MEETING_INSIDE_USEROUT[$count];   
                        $update_useroutsub->save(); 
                    }
        } 
    
        Meetting_inside_performancesub::where('MEETING_INSIDE_ID','=',$id)->delete();
        
        if($request->MEETING_INSIDE_PERFORMANCE != '' || $request->MEETING_INSIDE_PERFORMANCE != null)
        {        
            $MEETING_INSIDE_PERFORMANCE = $request->MEETING_INSIDE_PERFORMANCE;                         
            $number =count($MEETING_INSIDE_PERFORMANCE);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $update_performancesub = new Meetting_inside_performancesub();    
                        $update_performancesub->MEETING_INSIDE_ID = $id;   
                        $update_performancesub->MEETING_INSIDE_PERFORMANCE_NAME = $MEETING_INSIDE_PERFORMANCE[$count];   
                        $update_performancesub->save(); 
                    }
        }
    
        Meetting_inside_professionsub::where('MEETING_INSIDE_ID','=',$id)->delete();
    
        if($request->MEETING_INSIDE_PROFESSION != '' || $request->MEETING_INSIDE_PROFESSION != null)
        {        
            $MEETING_INSIDE_PROFESSION = $request->MEETING_INSIDE_PROFESSION;                         
            $number =count($MEETING_INSIDE_PROFESSION);
            $count = 0;    
                for($count = 0; $count< $number; $count++)
                    { 
                        $update_performancesub = new Meetting_inside_professionsub();    
                        $update_performancesub->MEETING_INSIDE_ID = $id;   
                        $update_performancesub->MEETING_INSIDE_PROFESSION_NAME = $MEETING_INSIDE_PROFESSION[$count];   
                        $update_performancesub->save(); 
                    }
        }
    
        return redirect()->route('mperson.inforperson_meetinginside');
    }


    public function inforperson_meetinginside_cancel(Request $request,$id)
    {

        $meetting_inside_type = DB::table('meetting_inside_type')->get();

        $infopresident = DB::table('hrd_person')->get();

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

        $meetting_inside_type = DB::table('meetting_inside_type')->get();
        $location             = DB::table('grecord_org_location')->get();    
        $room          = DB::table('meetingroom_index')->get();
        $infopresident =  DB::table('hrd_person')->get();

        $meetinginside = DB::table('meetting_inside_index')
        ->leftJoin('hrd_person','meetting_inside_index.MEETING_INSIDE_PRESIDENT','=','hrd_person.ID')
        ->leftJoin('meetting_inside_type','meetting_inside_index.MEETING_INSIDE_TYPE','=','meetting_inside_type.MEETTINGSIDE_ID')
        ->leftjoin('grecord_status','meetting_inside_index.MEETING_STATUS','=','grecord_status.STATUS')
        ->leftjoin('meetingroom_index','meetting_inside_index.ROOM_ID','=','meetingroom_index.ROOM_ID')
        ->where('meetting_inside_index.MEETING_INSIDE_ID','=',$id)->first();


        $inside_usersub =  DB::table('meetting_inside_usersub') ->where('meetting_inside_usersub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_useroutsub =  DB::table('meetting_inside_useroutsub') ->where('meetting_inside_useroutsub.MEETING_INSIDE_ID','=',$id)->get();


        $inside_performance =  DB::table('meetting_inside_performancesub') ->where('meetting_inside_performancesub.MEETING_INSIDE_ID','=',$id)->get();
        $inside_professionsub =  DB::table('meetting_inside_professionsub') ->where('meetting_inside_professionsub.MEETING_INSIDE_ID','=',$id)->get();



        return view('manager_person.inforperson_meetinginside_cancel', [
            'inside_usersubs' =>  $inside_usersub,
            'inside_useroutsubs' =>  $inside_useroutsub,
            'meetinginsides' =>  $meetinginside,
            'inside_performances' =>  $inside_performance,
            'inside_professionsubs' =>  $inside_professionsub,
            'rooms'                 => $room,
            'locations'             => $location,
            'meetting_inside_types' => $meetting_inside_type,
            'infopresidents'        => $infopresident,
             'displaydate_bigen'     => $displaydate_bigen,
            'displaydate_end'       => $displaydate_end,
            'status_check'          => $status,
            'search'                => $search,
            'budgets'               => $budget,
            'year_id'               => $year_id
        ]);
    }


    public function inforperson_meetinginside_updatecancel(Request $request)
    {
 
    $id = $request->MEETING_INSIDE_ID; 

      $updatecancel = Meetting_inside_index::find($id);
      $updatecancel->MEETING_STATUS = 'CANCEL'; 
      $updatecancel->MEETING_INSIDE_COMMENT = $request->MEETING_INSIDE_COMMENT;
      $updatecancel->save();
               
      return redirect()->route('mperson.inforperson_meetinginside');

}













    public function setinforperson_meetinginside_save(Request $request)
    {
        $add                    = new Meetting_inside_type();
        $add->MEETTINGSIDE_NAME = $request->MEETTINGSIDE_NAME;
        $add->save();

        return redirect()->route('setmperson.setinforperson_meetinginside');
    }

   

 //======================ฟังชั่น====================//

 public function checkuserin(Request $request)
 {
     $idin   = $request->MEETING_INSIDE_ID;
     $userin = DB::table('meetting_inside_usersub')->wherewhere('MEETING_INSIDE_ID', '=', $idin)->first();
     echo $userin->MEETING_INSIDE_ID;

 }

 public function setinforperson_meetinginside(Request $request)
 {
     $search     = $request->get('search');
     $status     = $request->STATUS_CODE;
     $datebigin  = $request->get('DATE_BIGIN');
     $dateend    = $request->get('DATE_END');
     $yearbudget = $request->BUDGET_YEAR;

     if ($datebigin != '' && $dateend != '') {
         $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
         $date_arrary  = explode("-", $date_bigen_c);
         $y_sub_st     = $date_arrary[0];

         if ($y_sub_st >= 2500) {
             $y = $y_sub_st - 543;
         } else {
             $y = $y_sub_st;
         }

         $m                 = $date_arrary[1];
         $d                 = $date_arrary[2];
         $displaydate_bigen = $y . "-" . $m . "-" . $d;

         $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
         $date_arrary_e = explode("-", $date_end_c);

         $y_sub_e = $date_arrary_e[0];

         if ($y_sub_e >= 2500) {
             $y_e = $y_sub_e - 543;
         } else {
             $y_e = $y_sub_e;
         }
         $m_e             = $date_arrary_e[1];
         $d_e             = $date_arrary_e[2];
         $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

         $from = date($displaydate_bigen);
         $to   = date($displaydate_end);
     }

     $year_id = $yearbudget;

     $infostatus      = DB::table('health_screen_status')->get();
     $meetting_inside = DB::table('meetting_inside_type')->get();

     return view('manager_person.setinforperson_meetinginside', [
         'infostatuss'      => $infostatus,
         // 'displaydate_bigen'=> $displaydate_bigen,
          // 'displaydate_end'=> $displaydate_end,
          'status_check'     => $status,
         'search'           => $search,
         'year_id'          => $year_id,
         'meetting_insides' => $meetting_inside
     ]);
 }




    public function avgbloodlower(Request $request)
    {

        $HEALTH_BODY_BLOOD11 = $request->HEALTH_BODY_BLOOD11;
        $HEALTH_BODY_BLOOD21 = $request->HEALTH_BODY_BLOOD21;

        $result = number_format(($HEALTH_BODY_BLOOD11 + $HEALTH_BODY_BLOOD21) / 2);

        return $result;
    }

    public function avgbloodtop(Request $request)
    {

        $HEALTH_BODY_BLOOD12 = $request->HEALTH_BODY_BLOOD12;
        $HEALTH_BODY_BLOOD22 = $request->HEALTH_BODY_BLOOD22;

        $result = number_format(($HEALTH_BODY_BLOOD12 + $HEALTH_BODY_BLOOD22) / 2);

        return $result;
    }

//=================================================

    public function checkcode(Request $request)
    {

        $HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID;
        $result               = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $HEALTH_SCREEN_LAB_ID)->first();

        return $result->HEALTH_SCREEN_LAB_CODE;
    }

    public function checkpice(Request $request)
    {

        $HEALTH_SCREEN_LAB_ID = $request->HEALTH_SCREEN_LAB_ID;
        $number               = $request->number;
        $result               = DB::table('health_screen_lab')->where('HEALTH_SCREEN_LAB_ID', '=', $HEALTH_SCREEN_LAB_ID)->first();

        $outpuet = '<input type="text" name="HEALTH_SCREEN_CON_PICE[]" id="HEALTH_SCREEN_CON_PICE' . $number . '" value="' . number_format($result->HEALTH_SCREEN_LAB_PICE, 2) . '" class="form-control input-lg" style=" font-family: \'Kanit\', sans-serif;font-size: 13px;" onkeyup="checksummoney(' . $number . ');">';

        return $outpuet;
    }

    public function checksummoney(Request $request)
    {

        $SUP_TOTAL      = $request->get('SUP_TOTAL');
        $PRICE_PER_UNIT = $request->get('PRICE_PER_UNIT');

        $output = number_format(($SUP_TOTAL * $PRICE_PER_UNIT), 2);
        $resule = $output . '<input type="hidden" name="sum" id="sum" value="' . ($SUP_TOTAL * $PRICE_PER_UNIT) . '">';

        return $resule;

    }

    public function persondevreport(Request $request)
    {
        if(!empty($request->DATE_BIGIN) ){
            $datebigin = datepickerTodate($request->DATE_BIGIN);
            $dateend = datepickerTodate($request->DATE_END);
            $ID_PERSON = $request->ID_PERSON;
            $search    = $request->search;
            session([
                'manager_person.persondevreport.DATE_BIGIN'=> $datebigin,
                'manager_person.persondevreport.DATE_END'=> $dateend,
                'manager_person.persondevreport.ID_PERSON'=> $ID_PERSON,
                'manager_person.persondevreport.search'=> $search
                ]);
        }elseif(!empty(session('manager_person.persondevreport'))){
            $datebigin = session('manager_person.persondevreport.DATE_BIGIN');
            $dateend = session('manager_person.persondevreport.DATE_END');
            $ID_PERSON = session('manager_person.persondevreport.ID_PERSON');
            $search = session('manager_person.persondevreport.search');
        }else{
            $datebigin = date('Y-m-1');
            $dateend   = date('Y-m-d', strtotime(date('Y-m-1'). '+1month -1days'));
            $ID_PERSON = '';
            $search = '';
        }

            $datebigin_year = Carbon::createFromFormat('Y-m-d', $datebigin)->format('Y');
            if($datebigin_year >= 2500){
                $datebigin_month = Carbon::createFromFormat('Y-m-d', $datebigin)->format('-m-d');
                $datebigin = ($datebigin_year-543).$datebigin_month;
            }
            $dateend_year = Carbon::createFromFormat('Y-m-d', $dateend)->format('Y');
            if($dateend_year >= 2500){
                $dateend_month = Carbon::createFromFormat('Y-m-d', $dateend)->format('-m-d');
                $dateend = ($dateend_year-543).$dateend_month;
            }

            $from =  $datebigin;
            $to = $dateend;
            if ($ID_PERSON != '') {
                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_index_person', 'grecord_index.ID', '=', 'grecord_index_person.RECORD_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where('grecord_index_person.HR_PERSON_ID', '=', $ID_PERSON)
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();
            } else {
                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
                    ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');
                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();

            }

        $grecordstatus = DB::table('grecord_status')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id      = $yearbudget;
        $person_check = $ID_PERSON;
        $status       = '';
        $infoperson   = DB::table('hrd_person')
            ->where('HR_STATUS_ID', '<>', 5)
            ->where('HR_STATUS_ID', '<>', 6)
            ->where('HR_STATUS_ID', '<>', 7)
            ->where('HR_STATUS_ID', '<>', 8)
            ->get();

        return view('manager_person.persondevreport', [
            'inforrecordindexs' => $inforrecordindex,
            'grecordstatuss'    => $grecordstatus,
            'displaydate_bigen' => $datebigin,
            'displaydate_end'   => $dateend,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'infopersons'       => $infoperson,
            'person_check'      => $person_check
        ]);
    }

    public function persondevreport_search(Request $request)
    {
        $datebigin = $request->get('DATE_BIGIN');
        $dateend   = $request->get('DATE_END');
        $ID_PERSON = $request->get('ID_PERSON');
        $search    = $request->get('search');

        if ($datebigin != '' && $dateend != '') {
            $date_bigen_c = Carbon::createFromFormat('d/m/Y', $datebigin)->format('Y-m-d');
            $date_arrary  = explode("-", $date_bigen_c);
            $y_sub_st     = $date_arrary[0];

            if ($y_sub_st >= 2500) {
                $y = $y_sub_st - 543;
            } else {
                $y = $y_sub_st;
            }

            $m                 = $date_arrary[1];
            $d                 = $date_arrary[2];
            $displaydate_bigen = $y . "-" . $m . "-" . $d;

            $date_end_c    = Carbon::createFromFormat('d/m/Y', $dateend)->format('Y-m-d');
            $date_arrary_e = explode("-", $date_end_c);

            $y_sub_e = $date_arrary_e[0];

            if ($y_sub_e >= 2500) {
                $y_e = $y_sub_e - 543;
            } else {
                $y_e = $y_sub_e;
            }
            $m_e             = $date_arrary_e[1];
            $d_e             = $date_arrary_e[2];
            $displaydate_end = $y_e . "-" . $m_e . "-" . $d_e;

            $from = date($displaydate_bigen);
            $to   = date($displaydate_end);
            if ($ID_PERSON != '') {

                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_index_person', 'grecord_index.ID', '=', 'grecord_index_person.RECORD_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where('grecord_index_person.HR_PERSON_ID', '=', $ID_PERSON)
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();
            } else {

                $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                    , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                    , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
                    ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
                    ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                    ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                    ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                    ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                    ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                    ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                    ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                    ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                    ->WhereBetween('DATE_GO', [$from, $to])
                    ->where(function ($q) use ($search) {
                        $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                        $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                        $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                    })
                    ->orderBy('grecord_index.ID', 'desc')
                    ->get();

            }

        }

        $grecordstatus = DB::table('grecord_status')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id      = $yearbudget;
        $person_check = $ID_PERSON;
        $status       = '';
        $infoperson   = DB::table('hrd_person')
            ->where('HR_STATUS_ID', '<>', 5)
            ->where('HR_STATUS_ID', '<>', 6)
            ->where('HR_STATUS_ID', '<>', 7)
            ->where('HR_STATUS_ID', '<>', 8)
            ->get();

        return view('manager_person.persondevreport', [
            'inforrecordindexs' => $inforrecordindex,
            'grecordstatuss'    => $grecordstatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'infopersons'       => $infoperson,
            'person_check'      => $person_check
        ]);
    }

    public function persondevreport_excel(Request $request, $datebegin, $dateen, $idperson, $search)
    {
        $from = $datebegin;
        $to   = $dateen;
        if ($search == 'null') {
            $search = '';
        }

        if ($idperson != 'null') {

            $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK')
                ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                ->leftJoin('grecord_index_person', 'grecord_index.ID', '=', 'grecord_index_person.RECORD_ID')
                ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                ->WhereBetween('DATE_GO', [$from, $to])
                ->where('grecord_index_person.HR_PERSON_ID', '=', $idperson)
                ->where(function ($q) use ($search) {
                    $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                    $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                })
                ->orderBy('grecord_index.ID', 'desc')
                ->get();
        } else {

            $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
                , 'RECORD_LEVEL_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
                , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
                ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
                ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
                ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
                ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
                ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
                ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
                ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
                ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
                ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
                ->WhereBetween('DATE_GO', [$from, $to])
                ->where(function ($q) use ($search) {
                    $q->where('STATUS_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_TYPE_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('RECORD_HEAD_USE', 'like', '%' . $search . '%');
                    $q->orwhere('LOCATION_ORG_NAME', 'like', '%' . $search . '%');
                    $q->orwhere('USER_POST_NAME', 'like', '%' . $search . '%');

                })
                ->orderBy('grecord_index.ID', 'desc')
                ->get();

        }

        return view('manager_person.persondevreport_excel', [
            'inforrecordindexs' => $inforrecordindex
        ]);
    }

    public static function grouppersundev($RECORD_ID)
    {
        $query = DB::table('grecord_index_person')->where('RECORD_ID', '=', $RECORD_ID)->get();

        $num = 1;
        foreach ($query as $row) {
            if ($num == 1) {
                $output = $row->HR_FULLNAME . "|";
            } else {
                $output .= $row->HR_FULLNAME . "|";
            }

            $num++;
        }

        return $output;
    }

    public function personmeettinginside(Request $request)
    {

        $mo = date('Y-m');

        $inforrecordindex = Recordindex::select('grecord_index.ID', 'grecord_index.STATUS', 'STATUS_NAME', 'RECORD_TYPE_NAME', 'grecord_index.RECORD_TYPE_ID', 'USER_POST_NAME', 'RECORD_HEAD_USE', 'LOCATION_ORG_NAME'
            , 'RECORD_LEVEL_NAME', 'RECORD_ORG_NAME', 'RECORD_ORGANIZER_NAME', 'gleave_location.LOCATION_NAME', 'DATE_GO', 'DATE_BACK', 'RECORD_COMMENT', 'RECORD_GO_NAME', 'RECORD_VEHICLE_NAME', 'WITHDRAW_NAME'
            , 'LEADER_HR_NAME', 'OFFER_WORK_HR_NAME', 'SAVE_BACK', 'RECORD_USER_ID', 'POSITION_IN_WORK')
            ->leftJoin('grecord_org', 'grecord_org.RECORD_ORG_ID', '=', 'grecord_index.RECORD_ORG_ID')
            ->leftJoin('hrd_person', 'grecord_index.RECORD_USER_ID', '=', 'hrd_person.ID')
            ->leftJoin('grecord_status', 'grecord_index.STATUS', '=', 'grecord_status.STATUS')
            ->leftJoin('grecord_type', 'grecord_index.RECORD_TYPE_ID', '=', 'grecord_type.RECORD_TYPE_ID')
            ->leftJoin('grecord_org_location', 'grecord_org_location.LOCATION_ID', '=', 'grecord_index.RECORD_LOCATION_ID')
            ->leftJoin('grecord_level', 'grecord_level.ID', '=', 'grecord_index.RECORD_LEVEL_ID')
            ->leftJoin('gleave_location', 'gleave_location.LOCATION_ID', '=', 'grecord_index.LOCATION_PROV_ID')
            ->leftJoin('grecord_go', 'grecord_go.RECORD_GO_ID', '=', 'grecord_index.RECORD_GO_ID')
            ->leftJoin('grecord_vehicle', 'grecord_vehicle.RECORD_VEHICLE_ID', '=', 'grecord_index.RECORD_VEHICLE_ID')
            ->leftJoin('grecord_withdraw', 'grecord_withdraw.WITHDRAW_ID', '=', 'grecord_index.RECORD_MONEY_ID')
            ->where('DATE_GO', 'like', $mo . '%')
            ->orderBy('grecord_index.ID', 'desc')
            ->get();

        $grecordstatus = DB::table('grecord_status')->get();

        $m_budget = date("m");
        if ($m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $budget            = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $displaydate_bigen = $mo . '-01';

        $M = date('m');

        if ($M == 2) {
            if (date("Y") % 4 == 0) {
                $displaydate_end = $mo . '-29';
            } else {
                $displaydate_end = $mo . '-28';
            }

        } elseif ($M == 1 || $M == 3 || $M == 5 || $M == 7 || $M == 8 || $M == 10 || $M == 12) {
            $displaydate_end = $mo . '-31';
        } else {
            $displaydate_end = $mo . '-30';
        }

        $infoperson = DB::table('hrd_person')
            ->where('HR_STATUS_ID', '<>', 5)
            ->where('HR_STATUS_ID', '<>', 6)
            ->where('HR_STATUS_ID', '<>', 7)
            ->where('HR_STATUS_ID', '<>', 8)
            ->get();

        $status       = '';
        $search       = '';
        $person_check = '';
        $year_id      = $yearbudget;

        return view('manager_person.personmeettinginside', [
            'inforrecordindexs' => $inforrecordindex,
            'grecordstatuss'    => $grecordstatus,
            'displaydate_bigen' => $displaydate_bigen,
            'displaydate_end'   => $displaydate_end,
            'status_check'      => $status,
            'search'            => $search,
            'budgets'           => $budget,
            'year_id'           => $year_id,
            'infopersons'       => $infoperson,
            'person_check'      => $person_check
        ]);
    }

    public static function contperson($iddep)
    {

        $total = DB::table('meetting_inside_usersub')->where('MEETING_INSIDE_ID', '=', $iddep)->count();

        return $total;
    }

}
