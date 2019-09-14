<?php /* Smarty version Smarty-3.1.19, created on 2019-08-20 10:31:24
         compiled from "/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats_daily.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1825406635d5bafdc80dbf7-23544277%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd03a17588816d48f634b5f84793c217f0c615a10' => 
    array (
      0 => '/home/koehlert/public_html/modules/khlbasic/views/templates/admin/salesstats/stats_daily.tpl',
      1 => 1547140244,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1825406635d5bafdc80dbf7-23544277',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5bafdc813984_71845971',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5bafdc813984_71845971')) {function content_5d5bafdc813984_71845971($_smarty_tpl) {?><table class="table table-bordered" id="khlSaleStatsTable">
	<thead>
		<tr>
			<td colspan="10">
			<?php echo $_smarty_tpl->getSubTemplate ('./filter_form.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</td>
		</tr>
		<tr>
			<th><?php echo smartyTranslate(array('s'=>'Date'),$_smarty_tpl);?>
</th>
			<th><?php echo smartyTranslate(array('s'=>'Sold dresses'),$_smarty_tpl);?>
</th>
			<th><?php echo smartyTranslate(array('s'=>'Sale revenue'),$_smarty_tpl);?>
</th>
		</tr>

	</thead>
	<tbody>
	<?php echo $_smarty_tpl->getSubTemplate ('./stats_daily_rows.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</tbody>
	<tfoot>
		<tr>
			<td colspan="10">
				<button id="khlSaleStatsPrev" class="btn btn-primary pull-left">Previous</button>
				
				<button id="khlSaleStatsExport" class="btn btn-default pull-right">Export</button>
			</td>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
<!--
khlSaleStats.init('daily');
//-->
</script><?php }} ?>
