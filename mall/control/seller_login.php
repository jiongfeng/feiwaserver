<?php
/**
 * 店铺卖家登录
 *
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');

class seller_loginControl extends BaseSellerControl {

    public function __construct() {
        parent::__construct();
        if (!empty($_SESSION['seller_id'])) {
            @header('location: index.php?app=seller_center');die;
        }
    }

    public function indexFeiwa() {
        $this->show_loginFeiwa();
    }

    public function show_loginFeiwa() {
        Tpl::output('nchash', getNchash());
        Tpl::setLayout('null_layout');
        Tpl::showpage('login');
    }

    public function loginFeiwa() {
        $result = chksubmit(true,true,'num');
        if ($result){
            if ($result === -11){
                showDialog('用户名或密码错误','','error');
            } elseif ($result === -12){
                showDialog('验证码错误','','error');
            }
        } else {
            showDialog('非法提交','','error');
        }

        $model_seller = Model('seller');
        $seller_info = $model_seller->getSellerInfo(array('seller_name' => $_POST['seller_name']));
        if($seller_info) {

            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo(
                array(
                    'member_id' => $seller_info['member_id'],
                    'member_passwd' => md5($_POST['password'])
                )
            );
            if($member_info) {
                // 更新卖家登陆时间
                $model_seller->editSeller(array('last_login_time' => TIMESTAMP), array('seller_id' => $seller_info['seller_id']));

                $model_seller_group = Model('seller_group');
                $seller_group_info = $model_seller_group->getSellerGroupInfo(array('group_id' => $seller_info['seller_group_id']));

                $model_store = Model('store');
                $store_info = $model_store->getStoreInfoByID($seller_info['store_id']);

                $_SESSION['is_login'] = '1';
                $_SESSION['member_id'] = $member_info['member_id'];
                $_SESSION['member_name'] = $member_info['member_name'];
                $_SESSION['member_email'] = $member_info['member_email'];
                $_SESSION['is_buy'] = $member_info['is_buy'];
                $_SESSION['avatar'] = $member_info['member_avatar'];

                $_SESSION['grade_id'] = $store_info['grade_id'];
                $_SESSION['seller_id'] = $seller_info['seller_id'];
                $_SESSION['seller_name'] = $seller_info['seller_name'];
                $_SESSION['seller_is_admin'] = intval($seller_info['is_admin']);
                $_SESSION['store_id'] = intval($seller_info['store_id']);
                $_SESSION['store_name'] = $store_info['store_name'];
                $_SESSION['store_avatar'] = $store_info['store_avatar'];
                $_SESSION['is_own_mall'] = (bool) $store_info['is_own_mall'];
                $_SESSION['bind_all_gc'] = (bool) $store_info['bind_all_gc'];
                $_SESSION['seller_limits'] = explode(',', $seller_group_info['limits']);
                $_SESSION['seller_group_id'] = $seller_info['seller_group_id'];
                $_SESSION['seller_gc_limits'] = $seller_group_info['gc_limits'];
                if($seller_info['is_admin']) {
                    $_SESSION['seller_group_name'] = '管理员';
                    $_SESSION['seller_smt_limits'] = false;
                } else {
                    $_SESSION['seller_group_name'] = $seller_group_info['group_name'];
                    $_SESSION['seller_smt_limits'] = explode(',', $seller_group_info['smt_limits']);
                }
                if(!$seller_info['last_login_time']) {
                    $seller_info['last_login_time'] = TIMESTAMP;
                }
                $_SESSION['seller_last_login_time'] = date('Y-m-d H:i', $seller_info['last_login_time']);
                $seller_menu = $this->getSellerMenuList($seller_info['is_admin'], explode(',', $seller_group_info['limits']));
                $_SESSION['seller_menu'] = $seller_menu['seller_menu'];
                $_SESSION['seller_function_list'] = $seller_menu['seller_function_list'];
                if(!empty($seller_info['seller_quicklink'])) {
                    $quicklink_array = explode(',', $seller_info['seller_quicklink']);
                    foreach ($quicklink_array as $value) {
                        $_SESSION['seller_quicklink'][$value] = $value ;
                    }
                }
                setNcCookie('auto_login', '', -3600);
                $this->recordSellerLog('登录成功');
                redirect('index.php?app=seller_center');
            } else {
                showMessage('用户名密码错误', '', '', 'error');
            }
        } else {
            showMessage('用户名密码错误', '', '', 'error');
        }
    }
}
