<?php
//大内容类型字段
$clob_fields = array(
        'article' => array('article_content'=>null),
        'attribute' => array('attr_value'=>null),
        'circle_recycle' => array('recycle_content'=>null),
        'circle_theme' => array('theme_content'=>null),
        'circle_threply' => array('reply_content'=>null),
        'reads_article' => array('article_content'=>null,'article_goods'=>null,'article_image_all'=>null),
        'reads_index_module' => array('module_content'=>null),
        'reads_picture_image' => array('image_goods'=>null),
        'reads_special' => array('special_image_all'=>null,'special_content'=>null),
        'consult_type' => array('ct_introduce'=>null),
        'document' => array('doc_content'=>null),
        'gadmin' => array('limits'=>null),
        'goods' => array('goods_spec'=>null,'goods_body'=>null,'mobile_body'=>null),
        'goods_class_tag' => array('gc_tag_value'=>null),
        'goods_common' => array('spec_value'=>null,'goods_attr'=>null,'goods_body'=>null,'mobile_body'=>null),
        'groupbuy' => array('groupbuy_intro'=>null),
		'xianshi' => array('xianshi_intro'=>null),
        'help' => array('help_info'=>null),
        'mail_cron' => array('contnet'=>null),
        'mail_msg_temlates' => array('content'=>null),
        'mall_consult_type' => array('mct_introduce'=>null),
        'member' => array('member_qqinfo'=>null,'member_sinainfo'=>null,'member_privacy'=>null),
        'member_msg_tpl' => array('mmt_mail_content'=>null),
        'micro_personal' => array('commend_image'=>null,'commend_buy'=>null),
        'offpay_area' => array('area_id'=>null),
        'order_common' => array('deliver_explain'=>null),
        'payment' => array('payment_config'=>null),
        'points_goods' => array('pgoods_body'=>null),
        'rec_position' => array('content'=>null),
        'seller_group' => array('limits'=>null),
        'seo' => array('description'=>null),
        'setting' => array('value'=>null),
        'sns_binding' => array('snsbind_openinfo'=>null),
        'sns_goods' => array('snsgoods_likemember'=>null),
        'sns_tracelog' => array('trace_content'=>null),
        'store' => array('store_zy'=>null,'store_slide'=>null,'store_slide_url'=>null,'store_presales'=>null,'store_aftersales'=>null),
        'store_decoration_block' => array('block_content'=>null),
        'store_extend' => array('express'=>null,'pricerange'=>null,'orderpricerange'=>null),
        'store_grade' => array('sg_description'=>null),
        'store_msg_tpl' => array('smt_mail_content'=>null),
        'store_navigation' => array('sn_content'=>null),
        'store_plate' => array('plate_content'=>null),
        'store_sns_tracelog' => array('strace_content'=>null),
        'store_watermark' => array('wm_text'=>null),
        'transport_extend' => array('area_name'=>null),
        'store_sns_tracelog' => array('strace_goodsdata'=>null),
		'web_code' => array('code_info'=>null),
        'web' => array('web_html'=>null),
		'order_snapshot' => array('goods_attr'=>null,'goods_body'=>null,'plate_top'=>null,'plate_bottom'=>null)
);
return $clob_fields;
?>
