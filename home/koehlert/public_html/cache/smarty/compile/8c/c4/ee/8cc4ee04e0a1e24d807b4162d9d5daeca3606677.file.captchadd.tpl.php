<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:30:04
         compiled from "/home/koehlert/public_html/modules/captchadd/views/templates/hook/captchadd.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9405852545d5960ec4258f4-44542395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8cc4ee04e0a1e24d807b4162d9d5daeca3606677' => 
    array (
      0 => '/home/koehlert/public_html/modules/captchadd/views/templates/hook/captchadd.tpl',
      1 => 1497003683,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9405852545d5960ec4258f4-44542395',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5960ec430ba9_78437044',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5960ec430ba9_78437044')) {function content_5d5960ec430ba9_78437044($_smarty_tpl) {?>
<!-- Module Captchadd By http://www.librasoft.fr/ -->
<div class="captchaContainer">
    <img id='captcha' src='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/captchadd/securimage/securimage_show.php' alt='CAPTCHA Image' />
    <input type='text' name='captcha_code' size='10' maxlength='6' />
    <a id='lien'><img src='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/captchadd/securimage/images/refresh.png' style='cursor: pointer'></a></div>
<script type='text/javascript'>
    $(document).ready(function(){
        $('#lien').click(function(){
            $('#captcha').attr('src','<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/captchadd/securimage/securimage_show.php?' + Math.random());
        });
    });
</script>
<!-- Module Captchadd By http://www.librasoft.fr/ --><?php }} ?>
