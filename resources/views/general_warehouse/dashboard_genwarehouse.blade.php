@extends('layouts.backend')

<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

<link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('asset/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">

@section('content')

<style>
    .center {
        margin: auto;
        width: 100%;
        padding: 10px;
    }

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;

    }

    label {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;

    }

    @media only screen and (min-width: 1200px) {
        label {
            float: right;
        }

    }

    .text-pedding {
        padding-left: 10px;
    }

    .text-font {
        font-size: 14px;
    }
</style>

<script>
    function checklogin() {
        window.location.href = '{{route("index")}}';
    }
</script>
<?php
if(Auth::check()){
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;
}else{
    echo "<body onload=\"checklogin()\"></body>";
    exit();
}

$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos);



use App\Http\Controllers\WarehouseController;

$checkagree = WarehouseController::agree($user_id);

?>
<?php
function RemoveDateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }


  function Removeformate($strDate)
{
  $strYear = date("Y",strtotime($strDate));
  $strMonth= date("m",strtotime($strDate));
  $strDay= date("d",strtotime($strDate));


  return $strDay."/".$strMonth."/".$strYear;
  }


?>
<!-- Advanced Tables -->
<div class="bg-body-light">
    <div class="block-header block-header-default">
        <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลสถานะคลังพัสดุ</B></h3>
        <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <div class="row">
                    <div>
                        <a href="{{ url('general_warehouse/dashboard/'.$inforpersonuserid -> ID) }}"
                            class="btn btn-warning loadscreen"
                            >Dashboard</a>
                    </div>
                    <div>&nbsp;</div>
                   
                    <div>
                        <a href="{{ url('general_warehouse/infowithdrawindex/'.$inforpersonuserid -> ID)}}" class="btn loadscreen"
                            style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">เบิกจากคลังหลัก</a>
                    </div>
                    <div>&nbsp;</div>
                    <div>
                        <a href="{{ url('general_warehouse/infostockcard/'.$inforpersonuserid -> ID)}}" class="btn loadscreen"
                            style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">คลังย่อย

                            <span class="badge badge-light"
                                ></span>

                        </a>
                    </div>
                    <div>&nbsp;</div>
                    <div>
                        <a href="{{ url('general_warehouse/infopayindex/'.$inforpersonuserid -> ID)}}" class="btn loadscreen"
                            style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">จ่ายวัสดุ</a>
                    </div>
                    <div>&nbsp;</div>

                    <div>

                        @if($checkagree <> 0)
                        
                        <a href="{{ url('general_warehouse/infoapp/'.$inforpersonuserid -> ID)}}" class="btn loadscreen"
                            style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">เห็นชอบ

                            <span class="badge badge-light"
                                ></span>

                        </a>

                        @endif

                    </div>
                    <div>&nbsp;</div>

            </ol>

        </nav>
    </div>
    <div class="block-content">

        <div class="block-content">
            <form action="{{ route('warehouse.dashboardsearch',[ 'iduser'=>$inforpersonuserid->ID ]) }}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-2">
                        &nbsp;ประจำปีงบประมาณ : &nbsp;
                    </div>
                    <div class="col-md-2">
                        <span>
                            <select name="STATUS_CODE" id="STATUS_CODE" class="form-control input-lg"
                                style=" font-family: 'Kanit', sans-serif;">
                                @foreach ($budgets as $budget)
                                @if($budget->LEAVE_YEAR_ID== $year_id)
                                <option value="{{ $budget->LEAVE_YEAR_ID  }}" selected>{{ $budget->LEAVE_YEAR_ID}}
                                </option>
                                @else
                                <option value="{{ $budget->LEAVE_YEAR_ID  }}">{{ $budget->LEAVE_YEAR_ID}}</option>
                                @endif
                                @endforeach
                            </select>

                        </span>

                    </div>
                    <div class="col-md-1">
                        <span>
                            <button type="submit" class="btn btn-info"
                                >แสดง</button>
                        </span>
                    </div>
                </div>

            </form>
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <a class="block block-rounded block-link-pop bg-xinspire" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div class="item">
                                <i class="fa fa-2x fa fa-book text-white"></i>
                            </div>
                            <div class="ml-3 text-right">

                                <p class="text-white mb-0" style="font-size: 2.25rem;">
                                    {{$count1}}
                                </p>
                                <p class="text-white mb-0">
                                    ขอเบิกวัสดุ (เรื่อง)
                                </p>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-xl-3">
                    <a class="block block-rounded block-link-pop bg-danger" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div class="item">
                                <i class="fa fa-2x fa fa-paper-plane text-white"></i>
                            </div>
                            <div class="ml-3 text-right">
                                <p class="text-white mb-0" style="font-size: 2.25rem;">
                                    {{$count2}}
                                </p>
                                <p class="text-white mb-0">
                                    หน. เห็นชอบ (เรื่อง)
                                </p>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-xl-3">
                    <a class="block block-rounded block-link-pop bg-warning" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div class="item">
                                <i class="fa fa-2x fa fa-inbox text-white"></i>
                            </div>
                            <div class="ml-3 text-right">
                                <p class="text-white mb-0" style="font-size: 2.25rem;">
                                    {{$count3}}
                                </p>
                                <p class="text-white mb-0">
                                    ตรวจสอบผ่าน (เรื่อง)
                                </p>

                            </div>

                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-xl-3">
                    <a class="block block-rounded block-link-pop bg-info" href="javascript:void(0)">
                        <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                            <div class="item">
                                <i class="fa fa-2x fa fa-hand-point-up text-white"></i>
                            </div>
                            <div class="ml-3 text-right">
                                <p class="text-white mb-0" style="font-size: 2.25rem;">
                                    {{$count4}}
                                </p>
                                <p class="text-white mb-0">
                                    อนุมัติ (เรื่อง)
                                </p>

                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div style="width: 95%;">
                <div class="block block-content">
                    <div id="columnchart_01" style="font-family: 'Kanit', sans-serif;width: 100%; height: 500px;"></div>
                </div>
            </div>
            <br>
            <div style="width: 95%;">
                <div class="block block-content">
                    <div id="columnchart_02" style="font-family: 'Kanit', sans-serif;width: 100%; height: 500px;"></div>
                </div>
            </div>

        </div>

        @endsection

        @section('footer')

        <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>

        <script src="{{ asset('google/Charts.js') }}"></script>

        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['เดือน', 'มูลค่า'],
                    ['ม.ค', < ? php echo $m1_1; ? > ],
                    ['ก.พ', < ? php echo $m2_1; ? > ],
                    ['มี.ค', < ? php echo $m3_1; ? > ],
                    ['เม.ย', < ? php echo $m4_1; ? > ],
                    ['พ.ค', < ? php echo $m5_1; ? > ],
                    ['มิ.ย', < ? php echo $m6_1; ? > ],
                    ['ก.ค', < ? php echo $m7_1; ? > ],
                    ['ส.ค', < ? php echo $m8_1; ? > ],
                    ['ก.ย', < ? php echo $m9_1; ? > ],
                    ['ต.ค', < ? php echo $m10_1; ? > ],
                    ['พ.ย', < ? php echo $m11_1; ? > ],
                    ['ธ.ค', < ? php echo $m12_1; ? > ]
                ]);
                var options = {
                    fontName: 'Kanit',
                    hAxis: {
                        slantedText: true,
                        slantedTextAngle: 45
                    },
                    chart: {
                        title: 'จำนวนมูลค่าการเบิกวัสดุของหน่วยงาน ปีปัจจุบัน',
                    }
                };
                var chart = new google.charts.Bar(document.getElementById('columnchart_01'));
                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>

        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart2);

            function drawChart2() {
                var data = google.visualization.arrayToDataTable([
                    ['เดือน', 'มูลค่า'],
                    ['ม.ค', < ? php echo $m1_2; ? > ],
                    ['ก.พ', < ? php echo $m2_2; ? > ],
                    ['มี.ค', < ? php echo $m3_2; ? > ],
                    ['เม.ย', < ? php echo $m4_2; ? > ],
                    ['พ.ค', < ? php echo $m5_2; ? > ],
                    ['มิ.ย', < ? php echo $m6_2; ? > ],
                    ['ก.ค', < ? php echo $m4_2; ? > ],
                    ['ส.ค', < ? php echo $m8_2; ? > ],
                    ['ก.ย', < ? php echo $m9_2; ? > ],
                    ['ต.ค', < ? php echo $m10_2; ? > ],
                    ['พ.ย', < ? php echo $m11_2; ? > ],
                    ['ธ.ค', < ? php echo $m12_2; ? > ]
                ]);
                var options = {
                    fontName: 'Kanit',
                    colors: ['#e0440e'],
                    hAxis: {
                        slantedText: true,
                        slantedTextAngle: 45
                    },
                    chart: {
                        title: 'จำนวนมูลค่าการจ่ายวัสดุของหน่วยงาน ปีปัจจุบัน',
                    }
                };
                var chart = new google.charts.Bar(document.getElementById('columnchart_02'));
                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>

        @endsection