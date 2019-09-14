{*
* 2007-2017 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="clearfix">
	<div class="key-block">
		<div class="bootstrap panel">
			<h3>{l s='API key' mod='autotranslator'}</h3>
			<form method="post" action="" class="form-horizontal clearfix">
				<div class="key-input-wrapper">
					<input type="text" value="{$key|escape:'html':'UTF-8'}" class="text" name="yandex_api_key">
					<input type="submit" value="{l s='OK' mod='autotranslator'}" class="btn btn-default" name="updateAPIkey">
				</div>
				<p class="note"><a href="http://api.yandex.com/key/form.xml?service=trnsl" target="_blank"><i class="icon-key"></i>  {l s='Get a free key' mod='autotranslator'}</a> | {l s='Powered by' mod='autotranslator'} <a href="http://translate.yandex.com/" target="_blank">Yandex.Translate</a></p>
			</form>
		</div>
	</div>
	<div class="info-block">
		<div class="bootstrap panel clearfix">
			<h3>{l s='Information' mod='autotranslator'} <span class="current-version">v{$version|escape:'html':'UTF-8'}</span></h3>
			<a href="{$info_links.documentation|escape:'html':'UTF-8'}" target="_blank">
				<i class="icon-file-text"></i> {l s='Documentation' mod='autotranslator'}
			</a>
			<a href="{$info_links.changelog|escape:'html':'UTF-8'}" target="_blank">
				<i class="icon-code-fork"></i> {l s='Changelog' mod='autotranslator'}
			</a>
			<a href="{$info_links.contact|escape:'html':'UTF-8'}" target="_blank">
				<i class="icon-envelope"></i> {l s='Contact us' mod='autotranslator'}
			</a>
			<a href="{$info_links.modules|escape:'html':'UTF-8'}" target="_blank">
				<i class="icon-download"></i> {l s='Our modules' mod='autotranslator'}
			</a>
		</div>
	</div>
</div>
{* since 2.7.0 *}
