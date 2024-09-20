<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPShopify;

class CheckoutSettingController extends Controller
{   
    public function __construct()
    {   
        $apps = DB::table("shop")->where("id",1)->select("*")->get()->toArray();
        
        $config = array(
            'ShopUrl' => 'harvey-teststore.myshopify.com',
            'ApiKey' => $apps[0]->client_id,
            'Password' => $apps[0]->client_secret,
            'ApiVersion' => $apps[0]->api_version,
            'SharedSecret' => $apps[0]->client_secret,
            'Curl' => array(
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true
            )
        );
        
        $scopes = $apps[0]->scopes;
        
        $redirectUrl = $apps[0]->redirect_url;
        
        PHPShopify\ShopifySDK::config($config);
        
        $accessToken = \PHPShopify\AuthHelper::createAuthRequest($scopes);
        
        echo $accessToken;exit;
        
    }
    
    public function index(){
        
        $session = Shopify\Utils::loadCurrentSession(
            $headers,
            $cookies,
            $isOnline
        );
        $client = new Rest(
            $session->getShop(),
            $session->getAccessToken()
        );
        $response = $client->get('shop');
        
        dd($response);

        return view("checkout-settings");
    }

    public function getconfig(){
        
        $shop="harvey-teststore.myshopify.com";
        
        $app_list = DB::table("app")->where("domain",$shop)->select("app_list")->get()->toArray();
        
        $arr=json_decode($app_list[0]->app_list, true);
        
        $configItems=array();
        
        foreach ($arr as $v){
            $description=DB::table("shop")->where("id",$v)->select("description")->get()->toArray();
            $description = $description[0]->description;
            $push_arr=array(
                "id"=>$v,
                "description"=>$description,
                "enabled"=>true
            );
            array_push($configItems,$push_arr);
        }
        
        
        
        // $configItems = [
        //     [
        //         'id' => 1,
        //         'description' => '功能12描述',
        //         'enabled' => false
        //     ],
        //     [
        //         'id' => 2,
        //         'description' => '功能2描述',
        //         'enabled' => true
        //     ],
        //     [
        //         'id' => 3,
        //         'description' => '功能3描述',
        //         'enabled' => false
        //     ]
        // ];
        
        
        
        echo json_encode($configItems);
    }

}