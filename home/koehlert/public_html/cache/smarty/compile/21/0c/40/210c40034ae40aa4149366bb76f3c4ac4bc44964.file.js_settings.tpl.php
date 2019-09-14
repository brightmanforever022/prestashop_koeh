<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/javascript/js_settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2415604645d5a47a8c925d6-25932002%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '210c40034ae40aa4149366bb76f3c4ac4bc44964' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/javascript/js_settings.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2415604645d5a47a8c925d6-25932002',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'jsData' => 0,
    'href_replace' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8c9ae31_96107683',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8c9ae31_96107683')) {function content_5d5a47a8c9ae31_96107683($_smarty_tpl) {?>

<script type="text/javascript">

	
	NewsletterPro.dataStorage.addObject(jQuery.parseJSON('<?php echo strval($_smarty_tpl->tpl_vars['jsData']->value);?>
'));

	// script alias, for the websites that have cache, this variables are not required, they can be deleted
	var CATEGORIES_LIST = NewsletterPro.dataStorage.get('categories_list'),
		NPRO_CONFIGURATION = {
			'SUBSCRIPTION_ACTIVE': NewsletterPro.dataStorage.getNumber('configuration.SUBSCRIPTION_ACTIVE'),
			'VIEW_ACTIVE_ONLY': NewsletterPro.dataStorage.getNumber('configuration.VIEW_ACTIVE_ONLY'),
			'PS_SHOP_EMAIL': NewsletterPro.dataStorage.get('configuration.PS_SHOP_EMAIL')
		},
		NEWSLETTER_PRO_IMG_PATH = NewsletterPro.dataStorage.get('module_img_path'),
		DISPLAY_PRODUCT_IMAGE = NewsletterPro.dataStorage.getNumber('configuration.DISPLAY_PRODUCT_IMAGE'),
		NPRO_AJAX_URL = NewsletterPro.dataStorage.get('ajax_url'),
		NPRO_TRANSLATIONS = {
			'add': "<?php echo smartyTranslate(array('s'=>'add','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
			'remove': "<?php echo smartyTranslate(array('s'=>'remove','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
		};

	<?php if ($_smarty_tpl->tpl_vars['href_replace']->value==true) {?>
		window.location.href = window.location.href.replace(/&downloadImportSample/, '');
	<?php }?>
</script><?php }} ?>
