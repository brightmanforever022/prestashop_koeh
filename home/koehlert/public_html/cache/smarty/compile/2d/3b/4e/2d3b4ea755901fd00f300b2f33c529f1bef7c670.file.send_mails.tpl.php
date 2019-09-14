<?php /* Smarty version Smarty-3.1.19, created on 2019-08-20 10:47:54
         compiled from "/home/koehlert/public_html/modules/khlmassmail/views/templates/admin/send_mails.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10788539625d5bb3baee2399-04521089%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d3b4ea755901fd00f300b2f33c529f1bef7c670' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlmassmail/views/templates/admin/send_mails.tpl',
      1 => 1562677135,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10788539625d5bb3baee2399-04521089',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'receivers_count' => 0,
    'mail_templates_list' => 0,
    'receivers_list' => 0,
    'receiver_data' => 0,
    'currentIndex' => 0,
    'massmail_controller_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5bb3baefa6d7_38057556',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5bb3baefa6d7_38057556')) {function content_5d5bb3baefa6d7_38057556($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/home/koehlert/public_html/tools/smarty/plugins/function.html_options.php';
?>
<div class="panel">
  <p>This form send emails to customers exported from Customers or Diff payments page. 
  Select template and click Send.
  </p>
  <div class="row">
    <div class="col-lg-6">
      <div class="form-inline">
        <div class="form-group">
          <?php echo smartyTranslate(array('s'=>'Number of receivers','mod'=>'khlmassmail'),$_smarty_tpl);?>
: <?php echo $_smarty_tpl->tpl_vars['receivers_count']->value;?>
 
          &nbsp;
          <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#massmailReceiverList"
            ><?php echo smartyTranslate(array('s'=>'View','mod'=>'khlmassmail'),$_smarty_tpl);?>
</button>
        </div>
        <div class="form-group">
          <?php echo smarty_function_html_options(array('name'=>'id_template','options'=>$_smarty_tpl->tpl_vars['mail_templates_list']->value,'id'=>'id_template'),$_smarty_tpl);?>

          &nbsp;
        </div>
        <button id="massmailStart" type="button" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'Send mails','mod'=>'khlmassmail'),$_smarty_tpl);?>
</button>
      </div>
    
    </div>
    <div class="col-lg-6">
      <div class="well" id="reportWell" hidden>
        <p>Status: <span class="mailing-status">Idle</span></p>
        <ul class="list-group" id="reportList">
          <li class="list-group-item"> <span class="badge badge-queue"><?php echo $_smarty_tpl->tpl_vars['receivers_count']->value;?>
</span> Queue </li>
          <li class="list-group-item"> <span class="badge badge-sent">0</span> Sent </li>
          <li class="list-group-item"> <span class="badge badge-errors">0</span> Errors </li>
        </ul>
      </div>

    </div>
  </div>
  <div class="row" id="massmailReceiverList" hidden>
    <div class="col-lg-12">
      <hr>
      <ul class="list-group clearfix">
    	<?php  $_smarty_tpl->tpl_vars['receiver_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['receiver_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['receivers_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['receiver_data']->key => $_smarty_tpl->tpl_vars['receiver_data']->value) {
$_smarty_tpl->tpl_vars['receiver_data']->_loop = true;
?>
        <li class="list-group-item col-lg-3">
			<?php echo $_smarty_tpl->tpl_vars['receiver_data']->value['customer_first_name'];?>
 <?php echo $_smarty_tpl->tpl_vars['receiver_data']->value['customer_last_name'];?>
<br> <?php echo $_smarty_tpl->tpl_vars['receiver_data']->value['email'];?>

        </li>
    	<?php } ?>
      </ul>
      <hr class="clearfix">
      <form method="post" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;token=<?php echo $_GET['token'];?>
">
      <button type="submit" class="btn btn-danger" name="action" value="delete_receivers"><?php echo smartyTranslate(array('s'=>'Delete all','mod'=>'khlmassmail'),$_smarty_tpl);?>
</button>
      </form>
    </div> 
  </div>
</div>

<script type="text/javascript">
var massmailControllerUrl = "<?php echo $_smarty_tpl->tpl_vars['massmail_controller_url']->value;?>
";
$(function(){
	KhlMassMailing.init();
});

</script><?php }} ?>
