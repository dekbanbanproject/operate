<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('asset/media/favicons/logo_cir.png') }}">
    <title>print</title>
    <link rel="stylesheet" id="css-main" href="{{ asset('asset/css/dashmix.css') }}">
    <link rel="stylesheet" href="{{asset('css/stylesl.css').'?v='.time()}}">
    <style>
        body * {
            font-family: 'Kanit', sans-serif;
        }
    </style>
    <style>
        @media print {

            /* html,
            body {
                -webkit-print-color-adjust: exact;
                width: 100mm;
                width: 100mm;
            } */
            @page {
                size: auto;
                /* size: 50mm 20mm; */
                margin: 0px;
            }

            .pageSmall {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
                /* overflow:hidden; */
            }

            .pageBig {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <?php
    $barcode_generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    use App\Models\cpay_setequpment_list;
?>
    <div class="block d-print-none">
        <div class="block-header border ">
            <div class="block-title fs-18 fw-7">ปริ้นสติ๊กเกอร์</div>
            <div class="block-options fs-18 fw-7">
                <button type="button" class="btn btn-sm btn-primary f-kanit" onclick="printSmall()">
                    <div class="fa fa-barcode mr-2"></div>ปริ้นสติ๊กเกอร์เล็ก
                </button>
                <button type="button" class="btn btn-sm btn-primary f-kanit" onclick="printBig()">
                    <div class="fa fa-barcode mr-2"></div>ปริ้นสติ๊กเกอร์ใหญ่
                </button>
            </div>
        </div>
        <div class="block-body d-block justify-content-center">
            <?php
                        $temp_row_setequpment   = '
                        <tr>
                        <td class="p-0 overflow-hidden" style="width:165px;vertical-align: text-top;">[[equp_list]]</td>
                        <td class="p-0 text-center overflow-hidden" style="width:66px;vertical-align: text-top;">[[num]]</td>
                        </tr>
                                                ';
                        $template               = '<div class="boreder pageBig overflow-hidden position-relative" style="
                                            width:calc(5cm*1.50);
                                            height:calc(8cm*1.49);
                                            background:white;
                                            overflow:hidden;
                                            padding:1mm;
                                            color:black;
                                            ">
                                                <div class="fs-14 fw-b position-absolute text-center text-nowrap overflow-hidden" style="
                                                    top:25px;left: 14px;width: 119px;">[[type_steam]]</div>
                                                <div class="fs-9 fw-6 position-absolute" style="
                                                    top:23px;left:150px">[[hospital_name]]</div>
                                                <div class="fs-9 fw-8 position-absolute" style="
                                                    top:38px;left:150px">[[dep_name]]</div>
                                                <div class="fs-16 fw-6 position-absolute text-center" style="line-height:1;overflow-wrap:anywhere;
                                                    top:63px;left:14px;width:255px;">[[equpment]]</div>
                                                <div class="fs-12 position-absolute text-nowrap overflow-hidden" style="top:115px;left:40px;width:104.88px">ผู้ผลิต [[p_production]]</div>
                                                <div class="fs-12 position-absolute text-nowrap overflow-hidden" style="top:128px;left:40px;width:104.88px">ผู้ตรวจ [[p_check]]</div>
                                                <div class="fs-12 position-absolute text-nowrap overflow-hidden" style="top:140px;left:40px;width:104.88px">ผู้นึ่ง/อบ [[p_sterilize]]</div>
                                                <div class="fs-12 position-absolute text-nowrap overflow-hidden" style="top:115px;left:150px;width:125px">รอบผลิต [[around]]</div>
                                                <div class="fs-12 position-absolute text-nowrap overflow-hidden" style="top:128px;left:150px;width:125px">เครื่อง ([[mach_num]]) [[mach_name]]</div>
                                                    <div class="position-absolute" style="top:155px;left:42px">
                                                        <table width="231px" class="fs-12" style="color:black;table-layout:fixed">
                                                            <thead>
                                                                <tr><th width="165px" class="pl-1">รายการ</th>
                                                                <th width="67px" class="text-center">จำนวน</th>
                                                            </tr></thead>
                                                            <col width="165px" />
                                                <col width="66px" />
                                                            <tbody>
                                                            [[row_setequp_list]]
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <div class="fs-10 position-absolute" style="top:380px;left:55px;width:221px;">
                                                    <div class="text-center">[[label]]<br>
                                                        <img src="data:image/png;base64,[[barcode_label]]" style="width:100%;height:20px">
                                                    </div>
                                                </div>
                                                <div class="fs-10 position-absolute text-nowrap overflow-hidden" style="top:420px;left:110px;width:120px">วันที่ผลิต
                                                [[production_date]]</div>
                                                <div class="fs-14 position-absolute text-nowrap overflow-hidden" style="top:431px;left:110px;width:165px">วันหมดอายุ
                                                [[expire_date]]</div>
                                                <div class="fs-10 position-absolute text-nowrap overflow-hidden" style="top:420px;left:235px;width:45px">อายุ 
                                                [[expire_day]] วัน</div>
                                            </div>';
                        $template = str_replace('[[row_setequp_list]]',$temp_row_setequpment,$template);
                ?>
                <?php 
                        $template  = '<div class="boreder pageSmall overflow-hidden position-relative" style="
                        width:calc(5cm*1.50);
                        height:calc(2.5cm*1.49);
                        background:white;
                        overflow:hidden;
                        color:black;
                        ">
                            <div class="fs-14 fw-b position-absolute text-center text-nowrap overflow-hidden" style="
                                top: 59.7px; 
                                left: -21.8px;
                                transform: rotate(90deg);
                                width: 85px;
                                ">[[type_steam]]</div>
                            <div class="fs-9 fw-6 position-absolute" style="top:2px;left:180px">[[hospital_name]]</div>
                            <div class="fs-9 fw-6 position-absolute" style="top:2px;left:45px">[[dep_name]]</div>
                            <div class="fs-12 fw-6 position-absolute text-center" style="line-height:1;overflow-wrap:anywhere;top:14px;left:45px;width:223px">
                            [[equpment]]</div>
                            <div class="fs-8 position-absolute" style="top:40px;left:45px;width:223px">
                                <div class="text-center">[[label]]<br>
                                    <img src="data:image/png;base64,[[barcode_label]]" style="width:100%;height:8px">
                                </div>
                            </div>
                            <div class="fs-9 position-absolute text-nowrap overflow-hidden" style="top:65px;left:45px;width:45%">ผู้ผลิต [[p_production]]</div>
                            <div class="fs-9 position-absolute text-nowrap overflow-hidden" style="top:77px;left:45px;width:45%">ผู้ตรวจ [[p_check]]</div>
                            <div class="fs-9 position-absolute text-nowrap overflow-hidden" style="top:90px;left:45px;width:45%">ผู้นึ่ง/อบ [[p_sterilize]]</div>
                            <div class="fs-9 position-absolute text-nowrap overflow-hidden" style="top:65px;left:168px;width:100%">รอบผลิต [[around]]</div>
                            <div class="fs-7 position-absolute text-nowrap overflow-hidden" style="top:77px;left:168px;width:100%">เครื่อง ([[mach_num]]) [[mach_name]]</div>
                            <div class="fs-10 position-absolute text-nowrap" style="top:105px;left:94px">วันที่ผลิต
                            [[production_date]]</div>
                            <div class="fs-13 position-absolute text-nowrap" style="top:115px;left:94px">วันหมดอายุ
                            [[expire_date]]</div>
                            <div class="fs-8 position-absolute text-nowrap" style="top:100px;left:240px">อายุ 
                            [[expire_day]] วัน</div>
                        </div>';

                    echo $template;
                ?>

        </div>
        <h3 class="m-0 ml-3">สำหรับขนาดเล็ก (ไม่มีรายการย่อย)</h3>
        <div id="show_cardsmall" style="
                display:grid;
                grid-column-gap:10px;
                grid-row-gap:10px;
                grid-template-columns: auto auto auto auto auto;
                justify-items:center;
                background:#dcdcdc;
                padding:10px
            "></div>
        <h3 class="m-0 ml-3">สำหรับขนาดใหญ่ (มีรายการย่อย)</h3>
        <div id="show_cardbig" style="
                display:grid;
                grid-column-gap:10px;
                grid-row-gap:10px;
                grid-template-columns: auto auto auto auto;
                justify-items:center;
                background:#dcdcdc;
                padding:10px
            "></div>
    </div>
    </div>
    <div id="cardsmall" class="d-none d-print-block"></div>
    <div id="cardbig" class="d-none d-print-block"></div>
    </div>
    </div>
    <script src="{{ asset('asset/js/dashmix.app.js') }}"></script>
    <script>
        // ปริ้นภายในหน้า และเลือกส่วนที่ปริ้นได้
        // const printContentsSmall = $('.pageSmall')
        const printContentsSmall = document.querySelectorAll('.pageSmall');
        let divToShowSmall = document.getElementById('show_cardsmall');
        let divToPrintSmall = document.getElementById('cardsmall');
        // for (const item in printContentsSmall) {
        //     // divToShowSmall.html += printContentsSmall[item];
        // }

        printContentsSmall.forEach(function (ele, index) {
            // let aBlock = document.createElement('block').appendChild();
            divToShowSmall.append(ele.cloneNode(true));
            divToPrintSmall.append(ele);
            // divToPrintSmall.cloneNode(ele);
        });

        const printContentsBig = $('.pageBig')
        let divToShowBig = document.getElementById('show_cardbig');
        let divToPrintBig = document.getElementById('cardbig');
        printContentsBig.each(function (index, ele) {
            divToShowBig.append(ele.cloneNode(true));
            divToPrintBig.appendChild(ele);
        });
        // printSmall()
        // printBig()
        window.print();
        function printSmall() {
            let divToPrintSmall = document.getElementById('cardsmall');
            var html = '<html>' + // 
                '<head>' +
                '<link rel="shortcut icon" href="{{ asset("asset/media/favicons/logo_cir.png") }}">' +
                '<title>ปริ้่นสติ๊กเกอร์ขนาดเเล็ก</title>' +
                '<link rel="stylesheet" id="css-main" href="{{ asset("asset/css/dashmix.css") }}">' +
                '<link rel="stylesheet" href="{{asset("css/stylesl.css")."?v=".time()}}">' +
                '<style>' +
                'body * {' +
                'font-family: "Kanit", sans-serif;' +
                '}' +
                '@media print {' +
                '@page{' +
                'size: auto;' +
                '}' +
                '.pageSmall {' +
                'margin: 0;' +
                'border: initial;' +
                'border-radius: initial;' +
                'width: initial;' +
                'min-height: initial;' +
                'box-shadow: initial;' +
                'background: initial;' +
                'page-break-after: always;' +
                '}}' +
                '</style>' +
                '</head>' +
                '<body onload="window.print(); window.close();">' + divToPrintSmall.innerHTML +
                '</body>' +
                '</html>';
            console.log(divToPrintSmall);
            // var popupWin = window.open('', "PRINT",
            // "toolbar=no,menubar=no,location=no,resizable=no,status=yes,scrollbars=yes,fullscreen=yes");
            if (divToPrintSmall.innerHTML !== '') {
                var popupWin = window.open();
                popupWin.document.write(html); //โหลด print.css ให้ทำงานก่อนสั่งพิมพ์
                popupWin.focus();
                popupWin.document.close();
            }
        }

        function printBig() {
            let divToPrintBig = document.getElementById('cardbig');
            var html = '<html>' + // 
                '<head>' +
                '<title>ปริ้่นสติ๊กเกอร์ขนาดใหญ่</title>' +
                '<link rel="stylesheet" id="css-main" href="{{ asset("asset/css/dashmix.css") }}">' +
                '<link rel="stylesheet" href="{{asset("css/stylesl.css")."?v=".time()}}">' +
                '<style>' +
                'body * {' +
                'font-family: "Kanit", sans-serif;' +
                '}' +
                '@media print {' +
                '@page{' +
                'size: auto;' +
                '}' +
                '.pageBig {' +
                'margin: 0;' +
                'border: initial;' +
                'border-radius: initial;' +
                'width: initial;' +
                'min-height: initial;' +
                'box-shadow: initial;' +
                'background: initial;' +
                'page-break-after: always;' +
                '}}' +
                '</style>' +
                '</head>' +
                '<body style="padding:0px" onload="window.print(); window.close();">' + divToPrintBig.innerHTML +
                '</body>' +
                '</html>';
            // var popupWin = window.open('', "PRINT",
            // "toolbar=no,menubar=no,location=no,resizable=no,status=yes,scrollbars=yes,fullscreen=yes");
            if (divToPrintBig.innerHTML !== '') {
                var popupWin = window.open();
                popupWin.document.write(html); //โหลด print.css ให้ทำงานก่อนสั่งพิมพ์
                popupWin.document.close();
            }
        }
    </script>

</body>

</html>