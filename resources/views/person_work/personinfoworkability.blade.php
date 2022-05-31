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
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">{{ $inforperson -> HR_PREFIX_NAME }}   {{ $inforperson -> HR_FNAME }}  {{ $inforperson -> HR_LNAME }}</h1>
                            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <div class="row">
                                <div>
                                                <a href="{{ url('person_work/carcalendarhealth/'.$inforpersonid -> ID)}}"  class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">ปฎิทิน</a>
                                        </div>
                                        <div>&nbsp;</div>
                                    
                                        <div>
                                                <a href="{{ url('person_work/personworkability/'.$inforpersonid -> ID)}}"  class="btn btn-primary loadscreen" >ทดสอบสมรรถภาพ</a>
                                        </div>
                                        <div>&nbsp;</div>
                                        <div>
                                        <a href="{{ url('person_work/personworkscreening/checkup/'.$inforpersonid -> ID)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">ตรวจสุขภาพประจําปี</a>
                                        </div>
                                        <div>&nbsp;</div>
                               
                             
                              
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="content">
                <div class="block block-rounded block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลการตรวจสมรรถภาพประจำปี</B></h3>
                          
                        </div>
                        <div class="block-content block-content-full">

                    
                        <div class="table-responsive">      
                
                        <table class="gwt-table table-striped table-vcenter" width="100%">
                  <thead style="background-color: #FFEBCD;">
                  
                   <tr height="40">
                  
                   <th class="text-font"  style="border-color:#F0FFFF; text-align: center;" width="5%">ลำดับ</th>
                        <th class="text-font"  style="border-color:#F0FFFF; text-align: center;">ข้อมูลการตรวจสมรรถภาพประจำปี</th>
    
                        <th class="text-font"  style="border-color:#F0FFFF; text-align: center;" width="8%">รายละเอียด</th>
        
        
                    </tr>
                   </tr>
                   </thead>
                   <tbody>

                   <?php $number = 0; ?>
                      @foreach ($infocapas as $infocapa)
                      <?php $number++;  ?>
                 
                   <tr height="20">
                                <td class="text-font" align="center">{{$number}}</td>
                                <td class="text-font text-pedding" >{{$infocapa->CAPACITY_YEAR}}</td>
                             
                             
                                <td align="center">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;">
                                                    ทำรายการ
                                                </button>
                                                <div class="dropdown-menu" style="width:10px"> 
                                                <a class="dropdown-item"  href="{{ url('person_work/personworkability/detail/'.$infocapa->CAPACITY_PERSON_ID.'/'.$infocapa->CAPACITY_ID)  }}" style="font-family: 'Kanit', sans-serif; font-size: 15px;font-weight:normal;" >รายละเอียด</a>   

                                                </div>
                                            </div>
                                </td>     
                        </tr>
                        @endforeach 
                  
                  

                   </tbody>
                  </table>

             


                  
      
                      

@endsection

@section('footer')

  



@endsection