<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['feiwa_operation_set']?></h3>
        <h5><?php echo $lang['feiwa_operation_set_subhead']?></h5>
      </div>
    </div>
  </div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit"><?php echo $lang['groupbuy_allow'];?></dt>
        <dd class="opt">
          <div class="onoff">
            <label for="groupbuy_allow_1" class="cb-enable <?php if($output['list_setting']['groupbuy_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><?php echo $lang['open'];?></label>
            <label for="groupbuy_allow_0" class="cb-disable <?php if($output['list_setting']['groupbuy_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><?php echo $lang['close'];?></label>
            <input id="groupbuy_allow_1" name="groupbuy_allow" <?php if($output['list_setting']['groupbuy_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="groupbuy_allow_0" name="groupbuy_allow" <?php if($output['list_setting']['groupbuy_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic"><?php echo $lang['groupbuy_isuse_notice'];?></p>
        </dd>
      </dl>
      <!-- 促销开启 -->
      <dl class="row">
        <dt class="tit">
          <label><?php echo $lang['promotion_allow'];?></label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="promotion_allow_1" class="cb-enable <?php if($output['list_setting']['promotion_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><?php echo $lang['open'];?></label>
            <label for="promotion_allow_0" class="cb-disable <?php if($output['list_setting']['promotion_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><?php echo $lang['close'];?></label>
            <input type="radio" id="promotion_allow_1" name="promotion_allow" value="1" <?php echo $output['list_setting']['promotion_allow'] ==1?'checked=checked':''; ?>>
            <input type="radio" id="promotion_allow_0" name="promotion_allow" value="0" <?php echo $output['list_setting']['promotion_allow'] ==0?'checked=checked':''; ?>>
          </div>
          <p class="notic"><?php echo $lang['promotion_notice'];?></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit"><?php echo $lang['open_pointmall_isuse'];?></dt>
        <dd class="opt">
          <div class="onoff">
            <label for="pointmall_isuse_1" class="cb-enable <?php if($output['list_setting']['pointmall_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['feiwa_open'];?>"><span><?php echo $lang['feiwa_open'];?></span></label>
            <label for="pointmall_isuse_0" class="cb-disable <?php if($output['list_setting']['pointmall_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['feiwa_close'];?>"><span><?php echo $lang['feiwa_close'];?></span></label>
            <input id="pointmall_isuse_1" name="pointmall_isuse" <?php if($output['list_setting']['pointmall_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="pointmall_isuse_0" name="pointmall_isuse" <?php if($output['list_setting']['pointmall_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic"><?php echo sprintf($lang['open_pointmall_isuse_notice'],"index.php?app=setting&feiwa=pointmall_setting");?></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit"><?php echo $lang['open_pointprod_isuse'];?></dt>
        <dd class="opt">
          <div class="onoff">
            <label for="pointprod_isuse_1" class="cb-enable <?php if($output['list_setting']['pointprod_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><?php echo $lang['open'];?></label>
            <label for="pointprod_isuse_0" class="cb-disable <?php if($output['list_setting']['pointprod_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><?php echo $lang['close'];?></label>
            <input id="pointprod_isuse_1" name="pointprod_isuse" <?php if($output['list_setting']['pointprod_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="pointprod_isuse_0" name="pointprod_isuse" <?php if($output['list_setting']['pointprod_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic"><?php echo $lang['open_pointprod_isuse_notice'];?></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit"><?php echo $lang['voucher_allow'];?></dt>
        <dd class="opt">
          <div class="onoff">
            <label for="voucher_allow_1" class="cb-enable <?php if($output['list_setting']['voucher_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><?php echo $lang['open'];?></label>
            <label for="voucher_allow_0" class="cb-disable <?php if($output['list_setting']['voucher_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><?php echo $lang['close'];?></label>
            <input id="voucher_allow_1" name="voucher_allow" <?php if($output['list_setting']['voucher_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="voucher_allow_0" name="voucher_allow" <?php if($output['list_setting']['voucher_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic"><?php echo $lang['voucher_allow_notice'];?></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">平台红包</dt>
        <dd class="opt">
          <div class="onoff">
            <label for="redpacket_allow_1" class="cb-enable <?php if($output['list_setting']['redpacket_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><?php echo $lang['open'];?></label>
            <label for="redpacket_allow_0" class="cb-disable <?php if($output['list_setting']['redpacket_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><?php echo $lang['close'];?></label>
            <input id="redpacket_allow_1" name="redpacket_allow" <?php if($output['list_setting']['redpacket_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="redpacket_allow_0" name="redpacket_allow" <?php if($output['list_setting']['redpacket_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic">平台红包开启后，可以在后台“平台红包”功能中发布红包，会员通过相应的方式领取红包，在下单时选择使用拥有的红包，从而得到优惠</p>
        </dd>
      </dl>
         <dl class="row">
        <dt class="tit">整点秒杀</dt>
        <dd class="opt">
          <div class="onoff">
            <label for="spike_allow_1" class="cb-enable <?php if($output['list_setting']['spike_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><?php echo $lang['open'];?></label>
            <label for="spike_allow_0" class="cb-disable <?php if($output['list_setting']['spike_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><?php echo $lang['close'];?></label>
            <input id="spike_allow_1" name="spike_allow" <?php if($output['list_setting']['spike_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="spike_allow_0" name="spike_allow" <?php if($output['list_setting']['spike_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
          </div>
          <p class="notic">整点秒杀开启后，可以在后台“整点秒杀”功能中发布秒杀</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['feiwa_submit'];?></a></div>
    </div>
  </form>
</div>
<script>
$(function(){$("#submitBtn").click(function(){
    if($("#settingForm").valid()){
     $("#settingForm").submit();
	}
	});
});
</script>
