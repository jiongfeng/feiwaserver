<?php
/**
 * 下载设置
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
class mb_appControl extends SystemControl{
    public function __construct(){
        parent::__construct();
    }

    public function indexFeiwa() {
        $this->mb_appFeiwa();
    }

    /**
     * 设置下载地址
     *
     */
    public function mb_appFeiwa() {
        $model_setting = Model('setting');
        $mobile_apk = $model_setting->getRowSetting('mobile_apk');
        $mobile_apk_version = $model_setting->getRowSetting('mobile_apk_version');
        $mobile_ios = $model_setting->getRowSetting('mobile_ios');
        if (chksubmit()) {
            $update_array = array();
            $update_array['mobile_apk'] = $_POST['mobile_apk'];
            $update_array['mobile_apk_version'] = $_POST['mobile_apk_version'];
            $update_array['mobile_ios'] = $_POST['mobile_ios'];
            $state = $model_setting->updateSetting($update_array);
            if ($state) {
                $this->log('设置手机端下载地址');
                showMessage(Language::get('feiwa_common_save_succ'),'index.php?app=mb_app&feiwa=mb_app');
            } else {
                showMessage(Language::get('feiwa_common_save_fail'));
            }
        }
        Tpl::output('mobile_apk',$mobile_apk);
        Tpl::output('mobile_version',$mobile_apk_version);
        Tpl::output('mobile_ios',$mobile_ios);
        Tpl::setDirquna('mobile');
Tpl::showpage('mb_app.edit');
    }

    /**
     * 生成二维码
     */
    public function mb_qrFeiwa() {
        $url = urlMall('mb_app', 'index');
        $mobile_app = 'mb_app.png';
        require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
        $PhpQRCode = new PhpQRCode();
        $PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_COMMON.DS);
        $PhpQRCode->set('date',$url);
        $PhpQRCode->set('pngTempName', $mobile_app);
        $PhpQRCode->init();

        $this->log('生成手机端二维码');
        showMessage('生成二维码成功','index.php?app=mb_app&feiwa=mb_app');
    }
}
