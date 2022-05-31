@extends('layouts.headorg')



@section('content')
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

  function RemovegetAge($birthday) {
    $then = strtotime($birthday);
    return(floor((time()-$then)/31556926));
}
?>

<style>
        body {
            font-family: 'Kanit', sans-serif;
           
            }

            p {
	
                word-wrap:break-word;
                }
                .text{
                    font-family: 'Kanit', sans-serif;
                     
                }
</style>
<br>
<br>
<center>    
    <div class="block" style="width: 95%;">
        <div class="block-content">
            <div class="block-header block-header-default">
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลบุคลากร</B></h3>
                 
            </div>
            <div class="block-content">
        
            <div class="row" >
        
           
                   
       
              <br>
        
            <?php $data[] = array('กลุ่มงาน','จำนวนคน'); ?>
            @foreach ($groupworks as $groupwork)
            <?php $data[] = array($groupwork->HR_DEPARTMENT_NAME,$groupwork->person_count); ?>   
            @endforeach  


            <div style="width: 95%;">
           <div class="block block-content">
   <div id="columnchart_material" style="font-family: 'Kanit', sans-serif;width: 100%; height: 500px;"></div>
                   
   </div>
 </div>


          <br>
                <?php $data_2[] = array('กลุ่มบุคลากร','จำนวนคน'); ?>
            @foreach ($grouppersons as $groupperson)
            <?php $data_2[] = array($groupperson->HR_PERSON_TYPE_NAME,$groupperson->person_count); ?>   
            @endforeach  


            <div style="width: 95%;">
           <div class="block block-content">
            <div class="row">
            <div class="col-md-6">
      <div id="piechart_3d_1" style="width: 100%; height: 550px;"></div>
      </div>
      <div class="col-md-6">
      <div id="piechart_3d_2" style="width: 100%; height: 550px;"></div>
       </div> 
    </div> 

    </div>
    </div>    
    </div>    


<div class="block-header block-header-default">
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ข้อมูลการลา</B></h3>
                 
            </div>
         
            <br>
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                            <a class="block block-rounded block-link-pop bg-xinspire" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div class="item">
                                        <i class="fa fa-2x fa fa-user-injured text-white"></i>
                                    </div>
                                    <div class="ml-3 text-right" >
                                    <p class="text-white mb-0">
                                            ลาป่วย (ครั้ง)
                                        </p>
                                        <p class="text-white mb-0" style="font-size: 2.25rem;">
                                         {{$count1}}
                                        </p>
                                 
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-xl-3">
                            <a class="block block-rounded block-link-pop bg-danger" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div class="item">
                                        <i class="fa fa-2x fa fa fa-baby text-white"></i>
                                    </div>
                                    <div class="ml-3 text-right">
                                    <p class="text-white mb-0">
                                            ลาคลอดบุตร (ครั้ง)
                                        </p>
                                    <p class="text-white mb-0" style="font-size: 2.25rem;">
                                            {{$count2}}
                                        </p>
                                   
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-xl-3">
                            <a class="block block-rounded block-link-pop bg-warning" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div class="item">
                                        <i class="fa fa-2x fa-envelope-open text-white"></i>
                                    </div>
                                <div class="ml-3 text-right">
                                <p class="text-white mb-0">
                                        ลากิจ (ครั้ง)
                                        </p>
                                <p class="text-white mb-0" style="font-size: 2.25rem;">
                                        {{$count3}}
                                        </p>
                                    
                                    </div>
                                    
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-xl-3">
                            <a class="block block-rounded block-link-pop bg-info" href="javascript:void(0)">
                                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                <div class="item">
                                        <i class="fa fa-2x fa fa-coffee text-white"></i>
                                    </div>
                                <div class="ml-3 text-right">
                                <p class="text-white mb-0">
                                        ลาพักผ่อน (ครั้ง)
                                        </p>
                                <p class="text-white mb-0" style="font-size: 2.25rem;">
                                        {{$count4}}
                                        </p>
                                   
                                    </div>
                                    
                                </div>
                            </a>
                        </div>   
                </div>
                <div class="row">
                        <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-xinspire" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div class="item">
                                            <i class="fa fa-2x fa fa-bookmark text-white"></i>
                                        </div>
                                        <div class="ml-3 text-right" >
                                        <p class="text-white mb-0">
                                                ลาอุปสมบท (ครั้ง)
                                            </p>
                                            <p class="text-white mb-0" style="font-size: 2.25rem;">
                                                    {{$count5}}
                                            </p>
                                     
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-danger" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div class="item">
                                            <i class="fa fa-2x fa fa-baby-carriage text-white"></i>
                                        </div>
                                        <div class="ml-3 text-right">
                                        <p class="text-white mb-0">
                                                ลาช่วยภริยาคลอด (ครั้ง)
                                            </p>
                                        <p class="text-white mb-0" style="font-size: 2.25rem;">
                                                {{$count6}}
                                            </p>
                                       
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-warning" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div class="item">
                                            <i class="fa fa-2x fa fa-users text-white"></i>
                                        </div>
                                    <div class="ml-3 text-right">
                                    <p class="text-white mb-0">
                                            ลาเกณฑ์ทหาร (ครั้ง)
                                            </p>
                                    <p class="text-white mb-0" style="font-size: 2.25rem;">
                                            {{$count7}}
                                            </p>
                                        
                                        </div>
                                        
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-info" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div class="item">
                                            <i class="fa fa-2x fa fa-graduation-cap text-white"></i>
                                        </div>
                                    <div class="ml-3 text-right">
                                    <p class="text-white mb-0">
                                            ลาศึกษา ฝึกอบรม (ครั้ง)
                                            </p>
                                    <p class="text-white mb-0" style="font-size: 2.25rem;">
                                            {{$count8}}
                                            </p>
                                       
                                        </div>
                                        
                                    </div>
                                </a>
                            </div>   
                
                <div class="row">
                        <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-xinspire" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div class="item">
                                            <i class="fa fa-2x fa fa-plane-departure text-white"></i>
                                        </div>
                                        <div class="ml-3 text-right" >
                                        <p class="text-white mb-0">
                                                ลาทำงานต่างประเทศ (ครั้ง)
                                            </p>
                                            <p class="text-white mb-0" style="font-size: 2.25rem;">
                                                    {{$count9}}
                                            </p>
                                     
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-danger" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                        <div class="item">
                                            <i class="fa fa-2x fa fa-transgender text-white"></i>
                                        </div>
                                        <div class="ml-3 text-right">
                                        <p class="text-white mb-0">
                                                ลาติดตามคู่สมรส (ครั้ง)
                                            </p>
                                        <p class="text-white mb-0" style="font-size: 2.25rem;">
                                                {{$count10}}
                                            </p>
                                       
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-warning" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div class="item">
                                            <i class="fa fa-2x fa fa-pencil-ruler text-white"></i>
                                        </div>
                                    <div class="ml-3 text-right">
                                    <p class="text-white mb-0">
                                            ลาฟื้นฟูอาชีพ (ครั้ง)
                                            </p>
                                    <p class="text-white mb-0" style="font-size: 2.25rem;">
                                            {{$count11}}
                                            </p>
                                        
                                        </div>
                                        
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <a class="block block-rounded block-link-pop bg-info" href="javascript:void(0)">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                                    <div class="item">
                                            <i class="fa fa-2x fa fa-share text-white"></i>
                                        </div>
                                    <div class="ml-3 text-right">
                                    <p class="text-white mb-0">
                                            ลาออก (ครั้ง)
                                            </p>
                                    <p class="text-white mb-0" style="font-size: 2.25rem;">
                                            {{$count12}}
                                            </p>
                                       
                                        </div>
                                        
                                    </div>
                                </a>
                            </div>   
                </div>

                </div> 
            </div> 
            </div> 


            <br>

<div style="width: 95%;">
<div class="block block-content">

            <div id="columnchart_leave" style="font-family: 'Kanit', sans-serif;width: 100%; height: 500px;"></div>
            
            </div> 
            </div> 
          
        

        </div>
   

    <script src="{{ asset('google/Charts.js') }}"></script>

    
<script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php
            echo json_encode($data);
            ?>);

        var options = {
            fontName: 'Kanit',
            hAxis: { slantedText: true, 
                      slantedTextAngle: 45
            },
          chart: {
            title: 'จำนวนเจ้าหน้าที่ในกลุ่มงาน',
          }
        
        };

     
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable( <?php
            echo json_encode($data_2);
            ?>);

        var options = {
          title: 'จำนวนกลุ่มบุคลากร ',
          fontName: 'Kanit',

      
        
           
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_1'));
        chart.draw(data, options);
      }
    </script>


<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['เพศ', 'จำนวน'],
          ['ชาย',<?php echo $man ?>],
          ['หญิง', <?php echo $women ?>],
         
         
        ]);

        var options = {
          title: 'จำนวนบุคลากรจำแนกเพศ ',
          fontName: 'Kanit',

      
        
           
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_2'));
        chart.draw(data, options);
      }
    </script>


    
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['เดือน','จำนวนครั้ง'],
        ['ม.ค', <?php echo $m1_1; ?>],
        ['ก.พ', <?php echo $m2_1; ?>],
        ['มี.ค', <?php echo $m3_1;?>],
        ['เม.ย', <?php echo $m4_1;?>],
        ['พ.ค', <?php echo $m5_1;?>],
        ['มิ.ย', <?php echo $m6_1;?>],
        ['ก.ค', <?php echo $m7_1;?>],
        ['ส.ค', <?php echo $m8_1;?>],
        ['ก.ย', <?php echo $m9_1;?>],
        ['ต.ค', <?php echo $m10_1;?>],
        ['พ.ย', <?php echo $m11_1; ?>],
        ['ธ.ค', <?php echo  $m12_1;?>]
      ]);
      var options = {
          fontName: 'Kanit',
          hAxis: { slantedText: true, 
                    slantedTextAngle: 45
          },
        chart: {
          title: 'จำนวนการลา ปีปัจจุบัน',
        }        
      };     
      var chart = new google.charts.Bar(document.getElementById('columnchart_leave'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }      
</script>

@endsection