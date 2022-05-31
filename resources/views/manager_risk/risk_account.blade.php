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

        label {
            font-family: 'Kanit', sans-serif;
            font-size: 10px;
            font-size: 1.0rem;
        }

        @media only screen and (min-width: 1200px) {
            label {
                /* float: right; */
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

    function timeformate($strtime)
    {
    [$a, $b] = explode(':', $strtime);
    return $a . ':' . $b;
    }
    ?>
    <center>
        <div class="block shadow-lg mt-5" style="width: 95%;">
            <div class="block block-rounded block-bordered">
                <div class="block-header block-header-default">
                    <div align="left">
                        <h2 class="block-title" style="font-family:'Kanit',sans-serif;font-size:17px;font-weight:normal;">
                            <B>บัญชีความเสี่ยง</B></h2>
                    </div>
                  
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="gwt-table table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                            <thead style="background-color: #FFEBCD;">
                                <tr height="40">
                                    <th class="text-font" style="text-align: center;" width="5%">ลำดับ</th>
                                    <th class="text-font" style="text-align: center;" >ประเด็นความเสี่ยง</th>
                                    <th class="text-font" style="text-align: center;" >ความเสี่ยง</th>
                                    <th class="text-font" style="text-align: center;" >การควบคุมภายในที่มีอยู่</th>
                                 
                                    <th class="text-font" style="text-align: center;" > กลยุทธ์การจัดการ</th>
                                    <th class="text-font" style="text-align: center;" width="5%">คำสั่ง</th>
                                </tr >
                            </thead>
                            <tbody>
                                <?php $number = 0; ?>
                                @foreach ($infomations as $infomation)
                                <?php
                                $number++;
                          ?>
                          
                                    <tr height="40">                       
                                        <td class="text-font" style="text-align: center;font-size: 13px;" align="center">{{$number}}</td>
                                    
                                        <td class="text-font text-pedding" style="text-align: left;font-size: 13px;" >{{$infomation->RISK_ACC_ISSUE}}</td>
                                        <td class="text-font text-pedding" style="text-align: left;font-size: 13px;" >{{$infomation->RISK_ACC_RISK}}</td>
                                        <td class="text-font text-pedding" style="text-align: left;font-size: 13px;" >{{$infomation->RISK_ACC_CONTROLS}}</td>
    
                                        <td class="text-font text-pedding" style="text-align: left;font-size: 13px;" >{{$infomation->RISK_ACC_MANAGE}}</td>
                            
                                        <td align="center" width="5%">
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-outline-info dropdown-toggle"
                                                    id="dropdown-align-outline-info" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false"
                                                    style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;">
                                                    ทำรายการ
                                                </button>
                                                <div class="dropdown-menu" style="width:10px">                                              
                                               
                                                        <a class="dropdown-item" 
                                                        href="{{ url('manager_risk/risk_account_incidence/'. $infomation->RISK_ACC_ID) }}" style="font-family:'Kanit',sans-serif;font-size:13px;font-weight:normal;">อุบัติการณ์ความเสี่ยง</a>
                                               
                        
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
    
    
    
                                    @endforeach 
                               
                            </tbody>
                        </table>
                                     
    <br><br><br>
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

        <script>
            function detail(id) {
                $.ajax({
                    url: "{{ route('suplies.detailapp') }}",
                    method: "GET",
                    data: {
                        id: id
                    },
                    success: function(result) {
                        $('#detail').html(result);
                    }
                })
            }
            $(document).ready(function() {

                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    todayBtn: true,
                    language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                    thaiyear: true,
                    autoclose: true //Set เป็นปี พ.ศ.
                }); //กำหนดเป็นวันปัจุบัน
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
                }
            });

            function chkmunny(ele) {
                var vchar = String.fromCharCode(event.keyCode);
                if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
                ele.onKeyPress = vchar;
            }

        </script>

    @endsection
