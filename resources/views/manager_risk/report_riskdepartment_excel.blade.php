<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="riskdepartment.xls"');//ชื่อไฟล์

use App\Http\Controllers\ManagerriskController;
?>

<center>    

                <div class="block" style="width: 95%;">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>รายงานอันดับการเกิดอุบัติการณ์ความเสี่ยงขององค์กร</B></h3>   
                <div align="right ">
                 
                  </div>
                </div>
                <div class="block-content block-content-full">  
              
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
                        @foreach ($items as $item)
                            <?php
                            $number++;
                            ?>
                   
                            <tr height="20">                       
                                <td class="text-font" align="center">{{$number}}</td>
                                <td class="text-font text-pedding" style="text-align: left;">  {{ $item->RISK_REPITEMS_CODE }} :: {{ $item->RISK_REPITEMS_NAME }}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('A',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('B',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('C',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('D',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>  
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('E',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('F',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td> 
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('G',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('H',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>  
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('I',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('1',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td> 
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('2',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('3',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>  
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('4',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>
                                <td class="text-font text-pedding" >{{number_format(ManagerriskController::countriskrepitem('5',$item->RISK_REPITEMS_ID,$displaydate_bigen,$displaydate_end))}}</td>        
                                {{-- <td class="text-font text-pedding" ></td> --}}
                            </tr>

                            @endforeach
                       
                    </tbody>
                </table>
      