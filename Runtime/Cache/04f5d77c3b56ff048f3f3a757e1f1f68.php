<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>kids grow system</title>
<link rel="icon" href="__ROOT__/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="__ROOT__/favicon.ico" type="image/x-icon" />
<link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/wy.js"></script>
<style type="text/css">
.wml{margin-left:-20px;}
</style>
</head>
<body style='background:url(__PUBLIC__/img/1024x768girl.jpg) repeat-x;'>
<form class="form-horizontal"  name="myForm" action="__ROOT__/index/reg/" method="post">
    <div style="width:500px;height:320px;margin:5% auto;border:2px #f6f8f9 solid;">
        <fieldset>
            <legend style="margin-bottom:12px;text-align:center;"><span><?php echo APP_NAME;?></span></legend>
 
            <div id="msg" style="weidth:50px;height:20px;margin-bottom:5px;margin-left:200px;color:#ff0000;"></div>
            <div class="control-group wml">
                <div class="controls input-prepend">
                <span class="add-on"><i class="icon-user"></i></span>
                <input id="username" name="username" type="text" onblur="checkUsername();" placeholder="用户名" value="" maxlength=32 />
                <span id="span1" style="color:#ff0000;vertical-align:middle;font-size:25px;"></span>
              </div>
            </div>
      
            <div class="control-group wml">
                <div class="controls input-prepend">
                <span class="add-on"><i class="icon-leaf"></i></span>
                  <input id="pwd" name="pwd" type="password" onblur="checkPwd();" placeholder="密码" value="" maxlength=32 />
                  <span id="span2" style="color:#ff0000;vertical-align:middle;font-size:25px;"></span>
                </div>
            </div>
      
            <div class="control-group wml">
                <div class="controls input-prepend">
                <span class="add-on"><i class="icon-repeat"></i></span>
                  <input id="pwds" name="pwds" type="password" onblur="checkPwdS();" placeholder="密码确认" value="" maxlength=32>
                  <span id="span4" style="color:#ff0000;vertical-align:middle;font-size:25px;"></span>
                </div>
            </div>
            
            <div class="control-group wml">
                <div class="controls input-prepend" style='display:block;'>
                    <span class="add-on"><i class="icon-qrcode"></i></span>
                    <input class="span2" id="checkcode" onblur="checkCode();" name="checkcode" maxlength=4 type="text" placeholder="验证码">
                    <img src="__ROOT__/index/checkcode/" style="cursor:pointer;" onclick="this.src='__ROOT__/index/checkcode/id/'+Math.random()*5;"/>
                    <span id="span3" style="color:#ff0000;vertical-align:middle;font-size:25px;margin-left:4px;"></span>
                </div>
            </div>
      
            <div class="control-group wml">
              <div class="controls">
                <button type="submit" class="btn" onclick="javascript:return login();">注册</button>
                <a class="btn" style="margin-left:20px;" href="__ROOT__">返回</a>
              </div>
            </div>
        </fieldset>
    </div>
</form>
<script>
var error = "<?php echo $error; ?>";
if(error==1){
    document.getElementById('msg').innerHTML = '用户名已存在!';
}

function checkUsername(){
    document.getElementById('msg').innerHTML = '';
    var reg = /<|>|'|;|\/|&|#|"|'|\s/;
    var username = document.getElementById('username').value;
    var len = (username.length+(username.match(/[^\x00-\xff]/g) ||"").length);
    if(len<4 || len>32){
        document.getElementById('msg').innerHTML = '用户名不能小于4个字';
        document.getElementById('span1').innerHTML='×';
    }else if(reg.test(username)){
        document.getElementById('span1').innerHTML='×';
    }else{
        document.getElementById('span1').innerHTML='';
    }
}

function checkPwd(){
    document.getElementById('msg').innerHTML = '';
    var pwd = document.getElementById('pwd').value;
    var pwds = document.getElementById('pwds').value;
    if( pwds!='' && pwd!=pwds ){
        document.getElementById('msg').innerHTML = '两次密码不一样';
        document.getElementById('span4').innerHTML='×';
        return false;
    }
    var reg = /^[a-zA-Z0-9|~!@#$%^&*()]+$/;
    if(pwd.length<6 || pwd.length>32){
        document.getElementById('msg').innerHTML = '密码至少6位';
        document.getElementById('span2').innerHTML='×';
     }else if(!reg.test(pwd)){
         document.getElementById('span2').innerHTML='×';
     }else{
         document.getElementById('span2').innerHTML='';
     }
}

function checkPwdS(){
    document.getElementById('msg').innerHTML = '';
    var pwd = document.getElementById('pwd').value;
    var pwds = document.getElementById('pwds').value;
    if(pwd!=pwds){
        document.getElementById('msg').innerHTML = '两次密码不一样';
        document.getElementById('span4').innerHTML='×';
        return false;
    }
    var reg = /^[a-zA-Z0-9|~!@#$%^&*()]+$/;
    if(pwds.length<6 || pwds.length>32){
        document.getElementById('msg').innerHTML = '密码至少6位';
        document.getElementById('span4').innerHTML='×';
     }else if(!reg.test(pwds)){
         document.getElementById('span4').innerHTML='×';
     }else{
         document.getElementById('span4').innerHTML='';
     }
}

function checkCode(){
    document.getElementById('msg').innerHTML = '';
    var checkcode = document.getElementById('checkcode').value;
    if(checkcode.length!=4){
        document.getElementById('msg').innerHTML = '验证码不正确';
        document.getElementById('span3').innerHTML='×';
        return false;
    }
    var url = "__ROOT__/index/ajaxcheckrandcode/checkcode/"+checkcode;
    var flag = getAjaxData(url);
    if(flag!=1){
        document.getElementById('span3').innerHTML='×';
    }else{
        document.getElementById('span3').innerHTML='';
    }
}

function login(){
    var span1 = document.getElementById('span1').innerText;
    var span2 = document.getElementById('span2').innerText;
    var span3 = document.getElementById('span3').innerText;
    var span4 = document.getElementById('span4').innerText;
    var username = document.getElementById('username').value;
    var pwd = document.getElementById('pwd').value;
    var pwds = document.getElementById('pwds').value;
    var checkcode = document.getElementById('checkcode').value;
    if(username==''||pwd==''||checkcode==''||pwds==''||span1=='×'||span2=='×'||span3=='×'||span4=='×'){
        return false;
    }
    $("form").submit();
}
</script>
</body>
</html>