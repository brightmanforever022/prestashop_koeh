{*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if !$logged AND !$cart->id_customer AND ($page_name|escape:'html':'UTF-8' == 'category' or $page_name|escape:'html':'UTF-8' == 'product') }
<script>
  window.location = "index.php?controller=authentication";
</script>
{/if}
{if !$logged AND !$cart->id_customer AND $page_name|escape:'html':'UTF-8' == 'cms' AND ($cms->id == 3 OR $cms->id == 5)}
<script>
  window.location = "index.php?controller=authentication";
</script>
{/if}

<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<html{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if} {if isset($IS_RTL) && $IS_RTL} dir="rtl" class="rtl{if isset($LEO_DEFAULT_SKIN)} {$LEO_DEFAULT_SKIN}{/if}" {else} class="{if isset($LEO_DEFAULT_SKIN)}{$LEO_DEFAULT_SKIN}{/if}" {/if}>
  {include file="$tpl_dir./layout/setting.tpl"}
  <head>
    <meta charset="utf-8" />
    <title>{$meta_title|escape:'html':'UTF-8'}</title>
    {if isset($meta_description) AND $meta_description}
      <meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
    {/if}
    {if isset($meta_keywords) AND $meta_keywords}
      <meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
    {/if}
    <meta name="generator" content="PrestaShop" />
    <meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
    {if $ENABLE_RESPONSIVE}<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />{/if}
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
    <link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css' />
    {if isset($css_files)}
      {foreach from=$css_files key=css_uri item=media}
        <link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
      {/foreach}
    {/if}
    {if isset($js_defer) && !$js_defer && isset($js_files) && isset($js_def)}
      {$js_def}
      {foreach from=$js_files item=js_uri}
      <script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
      {/foreach}
{/if}
    {if $ENABLE_RESPONSIVE}
    <link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/css/responsive.css"/>
    {else}
    <link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/css/non-responsive.css"/>
    {/if}
    <link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/css/font-awesome.min.css"/>
    {$HOOK_HEADER}
                {if isset($LEO_CSS)}{foreach from=$LEO_CSS key=css_uri item=media}
                <link rel="stylesheet" href="{$css_uri}" type="text/css" media="{$media}" />
                {/foreach}{/if}
    {if isset($CUSTOM_FONT)}
                {$CUSTOM_FONT}
    {/if}
    {if isset($LAYOUT_WIDTH)}
                {$LAYOUT_WIDTH}
    {/if}
    <!-- <link href='http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700' rel='stylesheet' type='text/css'> -->
    
    <!--[if IE 8]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    {if isset($LEO_SKIN_CSS)}
      {foreach from=$LEO_SKIN_CSS item=linkCss}
        {$linkCss}
      {/foreach}
    {/if}
    <link href='http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link href='http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    
    {if !$logged AND !$cart->id_customer}
      <link href='{$content_dir}themes/{$LEO_THEMENAME}/css/hiddenfornonreguser.css' rel='stylesheet' type='text/css'>
    {/if}
    <!--script src="/themes/leo_wedding_dress/js/jQuery.scrollSpeed.js"></script>
    <script>
      $(document).ready(function(){
        jQuery.scrollSpeed(50, 400);}
      );
    </script-->
  </head>
  <body{if isset($page_name)} id="{$page_name|escape:'html':'UTF-8'}"{/if} class="{if isset($page_name)}{$page_name|escape:'html':'UTF-8'}{/if}{if isset($body_classes) && $body_classes|@count} {implode value=$body_classes separator=' '}{/if}{if $hide_left_column} hide-left-column{/if}{if $hide_right_column} hide-right-column{/if}{if isset($content_only) &&  $content_only} content_only{/if} lang_{$lang_iso} {if isset($LEO_LAYOUT_MODE)}{$LEO_LAYOUT_MODE}{/if}{if isset($USE_FHEADER) && $USE_FHEADER} keep-header{/if}{if isset($LEO_HEADER_STYLE)} {$LEO_HEADER_STYLE}{/if}{if $LEO_HEADER_STYLE!="header-hide-topmenu" && $LEO_SIDEBAR_MENU!="sidebar-hide"} double-menu{/if}">
    {if !isset($content_only) || !$content_only}
    {if isset($restricted_country_mode) && $restricted_country_mode}
      <section id="restricted-country">
        <p>{l s='You cannot place a new order from your country.'}{if isset($geolocation_country) && $geolocation_country} <span class="bold">{$geolocation_country|escape:'html':'UTF-8'}</span>{/if}</p>
      </section>
    {/if}
    <section id="page" data-column="{$colValue}" data-type="{$LISTING_GRIG_MODE}">
      <!-- Header -->
      <header id="header">
        <section class="header-container">
          {capture name='displayBanner'}{hook h='displayBanner'}{/capture}
          {if $smarty.capture.displayBanner}
          <div class="banner">
              {$smarty.capture.displayBanner}
          </div>
          {/if}
                      {capture name='displayNav'}{hook h='displayNav'}{/capture}
                      {if $smarty.capture.displayNav}
          <div id="topbar">
            <div class="container">
              <div class="inner">
                              <nav {if !$logged AND !$cart->id_customer} style="display:none;"{/if}>{$smarty.capture.displayNav}</nav>
              </div>
            </div>
          </div>
          {/if}
          <div id="header-main">
            <div class="container">
              <div class="inner clearfix">
                <div id="header_logo">
                  <a href="{$base_dir}" title="{$shop_name|escape:'html':'UTF-8'}">
                    <img class="logo img-responsive" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"{if isset($logo_image_width) && $logo_image_width} width="{$logo_image_width}"{/if}{if isset($logo_image_height) && $logo_image_height} height="{$logo_image_height}"{/if}/>
                  </a>
                </div>
                {if isset($HOOK_TOP)}{$HOOK_TOP}{/if}
              </div>
            </div>
          </div>
        </section>
      </header>
      
      <div class="after-fixed-menu"></div>

      
      {if in_array($page_name,array('index'))}
        {capture name='displayTopColumn'}{hook h='displayTopColumn'}{/capture}
        {if $smarty.capture.displayTopColumn}
        <div id="slideshow-wrap" style="overflow:hidden;border-bottom: 30px solid #fff;">
          <div id="slideshow" class="clearfix slideshow-paralax rellax" data-rellax-speed="-7">
            {$smarty.capture.displayTopColumn}
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
        {/if}
      {/if}

      {*{if $page_name !='index' && $page_name !='pagenotfound'}
        <div id="breadcrumb" class="clearfix">   
          <div class="container">
            {include file="$tpl_dir./breadcrumb.tpl"}
          </div>
        </div>
      {/if}*}
  
      <script>
      var userLoginIn ={if $logged AND $cart->id_customer}1{else}0{/if};
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
  
          {if $page_name !='index' && $page_name !='pagenotfound'}
            <div id="breadcrumb" class="clearfix">   
              {include file="$tpl_dir./breadcrumb.tpl"} 
            </div>
          {/if}

          {if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
          <div class="{if {$cols|intval} != 12}row{else}inner{/if}">
      
                        {if !isset($LEO_LAYOUT_DIRECTION)} {assign var="LEO_LAYOUT_DIRECTION" value="default" scope='global'} {/if}
            {include file="$tpl_dir./layout/{$LEO_LAYOUT_DIRECTION}/header.tpl"}  
          {/if}
