<?php /* Smarty version Smarty-3.1.19, created on 2019-09-10 14:16:03
         compiled from "/home/koehlert/public_html/override/controllers/admin/templates/customers/helpers/list/list_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19992054665d596ad53c2288-15829315%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a75d36e4b409c4527a63af12f1826b6448d43470' => 
    array (
      0 => '/home/koehlert/public_html/override/controllers/admin/templates/customers/helpers/list/list_header.tpl',
      1 => 1559298564,
      2 => 'file',
    ),
    '4f301d3c5cbf518e176f2215f4117c4ccb2c9497' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/controllers/customers/helpers/list/list_header.tpl',
      1 => 1559154041,
      2 => 'file',
    ),
    'c15cdcbe8cb0a1a23a5b0bbc238d22effdea9d9a' => 
    array (
      0 => '/home/koehlert/public_html/admin971jqkmvw/themes/default/template/helpers/list/list_header.tpl',
      1 => 1568117408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19992054665d596ad53c2288-15829315',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d596ad55e63d7_98840443',
  'variables' => 
  array (
    'ajax' => 0,
    'is_order_position' => 0,
    'list_id' => 0,
    'order_way' => 0,
    'simple_header' => 0,
    'table' => 0,
    'name_controller' => 0,
    'hookName' => 0,
    'sql' => 0,
    'link' => 0,
    'action' => 0,
    'page' => 0,
    'selected_pagination' => 0,
    'icon' => 0,
    'title' => 0,
    'toolbar_btn' => 0,
    'list_total' => 0,
    'k' => 0,
    'btn' => 0,
    'sql_manager' => 0,
    'show_toolbar' => 0,
    'bulk_actions' => 0,
    'has_bulk_actions' => 0,
    'fields_display' => 0,
    'y' => 0,
    'param' => 0,
    'params' => 0,
    'use_overflow' => 0,
    'table_id' => 0,
    'table_dnd' => 0,
    'order_by' => 0,
    'key' => 0,
    'hint' => 0,
    'show_filters' => 0,
    'currentIndex' => 0,
    'token' => 0,
    'identifier' => 0,
    'shop_link_type' => 0,
    'has_actions' => 0,
    'row_hover' => 0,
    'option_value' => 0,
    'option_display' => 0,
    'filters_has_value' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d596ad55e63d7_98840443')) {function content_5d596ad55e63d7_98840443($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/home/koehlert/public_html/tools/smarty/plugins/function.math.php';
if (!is_callable('smarty_modifier_replace')) include '/home/koehlert/public_html/tools/smarty/plugins/modifier.replace.php';
if (!is_callable('smarty_function_html_options')) include '/home/koehlert/public_html/tools/smarty/plugins/function.html_options.php';
?>
<?php if ($_smarty_tpl->tpl_vars['ajax']->value) {?>
	<script type="text/javascript">
		$(function () {
			$(".ajax_table_link").click(function () {
				var link = $(this);
				$.post($(this).attr('href'), function (data) {
					if (data.success == 1) {
						showSuccessMessage(data.text);
						if (link.hasClass('action-disabled')){
							link.removeClass('action-disabled').addClass('action-enabled');
						} else {
							link.removeClass('action-enabled').addClass('action-disabled');
						}
						link.children().each(function () {
							if ($(this).hasClass('hidden')) {
								$(this).removeClass('hidden');
							} else {
								$(this).addClass('hidden');
							}
						});
					} else {
						showErrorMessage(data.text);
					}
				}, 'json');
				return false;
			});
		});
	</script>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['is_order_position']->value) {?>
	<script type="text/javascript" src="../js/jquery/plugins/jquery.tablednd.js"></script>
	<script type="text/javascript">
		var come_from = '<?php echo addslashes($_smarty_tpl->tpl_vars['list_id']->value);?>
';
		var alternate = <?php if ($_smarty_tpl->tpl_vars['order_way']->value=='DESC') {?>'1'<?php } else { ?>'0'<?php }?>;
	</script>
	<script type="text/javascript" src="../js/admin/dnd.js"></script>
<?php }?>
<?php if (!$_smarty_tpl->tpl_vars['simple_header']->value) {?>
	<script type="text/javascript">
		$(function() {
			$('table.<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
 .filter').keypress(function(e){
				var key = (e.keyCode ? e.keyCode : e.which);
				if (key == 13)
				{
					e.preventDefault();
					formSubmit(e, 'submitFilterButton<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
');
				}
			})
			$('#submitFilterButton<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
').click(function() {
				$('#submitFilter<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
').val(1);
			});

			if ($("table .datepicker").length > 0) {
				$("table .datepicker").datepicker({
					prevText: '',
					nextText: '',
					altFormat: 'yy-mm-dd'
				});
			}
			$('table.table.<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
').on('click', '#checkSwitchAll', function(){
                if($(this).prop('checked')){
                    checkDelBoxes($('#form-<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
').get(0), '<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Box[]', true);
                }
                else{
                    checkDelBoxes($('#form-<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
').get(0), '<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Box[]', false);
                }
            });
	            
		});
	</script>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['simple_header']->value) {?>
	<div class="leadin">
		
	<?php if (isset($_smarty_tpl->tpl_vars['delete_customer']->value)&&$_smarty_tpl->tpl_vars['delete_customer']->value) {?>
		<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['REQUEST_URI']->value, ENT_QUOTES, 'UTF-8', true);?>
" method="post">
			<div class="alert alert-warning">
				<h4><?php echo smartyTranslate(array('s'=>'How do you want to delete the selected customers?'),$_smarty_tpl);?>
</h4>
				<p><?php echo smartyTranslate(array('s'=>'There are two ways of deleting a customer. Please choose your preferred method.'),$_smarty_tpl);?>
</p>
				<br>
				<ul class="listForm list-unstyled">
					<li>
						<label for="deleteMode_deleted" class="control-label">
							<input type="radio" name="deleteMode" value="deleted" id="deleteMode_deleted" />
							<?php echo smartyTranslate(array('s'=>'I do not want my customer(s) to register again with the same email address. All selected customer(s) will be removed from this list but their corresponding data will be kept in the database.'),$_smarty_tpl);?>

						</label>
					</li>
				</ul>
				<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['POST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
					<?php if (is_array($_smarty_tpl->tpl_vars['value']->value)) {?>
						<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['value']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
							<input type="hidden" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true);?>
[]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['val']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
						<?php } ?>
					<?php } else { ?>
						<input type="hidden" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
" />
					<?php }?>
				<?php } ?>
				<input type="submit" class="btn btn-default" value="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
" />
			</div>
		</form>
		<script>
			$(document).ready(function() {
				$('table[name=\'list_table\']').hide();
			});
		</script>
	<?php }?>


	</div>
<?php }?>


<script type="text/javascript">
    var countriesList = <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['countriesList']->value);?>
;
    var gendersList = <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['gendersList']->value);?>
;
    var customerKeyAccountOptions = <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['customerKeyAccountOptions']->value);?>
;
</script>
<?php if ($_smarty_tpl->tpl_vars['submit_form_ajax']->value) {?>
	<script type="text/javascript">
		$('#customer', window.parent.document).val('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['new_customer']->value->email, ENT_QUOTES, 'UTF-8', true);?>
');
		parent.setupCustomer(<?php echo intval($_smarty_tpl->tpl_vars['new_customer']->value->id);?>
);
		parent.$.fancybox.close();
	</script>
<?php }?>


<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayAdminListBefore'),$_smarty_tpl);?>


<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
ListBefore<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php } elseif (isset($_GET['controller'])) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
ListBefore<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php }?>

<div class="alert alert-warning" id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
-empty-filters-alert" style="display:none;"><?php echo smartyTranslate(array('s'=>'Please fill at least one field to perform a search in this list.'),$_smarty_tpl);?>
</div>
<?php if (isset($_smarty_tpl->tpl_vars['sql']->value)&&$_smarty_tpl->tpl_vars['sql']->value) {?>
	<form id="sql_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminRequestSql'), ENT_QUOTES, 'UTF-8', true);?>
&amp;addrequest_sql" method="post" class="hide">
		<input type="hidden" id="sql_query_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" name="sql" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['sql']->value, ENT_QUOTES, 'UTF-8', true);?>
"/>
		<input type="hidden" id="sql_name_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" name="name" value=""/>
	</form>
<?php }?>


	<form method="post" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="form-horizontal clearfix" id="form-<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
">


<?php if (!$_smarty_tpl->tpl_vars['simple_header']->value) {?>
	<input type="hidden" id="submitFilter<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
" name="submitFilter<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
" value="0"/>
	<input type="hidden" name="page" value="<?php echo intval($_smarty_tpl->tpl_vars['page']->value);?>
"/>
	<input type="hidden" name="selected_pagination" value="<?php echo intval($_smarty_tpl->tpl_vars['selected_pagination']->value);?>
"/>
	
	<div class="panel col-lg-12">
		<div class="panel-heading">
			<?php if (isset($_smarty_tpl->tpl_vars['icon']->value)) {?><i class="<?php echo $_smarty_tpl->tpl_vars['icon']->value;?>
"></i> <?php }?><?php if (is_array($_smarty_tpl->tpl_vars['title']->value)) {?><?php echo end($_smarty_tpl->tpl_vars['title']->value);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['toolbar_btn']->value)&&count($_smarty_tpl->tpl_vars['toolbar_btn']->value)>0) {?>
				<span class="badge"><?php echo $_smarty_tpl->tpl_vars['list_total']->value;?>
</span>
				<span class="panel-heading-action">
				<?php  $_smarty_tpl->tpl_vars['btn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['btn']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['toolbar_btn']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['btn']->key => $_smarty_tpl->tpl_vars['btn']->value) {
$_smarty_tpl->tpl_vars['btn']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['btn']->key;
?>
					<?php if ($_smarty_tpl->tpl_vars['k']->value!='modules-list'&&$_smarty_tpl->tpl_vars['k']->value!='back') {?>
						<a id="desc-<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
-<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['imgclass'])) {?><?php echo $_smarty_tpl->tpl_vars['btn']->value['imgclass'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
<?php }?>" class="list-toolbar-btn<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['target'])&&$_smarty_tpl->tpl_vars['btn']->value['target']) {?> _blank<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['href'])) {?> href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['btn']->value['href'], ENT_QUOTES, 'UTF-8', true);?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['btn']->value['js'])&&$_smarty_tpl->tpl_vars['btn']->value['js']) {?> onclick="<?php echo $_smarty_tpl->tpl_vars['btn']->value['js'];?>
"<?php }?>>
							<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>$_smarty_tpl->tpl_vars['btn']->value['desc']),$_smarty_tpl);?>
" data-html="true" data-placement="top">
								<i class="process-icon-<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['imgclass'])) {?><?php echo $_smarty_tpl->tpl_vars['btn']->value['imgclass'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['btn']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['btn']->value['class'];?>
<?php }?>"></i>
							</span>
						</a>
					<?php }?>
				<?php } ?>
					<a class="list-toolbar-btn" href="javascript:location.reload();">
						<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'Refresh list'),$_smarty_tpl);?>
" data-html="true" data-placement="top">
							<i class="process-icon-refresh"></i>
						</span>
					</a>
				<?php if (isset($_smarty_tpl->tpl_vars['sql']->value)&&$_smarty_tpl->tpl_vars['sql']->value) {?>
					<?php if (isset($_smarty_tpl->tpl_vars['sql_manager'])) {$_smarty_tpl->tpl_vars['sql_manager'] = clone $_smarty_tpl->tpl_vars['sql_manager'];
$_smarty_tpl->tpl_vars['sql_manager']->value = Profile::getProfileAccess(Context::getContext()->employee->id_profile,Tab::getIdFromClassName('AdminRequestSql')); $_smarty_tpl->tpl_vars['sql_manager']->nocache = null; $_smarty_tpl->tpl_vars['sql_manager']->scope = 0;
} else $_smarty_tpl->tpl_vars['sql_manager'] = new Smarty_variable(Profile::getProfileAccess(Context::getContext()->employee->id_profile,Tab::getIdFromClassName('AdminRequestSql')), null, 0);?>

					<?php if ($_smarty_tpl->tpl_vars['sql_manager']->value['view']==1) {?>
						<a class="list-toolbar-btn" href="javascript:void(0);" onclick="$('.leadin').first().append('<div class=\'alert alert-info\'>' + $('#sql_query_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
').val() + '</div>'); $(this).attr('onclick', '');">
							<span class="label-tooltip" data-toggle="tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'Show SQL query'),$_smarty_tpl);?>
" data-html="true" data-placement="top" >
								<i class="process-icon-terminal"></i>
							</span>
						</a>
						<a class="list-toolbar-btn" href="javascript:void(0);" onclick="$('#sql_name_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
').val(createSqlQueryName()); $('#sql_query_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
').val($('#sql_query_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
').val().replace(/\s+limit\s+[0-9,\s]+$/ig, '').trim()); $('#sql_form_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list_id']->value, ENT_QUOTES, 'UTF-8', true);?>
').submit();">
							<span class="label-tooltip" data-toggle="tooltip" data-original-title="<?php echo smartyTranslate(array('s'=>'Export to SQL Manager'),$_smarty_tpl);?>
" data-html="true" data-placement="top" >
								<i class="process-icon-database"></i>
							</span>
						</a>
					<?php }?>
				<?php }?>
				</span>
			<?php }?>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['show_toolbar']->value) {?>
			<script type="text/javascript">
				//<![CDATA[
				var submited = false;
				$(function() {
					//get reference on save link
					btn_save = $('i[class~="process-icon-save"]').parent();
					//get reference on form submit button
					btn_submit = $('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form_submit_btn');
					if (btn_save.length > 0 && btn_submit.length > 0) {
						//get reference on save and stay link
						btn_save_and_stay = $('i[class~="process-icon-save-and-stay"]').parent();
						//get reference on current save link label
						lbl_save = $('#desc-<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
-save div');
						//override save link label with submit button value
						if (btn_submit.val().length > 0) {
							lbl_save.html(btn_submit.attr("value"));
						}
						if (btn_save_and_stay.length > 0) {
							//get reference on current save link label
							lbl_save_and_stay = $('#desc-<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
-save-and-stay div');
							//override save and stay link label with submit button value
							if (btn_submit.val().length > 0 && lbl_save_and_stay && !lbl_save_and_stay.hasClass('locked')) {
								lbl_save_and_stay.html(btn_submit.val() + " <?php echo smartyTranslate(array('s'=>'and stay'),$_smarty_tpl);?>
 ");
							}
						}
						//hide standard submit button
						btn_submit.hide();
						//bind enter key press to validate form
						$('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form').keypress(function (e) {
							if (e.which == 13 && e.target.localName != 'textarea') {
								$('#desc-<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
-save').click();
							}
						});
						//submit the form
						
							btn_save.click(function() {
								// Avoid double click
								if (submited) {
									return false;
								}
								submited = true;
								//add hidden input to emulate submit button click when posting the form -> field name posted
								btn_submit.before('<input type="hidden" name="'+btn_submit.attr("name")+'" value="1" />');
								$('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form').submit();
								return false;
							});
							if (btn_save_and_stay) {
								btn_save_and_stay.click(function() {
									//add hidden input to emulate submit button click when posting the form -> field name posted
									btn_submit.before('<input type="hidden" name="'+btn_submit.attr("name")+'AndStay" value="1" />');
									$('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form').submit();
									return false;
								});
							}
						
					}
				});
				//]]>
			</script>
		<?php }?>
<?php } elseif ($_smarty_tpl->tpl_vars['simple_header']->value) {?>
	<div class="panel col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['title']->value)) {?><h3><?php if (isset($_smarty_tpl->tpl_vars['icon']->value)) {?><i class="<?php echo $_smarty_tpl->tpl_vars['icon']->value;?>
"></i> <?php }?><?php if (is_array($_smarty_tpl->tpl_vars['title']->value)) {?><?php echo end($_smarty_tpl->tpl_vars['title']->value);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?></h3><?php }?>
<?php }?>


	<?php if ($_smarty_tpl->tpl_vars['bulk_actions']->value&&$_smarty_tpl->tpl_vars['has_bulk_actions']->value) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['y'])) {$_smarty_tpl->tpl_vars['y'] = clone $_smarty_tpl->tpl_vars['y'];
$_smarty_tpl->tpl_vars['y']->value = 2; $_smarty_tpl->tpl_vars['y']->nocache = null; $_smarty_tpl->tpl_vars['y']->scope = 0;
} else $_smarty_tpl->tpl_vars['y'] = new Smarty_variable(2, null, 0);?>
	<?php } else { ?>
		<?php if (isset($_smarty_tpl->tpl_vars['y'])) {$_smarty_tpl->tpl_vars['y'] = clone $_smarty_tpl->tpl_vars['y'];
$_smarty_tpl->tpl_vars['y']->value = 1; $_smarty_tpl->tpl_vars['y']->nocache = null; $_smarty_tpl->tpl_vars['y']->scope = 0;
} else $_smarty_tpl->tpl_vars['y'] = new Smarty_variable(1, null, 0);?>
	<?php }?>
	<style>
	@media (max-width: 992px) {
		<?php  $_smarty_tpl->tpl_vars['param'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['param']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fields_display']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['params']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['param']->key => $_smarty_tpl->tpl_vars['param']->value) {
$_smarty_tpl->tpl_vars['param']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['params']['index']++;
?>
			.table-responsive-row td:nth-of-type(<?php echo smarty_function_math(array('equation'=>"x+y",'x'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['params']['index'],'y'=>$_smarty_tpl->tpl_vars['y']->value),$_smarty_tpl);?>
):before {
				content: "<?php echo $_smarty_tpl->tpl_vars['param']->value['title'];?>
";
			}
		<?php } ?>
	}
	</style>
    <?php  $_smarty_tpl->tpl_vars['params'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['params']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields_display']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['params']->key => $_smarty_tpl->tpl_vars['params']->value) {
$_smarty_tpl->tpl_vars['params']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['params']->key;
?>
        <?php if (($_smarty_tpl->tpl_vars['params']->value['type']=='select')&&isset($_smarty_tpl->tpl_vars['params']->value['multiple'])&&$_smarty_tpl->tpl_vars['params']->value['multiple']) {?>
        <div id="<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['params']->value['filter_key'],'!','');?>
MultySelectCont" ></div>
        <?php }?>
    <?php } ?>
	
<div class="row">
  <div class="col-md-2">
    <label><?php echo smartyTranslate(array('s'=>'Did not ordered'),$_smarty_tpl);?>
</label>
    <?php echo smarty_function_html_options(array('name'=>'customerFilter_did_not_ordered','options'=>$_smarty_tpl->tpl_vars['did_not_ordered_filter_options']->value,'selected'=>$_smarty_tpl->tpl_vars['did_not_ordered_selected']->value),$_smarty_tpl);?>

  </div>
</div>
<hr>

	<div class="table-responsive-row clearfix<?php if (isset($_smarty_tpl->tpl_vars['use_overflow']->value)&&$_smarty_tpl->tpl_vars['use_overflow']->value) {?> overflow-y<?php }?>">
		<table<?php if ($_smarty_tpl->tpl_vars['table_id']->value) {?> id="table-<?php echo $_smarty_tpl->tpl_vars['table_id']->value;?>
"<?php }?> class="table<?php if ($_smarty_tpl->tpl_vars['table_dnd']->value) {?> tableDnD<?php }?> <?php echo $_smarty_tpl->tpl_vars['table']->value;?>
" >
			<thead>
				<tr class="nodrag nodrop">
					<?php if ($_smarty_tpl->tpl_vars['bulk_actions']->value&&$_smarty_tpl->tpl_vars['has_bulk_actions']->value) {?>
						<th class="center fixed-width-xs"></th>
					<?php }?>
					<?php  $_smarty_tpl->tpl_vars['params'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['params']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields_display']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['params']->key => $_smarty_tpl->tpl_vars['params']->value) {
$_smarty_tpl->tpl_vars['params']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['params']->key;
?>
					<th class="<?php if (isset($_smarty_tpl->tpl_vars['params']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['params']->value['class'];?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['params']->value['align'])) {?> <?php echo $_smarty_tpl->tpl_vars['params']->value['align'];?>
<?php }?>">
						<span class="title_box<?php if (isset($_smarty_tpl->tpl_vars['order_by']->value)&&($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['order_by']->value)) {?> active<?php }?>">
							<?php if (isset($_smarty_tpl->tpl_vars['params']->value['hint'])) {?>
								<span class="label-tooltip" data-toggle="tooltip"
									title="
										<?php if (is_array($_smarty_tpl->tpl_vars['params']->value['hint'])) {?>
											<?php  $_smarty_tpl->tpl_vars['hint'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hint']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['params']->value['hint']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hint']->key => $_smarty_tpl->tpl_vars['hint']->value) {
$_smarty_tpl->tpl_vars['hint']->_loop = true;
?>
												<?php if (is_array($_smarty_tpl->tpl_vars['hint']->value)) {?>
													<?php echo $_smarty_tpl->tpl_vars['hint']->value['text'];?>

												<?php } else { ?>
													<?php echo $_smarty_tpl->tpl_vars['hint']->value;?>

												<?php }?>
											<?php } ?>
										<?php } else { ?>
											<?php echo $_smarty_tpl->tpl_vars['params']->value['hint'];?>

										<?php }?>
									">
									<?php echo $_smarty_tpl->tpl_vars['params']->value['title'];?>

								</span>
							<?php } else { ?>
								<?php echo $_smarty_tpl->tpl_vars['params']->value['title'];?>

							<?php }?>
							<?php if ((!isset($_smarty_tpl->tpl_vars['params']->value['orderby'])||$_smarty_tpl->tpl_vars['params']->value['orderby'])&&!$_smarty_tpl->tpl_vars['simple_header']->value&&$_smarty_tpl->tpl_vars['show_filters']->value) {?>
								<a class="sorting-link<?php if (isset($_smarty_tpl->tpl_vars['order_by']->value)&&($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['order_by']->value)&&($_smarty_tpl->tpl_vars['order_way']->value=='DESC')) {?> active<?php }?>" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Orderby=<?php echo urlencode($_smarty_tpl->tpl_vars['key']->value);?>
&amp;<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Orderway=desc&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php if (isset($_GET[$_smarty_tpl->tpl_vars['identifier']->value])) {?>&amp;<?php echo $_smarty_tpl->tpl_vars['identifier']->value;?>
=<?php echo intval($_GET[$_smarty_tpl->tpl_vars['identifier']->value]);?>
<?php }?>">
									<i class="icon-caret-down"></i>
								</a>
								<a class="sorting-link<?php if (isset($_smarty_tpl->tpl_vars['order_by']->value)&&($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['order_by']->value)&&($_smarty_tpl->tpl_vars['order_way']->value=='ASC')) {?> active<?php }?>" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currentIndex']->value, ENT_QUOTES, 'UTF-8', true);?>
&amp;<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Orderby=<?php echo urlencode($_smarty_tpl->tpl_vars['key']->value);?>
&amp;<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Orderway=asc&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php if (isset($_GET[$_smarty_tpl->tpl_vars['identifier']->value])) {?>&amp;<?php echo $_smarty_tpl->tpl_vars['identifier']->value;?>
=<?php echo intval($_GET[$_smarty_tpl->tpl_vars['identifier']->value]);?>
<?php }?>">
									<i class="icon-caret-up"></i>
								</a>
							<?php }?>
						</span>
					</th>
					<?php } ?>
					<?php if ($_smarty_tpl->tpl_vars['shop_link_type']->value) {?>
						<th>
							<span class="title_box">
							<?php if ($_smarty_tpl->tpl_vars['shop_link_type']->value=='shop') {?>
								<?php echo smartyTranslate(array('s'=>'Shop'),$_smarty_tpl);?>

							<?php } else { ?>
								<?php echo smartyTranslate(array('s'=>'Shop group'),$_smarty_tpl);?>

							<?php }?>
							</span>
						</th>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['has_actions']->value||$_smarty_tpl->tpl_vars['show_filters']->value) {?>
						<th><?php if (!$_smarty_tpl->tpl_vars['simple_header']->value) {?><?php }?></th>
					<?php }?>
				</tr>
			<?php if (!$_smarty_tpl->tpl_vars['simple_header']->value&&$_smarty_tpl->tpl_vars['show_filters']->value) {?>
				<tr class="nodrag nodrop filter <?php if ($_smarty_tpl->tpl_vars['row_hover']->value) {?>row_hover<?php }?>">
					<?php if ($_smarty_tpl->tpl_vars['has_bulk_actions']->value) {?>
						<th class="text-center">
							<input type="checkbox" id="checkSwitchAll">
						</th>
					<?php }?>
					
					<?php  $_smarty_tpl->tpl_vars['params'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['params']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields_display']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['params']->key => $_smarty_tpl->tpl_vars['params']->value) {
$_smarty_tpl->tpl_vars['params']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['params']->key;
?>
						<th <?php if (isset($_smarty_tpl->tpl_vars['params']->value['align'])) {?> class="<?php echo $_smarty_tpl->tpl_vars['params']->value['align'];?>
" <?php }?>>
							<?php if (isset($_smarty_tpl->tpl_vars['params']->value['search'])&&!$_smarty_tpl->tpl_vars['params']->value['search']) {?>
								--
							<?php } else { ?>
								<?php if ($_smarty_tpl->tpl_vars['params']->value['type']=='bool') {?>
									<select class="filter fixed-width-sm center" name="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Filter_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
										<option value="">-</option>
										<option value="1" <?php if ($_smarty_tpl->tpl_vars['params']->value['value']==1) {?> selected="selected" <?php }?>><?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
</option>
										<option value="0" <?php if ($_smarty_tpl->tpl_vars['params']->value['value']==0&&$_smarty_tpl->tpl_vars['params']->value['value']!='') {?> selected="selected" <?php }?>><?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
</option>
									</select>
								<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['type']=='date'||$_smarty_tpl->tpl_vars['params']->value['type']=='datetime') {?>
									<div class="date_range row">
 										<div class="input-group fixed-width-md center">
											<input type="text" class="filter datepicker date-input form-control" id="local_<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_0" name="local_<?php echo $_smarty_tpl->tpl_vars['params']->value['name_date'];?>
[0]"  placeholder="<?php echo smartyTranslate(array('s'=>'From'),$_smarty_tpl);?>
" />
											<input type="hidden" id="<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_0" name="<?php echo $_smarty_tpl->tpl_vars['params']->value['name_date'];?>
[0]" value="<?php if (isset($_smarty_tpl->tpl_vars['params']->value['value'][0])) {?><?php echo $_smarty_tpl->tpl_vars['params']->value['value'][0];?>
<?php }?>">
											<span class="input-group-addon">
												<i class="icon-calendar"></i>
											</span>
										</div>
 										<div class="input-group fixed-width-md center">
											<input type="text" class="filter datepicker date-input form-control" id="local_<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_1" name="local_<?php echo $_smarty_tpl->tpl_vars['params']->value['name_date'];?>
[1]"  placeholder="<?php echo smartyTranslate(array('s'=>'To'),$_smarty_tpl);?>
" />
											<input type="hidden" id="<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_1" name="<?php echo $_smarty_tpl->tpl_vars['params']->value['name_date'];?>
[1]" value="<?php if (isset($_smarty_tpl->tpl_vars['params']->value['value'][1])) {?><?php echo $_smarty_tpl->tpl_vars['params']->value['value'][1];?>
<?php }?>">
											<span class="input-group-addon">
												<i class="icon-calendar"></i>
											</span>
										</div>
										<script>
											$(function() {
												var dateStart = parseDate($("#<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_0").val());
												var dateEnd = parseDate($("#<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_1").val());
												$("#local_<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_0").datepicker("option", "altField", "#<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_0");
												$("#local_<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_1").datepicker("option", "altField", "#<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_1");
												if (dateStart !== null){
													$("#local_<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_0").datepicker("setDate", dateStart);
												}
												if (dateEnd !== null){
													$("#local_<?php echo $_smarty_tpl->tpl_vars['params']->value['id_date'];?>
_1").datepicker("setDate", dateEnd);
												}
											});
										</script>
									</div>
								<?php } elseif ($_smarty_tpl->tpl_vars['params']->value['type']=='select') {?>
									<?php if (isset($_smarty_tpl->tpl_vars['params']->value['filter_key'])) {?>
										<?php if (isset($_smarty_tpl->tpl_vars['params']->value['multiple'])&&$_smarty_tpl->tpl_vars['params']->value['multiple']) {?>
										<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Filter_<?php echo $_smarty_tpl->tpl_vars['params']->value['filter_key'];?>
[]" value="">
										<select class="filter center" id="<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['params']->value['filter_key'],'!','');?>
MultySelect" name="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Filter_<?php echo $_smarty_tpl->tpl_vars['params']->value['filter_key'];?>
[]" multiple="multiple"  
											<?php if (isset($_smarty_tpl->tpl_vars['params']->value['width'])) {?> style="width:<?php echo $_smarty_tpl->tpl_vars['params']->value['width'];?>
px"<?php }?> >
											<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['params']->value['list'],'selected'=>$_smarty_tpl->tpl_vars['params']->value['value']),$_smarty_tpl);?>

										</select>
                                                                                <script type="text/javascript">
				                                                //<![CDATA[
                                                                                $("#<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['params']->value['filter_key'],'!','');?>
MultySelect").multipleSelect({
                                                                                    multiple: true,
                                                                                    <?php if (isset($_smarty_tpl->tpl_vars['params']->value['multipleWidth'])) {?>
                                                                                    multipleWidth: <?php echo $_smarty_tpl->tpl_vars['params']->value['multipleWidth'];?>
,
                                                                                    onOpen: function(){
                                                                                    	$('#<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['params']->value['filter_key'],'!','');?>
MultySelectCont .ms-drop').width('<?php echo $_smarty_tpl->tpl_vars['params']->value['multipleWidth']+30;?>
px');
                                                                                    },
                                                                                    <?php }?>
                                                                                    dropWidth:250,
                                                                                    container: '#<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['params']->value['filter_key'],'!','');?>
MultySelectCont',
                                                                                });
                                                                                //]]>
                                                                                </script>
										<?php } else { ?>
										<select class="filter center" name="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Filter_<?php echo $_smarty_tpl->tpl_vars['params']->value['filter_key'];?>
" onchange="$('#submitFilterButton<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
').focus();$('#submitFilterButton<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
').click();"  
											<?php if (isset($_smarty_tpl->tpl_vars['params']->value['width'])) {?> style="width:<?php echo $_smarty_tpl->tpl_vars['params']->value['width'];?>
px"<?php }?> >
											
											<option value="" <?php if ($_smarty_tpl->tpl_vars['params']->value['value']=='') {?> selected="selected" <?php }?>>-</option>
											<?php if (isset($_smarty_tpl->tpl_vars['params']->value['list'])&&is_array($_smarty_tpl->tpl_vars['params']->value['list'])) {?>
												<?php  $_smarty_tpl->tpl_vars['option_display'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option_display']->_loop = false;
 $_smarty_tpl->tpl_vars['option_value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['params']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option_display']->key => $_smarty_tpl->tpl_vars['option_display']->value) {
$_smarty_tpl->tpl_vars['option_display']->_loop = true;
 $_smarty_tpl->tpl_vars['option_value']->value = $_smarty_tpl->tpl_vars['option_display']->key;
?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['option_value']->value;?>
" <?php if ((string)$_smarty_tpl->tpl_vars['option_display']->value===(string)$_smarty_tpl->tpl_vars['params']->value['value']||(string)$_smarty_tpl->tpl_vars['option_value']->value===(string)$_smarty_tpl->tpl_vars['params']->value['value']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['option_display']->value;?>
</option>
												<?php } ?>
											<?php }?>
										</select>
										<?php }?>
									<?php }?>
								<?php } else { ?>
									<input type="text" class="filter" name="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
Filter_<?php if (isset($_smarty_tpl->tpl_vars['params']->value['filter_key'])) {?><?php echo $_smarty_tpl->tpl_vars['params']->value['filter_key'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
<?php }?>" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if (isset($_smarty_tpl->tpl_vars['params']->value['width'])&&$_smarty_tpl->tpl_vars['params']->value['width']!='auto') {?> style="width:<?php echo $_smarty_tpl->tpl_vars['params']->value['width'];?>
px"<?php }?> />
								<?php }?>
							<?php }?>
						</th>
					<?php } ?>

					<?php if ($_smarty_tpl->tpl_vars['shop_link_type']->value) {?>
						<th>--</th>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['has_actions']->value||$_smarty_tpl->tpl_vars['show_filters']->value) {?>
						<th class="actions">
							<?php if ($_smarty_tpl->tpl_vars['show_filters']->value) {?>
							<span class="pull-right">
								
								<button type="submit" id="submitFilterButton<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
" name="submitFilter" class="btn btn-default" data-list-id="<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
">
									<i class="icon-search"></i> <?php echo smartyTranslate(array('s'=>'Search'),$_smarty_tpl);?>

								</button>
								<?php if ($_smarty_tpl->tpl_vars['filters_has_value']->value) {?>
									<button type="submit" name="submitReset<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
" class="btn btn-warning">
										<i class="icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Reset'),$_smarty_tpl);?>

									</button>
								<?php }?>
							</span>
							<?php }?>
						</th>
					<?php }?>
				</tr>
			<?php }?>
			</thead>
		<script type="text/javascript">
			$('.sorting-link').on('click',function(e){
				e.preventDefault();
				$(this).closest("form").attr('action', $(this).attr('href'));
				//$('#submitFilter'+$(this).data("list-id")).val($(this).data("page")).closest("form").submit();
				//$('#submitFilter<?php echo $_smarty_tpl->tpl_vars['list_id']->value;?>
').val($(this).data("page")).closest("form").submit();
				$(this).closest("form").submit();
			});
		</script>
			<?php }} ?>
