@extends('layouts.backend_admin')

@section('content')
<style>

.table-cont{
  /**make table can scroll**/
  max-height: 300px;
  overflow: auto;
  /** add some style**/
  /*padding: 2px;*/
  background: #ddd;
  margin: 20px 10px;
  box-shadow: 0 0 1px 3px #ddd;
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

  
function Removeformatetime($strtime)
{
  $H = substr($strtime,0,5);
  return $H;
  }

?>

 

    <!-- Page Content -->
    <br>
    <center>    
<div style="max-width:90%;">

@if($id_user == '0')

<div class="row" > 
                        

          
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-users text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">บุคลากร</div>
                         </div>
                     </div>
                 </a>
             </div>
            
       

           
             <div class="col-6 col-md-4 col-xl-2">
             <a class="block block-link-pop text-center" >
                     <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                         <div>
                         <i class="fa fa-3x fa-history text-secondary"></i>
                             <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบลงเวลา</div>
                         </div>
                     </div>
                 </a>
             </div>




@else
 <div class="row" > 
                    <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_person/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                    <i class="fa fa-3x fa-users text-info"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">บุคลากร</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6 col-md-4 col-xl-2">
                        <a class="block block-link-pop text-center" href="{{ url('manager_personcheck/dashboard')}}" target="_blank">
                                <div class="block-content block-content-full aspect-ratio-4-3 d-flex justify-content-center align-items-center">
                                    <div>
                                        <i class="fa fa-3x fa-history text-dark"></i>
                                        <div class="font-w600 mt-2 text-dark" style="font-size: 15px;">ระบบลงเวลา</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                      
                  </div>

@endif 

<br>

    <script src="{{ asset('google/Charts.js') }}"></script>

    <script>
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 5000); // Change image every 2 seconds
}
</script>
<script>

// Code goes here

window.onload = function(){
  var tableCont = document.querySelector('#table-cont')
  var tableCont2 = document.querySelector('#table-cont2')
  /**
   * scroll handle
   * @param {event} e -- scroll event
   */
  function scrollHandle (e){
    var scrollTop = this.scrollTop;
    this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
  }
  
  tableCont.addEventListener('scroll',scrollHandle)
  tableCont2.addEventListener('scroll',scrollHandle)
}


</script>

@endsection
