<?php
/**
 * 买家商品咨询
 *
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');
class member_consultControl extends BaseMemberControl {
    public function __construct() {
        parent::__construct();
        Language::read('member_store_consult_index');
    }

    /**
     * 商品咨询首页
     */
    public function indexFeiwa(){
        $this->my_consultFeiwa();
    }

    /**
     * 查询买家商品咨询
     */
    public function my_consultFeiwa(){
        //实例化商品咨询模型
        $consult    = Model('consult');
        $page   = new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');
        $list_consult   = array();
        $search_array   = array();
        if($_GET['type'] != ''){
            if($_GET['type'] == 'to_reply'){
                if (C('dbdriver') == 'mysqli') {
                    $search_array['consult_reply']  = '';
                } else {
                    $search_array['consult_reply']  = array('exp', 'consult_reply IS NULL');
                }
            }
            if($_GET['type'] == 'replied'){
                if (C('dbdriver') == 'mysqli') {
                    $search_array['consult_reply']  = array('neq', '');
                } else {
                    $search_array['consult_reply']  = array('exp', 'consult_reply IS NOT NULL');
                }
            }
        }
        $search_array['member_id']  = "{$_SESSION['member_id']}";
        $list_consult   = $consult->getConsultList($search_array,$page);
        Tpl::output('show_page',$page->show());
        Tpl::output('list_consult',$list_consult);
        $_GET['type']   = empty($_GET['type'])?'consult_list':$_GET['type'];
        self::profile_menu('my_consult',$_GET['type']);
        Tpl::showpage('member_my_consult');
    }
    /**
     * 用户中心右边，小导航
     *
     * @param string    $menu_type  导航类型
     * @param string    $menu_key   当前导航的menu_key
     * @param array     $array      附加菜单
     * @return
     */
    private function profile_menu($menu_type,$menu_key='',$array=array()) {
        Language::read('member_layout');
        $menu_array     = array();
        switch ($menu_type) {
            case 'my_consult':
                $menu_array = array(
                1=>array('menu_key'=>'consult_list',    'menu_name'=>Language::get('feiwa_member_path_all_consult'),           'menu_url'=>'index.php?app=member_consult&feiwa=my_consult'),
                2=>array('menu_key'=>'to_reply',    'menu_name'=>Language::get('feiwa_member_path_unreplied_consult'),         'menu_url'=>'index.php?app=member_consult&feiwa=my_consult&type=to_reply'),
                3=>array('menu_key'=>'replied', 'menu_name'=>Language::get('feiwa_member_path_replied_consult'),           'menu_url'=>'index.php?app=member_consult&feiwa=my_consult&type=replied'));
                break;
        }
        if(!empty($array)) {
            $menu_array[] = $array;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
