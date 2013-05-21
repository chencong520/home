<?php
/**
 * @desc 安全过滤函数
 * @param string $string 字符串
 * @return string 过滤后的字符串
 */
function safe_replace($string) {
    $string = str_replace('%20','',$string);
    $string = str_replace('%27','',$string);
    $string = str_replace('%2527','',$string);
    $string = str_replace('*','',$string);
    //$string = str_replace("'",'',$string);
    $string = str_replace('"','',$string);
    $string = str_replace(';','',$string);
    $string = str_replace('<','<',$string);
    $string = str_replace('>','>',$string);
    $string = str_replace("{",'',$string);
    $string = str_replace('}','',$string);
    $string = str_replace('\\','',$string);
    $string = str_replace('\0','',$string);
    //$string = str_replace('or','',$string);
    return $string;
}
/**
 * @desc 获取客户端IP
 * @return string IP结果
 */
function getClientIP(){
    $ip = null;
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            /* 取X-Forwarded-For中第x个非unknown的有效IP字符? */
            foreach ($arr as $xip){
                $xip = trim($xip);
                if ($xip != 'unknown'){
                    $ip = $xip;
                    break;
                }
            }
        } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])){
                $ip = $_SERVER['REMOTE_ADDR'];
            }else{
                $ip = '0.0.0.0';
            }
        }
    }else{
        if (getenv('HTTP_X_FORWARDED_FOR')){
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }else if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else {
            $ip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $ip, $onlineip);
    $ip = ! empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    return $ip;
}
?>