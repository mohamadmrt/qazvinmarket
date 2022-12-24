<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bazara extends Model
{
    protected function market(){
        return  Market::find(1);
    }
  static  public function login_bazara()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("BAZARA_LOGIN"),
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=".env("BAZARA_USERNAME")."&password=".env("BAZARA_PASSWORD")."&systemSyncID‬‬=".env("BAZARA_SYNC_ID")
        ));
        $loginResponse = curl_exec($curl);
        curl_close($curl);
        $loginResponse=json_decode($loginResponse);
        if ($loginResponse and $loginResponse->result=='success'){
            return $loginResponse->data->token;
        }
        return 0;
    }
    function getProducts($token){
        $new_cargos=0;
        $exists_cargos=0;
        $changed_after=$this->market()->bazara_ProductRowVersion;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("BAZARA_GET_PRODUCT_URL").$changed_after,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userToken=".$token . "&systemSyncID=".env("BAZARA_SYNC_ID") ,
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        $products=collect($response->data);
        if ($products->count()>0 and $response->result=='success'){

            foreach ($products as $product){
                $UnitName=$product->UnitName;
                if (!$product->UnitName)
                    $UnitName=null;
                $product->Name = str_replace("ي", "ی", $product->Name);
                $product->Name = str_replace("ك", "ک", $product->Name);
                $product->Name = preg_replace('/\s+/', ' ', $product->Name);
                $product->Name=trim($product->Name);
                $found_cargo=Cargo::where('bazara_ProductID',$product->ProductID)->first();
//                $found_cargo=Cargo::where('bazara_Code',$product->Code)->first();
                if ($found_cargo){
                    $found_cargo->update([
                        "bazara_ProductID" => $product->ProductID,
                        "bazara_Code" => $product->Code,
                        'name' => $product->Name ,
                        'bazara_UnitName' => $UnitName,
                        'status' => "1",
                        'synced_at'=>Carbon::now()
                    ]);
                    $exists_cargos++;
                }
                else{
                    Cargo::create([
                        'market_id' => 1,
                        'bazara_ProductID' => $product->ProductID,
                        "bazara_Code" => $product->Code,
                        'name' => $product->Name ,
                        'bazara_UnitName' => $UnitName,
                        'status' => "1",
                        'synced_at'=>Carbon::now()
                    ]);
                    $new_cargos++;
                }
            }
            $this->market()->update([
                "bazara_ProductRowVersion"=>$products->max("RowVersion")
            ]);

        }
        return  $new_cargos." cargos created. ".$exists_cargos." cargos updated. ".$products->count()." total cargos";
    }
    function getPrices($token){
        $changed_after=$this->market()->bazara_PriceRowVersion;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("BAZARA_GET_PRICE_URL").$changed_after,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userToken=".$token . "&systemSyncID=".env('BAZARA_SYNC_ID') ,
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        $prices=collect($response->data);
        $updated_cargos=0;
        if ($prices->count() and $response->result=='success'){


            foreach ($prices as $price){
                $found_cargo=Cargo::where('bazara_ProductID',$price->ProductID)->first();
                if ($found_cargo and ($found_cargo->price!=round($price->Price1/10) or $found_cargo->price_discount!=round($price->Price2/10) or$found_cargo->max_count!= $price->AvailableCount)){
                    $found_cargo->update([
                        'price' => round($price->Price1/10),
                        'price_discount' => round($price->Price2/10),
                        "max_count" => $price->AvailableCount,
                        'bazara_ProductPriceID' => $price->ProductPriceID ,
                    ]);
                    $updated_cargos++;
                }
            }
            $this->market()->update([
                "bazara_PriceRowVersion"=>$prices->max("RowVersion")
            ]);
        }
        return 'cargos price updated: '.$updated_cargos.' cargos';
    }
    public function get_products(){
        $token=$this->login_bazara();
        if ($token){
            $product_result=$this->getProducts($token);
            $price_result=$this->getPrices($token);
            return $product_result.' '.$price_result ;
        }
        return "login failed";
    }
    public function send_factors(){
        set_time_limit(300);
        $orders=Order::where('market_id',1)
            ->where('status','=','4')
            ->where('valid','=','1')
            ->where('send_factor',0)
            ->where('lock_factor',0)
            ->get();
        if ($orders->count()==0){
            return "0 order will send";
        }
        foreach ($orders as $order){
           self::send_factor($order);
        }
        return $orders->count().' orders sent';
    }
    static public function send_factor($order)
    {
        $time=Carbon::now();
        $order->update([
            'lock_factor'=>'1',
            'time_lock'=>$time
        ]);
        $countRunWS='';$k=0;$response_login='';$response_getPeople='';$response_getAddress='';$response_createNewOrder='';
        $errCurl='';
        $response_login.='beforeLogin:'.time();
        $token=0;
        for ($i=1;$i<=4;$i++){
            $k++;
            $token=Bazara::login_bazara();
        }
        if (!$token)
            $response_login.="errCurl".$errCurl.',afterLogin:'.time();
        if ($token) {
            $array=[];
            foreach ($order->cargos as $cargo){
                $item=Cargo::find($cargo['id']);
                $priceId=0;
                if ($item)
                    $priceId=$item->bazara_ProductPriceID;
                $array[]=[
                    "Quantity" => $cargo['count'],
                    "UnitPrice" => ($cargo['main_price']*10),
                    "UnitDiscount" => 0,
                    "TotalDiscount" => 0,
                    "ProductPriceID" => $priceId,
                    "PriceLevel" => 1,
                    "Comment" => ""
                ];
            }
            $shipping_price=$order->shipping_price*10;
            //mellat=1; wallet=2; cash=4;
            $bank='';
            switch ($order->bank){
                case '4':
                    $bank='نقدی';
                    break;
                case "1":
                    $bank="بانک ملت";
                    break;
                case "3":
                    $bank="کیف پول";
                    break;
            }
            $amount_pay="مبلغ نهایی:";
            if ($order['type_discount'] == 3)
                $amount_pay.=$order['invoice_amount']-($order['Amount_customer']*10)."تومان";
            else
                $amount_pay.=$order['invoice_amount']-($order['discount_ghasedak']*10)."تومان";

            $comment="توضیحات کاربر: $order->description مبلغ پیک: $shipping_price ریال نوع خرید: $bank شماره فاکتور سایت: $order->id $amount_pay";

            $beforeTime=$order->verified_at->subSeconds(12600);  //3.5 hour before
            $time=$beforeTime->format('H:i');
            $date=$beforeTime->format("Y-m-d");

            $Transactions=[];
            if ($order->bank=="1") {
                $Transactions = [
                    "DebtAmount" => 0,
                    "CreditAmount" => (int)$order->invoice_amount*10,
                    "TransactionType" => 0,
                    "ReferenceNumber" => $order->SaleRefId,
                    "TransactionDate" => $date . "T" . $time,
                    "Account" => "0002103657531",
                    "Comment" => "comment"
                ];
            }

            $user=User::where('username',$order->tel)->first();
            $personId=0;
            if ($user && $user->personId!=0)
                $personId=$user->personId;
            $personCode=0;
            $json=[
                "systemSyncID"=> env('BAZARA_SYNC_ID'),
                "userToken"=> "$token",
                "Person"=> [
                    "PersonID" => 0,
                    "FirstName" => $order->name,
                    "LastName" => "",
                    "PersonType" => 0,
                    "PersonCode" => $personCode,
                    "PersonGroupID" => null,
                    "Gender" => 0,
                    "NationalCode" => 0,
                    "Mobile1" => $order->tel,
                    "Phone1" => $order->tel,
                    "Fax" => "",
                    "Email" => "",
                    "UserName" =>  $order->tel,
                    "Password" => "",
                    "PriceLevel" => 1,
                    "CityCode" => null,
                    "Credit" =>0,
                    "Balance"=>0,
                    "Comment"=>"",
                    "Address"=> [
                        "AddressLabel"=>$order->address ,
                        "CityCode"=> 0,
                        "Phone"=>$order->tel,
                        "Longitude"=> 0,
                        "Latitude"=> 0,
                        "PostalCode"=> 0,
                        "Title"=> ""
                    ]
                ],
                "ShippingAddress"=> [
                    "AddressID"=> null,
                    "CityCode"=> 0,
                    "PostalCode"=> 0,
                    "AddressLabel"=> $order->address,
                    "Title"=> "",
                    "Phone"=> $order->tel,
                    "Longitude"=> 0,
                    "Latitude"=> 0,
                    "Comment"=> ""
                ],
                "Order"=> [
                    "OrderDate"=> $date."T".$time,
                    "Status"=> 0,
                    "CustomerComment"=> '',
                    "Comment"=> $comment,
                    "PaymentType"=> 0
                ],
                "Items"=> $array,
                "ExtraCosts"=> [
                    [
                        "Amount"=> $shipping_price,
                        "Type"=> 1,
                        "Description"=> "مبلغ پیک"
                    ]
                ],
                "Transactions" => [
                    $Transactions
                ]
            ];

            $response='';
            $errCurl='';$responseCurl='';
            $response_createNewOrder.="beforeOrder:".time();
            for ($i=1;$i<=4;$i++){
                $k++;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => env("BAZARA_CREATE_ORDER_URL"),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 80,
                    CURLOPT_CONNECTTIMEOUT => 80,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($json),
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                    ),
                ));

                $responseCurl = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if (!$err){
                    $response=json_decode($responseCurl);
                    if ($response and $response->result=='success')
                        break;
                }
                else{
                    $errCurl.=$err;
                }
            }

            if ($errCurl)
                $response_createNewOrder.="errCurl".$errCurl.'afterOrder:'.time();
            if ($responseCurl)
                $response_createNewOrder.=",response_createNewOrder".$responseCurl.',afterOrder:'.time();

            $countRunWS.="createNewOrder:$k";

            if ($response and $response->result=='success') {
                if ($user){
                    $user->update([
                        'personId'=>$response->data->PersonID
                    ]);
                }
                $order->update([
                    'send_factor'=>'1',
                    'response_factor'=>json_encode($response)
                ]);
            }
        }
        FactorLog::insert($order->id,$countRunWS,$response_login,$response_getPeople,$response_getAddress,$response_createNewOrder);
        return 'ok';
    }

}
