<?php
header('Content-Type: text/html; charset=utf-8');
require_once "email.class.php";
    function sendmail($email,$code,$type){
        //******************** 配置信息 ********************************
        $smtpserver = "c1.icoremail.net";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "blocco5@blocco5.com";//SMTP服务器的用户邮箱
        $smtpuser = "blocco5@blocco5.com";//SMTP服务器的用户帐号
        $smtppass = "stens123";//SMTP服务器的用户密码
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
        //************************ 配置信息 ****************************
        if (strlen($email) > 6 && preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email)){
            //邮箱注册发送验证码
            if($type==4){
                $mailtitle = '极乐电商邮箱注册：';//$_POST['title'];//邮件主题
                $mailcontent = '您的邮箱注册验证码为：'.$code;//"<h1>".$_POST['content']."</h1>";//邮件内容
            }
            //邮箱找回密码发送验证码
            if($type==5){
                $mailtitle = '极乐电商邮箱找回密码：';//$_POST['title'];//邮件主题
                $mailcontent = '您的邮箱找回密码验证码为：'.$code;//"<h1>".$_POST['content']."</h1>";//邮件内容
            }
            $smtpemailto = $email;//$_POST['toemail'];//发送给谁
            $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
            $smtp->debug = false;//是否显示发送的调试信息           
            $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
            if($state==""){
                return 102;//对不起，邮件发送失败！请检查邮箱填写是否有误。    
            }else{
                return 101;//恭喜！邮件发送成功！
            }
        }else{
            return 102;
        }
       
    }
?>