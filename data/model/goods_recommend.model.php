<?php
/**
 * 商品推荐
 *
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */
defined('ByFeiWa') or exit('Access Invalid!');
class goods_recommendModel extends Model{

    public function __construct(){
        parent::__construct('goods_recommend');
    }

    /**
     * 读取列表
     * @param array $condition
     *
     */
    public function getGoodsRecommendList($condition, $page = '', $order = '', $field = '*', $gourpby = '', $key = '',$count = null) {
        return $this->field($field)->where($condition)->page($page,$count)->order($order)->group($gourpby)->key($key)->select();
    }

    /**
     * 读取单条记录
     * @param array $condition
     *
     */
    public function getGoodsRecommendInfo($condition) {
        return $this->where($condition)->find();
    }

    /*
     * 增加
     * @param array $data
     * @return bool
     */
    public function addGoodsRecommend($data){
        return $this->insertAll($data);
    }

    public function editGoodsRecommend($data,$condition) {
        return $this->where($condition)->update($data);
    }

    /*
     * 删除
     * @param array $condition
     * @return bool
     */
    public function delGoodsRecommend($condition){
        return $this->where($condition)->delete();
    }

    public function getGoodsRecommendCount($condition = array(), $field = '') {
        return $this->where($condition)->count($field);
    }

}
