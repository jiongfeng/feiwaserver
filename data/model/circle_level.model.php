<?php
/**
 * circle Level
 *
 *
 *
 * * @FeiWa (c) 2015-2018 FeiWa   (http://www.feiwa.org)
 * @license    http://www.feiwa.org
 * @link       联系电话：0539-889333 客服QQ：2116198029
 * @since      山东破浪网络科技有限公司提供技术支持 授权请购买FeiWa授权
 */
defined('ByFeiWa') or exit('Access Invalid!');

class circle_levelModel extends Model {
    public function __construct(){
        parent::__construct();
    }
    /**
     * insert
     * @param array $insert
     * @param bool $replace
     */
    public function levelInsert($insert, $replace){
        $this->table('circle_ml')->insert($insert, $replace);
        return $this->updateLevelName($insert);
    }

    /**
     * update level name
     * @param array $insert
     */
    private function updateLevelName($insert){
        $str = '( case cm_level ';
        for ($i=1; $i<=16; $i++){
            $str .= ' when '.$i.' then \''.$insert['ml_'.$i].'\'';
        }
        $str .= ' else cm_levelname end)';

        $update = array();
        $update['cm_levelname'] = array('exp',$str);

        $where = array();
        $where['circle_id'] = $insert['circle_id'];
        return $this->table('circle_member')->where($where)->update($update);
    }
}
