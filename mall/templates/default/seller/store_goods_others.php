<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<style type="text/css">
<!--
.STYLE5 {color: #33CC99}
.STYLE6 {color: #FF3300}
.STYLE7 {color: #990033}
-->
</style>

<div class="tabmenu">
  <?php include template('layout/submenu'); ?>

</div>
<div class="page">
  <div class="tab-div" style="width: 1030px;">
    <div id="tabbody-div" style="background: #FFFDEA;" >
      <form action="index.php?app=taobao_caiji&feiwa=otherscolect" method="post" enctype="multipart/form-data" name="theForm" id="theForm" >
        <!-- 最大文件限� -->
        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
        <!-- 通用信息 -->
        <table width="90%" id="general-table" >
		<tr><td></td><td height="20"><input type="text" value="<?php echo $output['good_cat_id']; ?>" class="textinput" name="cat_id" size="80" height="55" style="display:none;" /> </td></tr>
          <tr>
            <th width="150"><div align="center">采集商品链接：</div></th>
            <td><textarea style="display:none" name="keyword2" cols="80" rows="2" wrap="virtual"></textarea>
                <input type="text" value="" class="textinput" name="keyword" size="80" height="55" /> 
               </td>
          </tr>
		  <tr><td height="2"></td></tr>
		   <tr><td></td><td> <span><span class="STYLE5"> ( 填写你要采集的<span class="STYLE6">淘宝</span>或<span class="STYLE7">天猫</span>的商品链接.)</span></span>  </td></tr>
		   <tr><td height="20"></td></tr>
         <tr>
           <td><div align="center">放到店铺分类：</div></td>
           <td height="20"> <?php if (!empty($output['store_class_goods'])) { ?>
          <?php foreach ($output['store_class_goods'] as $v) { ?>
          <select name="sgcate_id[]" class="sgcategory">
            <option value="0"><?php echo $lang['feiwa_please_choose'];?></option>
            <?php foreach ($output['store_goods_class'] as $val) { ?>
            <option value="<?php echo $val['stc_id']; ?>" <?php if ($v==$val['stc_id']) { ?>selected="selected"<?php } ?>><?php echo $val['stc_name']; ?></option>
            <?php if (is_array($val['child']) && count($val['child'])>0){?>
            <?php foreach ($val['child'] as $child_val){?>
            <option value="<?php echo $child_val['stc_id']; ?>" <?php if ($v==$child_val['stc_id']) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
            <?php }?>
            <?php }?>
            <?php } ?>
          </select>
          <?php } ?>
          <?php } else { ?>
          <select name="sgcate_id[]" class="sgcategory">
            <option value="0"><?php echo $lang['feiwa_please_choose'];?></option>
            <?php if (!empty($output['store_goods_class'])){?>
            <?php foreach ($output['store_goods_class'] as $val) { ?>
            <option value="<?php echo $val['stc_id']; ?>"><?php echo $val['stc_name']; ?></option>
            <?php if (is_array($val['child']) && count($val['child'])>0){?>
            <?php foreach ($val['child'] as $child_val){?>
            <option value="<?php echo $child_val['stc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
            <?php }?>
            <?php }?>
            <?php } ?>
            <?php } ?>
          </select>
          <?php } ?></td></tr>
          <tr><td height="20"></td></tr>
          <tr class="app">
            <th>&nbsp;</th>
            <td>&nbsp;&nbsp;
                <input name="submit" type="submit" class="submit_btn" value="开始采集" />
              &nbsp;&nbsp; </td>
          </tr>
		  <tr><td height="20"></td></tr>
        </table>
      </form>
    </div>
  </div>
</div>

