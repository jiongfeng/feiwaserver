<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="clear">&nbsp;</div>
<div id="tbox">
<a id="gotop" href="JavaScript:void(0);" title="<?php echo $lang['go_top'];?>" style="display:none;"></a>
</div>
<div class="feiwa-footer"> 
 <div class="ensureBox"> 
  <ul class="clearfix"> 
   <li><a rel="nofollow" href="javascript:;" target="_self"><i class="i_ensure01"></i><span>产品更齐全</span>轻松购物 畅选无忧</a></li> 
   <li><a rel="nofollow" href="javascript:;" target="_self"><i class="i_ensure02"></i><span>服务更精致</span>正品行货 优质体验</a></li> 
   <li><a rel="nofollow" href="javascript:;" target="_self"><i class="i_ensure03"></i><span>售后有保障</span>七天无理由退换货</a></li> 
   <li><a rel="nofollow" href="javascript:;" target="_self"><i class="i_ensure04"></i><span>购物更安全</span>品质护航 安全放心</a></li> 
  </ul> 
 </div> 

 
  <?php if(is_array($output['article_lists']) && !empty($output['article_lists'])){ ?>
 <div class="foot_navi"> 
  <div class="footRight clearfix"> 
 <?php foreach ($output['article_lists'] as $k=> $article_class){ ?>
<?php if(!empty($article_class)){ ?><dl> 
    <dt> <?php if(is_array($article_class['class'])) echo $article_class['class']['ac_name'];?> </dt> 
   <?php if(is_array($article_class['list']) && !empty($article_class['list'])){ ?>
	<?php foreach ($article_class['list'] as $article){ ?> 
	<dd> <a rel="nofollow" target="_blank" href="<?php if($article['article_url'] != '')echo $article['article_url'];else echo urlMember('article', 'show',array('article_id'=> $article['article_id']));?>"><?php echo $article['article_title'];?></a> </dd> 
   <?php }}?>
   </dl> <?php }}?>


  </div> 
  <div class="gzabout">
          <dl>
          <dt>关注我们</dt>
           <dd>客服电话：0851-84603146</dd>
          </dl>
         
      </div>
  <div class="ft_weixin"> 
   <div class="erweima"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.C('mobile_app');?>"></div> 
   <p>贵电商淘宝养生馆</p> 
  </div> 
  <div class="ft_app"> 
   <div class="erweima"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MOBILE.DS.C('mobile_wx');?>"></div> 
   <p>www.guidianshang.com.cn</p> 
  </div> 
  <div class="ft_app"> 
   <div class="erweima"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MOBILE.DS.C('mobile_wx');?>"></div> 
   <p>贵电商服务公众号</p> 
  </div>
 </div> <?php }?>
 <div class="gray_box"> 
  <ul class="bt_securityAlliance clearfix"> 
   <li><a rel="nofollow" href="http://www.miitbeian.gov.cn/" target="_blank"><img src="<?php echo MALL_SITE_URL;?>/img/bt_logo08.png" alt="工业和信息化部"></a></li> 
   <li><a rel="nofollow" href="http://www.gdgs.gov.cn/" target="_blank"><img src="<?php echo MALL_SITE_URL;?>/img/bt_logo01.png" alt="工商网监"></a></li> 
   <li><a rel="nofollow" href="http://www.gzjd.gov.cn/gsmpro/web/serviceitem/web_alert_view.html" target="_blank"><img src="<?php echo MALL_SITE_URL;?>/img/bt_logo00.png" alt="网络警察"></a></li> 
   <li><img src="<?php echo MALL_SITE_URL;?>/img/bt_logo03.png" alt="支付宝"></li>
   <li><img src="<?php echo MALL_SITE_URL;?>/img/bt_logo04.png" alt="快钱"></li> 
   <li><img src="<?php echo MALL_SITE_URL;?>/img/bt_logo05.png" alt="微信支付"></li> 
   <li><img src="<?php echo MALL_SITE_URL;?>/img/bt_logo06.png" alt="银联支付"></li> 
  </ul> 
  <div class="wrap"> 
  	<a href="<?php echo MALL_SITE_URL;?>">首页</a>
  	<?php if(!empty($output['nav_list']) && is_array($output['nav_list'])){?><?php foreach($output['nav_list'] as $nav){?>
				<?php if($nav['nav_location'] == '2'){?>|
		<a  <?php if($nav['nav_new_open']){?>target="_blank" <?php }?>href="<?php switch($nav['nav_type']){
			case '0':echo $nav['nav_url'];break; 
			case '1':echo urlMall('search', 'index', array('cate_id'=>$nav['item_id']));break; 
			case '2':echo urlMember('article', 'article',array('ac_id'=>$nav['item_id']));break; 
			case '3':echo urlMall('activity', 'index',array('activity_id'=>$nav['item_id']));break;}?>">
			<?php echo $nav['nav_title'];?></a><?php }}}?>|
			<a href="<?php echo urlmall('link');?>">友情链接</a>|FeiWa</p>

   <div class="copy_right">
     ©2017 贵电商.com 
    <a href="http://www.贵电商.com/">贵电商</a> <?php echo $output['setting_config']['icp_number']; ?>  客户服务中心(7×24):0851-84603146
    <br />
<!-- <?php echo $output['setting_config']['feiwa_version'];?>-<?php echo feiwa_by_version;?> -->
   </div> 
  </div> 
 </div> 
</div><p><?php echo html_entity_decode($output['setting_config']['statistics_code'],ENT_QUOTES); ?></p></div></div>
<?php if (C('debug') == 1){?>
<div id="think_page_trace" class="trace">
  <fieldset id="querybox">
    <legend><?php echo $lang['feiwa_debug_trace_title'];?></legend>
    <div>
      <?php print_r(Tpl::showTrace());?>
    </div>
  </fieldset>
</div>
<?php }?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.cookie.js"></script>
</body>
</html>
