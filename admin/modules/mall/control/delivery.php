<?php
/**
 * 物流自提服务站管理
 *
 *
 *
 *
 * @山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 */



defined('ByFeiWa') or exit('Access Invalid!');
class deliveryControl extends SystemControl{
    public function __construct() {
        parent::__construct();
    }

    /**
     * 物流自提服务站列表
     */
    public function indexFeiwa()
    {
        if ($_GET['sign'] == 'verify') {
            Tpl::output('sign', 'verify');
        }
				//feiwa.org
		Tpl::setDirquna('mall');
        Tpl::showpage('delivery.index');
    }

    /**
     * 物流自提服务站列表XML
     */
    public function index_xmlFeiwa()
    {
        $condition = array();
        if (strlen($q = trim($_REQUEST['query']))) {
            switch ($_REQUEST['qtype']) {
                case 'dlyp_name':
                case 'dlyp_truename':
                case 'dlyp_address_name':
                case 'dlyp_area_info':
                case 'dlyp_address':
                    $condition[$_REQUEST['qtype']] = array('like', '%' . $q . '%');
                    break;
            }
        }

        switch ($_REQUEST['sortname']) {
            case 'dlyp_addtime':
                $sort = $_REQUEST['sortname'];
                break;
            default:
                $sort = 'dlyp_id';
                break;
        }
        if ($_REQUEST['sortorder'] != 'asc') {
            $sort .= ' desc';
        }

        $model_dp = Model('delivery_point');
        if ($_GET['sign'] == 'verify') {
            $list = (array) $model_dp->getDeliveryPointWaitVerifyList($condition, $_REQUEST['rp'], $sort);
        } else {
            $list = (array) $model_dp->getDeliveryPointList($condition, $_REQUEST['rp'], $sort);
        }

        $states = $model_dp->getDeliveryState();

        $data = array();
        $data['now_page'] = $model_dp->shownowpage();
        $data['total_num'] = $model_dp->gettotalnum();

        foreach ($list as $val) {
            $i = array();

            $i['operation'] = <<<EOB
<a class="btn green" href="index.php?app=delivery&feiwa=order_list&dlyp_id={$val['dlyp_id']}"><i class="fa fa-list-alt"></i>查看订单</a>
<a class="btn blue" href="index.php?app=delivery&feiwa=edit_delivery&d_id={$val['dlyp_id']}"><i class="fa fa-pencil-square-o"></i>编辑</a>
EOB;

            $i['dlyp_name'] = $val['dlyp_name'];
            $i['dlyp_truename'] = $val['dlyp_truename'];
            $i['dlyp_address_name'] = $val['dlyp_address_name'];
            $i['dlyp_area_info'] = $val['dlyp_area_info'];
            $i['dlyp_address'] = $val['dlyp_address'];

            $i['dlyp_state'] = $states[$val['dlyp_state']];

            $i['dlyp_addtime'] = date('Y-m-d H:i:s', $val['dlyp_addtime']);

            $data['list'][$val['dlyp_id']] = $i;
        }

        echo Tpl::flexigridXML($data);
        exit;
    }

    /**
     * 物流自提服务站设置
     */
    public function settingFeiwa() {
        $list_setting = Model('setting')->getListSetting();
        Tpl::output('list_setting',$list_setting);
						//feiwa.org
		Tpl::setDirquna('mall');
        Tpl::showpage('delivery.setting');
    }
    /**
     * 提说站设置保存
     */
    public function save_settingFeiwa() {
        if (!chksubmit()){
            showMessage(L('feiwa_common_save_fail'));
        }
        $update_array = array();
        $update_array['delivery_isuse'] = intval($_POST['delivery_isuse']);
        $result = Model('setting')->updateSetting($update_array);
        if ($result === true){
            $log = '开启';
            if ($update_array['delivery_isuse'] == 0) {
                $log = '关闭';
                // 删除相关联的收货地址
                Model('address')->delAddress(array('dlyp_id' => array('neq', 0)));
            }
            $this->log($log.'物流自提服务站功能', 1);
            showMessage(L('feiwa_common_save_succ'));
        }else {
            $this->log($log.'物流自提服务站功能', 0);
            showMessage(L('feiwa_common_save_fail'));
        }
    }
    /**
     * 编辑物流自提服务站信息
     */
    public function edit_deliveryFeiwa() {
        $dlyp_id = intval($_GET['d_id']);
        if ($dlyp_id <= 0) {
            showMessage(L('param_error'));
        }
        $dlyp_info = Model('delivery_point')->getDeliveryPointInfo(array('dlyp_id' => $dlyp_id));
        if (empty($dlyp_info)) {
            showMessage(L('param_error'));
        }
        Tpl::output('dlyp_info', $dlyp_info);
						//feiwa.org
		Tpl::setDirquna('mall');
        Tpl::showpage('delivery.edit');
    }
    /**
     * 编辑保存
     */
    public function save_editFeiwa() {
        $dlyp_id = intval($_POST['did']);
        if (!chksubmit() || $dlyp_id <= 0) {
            showMessage(L('param_error'));
        }
        $where = array('dlyp_id' => $dlyp_id);
        $update = array();
        $update['dlyp_mobile']          = $_POST['dmobile'];
        $update['dlyp_telephony']       = $_POST['dtelephony'];
        $update['dlyp_address_name']    = $_POST['daddressname'];
        $update['dlyp_address']         = $_POST['daddress'];
        if ($_POST['dpasswd'] != '') {
            $update['dlyp_passwd']      = md5($_POST['dpasswd']);
        }
        $update['dlyp_area_1']          = intval($_POST['area_id_1']);
        $update['dlyp_area_2']          = intval($_POST['area_id_2']);
        $update['dlyp_area_3']          = intval($_POST['area_id_3']);
        $update['dlyp_area_4']          = intval($_POST['area_id_4']);
        $update['dlyp_area']            = intval($_POST['area_id']);
        $update['dlyp_area_info']       = $_POST['region'];
        $update['dlyp_state']           = intval($_POST['dstate']);
        $update['dlyp_fail_reason']     = $_POST['fail_reason'];
        $result = Model('delivery_point')->editDeliveryPoint($update, $where);
        if ($result) {
            // 删除相关联的收货地址
            Model('address')->delAddress(array('dlyp_id' => $dlyp_id));
            $this->log('编辑物流自提服务站功能，ID：'.$dlyp_id, 1);
            showMessage(L('feiwa_common_op_succ'), urlAdminMall('delivery', 'index'));
        } else {
            $this->log('编辑物流自提服务站功能，ID：'.$dlyp_id, 0);
            showMessage(L('feiwa_common_op_fail'));
        }
    }

    /**
     * 订单列表
     */
    public function order_listFeiwa()
    {
        $dlyp_id = intval($_GET['dlyp_id']);
        if ($dlyp_id <= 0) {
            showMessage(L('param_error'));
        }

        $dlyp_info = Model('delivery_point')->getDeliveryPointInfo(array('dlyp_id' => $dlyp_id));
        if (empty($dlyp_info)) {
            showMessage(L('param_error'));
        }
        Tpl::output('dlyp_info', $dlyp_info);

        Tpl::output('dlyp_id', $dlyp_id);
						//feiwa.org
		Tpl::setDirquna('mall');
        Tpl::showpage('delivery.order_list');
    }

    /**
     * 订单列表
     */
    public function order_list_xmlFeiwa()
    {
        $condition = array();
        if (strlen($q = trim($_REQUEST['query']))) {
            switch ($_REQUEST['qtype']) {
                case 'order_sn':
                case 'shipping_code':
                case 'reciver_name':
                case 'reciver_mobphone':
                case 'reciver_telphone':
                    $condition[$_REQUEST['qtype']] = array('like', '%' . $q . '%');
                    break;
            }
        }
        $condition['dlyp_id'] = (int) $_GET['dlyp_id'];

        $model_do = Model('delivery_order');
        $list = (array) $model_do->getDeliveryOrderList($condition, '*', $_REQUEST['rp']);
        $states = $model_do->getDeliveryOrderState();

        $data = array();
        $data['now_page'] = $model_do->shownowpage();
        $data['total_num'] = $model_do->gettotalnum();

        foreach ($list as $val) {
            $i = array();
            $i['operation'] = '<span>--</span>';

            $i['order_sn'] = $val['order_sn'];
            $i['shipping_code'] = $val['shipping_code'];
            $i['reciver_name'] = $val['reciver_name'];
            $i['reciver_mobphone'] = $val['reciver_mobphone'];
            $i['reciver_telphone'] = $val['reciver_telphone'];

            $i['dlyo_state'] = $states[$val['dlyo_state']];

            $data['list'][$val['order_id']] = $i;
        }

        echo Tpl::flexigridXML($data);
        exit;
    }
}
