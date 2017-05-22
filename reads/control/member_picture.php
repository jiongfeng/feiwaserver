<?php
/**
 * 资讯用户中心画报
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');
class member_pictureControl extends READSMemberControl{

    public function __construct() {
        parent::__construct();
    }

    public function indexFeiwa() {
        $this->picture_listFeiwa();
    }

    /**
     * 画报列表
     */
    public function picture_listFeiwa() {
        $condition = array();
        if(!empty($_GET['picture_state'])) {
            $condition['picture_state'] = intval($_GET['picture_state']);
        } else {
            $condition['picture_state'] = array('in',array(self::ARTICLE_STATE_PUBLISHED, self::ARTICLE_STATE_VERIFY)) ;
        }
        $this->get_picture_list($condition);
    }

    /**
     * 草稿列表
     */
    public function draft_listFeiwa() {
        $condition = array();
        $condition['picture_state'] = self::ARTICLE_STATE_DRAFT;
        $this->get_picture_list($condition);
    }

    /**
     * 草稿列表
     */
    public function recycle_listFeiwa() {
        $condition = array();
        $condition['picture_state'] = self::ARTICLE_STATE_RECYCLE;
        $this->get_picture_list($condition);
    }

    /**
     * 获得画报列表
     */
    private function get_picture_list($condition = array()) {
        if(!empty($_GET['keyword'])) {
            $condition['picture_title'] = array('like', '%'.$_GET['keyword'].'%');
        }
        $condition['picture_type'] = $this->publisher_type;
        $condition['picture_publisher_id'] = $this->publisher_id;
        $model_picture = Model('reads_picture');
        $picture_list = $model_picture->getList($condition, 20, 'picture_id desc');
        Tpl::output('show_page',$model_picture->showpage(2));
        Tpl::output('picture_list', $picture_list);

        //获取画报图片
        $picture_ids = '';
        if(!empty($picture_list)) {
            foreach ($picture_list as $value) {
                $picture_ids .= $value['picture_id'].',';
            }
            $picture_ids = rtrim($picture_ids, ',');
        }
        $model_picture_image = Model('reads_picture_image');
        $picture_image_array = $model_picture_image->getList(array('image_picture_id'=>array('in', $picture_ids)));
        $picture_image_list = array();
        if(!empty($picture_image_array)) {
            foreach($picture_image_array as $value) {
                $image = array('name'=>$value['image_name'], 'path'=>$value['image_path']);
                $picture_image_list[$value['image_picture_id']][] = serialize($image);
            }
        }
        Tpl::output('picture_image_list', $picture_image_list);

        Tpl::output('picture_state_list', $this->get_article_state_list());
        Tpl::output('index_sign', 'picture');
        Tpl::showpage('member_picture_list', 'reads_member_layout');
    }

    /**
     * 画报编辑
     */
    public function picture_editFeiwa() {
        $picture_id = intval($_GET['picture_id']);
        $picture_detail = $this->check_picture_auth($picture_id);
        if($picture_detail) {
            $model_picture_class = Model('reads_picture_class');
            $picture_class_list = $model_picture_class->getList(TRUE, NULL, 'class_sort asc');
            Tpl::output('picture_class_list', $picture_class_list);

            $model_tag = Model('reads_tag');
            $tag_list = $model_tag->getList(TRUE, NULL, 'tag_sort asc');
            Tpl::output('tag_list', $tag_list);

            $model_picture_image = Model('reads_picture_image');
            $picture_image_list = $model_picture_image->getList(array('image_picture_id'=>$picture_id), NULL);
            Tpl::output('picture_image_list', $picture_image_list);

            Tpl::output('picture_detail', $picture_detail);

            Tpl::showpage('publish_picture','reads_member_layout');
        } else {
            showMessage(Language::get('wrong_argument'),'','','error');
        }
    }

    /**
     * 发布
     */
    public function picture_publishFeiwa() {
        $this->picture_state_change($this->publish_state);
    }

    /**
     * 移到回收站
     */
    public function picture_recycleFeiwa() {
        $this->picture_state_change(self::ARTICLE_STATE_RECYCLE);
    }

    /**
     * 移到草稿箱
     */
    public function picture_draftFeiwa() {
        $this->picture_state_change(self::ARTICLE_STATE_DRAFT);
    }

    /**
     * 删除
     */
    public function picture_dropFeiwa() {
        $picture_id = intval($_GET['picture_id']);
        $picture_auth = $this->check_picture_auth($picture_id);
        if($picture_auth) {
            $model_picture = Model('reads_picture');
            $result = $model_picture->drop(array('picture_id'=>$picture_id));
            if($result) {
                showMessage(Language::get('feiwa_common_del_succ'),'');
            } else {
                showMessage(Language::get('feiwa_common_del_fail'),'','','error');
            }
        } else {
            showMessage(Language::get('wrong_argument'),'','','error');
        }
    }

    /**
     * 改变画报状态
     */
    private function picture_state_change($picture_state_new) {
        $picture_id = intval($_GET['picture_id']);
    $picture_auth = $this->check_picture_auth($picture_id);
    if($picture_auth) {
        $model_picture = Model('reads_picture');
        $result = $model_picture->modify(array('picture_state'=>$picture_state_new),array('picture_id'=>$picture_id));
        showMessage(Language::get('feiwa_common_op_succ'),'');
    } else {
        showMessage(Language::get('feiwa_common_op_fail'),'','','error');
    }
}
}
