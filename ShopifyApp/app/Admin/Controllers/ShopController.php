<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Shop;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ShopController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Shop(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('client_id');
            $grid->column('client_secret');
            $grid->column('app_name');
            $grid->column('scopes');
            $grid->column('api_version');
            $grid->column('app_url');
            $grid->column('redirect_url');
            $grid->column('description');
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
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
        return Show::make($id, new Shop(), function (Show $show) {
            $show->field('id');
            $show->field('client_id');
            $show->field('client_secret');
            $show->field('app_name');
            $show->field('app_url');
            $show->field('redirect_url');
             $show->field('description');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Shop(), function (Form $form) {
            $form->display('id');
            $form->text('client_id');
            $form->text('client_secret');
            $form->text('app_name');
            $form->text('scopes');
            $form->text('api_version')->default("2024-07");
            $form->text('app_url');
            $form->text('redirect_url');
            $form->text('description');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
