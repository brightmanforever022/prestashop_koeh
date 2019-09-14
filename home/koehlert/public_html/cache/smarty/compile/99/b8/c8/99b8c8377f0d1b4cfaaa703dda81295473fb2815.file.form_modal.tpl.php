<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:43:56
         compiled from "/home/koehlert/public_html/modules/shopcomments/views/templates/admin/form_modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3481465385d59642c030e82-20201838%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99b8c8377f0d1b4cfaaa703dda81295473fb2815' => 
    array (
      0 => '/home/koehlert/public_html/modules/shopcomments/views/templates/admin/form_modal.tpl',
      1 => 1558370654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3481465385d59642c030e82-20201838',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shop_comments_controller_url' => 0,
    'shop_comment_reference' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59642c03baf3_82823070',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59642c03baf3_82823070')) {function content_5d59642c03baf3_82823070($_smarty_tpl) {?><div class="bootstrap">
<div class="modal fade" tabindex="-1" role="dialog" id="shopCommentFormDialog"  aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title"  id="myModalLabel"><?php echo smartyTranslate(array('s'=>'Add note','mod'=>'shopcomments'),$_smarty_tpl);?>
</h4>
      		</div>
      		<div class="modal-body">
        	<form action="<?php echo $_smarty_tpl->tpl_vars['shop_comments_controller_url']->value;?>
&action=save" method="post">
        		<div class="form-group">
		            <textarea rows="4" class="form-control" name="message"></textarea>
        		</div>
        		<div class="form-group">
        			<input type="hidden" name="reference_type" value="<?php echo $_smarty_tpl->tpl_vars['shop_comment_reference']->value;?>
">
        			<input type="hidden" name="reference_id">
        			<button type="submit" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'Save note','mod'=>'shopcomments'),$_smarty_tpl);?>
</button>
        		</div>
        	</form>
      		</div>
    	</div>
  	</div>
</div>

<div id="shopCommentsGrid" class="panel panel-default" style="position:absolute;z-index:100;display:none;width:600px;"><div class="panel-body"></div></div>
</div>

<div hidden style="position:absolute;z-index:20;width:100px;" id="shopCommentsRecordActionsPanel">
  <button type="button" class="btn btn-warning btn-xs comment-archive"><?php echo smartyTranslate(array('s'=>'Archive','mod'=>'shopcomments'),$_smarty_tpl);?>
</button>
  <button type="button" class="btn btn-success btn-xs comment-activate"><?php echo smartyTranslate(array('s'=>'Activate','mod'=>'shopcomments'),$_smarty_tpl);?>
</button>
</div>


<script type="text/javascript">
<!--
var shopCommentsReferenceType = <?php echo $_smarty_tpl->tpl_vars['shop_comment_reference']->value;?>
;
var shopCommentsControllerUrl = "<?php echo $_smarty_tpl->tpl_vars['shop_comments_controller_url']->value;?>
";
//-->
</script><?php }} ?>
