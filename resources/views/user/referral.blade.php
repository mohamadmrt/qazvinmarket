@extends('user.master')
@section('content')
    <div class="panel-body">
        <div style="margin-bottom: 50px;text-align: center;"  >
            <i class="fal fa-gift" style="font-size: 80px; color:#00b5ad "></i>
            <div class="panels panels-default text-center ">
                <h4>  دریافت هدیه <span style="font-size: 18px;color: #5cb85c;"> 5,000 هزار تومانی</span>  با دعوت از دوستان  </h4>
            </div>
            <h5 style="line-height : 2;text-align: justify;">
                کافیست شما دوستان خود را به خرید از {{$market->name}} دعوت کنید، تا پس از خرید آنها کیف پول شما به مبلغ 5,000 هزار تومان شارژ گردد. قابل ذکر است دوستانتان هم هنگام خرید از تخفیف 10 درصدی تا سقف 15,000 هزارتومان برخوردار می شوند.
            </h5>

            <hr class="hr">
            <h4 style="line-height : 2;text-align: justify;color: #cc3c79;">لطفا به یکی از روش ها زیر کد تخفیف را برای دوستان خود ارسال کنید :</h4>
            <br>
            <h3 style="text-align: center;border-bottom: 1px solid #ddd;line-height: 0;margin-bottom: 30px; color: #cc3c79;font-size: 18px;">
                              <span style="background-color: white;padding: 20px;font-size: 16px;color: #cc3c79;" >
                                   <span> روش اول </span>
                              </span>
            </h3>

            <h5 style="line-height : 2;text-align: justify;"> شماره تلفن همراه دوستان خود را جهت دعوت در کادر زیر وارد نمایید تا اطلاعات لازم برای آنها پیامک شود:</h5>
            <input class="form-control"   style="margin-bottom: 10px;" id="tel" name="tel" placeholder="شماره همراه">
            <button class="btn btn-success"  id="submit_send" name="submit_send">ارسال از طریق پیامک</button>
            <br>
            <br>
            <span style="color: #ac2925;display: none;margin-top: 10px; " id="error_tel"></span>
            <span style="color: #3c763d;display: none;margin-top: 10px; " id="success_tel"> </span>
            <br>
            <br>
            <h3 style="text-align: center;border-bottom: 1px solid #ddd;line-height: 0;margin-bottom: 30px; color: #cc3c79;font-size: 18px;">
                              <span style="background-color: white;padding: 20px;font-size: 16px;color: #cc3c79;" >
                                   <span> روش دوم </span>
                              </span>
            </h3>
            <h5 style="line-height : 2;text-align: justify;"> کد تخفیف :
                <span style="font-size: 16px;color: #3c763d;" id="code">
                               {{$code_friends}}
                    </span> به دوستان خود اطلاع رسانی کنید.

            </h5>                            <br>
            <h3 style="text-align: center;border-bottom: 1px solid #ddd;line-height: 0;margin-bottom: 30px; color: #cc3c79;font-size: 18px;">
                              <span style="background-color: white;padding: 20px;font-size: 16px;color: #cc3c79;" >
                                   <span> روش سوم </span>
                              </span>
            </h3>
            <h5 style="line-height : 2;text-align: justify;">لینک ذیل را کپی و از طریق تلگرام برای دوستان خود ارسال نمایید: </h5>
            <a href="{{route('home.index',['code_friends' => auth()->user()->code_friends])}}">
                https://{{$market->url}}/{{auth()->user()->code_friends}}
            </a>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $("#submit_send").click(function () {

                var code = $("#code").text();
                var name = $("#name").val();
                var tel = $("#tel").val();
                if( tel == "")
                {
                    var message = 'لطفا تلفن همراه را وارد کنید.';
                    $("#error_tel").show().text(message);
                }else{
                    $.ajax({
                        type: "POST",
                        url: "{{url('/sendSMSReferral')}}",
                        data: {tel : tel , code : code,"_token": "{{ csrf_token() }}"},
                        success: function(data) {
//                            console.log(data);
                            if(data.success){
                                $("#error_tel").hide();
                                $('#success_tel').show().text(data.message);
                            }
                            else{
                                $('#success_tel').hide();
                                $('#error_tel').show().text(data.message);
                            }
                        }
                    });
                }
            });
        })
    </script>

@endsection
