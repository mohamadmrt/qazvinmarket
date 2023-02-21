<?php

use App\Market;
use App\Sms;
use Hashids\Hashids;
use Illuminate\Support\Facades\Session;
use Morilog\Jalali\CalendarUtils;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

function convertPersianToEnglish($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    $output = str_replace($persian, $english, $string);
    return $output;
}

if (!function_exists('fa2en')) {
    /**
     * Returns a human readable file size
     *
     * @param $value
     * @return string a string in human readable format
     *
     */


    function fa2en($value)
    {
        $en_num = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", 'ی', 'ی', 'ی', 'ک', 'ه');
        $fa_num = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹", 'ي', 'ى', 'ئ', 'ك', 'ة');
        return str_replace($fa_num, $en_num, ConvertAeToEn($value));
    }

    function ConvertAeToEn($string)
    {
        $en_num2 = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", 'ی', 'ی', 'ی', 'ک', 'ه');
        $fa_num2 = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩", 'ي', 'ى', 'ئ', 'ك', 'ة');
        return str_replace($fa_num2, $en_num2, $string);
    }
}
if (!function_exists('en2fa')) {
    /**
     * Returns a human readable file size
     *
     * @param $value
     * @return string a string in human readable format
     *
     */
    function en2fa($value)
    {
        $en_num = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $fa_num = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹");
        return str_replace($en_num, $fa_num, $value);
    }
}
if (!function_exists('gregorian2jalali')) {
    function gregorian2jalali($timestamp)
    {
        if ($timestamp != null) {
            return CalendarUtils::strftime('Y/m/d H:i:s', $timestamp);
        } else {
            return null;
        }
    }
}
if (!function_exists('gregorian2jalali_without_seconds')) {
    function gregorian2jalali_without_seconds($timestamp)
    {
        if ($timestamp != null) {
            return CalendarUtils::strftime('Y/m/d H:i', $timestamp);
        } else {
            return null;
        }
    }
}
if (!function_exists('gregorian2jalali_without_time')) {
    function gregorian2jalali_without_time($timestamp)
    {
        if ($timestamp != null) {
            return CalendarUtils::strftime('Y/m/d', $timestamp);
        } else {
            return null;
        }
    }
}
if (!function_exists('jalali2gregorian')) {
    function jalali2gregorian($timestamp)
    {
        if ($timestamp != null) {
            return CalendarUtils::createDatetimeFromFormat('Y/m/d', $timestamp);
        } else {
            return null;
        }
    }
}
if (!function_exists('get_market')) {
    function get_market($id)
    {
        return Market::find($id);
    }
}
if (!function_exists('MellatPay')) {
    function MellatPay($order, $amount, $callback_url)
    {
        $params = array(
            "terminalId" => env('MELLAT_TERMINALID'),
            "userName" => env('MELLAT_USERNAME'),
            "userPassword" => env('MELLAT_PASSWORD'),
            "orderId" => $order->id,
            "amount" => $amount,
            "localDate" => date("Ymd"),
            "localTime" => date("His"),
            "additionalData" => $order->id . ' ' . $order->user->username,
            "callBackUrl" => $callback_url,
//                "payerId" => 6042
        );

        $i = 0;
        do {
            try {
                $client = @new SoapClient(env("MELLAT_WSDL"), ['trace' => 1]);
                return explode(',', $client->bpPayRequest($params, env("MELLAT_NAMESPACE"))->return);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            $err = $client->getError();
            $i++;
        } while (($err) and ($i < 25));

    }
}

if (!function_exists('verify_payment')) {
    function verify_payment($SaleReferenceId, $SaleOrderId)
    {
        try {
            $namespace = env('MELLAT_NAMESPACE');
            $client = @new SoapClient(env('MELLAT_WSDL'));
            $parameters = array(
                "terminalId" => env('MELLAT_TERMINALID'),
                "userName" => env('MELLAT_USERNAME'),
                "userPassword" => env('MELLAT_PASSWORD'),
                'saleOrderId' => $SaleOrderId,
                'orderId' => $SaleOrderId,
                'saleReferenceId' => $SaleReferenceId);


            $verify = $client->bpVerifyRequest($parameters, $namespace)->return;
            if ($verify == 0) {
                $settle = $client->bpSettleRequest($parameters, $namespace)->return;
                if ($settle == 0) {
                    return 0;
                } else {
                    $client->bpReversalRequest($parameters);
                    return 1;
                }
            } else {
                $client->bpReversalRequest($parameters);
                return 1;
            }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
if (!function_exists('encode')) {
    function encode($data)
    {
        $hashids = new Hashids('l1a3r9a7v0e9l13');
        $id = $hashids->encode($data);
        return $id;
    }
}
if (!function_exists('in_arrayi')) {

    /**
     * Checks if a value exists in an array in a case-insensitive manner
     *
     * @param mixed $needle
     * The searched value
     *
     * @param $haystack
     * The array
     *
     * @param bool $strict [optional]
     * If set to true type of needle will also be matched
     *
     * @return bool true if needle is found in the array,
     * false otherwise
     */
    function in_arrayi($needle, $haystack, $strict = false)
    {
        return in_array(strtolower($needle), array_map('strtolower', $haystack), $strict);
    }
}
