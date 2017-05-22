<?php
/**
 * 入口文件
 *
 * 统一入口，进行初始化信息
 *
 *
 * @copyright  Copyright (c) 2006-2015 FeiWa   (http://www.FeiWa.com)
 * @license    http://www.FeiWa.com/
 * @link       http://www.FeiWa.com/
 * @since      File available since Release v1.1
 */
define('BASE_PATH', str_replace('\\', '/', dirname(__FILE__)));
require __DIR__ . '/../feiwa.php';

session_save_path(BASE_DATA_PATH.DS.'session');
require_once(BASE_DATA_PATH.DS.'config/config.ini.php');
$site_url = $config['mall_site_url'];
$version = $config['version'];
$setup_date = $config['setup_date'];
$gip = $config['gip'];
$dbtype = $config['dbdriver'];
$dbcharset = $config['db']['1']['dbcharset'];
$dbserver = $config['db']['1']['dbhost'];
$dbserver_port = $config['db']['1']['dbport'];
$dbname = $config['db']['1']['dbname'];
$db_pre = $config['tablepre'];
$dbuser = $config['db']['1']['dbuser'];
$dbpasswd = $config['db']['1']['dbpwd'];
$lang_type = $config['lang_type'];
$cookie_pre = $config['cookie_pre'];
unset($config);

if ($_GET['app'] == 'toqq'){
    //define('MALL_SITE_URL',$site_url);
    if ($_GET['feiwa'] == 'g'){
        include 'api/qq/oauth/qq_callback.php';
    }else{
        include 'api/qq/oauth/qq_login.php';
    }
}elseif ($_GET['app'] == 'tosina'){
    //define('MALL_SITE_URL',$site_url);
    if ($_GET['feiwa'] == 'g'){
        include 'api/sina/callback.php';
    }else{
        include 'api/sina/index.php';
    }
}elseif ($_GET['app'] == 'sharebind'){
    //define('MALL_SITE_URL',$site_url);
    if($_GET['type'] == 'qqzone'){
        include BASE_DATA_PATH.DS.'api/snsapi/qqzone/oauth/qq_login.php';
    }elseif ($_GET['type'] == 'sinaweibo'){
        include BASE_DATA_PATH.DS.'api/snsapi/sinaweibo/index.php';
    }elseif ($_GET['type'] == 'qqweibo'){
        include BASE_DATA_PATH.DS.'api/snsapi/qqweibo/index.php';
    }
}
