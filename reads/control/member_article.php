<?php
/**
 * 资讯用户中心文章
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');
class member_articleControl extends READSMemberControl{

    public function __construct() {
        parent::__construct();
    }

    public function indexFeiwa() {
        $this->article_listFeiwa();
    }

    /**
     * 文章列表
     */
    public function article_listFeiwa() {
        $condition = array();
        if(!empty($_GET['article_state'])) {
            $condition['article_state'] = $_GET['article_state'];
        } else {
            $condition['article_state'] = array('in',array(self::ARTICLE_STATE_PUBLISHED, self::ARTICLE_STATE_VERIFY)) ;
        }
        $this->get_article_list($condition);
    }

    /**
     * 草稿列表
     */
    public function draft_listFeiwa() {
        $condition = array();
        $condition['article_state'] = self::ARTICLE_STATE_DRAFT;
        $this->get_article_list($condition);
    }

    /**
     * 草稿列表
     */
    public function recycle_listFeiwa() {
        $condition = array();
        $condition['article_state'] = self::ARTICLE_STATE_RECYCLE;
        $this->get_article_list($condition);
    }

    /**
     * 获得文章列表
     */
    private function get_article_list($condition = array()) {
        if(!empty($_GET['keyword'])) {
            $condition['article_title'] = array('like', '%'.$_GET['keyword'].'%');
        }
        $condition['article_type'] = $this->publisher_type;
        $condition['article_publisher_id'] = $this->publisher_id;
        $model_article = Model('reads_article');
        $article_list = $model_article->getList($condition, 20, 'article_id desc');
        Tpl::output('show_page',$model_article->showpage(2));
        Tpl::output('article_list', $article_list);

        Tpl::output('article_state_list', $this->get_article_state_list());
        Tpl::output('index_sign', 'article');
        Tpl::showpage('member_article_list', 'reads_member_layout');
    }

    /**
     * 文章编辑
     */
    public function article_editFeiwa() {
        $article_id = intval($_GET['article_id']);
        $article_detail = $this->check_article_auth($article_id);
        if($article_detail) {
            $model_article_class = Model('reads_article_class');
            $article_class_list = $model_article_class->getList(TRUE, null, 'class_sort asc');
            Tpl::output('article_class_list', $article_class_list);

            $model_tag = Model('reads_tag');
            $tag_list = $model_tag->getList(TRUE, null, 'tag_sort asc');
            Tpl::output('tag_list', $tag_list);

            //相关文章
            $article_link_list = $this->get_article_link_list($article_detail['article_link']);
            Tpl::output('article_link_list', $article_link_list);

            //相关商品
            $article_goods_list = unserialize($article_detail['article_goods']);
            Tpl::output('article_goods_list', $article_goods_list);

            Tpl::output('article_detail', $article_detail);

            Tpl::showpage('publish_article','reads_member_layout');
        } else {
            showMessage(Language::get('wrong_argument'),'','','error');
        }
    }

    /**
     * 移到回收站
     */
    public function article_publishFeiwa() {
        $this->article_state_change($this->publish_state);
    }

    /**
     * 移到回收站
     */
    public function article_recycleFeiwa() {
        $this->article_state_change(self::ARTICLE_STATE_RECYCLE);
    }

    /**
     * 移到草稿箱
     */
    public function article_draftFeiwa() {
        $this->article_state_change(self::ARTICLE_STATE_DRAFT);
    }

    /**
     * 删除
     */
    public function article_dropFeiwa() {
        $article_id = intval($_GET['article_id']);
        $article_auth = $this->check_article_auth($article_id);
        if($article_auth) {
            $model_article = Model('reads_article');
            $result = $model_article->drop(array('article_id'=>$article_id));
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
     * 改变文章状态
 */
    private function article_state_change($article_state_new) {
        $article_id = intval($_GET['article_id']);
        $article_auth = $this->check_article_auth($article_id);
        if($article_auth) {
            $model_article = Model('reads_article');
            $result = $model_article->modify(array('article_state'=>$article_state_new),array('article_id'=>$article_id));
            showMessage(Language::get('feiwa_common_op_succ'),'');
        } else {
            showMessage(Language::get('feiwa_common_op_fail'),'','','error');
        }
    }
}
