<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Extension;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ExtensionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Extension(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('category');
            $grid->column('app_id');
            $grid->column('description');
            $grid->column('lujing');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
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
        return Show::make($id, new Extension(), function (Show $show) {
            $show->field('id');
            $show->field('category');
            $show->field('app_id');
            $show->field('description');
            $show->field('lujing');
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
        return Form::make(new Extension(), function (Form $form) {
            $form->display('id');
            $form->text('category');
            $form->text('app_id');
            $form->text('description');
            $form->text('lujing');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
