@extends('user.master')
@section('content')
    <script>
        (function ($) {
            "use strict";
            function centerModal() {
                $(this).css('display', 'block');
                let $dialog  = $(this).find(".modal-dialog"),
                    offset       = ($(window).height() - $dialog.height()) / 2,
                    bottomMargin = parseInt($dialog.css('marginBottom'), 10);
                // Make sure you don't hide the top part of the modal w/ a negative margin if it's longer than the screen height, and keep the margin equal to the bottom margin of the modal
                if(offset < bottomMargin) offset = bottomMargin;
                $dialog.css("margin-top", offset);
            }

            $('.modal').on('show.bs.modal', centerModal);
            $(window).on("resize", function () {
                $('.modal:visible').each(centerModal);
            });
        })(jQuery);
    </script>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="panel-body">
        <div class="form-inline">
            <div class="input-group">
                <label for="name" class="control-label">نام و نام خانوادگی</label>
                <input id="name" name="name" class="form-control" type="text" value="{{auth()->user()->name}}" size="40"
                       style="@if(auth()->user()->name =='') border-color: red; @endif">
            </div>
            <div class="input-group">
                <label for="birth" class="control-label">تاریخ تولد</label>
                <input  style="width: 80%;background-color: white;cursor: context-menu" type="text"
                        value="@if (auth()->user()->birthday!==NULL){{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d',auth()->user()->birthday)}}@endif"
                        class="form-control" id="birthday" placeholder="تاریخ تولد" name="birth"  readonly @if (auth()->user()->birthday!==NULL) disabled @endif/>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-success" id="save" title="ذخیره تغییرات"> <i class="far fa-save" style="font-size: 16px"></i> ذخیره </button>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $('#birthday').persianDatepicker({
                formatDate: "YYYY/0M/0D"
            });
        });
        $('#save').on("click",function (e) {
            e.preventDefault();
            let name=$('#name').val();
            let birthday=$('#birthday').val();
            let token=localStorage.getItem('token');
            let data= {'token':token,'name':name,'birthday':birthday}
            $.ajax({
                method: 'post',
                url: "{{url('api/v1/update_user_info')}}",
                data:data,
                success:function (response) {
                    if(response.status==='ok'){
                        localStorage.setItem('username',response.data.name)
                        localStorage.setItem('birthday',response.data.birthday)
                        swal({
                            title: 'پیغام سیستم',
                            text: response.message,
                            type: 'success',
                            confirmButtonText: 'باشه'
                        }).then(isConfirm=>{
                            window.location="/dashboard";
                        })
                    }

                },
                error:function (response) {
                    $("#message").html(response.responseJSON.message)
                }
            })
        });


    </script>


@endsection

