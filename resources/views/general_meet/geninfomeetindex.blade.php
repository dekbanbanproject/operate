@extends('layouts.backend')


    <link rel="stylesheet" href="{{ asset('fullcalendar/js/fullcalendar-2.1.1/fullcalendar.min.css') }}">


@section('content')

<style>

#calendar{
		max-width: 95%;
		margin: 0 auto;
    font-size:15px;
	}

    body {
      font-family: 'Kanit', sans-serif;
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



use App\Http\Controllers\MeetingController;
$checkver = MeetingController::checkver($user_id);
$countver = MeetingController::countver($user_id);

$m_budget = date("m");
if($m_budget>9){
  $yearbudget = date("Y")+544;
}else{
  $yearbudget = date("Y")+543;
}


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
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                            <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.3rem;font-weight:normal;">{{ $inforpersonuser -> HR_PREFIX_NAME }}   {{ $inforpersonuser -> HR_FNAME }}  {{ $inforpersonuser -> HR_LNAME }}</h1>
                            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                <div class="row">
                                <div >

                                    <a href="{{ url('general_meet/genmeetindex/'.$inforpersonuserid -> ID)}}" class="btn btn-warning loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;">Dashboard</a>

                                </div>
                                    <div>&nbsp;</div>

                                <div >
                                <a href="{{ url('general_meet/genmeetroom/'.$inforpersonuserid -> ID)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">จองห้องประชุม</a>
                                </div>
                                <div>&nbsp;</div>
                                <div>
                                <a href="{{ url('general_meet/genmeetroominfo/'.$inforpersonuserid -> ID)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">ข้อมูลการจองห้อง</a>
                                </div>
                                <div>&nbsp;</div>
                                <div>
                                @if($checkver!=0)
                                <a href="{{ url('general_meet/genmeetroomver/'.$inforpersonuserid -> ID)}}" class="btn loadscreen" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-size: 1.0rem;font-weight:normal;background-color:#DCDCDC;color:#696969;">ตรวจสอบ
                                @if($countver!=0)
                                    <span class="badge badge-light" >{{$countver}}</span>
                                @endif

                                </a>
                                </div>
                                <div>&nbsp;</div>
                                @endif
                                </div>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <center>
                <div class="content">

                    <div class="block block-rounded block-bordered">
                        <br>

                    <div id='calendar' style="width:100%; display: inline-block;"></div>

                    <br>
                    <br>
                    </div>

                            <!-- END  -->
                </div>
                <?php $count=0; ?>
                @foreach ($infoservices as $infoservice)

                <?php
                    if($infoservice->STATUS == 'SUCCESS'){
                        $color_code = '#ADD8E6';
                    }elseif($infoservice->STATUS == 'LASTAPP'){
                        $color_code = '#A3DCA6';
                    }else{
                        $color_code = '#F1C54D';
                    }
                   $data[] = array(
                    'id'   => $infoservice->ID,
                    'title'   => $infoservice->SERVICE_STORY,
                    'room'   => $infoservice->ROOM_NAME,
                    'start'   => $infoservice->DATE_BEGIN.'T'.$infoservice->TIME_BEGIN,
                    'end'   => $infoservice->DATE_END.'T'.$infoservice->TIME_END,
                    'person'   => $infoservice->PERSON_REQUEST_NAME,
                    'color'=> $color_code
                   );
                   ?>
                   <?php $count++; ?>
                  @endforeach

                  <div class="row">
                    <div class="col-md-10" align="right">
                    <p class="fa fa-circle" style="color:#A3DCA6;"></p> อนุมัติ 
                    <p class="fa fa-circle" style="color:#ADD8E6;"></p> จัดสรร 
                    <p class="fa fa-circle" style="color:#F1C54D;"></p> ร้องขอ 
                    </div>
                    </div>

                  <div class="detail"></div>


@endsection

@section('footer')




<script type="text/javascript" src="{{ asset('fullcalendar/js/fullcalendar-2.1.1/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('fullcalendar/js/fullcalendar-2.1.1/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('fullcalendar/js/fullcalendar-2.1.1/lang/th.js') }}"></script>

<script type="text/javascript">
$(function(){

$('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',  //  prevYear nextYea
        center: 'title',
        right: 'month,agendaWeek,agendaDay',
    },
    buttonIcons:{
        prev: 'left-single-arrow',
        next: 'right-single-arrow',
        prevYear: 'left-double-arrow',
        nextYear: 'right-double-arrow'
    },

    viewRender: function(view, element) {
    setTimeout(function(){
        var strDate = $.trim($(".fc-center").find("h2").text());
        var arrDate = strDate.split(" ");
        var lengthArr = arrDate.length;
        var newstrDate = "";
        for(var i=0;i<lengthArr;i++){
            if(lengthArr-1==i || parseInt(arrDate[i])>1000){
                var yearBuddha=parseInt(arrDate[i])+543;
                newstrDate+=yearBuddha;
            }else{
                newstrDate+=arrDate[i]+" ";
            }
        }
        $(".fc-center").find("h2").text(newstrDate);
    },5);
},
//        theme:false,
//        themeButtonIcons:{
//            prev: 'circle-triangle-w',
//            next: 'circle-triangle-e',
//            prevYear: 'seek-prev',
//            nextYear: 'seek-next'
//        },
//        firstDay:1,
//        isRTL:false,
//        weekends:true,
//        weekNumbers:false,
//        weekNumberCalculation:'local',
//          height:'auto',
//          width:'500px',
//        fixedWeekCount:false,

    events:<?php
    if($count == 0 ){
        echo '[]';
    }else{
        echo json_encode($data);

    }


    ?>,

    eventLimit:true,
//        hiddenDays: [ 2, 4 ],
    lang: 'th',

eventClick: function(calEvent, jsEvent, view) {

    $.ajax({
                   url:"{{route('meeting.deatailcalendar')}}",
                   method:"GET",
                   data:{id:calEvent.id},
                   success:function(result){
                      $('.detail').html(result);
                      $('#detail_meet').modal();
                     // alert("Hello! I am an alert box!!");
                   }

           })



}




});


});



</script>



@endsection
