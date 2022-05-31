<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="riskincidencelevel.xls"');//ชื่อไฟล์

use App\Http\Controllers\ManagerriskController;
?>

<center>    
    <div class="block" style="width: 95%;">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>รายงานการเกิด/แก้ไขอุบัติการณ์ความเสี่ยงแยกตามระดับความรุนแรง</B></h3>   
               <div align="right ">
                 
                  </div>
                </div>
             
                 
        <div class="block-content">  
            <div class="table-responsive"> 
               <table class="gwt-table table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                    <thead style="background-color: #FFEBCD;">
                        <tr height="40">
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">ลำดับ</th>
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" >ระดับความรุนแรง</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">A</th>
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">B</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">C</th>
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">D</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">E</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">F</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">G</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">H</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">I</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">1</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">2</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">3</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">4</th> 
                            <th  class="text-font" style="border: 1px solid black;text-align: center;" width="5%">5</th>                           
                            {{-- <th  class="text-font" style="border: 1px solid black;ext-align: center" width="8%">ร้อยละ</th>  --}}
                        </tr >
                    </thead>
                    <tbody>
                        <?php $number = 0; ?>
                        @foreach ($riskprograms as $riskprogram)
                            <?php
                            $number++;
                            ?>
                   
                            <tr height="20">                       
                                <td class="text-font" align="center">{{$number}}</td>
                                <td class="text-font text-pedding" style="text-align: left;">{{$riskprogram->RISK_REPPROGRAM_NAME}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('A',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('B',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('C',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('D',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>  
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('E',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('F',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td> 
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('G',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('H',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>  
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('I',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('1',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td> 
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('2',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('3',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>  
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('4',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countrisklevel('5',$riskprogram->RISK_REPPROGRAM_ID,$displaydate_bigen,$displaydate_end))}}</td>        
                                {{-- <td class="text-font text-pedding" ></td> --}}
                            </tr>

                            @endforeach
                       
                    </tbody>
                </table>
    