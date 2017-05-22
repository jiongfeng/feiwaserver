<?php
/**
 * 资讯调用接口
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */



defined('ByFeiWa') or exit('Access Invalid!');
class apiControl extends READSHomeControl{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 商品列表
     */
    public function goods_listFeiwa() {
        $model_goods = Model('goods');

        $condition = array();
        if($_GET['search_type'] == 'goods_url') {
            $condition['goods_id'] = intval($_GET['search_keyword']);
        } else {
            $condition['goods_name'] = array('like', '%' . $_GET['search_keyword'] . '%');
        }
        $goods_list = $model_goods->getGoodsOnlineList($condition, 'goods_id,goods_name,store_id,goods_image,goods_price', 10);
        Tpl::output('show_page', $model_goods->showpage(2));
        Tpl::output('goods_list', $goods_list);
        Tpl::showpage('api_goods_list', 'null_layout');
    }

    /**
     * 文章列表
     */
    public function article_listFeiwa() {
        //获取文章列表
        $condition = array();
        if($_GET['search_type'] == 'article_id') {
            $condition['article_id'] = intval($_GET['search_keyword']);
        } else {
            $condition['article_title'] = array('like','%'.trim($_GET['search_keyword']).'%');
        }
        $condition['article_state'] = self::ARTICLE_STATE_PUBLISHED;

        $model_article = Model('reads_article');
        $article_list = $model_article->getList($condition , 10, 'article_id desc');
        Tpl::output('show_page',$model_article->showpage(1));
        Tpl::output('article_list', $article_list);
        Tpl::showpage('api_article_list','null_layout');
    }

    /**
     * 图片商品添加
     */
    public function goods_info_by_urlFeiwa() {
        $url = urldecode($_GET['url']);
        if(empty($url)) {
            self::return_json(Language::get('goods_not_exist'), 'false');
        }
        $model_goods_info = Model('goods_info_by_url');
        $result = $model_goods_info->get_goods_info_by_url($url);
        if($result) {
            self::echo_json($result);
        } else {
            self::return_json(Language::get('goods_not_exist'), 'false');
        }
    }

}
