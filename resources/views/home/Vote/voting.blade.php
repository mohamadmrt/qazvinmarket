@extends('home.master',array('contactUs'=>__('messages.vote.2')))
@section('header')
@endsection
@section('style')
@endsection
@section('content')
    <body>
    <div class="container-fluid" style="    background-color: #f2efeb;">
        <div class=" container voting" >
            <input type="hidden" name="order_id" id="order_id" value="$orderUser->id}}">
            <input type="hidden" name="rid" id="rid" value="$resturant['id']}}">
            <div class="" style="background-color:#FFF;padding-top: 10px;">
                <h4 class="text-center" style="margin-bottom:30px;">
                    <p style="font-size:13pt; color:#666;"><span id="name"></span> عزیز ؛ نظر خود را درباره‌ی این سفارش  به ما بگویید!</p>
                </h4>
                <hr>
                <div >
                    <h3 class="text text-center">@lang('messages.vote.3') <span id="market_name"></span>  @lang('messages.vote.4')</h3><br><br>
                    <div class="text-center" dir="ltr" style="font-size: 30px;" >
                        <div class="row">
                            <div class="col-md-4" ><button class="market_rating" data-id="1" title="راضی" style="opacity: 0.5"><i class='far fa-grin' style='font-size:48px;color:green;border-radius: 5px;cursor: pointer;' ></i></button>  </div>
                            <div class="col-md-4" ><button class="market_rating" data-id="2" title="نظری ندارم" style="opacity: 0.5"><i class='far fa-frown' style='font-size:48px;color:#ffdd00;border-radius: 5px;cursor: pointer;' ></i></button> </div>
                            <div class="col-md-4" ><button class="market_rating" data-id="3" title="ناراضی" style="opacity: 0.5" ><i class='fas fa-angry' style='font-size:48px;color:red;border-radius: 5px;cursor: pointer;'></i></button> </div>
                        </div>

                        <div id="bads"  style="margin-top:20px;display: none;">
                            <div class="col-lg-9 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12 text-right" style="font-size: 14px;" id="dissatisfactions">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <hr class="type_8">

                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <h3 class="text text-center">@lang('messages.vote.17') </h3><br>
                    <div class="text-center" id="cargos"></div>

                    <input type="hidden" id="order_count" name="order_count" value="$i}}">
                    <hr>
                    <h4 class="text text-center" id="title"> @lang('messages.vote.24')  </h4><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <textarea  class="inputstyles"   id="message_text" name="message" style="width: 70%;" ></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center" style="line-height: 3rem">
                        <div class="col-lg-6 col-lg-push-4 col-md-6 col-md-push-4 col-xs-9 col-xs-push-2" style="text-align: justify">
                            <input  type="radio" class="message_private" name="message_private" value="0" checked> @lang('messages.vote.25')
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-lg-6 col-lg-push-4 col-md-6 col-md-push-4 col-xs-9 col-xs-push-2" style="text-align: justify">
                            <input  type="radio" class="message_private" name="message_private" value="1"> @lang('messages.vote.33')
                        </div>
                    </div>

                    <br>
                    <div class="text-center" style="padding-bottom: 35px;">
                        <button class="btn btn-success" value="ارسال نظر"  id="submit" name="submit" type="button">@lang('messages.vote.26') </button>
                    </div>
                    <div id="error_comment" class="row col-md-12 error-log"></div>
                    <div id="success_comment" class="row col-md-12 success-log"></div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script>
        let cargos_vote=[];
        $(document).ready(function(){
            let url = window.location.href;
            let a = $('<a>', {
                href: url
            });
            let menu_id=a.prop("pathname").split("/");
            let market_rating=0;
            let bads=[];

            function _get(order){
                $.ajax({
                    headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                    type: "GET",
                    url: "/api/v1/vote/"+order,
                    success:function (response) {
                        let cargos=``;
                        $.each(response.order.cargos, function (key, item) {
                            cargos+=`<div class="row"> `;
                            cargos+=`<div class="col-md-6">`;
                            cargos+=`<button  value="0" id="cargo" class="btn btn-info ">${item.name}</button>`;
                            cargos+=`</div>`;
                            cargos+=`<div class="col-md-6" dir="ltr">`;
                            cargos+=`<p  style="font-size: 25px;cursor: pointer;">`;
                            cargos+=`<input data-count="${item.count}" id=${item.id} style="font-size: 30px;"  dir="ltr"  type="number" name="" class="rating" data-clearable=""/>`;
                            cargos+=`</p>`;
                            cargos+=`</div>`;
                            cargos+=`</div>`;
                            cargos_vote.push({id:item.id,count:item.count,rate:0})
                        })
                        let dissatisfactions=`<h4 class="text-right">:علت عدم رضایت</h4>`;
                        $.each(response.dissatisfaction_items, function (key, item) {
                            dissatisfactions+=`<div class="col-md-4"> <label style="font-size: 14px;margin-right: 10px;cursor: pointer;" for="${item.id}">${item.name} </label><input class="bads"type="checkbox" id="${item.id}" value="0"></div>`

                        })
                        $('#dissatisfactions').html(dissatisfactions)
                        $('#name').text(response.user.name);
                        $('#market_name').text(response.market.name?response.market.name:'قزوین مارکت');
                        $('#cargos').html(cargos);
                        $('.rating').rating();

                    },
                    error:function () {
                        swal({
                            type: 'warning',
                            title: 'خطای سیستم',
                            confirmButtonText: 'باشه',
                        }).then((result) => {
                            if (result.value)
                            {
                                window.location = "/";
                            }
                        })
                    }
                });
            }
            _get(menu_id[2])
            $(document).on('click', ".market_rating", function(e) {
                market_rating=parseInt($(this).data("id"))
                $('.market_rating').css({'border':"",'opacity':'0.5'})
                $(this).css({'border':'6px solid greenyellow','opacity':'1'});
                $("#bads").hide()
                if (market_rating=== 3){
                    $("#bads").show()
                }
            });
            $("#submit").click(function () {
                let message=$("#message_text").val();
                let order =menu_id[2];
                let is_private = $('input[name=message_private]:checked').val();
                if((message.length<5 && market_rating===3)|| market_rating===0){
                    swal({
                        type: 'warning',
                        title: "لطقاً نظر خود را تکمیل نمایید",
                        confirmButtonText: 'باشه',
                    })

                }else{
                if(market_rating!==3){
                    bads=[]
                }
                $.ajax({
                    headers:{"Authorization":"Bearer "+localStorage.getItem('token')},
                    type: "POST",
                    url: "/api/v1/set_vote/"+order,
                    data: {
                        market_rating,
                        cargos:cargos_vote,
                        is_private,
                        bads,
                        message
                    },
                    success: function(data) {
                        swal({
                            type: 'success',
                            title: data.message,
                            confirmButtonText: 'باشه',
                        }).then(function () {
                            window.location.href="/"

                        })
                    },
                    error:function (response) {
                        swal({
                            type: 'warning',
                            title: response.responseJSON.message,
                            confirmButtonText: 'باشه',
                        })

                    }
                });
                }
            });
            $(document).on('change', ".rating", function(e) {
                cargos_vote[cargos_vote.findIndex(x=>x.id===parseInt($(e.target).attr('id')))].rate=parseInt($(e.target).val());
            });
            $(document).on('change', ".bads", function(e) {
                if($(this).prop("checked")){
                    bads.push($(this).attr('id'))
                }else{
                    bads.splice( $.inArray($(this).attr('id'), bads), 1 );
                }

            });
        });

    </script>
    </body>
@endsection



