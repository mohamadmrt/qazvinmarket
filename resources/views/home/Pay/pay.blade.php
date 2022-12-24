@extends('home.master',array('paypage'=>__('messages.pay.register_order')))
@push('style')
    <link href="{{asset('assets/css/style-pay.css?v=5')}}" rel="stylesheet" type="text/css">
    <script     src="https://www.parsimap.com/js/v3.1.0/parsimap.js?key=public"></script>
@endpush
@section('header')
    <section class="menu-bg" style="height: 6rem;background-image: url('images/ui_images/back.jpg?m=1');background-repeat: repeat; background-position:right;">
    </section>
@endsection

@section('content')
    <div id="AddressModal" class="modal fade "  role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form" id="AddressForm" role="form" >
                    <input type="hidden" id="id">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="title">افزودن آدرس</h4>
                    </div>
                    <div class="modal-body ">
                        <div class="form-group">
                            <label for="type"  class="pull-right">عنوان آدرس (مثلا منزل):</label>
                            <input type="text"  style="text-align: right" class="form-control" name="type" id="label" >
                        </div>
                        <div class="form-group">
                            <label for="zones" class="pull-right">منطقه پیک:</label><br>
                            <span class="text-danger" id="zones_error"></span>
                            <select name="zones"  id="zones" required="" style="width:100%; padding:5px; border:#999 1px solid;">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address" class="pull-right">آدرس دقیق:</label>
                            <p id="address_error" class="text-danger"></p>
                            <input type="text" class="form-control" name="address"  id="address" value="">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="set_type" id="is_default">
                            <label for="set_type">آدرس پیش فرض </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" title="اعمال تغییرات" id="update" style="display: none"><i class="far fa-save"></i> ذخیره</button>
                        <button type="button" class="btn btn-success" title="ذخیره" id="save" style="display: none"><i class="far fa-save"></i> ذخیره</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" title="خروج">&times; خروج</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container" id="return">
        <div class="row">
            <h3 class="text-center col-md-12 col-sm-12" style="margin-top: 40px;">سبد خرید</h3>
        </div>
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">سفارش شما</div>
                <div class="panel-body">
                    <form class="form-horizontal"  id="orderForm" role="form" method="post">
                        <div class="row befor" id="priceDiv"><br>
                            <div class=" col-md-12 col-sm-12 col-xs-12 well">
                                <div class="row" id="cargo_list">
                                </div>
                            </div>

                        </div>

                        <div class="alert alert-dismissable alert-danger" id="errors" style="display: none">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">نام و نام خانوادگی :</label>
                            <div class="col-sm-9">
                                <input  type="text" class="form-control font-ios" name="name" id="name" value="" placeholder="نام و نام خانوادگی">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tel"> شماره تلفن همراه :</label>
                            <div class="col-sm-9">
                                <input type="text" maxlength="11" class="form-control font-ios" name="tel" id="tel" value="" placeholder="شماره همراه">
                            </div>
                        </div>


                        <div class="form-group">
                            <div id="addressDiv">
                                <label class="control-label col-sm-2" for="address" style="padding-right: 10px;">  آدرس ارسال سفارش:</label>
                                <div class="col-sm-9">
                                    <div class="input-group" style="padding-bottom: 10px">
                                        <a href="#" class="btn btn-danger font-ios"  id="addAddress"><i class="fas fa-map-marker-plus"></i>افزودن آدرس</a>
                                    </div>
                                    <div class="input-group" id="addresses_list"></div>
                                </div>
                            </div>
                            <div class="">
                                <label class="control-label col-sm-2" for="address">روش ارسال:</label>
                                <div class="col-sm-9">
                                    <input type="radio" name="sendMethod" id="expressRadio" data-type="express" onchange="_calculateShipment()" checked><span>فوری</span>&nbsp;<span id="express"></span><br>
                                    <input type="radio" name="sendMethod" id="scheduledRadio" data-type="scheduled" onchange="_calculateShipment()" ><span>زمانبندی</span>&nbsp;<span id="scheduled"></span>
                                    <select class="form-control" id="days" onchange="_showHours()" style="display: none"></select>
                                    <select class="form-control"  id="hours" style="display: none"></select>
                                    <br>
                                    <input type="radio" name="sendMethod" id="verbalRadio" data-type="verbal" onchange="_calculateShipment()" ><span>مراجعه و دریافت حضوری</span><span id="verbal_address" style="font-weight: bold;color: darkred"></span>&nbsp;<span id="verbal"></span>
                                    <div class="form-group d-none" id="getInResDiv" style="display: none">
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <label class="control-label col-sm-2" for="comment">توضیحات:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control font-ios"   name="comment" id="comment" placeholder="توضیحات اختیاری است">
                                </div>
                            </div>
                        </div>

                        <div class="form-group discount_no d-none">
                            <label class="control-label col-sm-2" for="discountCode"> </label>
                        </div>

                        <div class="form-group discount d-none" >
                            <label class="control-label col-sm-2" for="discountCode">مبلغ با تخفیف:</label>
                            <div class="col-sm-5" id="coupon_invalid">
                                <h4   style="background-color:#5CB85C;color: #ffffff;border-radius: 3px; padding: 5px;"> <span class="dicount_price">0</span></h4>
                            </div>
                        </div>
                        <div class="form-group deducted d-none" >
                            <label class="control-label col-sm-2" for="deducted_price">مبلغ کسر شده:</label>
                            <div class="col-sm-5" id="deducted_price">
                                <h4   style="background-color:#9944b8;color: #ffffff;border-radius: 3px; padding: 5px;"> <span class="deducted_price">0</span></h4>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="discountCode">کد تخفیف:</label>
                            <div class="col-sm-5">
                                <input  type="text" class="form-control font-ios" name="discountCode" id="discountCode" placeholder="کد تخفیف "  value="@if (session()->has('referral')){{session()->get('referral')}}@endif"   maxlength="15">
                            </div>
                            <div class="col-md-2"  style="padding-bottom: 20px">
                                <input  type="button" name="gift" id="gift" onclick="coupon();"  value="اعمال تخفیف" class="btn btn-primary info font-ios">
                            </div>

                        </div>
                        <div class="col-md-3 col-md-offset-1 col-sm-12 col-xs-12 label label-success" style="margin-top:10px; margin-bottom:20px;">
                            <h4><span id="totalPrice"></span>&nbsp;<span id="priceUnit"></span></h4>
                        </div>

                        <div class="col-md-offset-1 col-md-6 col-sm-12 col-xs-12 well">
                            جمع کل سفارش بدون تخفیف :
                            <span id="totalPrice_without_saleoff"></span>
                            تومان +
                            هزینه ارسال :
                            <span id="peyk_price">0</span> تومان
                            <br>
                            <div style="color: green;font-size: 18px;text-align: center;padding-top: 7px">تخفیفی که اعمال شد :
                                <span id="total_dicount"></span> تومان</div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pay"> روش پرداخت :</label>
                            <div class="col-sm-9">
                                {{--                                    wallet--}}
                                @if(\Illuminate\Support\Facades\Auth::guard('user')->check())
                                    <label  class="radio-inline">
                                        <input   type="radio" name="pay" value="3" id="walletMethod" class="font-ios">موجودی کیف پول شما: <span id="wallet" style="color: #D84105 !important;"></span><span style="color: #D84105 !important;"> تومان</span>
                                    </label>
                                    <br>
                                @endif
                                {{--ipg--}}
                                <label class="radio-inline"><input type="radio" name="pay" checked value="1" class="font-ios">پرداخت اینترنتی
                                    <span style="color:#990000 ">(درگاه بانک ملت، پذیرنده کلیه کارتهای بانکی.)</span>
                                </label>
                                <br>
                                {{--                                        cash--}}
                                <label class="radio-inline"><input type="radio" name="pay" id="cash" value="4" class="font-ios">پرداخت نقدی هنگام تحویل کالا
                                    <span style="color:#990000 ">(کارتخوان موجود است.)</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-10 col-sm-2" style="padding-top: 25px;padding-bottom: 25px">
                                <input type="submit" name="request"  id="request" value="ثبت سفارش" class="btn btn-primary info font-ios">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click','#addAddress',function (e) {
            e.preventDefault();
            $('#update').hide();
            $('#title').text('افزودن آدرس');
            $('#save').show();
            $('#AddressModal').modal('show')
        });

        $('#tel').keypress(function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57) && (event.which < 1776 || event.which > 1785)) {
                event.preventDefault();
            }
        });
        $(document).ready(function () {
            if (localStorage.getItem('cargos')!==null){
                if (localStorage.getItem('cargos').length<0){
                    window.location.replace('/')
                }
            }
            render_cargos_pay();
            get_post_area();
            _wallet();
            _loadMarketInfo()

            if(localStorage.getItem('username')!==null){
                $('#name').val(localStorage.getItem('username'))
            }
            if(localStorage.getItem('mobile')!==null){
                $('#tel').val(localStorage.getItem('mobile'))
            }
            if(localStorage.getItem('cash')!==null){
                let status=localStorage.getItem('cash')
                if (status==='true'){
                    $('#cash').prop('disabled',false)
                }else{
                    $('#cash').prop('disabled',true)
                }

            }
            if(localStorage.getItem('express')!==null){
                let express_status=localStorage.getItem('express')
                if (express_status==='true'){
                    $('#expressRadio').prop('disabled',false)
                }else{
                    $('#expressRadio').prop('disabled',true).prop('checked',false)
                }

            }
            _updateAddress();
            $("#AddressModal").on('hide.bs.modal', function(){
                _emptyVal()
            });
        });
        function _updateAddress () {
            if(localStorage.getItem('addresses')!==null){
                let addresses= JSON.parse(localStorage.getItem('addresses'));
                addresses.sort((a, b) => (a.is_default > b.is_default) ? 1 : -1 )
                let data='';
                $.each(addresses,function (key,item) {
                    data+=`<div class="input-group" ><span class="input-group-addon"><input type="radio" onchange="_calculateShipment()" ${item.is_default==='1'?'checked':''} ${addresses.length===1?'checked':''} data-zones=${item.peyk_id} name="address"></span><input  type="text" class="form-control font-ios addressColor" readonly  id="${item.id}" style="${item.is_default === "1" || addresses.length===1 ?"background-color:#a7eea0" : ''}" value="${item.label.length>0?item.label+' - ':'آدرس: '}  ${item.address}"><div class="input-group-btn"><a title="حذف" class="btn btn-danger" onclick="_deleteAddress('${item.address}',${item.id})">&times;</a><a title="ویرایش" class="btn btn-success" onclick="_editAddress('${item.address}',${item.id})"><i class="fas fa-pencil"></i></a></div></div>`;
                })
                $('#addresses_list').html(data).css('display','block');
            }else{
                $('#addresses_list').css('display','none')
            }
        }
        function _deleteAddress(address,id) {
            if (id===0){
                let addresses=JSON.parse(localStorage.getItem('addresses'));
                addresses.splice(addresses.findIndex(x=>x.address===address),1);
                localStorage.setItem('addresses',JSON.stringify(addresses));
                swal({
                    title: 'حذف شد!',
                    text: 'آدرس مورد نظر حذف شد',
                    type: 'success',
                    confirmButtonText: 'باشه'
                })
                _updateAddress();
            }else{
                let token=localStorage.getItem('token')
                $.ajax({
                    type: "POST",
                    url: `/api/v1/address/${id}`,
                    data:{"_method":"DELETE",token},
                    success: function (response) {
                        if(response.status==='ok'){
                            let addresses=JSON.parse(localStorage.getItem('addresses'));
                            addresses.splice(addresses.findIndex(x=>x.id===id),1);
                            localStorage.setItem('addresses',JSON.stringify(addresses));
                            _updateAddress();
                            swal({
                                title: 'حذف شد!',
                                text: 'آدرس مورد نظر حذف شد',
                                type: 'success',
                                confirmButtonText: 'باشه'
                            })
                        }

                    }
                });
            }
        }
        function _editAddress(address) {
            $('#title').text('ویرایش آدرس');
            $('#update').show();
            $('#save').hide();
            let addresses=JSON.parse(localStorage.getItem('addresses'));
            let selectedAddress=addresses[addresses.findIndex(x=>x.address===address)];
            $('#label').val(selectedAddress.label)
            $('#address').val(selectedAddress.address)
            $('#id').val(selectedAddress.id===0?address:selectedAddress.id)
            $('#zones').val(selectedAddress.peyk_id)
            $('#is_default').prop('checked',selectedAddress.is_default === "1")
            $('#AddressModal').modal('show');
        }
        $(document).on('click','#update',function(e) {
            let id = $('#id').val();
            let addresses=JSON.parse(localStorage.getItem('addresses'));
            if (id<1){
                let selectedAddress=addresses[addresses.findIndex(x=>x.address===id)];
                selectedAddress.label=$('#label').val();
                selectedAddress.peyk_id=parseInt($('#zones').val());
                selectedAddress.address=$('#address').val();
                selectedAddress.is_default= $('#is_default').prop('checked')?"1":"0";
                addresses[addresses.findIndex(x=>x.address===address)]=selectedAddress;
                localStorage.setItem('addresses',JSON.stringify(addresses));
                _emptyVal();
                $('#AddressModal').modal('hide');
            }else {
                e.preventDefault();
                let token = localStorage.getItem('token');
                let label = $('#label').val();
                let peyk_id = $('#zones').val();
                let address = $('#address').val();
                let is_default = $('#is_default').prop('checked')
                let url = "api/v1/address";
                let method = "POST";
                if (id !== "") {
                    url = "api/v1/address/" + id;
                    method = "PUT";
                }
                if(address.length<10){
                    $('#address').addClass('error')
                }else{
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            token,
                            "_method": method,
                            label,
                            peyk_id,
                            address,
                            is_default
                        },
                        success: function (response) {
                            if (response.status === 'ok') {
                                let selectedAddress=addresses[addresses.findIndex(x=>x.id===parseInt(id))];
                                selectedAddress.label=$('#label').val();
                                selectedAddress.peyk_id=$('#zones').val();
                                selectedAddress.address=$('#address').val();
                                selectedAddress.is_default= $('#is_default').prop('checked')?"1":"0";
                                addresses[addresses.findIndex(x=>x.id===parseInt(id))]=selectedAddress;
                                localStorage.setItem('addresses',JSON.stringify(addresses))
                                _updateAddress();
                                _emptyVal();
                                $('#AddressModal').modal('hide');
                            }
                        },
                        error:function () {
                            alert("خطا در عملیات! لطفاً با پشتیبانی تماس بگیرید.")
                        }
                    });
                }
            }
            _updateAddress()
        });
        $(document).on('click','#expressRadio',function () {
            $('#days').hide()
            $('#hours').hide()
            $('#getInResDiv').hide();
            $('#verbal_address').hide();

        });
        $(document).on('click','#scheduledRadio',function () {
            $('#verbal').hide()
            $('#verbal_address').hide()
            $.ajax({
                method: 'GET',
                url: "{{url('api/v1/pre_order')}}",
                data: {},
                success:function (response) {
                    if (response.length>0){
                        localStorage.setItem('scheduler',JSON.stringify(response))
                        let days='<option value="">انتخاب روز</option>';
                        $.each(response,function (key,item) {
                            days+=`<option value="${item.id}" >${item.name}</option>`;
                        });
                        $('#days').html(days).show()

                    }else{
                        $('#days').hide()
                        $('#hours').hide()
                        alert('امکان ارسال زمانبندی وجود ندارد')
                    }
                },

            });
            $('#preOrderDiv').show();
        });
        $(document).on('click','#verbalRadio',function () {
            $('#days').html("").hide()
            $('#hours').html("").hide()
            $.ajax({
                method: 'GET',
                url: "{{url('api/v1/verbal_order')}}",
                data: {},
                success:function (response) {
                    if (response.status==='ok'){
                        let verbal_intervals='<label class="control-label col-sm-2" for="deliver_time">ساعت مراجعه:</label>';
                        localStorage.setItem('verbal',JSON.stringify(response.data))
                        $('#getInResDiv').html(verbal_intervals).show()
                        $('#verbal_address').html(" ("+response.address+") ").show()
                    }else{
                        alert('زمان مناسب برای دریافت حضوری وجود ندارد')
                    }
                },
                error:function (response) {
                    alert(response.responseJSON.message)
                }
            })
        });
        let redirect_pay = function(url, method) {
            let form = document.createElement('form');
            form.method = method;
            form.action = url;
            document.body.appendChild(form);
            form.submit();
        };
        function _showHours(){
            let id=parseInt($('#days').val());
            let scheduler=JSON.parse(localStorage.getItem('scheduler'));
            let hours='<option value="">انتخاب کنید</option>';
            $.each(scheduler,function (key,item) {

                if(item.id===id) {
                    $.each(item.times, function (index, times) {
                        hours += `<option  data-id=${times.id} value="${times.name}">${times.name}</option>`;
                    })
                }

            })
            $('#hours').html(hours).show()
        }
        $('#orderForm').on('submit',function (e) {
            $('#errors').html('').hide()
            e.preventDefault(e);
            let name=$("#name").val();
            let tel=$("#tel").val();
            let peyk_id=0;
            let address="";
            let sendMethod='';
            let validate=true;
            let errors='';
            let comment=$('#comment').val();
            let bank=1;
            $("input:radio[name=pay]:checked").each(function () {
                bank= $(this).val();
            });
            $("input:radio[name=sendMethod]:checked").each(function () {
                sendMethod= $(this).data('type');
            });
            $("input:radio[name=address]:checked").each(function () {
                peyk_id= $(this).data('zones');
                address=$(this).parent().parent().find("input:nth-child(2)").val()
            });
            if(name.length<3){
                errors+="<li>حداقل سه حرف را برای نام وارد نمایید.</li>"
                validate=false;
            }
            if(tel.length<11){
                errors+="<li>موبایل را بدرستی وارد نمایید</li>"
                validate=false;
            }

            if(address.length<10){
                errors+="<li>آدرس را انتخاب کنید حداقل طول آدرس باید 10 حرف باشد</li>"
                validate=false;
            }
            if (sendMethod===''){
                errors+='<li>لطفاً روش ارسال را بدرستی انتخاب نمایید</li>';
                validate=false;
            }
            let deliver_time="0";
            let deliver_day="0";
            if(sendMethod==='verbal'){
                deliver_time=$('#deliver_time option:selected').text()
            }
            if(sendMethod==='scheduled'){
                deliver_day=$('#days option:selected').text()
                deliver_time=$('#hours option:selected').text()
            }
            if (sendMethod==='scheduled' &&  (deliver_time==="0" || deliver_time==="انتخاب روز - " || $('#hours option:selected').text()==='') ){
                errors+='<li>لطفاً زمان ارسال را بدرستی انتخاب نمایید</li>';
                validate=false;
            }
            if(validate){
                $('.loader').attr('style','visibility:visible');
                localStorage.setItem('name',name);
                localStorage.setItem('tel',tel);
                localStorage.setItem('peyks',peyk_id);
                let discountCode=$('#discountCode').val();
                let cargos = [];
                let items={};
                $.each(JSON.parse(localStorage.getItem('cargos')),function (key,item) {
                    items['id']=item.id;
                    items['count']=item.count;
                    items['main_price']=item.main_price;
                    cargos.push(items)
                    items={};
                });
                let data={
                    name,
                    tel,
                    address,
                    peyk_id,
                    source:'web',
                    cargos,
                    sendMethod,
                    deliver_time,
                    deliver_day,
                    'coupon':discountCode,
                    bank,
                    comment,
                    'token':localStorage.getItem('token')
                }
                $.ajax({
                    method: 'POST',
                    url: "/api/v1/checkout",
                    data: data,
                    headers:{"source":"web"},
                    success:function (result) {
                        if(result.action==='verify'){
                            code=prompt('لطفا کد ارسالی به شماره را وارد نمایید')
                            if(code!=null && code.length===4){
                                let source='web'
                                $.ajax({
                                    headers:{source},
                                    method: 'POST',
                                    url: "/api/v1/checkout",
                                    data: {'confirm_code' : code,"order":result.order, name,
                                        tel,
                                        address,
                                        peyk_id,
                                        cargos,
                                        sendMethod,
                                        deliver_time,
                                        deliver_day,
                                        'coupon':discountCode,
                                        bank,
                                        comment,
                                        'token':localStorage.getItem('token')},
                                    success:function (response) {
                                        if(response.status==='ok'){
                                            localStorage.setItem('token',response.token)
                                            localStorage.removeItem('cargos')
                                            redirect_pay("/back/"+result.order+"?token="+response.token+"&s=w", 'post');
                                        }
                                    },
                                    error:function (response) {
                                        $('.loader').attr('style','visibility:hidden');
                                        swal({
                                            title: 'پیغام سیستم' ,
                                            text: response.responseJSON.message,
                                            type: 'error',
                                            confirmButtonText: 'باشه'
                                        })
                                    }
                                })
                            }
                            $('.loader').attr('style','visibility:hidden');
                        }
                        else if(result.action==='mellatPay'){
                            localStorage.setItem('token',result.token)
                            window.location.replace(result.payment_url)
                        }
                        else if(result.action==='wallet') {
                            redirect_pay("/back/" + result.data.order + "?token=" + result.data.token, 'post');}
                    },
                    error:function (response){
                        $('html, body').animate({
                            scrollTop: $("#return").offset().top
                        }, 500);
                        $('.loader').attr('style','visibility:hidden');
                        swal({
                            type: 'error',
                            title: response.responseJSON.message,
                            text: "تلاش مجدد",
                            confirmButtonText:"باشه",
                        });
                    }
                });
            }else{
                $('html, body').animate({
                    scrollTop: $("#errors").offset().top
                }, 500);
                $('#errors').html(errors).show()
            }
        });
        $("#zones").on('change',function () {
            $('#zones_error').text('')
            $('#zones').removeClass('error')
        })
        $("#address").on('keyup',function () {
            $('#address_error').text('')
            $('#address').removeClass('error')
        })
        $(document).on('click','#save',function(e) {
            e.preventDefault();
            let id = $('#id').val();
            let token=localStorage.getItem('token');
            let label=$('#label').val();
            let peyk_id=$('#zones').val();
            let address=$('#address').val();
            let is_default=$('#is_default').prop('checked')
            let url= "api/v1/address" ;
            let method="POST";
            if(id!=="0"){
                url= "api/v1/address/"+id;
                method="PUT";
            }
            if(peyk_id==="0"){
                $('#zones').addClass('error')
                $('#zones_error').text('منطقه ارسال سفارش را بدرستی انتخاب نمایید')
            }
            else if(address.length<10){
                $('#address').addClass('error')
                $('#address_error').text('آدرس باید حداقل شامل 10 حرف باشد')
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    data:{token,"_method":method,label,peyk_id,address,is_default},
                    success: function (response) {
                        if(response.status==='ok'){
                            let addedAddress={};
                            if(response.data.id>0){
                                addedAddress.id=response.data.id;
                            }else{
                                addedAddress.id=0;
                            }
                            addedAddress.peyk_id=peyk_id;
                            addedAddress.label=label;
                            addedAddress.address=address;
                            addedAddress.is_default=is_default?"1":"0";
                            let  addresses= [];
                            if(localStorage.getItem('addresses')!=null){
                                addresses=JSON.parse(localStorage.getItem('addresses'));
                                if(addedAddress.is_default==="1"){
                                    $.each(addresses,function (key,item) {
                                        item.is_default="0"
                                    })
                                }
                            }
                            addresses.push(addedAddress);
                            localStorage.setItem('addresses',JSON.stringify(addresses))
                            _updateAddress()
                            _emptyVal();
                            $('#AddressModal').modal('hide');
                        }
                    },
                    error:function (response) {
                        let addedAddress={};
                        addedAddress.id=Math.random();
                        addedAddress.peyk_id=peyk_id;
                        addedAddress.label=label;
                        addedAddress.address=address;
                        addedAddress.is_default=is_default?"1":"0";
                        let  addresses= [];
                        if(localStorage.getItem('addresses')!=null){
                            addresses=JSON.parse(localStorage.getItem('addresses'));
                            if(addedAddress.is_default==="1"){
                                $.each(addresses,function (key,item) {
                                    item.is_default="0"
                                })
                            }
                        }
                        addresses.push(addedAddress);
                        localStorage.setItem('addresses',JSON.stringify(addresses))
                        _updateAddress()
                        _emptyVal();
                        $('#AddressModal').modal('hide');
                    }
                });
            }
        });
        function _emptyVal() {
            $('#id').val('');
            $('#label').val('');
            $('#zones').val('');
            $('#address').val('');
            $('#is_default').prop('checked',false)
        }
        coupon = function ( ){
            let mobile = $('#tel').val();
            let peyks=0;
            $("input:radio[name=address]:checked").each(function () {
                peyks= $(this).data('zones');
            });
            let scheduledRadio=$('#scheduledRadio').is(":checked");
            let discountCode = $("#discountCode").val();
            let rid = $("#rid").val();
            let cargos = [];
            let items={};
            $.each(JSON.parse(localStorage.getItem('cargos')),function (key,item) {
                items['id']=item.id;
                items['count']=item.count;
                cargos.push(items)
                items={};
            });
            let state=true;
            let errors='';
            if(mobile.length<11){
                state=false;
                $('html, body').animate({
                    scrollTop: $("#errors").offset().top
                }, 500);
                $('#errors').html('<div class="alert alert-danger"></div>');
                errors+='<li>تلفن همراه خود را بدرستی وارد نمایید، سپس از کد تخفیف استفاده کنید.</li>'

            }

            if(peyks=== 0){
                state=false;
                $('html, body').animate({
                    scrollTop: $("#errors").offset().top
                }, 500);
                $('#errors').html('<div class="alert alert-danger"></div>');
                errors+='<li>ابتدا منطقه ارسال سفارش خود را انتخاب کنید، سپس از کد تخفیف استفاده کنید.</li>'
            }
            if(discountCode.length< 2){
                state=false;
                $('html, body').animate({
                    scrollTop: $("#errors").offset().top
                }, 500);
                $('#errors').html('<div class="alert alert-danger"></div>');
                errors+='<li>کد تخفیف را بدرستی وارد کنید ، سپس از کد تخفیف استفاده کنید.</li>'
            }
            if(!state){
                $('#errors').html(errors).show();
            }

            if(state){
                $.ajax({
                    type: "POST",
                    url: "/api/v1/coupon/"+discountCode,
                    data: { cargos:cargos ,  discountCode : discountCode , rid : rid , mobile : mobile , peyk : peyks,scheduledRadio:scheduledRadio ,"_token": "{{ csrf_token() }}"},
                    success: function(response) {
                        $('#errors').html('');
                        if(response.status==='ok'){
                            $('.dicount_price').text(response.discountable_price+' '+localStorage.getItem('priceUnit')).css('display','block');
                            $('.discount').css('display','block');
                            $('.deducted_price').text(" - "+response.deducted_price+' '+localStorage.getItem('priceUnit')).css('display','block');
                            $('.deducted').css('display','block');
                        }else{
                            $('.discount').css('display','block');
                            $('.dicount_price').text('کد وارد شده معتبر نیست!').css('display','block');
                        }
                    },
                    error: function(response){
                        $('#errors').html("").show();
                        $('.discount').css('display','block');
                        $('.dicount_price').text(response.responseJSON.message);
                    }
                });
            }
        };
        function get_post_area() {
            $.ajax({
                type: "GET",
                url: "{{url('/api/v1/get_post_area')}}",
                data: '',
                success: function (response) {
                    if (response.status==='ok'){
                        let peyks=response.areas;
                        let data='<option value="0">انتخاب کنید</option>';
                        $.each(peyks,function (key,item) {
                            data+=`<option value="${item.id}" ${item.id===14?'id="hozuriOption"':''} ${localStorage.getItem('peyks')==item.id?'selected':''}>${item.zones}</option>`
                        });
                        $('#zones').html(data);
                        // $('#tower_peykPrice').html(formatPrice(response.tower_deliver_peykPrice));
                        $('#express').html(response.incity_peykPrice)
                        $('#scheduled').html(response.incity_scheduled_peykPrice)
                        _calculateShipment();
                    }
                }
            });
        }

    </script>

@endsection












