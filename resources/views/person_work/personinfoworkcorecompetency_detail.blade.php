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
   padding-right:10px;
                    }

        .text-font {
    font-size: 13px;
                  }
      }

</style>
<style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 14px;

            }
            .form-control {
            font-family: 'Kanit', sans-serif;
            font-size: 13px;
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
  function Removeformatetime($strtime)
  {
  $H = substr($strtime,0,5);
  return $H;
  }
  date_default_timezone_set("Asia/Bangkok");
  $date = date('Y-m-d');
?>


                    <!-- Advanced Tables -->
                    <div class="bg-body-light">
                    <div class="content">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">{{ $inforpersonuser -> HR_PREFIX_NAME }}   {{ $inforpersonuser -> HR_FNAME }}  {{ $inforpersonuser -> HR_LNAME }}</h1>
                            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <div class="row">
                                        <div>
                                                <a href="{{ url('person_work/personworkjobdescription/'.$inforpersonuserid -> ID)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">
                                                  
                                                   Job description
                                                </a>
                                            </div>
                                        <div>&nbsp;</div>
                                <div>
                                        <a href="{{ url('person_work/personworkcorecompetency_detail/'.$inforpersonuserid -> ID)}}" class="btn btn-primary loadscreen" >Core competency</a>
                                </div>
                                        <div>&nbsp;</div>
                               
                                <div>
                                        <a href="{{ url('person_work/personworkfuntionalcompetency_detail/'.$inforpersonuserid -> ID)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">Funtional competency
                            
                                </a>
                                </div>

                                <div>&nbsp;</div>
                               
                               <!--<div>
                                       <a href="{{ url('person_work/personworkkpis/'.$inforpersonuserid -> ID)}}" class="btn" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">ข้อมูลตัวชี้วัด (KPI)
                           
                               </a>
                               </div>-->
                              
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="content">

                             <!-- Dynamic Table Simple -->
                             <div class="block block-rounded block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>Core competency</B></h3>
                            <a href="{{ url('person_work/personworkcorecompetency_setup/'.$inforpersonuserid -> ID)}}" class="btn btn-primary" >ตั้งระดับ</a>
                        </div>
                        <div class="block-content block-content-full">
     

     <div class="table-responsive"> 
<!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
<table class="gwt-table table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
 <thead style="background-color: #FFEBCD;">
     <tr height="40">
         <td  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"  width="5%">ลำดับ</td> 
         <td  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"  >ปีงบประมาณ</td>         
         <td  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"  >ครั้งที่</td>       
         <td  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"  >วันที่</td>
       <!--  <td  class="text-font" style="border-color:#F0FFFF;text-align: center;"  >คะแนน</td>
         <td  class="text-font" style="border-color:#F0FFFF;text-align: center;"  >ผู้ประเมิน</td>
         <td  class="text-font" style="border-color:#F0FFFF;text-align: center;"  >หมายเหตุ</td>-->
         

         <td  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="7%">คำสั่ง</td> 
     </tr >

 </thead>
 <tbody>
 <?php $number= 0; ?>
 @foreach ($corecompetencys as $corecompetency)
 <?php $number++; ?>

     <tr height="20">
             <td class="text-font" align="center">{{$number}}</td>
             <td class="text-font text-pedding" >{{$corecompetency->COR_RESULT_YEAR}}</td>
             <td class="text-font text-pedding" >{{$corecompetency->COR_RESULT_NO}}</td>
             <td class="text-font text-pedding" >{{DateThai($corecompetency->created_at)}}</td>
             <!--   <td class="text-font text-pedding" ></td>
             <td class="text-font text-pedding" ></td>
             <td class="text-font text-pedding" ></td>-->
           
          
             <td align="center">
                         <div class="dropdown">
                             <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;">
                                 ทำรายการ
                             </button>
                             <div class="dropdown-menu" style="width:10px"> 
                             <a class="dropdown-item" href="{{ url('person_work/personworkcorecompetency_detail_sub/'.$corecompetency->COR_RESULT_ID.'/'.$user_id )}}" style="font-family: 'Kanit', sans-serif; font-size: 15px;font-weight:normal;" >รายละเอียด</a>    
                          
                             </div>
                         </div>
             </td>     
     </tr>
     @endforeach         
 
  
 </tbody>
</table>
<br>
<br>
<br>
</div>
</div>
</div>    
</div>

     </div>





@endsection

@section('footer')

<script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
<script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8"></script>



 <!-- Page JS Plugins -->
<script src="{{ asset('asset/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('asset/js/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<!-- Page JS Code -->
<script src="{{ asset('asset/js/pages/be_comp_charts.min.js') }}"></script>
<script>jQuery(function(){ Dashmix.helpers(['easy-pie-chart', 'sparkline']); });</script>


 <!-- Page JS Plugins -->
 <script src="{{ asset('asset/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
 <script src="{{ asset('asset/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
<!-- Page JS Code -->
 <script src="{{ asset('asset/js/pages/be_tables_datatables.min.js') }}"></script>


<script>
   $(document).ready(function () {

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                thaiyear: true,
                autoclose: true                         //Set เป็นปี พ.ศ.
            });  //กำหนดเป็นวันปัจุบัน
    });


    function chkmunny(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9' )&& (vchar != '.')) return false;
ele.onKeyPress=vchar;
}


</script>



@endsection
