<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$market->name}}</title>
    <link href="{{asset('assets/css/print.css')}}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset('assets/js/jquery-print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery.jqprint-0.3.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(e){
            $('#print-me').jqprint();
        });
    </script>
    <style type="text/css">
        @page { margin: 2cm }
        /* First page, 10 cm margin on top */
        @page :first {
            margin-top: 10cm;
        }
        /* Left pages, a wider margin on the left */
        @page :left {
            margin-left: 3cm;
            margin-right: 2cm;
        }
        @page :right {
            margin-left: 2cm;
            margin-right: 3cm;
        }
        table {
            border-collapse: collapse;
        }
        table, td, tr {
            border: 1px solid black;
        }
        @media all {
            .page-break	{ display: none; }
        }
        @media print {
            .page-break	{ display: block; page-break-before: always; }
        }
    </style>
</head>
<body style="background-color:#eee; text-align:center">

<br />
<input name="" type="button" value="چاپ" style="padding-left:20px; padding-right:20px" onclick="$('#print-me').jqprint();" />
<br /><br />
<div id="print-me" align="center" style="height: 500px;">
    <div class="print-area" style="padding: 20px;border: 1px solid #000000;border-radius: 7px;">
        <div style="margin:0 10px 0 10px;">
            <div>
                <img src="{{asset('images/ui_images/Logo_qazvinMarket.png')}}"  width="150" alt=""/>
            </div>
            <div style="border:1px solid #000000;height: 30px;margin-top: 10px;border-radius: 5px">
                <div style="padding: 5px;direction: ltr">تاریخ :
                    {{$order->verified_at->format('Y/m/d')}}
                    ساعت:
                    {{$order->verified_at->format('H:i:s')}}
                </div>
            </div>

            <div style="border:1px solid #000000;margin-top: 10px;border-radius: 5px">
                <div style="font-size: 14px;text-align: right;padding: 5px;">نام مشتری : {{$order->name}}</div>
                <div style="font-size: 14px;text-align: right;padding: 5px;">تلفن : {{$order->tel}} </div>
                <div style="font-size: 14px;padding: 5px;text-align: right;">آدرس : {{$order->address}} @if(isset($order->tower) and $order->tower>150)  - تحویل درب واحد @endif</div>
                <div style="font-size: 14px;padding: 5px;text-align: right;">هزینه ارسال : {{number_format($order->shipping_price)}} تومان</div>
                @if($order['Amount_customer'] + $order['discount_ghasedak'] > 10)
                    <div style="font-size: 14px;padding: 5px;text-align: right;">تخفیف :
                        {{number_format($order['Amount_customer']+$order['discount_ghasedak'])}} تومان
                    </div>
                @endif
            </div>
            <table style="margin-top: 5px;text-align: center;" width="100%"   >
                <tr class="bg-success">
                    <td>کالا</td>
                    <td>تعداد</td>
                </tr>
                @foreach($order->cargos as $cargo)
                    <tr>
                        <td>{{$cargo['name']}}</td>
                        <td>{{$cargo['count']}}</td>
                    </tr>
                @endforeach
            </table>
            @if($order->comment != '')
                <div style="
                border:1px solid #000000;margin-top: 10px;border-radius: 5px">
                    <div style=" font-size: 16px;padding: 5px;text-align: justify;">توضیحات : {{$order->comment}}</div>
                </div>
            @endif
            <div style=" height:50px;margin-top: 10px;">
                <div style="font-size: 14px;">شماره تماس سوپرمارکت</div>
                <div>{{$market->tel[0]}}</div>
            </div>
            <hr/>
            <div style=" height:50px;margin-top: 10px;">
                <div style="font-size: 13px;">{{$market->name}} ، سفارش اینترنتی غذا، میوه و شیرینی</div>
                <div>www.{{$market->url}}</div>
            </div>
        </div>
    </div>
    <div class="page-break"></div>
</div>
</body>
</html>
