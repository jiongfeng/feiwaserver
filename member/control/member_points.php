<?php
/**
 * 积分管理
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');
class member_pointsControl extends BaseMemberControl {
    public function indexFeiwa(){
        $this->points_logFeiwa();
        exit;
    }
    public function __construct() {
        parent::__construct();
        /**
         * 读取语言包
         */
        Language::read('member_member_points,member_pointorder');
        /**
         * 判断系统是否开启积分功能
         */
        if (C('points_isuse') != 1){
            showMessage(Language::get('points_unavailable'),urlMall('member', 'home'),'html','error');
        }
    }
    /**
     * 积分日志列表
     */
    public function points_logFeiwa(){
        $condition_arr = array();
        $condition_arr['pl_memberid'] = $_SESSION['member_id'];
        if ($_GET['stage']){
            $condition_arr['pl_stage'] = $_GET['stage'];
        }
        $condition_arr['saddtime'] = strtotime($_GET['stime']);
        $condition_arr['eaddtime'] = strtotime($_GET['etime']);
        if($condition_arr['eaddtime'] > 0) {
            $condition_arr['eaddtime'] += 86400;
        }
        $condition_arr['pl_desc_like'] = $_GET['description'];
        //分页
        $page   = new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');
        //查询积分日志列表
        $points_model = Model('points');
        $list_log = $points_model->getPointsLogList($condition_arr,$page,'*','');
        //信息输出
        self::profile_menu('points');
        Tpl::output('show_page',$page->show());
        Tpl::output('list_log',$list_log);
        Tpl::showpage('member_points');
    }
    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @param array     $array      附加菜单
     * @return
     */
    private function profile_menu($menu_key='',$array=array()) {
        $menu_array = array(
            1=>array('menu_key'=>'points',  'menu_name'=>'积分明细',    'menu_url'=>'index.php?app=member_points'),
            2=>array('menu_key'=>'orderlist','menu_name'=>'积分兑换',    'menu_url'=>'index.php?app=member_pointorder&feiwa=orderlist')
        );
        if(!empty($array)) {
            $menu_array[] = $array;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
