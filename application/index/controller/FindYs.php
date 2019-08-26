<?php
/**
 * Created by PhpStorm.
 * User: glen9
 * Date: 2019/8/26
 * Time: 10:26
 */

namespace app\index\controller;


use app\common\controller\Frontend;

class FindYs extends Frontend
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = 'default';

    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $this->view->assign('find_ys', '找月嫂');
        return $this->view->fetch();
    }
}