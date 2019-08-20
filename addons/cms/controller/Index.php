<?php

namespace addons\cms\controller;

use think\Config;

/**
 * CMS首页控制器
 * Class Index
 * @package addons\cms\controller
 */
class Index extends Base
{
    public function index()
    {
//        echo '520接好孕home';die;
        Config::set('cms.title', Config::get('cms.title') ? Config::get('cms.title') : __('Home'));
        if ($this->request->isAjax()) {
            $this->success("", "", $this->view->fetch('common/index_list'));
        }
        return $this->view->fetch('/index');
    }

}
