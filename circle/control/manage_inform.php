<?php
/**
 * 圈子首页
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');

class manage_informControl extends BaseCircleManageControl{
    public function __construct(){
        parent::__construct();
        Language::read('manage_inform');
        $this->circleSEO();
    }
    /**
     * Inform
     */
    public function informFeiwa(){
        // Circle information
        $this->circleInfo();
        // Membership information
        $this->circleMemberInfo();
        // Members to join the 淘友圈 list
        $this->memberJoinCircle();
        $model = Model();
        if (chksubmit()){
            if(empty($_POST['i_id']))
                showDialog(L('wrong_argument'));


            foreach ($_POST['i_id'] as $val){
                $i_rewards = intval($_POST['i_rewards'][$val]);
                $update = array();
                $update['inform_id']    = $val;
                $update['inform_state'] = 1;
                $update['inform_opid']  = $_SESSION['member_id'];
                $update['inform_opname']= $_SESSION['member_name'];
                $update['inform_opexp'] = $i_rewards;
                $update['inform_opresult']  = $_POST['i_result'][$val] == ''? L('feiwa_nothing') : $_POST['i_result'][$val];

                $rs = $model->table('circle_inform')->where(array('inform_id'=>$val))->update($update);

                // Experience increase or decrease
                if($rs && $i_rewards != 0){
                    $inform_info = $model->table('circle_inform')->field('circle_id,member_id,member_name')->where(array('inform_id'=>$val))->find();
                    if(!empty($inform_info)){
                        $param = array();
                        $param['circle_id']     = $inform_info['circle_id'];
                        $param['member_id']     = $inform_info['member_id'];
                        $param['member_name']   = $inform_info['member_name'];
                        $param['type']          = 'master';
                        $param['exp']           = $i_rewards;
                        $param['desc']          = L('circle_exp_inform');
                        $param['itemid']        = 0;
                        Model('circle_exp')->saveExp($param);
                    }
                }
            }

            // Update the inform number
            $count = $model->table('circle_inform')->where(array('circle_id'=>$this->c_id, 'inform_state'=>0))->count();
            $model->table('circle')->where(array('circle_id'=>$this->c_id))->update(array('new_informcount'=>$count));

            showDialog(L('feiwa_common_op_succ'),'reload','succ');

        }

        $where = array();
        $where['circle_id'] = $this->c_id;
        $where['inform_state'] = $_GET['type'] == 'treated' ? 1 : 0;

        $inform_list = $model->table('circle_inform')->where($where)->page(10)->order('inform_id desc')->select();
        // tidy
        if(!empty($inform_list)){
            foreach ($inform_list as $key=>$val){
                $inform_list[$key]['url']   = spellInformUrl($val);
                $inform_list[$key]['title'] = L('circle_theme,feiwa_quote1').$val['theme_name'].L('feiwa_quote2');
                if($val['reply_id'] != 0)
                    $inform_list[$key]['title'] .= L('circle_inform_reply_title');
            }
        }
        Tpl::output('inform_list', $inform_list);
        Tpl::output('show_page', $model->showpage(2));

        $type = $_GET['type'] == 'treated' ? 'treated' : 'untreated';
        $this->sidebar_menu('inform', $type);
        $_GET['type'] == 'treated' ? Tpl::showpage('group_manage_inform.treated') : Tpl::showpage('group_manage_inform.untreated');
    }

    /**
     * Delete Inform
     */
    public function delinformFeiwa(){
        // Authentication
        $rs = $this->checkIdentity('c');
        if(!empty($rs)){
            showDialog($rs);
        }
        $inform_id = explode(',', $_GET['i_id']);
        if(empty($inform_id)){
            echo 'false';exit;
        }
        $where = array();
        $where['circle_id'] = $this->c_id;
        $where['inform_id'] = array('in', $inform_id);
        Model()->table('circle_inform')->where($where)->delete();
        showDialog(L('feiwa_common_del_succ'), 'reload', 'succ');
    }
}
