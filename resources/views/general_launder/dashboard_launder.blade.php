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

      label{
            font-family: 'Kanit', sans-serif;
            font-size: 14px;

      }

      @media only screen and (min-width: 1200px) {
label {
    float:right;
  }

      }

      .text-pedding{
   padding-left:10px;
                    }

        .text-font {
    font-size: 14px;
                  }
    

</style>

<script>
    function checklogin(){
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



use App\Http\Controllers\PerdevController;
$checkapp = PerdevController::checkapp($user_id);
$checkver = PerdevController::checkver($user_id);

$countapp = PerdevController::countapp($user_id);
$countver = PerdevController::countver($user_id);


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
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลสถานะคลังผ้า</B></h3>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                                            <div class="row">
                                            <div>
                                             <a href="{{ url('general_launder/dashboard_launder/'.$inforpersonuserid -> ID) }}" class="btn btn-warning" >Dashboard</a>
                                            </div>
                                            <div>&nbsp;</div>

                                            <div>
                                            <a href="{{ url('general_launder/stockcard_launder/'.$inforpersonuserid -> ID) }}" class="btn " style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">คลังย่อย

                                                <span class="badge badge-light" ></span>

                                            </a>
                                            </div>
                                            <div>&nbsp;</div>

                                            <div>
                                             <a href="{{ url('general_launder/withdraw_launder/'.$inforpersonuserid -> ID) }}" class="btn " style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">เช็คสต๊อค-เบิกผ้า</a>
                                            </div>
                                            <div>&nbsp;</div>

                                            <div>
                                             <a href="{{ url('general_launder/pay_launder/'.$inforpersonuserid -> ID) }}" class="btn " style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">จ่ายผ้า</a>
                                            </div>
                                            <div>&nbsp;</div>

                                          
                                            <div>&nbsp;</div>
   

                                            </ol>

                            </nav>
            </div>
            <div class="block-content">

            <div class="block-content">
            <form action="" method="post">
                    @csrf 
            <div class="row" >
        
           
            <div class="col-md-2">
                &nbsp;ประจำปีงบประมาณ : &nbsp;
            </div>
            <div class="col-md-2">
                <span>
                <select name="STATUS_CODE" id="STATUS_CODE" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">   
                                    @foreach ($budgets as $budget)
                                @if($budget->LEAVE_YEAR_ID== $year_id)
                        <option value="{{ $budget->LEAVE_YEAR_ID  }}" selected>{{ $budget->LEAVE_YEAR_ID}}</option>
                                @else
                        <option value="{{ $budget->LEAVE_YEAR_ID  }}">{{ $budget->LEAVE_YEAR_ID}}</option>
                                @endif                                 
                            @endforeach                         
                                </select>

                 
                   
                </span>

                </div> 
                <div class="col-md-1">
                            <span>
                                <button type="submit" class="btn btn-info" >แสดง</button>
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
                    <div class="ml-3 text-right" >

                        <p class="text-white mb-0" style="font-size: 2.25rem;">
                        {{$getbacks}}
                        
                        </p>
                        <p class="text-white mb-0">
                        รับผ้า 
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
                    {{$checks}}
                        </p>
                        <p class="text-white mb-0">
                        ตรวจรับผ้า 
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
                {{$diss}}
                        </p>
                        <p class="text-white mb-0">
                        ส่งผ้า
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
                {{$withdrows}}
                        </p>
                        <p class="text-white mb-0">
                       เบิก-จ่าย
                        </p>

                    </div>

                </div>
            </a>
        </div>
</div>

<center>
            <div style="width: 100%;">
               
                    <div class="row">
                        <div class="col-md-6">
                            <!-- PIE CHART -->
                            <div class="card shadow lg">
                          
                                <div class="card-body shadow lg">
                               
                                <div id="chart_dep" style="width: 100%; height: 500px;"></div>
                                </div>
                                
                            </div>
                           
                        </div>
                        <div class="col-md-6">
                            <!-- PIE CHART -->
                            <div class="card shadow lg">
                         
                                        <div class="card-body shadow lg">

                                        <div id="chart_checkdep" style="width: 100%; height: 500px;"></div>

                                        </div>
                                       
                                    </div>
                                   
                            </div>
                        </div>   
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- PIE CHART -->
                            <div class="card shadow lg">
                                                                 
                              
                                <div class="card-body shadow lg">
                               
                                <div id="chart_dis" style="width: 100%; height: 500px;"></div>
                                </div>
                                
                            </div>
                           
                        </div>
                        <div class="col-md-6">
                            <!-- PIE CHART -->
                            <div class="card shadow lg">
                                        
                                        <div class="card-body shadow lg">

                                        <div id="chart_withdrow" style="width: 100%; height: 500px;"></div>

                                        </div>
                                       
                                    </div>
                                   
                            </div>
                        </div>   
                        <br>
                    </div>
            </div> 
           
        </center>

<!-- <div style="width: 95%;">
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




</div> -->

@endsection

@section('footer')

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>


<script src="{{ asset('google/Charts.js') }}"></script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
          ['บริหารกลุ่มการพยาบาล', <?php echo $d_1; ?>], ['งานอุบัติเหตุฉุกเฉิน', <?php echo $d_2; ?>], ['งานวิสัญญี', <?php echo $d_3; ?>], ['งานห้องผ่าตัด', <?php echo $d_4; ?>], ['งานห้องคลอด', <?php echo $d_5; ?>],
          ['งานผู้ป่วยใน 1', <?php echo $d_6; ?>], ['งานผู้ป่วยใน 2', <?php echo $d_7; ?>], ['งานผู้ป่วยใน 3', <?php echo $d_8; ?>], ['งานผู้ป่วยนอก', <?php echo $d_9; ?>], ['งานให้คำปรึกษา', <?php echo $d_10; ?>],
          ['งานเคลื่อนย้ายผู้ป่วย', <?php echo $d_11; ?>], ['งานจ่ายกลาง', <?php echo $d_12; ?>], ['งานบริการอาหาร ', <?php echo $d_13; ?>], ['ฝ่ายบริหารงานทั่วไป', <?php echo $d_14; ?>], ['งานการเงิน', <?php echo $d_15; ?>],
          ['ART-งานพัสดุ', <?php echo $d_16; ?>], ['BOO-งานธุรการ', <?php echo $d_17; ?>], ['CAL-งานซ่อมบำรุง ', <?php echo $d_18; ?>], ['AMB-งานยานพาหนะ', <?php echo $d_19; ?>], ['GAR-งานภูมิทัศน์', <?php echo $d_20; ?>],
          ['CLC-งานซักฟอก', <?php echo $d_21; ?>], ['SEC-งานรักษาความปลอดภัย', <?php echo $d_22; ?>], ['CLE-งานทำความสะอาด ', <?php echo $d_23; ?>], ['MED-งานเวชปฏิบัติทั่วไป', <?php echo $d_24; ?>], ['XRA-งานรังสี', <?php echo $d_25; ?>],
          ['LAB-งานเทคนิคการแพทย์', <?php echo $d_26; ?>], ['TTM-งานแพทย์แผนไทย', <?php echo $d_27; ?>], ['PLA-ฝ่ายแผนงานและประเมินผล', <?php echo $d_28; ?>], ['COM-งานศูนย์คอมพิวเตอร์', <?php echo $d_29; ?>], ['HAC-งานศูนย์ประกันสุขภาพ', <?php echo $d_30; ?>],
          ['MRD-งานเวชระเบียน', <?php echo $d_31; ?>], ['FMC-ฝ่ายเวชปฏิบัติครอบครัว', <?php echo $d_32; ?>], ['PHA-ฝ่ายเภสัชกรรมชุมชน', <?php echo $d_33; ?>], ['PTD-ฝ่ายเวชกรรมฟื้นฟู', <?php echo $d_34; ?>], ['FUN-ฝ่ายทันตสาธารณสุข', <?php echo $d_35; ?>],
          ['HED-งานสุขศึกษาและประชาสัมพันธ์', <?php echo $d_36; ?>],
        ]);
            
        var options = {
          title: 'รายการหน่วยงานที่รับผ้า ',
          fontName: 'Kanit', 
          pieHole: 0.4, 
        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_dep'));
        chart.draw(data, options);
        }
</script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
          ['หน่วยงานภายใน',     <?php echo $o_1; ?>],
          ['หน่วยงานภายนอก',     <?php echo $o_2; ?>],
        ]);
            
            
        var options = {
          title: 'รายการหน่วยงานที่ตรวจรับ ',
          fontName: 'Kanit', 
          pieHole: 0.4, 
        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_checkdep'));
        chart.draw(data, options);
        }
</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
          ['บริหารกลุ่มการพยาบาล', <?php echo $di_1; ?>], ['งานอุบัติเหตุฉุกเฉิน', <?php echo $di_2; ?>], ['งานวิสัญญี', <?php echo $di_3; ?>], ['งานห้องผ่าตัด', <?php echo $di_4; ?>], ['งานห้องคลอด', <?php echo $di_5; ?>],
          ['งานผู้ป่วยใน 1', <?php echo $di_6; ?>], ['งานผู้ป่วยใน 2', <?php echo $di_7; ?>], ['งานผู้ป่วยใน 3', <?php echo $di_8; ?>], ['งานผู้ป่วยนอก', <?php echo $di_9; ?>], ['งานให้คำปรึกษา', <?php echo $di_10; ?>],
          ['งานเคลื่อนย้ายผู้ป่วย', <?php echo $di_11; ?>], ['งานจ่ายกลาง', <?php echo $di_12; ?>], ['งานบริการอาหาร ', <?php echo $di_13; ?>], ['ฝ่ายบริหารงานทั่วไป', <?php echo $di_14; ?>], ['งานการเงิน', <?php echo $di_15; ?>],
          ['ART-งานพัสดุ', <?php echo $di_16; ?>], ['BOO-งานธุรการ', <?php echo $di_17; ?>], ['CAL-งานซ่อมบำรุง ', <?php echo $di_18; ?>], ['AMB-งานยานพาหนะ', <?php echo $di_19; ?>], ['GAR-งานภูมิทัศน์', <?php echo $di_20; ?>],
          ['CLC-งานซักฟอก', <?php echo $di_21; ?>], ['SEC-งานรักษาความปลอดภัย', <?php echo $di_22; ?>], ['CLE-งานทำความสะอาด ', <?php echo $di_23; ?>], ['MED-งานเวชปฏิบัติทั่วไป', <?php echo $di_24; ?>], ['XRA-งานรังสี', <?php echo $di_25; ?>],
          ['LAB-งานเทคนิคการแพทย์', <?php echo $di_26; ?>], ['TTM-งานแพทย์แผนไทย', <?php echo $di_27; ?>], ['PLA-ฝ่ายแผนงานและประเมินผล', <?php echo $di_28; ?>], ['COM-งานศูนย์คอมพิวเตอร์', <?php echo $di_29; ?>], ['HAC-งานศูนย์ประกันสุขภาพ', <?php echo $di_30; ?>],
          ['MRD-งานเวชระเบียน', <?php echo $di_31; ?>], ['FMC-ฝ่ายเวชปฏิบัติครอบครัว', <?php echo $di_32; ?>], ['PHA-ฝ่ายเภสัชกรรมชุมชน', <?php echo $di_33; ?>], ['PTD-ฝ่ายเวชกรรมฟื้นฟู', <?php echo $di_34; ?>], ['FUN-ฝ่ายทันตสาธารณสุข', <?php echo $di_35; ?>],
          ['HED-งานสุขศึกษาและประชาสัมพันธ์', <?php echo $di_36; ?>],
        ]);
            
        var options = {
          title: 'รายการหน่วยงานที่ส่งผ้า ',
          fontName: 'Kanit', 
          pieHole: 0.4, 
        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_dis'));
        chart.draw(data, options);
        }
</script>

<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
          ['บริหารกลุ่มการพยาบาล', <?php echo $dw_1; ?>], ['งานอุบัติเหตุฉุกเฉิน', <?php echo $dw_2; ?>], ['งานวิสัญญี', <?php echo $dw_3; ?>], ['งานห้องผ่าตัด', <?php echo $dw_4; ?>], ['งานห้องคลอด', <?php echo $dw_5; ?>],
          ['งานผู้ป่วยใน 1', <?php echo $dw_6; ?>], ['งานผู้ป่วยใน 2', <?php echo $dw_7; ?>], ['งานผู้ป่วยใน 3', <?php echo $dw_8; ?>], ['งานผู้ป่วยนอก', <?php echo $dw_9; ?>], ['งานให้คำปรึกษา', <?php echo $dw_10; ?>],
          ['งานเคลื่อนย้ายผู้ป่วย', <?php echo $dw_11; ?>], ['งานจ่ายกลาง', <?php echo $dw_12; ?>], ['งานบริการอาหาร ', <?php echo $dw_13; ?>], ['ฝ่ายบริหารงานทั่วไป', <?php echo $dw_14; ?>], ['งานการเงิน', <?php echo $dw_15; ?>],
          ['ART-งานพัสดุ', <?php echo $dw_16; ?>], ['BOO-งานธุรการ', <?php echo $dw_17; ?>], ['CAL-งานซ่อมบำรุง ', <?php echo $dw_18; ?>], ['AMB-งานยานพาหนะ', <?php echo $dw_19; ?>], ['GAR-งานภูมิทัศน์', <?php echo $dw_20; ?>],
          ['CLC-งานซักฟอก', <?php echo $dw_21; ?>], ['SEC-งานรักษาความปลอดภัย', <?php echo $dw_22; ?>], ['CLE-งานทำความสะอาด ', <?php echo $dw_23; ?>], ['MED-งานเวชปฏิบัติทั่วไป', <?php echo $dw_24; ?>], ['XRA-งานรังสี', <?php echo $dw_25; ?>],
          ['LAB-งานเทคนิคการแพทย์', <?php echo $dw_26; ?>], ['TTM-งานแพทย์แผนไทย', <?php echo $dw_27; ?>], ['PLA-ฝ่ายแผนงานและประเมินผล', <?php echo $dw_28; ?>], ['COM-งานศูนย์คอมพิวเตอร์', <?php echo $dw_29; ?>], ['HAC-งานศูนย์ประกันสุขภาพ', <?php echo $dw_30; ?>],
          ['MRD-งานเวชระเบียน', <?php echo $dw_31; ?>], ['FMC-ฝ่ายเวชปฏิบัติครอบครัว', <?php echo $dw_32; ?>], ['PHA-ฝ่ายเภสัชกรรมชุมชน', <?php echo $dw_33; ?>], ['PTD-ฝ่ายเวชกรรมฟื้นฟู', <?php echo $dw_34; ?>], ['FUN-ฝ่ายทันตสาธารณสุข', <?php echo $dw_35; ?>],
          ['HED-งานสุขศึกษาและประชาสัมพันธ์', <?php echo $dw_36; ?>],
        ]);
            
            
        var options = {
          title: 'รายการหน่วยงานที่เบิก-จ่าย ',
          fontName: 'Kanit', 
          pieHole: 0.4, 
        };
        var chart = new google.visualization.PieChart(document.getElementById('chart_withdrow'));
        chart.draw(data, options);
        }
</script>
@endsection
