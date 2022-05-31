
@extends('layouts.youtube')
            
@section('content')         
            
            <div class="container mt-5"> 
                <div class="row">
                    <div class="col-md-4 ">
                            <div class="card mb-4" style="width:100%">
                                <iframe width="350" height="260" src="https://www.youtube.com/embed/kEFt7NFQMwA" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                                <div class="card-body ">
                                    <h5 class="card-title">#Ep 2.การกำหนดสิทธิ์การใช้งาน</h5>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 ">
                            <div class="card mb-4" style="width:100%">
                                <iframe width="350" height="260" src="https://www.youtube.com/embed/lLuP5FwjVO0" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                                <div class="card-body ">
                                    <h5 class="card-title">#Ep 3.การตั้งค่าข้อมูลการลา</h5>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 ">
                            <div class="card mb-4" style="width:100%">
                                <iframe width="350" height="260" src="https://www.youtube.com/embed/kteNh2lEVgg" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                                <div class="card-body ">
                                    <h5 class="card-title">#Ep 5.การตั้งค่าหน่วยงาน</h5>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 ">
                            <div class="card mb-4" style="width:100%">
                                <iframe width="350" height="260" src="https://www.youtube.com/embed/qEK8ERrq-NM" frameborder="0" allowfullscreen ng-show="showvideo"></iframe>
                                <div class="card-body ">
                                    <h5 class="card-title">#Ep 6.การตั้งค่า Line Notify</h5>
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </a>
                    </div>
                   
                </div>

            </div>
                
    
            
        

            @endsection

            @section('footer')

            @endsection
