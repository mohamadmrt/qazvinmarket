@extends('ocms.master')

@section('content')
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div class="row">

                <h5 style="margin-top: 20px;">برای شروع فعالیت در سامانه لطفا از منو، گزینه مورد نظر خود را انتخاب کنید.</h5>
                <hr>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panels panels-default text-center ">
                            <i style="padding: 7px;color: grey;font-size: 100px" class="fas fa-file-invoice-dollar"></i>
                            <hr style="margin: 0;padding: 0px;">
                            <div class="panel-body" style="padding: 7px;"><a style="text-decoration: none;">مبلغ کل خرید :  <?php
                                    ?> تومان  </a></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panels panels-default text-center ">
                            <i style="padding: 7px;color: grey;font-size: 100px" class="fas fa-credit-card"></i>
                            <hr style="margin: 0px;padding: 0px;">
                            <div class="panel-body" style="padding: 7px;">
                                <a href="#">
                                    <span style="padding-left: 40px;">تعداد تراکنش</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panels panels-default text-center">
                            <i style="padding: 7px;color: grey;font-size: 100px" class="fas fa-list-ul"></i>
                            <hr style="margin: 0px;padding: 0px;">
                            <div class="panel-body" style="padding: 7px;">
                                <a href="#">
                                    <span style="padding-left: 40px;">تعداد خرید</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="panels panels-default text-center ">
                            <i style="padding: 7px;color: grey;font-size: 100px" class="fas fa-users"></i>
                            <hr style="margin: 0px;padding: 0px;">
                            <div class="panel-body" style="padding: 7px;"><a href="#">  تعداد کاربر : <span><?php  ?></span> </a></div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panels panels-default text-center ">
                            <i style="padding: 7px;color: grey;font-size: 100px" class="fas fa-star"></i>
                            <hr style="margin: 0px;padding: 0px;">
                            <div class="panel-body" style="padding: 7px;"><a href="#">  تعداد سوپرمارکت : <span><?php  ?></span> </a></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
