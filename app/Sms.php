<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SoapClient;

class Sms extends Model
{
    protected $guarded = [];
    protected $table = 'sms';
    protected $dates = [
        'sent_at'
    ];

    public static function insert($order_id, $to, $text)
    {
        $sms = Sms::create([
            'order_id' => $order_id,
            'to' => $to,
            'text' => $text,
            'market_id' => 1
        ]);
        return $sms;
    }

    static public function sendSmsSupporters($market_id, $order_id)
    {
        $market = get_market($market_id);
        $order = Order::findOrFail($order_id);
        $cargo_text = '';
        foreach ($order->cargos as $cargo) {
            $cargo_text .= $cargo['name'] . ' -> ' . $cargo['count'] . ' ' . 'عدد' . "\n\r";
        }
        $type = '';
        switch ($order->type) {
            case "verbal":
                $type = "حضوری";
                break;
            case "express":
                $type = "سریع";
                break;
            case "scheduled":
                $type = "زمانبندی";
                break;
        }
        $bank = '';
        switch ($order->bank) {
            case "1":
                $bank = "درگاه ملت";
                break;
            case "3":
                $bank = "کیف پول";
                break;
            case "4":
                $bank = "نقدی";
                break;
        }
        $date = gregorian2jalali(Carbon::now());
        $text = "$order->name\nسفارش: $type\nپرداخت : $bank\nموبایل: $order->tel\nمبلغ: $order->invoice_amount ت \n\r$date";
//            $text = "سفارش $order->id \n\r $cargo_text  \n\r جمع کل: $order->invoice_amount T \n\r موبایل مشتری: $order->tel  \n\r نحوه ارسال: $type";
//        $market_mobiles = explode("-", $market->mobile);
        foreach ($market->support as $market_support) {
            Sms::insert($order->id, $market_support, $text);
        }
    }

    static public function sendSmsSuccessOrder($order_id)
    {
        $order = Order::findOrFail($order_id);
        $date = gregorian2jalali(Carbon::now());
        $text = "با سلام\nسفارش شما با موفقیت ثبت شد. \nتلفن پیگیری: 02833825000\nجهت ثبت نظر میتوانید به پروفایل خود مراجعه فرمائید.\nبه جمع ما در اینستاگرام بپیوندید:
https://instagram.com/qazvinmarketcom
";
//            $text = "سفارش $order->id \n\r $cargo_text  \n\r جمع کل: $order->invoice_amount T \n\r موبایل مشتری: $order->tel  \n\r نحوه ارسال: $type";
        Sms::insert($order->id, $order->tel, $text);
    }

    static public function Adminlogin($order_id, $tel, $message)
    {
        SMS::create([
            'order_id' => $order_id,
            'to' => $tel,
            'text' => $message,
            'market_id' => 1,
        ]);
    }

    public static function send(Sms $sms)
    {
        try {
            $option = array('trace' => 1, 'exceptions' => 1);
            $client = @new SoapClient(env('SMS_API'), $option);
            $params = array(
                'username' => env('SMS_USERNAME'),
                'password' => env('SMS_PASSWORD'),
                'senderNumbers' => array(get_market(1)->sms_number),
                'recipientNumbers' => array($sms->to),
                'messageBodies' => array($sms->text)
            );
            $results = $client->SendSMS($params);
            $sms->update([
                'sent' => 1,
                'sent_at' => Carbon::now(),
                'rescode' => $results->SendSMSResult->long
            ]);
            return $results->SendSMSResult->long;
        } catch (\SoapFault $e) {
            $sms->update([
//                    'rescode'=>$e->faultstring
                'rescode' => $results->SendSMSResult->long
            ]);
            return $message = $e->faultstring;
        }
    }
}
