<?php
/**
 * 资讯评论
 *
 *
 *
 *
 * @山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 */

//use FeiWa\Tpl;

defined('ByFeiWa') or exit('Access Invalid!');
class reads_commentControl extends SystemControl{


    public function __construct(){
        parent::__construct();
        Language::read('reads');
    }

    public function indexFeiwa() {
        $this->comment_manageFeiwa();
    }


    /**
     * 评论管理
     */
    public function comment_manageFeiwa()
    {
        $this->get_type_array();
        Tpl::setDirquna('reads');
Tpl::showpage('reads_comment.manage');
    }

    /**
     * 评论管理
     */
    public function comment_manage_xmlFeiwa()
    {
        $condition = array();

        if ($_REQUEST['advanced']) {
            if (strlen($q = trim((string) $_REQUEST['comment_id']))) {
                $condition['comment_id'] = (int) $q;
            }
            if (strlen($q = trim((string) $_REQUEST['member_name']))) {
                $condition['member_name'] = $q;
            }
            if (strlen($q = trim((string) $_REQUEST['comment_type']))) {
                $condition['comment_type'] = (int) $q;
            }
            if (strlen($q = trim((string) $_REQUEST['comment_object_id']))) {
                $condition['comment_object_id'] = (int) $q;
            }
            if (strlen($q = trim((string) $_REQUEST['comment_message']))) {
                $condition['comment_message'] = array('like', '%' . $q . '%');
            }
        } else {
            if (strlen($q = trim($_REQUEST['query'])) > 0) {
                switch ($_REQUEST['qtype']) {
                    case 'comment_id':
                        $condition['comment_id'] = (int) $q;
                        break;
                    case 'member_name':
                        $condition['member_name'] = array('like', '%' . $q . '%');
                        break;
                    case 'comment_object_id':
                        $condition['comment_object_id'] = (int) $q;
                        break;
                    case 'comment_message':
                        $condition['comment_message'] = array('like', '%' . $q . '%');
                        break;
                }
            }
        }

        $model_comment = Model("reads_comment");
        $list = (array) $model_comment->getListWithUserInfo($condition, $_REQUEST['rp'], 'comment_time desc');

        $data = array();
        $data['now_page'] = $model_comment->shownowpage();
        $data['total_num'] = $model_comment->gettotalnum();

        $channel_array = $this->get_type_array();

        foreach ($list as $val) {
            $channel = $channel_array[$val['comment_type']];
            $o = '<a class="btn red confirm-del-on-click" href="index.php?app=reads_comment&feiwa=comment_drop&comment_id=' .
                $val['comment_id'] .
                '"><i class="fa fa-trash"></i>删除</a>';
            $o .= '<a class="btn green" target="_blank" href="' .
                READS_SITE_URL.DS.'index.php?app=' .
                $channel['key'] .
                '&feiwa=' .
                $channel['key'] .
                '_detail&' .
                $channel['key'] .
                '_id=' .
                $val['comment_object_id'] .
                '"><i class="fa fa-list-alt"></i>查看</a>';


            $i = array();
            $i['operation'] = $o;
            $i['comment_id'] = $val['comment_id'];

            $i['member_name'] = $val['member_name'];

            $i['comment_type'] = $channel['name'];
            $i['comment_object_id'] = $val['comment_object_id'];
            $i['comment_message'] = parsesmiles($val['comment_message']);

            $data['list'][$val['comment_id']] = $i;
        }

        echo Tpl::flexigridXML($data);
        exit;
    }

    /**
     * 获取类型数组
     */
    private function get_type_array() {
        $type_array = array();
        $type_array[1] = array('name'=>Language::get('reads_text_artcile'),'key'=>'article');
        $type_array[2] = array('name'=>Language::get('reads_text_picture'),'key'=>'picture');
        Tpl::output('type_array', $type_array);

        return $type_array;
    }


    /**
     * 评论删除
     */
    public function comment_dropFeiwa() {
        $model = Model('reads_comment');
        $condition = array();
        $condition['comment_id'] = array('in',trim($_REQUEST['comment_id']));
        $result = $model->drop($condition);
        if($result) {
            $this->log(Language::get('reads_log_comment_drop').$_REQUEST['comment_id'], 1);
            showMessage(Language::get('feiwa_common_del_succ'),'');
        } else {
            $this->log(Language::get('reads_log_comment_drop').$_REQUEST['comment_id'], 0);
            showMessage(Language::get('feiwa_common_del_fail'),'','','error');
        }
    }

}
