<?php /* Smarty version Smarty-3.1.19, created on 2019-08-18 16:27:45
         compiled from "/home/koehlert/public_html/themes/leo_wedding_dress/layout/setting.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7905884235d596061f250a5-75116636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7a5f5234a7c562aa82366a635aaf961097f4001' => 
    array (
      0 => '/home/koehlert/public_html/themes/leo_wedding_dress/layout/setting.tpl',
      1 => 1468539452,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7905884235d596061f250a5-75116636',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LISTING_PRODUCT_COLUMN' => 0,
    'LISTING_PRODUCT_MOBILE' => 0,
    'LISTING_PRODUCT_TABLET' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596062009a72_84522379',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596062009a72_84522379')) {function content_5d596062009a72_84522379($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"])) {$_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"] = clone $_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"];
$_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"]->value = "1"; $_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"]->nocache = null; $_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"]->scope = 3;
} else $_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"] = new Smarty_variable("1", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["ENABLE_RESPONSIVE"] = clone $_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["ENABLE_RESPONSIVE"] = clone $_smarty_tpl->tpl_vars["ENABLE_RESPONSIVE"];?><?php if (isset($_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"])) {$_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"];
$_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]->value = "grid"; $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]->nocache = null; $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]->scope = 3;
} else $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"] = new Smarty_variable("grid", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"];?><?php if (isset($_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"])) {$_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"];
$_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"]->value = "3"; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"]->nocache = null; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"]->scope = 3;
} else $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"] = new Smarty_variable("3", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LISTING_PRODUCT_COLUMN"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LISTING_PRODUCT_COLUMN"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN"];?><?php if (isset($_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"])) {$_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"];
$_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"]->value = "3"; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"]->nocache = null; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"]->scope = 3;
} else $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"] = new Smarty_variable("3", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_COLUMN_MODULE"];?><?php if (isset($_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"])) {$_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"];
$_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"]->value = "2"; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"]->nocache = null; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"]->scope = 3;
} else $_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"] = new Smarty_variable("2", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LISTING_PRODUCT_TABLET"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LISTING_PRODUCT_TABLET"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_TABLET"];?><?php if (isset($_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"])) {$_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"];
$_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"]->value = "1"; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"]->nocache = null; $_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"]->scope = 3;
} else $_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"] = new Smarty_variable("1", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LISTING_PRODUCT_MOBILE"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LISTING_PRODUCT_MOBILE"] = clone $_smarty_tpl->tpl_vars["LISTING_PRODUCT_MOBILE"];?><?php if (isset($_smarty_tpl->tpl_vars["ENABLE_WISHLIST"])) {$_smarty_tpl->tpl_vars["ENABLE_WISHLIST"] = clone $_smarty_tpl->tpl_vars["ENABLE_WISHLIST"];
$_smarty_tpl->tpl_vars["ENABLE_WISHLIST"]->value = "1"; $_smarty_tpl->tpl_vars["ENABLE_WISHLIST"]->nocache = null; $_smarty_tpl->tpl_vars["ENABLE_WISHLIST"]->scope = 3;
} else $_smarty_tpl->tpl_vars["ENABLE_WISHLIST"] = new Smarty_variable("1", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["ENABLE_WISHLIST"] = clone $_smarty_tpl->tpl_vars["ENABLE_WISHLIST"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["ENABLE_WISHLIST"] = clone $_smarty_tpl->tpl_vars["ENABLE_WISHLIST"];?><?php if (isset($_smarty_tpl->tpl_vars["ENABLE_COLOR"])) {$_smarty_tpl->tpl_vars["ENABLE_COLOR"] = clone $_smarty_tpl->tpl_vars["ENABLE_COLOR"];
$_smarty_tpl->tpl_vars["ENABLE_COLOR"]->value = "0"; $_smarty_tpl->tpl_vars["ENABLE_COLOR"]->nocache = null; $_smarty_tpl->tpl_vars["ENABLE_COLOR"]->scope = 3;
} else $_smarty_tpl->tpl_vars["ENABLE_COLOR"] = new Smarty_variable("0", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["ENABLE_COLOR"] = clone $_smarty_tpl->tpl_vars["ENABLE_COLOR"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["ENABLE_COLOR"] = clone $_smarty_tpl->tpl_vars["ENABLE_COLOR"];?><?php if ($_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN']->value=="5") {?>
    <?php if (isset($_smarty_tpl->tpl_vars["colValue"])) {$_smarty_tpl->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];
$_smarty_tpl->tpl_vars["colValue"]->value = "col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-2-4"; $_smarty_tpl->tpl_vars["colValue"]->nocache = null; $_smarty_tpl->tpl_vars["colValue"]->scope = 3;
} else $_smarty_tpl->tpl_vars["colValue"] = new Smarty_variable("col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-2-4", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];?>
<?php } else { ?>
    <?php if (isset($_smarty_tpl->tpl_vars["colValue"])) {$_smarty_tpl->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];
$_smarty_tpl->tpl_vars["colValue"]->value = "col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN']->value)); $_smarty_tpl->tpl_vars["colValue"]->nocache = null; $_smarty_tpl->tpl_vars["colValue"]->scope = 3;
} else $_smarty_tpl->tpl_vars["colValue"] = new Smarty_variable("col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN']->value)), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];?>
<?php }?><?php }} ?>
