<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 19:29:13
         compiled from "/home/koehlert/public_html/modules/customeractive/views/templates/front/thankyou.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8435407025d5adc693d43a9-85240172%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb093f17186bd42f6defde930f7da2e3ac8e667e' => 
    array (
      0 => '/home/koehlert/public_html/modules/customeractive/views/templates/front/thankyou.tpl',
      1 => 1469569619,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8435407025d5adc693d43a9-85240172',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5adc693e08a8_14990603',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5adc693e08a8_14990603')) {function content_5d5adc693e08a8_14990603($_smarty_tpl) {?>

<div class="col-xs-12 col-sm-12 col-md-12" style="padding-top:20px">
    <h1 class="page-heading bottom-indent"><?php echo smartyTranslate(array('s'=>'Registration Successfull','mod'=>'customeractive'),$_smarty_tpl);?>
</h1>
    <p class="warning"><?php echo smartyTranslate(array('s'=>'Thank you for your registration. We will check your registration and contact you soon.','mod'=>'customeractive'),$_smarty_tpl);?>
</p>
</div>

<script>
$("#left_column, #breadcrumb").remove();
$("#center_column").toggleClass("col-md-12");
</script>
<?php }} ?>
