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
                    <div class="content">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">{{ $inforpersonuser -> HR_PREFIX_NAME }}   {{ $inforpersonuser -> HR_FNAME }}  {{ $inforpersonuser -> HR_LNAME }}</h1>
                            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <div class="row">
                                        <div>
                                                <a href="{{ url('person_work/personworkjobdescription/'.$inforpersonuserid -> ID)}}" class="btn" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">
                                                  
                                                   Job description
                                                </a>
                                            </div>
                                        <div>&nbsp;</div>
                                <div>
                                        <a href="{{ url('person_work/personworkcorecompetency_detail/'.$inforpersonuserid -> ID)}}" class="btn btn-primary" >Core competency</a>
                                </div>
                                        <div>&nbsp;</div>
                               
                                <div>
                                        <a href="{{ url('person_work/personworkfuntionalcompetency_detail/'.$inforpersonuserid -> ID)}}" class="btn" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">Funtional competency
                            
                                </a>
                                </div>

                                <!--<div>&nbsp;</div>
                               
                               <div>
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
                            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ตั้งระดับ Core competency</B></h3>
                           
                        </div>
                        <div class="block-content block-content-full">
     
                        <br>
            <form  method="post" action="{{route('abi.personworkcorecompetency_setupupdate')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
           <div class="col-sm-1" >
           ปีงบประมาณ
           </div>
            <div class="col-sm-2">
            <select style=" font-family: 'Kanit', sans-serif;" name="COR_COM_SET_YEAR" id="COR_COM_SET_YEAR"   class="form-control">        
                                        <option value="2563">2563</option>
                                        <option value="2562">2562</option>
           </select>
           </div>      

        <div class="col-sm-12">

        <div class="row push">
        <div class="col-lg-1" style="text-align: left">
            <label >                           
                       
            </label>
            </div> 
                  
                    <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                        <thead style="background-color: #FFEBCD;">
                            <tr height="40">
                                <td style="text-align: center;">สมรรถนะ</td>
                                <td style="text-align: center;">ระดับสูงสุด</td>
                        
                                <td style="text-align: center;" width="12%">
                                    <a  class="btn btn-success fa fa-plus-square addRow" style="color:#FFFFFF;"></a>
                                </td>
                            </tr>
                        </thead>
                        <tbody class="tbody1">
                            <tr height="20">
                        
                            
                                <td>
                                
                                
                                    <select style=" font-family: 'Kanit', sans-serif;" name="COR_COM_SET_LEVEL_ID[]" id="COR_COM_SET_LEVEL_ID[]"   class="form-control">
                                        <option value="0">--เลือกทักษะ--</option>
                                        @foreach ($infocoms as $infocom)
                                        <option value="{{$infocom->COR_COM_ID}}">{{$infocom->COR_COM_NAME}}</option>
                                        @endforeach 
                                    </select>    

                                </td>
                                <td>
                                   
                                    
                                    <select style=" font-family: 'Kanit', sans-serif;" name="COR_COM_SET_LEVEL_SUB_MAX[]" id="COR_COM_SET_LEVEL_SUB_MAX[]"   class="form-control">
                                        <option value="0">--เลือกระดับสูงสุด--</option>
                                        <option value="1">ระดับ 1</option>
                                        <option value="2">ระดับ 2</option>
                                        <option value="3">ระดับ 3</option>
                                        <option value="4">ระดับ 4</option>
                                    </select>      
                                </td>
                            
                                <td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>
                            </tr>
                        </tbody>
                    </table>
                    </div> 
                    </div>
        </div>
 
      
    
       <br>
 
       

       <input type="hidden" name="COR_COM_SET_PERSON_ID" id="COR_COM_SET_PERSON_ID" class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;" value="{{$inforpersonuserid -> ID}}" >

        <div class="modal-footer">
        <div align="right">
        <button type="submit"  class="btn btn-hero-sm btn-hero-info" >บันทึก</button>
        <a href="{{ url('person_work/personworkcorecompetency_detail/'.$inforpersonuserid -> ID)}}" class="btn btn-hero-sm btn-hero-danger" onclick="return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')" >ยกเลิก</a>
        </div>

       
        </div>
        </form>  
                    

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

$('.addRow').on('click',function(){
        addRow();
    });

    function addRow(){
    var count = $('.tbody1').children('tr').length;
        var tr = '<tr height="20">'+
                        '<td>'+
                            '<select style=" font-family: \'Kanit\', sans-serif;" name="COR_COM_SET_LEVEL_ID[]" id="COR_COM_SET_LEVEL_ID[]"   class="form-control">'+
                                '<option value="0">--เลือกทักษะ--</option>'+
                                '@foreach ($infocoms as $infocom)'+
                                '<option value="{{$infocom->COR_COM_ID}}">{{$infocom->COR_COM_NAME}}</option>'+
                                '@endforeach'+ 
                            '</select>'+    
                        '</td>'+
                        '<td>'+
                            '<select style=" font-family: \'Kanit\', sans-serif;" name="COR_COM_SET_LEVEL_SUB_MAX[]" id="COR_COM_SET_LEVEL_SUB_MAX[]"   class="form-control">'+
                               '<option value="0">--เลือกระดับสูงสุด--</option>'+
                                '<option value="1">ระดับ 1</option>'+
                                '<option value="2">ระดับ 2</option>'+
                                '<option value="3">ระดับ 3</option>'+
                                '<option value="4">ระดับ 4</option>'+
                            '</select>'+      
                        '</td>'+
                    
                        '<td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>'+
                    '</tr>';
    $('.tbody1').append(tr);
    };

    $('.tbody1').on('click','.remove', function(){
        $(this).parent().parent().remove();
});
</script>

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
