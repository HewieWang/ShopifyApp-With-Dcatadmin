<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\App;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Dcat\Admin\Support\Helper;

class AppController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new App(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('domain');
            $grid->column('app_list')->display(function ($app_list) {
                $arr=json_decode($app_list, true);
                $s="";
                foreach ($arr as $v){
                    $d=DB::table("shop")->select('description')->where("id",$v)->get();
                    // dd(json_decode($d, true));
                    $s.="<span style='display: flex;margin: 5px 0;justify-content: space-between;'><span style='background:#586cb1;color: #fff;padding: 5px;width: fit-content;'>".json_decode($d, true)[0]['description']."</span><span style='float:right;background:green;color:#fff;padding:5px;'>Enable</span></span>";
                }
                return $s;
            });
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });  
            // $grid->column('access_token');
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableQuickEditButton();
            $grid->disableViewButton();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new App(), function (Show $show) {
            $show->field('id');
            $show->field('domain');
            $show->field('app_list');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new App(), function (Form $form) {
            $form->display('id');
            $form->text('domain')->default("harvey-teststore.myshopify.com");
            $form->multipleSelect('app_list')->options('/get_app_list')->saving(function ($paths) {
                $paths = Helper::array($paths);
                return json_encode($paths);
            });
            // $form->saving(function (Form $form) {
            //     if ($form->isCreating()) {
            //         $app_list = implode(',', $form->app_list);
            //         $form->app_list=$app_list;
            //         // dd($app_list);
            //     }
            // });
        });
    }
}
