<?php
/**
 * 接收微信支付异步通知回调地址
 *
 * 
 * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */
error_reporting(7);
$_GET['app']	= 'payment';
$_GET['feiwa']		= 'wxpay_notify';
require_once(dirname(__FILE__).'/../../../index.php');
