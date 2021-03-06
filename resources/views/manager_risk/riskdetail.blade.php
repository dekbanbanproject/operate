@extends('layouts.risk')   
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
      font-size: 10px;
      font-size: 1.0rem;
      }

      label{
            font-family: 'Kanit', sans-serif;
            font-size: 10px;
            font-size: 1.0rem;
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
    font-size: 13px;
                  }   
      
      
      .form-control{
    font-size: 13px;
                  } 
                  table {
  margin-left: auto;
  margin-right: auto;
  width: 80%;
}

table, th, td {
  border: 1px solid black;
}

td {
  padding: 0.5em;
  /* font-family: monospace; */
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
?>
         

<center>    
    <div class="block mt-5" style="width: 95%;">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <div align="left">
                    <h2 class="block-title" style="font-family: 'Kanit', sans-serif;">????????????????????????????????????????????????</h2> 
                </div>
                 
                <div align="right">
                    <a href="{{ url('manager_risk/detail_add')}}"  class="btn btn-hero-sm btn-hero-info foo15" ><i class="fas fa-plus"></i> ???????????????????????????????????????????????????????????????</a>
                    </div>
                </div>
                <div class="block-content block-content-full">
            <form action="{{route('mrisk.detail')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-0.5">
                        &nbsp;&nbsp; &nbsp;&nbsp; ???????????? &nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="col-sm-1.5">
                        <span>
                                <select name="BUDGET_YEAR" id="BUDGET_YEAR" class="form-control input-lg budget" style=" font-family: 'Kanit', sans-serif;">
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

            <div class="col-sm-4 date_budget">
            <div class="row">
                        <div class="col-sm">
                        ??????????????????
                        </div>
                    <div class="col-md-4">
             
                    <input  name = "DATE_BIGIN"  id="DATE_BIGIN"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  value="{{ formate($displaydate_bigen) }}" readonly>
                    
                    </div>
                    <div class="col-sm">
                        ????????? 
                        </div>
                    <div class="col-md-4">
           
                    <input  name = "DATE_END"  id="DATE_END"  class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"  value="{{ formate($displaydate_end) }}" readonly>
                  
                    </div>
                    </div>

                </div>

                <div class="col-sm-1">
                   ???????????????
                    </div>
                <div class="col-sm-2">
                      
                        <select name="STATUS" id="STATUS" class="form-control input-sm fo13" >
                            <option value="">--???????????????--</option>
                            @foreach($statuss as $status)
                                        @if( $status-> RISK_STATUS_NAME == $status_check)
                                        <option value="{{ $status-> RISK_STATUS_NAME}}" selected>{{ $status-> RISK_STATUS_NAME_TH}} </option>
                                        @else
                                        <option value="{{ $status-> RISK_STATUS_NAME}}">{{ $status-> RISK_STATUS_NAME_TH}} </option>
                                        @endif
                                    @endforeach
                            </select>
                </div>



<div class="col-sm-0.5">
&nbsp;??????????????? &nbsp;
</div>

<div class="col-sm-2">
<span>

<input type="search"  name="search" class="form-control" style="font-family: 'Kanit', sans-serif;font-weight:normal;" value="{{$search}}">

</span>
</div>

<div class="col-sm-30">
&nbsp;
</div> 
<div class="col-sm-1.5">
<span>
<button type="submit" class="btn btn-hero-sm btn-hero-info foo15" ><i class="fas fa-search mr-2"></i> ???????????????</button>
</span> 
</div>


              
 </div>  
             </form>
             <div class="table-responsive"> 
                <table class="gwt-table table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                    <thead style="background-color: #e3ccf8;">
                        <tr height="40">
                            <th class="text-font" style="text-align: center;" width="4">???????????????</th>
                            <th class="text-font" style="text-align: center;" width="7%">????????????</th>
                            <th class="text-font" style="text-align: center;" width="6%">???????????????</th>
                            <th class="text-font" style="text-align: center;" width="8%">??????????????????????????????</th>
                            <th class="text-font" style="text-align: center;" >??????????????????</th>
                            {{-- ??????????????????????????????????????????????????? --}}
                            <th class="text-font" style="text-align: center;" width="15%">???????????????/????????????????????????????????????</th>
                            {{-- ?????????????????????????????????????????????????????? --}}
                            <th class="text-font" style="text-align: center;" width="13%">???????????????/????????????????????????????????????</th>
                            <th class="text-font" style="text-align: center;" width="10%">??????????????????????????????</th>
                            <th class="text-font" style="text-align: center;" width="5%" >??????????????????</th> 
                        </tr >
                    </thead>
                    <tbody>
                    <?php $number = 0; ?>
                        @foreach ($rigreps as $rigrep)
                            <?php $number++; 
                                $status =  $rigrep -> RISKREP_STATUS;                                      
                                        
                                if( $status === 'CONFIRM'){
                                        $statuscol =  "badge badge-primary";
                                    }else if($status === 'REPORT'){
                                    $statuscol =  "badge badge-warning";
                                    }else if($status === 'ACCEPT'){
                                    $statuscol =  "badge badge-danger";
                                    }else if($status === 'CHECK'){
                                        $statuscol =  "badge badge-info";
                                    }else if($status === 'REPEAT'){
                                        $statuscol =  "badge badge-success";
                                    }else if($status === 'SUCCESS'){
                                        $statuscol =  "badge badge-info";
                                    }else{
                                        $statuscol =  "badge badge-secondary";
                                    } 
                                    
                                    $level = $rigrep->RISKREP_LEVEL;

                                        if ($level === '1') {
                                        $statuslevel = 'badge badge-success';
                                        } elseif ($level === '2') {
                                        $statuslevel = 'badge badge-success';
                                        } elseif ($level === '3') {
                                        $statuslevel = 'badge badge-info';
                                        } elseif ($level === '4') {
                                        $statuslevel = 'badge badge-info';
                                        } elseif ($level === '5') {
                                        $statuslevel = 'badge badge-warning';
                                        } elseif ($level === '6') {
                                        $statuslevel = 'badge badge-warning';                                  
                                        } elseif ($level === '7') {
                                        $statuslevel = 'badge badge-danger';
                                        } elseif ($level === '8') {
                                        $statuslevel = 'badge badge-danger';
                                        } elseif ($level === '9') {
                                        $statuslevel = 'badge badge-danger';
                                        } elseif ($level === '10') {
                                        $statuslevel = 'badge badge-danger';
                                        } elseif ($level === '11') {
                                        $statuslevel = 'badge badge-danger';
                                        } elseif ($level === '12') {
                                        $statuslevel = 'badge badge-danger';
                                        } elseif ($level === '13') {
                                        $statuslevel = 'badge badge-danger';
                                        } elseif ($level === '14') {
                                        $statuslevel = 'badge badge-danger';
                                        } else {
                                        $statuslevel = '';
                                        }
                            ?>
                        <tr height="20" >
                            <td class="text-font" style="vertical-align: text-top;" width="4">{{ $number}}</td>
                            <td class="text-font" style="vertical-align: text-top;" width="7%">{{$rigrep->RISKREP_NO}}</td>
                            <td class="text-font" style="vertical-align: text-top;" width="6%">&nbsp;&nbsp; <span class="{{$statuscol}}"> &nbsp;&nbsp;{{ $rigrep -> RISK_STATUS_NAME_TH }} &nbsp;&nbsp;</span></td>
                            <td class="text-font" style="text-align: center;"> <span class="{{ $statuslevel }}" width="8%"><label for="" style="font-family:'Kanit',sans-serif;font-size:20px;font-weight:normal;"><b>{{ $rigrep->RISK_REP_LEVEL_NAME }}</b></label></span></td>
                            {{-- <td class="text-font" style="text-align: center;" width="10%"> 
                                @if ($rigrep->RISKREP_LEVEL == 1)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelA.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 2)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelB.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 3)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelC.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 4)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelD.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 5)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelE.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 6)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelF.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 7)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelG.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 8)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelH.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 9)
                                <img class="media-object rounded-circle" src="{{ asset('image/levelI.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 10)
                                <img class="media-object rounded-circle" src="{{ asset('image/level1.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 11)
                                <img class="media-object rounded-circle" src="{{ asset('image/level2.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 12)
                                <img class="media-object rounded-circle" src="{{ asset('image/level3.png') }}" alt="Avatar"  width="40" height="40">
                                @elseif ($rigrep->RISKREP_LEVEL == 13)
                                <img class="media-object rounded-circle" src="{{ asset('image/level4.png') }}" alt="Avatar"  width="40" height="40">
                                @else
                                <img class="media-object rounded-circle" src="{{ asset('image/level5.png') }}" alt="Avatar"  width="40" height="40">
                                @endif
                               
                            
                            </td> --}}

                            <td class="text-font text-pedding" style="vertical-align: top;margin-top:5px">{{$rigrep->RISK_REPITEMS_CODE}} :: {{$rigrep->RISK_REPITEMS_NAME}}</td>                                   
                          
                            @if ($rigrep->RISKREP_TYPEDEP == '1')
                                <td class="text-font text-pedding " width="13%" style="vertical-align: baseline;">{{$rigrep->RISKREP_TYPEDEP_NAME}}</td>
                            @elseif ($rigrep->RISKREP_TYPEDEP == '2')  
                                 <td class="text-font text-pedding" width="13%" style="vertical-align: baseline;">{{$rigrep->RISKREP_TYPESUB_NAME}}</td>                            
                            @elseif ($rigrep->RISKREP_TYPEDEP == '3')  
                            <td class="text-font text-pedding" width="13%" style="vertical-align: top;">{{$rigrep->RISKREP_TYPESUBSUB_NAME}}</td>  
                            @else
                                <td class="text-font text-pedding" width="13%" style="vertical-align: top;">{{$rigrep->HR_TEAM_NAME}} :: {{$rigrep->HR_TEAM_DETAIL}}</td>
                            @endif
                            
                            <td class="text-font text-pedding" width="13%" style="vertical-align: top;">{{$rigrep->HR_DEPARTMENT_SUB_SUB_NAME}}</td>
                            <td class="text-font text-pedding" width="10%">
                               ????????????????????????????????? :: {{DateThai($rigrep->RISKREP_STARTDATE)}} <br>
                               ???????????????????????????????????? :: {{DateThai($rigrep->RISKREP_DATESAVE)}} <br>
                               ????????????????????????????????? :: {{DateThai($rigrep->RISKREP_DATENOTIFY)}} <br>
                               ?????????????????????????????? :: {{DateThai($rigrep->RISKREP_DATECONFIRM)}} <br>   
                            </td>                           
                            <td align="center" width="5%"  style="vertical-align: top;text-align: center;">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 12px;font-weight:normal;">
                                        ????????????????????????
                                    </button>
                                    <div class="dropdown-menu fo13" style="width:10px"> 
                                            <a class="dropdown-item" href="{{ url('manager_risk/detail_detail/'.$rigrep->RISKREP_ID) }}" style="font-family:'Kanit',sans-serif;font-size:13px;">??????????????????????????????</a> 
                                            
                                            {{-- @if ($rigrep -> RISKREP_STATUS == 'REPORT') --}}
                                            <a class="dropdown-item" href="{{ url('manager_risk/detail_edit/'.$rigrep->RISKREP_ID)}}">?????????????????????????????????</a>
                                            {{-- @endif                                           --}}
                                            {{-- @if ($rigrep -> RISKREP_STATUS == 'CHECK') --}}
                                            <a class="dropdown-item" href="{{ url('manager_risk/detail_check/'.$rigrep->RISKREP_ID)}}">?????????????????????</a>
                                            {{-- @endif  --}}

                                            <a class="dropdown-item" href="{{ url('manager_risk/detail_check_infer/'.$rigrep->RISKREP_ID.'/'.$id_user)}}">??????????????????????????????????????????????????????</a>
                                            <a class="dropdown-item" href="{{ url('manager_risk/detail_check_cancel/'.$rigrep->RISKREP_ID)}}">????????????????????????????????????</a>
                                            <a class="dropdown-item" href="{{ url('manager_risk/detail_edit/'.$rigrep->RISKREP_ID)}}">??????????????????????????????????????????????????????</a>
                                        </div>
                                    </div>
                            </td>                                    
                        </tr>
                        @endforeach     

                    </tbody>
                </table>
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

function detail(id){

$.ajax({
           url:"{{route('suplies.detailapp')}}",
          method:"GET",
           data:{id:id},
           success:function(result){
               $('#detail').html(result);
              //alert("Hello! I am an alert box!!");
           }
   })
}
datepick()
function datepick() {
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: true,
        language: 'th',             //????????????????????? label ????????????????????? ?????????????????? ????????????????????? ?????????????????????   (????????????????????????????????? bootstrap-datepicker.th.min.js ?????????????????????)
        thaiyear: true,
        autoclose: true                         //Set ?????????????????? ???.???.
    });  //?????????????????????????????????????????????????????????
}

$('.budget').change(function(){
 if($(this).val()!=''){
 var select=$(this).val();
 var _token=$('input[name="_token"]').val();
 $.ajax({
         url:"{{route('admin.selectbudget')}}",
         method:"GET",
         data:{select:select,_token:_token},
         success:function(result){
            $('.date_budget').html(result);
            datepick();
         }
 })
// console.log(select);
 }        
});

function chkmunny(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9' )&& (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
</script>

@endsection