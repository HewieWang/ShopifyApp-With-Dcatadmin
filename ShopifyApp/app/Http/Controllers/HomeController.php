<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PHPShopify;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
// use GuzzleHttp\Client;

class HomeController extends Controller
{
   public function index(){
       
        $apps = DB::table("shop")->select("*")->get()->toArray();
        
        return view("install",["apps"=>$apps]);
   }
   
   public function redirect_to_auth(Request $request)
    {
        $input = $request->all();
        
        // 从数据库获取app的配置信息
        $apps = DB::table("shop")->where("id", $input['app'])->first();
        
        if (!$apps) {
            return response()->json(['error' => 'App not found'], 404);
        }
        
        // 检查传入的输入数据
        if (!isset($input['domain']) || !isset($apps->client_id) || !isset($apps->client_secret)) {
            return response()->json(['error' => 'Missing required parameters'], 400);
        }
        
        $shop = $input['domain'].'.myshopify.com'; // Shopify 店铺的域名
        $api_key = $apps->client_id; // 从 Shopify 应用设置中获取
        $redirect_uri = $apps->redirect_url; // 授权回调 URL
        $scope = $apps->scopes; // 需要的权限
        
        session(['app'=>$input['app']]);
        // 创建授权 URL
        $auth_url = "https://$shop/admin/oauth/authorize?client_id=$api_key&scope=$scope&redirect_uri=" . urlencode($redirect_uri)."&app=".$input['app'];
        
        // 重定向到 Shopify 授权页面
        header("Location: $auth_url");
    }

    public function get_access_token(Request $request)
    {
        $input = $request->all();
        
        // dd($input);
        
        // array:5 [▼
        //   "code" => "5a89061bc066e395eade3ed114a28470"
        //   "hmac" => "ba70d0679e48ef4bc877e1ee225fa7ef71b4c8bdb15cc6cf434a1aeae8afc269"
        //   "host" => "YWRtaW4uc2hvcGlmeS5jb20vc3RvcmUvaGFydmV5LXRlc3RzdG9yZQ"
        //   "shop" => "harvey-teststore.myshopify.com"
        //   "timestamp" => "1726639393"
        // ]
        
        // 从数据库获取app的配置信息
        $apps = DB::table("shop")->where("id", session('app'))->first();
        
        if (!$apps) {
            return response()->json(['error' => 'App not found'], 404);
        }

        // 配置 ShopifySDK
        $config = [
            'ShopUrl' => $input['shop'],
            'ApiKey' => $apps->client_id,
            'SharedSecret' => $apps->client_secret,
            'ApiVersion' => $apps->api_version,
            'Curl' => [
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true
            ]
        ];
        
        
        // 配置
        $api_key = $apps->client_id;
        $api_secret = $apps->client_secret;
        $redirect_uri = $apps->redirect_url;
        $shop = $input['shop']; // 从回调请求中获取 shop 参数
        $code = $input['code']; // 从回调请求中获取 code 参数
        
        // 获取访问令牌
        $token_url = "https://$shop/admin/oauth/access_token?client_id=".$api_key."&client_secret=".$api_secret."&code=".$code;
        // echo $token_url;exit;
        // $params = [
        //     'client_id' => $api_key,
        //     'client_secret' => $api_secret,
        //     'code' => $code
        // ];
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $token_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_SSL_VERIFYPEER => false,
        //   CURLOPT_SSL_VERIFYPEER => false,
        //   CURLOPT_SSL_VERIFYHOST => 2,
        //   CURLOPT_SSLVERSION => 6,
        ));
        
        $response = curl_exec($curl);
        // $error = curl_error($curl);
        // var_dump($error);exit(0);
        curl_close($curl);
        
        $response_data = json_decode($response, true);
        
        $response_data['access_token'] = "shpua_0da04b79017a7578fcfc74880e0bf7e8";
        
        if (isset($response_data['access_token'])) {
            
            $access_token = $response_data['access_token'];
            
            $app=session('app');
            
            $app_list = DB::select("select app_list from app where domain = ?",[$shop]);
            
            $app_list=json_decode($app_list[0]->app_list,true);
            
            $token_list=array();
            
            foreach($app_list as $k => $v){
                $token_list[$k]="";
                if($v==$app){
                    $token_list[$k] = $access_token;
                }
            }
            
            DB::update("update app set access_token = ? where domain = ?",[json_encode($token_list),$shop]);
            
            echo "APP安装成功,token保存成功.关闭页面";
            // 这里可以保存访问令牌到数据库或者其他处理
            echo "Access Token: " . $access_token;
        } else {
            echo "Error retrieving access token.";
        }
   
    }

}
