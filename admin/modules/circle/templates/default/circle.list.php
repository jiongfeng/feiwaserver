<?php defined('ByFeiWa') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['feiwa_circle_manage'];?></h3>
        <h5><?php echo $lang['feiwa_circle_manage_subhead'];?></h5>
      </div>
      <ul class="tab-base nc-row">
        <li><a href="JavaScript:void(0);" class="current"><?php echo $lang['feiwa_manage'];?></a></li>
        <li><a href="index.php?app=circle_manage&feiwa=circle_verify"><?php echo $lang['circle_wait_verify'];?></a></li>
      </ul>
    </div>
  </div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 title="<?php echo $lang['feiwa_prompts_title'];?>"><?php echo $lang['feiwa_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['feiwa_prompts_span'];?>"></span>
    </div>
    <ul>
      <li><?php echo $lang['circle_prompts_one'];?></li>
      <li><?php echo $lang['circle_prompts_two'];?></li>
    </ul>
  </div>
  <div id="flexigrid"></div>
</div>
<script type="text/javascript">
$(function(){
    $("#flexigrid").flexigrid({
        url: 'index.php?app=circle_manage&feiwa=get_xml',
        colModel : [
            {display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
            {display: '圈子ID', name : 'circle_id', width : 40, sortable : true, align: 'left'},
            {display: '圈子名称', name : 'circle_name', width : 140, sortable : true, align: 'left'},
            {display: '圈子logo', name : 'circle_img', width : 80, sortable : true, align: 'center'},
            {display: '圈主ID', name : 'circle_masterid', width : 40, sortable : true, align: 'left'},
            {display: '圈主名称', name : 'circle_mastername', width : 120, sortable : true, align: 'left'},
            {display: '圈子状态', name : 'circle_status', width : 150, sortable : true, align: 'left'},
            {display: '创建时间', name : 'circle_addtime', width : 120, sortable : true, align: 'center'},
            {display: '是否推荐', name : 'is_recommend', width : 120, sortable : true, align: 'center'},
            {display: '是否热门', name : 'is_hot', width : 150, sortable : true, align: 'center'},
            {display: '成员数', name : 'circle_mcount', width : 120, sortable : true, align: 'left'},
            {display: '话题数', name : 'circle_thcount', width : 120, sortable : true, align: 'left'}
            ],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', title : '新增数据', onpress : fg_operation }
        ],
        searchitems : [
            {display: '圈子ID', name : 'circle_id'},
            {display: '圈子名称', name : 'circle_name'},
            {display: '圈主ID', name : 'circle_masterid'},
            {display: '圈主名称', name : 'circle_mastername'}
            ],
        sortname: "circle_id",
        sortorder: "desc",
        title: '圈子列表'
    });
});

function fg_operation(name, bDiv) {
    if (name == 'add') {
        window.location.href = 'index.php?app=circle_manage&feiwa=circle_add';
    }
}
function fg_del(id) {
    if(confirm('删除后将不能恢复，确认删除这项吗？')){
        $.getJSON('index.php?app=circle_manage&feiwa=circle_del', {id:id}, function(data){
            if (data.state) {
                $("#flexigrid").flexReload();
            } else {
                showError(data.msg)
            }
        });
    }
}
</script>