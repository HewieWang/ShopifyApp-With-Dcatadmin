<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class Setting extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        // dump($input);
        admin_setting($input);

        // return $this->error('Your error message.');

        return $this->response()->success('设置成功')->location('settings');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        // dd();
        // Since v1.6.5 弹出确认弹窗
        $this->confirm('您确定要提交表单吗', 'content');
        $this->text('crmname', '网站名称')->default(admin_setting('crmname', 'NXCRM客户管理系统'));
        $this->url('crmurl', '网站地址')->default(admin_setting('crmurl', 'https://nx.tt'));
        $this->switch('body_class', '默认暗色')
            ->customFormat(function ($v) {
                return $v == '打开' ? 1 : 0;
            })
            ->saving(function ($v) {
                return $v ? 'dark-mode' : '';
            })->help('更改后需清空浏览器缓存');
        $this->radio('menu_layout', '侧栏布局')->options(['default' => '默认', 'sidebar-separate' => '分离']);
    }


    public function
    default()
    {
        if (admin_setting('body_class', 0)) {
            $body_class = 0;
        } else {
            $body_class = 1;
        }


        return [
            'logo' => admin_setting('logo', public_path().'/static/img/logo.png'),
            'color' => admin_setting('color', 'green'),
            'body_class' => $body_class,
            'sidebar_style' => admin_setting('sidebar_style', 'light'),
            'menu_layout' => admin_setting('menu_layout', 'sidebar-separate'),
        ];
    }
}