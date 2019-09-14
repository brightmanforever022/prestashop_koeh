<?php /* Smarty version Smarty-3.1.19, created on 2019-09-10 13:19:52
         compiled from "/home/koehlert/public_html/modules/product_list/views/templates/admin/product_list/helpers/list/list_footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5045889505d596334530a27-24716319%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29404a350f7365f35de63e0457f20cefba75a363' => 
    array (
      0 => '/home/koehlert/public_html/modules/product_list/views/templates/admin/product_list/helpers/list/list_footer.tpl',
      1 => 1568117426,
      2 => 'file',
    ),
    '5ef8b62f37670df494f74bad687e8e5b1107e65c' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/list/list_footer.tpl',
      1 => 1503362864,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5045889505d596334530a27-24716319',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596334611588_94476119',
  'variables' => 
  array (
    'bulk_actions' => 0,
    'has_bulk_actions' => 0,
    'list_id' => 0,
    'params' => 0,
    'key' => 0,
    'table' => 0,
    'simple_header' => 0,
    'list_total' => 0,
    'pagination' => 0,
    'selected_pagination' => 0,
    'value' => 0,
    'page' => 0,
    'p' => 0,
    'total_pages' => 0,
    'toolbar_btn' => 0,
    'k' => 0,
    'btn' => 0,
    'back_button' => 0,
    'token' => 0,
    'name_controller' => 0,
    'hookName' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596334611588_94476119')) {function content_5d596334611588_94476119($_smarty_tpl) {?>
	</table>
</div>
<div class="row">
	<div class="col-lg-6">
		<?php if ($_smarty_tpl->tpl_vars['bulk_actions']->value&&$_smarty_tpl->tpl_vars['has_bulk_actions']->value) {?>
		<div class="btn-group bulk-actions dropup">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<?php echo smartyTranslate(array('s'=>'Bulk actions'),$_smarty_tpl);?>
 <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li>
					<a href="#" onclick="javascript:checkDelBoxes($(this).closest('form').get(0), '<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Box[]', true);return false;">
						<i class="icon-check-sign"></i>&nbsp;<?php echo smartyTranslate(array('s'=>'Select all'),$_smarty_tpl);?>

					</a>
				</li>
				<li>
					<a href="#" onclick="javascript:checkDelBoxes($(this).closest('form').get(0), '<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Box[]', false);return false;">
						<i class="icon-check-empty"></i>&nbsp;<?php echo smartyTranslate(array('s'=>'Unselect all'),$_smarty_tpl);?>

					</a>
				</li>
				<li class="divider"></li>
				<?php  $_smarty_tpl->tpl_vars['params'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['params']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bulk_actions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['params']->key => $_smarty_tpl->tpl_vars['params']->value) {
$_smarty_tpl->tpl_vars['params']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['params']->key;
?>
					<li<?php if ($_smarty_tpl->tpl_vars['params']->value['text']=='divider') {?> class="divider"<?php }?>>
						<?php if ($_smarty_tpl->tpl_vars['params']->value['text']!='divider') {?>
						<a href="#" onclick="<?php if (isset($_smarty_tpl->tpl_vars['params']->value['confirm'])) {?>if (confirm('<?php echo $_smarty_tpl->tpl_vars['params']->value['confirm'];?>
'))<?php }?>sendBulkAction($(this).closest('form').get(0), 'submitBulk<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
', <?php if (!empty($_smarty_tpl->tpl_vars['params']->value['targetBlank'])) {?>'<?php echo strtr($_smarty_tpl->tpl_vars['params']->value['targetBlank'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'<?php } else { ?>0<?php }?>);">
							<?php if (isset($_smarty_tpl->tpl_vars['params']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['params']->value['icon'];?>
"></i><?php }?>&nbsp;<?php echo $_smarty_tpl->tpl_vars['params']->value['text'];?>

						</a>
						<?php }?>
					</li>
				<?php } ?>
			</ul>
		</div>
		<?php }?>
	</div>
	<?php if (!$_smarty_tpl->tpl_vars['simple_header']->value&&$_smarty_tpl->tpl_vars['list_total']->value>$_smarty_tpl->tpl_vars['pagination']->value[0]) {?>
	<div class="col-lg-6">
		
		<div class="pagination">
			<?php echo smartyTranslate(array('s'=>'Display'),$_smarty_tpl);?>

			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<?php echo $_smarty_tpl->tpl_vars['selected_pagination']->value;?>

				<i class="icon-caret-down"></i>
			</button>
			<ul class="dropdown-menu">
			<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pagination']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
				<li>
					<a href="javascript:void(0);" class="pagination-items-page" data-items="<?php echo intval($_smarty_tpl->tpl_vars['value']->value);?>
" data-list-id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a>
				</li>
			<?php } ?>
			</ul>
			/ <?php echo $_smarty_tpl->tpl_vars['list_total']->value;?>
 <?php echo smartyTranslate(array('s'=>'result(s)'),$_smarty_tpl);?>

			<input type="hidden" id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
-pagination-items-page" name="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
_pagination" value="<?php echo intval($_smarty_tpl->tpl_vars['selected_pagination']->value);?>
" />
		</div>
		<script type="text/javascript">
			$('.pagination-items-page').on('click',function(e){
				e.preventDefault();
				$('#'+$(this).data("list-id")+'-pagination-items-page').val($(this).data("items")).closest("form").submit();
			});
		</script>
		<ul class="pagination pull-right">
			<li <?php if ($_smarty_tpl->tpl_vars['page']->value<=1) {?>class="disabled"<?php }?>>
				<a href="javascript:void(0);" class="pagination-link" data-page="1" data-list-id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
">
					<i class="icon-double-angle-left"></i>
				</a>
			</li>
			<li <?php if ($_smarty_tpl->tpl_vars['page']->value<=1) {?>class="disabled"<?php }?>>
				<a href="javascript:void(0);" class="pagination-link" data-page="<?php echo $_smarty_tpl->tpl_vars['page']->value-1;?>
" data-list-id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
">
					<i class="icon-angle-left"></i>
				</a>
			</li>
			<?php if (isset($_smarty_tpl->tpl_vars['p'])) {$_smarty_tpl->tpl_vars['p'] = clone $_smarty_tpl->tpl_vars['p'];
$_smarty_tpl->tpl_vars['p']->value = 0; $_smarty_tpl->tpl_vars['p']->nocache = null; $_smarty_tpl->tpl_vars['p']->scope = 0;
} else $_smarty_tpl->tpl_vars['p'] = new Smarty_variable(0, null, 0);?>
			<?php while ($_smarty_tpl->tpl_vars['p']->value++<$_smarty_tpl->tpl_vars['total_pages']->value) {?>
				<?php if ($_smarty_tpl->tpl_vars['p']->value<$_smarty_tpl->tpl_vars['page']->value-2) {?>
					<li class="disabled">
						<a href="javascript:void(0);">&hellip;</a>
					</li>
					<?php if (isset($_smarty_tpl->tpl_vars['p'])) {$_smarty_tpl->tpl_vars['p'] = clone $_smarty_tpl->tpl_vars['p'];
$_smarty_tpl->tpl_vars['p']->value = $_smarty_tpl->tpl_vars['page']->value-3; $_smarty_tpl->tpl_vars['p']->nocache = null; $_smarty_tpl->tpl_vars['p']->scope = 0;
} else $_smarty_tpl->tpl_vars['p'] = new Smarty_variable($_smarty_tpl->tpl_vars['page']->value-3, null, 0);?>
				<?php } elseif ($_smarty_tpl->tpl_vars['p']->value>$_smarty_tpl->tpl_vars['page']->value+2) {?>
					<li class="disabled">
						<a href="javascript:void(0);">&hellip;</a>
					</li>
					<?php if (isset($_smarty_tpl->tpl_vars['p'])) {$_smarty_tpl->tpl_vars['p'] = clone $_smarty_tpl->tpl_vars['p'];
$_smarty_tpl->tpl_vars['p']->value = $_smarty_tpl->tpl_vars['total_pages']->value; $_smarty_tpl->tpl_vars['p']->nocache = null; $_smarty_tpl->tpl_vars['p']->scope = 0;
} else $_smarty_tpl->tpl_vars['p'] = new Smarty_variable($_smarty_tpl->tpl_vars['total_pages']->value, null, 0);?>
				<?php } else { ?>
					<li <?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->tpl_vars['page']->value) {?>class="active"<?php }?>>
						<a href="javascript:void(0);" class="pagination-link" data-page="<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
" data-list-id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
</a>
					</li>
				<?php }?>
			<?php }?>
			<li <?php if ($_smarty_tpl->tpl_vars['page']->value>=$_smarty_tpl->tpl_vars['total_pages']->value) {?>class="disabled"<?php }?>>
				<a href="javascript:void(0);" class="pagination-link" data-page="<?php echo $_smarty_tpl->tpl_vars['page']->value+1;?>
" data-list-id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
">
					<i class="icon-angle-right"></i>
				</a>
			</li>
			<li <?php if ($_smarty_tpl->tpl_vars['page']->value>=$_smarty_tpl->tpl_vars['total_pages']->value) {?>class="disabled"<?php }?>>
				<a href="javascript:void(0);" class="pagination-link" data-page="<?php echo $_smarty_tpl->tpl_vars['total_pages']->value;?>
" data-list-id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
">
					<i class="icon-double-angle-right"></i>
				</a>
			</li>
		</ul>
		<script type="text/javascript">
			$('.pagination-link').on('click',function(e){
				e.preventDefault();

				if (!$(this).parent().hasClass('disabled'))
					$('#submitFilter'+$(this).data("list-id")).val($(this).data("page")).closest("form").submit();
			});
		</script>
	</div>
	<?php }?>
</div>

<div class="panel-footer">
	<div class="form-inline">
		<div class="form-group">
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="reference">
		  		<?php echo smartyTranslate(array('s'=>'Item number'),$_smarty_tpl);?>

			</label>
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="price">
		  		<?php echo smartyTranslate(array('s'=>'Item Price'),$_smarty_tpl);?>

			</label>
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="qr_code">
		  		<?php echo smartyTranslate(array('s'=>'QR code'),$_smarty_tpl);?>

			</label>
			<label class="radio-inline">
		  		<input type="checkbox" name="photos_download_option[]" value="stock">
		  		<?php echo smartyTranslate(array('s'=>'Item stock'),$_smarty_tpl);?>

			</label>

		</div>
		&nbsp;
		<button class="btn btn-primary" name="action" value="photos_download" type="submit"><?php echo smartyTranslate(array('s'=>'Download photos'),$_smarty_tpl);?>
</button>
		&nbsp;
		<button class="btn btn-primary" name="action" value="prodimg_pdf" id="prodimg_pdf" type="submit"><?php echo smartyTranslate(array('s'=>'Create PDF mailing'),$_smarty_tpl);?>
</button>
	</div>
</div>
<div class="panel-footer">
	<button name="action" value="sticker_print_dymo" id="sticker_print_dymo" type="button" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'CK Etikett Dymo'),$_smarty_tpl);?>
</button>
	<button name="action" value="sticker_print_pdf" id="sticker_print_pdf" type="submit" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'CK Etikett PDF'),$_smarty_tpl);?>
</button>
	&nbsp;
	<button name="action" value="sticker_exhb_print_dymo" id="sticker_exhb_print_dymo" type="button" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'CK Messe Etikett Dymo'),$_smarty_tpl);?>
</button>
	<button name="action" value="sticker_exhb_print_pdf" id="sticker_exhb_print_pdf" type="submit" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'CK Messe Etikett PDF'),$_smarty_tpl);?>
</button>
	&nbsp;
	<button name="action" value="export_excel" id="export_excel" type="submit" class="btn btn-primary"><?php echo smartyTranslate(array('s'=>'Export to Excel'),$_smarty_tpl);?>
</button>
</div>

<div class="modal fade" id="salesGraphPopup" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xxl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sale stats</h4>
        <p></p>
      </div>
      <div class="modal-body">
		<div id="salesGraphLeft"></div>
      </div>
    </div>
  </div>
</div>

<?php if (!$_smarty_tpl->tpl_vars['simple_header']->value) {?>
		<input type="hidden" name="token" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
	</div>
<?php } else { ?>
	</div>
<?php }?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayAdminListAfter'),$_smarty_tpl);?>

<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
ListAfter<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php } elseif (isset($_GET['controller'])) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
ListAfter<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php }?>


</form>



<?php }} ?>
