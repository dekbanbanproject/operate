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




use App\Http\Controllers\SupliesController;
$checkapp = SupliesController::checkapp($user_id);
$checkallow = SupliesController::checkallow($user_id);

$countapp = SupliesController::countapp($user_id);
$countallow = SupliesController::countallow($user_id);

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
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลสถานะพัสดุ</B></h3>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                                            <div class="row">
                                            <div>
                                             <a href="{{ url('general_suplies/dashboard/'.$inforpersonuserid -> ID) }}" class="btn btn-sm btn-warning loadscreen" >Dashboard</a>
                                            </div>
                                            <div>&nbsp;</div>


                                            <div>
                                             <a href="{{ url('general_suplies/inforequest/'.$inforpersonuserid -> ID) }}" class="btn btn-sm loadscreen" style="background-color:#DCDCDC;color:#696969;">ขอจัดซื้อ/จัดจ้าง</a>
                                            </div>
                                            <div>&nbsp;</div>

                                       
                                            @if($checkapp != 0)
                                            <div>
                                           <a href="{{ url('general_suplies/inforequestapp/'.$inforpersonuserid -> ID)}}" class="btn btn-hero-sm btn-hero loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">เห็นชอบ

                                           @if($countapp!=0)
                                    <span class="badge badge-light" >{{$countapp}}</span>
                                            @endif
                                            </a>
                                            </div>
                                            <div>&nbsp;</div>
                                   
                                            @endif

                                            @if($checkallow!=0)
                                            <div>
                                            <a href="{{ url('general_suplies/inforequestlastapp/'.$inforpersonuserid -> ID)}}" class="btn btn-hero-sm btn-hero loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">อนุมัติ

                                            @if($countallow!=0)
                                            <span class="badge badge-light" >{{$countallow}}</span>
                                            @endif
                                            </a>
                                            </div>
                                            <div>&nbsp;</div>
                                            @endif 

                                            </ol>

                            </nav>
            </div>
            <div class="block-content">
            <div class="block-content">
            <form action="{{ route('supplies.dashboardsearch',[ 'iduser'=>$inforpersonuserid->ID ]) }}" method="post">
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
                                <button type="submit" class="btn btn-hero-sm btn-hero-info mr-2" >แสดง</button>
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
                        {{$amount_1}}
                        </p>
                        <p class="text-white mb-0">
                    ขอซื้อ/ขอจ้าง (เรื่อง)
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
                    {{$amount_2}}
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
                {{$amount_3}}
                        </p>
                        <p class="text-white mb-0">
                        พัสดุตรวจสอบ (เรื่อง)
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
                {{$amount_4}}
                        </p>
                        <p class="text-white mb-0">
                        ผอ.อนุมัติ (เรื่อง)
                        </p>

                    </div>

                </div>
            </a>
        </div>


        <div class="col-md-4 col-xl-3">
            <a class="block block-rounded block-link-pop bg-xsmooth" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div class="item">
                        <i class="fa fa-2x fa fa-book text-white"></i>
                    </div>
                    <div class="ml-3 text-right" >

                        <p class="text-white mb-0" style="font-size: 2.25rem;">
                        {{$amount_5}}
                        </p>
                        <p class="text-white mb-0">
                        รอเห็นชอบ (เรื่อง)
                        </p>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xl-3">
            <a class="block block-rounded block-link-pop bg-xpro" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div class="item">
                        <i class="fa fa-2x fa fa-paper-plane text-white"></i>
                    </div>
                    <div class="ml-3 text-right">
                    <p class="text-white mb-0" style="font-size: 2.25rem;">
                    {{$amount_6}}
                        </p>
                        <p class="text-white mb-0">
                        ไม่เห็นชอบ (เรื่อง)
                        </p>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-xl-3">
            <a class="block block-rounded block-link-pop bg-xwork" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                <div class="item">
                        <i class="fa fa-2x fa fa-inbox text-white"></i>
                    </div>
                <div class="ml-3 text-right">
                <p class="text-white mb-0" style="font-size: 2.25rem;">
                {{$amount_7}}
                        </p>
                        <p class="text-white mb-0">
                        ตรวจสอบไม่ผ่าน (เรื่อง)
                        </p>

                    </div>

                </div>
            </a>
        </div>
        <div class="col-md-4 col-xl-3">
            <a class="block block-rounded block-link-pop bg-xeco" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                <div class="item">
                        <i class="fa fa-2x fa fa-hand-point-up text-white"></i>
                    </div>
                <div class="ml-3 text-right">
                <p class="text-white mb-0" style="font-size: 2.25rem;">
                {{$amount_8}}
                        </p>
                        <p class="text-white mb-0">
                        ไม่อนุมัติ (เรื่อง)
                        </p>

                    </div>

                </div>
            </a>
        </div>


</div>



<div style="width: 95%;">
           <div class="block block-content">
            <div id="columnchart_material" style="font-family: 'Kanit', sans-serif;width: 100%; height: 500px;"></div>
            </div>
            </div>

</div>

@endsection

@section('footer')
<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('google/Charts.js') }}"></script>


<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['ประเภทเงิน','จำนวนรายการ'],
          ['งบประมาณ', <?php echo  $budget_1;?>],
          ['เงิน UC', <?php echo  $budget_2;?>],
          ['เงินบำรุง',<?php echo  $budget_3;?>],
          ['เงินบริจาค', <?php echo  $budget_4;?>],
          ['เงินอื่นๆ', <?php echo  $budget_5;?>],
          ['เงินค่าบริการทางการแพทย์',<?php echo  $budget_6;?>]

        ]);

        

        var options = {
            fontName: 'Kanit',
          chart: {
            title: 'จำนวนรายการแบ่งตามประเภทเงิน',
          
          
          }

       
        
        };

     
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>


@endsection
