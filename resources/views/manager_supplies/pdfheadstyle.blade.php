
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew-webfont.eot');
            src: url('fonts/thsarabunnew-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew-webfont.woff') format('woff'),
                url('fonts/thsarabunnew-webfont.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;

        }
        
        @font-face {
            font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew_bolditalic-webfont.eot');
            src: url('fonts/thsarabunnew_bolditalic-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew_bolditalic-webfont.woff') format('woff'),
                url('fonts/thsarabunnew_bolditalic-webfont.ttf') format('truetype');
            font-weight: bold;
            font-style: italic;

        }

        @font-face {
            font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew_italic-webfont.eot');
            src: url('fonts/thsarabunnew_italic-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew_italic-webfont.woff') format('woff'),
                url('fonts/thsarabunnew_italic-webfont.ttf') format('truetype');
            font-weight: normal;
            font-style: italic;

        }

        @font-face {
            font-family: 'THSarabunNew';
            src: url('fonts/thsarabunnew_bold-webfont.eot');
            src: url('fonts/thsarabunnew_bold-webfont.eot?#iefix') format('embedded-opentype'),
                url('fonts/thsarabunnew_bold-webfont.woff') format('woff'),
                url('fonts/thsarabunnew_bold-webfont.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;

        }
        body {
            font-family: 'THSarabunNew', sans-serif;
                    font-size: 14px;
                    line-height: 1;
                    padding: 28.3465pt 7.1732pt 7.1732pt 56.6929pt;
            
                }
      
table, th, td {
    bordor:none;
}

.text-pedding{
    padding-left:10px;
    padding-right:10px;
                        }

            .text-font {
        font-size: 18px;
                    }   

        
    </style>

<?php


    function DateThaifrom($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
  $strMonthThai=$strMonthCut[$strMonth];
  return thainumDigit($strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear);
  }


    ?>

</head>
<body>
<img src="image/Garuda.png" width="50" height="50">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<B style="font-size: 20px;">บันทึกข้อความ</B><BR>
<b>ส่วนราชการ</b> {{$infoorg->ORG_NAME}} อ.{{$infoorg->DISTRICT}} จ.{{$infoorg->PROVINCE}}<br>
ที่ {{thainumDigit($hrddepartment->BOOK_NUM.'/'.$inforcon->DEP_REQUEST_BOOK_NUM)}}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
วันที่ {{DateThaifrom(date('Y-m-d'))}}<br>
<b>เรื่อง</b> ขออนุมัติจัดซื้อจัดจ้าง <br>
________________________________________________________________________________________<br>
<B>เรียน</B> {{$inforcon->ORG_PROVINCE_LEADER}}<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ด้วย   มีความประสงค์ขออนุมัติจัดซื้อจัดจ้าง {{$infotypebuy}} ดังนี้<br>
<br>

                <table style="width: 600px;" >
                <?php $number = 1; ?>
                    @foreach ($infocons as $infocon)  
                    <tr>
                    <td style="width: 25px word-break:break-all; word-wrap:break-word;" class="text-font text-pedding"><center>{{thainumDigit($number)}}</center></td>
                    <td style="width: 200px word-break:break-all; word-wrap:break-word;" class="text-font text-pedding">{{$infocon->SUP_NAME}}</td>
                    <td style="width: 25px word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding"> จำนวน</td>
                    <td style="width:50px; word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding">{{thainumDigit(number_format($infocon->SUP_TOTAL))}}   </td>
                    <td style="width: 25px word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding"> {{$infocon->SUP_UNIT_NAME}}</td>
                 
                    </tr>
                    <?php $number++;?>

                    @endforeach   


                </table><br>

                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;รวม   รายการ โดยใช้งบประมาณ <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในการนี้ขอแต่งตั้ง ... ตำแหน่ง .. เป็นเจ้าหน้าที่้ผู้รับผิดชอบในการจัดทำร่างขอบเขต
                ของงานหรือรายละเอียดคุณลักษณะเฉพาะของพัสดุที่จะซื้อหรือจ้าง ตามระเบียบกระทรวงการคลังว่าด้วยหลักเกณฑ์ การจัดซื้อจัดจ้างและบริหารพัสดุภาครัฐ พ.ศ.๒๕๖๐ ข้อ ๒๑ พร้อมได้แนบร่างขอบเขตของงานหรือรายละเอียดคุณลักษณะของพัสดุ พร้อมมานี้ด้วยแล้ว<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณาให้ความเห็นชอบในร่างขอบเขต ของงานหรือรายละเอียด
                คุณลักษณะของพัสดุที่จะซื้อ หรือจ้างตามข้อเสนอข้างต้นเพื่อประกอบการจัดหาพัสดุและมอบงานพัสดุกลุมงานบริหารทั่วไปดำเนินการจัดหาตามระเบียบฯ ต่อไป<br>
</body>
</html>