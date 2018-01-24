<?php
// memcache定义
define('MEMCACHE_HOST', "127.0.0.1");
define('MEMCACHE_PORT',11211);
define('MEMCACHE_FLAG', 0);
define('MEMCACHE_EXPIRE', 3600);

// token快过期时间
define('TOKEN_EXPIRE_CHECK_DURATION', 3600 * 23);

// token 过期时间
define('TOKEN_EXPIRE_DURATION',  3600 * 24);
define('URL', "http://{$_SERVER['SERVER_NAME']}:97/lailong/");
define('PINKAGE', '600');//免邮
define('POSTAGE', '20');//邮费
define('POINTS_RATIO', '0.01');//积分换算比例
define('rebate_money', '0.1');//返利金额
define('rebate_points', '0.01');//返利积分
define('order_time', 60 * 20);//订单过期时间
define('LOG_DIR', "{$_SERVER['DOCUMENT_ROOT']}/jile/logs/");//log地址
define('share_url', "http://{$_SERVER['SERVER_NAME']}:97/jile/api/user/share_goods.php");//分享统计地址

define('bask_points', 20);//晒单积分
define('pl_points', 20);//评论积分
define('login_points', 10);//评论积分

//极光推送参数
define('appkeys','7bd57e12bd80a01845ae435c');	//appkeyֵ
define('masterSecret', 'c87d5b518b3757c6a8ca0750');    //API MasterSecertֵ
define('platform', 'android,ios');

//订单推送信息
define('order_msg1', '您的订单%s支付成功');
define('order_msg2', '您的订单%s完成交易');
define('order_msg3', '您的订单%s已取消');
define('order_msg4', '您的订单%s已发货');
define('order_msg5', '退换货申请已通过，请将商品寄回');
define('order_msg6', '退换货申请未通过审核，请联系商户');
define('order_msg7', '确认收到货物，请等待审核');
//商品推送信息
define('goods_msg1', '品牌%s更新了商品%s');
define('goods_msg2', '您收藏的商品%s上架了');
define('goods_msg3', '您收藏的商品%s下架了');
//容联云通信参数
define('AccountSid', '8a48b55150b36d920150b6d4718008aa');
define('AccountToken', '8dbb19cc102441e5b2c70c5e13392574');
define('AppId', 'aaf98f895147cd2a015147deb3a20002');
//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
//生产环境（用户应用上线使用）：app.cloopen.com
define('ServerIP', 'app.cloopen.com');
define('ServerPort', '8883');
define('SoftVersion', '2013-12-26');
define('tempId', '52683');//注册模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
define('tempId2', '52268');//找回密码模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
define('tempId3', '52268');//绑定手机模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID

//crm接口调用
define('Token', "041b6b6ff8b5eb2d4d3a4e85eee47d50");//crmapi

