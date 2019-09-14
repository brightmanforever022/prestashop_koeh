<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:46
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/modules/blockuserinfo/nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1189192755d596062215599-56690286%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a7a4e7b50bf2ec7179a7b1af80b9de9364e4ba1' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/modules/blockuserinfo/nav.tpl',
      1 => 1483856258,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1189192755d596062215599-56690286',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_logged' => 0,
    'link' => 0,
    'cookie' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d59606224b242_04875929',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d59606224b242_04875929')) {function content_5d59606224b242_04875929($_smarty_tpl) {?>
<!-- Block user information module NAV  -->
<div class="displaynav">
		
	<div class="header_user_info pull-right e-scale popup-over">
		<div class="popup-title"><i class="fa fa-user"></i><?php echo smartyTranslate(array('s'=>'Account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</div>	
		<div class="popup-content">
			<ul class="links-block">
				<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
					<li class="first">
						<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="account" rel="nofollow">
							<span><?php echo smartyTranslate(array('s'=>'Hello','mod'=>'blockuserinfo'),$_smarty_tpl);?>
, <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_lastname;?>
</span>
						</a>
					</li>
				<?php }?>
				<li>
						<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="account" rel="nofollow">
							<span><?php echo smartyTranslate(array('s'=>'My account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span>
						</a>
				</li>

				<li>
						<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Here are the orders you\'ve placed since your account was created.','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="history" rel="nofollow">
							<span><?php echo smartyTranslate(array('s'=>'Order history','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span>
						</a>
				</li>
				<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
					<li><a class="logout" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout"), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Sign out','mod'=>'blockuserinfo'),$_smarty_tpl);?>

					</a></li>
				<?php } else { ?>
					<li class="first"><a class="login" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Login to your customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Sign in','mod'=>'blockuserinfo'),$_smarty_tpl);?>

					</a></li>
				<?php }?>  
			</ul>
		</div>
	</div>	
</div><?php }} ?>
