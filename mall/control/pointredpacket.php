<?php
/**
 * 红包
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');
class pointredpacketControl extends BasePointMallControl {
    public function __construct() {
        parent::__construct();
        //判断系统是否开启红包功能
        if (C('redpacket_allow') != 1){
            showDialog('系统未开启红包功能','index.php','error');
        }
    }
    public function indexFeiwa(){
        $this->pointredpacketFeiwa();
    }
    /**
     * 红包列表
     */
    public function pointredpacketFeiwa(){
        //查询会员及其附属信息
        parent::pointmallMInfo();
        $model_redpacket = Model('redpacket');
        //模板状态
        $templatestate_arr = $model_redpacket->getTemplateState();
        //领取方式
        $gettype_arr = $model_redpacket->getGettypeArr();
        
        $model_member = Model('member');
        //查询会员信息
        $member_info = $model_member->getMemberInfoByID($_SESSION['member_id']);
                
        //查询红包列表
        $where = array();
        $where['rpacket_t_gettype']     = $gettype_arr['points']['sign'];
        $where['rpacket_t_state']       = $templatestate_arr['usable']['sign'];
        //$where['rpacket_t_start_date']  = array('elt',time());
        $where['rpacket_t_end_date']    = array('egt',time());
        if (intval($_GET['price']) > 0){
            $where['voucher_t_price'] = intval($_GET['price']);
        }
        //查询仅我能兑换和所需积分
        $points_filter = array();
        if (intval($_GET['isable']) == 1){
            $points_filter['isable'] = $member_info['member_points'];
        }
        if (intval($_GET['points_min']) > 0){
            $points_filter['min'] = intval($_GET['points_min']);
        }
        if (intval($_GET['points_max']) > 0){
            $points_filter['max'] = intval($_GET['points_max']);
        }
                
        if (count($points_filter) > 0){
            asort($points_filter);
            if (count($points_filter) > 1){
                $points_filter = array_values($points_filter);
                $where['rpacket_t_points'] = array('between',array($points_filter[0],$points_filter[1]));
            } else {
                if ($points_filter['min']){
                    $where['rpacket_t_points'] = array('egt',$points_filter['min']);
                } elseif ($points_filter['max']) {
                    $where['rpacket_t_points'] = array('elt',$points_filter['max']);
                } elseif (isset($points_filter['isable'])) {
                    $where['rpacket_t_points'] = array('elt',$points_filter['isable']);
                }
            }
        }
        //仅我能兑换的会员级别
        if (intval($_GET['isable']) == 1){
            $member_currgrade = $model_member->getOneMemberGrade($member_info['member_exppoints']);
            $member_info['member_grade_level'] = $member_currgrade?$member_currgrade['level']:0;
            $where['rpacket_t_mgradelimit'] = array('elt',$member_info['member_grade_level']);
        }
        
        //排序
        switch ($_GET['orderby']){
            case 'exchangenumdesc':
                $orderby = 'rpacket_t_giveout desc,';
                break;
            case 'exchangenumasc':
                $orderby = 'rpacket_t_giveout asc,';
                break;
            case 'pointsdesc':
                $orderby = 'rpacket_t_points desc,';
                break;
            case 'pointsasc':
                $orderby = 'rpacket_t_points asc,';
                break;
        }
        $orderby .= 'rpacket_t_id desc';
        $rptlist = $model_redpacket->getRptTemplateList($where, '*', 0, 18, $orderby);
        Tpl::output('rptlist',$rptlist);
        Tpl::output('show_page', $model_redpacket->showpage(2));
        //分类导航
        $nav_link = array(
                0=>array('title'=>L('homepage'),'link'=>MALL_SITE_URL),
                1=>array('title'=>'积分中心','link'=>urlMall('pointmall','index')),
                2=>array('title'=>'红包列表')
        );
        Tpl::output('nav_link_list', $nav_link);
        Tpl::showpage('pointredpacket');
    }
    
    /**
     * 兑换红包
     */
    public function rptexchangeFeiwa(){
        $tid = intval($_GET['tid']);
        if($tid <= 0){
            $tid = intval($_POST['tid']);
        }
        if($_SESSION['is_login'] != '1'){
            $js = "login_dialog();";
            showDialog('','','js',$js);
        }elseif ($_GET['dialog']){
            $js = "CUR_DIALOG = ajax_form('rptexchange', '您要兑换的红包', 'index.php?app=pointredpacket&feiwa=rptexchange&tid={$tid}', 550);";
            showDialog('','','js',$js);
            die;
        }
        $result = true;
        $message = "";
        if ($tid <= 0){
            $result = false;
            L('wrong_argument');
        }
        if ($result){
            //查询可兑换红包模板信息
            $template_info = Model('redpacket')->getCanChangeTemplateInfo($tid,intval($_SESSION['member_id']));
            if ($template_info['state'] == false){
                $result = false;
                $message = $template_info['msg'];
            }else {
                //查询会员信息
                $member_info = Model('member')->getMemberInfoByID($_SESSION['member_id'],'member_points');
                Tpl::output('member_info',$member_info);
                Tpl::output('template_info',$template_info['info']);
            }
        }
        Tpl::output('message',$message);
        Tpl::output('result',$result);
        Tpl::showpage('pointredpacket.exchange','null_layout');
    }
    /**
     * 兑换红包保存信息
     */
    public function rptexchange_saveFeiwa(){
        if($_SESSION['is_login'] != '1'){
            $js = "login_dialog();";
            showDialog('','','js',$js);
        }
        $tid = intval($_POST['tid']);
        $js = "DialogManager.close('rptexchange');";
        if ($tid <= 0){
            showDialog(L('wrong_argument'),'','error',$js);
        }
        $model_redpacket = Model('redpacket');
        //验证是否可以兑换红包
        $data = $model_redpacket->getCanChangeTemplateInfo($tid,intval($_SESSION['member_id']));
        if ($data['state'] == false){
            showDialog($data['msg'],'','error',$js);
        }
        //添加红包信息
        $data = $model_redpacket->exchangeRedpacket($data['info'],$_SESSION['member_id'],$_SESSION['member_name']);
        if ($data['state'] == true){
            showDialog($data['msg'],'','succ',$js);
        } else {
            showDialog($data['msg'],'','error',$js);
        }
    }
}

