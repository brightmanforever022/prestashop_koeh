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

{capture name=path}{l s='Order confirmation'}{/capture}

<h1 class="page-heading">{l s='Order confirmation'}</h1>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{include file="$tpl_dir./errors.tpl"}

{*$HOOK_ORDER_CONFIRMATION*}
{*$HOOK_PAYMENT_RETURN*}
{*Ihre Bestellung auf Christian Koehlert ist abgeschlossen.*}
<p class="cheque-indent alert alert-success">
<strong class="dark">{l s='Your order on Christian Koehlert is complete.'}</strong>
</p>
<p>{l s='Vielen Dank für Ihren Auftrag.'}</p>
<p>{l s='Wir werden Ihre Bestellung umgehend prüfen und Ihnen dann eine Auftragsbestätigung zukommen lassen. In dieser Auftragsbestätigung finden Sie alle weiteren Details zur
Lieferzeit und Bezahlung.'}
</p>

<p>{l s='Wir danken für Ihr Vertrauen und wünschen Ihnen gute Geschäfte.'}</p>

</p>
{if $is_guest}
	<p>{l s='Your order ID is:'} <span class="bold">{$id_order_formatted}</span> . {l s='Your order ID has been sent via email.'}</p>
    <p class="cart_navigation exclusive">
	<a class="button-exclusive btn btn-outline" href="{$link->getPageLink('guest-tracking', true, NULL, "id_order={$reference_order|urlencode}&email={$email|urlencode}")|escape:'html':'UTF-8'}" title="{l s='Follow my order'}">{l s='Follow my order'}</a>
    </p>
{else}
<p class="cart_navigation exclusive">
	<a class="button-exclusive btn btn-outline" href="{$link->getPageLink('history', true)|escape:'html':'UTF-8'}" title="{l s='Go to your order history page'}">{l s='View your order history'}</a>
</p>
{/if}
