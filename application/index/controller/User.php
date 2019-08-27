<?php

namespace app\index\controller;

use app\common\controller\Frontend;
use fast\Random;
use think\Cache;
use think\Config;
use think\Cookie;
use think\Db;
use think\Hook;
use think\Session;
use think\Validate;
use ucpaas\Ucpaas;

/**
 * 会员中心
 */
class User extends Frontend
{
    protected $layout = 'default';
    protected $noNeedLogin = ['login', 'register', 'third', 'getCode', 'checkPhone'];
    protected $noNeedRight = ['*'];

    public function _initialize()
    {
        parent::_initialize();
        $auth = $this->auth;
        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

        //监听注册登录注销的事件
        Hook::add('user_login_successed', function ($user) use ($auth) {
            $expire = input('post.keeplogin') ? 30 * 86400 : 0;
            Cookie::set('uid', $user->id, $expire);
            Cookie::set('token', $auth->getToken(), $expire);
        });
        Hook::add('user_register_successed', function ($user) use ($auth) {
            Cookie::set('uid', $user->id);
            Cookie::set('token', $auth->getToken());
        });
        Hook::add('user_delete_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
        Hook::add('user_logout_successed', function ($user) use ($auth) {
            Cookie::delete('uid');
            Cookie::delete('token');
        });
    }

    /**
     * 空的请求
     * @param $name
     * @return mixed
     */
    public function _empty($name)
    {
        $data = Hook::listen("user_request_empty", $name);
        foreach ($data as $index => $datum) {
            $this->view->assign($datum);
        }
        return $this->view->fetch('user/' . $name);
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->view->assign('title', __('User center'));
        return $this->view->fetch();
    }

    /**
     * Notes:获取短信验证码
     * User: glen9
     * Date: 2019/8/25
     * Time: 13:07
     * @return string
     */
    public function getCode()
    {
        if ($this->request->isPost()) {
            $phone = $this->request->post()['phone'];
            $code = Random::numeric();
//            pr(Cache::get('reg_code'));die;
            $send_code_sta = json_decode(send_sms_code('496022', $code, $phone), true);
            if ($send_code_sta['code'] == '0' && $send_code_sta['msg'] == 'OK') {
                return ['msg' => '发送成功', 'code' => 1, 'result' => Cache::remember('reg_code', function () use ($phone, $code) {
                    return $code;
                }, 180)];
            }
            return ['msg' => $send_code_sta['msg'], 'code' => $send_code_sta['code'], 'result' => ''];

        }
    }

    public function checkPhone()
    {
        $mobile = $this->request->post()['mobile'];
        return Db::name('user')->where(['mobile' => $mobile])->count() ? ['msg' => '', 'code' => 1, 'result' => ''] : ['msg' => '账号不存在，请先注册', 'code' => 0, 'result' => ''];
    }

    /**
     * 注册会员
     */
    public function register()
    {
        $url = $this->request->request('url', '', 'trim');
        if ($this->auth->id) {
            $this->success(__('You\'ve logged in, do not login again'), $url ? $url : url('user/index'));
        }
        if ($this->request->isPost()) {
            if ($this->request->post('code') != Cache::get('reg_code')) {
                $this->error('验证码错误或已过期');
            }


            $mobile = $this->request->post('mobile', '');
            $username = $this->request->post('username');
            $baby_nickname = $this->request->post('baby_nickname');
            $baby_ycq = $this->request->post('baby_ycq');
            $services_address = $this->request->post('services_address');
            $token = $this->request->post('__token__');
            $rule = [
                'mobile' => 'regex:/^1\d{10}$/',
                'username' => 'require|length:3,30',
                'baby_nickname' => 'require',
                'baby_ycq' => 'require',
                'services_address' => 'require',
                '__token__' => 'require|token',
            ];

            $msg = [
                'mobile' => 'Mobile is incorrect',
                'username.require' => 'Username can not be empty',
                'username.length' => 'Username must be 3 to 30 characters',
                'baby_nickname.require' => '宝宝昵称不能为空',
                'baby_ycq.require' => '预产期不能为空',
                'services_address.require' => '服务地址不能为空',
            ];
            $data = [
                'mobile' => $mobile,
                'username' => $username,
                'baby_nickname' => $baby_nickname,
                'baby_ycq' => $baby_ycq,
                'services_address' => $services_address,
                '__token__' => $token,
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
            }
            if ($this->auth->register($username, '', '', $mobile, ['baby_nickname' => $baby_nickname, 'baby_ycq' => $baby_ycq, 'services_address' => $services_address])) {
                $this->success(__('Sign up successful'), $url ? $url : url('user/index'));
                //注册成功删除缓存
                Cache::rm('reg_code');
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        //判断来源
        $referer = $this->request->server('HTTP_REFERER');
        if (!$url && (strtolower(parse_url($referer, PHP_URL_HOST)) == strtolower($this->request->host()))
            && !preg_match("/(user\/login|user\/register|user\/logout)/i", $referer)) {
            $url = $referer;
        }
        $this->view->assign('url', $url);
        $this->view->assign('title', __('Register'));
        return $this->view->fetch();
    }

    /**
     * 会员登录
     */
    public function login()
    {
        $url = $this->request->request('url', '', 'trim');
        if ($this->auth->id) {
            $this->success(__('You\'ve logged in, do not login again'), $url ? $url : url('/'));
        }
        if ($this->request->isPost()) {
            $mobile = $this->request->post('mobile');
            $code = $this->request->post('code');

            $captcha = $this->request->post('captcha');
            $token = $this->request->post('__token__');


//            pr(Cache::get('reg_code'));
//            die;
            $rule = [
                'mobile' => 'regex:/^1\d{10}$/',
                'captcha' => 'require|captcha',
                '__token__' => 'require|token',
                'code' => 'require'
            ];

            $msg = [
                'mobile' => 'Mobile is incorrect',
                'captcha.require' => '图形验证码不能为空',
                'captcha.captcha' => '图形验证码错误',
                'code' => '手机验证码不能为空',

            ];
            $data = [
                'mobile' => $mobile,
                'captcha' => $captcha,
                '__token__' => $token,
                'code' => $code
            ];
            $validate = new Validate($rule, $msg);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
                return false;
            }
            if ($code != Cache::get('reg_code')) {
                $this->error('验证码错误或已过期');
                return false;
            }
            if ($this->auth->login($mobile)) {
                //登录成功删除缓存
                Cache::rm('reg_code');
                $this->success(__('Logged in successful'), $url ? $url : url('/'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        //判断来源
        $referer = $this->request->server('HTTP_REFERER');
        if (!$url && (strtolower(parse_url($referer, PHP_URL_HOST)) == strtolower($this->request->host()))
            && !preg_match("/(user\/login|user\/register|user\/logout)/i", $referer)) {
            $url = $referer;
        }
        $this->view->assign('url', $url);
        $this->view->assign('title', __('Login'));
        return $this->view->fetch();
    }

    /**
     * 注销登录
     */
    public function logout()
    {
        //注销本站
        $this->auth->logout();
        $this->success(__('Logout successful'), url('user/index'));
    }

    /**
     * 个人信息
     */
    public function profile()
    {
        $this->view->assign('title', __('Profile'));
        return $this->view->fetch();
    }

    /**
     * 修改密码
     */
    public function changepwd()
    {
        if ($this->request->isPost()) {
            $oldpassword = $this->request->post("oldpassword");
            $newpassword = $this->request->post("newpassword");
            $renewpassword = $this->request->post("renewpassword");
            $token = $this->request->post('__token__');
            $rule = [
                'oldpassword' => 'require|length:6,30',
                'newpassword' => 'require|length:6,30',
                'renewpassword' => 'require|length:6,30|confirm:newpassword',
                '__token__' => 'token',
            ];

            $msg = [
            ];
            $data = [
                'oldpassword' => $oldpassword,
                'newpassword' => $newpassword,
                'renewpassword' => $renewpassword,
                '__token__' => $token,
            ];
            $field = [
                'oldpassword' => __('Old password'),
                'newpassword' => __('New password'),
                'renewpassword' => __('Renew password')
            ];
            $validate = new Validate($rule, $msg, $field);
            $result = $validate->check($data);
            if (!$result) {
                $this->error(__($validate->getError()), null, ['token' => $this->request->token()]);
                return false;
            }

            $ret = $this->auth->changepwd($newpassword, $oldpassword);
            if ($ret) {
                $this->success(__('Reset password successful'), url('user/login'));
            } else {
                $this->error($this->auth->getError(), null, ['token' => $this->request->token()]);
            }
        }
        $this->view->assign('title', __('Change password'));
        return $this->view->fetch();
    }
}
