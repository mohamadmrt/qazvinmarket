@extends('ocms.master')

@section('content')
    <div class="col-md-10" style="padding-top:5px;padding-left: 40px;">
        <div align="center">
            <div class="panel panel-default panel-table radius2px">
                <div class="panel-body">
                    <form action="{{route('markets.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="credit-head">
                            <h4 >افزودن سوپرمارکت جدید</h4>
                        </div>
                        <hr>
                        <div style="text-align: right">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-4" style="text-align: right">
                            <div class="form-group">
                                <label for="name">نام سوپرمارکت :</label>
                                <input id="name" name="name" class="form-control" type="text" value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label for="type_resturant">نوع سوپرمارکت :</label>
                                <select id="type_resturant" name="type_resturant" class="form-control" >
                                    <option value="fruit" >نان و میوه</option>
                                    <option value="meat" >مرغ و گوشت</option>
                                    <option value="snack" >صبحانه و عصرانه</option>
                                    <option value="classic"  >سوپرمارکتهای سنتی</option>
                                    <option value="int" >سوپرمارکتهای ملل و محلی</option>
                                    <option value="fastfood" >سوپرمارکتهای فرنگی</option>
                                    <option value="pastry" >شیرینی و آجیل</option>
                                    <option value="coffeshop" >کافی شاپ ها</option>
                                    <option value="supermarket" >سوپر مارکت</option>
                                    <option value="service" >سرویس</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address_full">آدرس کامل :</label>
                                <input id="address_full" name="address_full" class="form-control" type="text" value="{{old('address_full')}}">
                            </div>
                            <div class="form-group">
                                <label for="address">آدرس کوتاه :</label>
                                <input id="address" name="address" class="form-control" type="text" value="{{old('address')}}">
                            </div>
                            <div class="form-group">
                                <label for="tel">شماره تماس سوپرمارکت :</label>
                                <input id="tel" name="tel" class="form-control" type="text" value="{{old('tel')}}">
                            </div>
                            <div class="form-group">
                                <label for="mobile">شماره تماس های همراه :</label>
                                <input id="mobile" name="mobile" class="form-control" type="text" placeholder="شماره تلفن ها را با کاراکتر - از هم جدا کنید" value="{{old('mobile')}}">
                            </div>
                            <div class="form-group">
                                <label for="deliver_type">نوع پیک :</label>
                                <select id="deliver_type" name="deliver_type" class="form-control" >
                                    <option value="motor">موتور</option>
                                    <option value="car">ماشین</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="discount_ghasedak">سهم قاصدک :</label>
                                <input id="discount_ghasedak" name="discount_ghasedak" class="form-control" type="text" value="{{old('discount_ghasedak')}}">
                            </div>
                            <div class="form-group">
                                <label for="description">توضیحات :</label>
                                <input id="description" name="description" class="form-control" type="text" value="{{old('description')}}">
                            </div>
                            <div class="form-group">
                                <label for="gps">موقعیت جغرافیایی :</label>
                                <input id="gps" name="gps" class="form-control" type="text" value="{{old('gps')}}">
                            </div>
                            <div class="form-group">
                                <label for="min_price">حداقل سفارش گیری:</label>
                                <input id="min_price" name="min_price" class="form-control" type="text" value="{{old('min_price')}}">
                            </div>
                            <div class="form-group">
                                <label for="min_price">تنظیمات امکان پیش سفارش:</label><br>
                                {{--<input id="min_price" name="min_price" class="form-control" type="text" value="{{old('min_price')}}">--}}
                                <input type="radio" name="pOrder"  value="porder" > سفارش اکنون و آینده
                                <input type="radio" name="pOrder"  value="justporder" > سفارش فقط در آینده
                                <input type="radio" name="pOrder"  value="now" > سفارش فقط اکنون
                            </div>


                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-4" style="text-align: right">
                            <div class="form-group">
                                <label for="discount_customer">تخفیف سوپرمارکت :</label>
                                <input id="discount_customer" name="discount_customer" class="form-control" type="text" value="{{old('discount_customer')}}">
                            </div>
                            <div class="form-group">
                                <label for="username">نام کاربری :</label>
                                <input id="username" name="username" class="form-control" type="text" placeholder="نام کاربری حداقل 6 کاراکتر" value="{{old('username')}}">
                            </div>
                            <div class="form-group">
                                <label for="password">پسورد :</label>
                                <input id="password" name="password" class="form-control" type="text" placeholder="رمز عبور حداقل 6 کاراکتر" value="{{old('password')}}">
                            </div>
                            <div class="form-group">
                                <label for="picture">تصویر سوپرمارکت :</label>
                                <input id="picture" name="picture"  type="file" >
                            </div>
                            <div class="form-group">
                                <label for="vat">مالیات :</label>
                                <select id="vat" name="vat" class="form-control" >
                                    <option value="0">غیر فعال</option>
                                    <option value="1">فعال</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="show">وضعیت نمایش در سایت :</label>
                                <select id="show" name="show" class="form-control">
                                    <option value="0">غیر فعال</option>
                                    <option value="1">فعال</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="vote">نظرسنجی :</label>
                                <select id="vote" name="vote" class="form-control">
                                    <option value="0">فعال</option>
                                    <option value="1">غیر فعال</option>
                                </select>
                            </div>
                            <div class="form-group col-md-7" style="padding-right: 0px">
                                <label for="account_name">نام صاحب حساب :</label>
                                <input id="account_name" name="account_name" class="form-control" type="text" value="{{old('account_name')}}">
                            </div>
                            <div class="form-group col-md-5" style="padding-left: 0px">
                                <label for="bank_name">نام بانک :</label>
                                <input id="bank_name" name="bank_name" class="form-control" type="text" value="{{old('bank_name')}}">
                            </div>
                            <div class="form-group">
                                <label for="account_number">شماره حساب :</label>
                                <input id="account_number" name="account_number" class="form-control" type="text" value="{{old('account_number')}}">
                            </div>
                            <div class="form-group">
                                <label for="mobile_clearing">موبایل تسویه:</label>
                                <textarea id="mobile_clearing" name="mobile_clearing" class="form-control text-left" > {{old('mobile_clearing')}} </textarea>
                            </div>
                            <div class="form-group">
                                <label for="peyk_id">منطقه پیک :</label>
                                <select id="peyk_id" name="peyk_id" class="form-control">
                                    @foreach($peyks as $peyk)
                                        <option value="{{$peyk->id}}">{{$peyk->zones}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-1"></div>

                        <div id="error_register" class="row col-md-12 error-log"></div>

                        <div class="col-md-12">
                            <br>
                            <div class="form-group" style="text-align: center">
                                <div class=" ">
                                    <a href="{{route('markets.index')}}" class="btn btn-danger">لغو</a>

                                    <input type="submit" id="register" name="register" value="ذخیره" class="btn btn-primary info">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

@endsection
