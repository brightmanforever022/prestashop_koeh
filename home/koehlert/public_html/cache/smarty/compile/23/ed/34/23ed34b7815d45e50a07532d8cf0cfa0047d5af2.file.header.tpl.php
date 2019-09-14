<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:45
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19118485875d596061dec950-48356891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23ed34b7815d45e50a07532d8cf0cfa0047d5af2' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/header.tpl',
      1 => 1536678584,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19118485875d596061dec950-48356891',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'logged' => 0,
    'cart' => 0,
    'page_name' => 0,
    'cms' => 0,
    'language_code' => 0,
    'IS_RTL' => 0,
    'LEO_DEFAULT_SKIN' => 0,
    'meta_title' => 0,
    'meta_description' => 0,
    'meta_keywords' => 0,
    'nobots' => 0,
    'nofollow' => 0,
    'ENABLE_RESPONSIVE' => 0,
    'favicon_url' => 0,
    'img_update_time' => 0,
    'css_files' => 0,
    'css_uri' => 0,
    'media' => 0,
    'js_defer' => 0,
    'js_files' => 0,
    'js_def' => 0,
    'js_uri' => 0,
    'content_dir' => 0,
    'LEO_THEMENAME' => 0,
    'HOOK_HEADER' => 0,
    'LEO_CSS' => 0,
    'CUSTOM_FONT' => 0,
    'LAYOUT_WIDTH' => 0,
    'LEO_SKIN_CSS' => 0,
    'linkCss' => 0,
    'body_classes' => 0,
    'hide_left_column' => 0,
    'hide_right_column' => 0,
    'content_only' => 0,
    'lang_iso' => 0,
    'LEO_LAYOUT_MODE' => 0,
    'USE_FHEADER' => 0,
    'LEO_HEADER_STYLE' => 0,
    'LEO_SIDEBAR_MENU' => 0,
    'restricted_country_mode' => 0,
    'geolocation_country' => 0,
    'colValue' => 0,
    'LISTING_GRIG_MODE' => 0,
    'base_dir' => 0,
    'shop_name' => 0,
    'logo_url' => 0,
    'logo_image_width' => 0,
    'logo_image_height' => 0,
    'HOOK_TOP' => 0,
    'left_column_size' => 0,
    'right_column_size' => 0,
    'cols' => 0,
    'LEO_LAYOUT_DIRECTION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596061f1fda3_70396838',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596061f1fda3_70396838')) {function content_5d596061f1fda3_70396838($_smarty_tpl) {?><?php if (!is_callable('smarty_function_implode')) include '/home/koehlert/public_html/tools/smarty/plugins/function.implode.php';
?>
<?php if (!$_smarty_tpl->tpl_vars['logged']->value&&!$_smarty_tpl->tpl_vars['cart']->value->id_customer&&(htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true)=='category'||htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true)=='product')) {?>
<script>
  window.location = "index.php?controller=authentication";
</script>
<?php }?>
<?php if (!$_smarty_tpl->tpl_vars['logged']->value&&!$_smarty_tpl->tpl_vars['cart']->value->id_customer&&htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true)=='cms'&&($_smarty_tpl->tpl_vars['cms']->value->id==3||$_smarty_tpl->tpl_vars['cms']->value->id==5)) {?>
<script>
  window.location = "index.php?controller=authentication";
</script>
<?php }?>

<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>><![endif]-->
<html<?php if (isset($_smarty_tpl->tpl_vars['language_code']->value)&&$_smarty_tpl->tpl_vars['language_code']->value) {?> lang="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language_code']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['IS_RTL']->value)&&$_smarty_tpl->tpl_vars['IS_RTL']->value) {?> dir="rtl" class="rtl<?php if (isset($_smarty_tpl->tpl_vars['LEO_DEFAULT_SKIN']->value)) {?> <?php echo $_smarty_tpl->tpl_vars['LEO_DEFAULT_SKIN']->value;?>
<?php }?>" <?php } else { ?> class="<?php if (isset($_smarty_tpl->tpl_vars['LEO_DEFAULT_SKIN']->value)) {?><?php echo $_smarty_tpl->tpl_vars['LEO_DEFAULT_SKIN']->value;?>
<?php }?>" <?php }?>>
  <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./layout/setting.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

  <head>
    <meta charset="utf-8" />
    <title><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_title']->value, ENT_QUOTES, 'UTF-8', true);?>
</title>
    <?php if (isset($_smarty_tpl->tpl_vars['meta_description']->value)&&$_smarty_tpl->tpl_vars['meta_description']->value) {?>
      <meta name="description" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_description']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['meta_keywords']->value)&&$_smarty_tpl->tpl_vars['meta_keywords']->value) {?>
      <meta name="keywords" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['meta_keywords']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
    <?php }?>
    <meta name="generator" content="PrestaShop" />
    <meta name="robots" content="<?php if (isset($_smarty_tpl->tpl_vars['nobots']->value)) {?>no<?php }?>index,<?php if (isset($_smarty_tpl->tpl_vars['nofollow']->value)&&$_smarty_tpl->tpl_vars['nofollow']->value) {?>no<?php }?>follow" />
    <?php if ($_smarty_tpl->tpl_vars['ENABLE_RESPONSIVE']->value) {?><meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" /><?php }?>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $_smarty_tpl->tpl_vars['favicon_url']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['favicon_url']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['img_update_time']->value;?>
" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css' />
    <?php if (isset($_smarty_tpl->tpl_vars['css_files']->value)) {?>
      <?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['media']->_loop = false;
 $_smarty_tpl->tpl_vars['css_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value) {
$_smarty_tpl->tpl_vars['media']->_loop = true;
 $_smarty_tpl->tpl_vars['css_uri']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['css_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
" type="text/css" media="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['media']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
      <?php } ?>
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['js_defer']->value)&&!$_smarty_tpl->tpl_vars['js_defer']->value&&isset($_smarty_tpl->tpl_vars['js_files']->value)&&isset($_smarty_tpl->tpl_vars['js_def']->value)) {?>
      <?php echo $_smarty_tpl->tpl_vars['js_def']->value;?>

      <?php  $_smarty_tpl->tpl_vars['js_uri'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_uri']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->key => $_smarty_tpl->tpl_vars['js_uri']->value) {
$_smarty_tpl->tpl_vars['js_uri']->_loop = true;
?>
      <script type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['js_uri']->value, ENT_QUOTES, 'UTF-8', true);?>
"></script>
      <?php } ?>
<?php }?>
    <?php if ($_smarty_tpl->tpl_vars['ENABLE_RESPONSIVE']->value) {?>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
themes/<?php echo $_smarty_tpl->tpl_vars['LEO_THEMENAME']->value;?>
/css/responsive.css"/>
    <?php } else { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
themes/<?php echo $_smarty_tpl->tpl_vars['LEO_THEMENAME']->value;?>
/css/non-responsive.css"/>
    <?php }?>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
themes/<?php echo $_smarty_tpl->tpl_vars['LEO_THEMENAME']->value;?>
/css/font-awesome.min.css"/>
    <?php echo $_smarty_tpl->tpl_vars['HOOK_HEADER']->value;?>

                <?php if (isset($_smarty_tpl->tpl_vars['LEO_CSS']->value)) {?><?php  $_smarty_tpl->tpl_vars['media'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['media']->_loop = false;
 $_smarty_tpl->tpl_vars['css_uri'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['LEO_CSS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['media']->key => $_smarty_tpl->tpl_vars['media']->value) {
$_smarty_tpl->tpl_vars['media']->_loop = true;
 $_smarty_tpl->tpl_vars['css_uri']->value = $_smarty_tpl->tpl_vars['media']->key;
?>
                <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['css_uri']->value;?>
" type="text/css" media="<?php echo $_smarty_tpl->tpl_vars['media']->value;?>
" />
                <?php } ?><?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['CUSTOM_FONT']->value)) {?>
                <?php echo $_smarty_tpl->tpl_vars['CUSTOM_FONT']->value;?>

    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['LAYOUT_WIDTH']->value)) {?>
                <?php echo $_smarty_tpl->tpl_vars['LAYOUT_WIDTH']->value;?>

    <?php }?>
    <!-- <link href='http<?php if (Tools::usingSecureMode()) {?>s<?php }?>://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700' rel='stylesheet' type='text/css'> -->
    
    <!--[if IE 8]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <?php if (isset($_smarty_tpl->tpl_vars['LEO_SKIN_CSS']->value)) {?>
      <?php  $_smarty_tpl->tpl_vars['linkCss'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['linkCss']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LEO_SKIN_CSS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['linkCss']->key => $_smarty_tpl->tpl_vars['linkCss']->value) {
$_smarty_tpl->tpl_vars['linkCss']->_loop = true;
?>
        <?php echo $_smarty_tpl->tpl_vars['linkCss']->value;?>

      <?php } ?>
    <?php }?>
    <link href='http<?php if (Tools::usingSecureMode()) {?>s<?php }?>://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link href='http<?php if (Tools::usingSecureMode()) {?>s<?php }?>://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http<?php if (Tools::usingSecureMode()) {?>s<?php }?>://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    
    <?php if (!$_smarty_tpl->tpl_vars['logged']->value&&!$_smarty_tpl->tpl_vars['cart']->value->id_customer) {?>
      <link href='<?php echo $_smarty_tpl->tpl_vars['content_dir']->value;?>
themes/<?php echo $_smarty_tpl->tpl_vars['LEO_THEMENAME']->value;?>
/css/hiddenfornonreguser.css' rel='stylesheet' type='text/css'>
    <?php }?>
    <!--script src="/themes/leo_wedding_dress/js/jQuery.scrollSpeed.js"></script>
    <script>
      $(document).ready(function(){
        jQuery.scrollSpeed(50, 400);}
      );
    </script-->
  </head>
  <body<?php if (isset($_smarty_tpl->tpl_vars['page_name']->value)) {?> id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> class="<?php if (isset($_smarty_tpl->tpl_vars['page_name']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['page_name']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['body_classes']->value)&&count($_smarty_tpl->tpl_vars['body_classes']->value)) {?> <?php echo smarty_function_implode(array('value'=>$_smarty_tpl->tpl_vars['body_classes']->value,'separator'=>' '),$_smarty_tpl);?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['hide_left_column']->value) {?> hide-left-column<?php }?><?php if ($_smarty_tpl->tpl_vars['hide_right_column']->value) {?> hide-right-column<?php }?><?php if (isset($_smarty_tpl->tpl_vars['content_only']->value)&&$_smarty_tpl->tpl_vars['content_only']->value) {?> content_only<?php }?> lang_<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
 <?php if (isset($_smarty_tpl->tpl_vars['LEO_LAYOUT_MODE']->value)) {?><?php echo $_smarty_tpl->tpl_vars['LEO_LAYOUT_MODE']->value;?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['USE_FHEADER']->value)&&$_smarty_tpl->tpl_vars['USE_FHEADER']->value) {?> keep-header<?php }?><?php if (isset($_smarty_tpl->tpl_vars['LEO_HEADER_STYLE']->value)) {?> <?php echo $_smarty_tpl->tpl_vars['LEO_HEADER_STYLE']->value;?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['LEO_HEADER_STYLE']->value!="header-hide-topmenu"&&$_smarty_tpl->tpl_vars['LEO_SIDEBAR_MENU']->value!="sidebar-hide") {?> double-menu<?php }?>">
    <?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['restricted_country_mode']->value) {?>
      <section id="restricted-country">
        <p><?php echo smartyTranslate(array('s'=>'You cannot place a new order from your country.'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['geolocation_country']->value)&&$_smarty_tpl->tpl_vars['geolocation_country']->value) {?> <span class="bold"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['geolocation_country']->value, ENT_QUOTES, 'UTF-8', true);?>
</span><?php }?></p>
      </section>
    <?php }?>
    <section id="page" data-column="<?php echo $_smarty_tpl->tpl_vars['colValue']->value;?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['LISTING_GRIG_MODE']->value;?>
">
      <!-- Header -->
      <header id="header">
        <section class="header-container">
          <?php $_smarty_tpl->_capture_stack[0][] = array('displayBanner', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayBanner'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
          <?php if (Smarty::$_smarty_vars['capture']['displayBanner']) {?>
          <div class="banner">
              <?php echo Smarty::$_smarty_vars['capture']['displayBanner'];?>

          </div>
          <?php }?>
                      <?php $_smarty_tpl->_capture_stack[0][] = array('displayNav', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayNav'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
                      <?php if (Smarty::$_smarty_vars['capture']['displayNav']) {?>
          <div id="topbar">
            <div class="container">
              <div class="inner">
                              <nav <?php if (!$_smarty_tpl->tpl_vars['logged']->value&&!$_smarty_tpl->tpl_vars['cart']->value->id_customer) {?> style="display:none;"<?php }?>><?php echo Smarty::$_smarty_vars['capture']['displayNav'];?>
</nav>
              </div>
            </div>
          </div>
          <?php }?>
          <div id="header-main">
            <div class="container">
              <div class="inner clearfix">
                <div id="header_logo">
                  <a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
">
                    <img class="logo img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value)&&$_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value)&&$_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?>/>
                  </a>
                </div>
                <?php if (isset($_smarty_tpl->tpl_vars['HOOK_TOP']->value)) {?><?php echo $_smarty_tpl->tpl_vars['HOOK_TOP']->value;?>
<?php }?>
              </div>
            </div>
          </div>
        </section>
      </header>
      
      <div class="after-fixed-menu"></div>

      
      <?php if (in_array($_smarty_tpl->tpl_vars['page_name']->value,array('index'))) {?>
        <?php $_smarty_tpl->_capture_stack[0][] = array('displayTopColumn', null, null); ob_start(); ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayTopColumn'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
        <?php if (Smarty::$_smarty_vars['capture']['displayTopColumn']) {?>
        <div id="slideshow-wrap" style="overflow:hidden;border-bottom: 30px solid #fff;">
          <div id="slideshow" class="clearfix slideshow-paralax rellax" data-rellax-speed="-7">
            <?php echo Smarty::$_smarty_vars['capture']['displayTopColumn'];?>

          </div>
        </div>
        
        
        <!--script src="/themes/leo_wedding_dress/js/rellax.min.js"></script>
        <script>
          // Accepts any class name
          var rellax = new Rellax('.rellax');
        </script-->

        <script>
          
          
          $(document).ready(function(){
            var positionArrows = $('.tparrows').position();
            $(window).scroll(function(){
              var st = $(this).scrollTop();
              //$('.slideshow-paralax').css("top" , ( st/1.5) +'px');
              //$('.tp-bullets').css("bottom" ,  ( st/1.5) +'px');
              //$('.tparrows').css("top" , positionArrows.top - ( st/5) +'px');
            });
          });
        </script>
        <?php }?>
      <?php }?>

      
  
      <script>
      var userLoginIn =<?php if ($_smarty_tpl->tpl_vars['logged']->value&&$_smarty_tpl->tpl_vars['cart']->value->id_customer) {?>1<?php } else { ?>0<?php }?>;
      $(document).ready(function(){
        
        $(window).scrollTop(0);
        $(window).scroll(function(){
          if($(this).scrollTop() > 0 && !$('#header').hasClass('fixed-top')){
            $('#header').addClass('fixed-top');
            //if (userLoginIn != 1 && $('#header').hasClass('fixed-top')){
            //  $('#slideshow-wrap').css("margin-top" , '-30px');
            //}
          }
          else if($(this).scrollTop() <= 0 && $('#header').hasClass('fixed-top')){
            $('#header').removeClass('fixed-top');
            //if (userLoginIn != 1 && !$('#header').hasClass('fixed-top')){
            //  $('#slideshow-wrap').css("margin-top" , '0');
            //}
          }
          
        });
      });
      </script>
  
      <!-- Content -->
      <section id="columns" class="columns-container"> 
        <div class="container">     
  
          <?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index'&&$_smarty_tpl->tpl_vars['page_name']->value!='pagenotfound') {?>
            <div id="breadcrumb" class="clearfix">   
              <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
            </div>
          <?php }?>

          <?php if (isset($_smarty_tpl->tpl_vars['left_column_size']->value)&&isset($_smarty_tpl->tpl_vars['right_column_size']->value)) {?><?php if (isset($_smarty_tpl->tpl_vars['cols'])) {$_smarty_tpl->tpl_vars['cols'] = clone $_smarty_tpl->tpl_vars['cols'];
$_smarty_tpl->tpl_vars['cols']->value = (12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value); $_smarty_tpl->tpl_vars['cols']->nocache = null; $_smarty_tpl->tpl_vars['cols']->scope = 0;
} else $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable((12-$_smarty_tpl->tpl_vars['left_column_size']->value-$_smarty_tpl->tpl_vars['right_column_size']->value), null, 0);?><?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['cols'])) {$_smarty_tpl->tpl_vars['cols'] = clone $_smarty_tpl->tpl_vars['cols'];
$_smarty_tpl->tpl_vars['cols']->value = 12; $_smarty_tpl->tpl_vars['cols']->nocache = null; $_smarty_tpl->tpl_vars['cols']->scope = 0;
} else $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable(12, null, 0);?><?php }?>
          <div class="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['cols']->value);?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1!=12) {?>row<?php } else { ?>inner<?php }?>">
      
                        <?php if (!isset($_smarty_tpl->tpl_vars['LEO_LAYOUT_DIRECTION']->value)) {?> <?php if (isset($_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"])) {$_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"] = clone $_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"];
$_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"]->value = "default"; $_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"]->nocache = null; $_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"]->scope = 3;
} else $_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"] = new Smarty_variable("default", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LEO_LAYOUT_DIRECTION"] = clone $_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LEO_LAYOUT_DIRECTION"] = clone $_smarty_tpl->tpl_vars["LEO_LAYOUT_DIRECTION"];?> <?php }?>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./layout/".((string)$_smarty_tpl->tpl_vars['LEO_LAYOUT_DIRECTION']->value)."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
  
          <?php }?>
<?php }} ?>
