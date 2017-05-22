<?php defined('ByFeiWa') or exit('Access Invalid!');?>
<div class="reads-page-module-frame module-style-<?php echo "<?php echo \$value['module_style']?>";?>">
<div class="reads-module-frame">
    <?php if($output['module_display_title']) { ?>
    <div class="reads-module-frame-title">
        <?php require('reads_module.assembly_title.php');?>
    </div>
    <?php } ?>
    <?php if(!empty($output['frame_structure']) && is_array($output['frame_structure'])) {?>
    <?php foreach ($output['frame_structure'] as $key=>$value) {?>
    <?php if(empty($value['child'])) { ?>
    <div nctype="reads_module_content" class="reads-module-frame-<?php echo $value['name'];?>">
        <?php if(!empty($output['frame_block'][$key])) { ?>
        <?php $block_name = $key;?>
        <?php require('reads_module.assembly_'.$output['frame_block'][$key].'.php');?>
        <?php } ?>
    </div>
    <?php } else { ?>
    <div nctype="reads_module_content" class="reads-module-frame-<?php echo $value['name'];?>">
        <?php foreach($value['child'] as $key_child=>$value_child) { ?>
        <div class="reads-module-frame-<?php echo $value_child['name'];?>">
            <?php if(!empty($output['frame_block'][$key_child])) { ?>
            <?php $block_name = $key_child;?>
            <?php require('reads_module.assembly_'.$output['frame_block'][$key_child].'.php');?>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="clear"></div>
    <?php } ?>
</div>
</div>

