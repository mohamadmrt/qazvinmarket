@extends('user.master')
@push('style')
    <style>
        .col-md-4:hover{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
@endpush
@section('content')
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 bg-success" >
                <a class="btn btn-block" href="{{route('user.buyList')}}" >
                    <div class="panel-header pull-left text-center">
                        <i class="fas fa-eye text-success"></i>
                    </div>
                    <i class="fas fa-clipboard-list text-primary" style="font-size: 60px;padding: 10px"></i>
                    <hr style="margin: 0px;padding: 0px;">
                    <div class="panel-body" style="padding: 7px;">
                        <span style="padding-left: 40px;">کل سفارشات</span>
                        <span style="border-radius: 10px;padding-right: 7px;padding-left: 7px;border: 1px solid #f0f0f0;" id="order"></span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 bg-info">
                <a class="btn btn-block" href="{{route('user.credit')}}">
                    <div class="panel-header pull-left text-center">
                        <i class="fas fa-plus-circle text-success"></i>
                    </div>
                    <i class="fas fa-sack-dollar text-primary" style="font-size: 60px;padding: 10px"></i>
                    <hr style="margin: 0px;padding: 0px;">
                    <div class="panel-body" style="padding: 7px;"> اعتبار کیف پول شما : <span id="wallet"></span> تومان  </div>
                </a>
            </div>
            <div class="col-md-4 bg-danger">
                <a class="btn btn-block" href="{{route('user.transactionList')}}">
                    <div class="panel-header pull-left text-center">
                        <i class="fas fa-eye text-success"></i>
                    </div>
                    <i class="fas fa-credit-card-front text-primary" style="font-size: 60px;padding: 10px"></i>
                    <hr style="margin: 0px;padding: 0px;">
                    <div class="panel-body" style="padding: 7px;"><span style="padding-left: 40px;">کل تراکنش ها</span><span style="border-radius: 10px;padding-right: 7px;padding-left: 7px;border: 1px solid #f0f0f0; " id="transactionCount"></span>
                    </div>
                </a>
            </div>

            <div class="col-md-4 bg-warning">
                <a class="btn btn-block" href="{{route('user.point')}}">
                    <div class="text-center ">
                        <div class="panel-header pull-left">
                            <i class="fas fa-eye text-success"></i>
                        </div>
                        <i class="far fa-star text-primary" style="font-size: 60px;padding: 10px"></i>
                        <hr style="margin: 0;padding: 0;">
                        <div class="panel-body" style="padding: 7px;">  امتیاز شما : <span id="point"></span> </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
