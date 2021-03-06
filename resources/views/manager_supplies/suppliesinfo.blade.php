@extends('layouts.supplies')
   
    {{-- <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" /> --}}

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

    
      .form-control {
    font-size: 13px;
                  }   


                  table {
            border-collapse: collapse;
            }

        table, td, th {
            border: 1px solid black;
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


use App\Http\Controllers\ManagersuppliesController;
?>



     <div class="block" style="width: 95%;margin:auto;">

                             <!-- Dynamic Table Simple -->
                             <div class="block block-rounded block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>
                            @if( $typedetail == 'parcel')
                             ?????????????????????????????????
                            @elseif( $typedetail == 'article')
                            ??????????????????????????????????????????
                            @elseif( $typedetail == 'service')
                            ????????????????????????????????????
                            @else
                            ?????????????????????????????????????????????????????????
                            @endif
                            
                            
                            </B></h3>
                            <div align="right">

        <a href="{{ url('manager_supplies/suppliesinfo_add/'.$typedetail)  }}"   class="btn btn-hero-sm btn-hero-primary js-click-ripple-enabled"><i class="fas fa-plus"></i>&nbsp;?????????????????????????????????</a>
        </div>
                        </div>
                        <div class="block-content block-content-full">
                        <form action="{{ route('msupplies.suppliesinfo',['typedetail' => $typedetail,]) }}" method="post">
                        @csrf

             <div class="row" >

                    <div class="col-md-1">
                    &nbsp;?????????????????? : &nbsp;
                    </div>

                    <div class="col-md-2">
                    <span>
                    <select name="SEND_TYPEKIND" id="SEND_TYPEKIND" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
                    @if( $typedetail == 'parcel')
                    <option value="">--?????????????????????--</option>
                    @endif
                    @foreach ($suppliestypekinds as $suppliestypekind)
                        @if($suppliestypekind->SUP_TYPE_KIND_ID == $typekind_check)
                        <option value="{{ $suppliestypekind->SUP_TYPE_KIND_ID  }}" selected>{{ $suppliestypekind->SUP_TYPE_KIND_NAME}}</option>
                        @else
                        <option value="{{ $suppliestypekind->SUP_TYPE_KIND_ID  }}">{{ $suppliestypekind->SUP_TYPE_KIND_NAME}}</option>
                        @endif
                    
                                                                                            
                    @endforeach 
                

                    </select> 
                    </span>
                    </div> 

                    <div class="col-md-1">
                    &nbsp;???????????? : &nbsp;
                    </div>

                    <div class="col-md-2">
                    <span>
                    <select name="SEND_TYPE" id="SEND_TYPE" class="form-control input-lg" style=" font-family: 'Kanit', sans-serif;">
                    <option value="">--?????????????????????--</option>
                    @foreach ($suppliestypes as $suppliestype)
                        @if($suppliestype->SUP_TYPE_ID == $type_check)
                        <option value="{{ $suppliestype->SUP_TYPE_ID  }}" selected>{{ $suppliestype->SUP_TYPE_NAME}}</option>
                        @else
                        <option value="{{ $suppliestype->SUP_TYPE_ID  }}">{{ $suppliestype->SUP_TYPE_NAME}}</option>
                        @endif
                                                                        
                    @endforeach 

                    </select>
                    </span>
                    </div> 
                    <div class="col-md-1">
                    &nbsp;??????????????? : &nbsp;
                    </div>
                  <div class="col-md-2" >
               <span>
                 
                 <input type="search"  name="search" class="form-control" style="font-family: 'Kanit', sans-serif;font-weight:normal;" value="{{$search}}">
                </span>
                 </div>
               
                 <input type="hidden" type="typedetail"  name="typedetail" class="form-control"  value="{{$typedetail}}">
                 <div class="col-md-30">
                &nbsp;
                </div> 
                 <div class="col-md-2">
                 <span>
                 <button type="submit" class="btn btn-hero-sm btn-hero-primary js-click-ripple-enabled"><i class="fas fa-search"></i>&nbsp;???????????????</button>
                 </span> 
                 </div>
                </div>
              
                
             </form>
             <div class="table-responsive"> 
                            <!-- DataTables init on table by adding .js-dataTable-simple class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                            <table class="table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                                <thead style="background-color: #FFEBCD;">
                                    <tr height="40">
                                        <th class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="5%">???????????????</th>
                                       
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">????????????</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="10%">????????????????????????</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">??????????????? ????????????????????????</th>    
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="20%">?????????????????????????????????</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >???????????????????????????</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" width="15%">???????????????????????????</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >?????????????????????</th>
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;" >???????????????</th>
                                        <th  class="text-font" width="5%" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;">?????????????????????</th> 
                                        
                                        <th  class="text-font" style="border-color:#F0FFFF;text-align: center;border: 1px solid black;"  width="12%">??????????????????</th>   
                                        
                                       
                                       
                                        
                                    </tr >
                                </thead>
                                <tbody>
                                

                                <?php $number = 0; ?>
                                @foreach ($infosuppliess as $infosupplies)
                                <?php $number++; ?>

                                    <tr height="20">
                                        <td class="text-font" align="center">{{$number}}</td>
                                        <td class="text-font" align="center">{{ $infosupplies->SUP_FSN_NUM }}</td>
                                        <td class="text-font" align="center">{{ $infosupplies->TPU_NUMBER }}</td>
                                        <td class="text-font text-pedding" >{{ $infosupplies->SUP_NAME }}</td>
                                        <td class="text-font text-pedding">{{ $infosupplies->SUP_TYPE_KIND_NAME }}</td>
                                        <td class="text-font text-pedding">{{ $infosupplies->SUP_TYPE_NAME }}</td>
                                        <td class="text-font text-pedding">{{ $infosupplies->SUP_PROP }}</td>
                                        <td class="text-font text-pedding">{{$infosupplies->CONTINUE_PRICE_NAME}}</td>
                                        <td class="text-font text-pedding">{{ManagersuppliesController::unitname($infosupplies ->ID)}}</td>
                                        <td align="center" width="5%">
                                            <div class="custom-control custom-switch custom-control-lg ">
                                             @if($infosupplies->ACTIVE == 'True')
                                                 <input type="checkbox" class="custom-control-input" id="{{ $infosupplies-> ID }}" name="{{ $infosupplies-> ID }}" onchange="switchactive({{ $infosupplies-> ID }});" checked>
                                             @else
                                                <input type="checkbox" class="custom-control-input" id="{{ $infosupplies-> ID }}" name="{{ $infosupplies-> ID }}" onchange="switchactive({{ $infosupplies-> ID }});">
                                             @endif
                                                <label class="custom-control-label" for="{{ $infosupplies-> ID }}"></label>
                                            </div>

                                        </td>
                                     
                                        <td align="center">
                                        <div class="dropdown">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle" id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;">
                                                    ????????????????????????
                                                </button>
                                                <div class="dropdown-menu" style="width:10px">
                                                <a class="dropdown-item"  href="{{ url('manager_supplies/suppliesinfo/edit/'.$typedetail.'/'.$infosupplies->ID ) }}"  style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;"><i class="fas fa-edit text-warning mr-2"></i>??????????????????????????????/???????????????</a> 
                                               
                                                <a class="dropdown-item"  href="#detail_historybuy"  data-toggle="modal"  style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;" onclick="historybuy({{$infosupplies->ID}});"><i class="fas fa-info-circle text-info mr-2"></i>??????????????????????????????????????????</a>
                                                @if( $typedetail == 'article')
                                                {{-- <a class="dropdown-item"  href="{{ url('manager_supplies/suppliesinfoinassetbarcodepdf/'.$infosupplies->ID ) }}"  style="font-family: 'Kanit', sans-serif; font-size: 15px;font-weight:normal;">??????????????? Barcode</a> --}}
                                                <a class="dropdown-item"  href="{{ url('manager_supplies/suppliesinfo/suppliesinfoinasset/'.$infosupplies->ID ) }}"  style="font-family: 'Kanit', sans-serif; font-size: 13px;font-weight:normal;"><i class="fas fa-folder-plus text-success mr-2"></i>???????????????????????????????????????????????????</a>
                                                
                                                @endif           
                                             
                                                
                                                <!--<a class="dropdown-item" href="{{ url('manager_supplies/suppliesinfo/destroysuppliesinfo/'.$typedetail.'/'.$infosupplies->ID ) }}" onclick="return confirm('???????????????????????????????????????????????????????????? {{ $infosupplies->SUP_FSN_NUM  }} :: {{$infosupplies->SUP_NAME }} ?')" style="font-family: 'Kanit', sans-serif; font-size: 15px;font-weight:normal;">????????????????????????</a>-->
                                                    
                                               
                                                   
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

                
         


<!--------------------------------------->

<div id="detail_historybuy" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
    <div class="modal-header">
    
    <div class="row">
    <div><h3  style="font-family: 'Kanit', sans-serif;">&nbsp;&nbsp;&nbsp;&nbsp;????????????????????????????????????????????????????????????????????????&nbsp;&nbsp;</h3></div>
    </div>
        </div>
        <div class="modal-body" >
            

                    
         <div id="historybuy"></div>
        
            
        </div>
        <div class="modal-footer">
        <div align="right">
    
        <button type="button" class="btn btn-hero-sm btn-hero-secondary" data-dismiss="modal" ><i class="fas fa-window-close mr-2"></i>?????????????????????????????????</button>
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

function historybuy(id){


$.ajax({
           url:"{{route('msupplies.historybuy')}}",
           method:"GET",
           data:{id:id},
           success:function(result){
               $('#historybuy').html(result);
             
           }
            
   })
    
}


   $(document).ready(function () {
            
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: true,
                language: 'th',             //????????????????????? label ????????????????????? ?????????????????? ????????????????????? ?????????????????????   (????????????????????????????????? bootstrap-datepicker.th.min.js ?????????????????????)
                thaiyear: true,
                autoclose: true                         //Set ?????????????????? ???.???.
            }).datepicker("setDate", 0);  //?????????????????????????????????????????????????????????
    });


    function chkmunny(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9' )&& (vchar != '.')) return false;
ele.onKeyPress=vchar;
}
    


  
</script>


<script>
 
 function switchactive(id){
      // alert(budget);
      var checkBox=document.getElementById(id);
      var onoff;

      if (checkBox.checked == true){
        onoff = "True";
  } else {
        onoff = "False";
  }
 //alert(onoff);

 var _token=$('input[name="_token"]').val();
      $.ajax({
              url:"{{route('msupplies.switchactivesup')}}",
              method:"GET",
              data:{onoff:onoff,id:id,_token:_token}
      })
      }        
  
</script>

@endsection