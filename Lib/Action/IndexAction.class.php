<?php
/**
 * @desc 首页,包括登陆、注册、注销等方法
 * @author cc
 *
 */
class IndexAction extends Action {
    public function _empty(){
        echo '您输入了非法Action,请重新输入！';
        exit;
    }

    //初始化
    public function __construct(){
    }

    /**
     * @desc    登录页面
     * @author  wy
     * @date    2013-4-26 17:42:28
     */
    public function index(){
        $this->display();
    }

    /**
     * @desc    登录逻辑处理
     * @author  陈聪
     * @date    2013-05-21 16:12:12
     */
    public function login(){
        $name = $this->_post("name","strip_tags","");
        $pwd = $this->_post("pwd","strip_tags","");
        $checkcode = $this->_post("checkcode");
        if($name == ''|| $pwd == '' || $checkcode == ''){
            $this->redirect("/index/index/error/1/");
        }
        if(strtolower(trim($checkcode)) != strtolower($_SESSION['randcode'])){
            $this->redirect("/index/index/error/2/");
        }
        $m = M("home_user");
        $info = $m->getByName($name);
        if(!isset($info) || !isset($info['uid'])){
            $this->redirect("/index/index/error/3/");
        }
        $pwd = md5($pwd.$info['salt'].APP_NAME);
        if($pwd != $info['pwd']){
            $this->redirect("/index/index/error/4/");
        }
        session('uid',$info['uid']);
        session('uinfo',$info);
        $this->redirect("/");
    }
    public function regindex(){
        $this->display();
    }
    /**
     * @desc 注册
     */
    public function reg(){
        $name = $this->_post('name','strip_tags','');
        $pwd = $this->_post('pwd','strip_tags','');
        $checkcode = $this->_post('checkcode','strip_tags','');

        if($name==''||$pwd==''||$checkcode==''){
            $this->redirect("/index/regindex/error/1/");
        }
        if(strtolower(trim($checkcode)) != strtolower($_SESSION['randcode'])){
            $this->redirect("/index/regindex/error/2/");
        }
        $m = M("home_user");
        $rs = $m->getByName($name);
        if(isset($rs) && isset($rs['uid'])){
            $this->redirect("/index/regindex/error/3/");
        }
        $salt = substr(uniqid(rand()),-8);
        $pwd = md5($pwd.$salt.APP_NAME);
        $ip = getClientIP();
        $flag = $m->add(array('name'=>$name,'pwd'=>$pwd,'salt'=>$salt,'ip'=>$ip));
        if($flag == 1){
            $this->success('注册成功!',__ROOT__.'/index/');
        }else{
            session('userid',null);
            $this->error('注册失败!',__ROOT__.'/index/reg/');
        }
    }
    /**
     * @desc    生成验证码
     * @author  wy
     * @date    2013-4-26 17:22:05
     */
    public function checkcode(){
        $this->display();
    }
    /**
     * @desc    ajax检查验证码
     * @author  wy
     * @date    2013-4-26 17:23:03
     */
    public function ajaxCheckRandcode(){
        $checkcode = $this->_get("checkcode");
        if(strtolower(trim($checkcode)) != strtolower($_SESSION['randcode'])){
            echo 2;//验证码错误
        }else{
            echo 1;
        }
        exit;
    }
    /**
     * @desc    注销
     * @author  wy
     * @date    2013-4-26 17:41:46
     */
    public function logout(){
        session('uid',null);
        session('uinfo',null);
        $this->success('注销成功!',__ROOT__);
    }
}