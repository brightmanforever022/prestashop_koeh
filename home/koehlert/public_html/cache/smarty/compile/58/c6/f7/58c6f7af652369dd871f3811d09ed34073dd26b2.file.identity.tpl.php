<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:11:08
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/identity.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14310838525d5a3d7ce11d21-44953285%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58c6f7af652369dd871f3811d09ed34073dd26b2' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/identity.tpl',
      1 => 1528367175,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14310838525d5a3d7ce11d21-44953285',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'navigationPipe' => 0,
    'confirmation' => 0,
    'pwd_changed' => 0,
    'email' => 0,
    'genders' => 0,
    'gender' => 0,
    'days' => 0,
    'v' => 0,
    'sl_day' => 0,
    'months' => 0,
    'k' => 0,
    'sl_month' => 0,
    'years' => 0,
    'sl_year' => 0,
    'newsletter' => 0,
    'optin' => 0,
    'b2b_enable' => 0,
    'HOOK_CUSTOMER_IDENTITY_FORM' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a3d7ce8d371_89181481',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a3d7ce8d371_89181481')) {function content_5d5a3d7ce8d371_89181481($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?>
    <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
">
        <?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>

    </a>
    <span class="navigation-pipe">
        <?php echo $_smarty_tpl->tpl_vars['navigationPipe']->value;?>

    </span>
    <span class="navigation_page">
        <?php echo smartyTranslate(array('s'=>'Your personal information'),$_smarty_tpl);?>

    </span>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<div class="box">
    <h1 class="page-subheading size24">
        <?php echo smartyTranslate(array('s'=>'Your personal information'),$_smarty_tpl);?>

    </h1>

    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


    <?php if (isset($_smarty_tpl->tpl_vars['confirmation']->value)&&$_smarty_tpl->tpl_vars['confirmation']->value) {?>
        <p class="alert alert-success">
            <?php echo smartyTranslate(array('s'=>'Your personal information has been successfully updated.'),$_smarty_tpl);?>

            <?php if (isset($_smarty_tpl->tpl_vars['pwd_changed']->value)) {?><br /><?php echo smartyTranslate(array('s'=>'Your password has been sent to your email:'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['email']->value;?>
<?php }?>
        </p>
    <?php } else { ?>
        <p class="info-title">
            <?php echo smartyTranslate(array('s'=>'Please be sure to update your personal information if it has changed.'),$_smarty_tpl);?>

        </p>
        <p class="required">
            <sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field'),$_smarty_tpl);?>

        </p>
        <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('identity',true), ENT_QUOTES, 'UTF-8', true);?>
" method="post" class="std form-horizontal col-sm-8">
            <fieldset>
                <div class="clearfix form-group">
                    <label class="control-label col-sm-4"><?php echo smartyTranslate(array('s'=>'Social title'),$_smarty_tpl);?>
</label>
                    <div class="col-sm-8">
                    <?php  $_smarty_tpl->tpl_vars['gender'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['gender']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['genders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['gender']->key => $_smarty_tpl->tpl_vars['gender']->value) {
$_smarty_tpl->tpl_vars['gender']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['gender']->key;
?>
                        <div class="radio-inline">
                            <label for="id_gender<?php echo $_smarty_tpl->tpl_vars['gender']->value->id;?>
" class="top">
                            <input type="radio" name="id_gender" id="id_gender<?php echo $_smarty_tpl->tpl_vars['gender']->value->id;?>
" value="<?php echo intval($_smarty_tpl->tpl_vars['gender']->value->id);?>
" <?php if (isset($_POST['id_gender'])&&$_POST['id_gender']==$_smarty_tpl->tpl_vars['gender']->value->id) {?>checked="checked"<?php }?> />
                            <?php echo $_smarty_tpl->tpl_vars['gender']->value->name;?>
</label>
                        </div>
                    <?php } ?>
                </div>
                </div>
                <div class="required form-group">
                    <label for="firstname" class="required control-label col-sm-4">
                        <?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>

                    </label>
                    <div class="col-sm-8">
                    <input class="is_required validate form-control" data-validate="isName" type="text" id="firstname" name="firstname" value="<?php echo $_POST['firstname'];?>
" />
					</div>
                </div>
                <div class="required form-group">
                    <label for="lastname" class="required control-label col-sm-4">
                        <?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>

                    </label>
                    <div class="col-sm-8">
                    <input class="is_required validate form-control" data-validate="isName" type="text" name="lastname" id="lastname" value="<?php echo $_POST['lastname'];?>
" />
					</div>
                </div>
                <div class="required form-group">
                    <label for="email" class="required control-label col-sm-4">
                        <?php echo smartyTranslate(array('s'=>'E-mail address'),$_smarty_tpl);?>

                    </label>
                    <div class="col-sm-8">
                    <input class="is_required validate form-control" autocomplete="off" data-validate="isEmail" type="email" name="email" id="email" value="<?php echo $_POST['email'];?>
" />
					</div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">
                        <?php echo smartyTranslate(array('s'=>'Date of Birth'),$_smarty_tpl);?>

                    </label>
					<div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-3 col-xs-3">
                            <select name="days" id="days" class="form-control">
                                <option value="">-</option>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['days']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['sl_day']->value==$_smarty_tpl->tpl_vars['v']->value)) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
&nbsp;&nbsp;</option>
                                <?php } ?>
                            </select>
                        </div>
							<div class="col-sm-6 col-xs-6">
							
                            <select id="months" name="months" class="form-control">
                                <option value="">-</option>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['months']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['sl_month']->value==$_smarty_tpl->tpl_vars['k']->value)) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
&nbsp;</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-xs-3">
                            <select id="years" name="years" class="form-control">
                                <option value="">-</option>
                                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['years']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['sl_year']->value==$_smarty_tpl->tpl_vars['v']->value)) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
&nbsp;&nbsp;</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                <div class="required form-group">
                    <label for="old_passwd" class="required control-label col-sm-4">
                        <?php echo smartyTranslate(array('s'=>'Current Password'),$_smarty_tpl);?>

                    </label>
					<div class="col-sm-8">
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="old_passwd" id="old_passwd" />
					</div>
                </div>
                <div class="password form-group">
                    <label class="control-label col-sm-4"  for="passwd">
                        <?php echo smartyTranslate(array('s'=>'New Password'),$_smarty_tpl);?>

                    </label>
					<div class="col-sm-8">
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="passwd" id="passwd" />
					</div>
                </div>
                <div class="password form-group">
                    <label class="control-label col-sm-4"  for="confirmation">
                        <?php echo smartyTranslate(array('s'=>'Confirmation'),$_smarty_tpl);?>

                    </label>
					<div class="col-sm-8">
                    <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="confirmation" id="confirmation" />
					</div>
                </div>
                <?php if (isset($_smarty_tpl->tpl_vars['newsletter']->value)&&$_smarty_tpl->tpl_vars['newsletter']->value) {?>
                    
		<?php }?>
                <?php if (isset($_smarty_tpl->tpl_vars['optin']->value)&&$_smarty_tpl->tpl_vars['optin']->value) {?>
					
                <?php }?>
			<?php if ($_smarty_tpl->tpl_vars['b2b_enable']->value) {?>
				<h1 class="page-subheading size24">
					<?php echo smartyTranslate(array('s'=>'Your company information'),$_smarty_tpl);?>

				</h1>
				<div class="form-group">
					<label class="control-label col-sm-4" for=""><?php echo smartyTranslate(array('s'=>'Company'),$_smarty_tpl);?>
</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="company" name="company" value="<?php if (isset($_POST['company'])) {?><?php echo $_POST['company'];?>
<?php }?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="siret"><?php echo smartyTranslate(array('s'=>'VAT number'),$_smarty_tpl);?>
</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="siret" name="siret" value="<?php if (isset($_POST['siret'])) {?><?php echo $_POST['siret'];?>
<?php }?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-4" for="website"><?php echo smartyTranslate(array('s'=>'Website'),$_smarty_tpl);?>
</label>
					<div class="col-sm-8">
					<input type="text" class="form-control" id="website" name="website" value="<?php if (isset($_POST['website'])) {?><?php echo $_POST['website'];?>
<?php }?>" />
					</div>
				</div>
			<?php }?>
                <?php if (isset($_smarty_tpl->tpl_vars['HOOK_CUSTOMER_IDENTITY_FORM']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['HOOK_CUSTOMER_IDENTITY_FORM']->value;?>

		<?php }?>
                <div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" name="submitIdentity" class="btn btn-outline button button-medium">
                        <span><?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
</span>
                    </button>
                </div>
				</div>
            </fieldset>
        </form> <!-- .std -->
    <?php }?>
</div>
<ul class="footer_links clearfix col-xs-12">
	<li class="pull-left">
        <a class="btn btn-outline button button-small btn-sm" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
">
            <span>
                <i class="fa fa-user"></i><?php echo smartyTranslate(array('s'=>'Back to your account'),$_smarty_tpl);?>

            </span>
        </a>
    </li>
	
</ul>
<?php }} ?>
