<?php
/**
 * 基类
 * @author 陈聪
 */
class BaseAction extends Action{
    protected $_uid;
    protected $_uinfo;
    public function _empty(){
        echo '您输入了非法Action,请重新输入！';
        exit;
    }

    //初始化
    public function __construct(){
        if(!session('uid')){
            $this->error("会话失效,请重新登录",__ROOT__);
        }
        $this->_uid = session('uid');
        $this->_uinfo=session('uinfo');
    }
}

?>