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
            font-size: 13px;

        }

        label {
            font-family: 'Kanit', sans-serif;
            font-size: 13px;

        }

        @media only screen and (min-width: 1200px) {
            label {
                float: right;
            }
        }

        .text-pedding {
            padding-left: 10px;
        }

        .text-font {
            font-size: 13px;
        }


        .form-control {
            font-size: 13px;
        }

    </style>

    <script>
        function checklogin() {
            window.location.href = '{{ route('index') }}';
        }

    </script>
    <?php
    if (Auth::check()) {
    $status = Auth::user()->status;
    $id_user = Auth::user()->PERSON_ID;
    } else {
    echo "

    <body onload=\"checklogin()\"></body>";
    exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    $user_id = substr($url, $pos);

    use App\Http\Controllers\MeetingController;
    $checkver = MeetingController::checkver($user_id);
    $countver = MeetingController::countver($user_id);
    ?>
    <?php
    function RemoveDateThai($strDate)
    {
    $strYear = date('Y', strtotime($strDate)) + 543;
    $strMonth = date('n', strtotime($strDate));
    $strDay = date('j', strtotime($strDate));
    $strMonthCut = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
    }
    function Removeformate($strDate)
    {
    $strYear = date('Y', strtotime($strDate));
    $strMonth = date('m', strtotime($strDate));
    $strDay = date('d', strtotime($strDate));
    return $strDay . '/' . $strMonth . '/' . $strYear;
    }
    function Removeformatetime($strtime)
    {
    $H = substr($strtime, 0, 5);
    return $H;
    }
    ?>
    <!-- Advanced Tables -->
    <br>
    <br>
    <br>

    <center>
        <div class="block" style="width: 95%;">
            <div class="block block-rounded block-bordered">


                <div class="block-content">
                    <h2 class="content-heading pt-0" style="font-family: 'Kanit', sans-serif;">
                        แก้ไขแบบประเมินการควบคุมภายในด้วยตนเอง (Control self Assessment : CSA)</h2>
                    <div class="block-content block-content-full" align="left">
                        <form method="post" action="{{ route('mrisk.internalcontrol_update') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value="{{ $internalcontrol->INTERNALCONTROL_ID }}"
                                name="INTERNALCONTROL_ID" id="INTERNALCONTROL_ID" class="form-control input-sm">




                            <div class="row push">
                                <div class="col-sm-2">
                                    <label for="INTERNALCONTROL_GROUP_NAME"
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">กลุ่ม/ฝ่าย/งาน
                                        :</label>
                                </div>
                                <div class="col-lg-4 ">
                                    <select name="INTERNALCONTROL_GROUP_NAME" id="INTERNALCONTROL_GROUP_NAME"
                                        class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;"
                                        required>
                                        <option value="">เลือก</option>
                                        @foreach ($departmentsubs as $departmentsub)
                                            @if ($departmentsub->HR_DEPARTMENT_SUB_ID == $internalcontrol->INTERNALCONTROL_GROUP_NAME)
                                                <option value="{{ $departmentsub->HR_DEPARTMENT_SUB_ID }}" selected>
                                                    {{ $departmentsub->HR_DEPARTMENT_SUB_NAME }}</option>
                                            @else
                                                <option value="{{ $departmentsub->HR_DEPARTMENT_SUB_ID }}">
                                                    {{ $departmentsub->HR_DEPARTMENT_SUB_NAME }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <label for="INTERNALCONTROL_HEAD_WORK"
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">หัวหน้าฝ่ายงาน:</label>
                                </div>
                                <div class="col-lg-2 ">
                                    <select name="INTERNALCONTROL_HEAD_WORK" id="INTERNALCONTROL_HEAD_WORK"
                                        class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;"
                                        required>
                                        <option value="">เลือก</option>
                                        @foreach ($infodepartmentsubs as $infodepartmentsub)
                                            @if ($infodepartmentsub->LEADER_HR_ID == $internalcontrol->INTERNALCONTROL_HEAD_WORK)
                                                <option value="{{ $infodepartmentsub->LEADER_HR_ID }}" selected>
                                                    {{ $infodepartmentsub->HR_FNAME }}
                                                    {{ $infodepartmentsub->HR_LNAME }}</option>
                                            @else
                                                <option value="{{ $infodepartmentsub->LEADER_HR_ID }}">
                                                    {{ $infodepartmentsub->HR_FNAME }}
                                                    {{ $infodepartmentsub->HR_LNAME }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <label
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">วันที่
                                        :</label>
                                </div>
                                <div class="col-lg-2 ">
                                    <input value="{{ formate($internalcontrol->INTERNALCONTROL_DATE) }}"
                                        name="INTERNALCONTROL_DATE" id="INTERNALCONTROL_DATE"
                                        class="form-control input-sm datepicker" data-date-format="mm/dd/yyyy" readonly>
                                </div>
                            </div>

                            <div class="row push">
                                <div class="col-sm-2 text-right"
                                    style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">
                                    ระยะเวลา :
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="col-sm-1.5">
                                    <span>
                                        <select name="BUDGET_YEAR" id="BUDGET_YEAR" class="form-control input-lg budget"
                                            style=" font-family: 'Kanit', sans-serif;">
                                            @foreach ($budgets as $budget)
                                                @if ($budget->LEAVE_YEAR_ID == $internalcontrol->INTERNALCONTROL_YEAR)
                                                    <option value="{{ $budget->LEAVE_YEAR_ID }}" selected>
                                                        {{ $budget->LEAVE_YEAR_ID }}</option>
                                                @else
                                                    <option value="{{ $budget->LEAVE_YEAR_ID }}">
                                                        {{ $budget->LEAVE_YEAR_ID }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </span>
                                </div>

                                <div class="col-sm-4 date_budget">
                                    <div class="row push">
                                        <div class="col-sm" style=" font-family: 'Kanit', sans-serif;">
                                            วันที่
                                        </div>
                                        <div class="col-md-4">

                                            <input name="DATE_BIGIN" id="DATE_BIGIN"
                                                class="form-control input-lg datepicker" data-date-format="mm/dd/yyyy"
                                                value="{{ formate($internalcontrol->INTERNALCONTROL_START_DAY) }}"
                                                readonly>

                                        </div>
                                        <div class="col-sm" style=" font-family: 'Kanit', sans-serif;">
                                            ถึง
                                        </div>
                                        <div class="col-md-4">

                                            <input name="DATE_END" id="DATE_END" class="form-control input-lg datepicker"
                                                data-date-format="mm/dd/yyyy"
                                                value="{{ formate($internalcontrol->INTERNALCONTROL_END_DAY) }}"
                                                readonly>

                                        </div>


                                        <div class="col-sm">

                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="row push">
                                <div class="col-sm-2 text-right">
                                    <label>1 :</label>
                                </div>
                                <div class="col-lg-10 ">
                                    <div align="left"
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">
                                        ไห้วิเคราะและเลือกภารกิจงาน/กิจกรรมที่มีความเสี่ยงสูงมา ๑
                                        เรื่องพร้อมระบุวัตถุประสงค์ของภารกิจงาน/กิจกรรมนั้น
                                    </div>
                                </div>
                            </div>

                            <div class="row push">
                                <div class="col-sm-2">
                                    <label></label>
                                </div>

                                <div align="left" class="col-sm-1 "
                                    style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">ภารกิจ :
                                </div>

                                <div class="col-lg-9 ">
                                    <input type="text" value="{{ $internalcontrol->INTERNALCONTROL_MISSION }}"
                                        name="INTERNALCONTROL_MISSION" id="INTERNALCONTROL_MISSION"
                                        class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">
                                </div>
                            </div>

                            <div class="row push">
                                <div class="col-md-2 ">
                                </div>

                                <div class="col-md-10  ">

                                    <div align="left"
                                        style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;">
                                        วัตถุประสงค์ :</div>
                                    <br>
                                    <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                                        <thead style="background-color: #FFEBCD;">
                                            <tr height="40">
                                                <td style="text-align: center;font-size: 14px;font-weight:normal;"
                                                    width="5%">ลำดับ</td>
                                                <td style="text-align: center;font-size: 14px;font-weight:normal;">
                                                    รายละเอียด</td>

                                                <td style="text-align: center;" width="8%">
                                                    <a class="btn btn-success fa fa-plus-square addRow"
                                                        style="color:#FFFFFF;"></a>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody1">

                                            <tr height="20">
                                                <?php $number = 0; ?>
                                                @foreach ($internalcontrol_subs as $internalcontrol_sub)
                                                    <?php $number++; ?>
                                                    <td style="text-align: center;font-size: 14px;font-weight:normal;">
                                                        {{ $number }}</td>
                                                    <td>
                                                        <input name="INTERNALCONTROL_OBJECTIVE[]"
                                                            id="INTERNALCONTROL_OBJECTIVE[]" class="form-control input-sm"
                                                            style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;"
                                                            value="{{ $internalcontrol_sub->INTERNALCONTROL_OBJECTIVE }}">
                                                    </td>

                                                    <td style="text-align: center;"><a
                                                            class="btn btn-danger fa fa-trash-alt remove"
                                                            style="color:#FFFFFF;"></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row push">
                                <div class="col-sm-2 text-right">
                                    <label>2 :</label>
                                </div>
                                <div class="col-lg-10 ">
                                    <div align="left"
                                        style=" font-family:'Kanit', sans-serif;font-size:14px;font-weight:normal;">
                                        ภารกิจงาน/กิจกรรมนั้น มีขั้นตอนหรือกระบวนการปฎิบัติอะไรบ้าง
                                        หรือทำอย่างไรที่จะทำไห้บรรลุตามวัตถุประสงค์
                                    </div>
                                </div>
                            </div>

                            <div class="row push">
                                <div class="col-sm-2">
                                    <label></label>
                                </div>
                                <div class="col-lg-10 ">
                                    <table class="gwt-table table-striped table-vcenter" style="width: 100%;">
                                        <thead style="background-color: #FFEBCD;">
                                            <tr height="40">
                                                <td style="text-align: center;font-size:14px;font-weight:normal;"
                                                    width="5%">ลำดับ</td>
                                                <td style="text-align: center;font-size:14px;font-weight:normal;">รายละเอียด
                                                </td>

                                                <td style="text-align: center;font-size:14px;font-weight:normal;"
                                                    width="8%">
                                                    <a class="btn btn-success fa fa-plus-square addRow2"
                                                        style="color:#FFFFFF;"></a>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody2">
                                            <tr height="20">
                                                <?php $number = 0; ?>
                                                @foreach ($internalcontrol_subsubs as $internalcontrol_subsub)
                                                    <?php $number++; ?>
                                                    <td style="text-align: center;font-size:14px;font-weight:normal;">
                                                        {{ $number }} </td>
                                                    <td>
                                                        <input name="INTERNALCONTROL_SUBSUB_NAME[]"
                                                            id="INTERNALCONTROL_SUBSUB_NAME[]" class="form-control input-sm"
                                                            style=" font-family: 'Kanit', sans-serif;font-size:14px;font-weight:normal;"
                                                            value="{{ $internalcontrol_subsub->INTERNALCONTROL_SUBSUB_NAME }}">
                                                    </td>

                                                    <td style="text-align: center;"><a
                                                            class="btn btn-danger fa fa-trash-alt remove"
                                                            style="color:#FFFFFF;"></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>





                    <div class="modal-footer">
                        <div align="right">

                            <button type="submit" id="button" class="btn btn-hero-sm btn-hero-info savebtn"><i
                                    class="fas fa-save mr-2"></i>บันทึกข้อมูล</button>
                            <a href="{{ url('manager_risk/internalcontrol') }}"
                                onclick="return confirm('ต้องการที่จะยกเลิกข้อมูล ?')"
                                class="btn btn-hero-sm btn-hero-danger cancel"><i
                                    class="fas fa-window-close mr-2"></i>ยกเลิก</a>
                        </div>

                    </div>
                    </form>
                    <!-- <button  class="btn btn-warning savebtn" >Add Alert</button> -->


                @endsection

                @section('footer')

                    <script src="{{ asset('datepicker/bootstrap-3.3.7-dist/js/bootstrap.js') }}"></script>
                    <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
                    <script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8">
                    </script>

                    <!-- Page JS Plugins -->
                    <script src="{{ asset('asset/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
                    <script src="{{ asset('asset/js/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
                    <script src="{{ asset('asset/js/plugins/chart.js/Chart.bundle.min.js') }}"></script>
                    <!-- Page JS Code -->
                    <script src="{{ asset('asset/js/pages/be_comp_charts.min.js') }}"></script>
                    <script>
                        jQuery(function() {
                            Dashmix.helpers(['easy-pie-chart', 'sparkline']);
                        });

                    </script>

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
                    <!-- Page toastr Alert -->
                    <script src="{{ asset('js/toastr.min.js') }}"></script>
                    <!-- Page ckeditor -->
                    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
                    <script src="{{ asset('js/sweetalert.js') }}" rel="stylesheet"> </script>
                    <scrip>
                        @if (session('status'))
                            alert('{{ session('status') }}')
                        @endif
                    </scrip>

                    <script>
                        CKEDITOR.replace('myeditor', {});

                    </script>
                    <script>
                        CKEDITOR.replace('myeditor2', {});

                    </script>

                    <script>
                        $(document).ready(function() {
                            $('.datepicker').datepicker({
                                format: 'dd/mm/yyyy',
                                todayBtn: true,
                                language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                thaiyear: true,
                                autoclose: true //Set เป็นปี พ.ศ.
                            }); //กำหนดเป็นวันปัจุบัน

                        });
                        $('.addRow').on('click', function() {
                            addRow();
                        });

                        function addRow() {
                            var count = $('.tbody1').children('tr').length;
                            var tr = '<tr>' +
                                '<td style="text-align: center;font-size:14px;font-weight:normal;">' +
                                (count + 1) +
                                '</td>' +
                                '<td>' +
                                '<input name="INTERNALCONTROL_OBJECTIVE[]" id="INTERNALCONTROL_OBJECTIVE[]" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;font-size:14px;font-weight:normal;" >' +
                                '</td>' +

                                '<td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>' +
                                '</tr>';
                            $('.tbody1').append(tr);
                        };

                        $('.tbody1').on('click', '.remove', function() {
                            $(this).parent().parent().remove();
                        });

                        $('.addRow2').on('click', function() {
                            addRow2();
                        });

                        function addRow2() {
                            var count = $('.tbody2').children('tr').length;
                            var tr = '<tr>' +
                                '<td style="text-align: center;font-size:14px;font-weight:normal;">' +
                                (count + 1) +
                                '</td>' +
                                '<td>' +
                                '<input name="INTERNALCONTROL_SUBSUB_NAME[]" id="INTERNALCONTROL_SUBSUB_NAME[]" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;font-size:14px;font-weight:normal;">' +
                                '</td>' +

                                '<td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>' +
                                '</tr>';
                            $('.tbody2').append(tr);
                        };

                        $('.tbody2').on('click', '.remove', function() {
                            $(this).parent().parent().remove();
                        });

                        $('.budget').change(function() {
                            if ($(this).val() != '') {
                                var select = $(this).val();
                                var _token = $('input[name="_token"]').val();
                                $.ajax({
                                    url: "{{ route('admin.selectbudget') }}",
                                    method: "GET",
                                    data: {
                                        select: select,
                                        _token: _token
                                    },
                                    success: function(result) {
                                        $('.date_budget').html(result);
                                        datepick();
                                    }
                                })
                                // console.log(select);
                            }
                        });

                    </script>

                @endsection
