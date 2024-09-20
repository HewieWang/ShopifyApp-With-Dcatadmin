<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\Setting;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
     /**
     * 版本号.
     *
     * @var string
     */
    const VERSION = '1.11.11';

    public function index(Content $content)
    {
        return $content
            ->title('设置')
            ->description('详情')
            ->body(new Card(new Setting()));
    }
    
    public function get_app_list(){
        $query=DB::table("shop")->select('id','description as text')->get();
        return $query;
    }

}