<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/campaign.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8951186695d5a47a8aa71f2-41451950%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5d7e856e51e6f5ff7251d76622349a07f3693ee' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tabs/campaign.tpl',
      1 => 1491367406,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8951186695d5a47a8aa71f2-41451950',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fix_document_write' => 0,
    'tab_id' => 0,
    'page_link' => 0,
    'CONFIGURATION' => 0,
    'CAMPAIGN_PARAMETERS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8b31750_24154940',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8b31750_24154940')) {function content_5d5a47a8b31750_24154940($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['fix_document_write']->value)&&$_smarty_tpl->tpl_vars['fix_document_write']->value==1) {?>
<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-campaign" style="display: none;">
<?php } else { ?>
<script type="text/javascript"> 
	if(window.location.hash == '#campaign') {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-campaign" style="display: block;">');
	} else {
		document.write('<div id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="tab-campaign" style="display: none;">');
	} 
</script>
<?php }?>
	<h4><?php echo smartyTranslate(array('s'=>'Campaign Statistics','mod'=>'newsletterpro'),$_smarty_tpl);?>
</h4>
	<div class="separation"></div>

	<div class="form-group clearfix">
		<form id="campaignForm" method="POST" action="<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['page_link']->value);?>
#campaign">
			<div class="form-group clearfix">
				<div class="col-sm-9 col-sm-offset-3">
					<div class="checkbox">
						<label for="set-universal-analytics" class="in-win control-label">
							<input class="smtp-checkbox" id="set-universal-analytics" type="checkbox"  onclick="NewsletterProControllers.SettingsController.universalAnaliytics( $(this) );" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['GOOGLE_UNIVERSAL_ANALYTICS_ACTIVE']==1) {?>checked="checked"<?php }?>>
							<?php echo smartyTranslate(array('s'=>'Universal Analytics','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>
					<p class="help-block" style="margin-top: 10px; width: 100%;">
						<?php echo smartyTranslate(array('s'=>'Connect to your Google Analytics account and check if the Universal Analytics is activated. If the answer is yes then check this option. Also if you use this option and you have installed the ganalytics module please check if it is compatible with the Google Universal Analytics.','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</p>
				</div>
			</div>

			<div class="form-group clearfix">
				<div class="col-sm-9 col-sm-offset-3">
					<div class="checkbox">
						<label for="set-campaign" class="in-win control-label">
							<input class="smtp-checkbox" id="set-campaign" type="checkbox"  onclick="NewsletterProControllers.SettingsController.activeCampaign( $(this) );" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==1) {?>checked="checked"<?php }?>>
							<?php echo smartyTranslate(array('s'=>'Activate Campaign','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</label>
					</div>
					<p class="help-block" style="margin-top: 10px; width: 100%;">
						<?php echo smartyTranslate(array('s'=>'This campaign works with Google Analytics, so the Google Analytics must to run in to your website.','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</p>
				</div>
			</div>
			
			<div class="form-group clearfix">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Source','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<input class="form-control fixed-width-xxl" type="text" id="utm_source" name="utm_source" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN']['UTM_SOURCE'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==0) {?>disabled="disabled"<?php }?>>
				</div>
			</div>
		
			<div class="form-group clearfix">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Medium','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<input class="form-control fixed-width-xxl" type="text" id="utm_medium" name="utm_medium" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN']['UTM_MEDIUM'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==0) {?>disabled="disabled"<?php }?>>
				</div>
			</div>

			<div class="form-group clearfix">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Campaign Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<input class="form-control fixed-width-xxl" type="text" id="utm_campaign" name="utm_campaign" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN']['UTM_CAMPAIGN'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==0) {?>disabled="disabled"<?php }?>>
				</div>
			</div>

			<div class="form-group clearfix">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Product Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<input class="form-control fixed-width-xxl" type="text" id="utm_content" name="utm_content" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN']['UTM_CONTENT'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==0) {?>disabled="disabled"<?php }?>>
				</div>
			</div>

			<div class="form-group clearfix">
				<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Parameters','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
				<div class="col-sm-9">
					<div class="form-group clearfix">
						<textarea class="form-control fixed-width-xxl gk-textarea" id="set-params" name="params" spellcheck="false" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==0) {?>disabled="disabled"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['CAMPAIGN_PARAMETERS']->value, ENT_QUOTES, 'UTF-8', true);?>
</textarea>
					</div>
						<div class="clearfix">
						<a id="set-params-default" href="javascript:{}" class="btn btn-default btn-margin pull-left <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==0) {?>disabled<?php }?>" onclick="NewsletterProControllers.SettingsController.makeDefaultParameteres();">
							<i class="icon icon-eraser"></i> <?php echo smartyTranslate(array('s'=>'Default','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</a>
						<a id="set-params-save" href="javascript:{}" class="btn btn-default btn-margin pull-left <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['CAMPAIGN_ACTIVE']==0) {?>disabled<?php }?>" onclick="NewsletterProControllers.SettingsController.saveCampaign();">
							<i class="icon icon-save"></i> <?php echo smartyTranslate(array('s'=>'Save','mod'=>'newsletterpro'),$_smarty_tpl);?>

						</a>
						<div class="form-group clearfix">
							<span id="set-params-save-message" style="display: none;"></span>
						</div>
						<div class="clearfix">
							<p class="help-block"><?php echo smartyTranslate(array('s'=>'One parameter per line','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
						</div>
					</div>
				</div>
			</div>
		</form>

		<div class="form-group clearfix">
			<div class="col-sm-9 col-sm-offset-3">
				<a id="campaign-is-running" href="javascript:{}" class="btn btn-default" onclick="NewsletterProControllers.SettingsController.checkIfCampaignIsRunning($(this));">
					<span class="btn-ajax-loader"></span>
					<i class="icon icon-check-circle"></i>
					<span><?php echo smartyTranslate(array('s'=>'Check Campaign','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
				</a>
			</div>
		</div>

		<div class="form-group clearfix">
			<div class="col-sm-9 col-sm-offset-3">
				<div class="checkbox">
					<label for="set-ganalytics" class="in-win control-label">
						<input class="smtp-checkbox" id="set-ganalytics" type="checkbox" onclick="NewsletterProControllers.SettingsController.activeGAnalytics( $(this) );" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['GOOGLE_ANALYTICS_ACTIVE']==1) {?>checked="checked"<?php }?>>
						<?php echo smartyTranslate(array('s'=>'Activate Google Analytics','mod'=>'newsletterpro'),$_smarty_tpl);?>

					</label>
				</div>
			</div>
		</div>

		<div class="form-group clearfix">
			<label class="control-label col-sm-3"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'Tracking ID','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>
			<div class="col-sm-9">
				<div class="clearfix">
					<input class="from-control fixed-width-xxl" id="ganalytics-id" type="text" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['CONFIGURATION']->value['GOOGLE_ANALYTICS_ID'], ENT_QUOTES, 'UTF-8', true);?>
" onblur="NewsletterProControllers.SettingsController.updateGAnalyticsID( $(this) );" <?php if ($_smarty_tpl->tpl_vars['CONFIGURATION']->value['GOOGLE_ANALYTICS_ACTIVE']==0) {?>disabled="disabled"<?php }?>>
				</div>
				<div class="form-group clearfix">
					<span id="ganalytics-id-message" style="display: none;"></span>
				</div>
				<div class="clearfix">
					<p class="help-block"><?php echo smartyTranslate(array('s'=>'Example: UA-1234567-1','mod'=>'newsletterpro'),$_smarty_tpl);?>
</p>
				</div>
			</div>
		</div>

	</div>

	<div class="alert alert-info">
		<?php echo smartyTranslate(array('s'=>'If you already configured your google analytics account with another module as "ganalytics", don\'t enable this option and follow the instructions.','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<br/>
		<span style="color: red;"><?php echo smartyTranslate(array('s'=>'It\'s important to have a little knowledge of php in order to proceed to the next step. I\'ts important to not generate errors in the script.','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span>
		<br/>
		<br/>
		1. <?php echo smartyTranslate(array('s'=>'Find the "ganalytics" module folder and open the "ganalytics.php".','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<br>
		2. <?php echo smartyTranslate(array('s'=>'If you find the line: ','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="color: #222; font-style: normal;"> ga(\'create\', ... </span> <?php echo smartyTranslate(array('s'=>'paste after that line, on a new row, the following code: ','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="color: #222; font-style: normal; font-weight: bold;"> '.(class_exists('NewsletterPro') ? NewsletterPro::getNewsletterCampaign() : '').' </span>
		<br>
		<br>
		<?php echo smartyTranslate(array('s'=>'If you find that line of code at the step 2, you don\'t need follow the next steps.','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<br>
		<br>
		3. <?php echo smartyTranslate(array('s'=>'Find the "ganalytics" module folder and open the "header.tpl".','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<br/>
		4. <?php echo smartyTranslate(array('s'=>'Find the line:','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="color: #222; font-style: normal;"> ga('create', ... </span>
		<br/>
		5. <?php echo smartyTranslate(array('s'=>'Find the line:','mod'=>'newsletterpro'),$_smarty_tpl);?>
 <span style="color: #222; font-style: normal;"> _gaq.push(['_setAccount', ... </span>
		<br/>
		6. <?php echo smartyTranslate(array('s'=>'Paste after this line the following code:','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<span style="color: #222; font-style: normal; font-weight: bold;"> {if isset($NEWSLETTER_CAMPAIGN)}{$NEWSLETTER_CAMPAIGN}{/if} </span>
		<br/>
		7. <?php echo smartyTranslate(array('s'=>'Save the file "header.tpl".','mod'=>'newsletterpro'),$_smarty_tpl);?>

		<br/>
		8. <?php echo smartyTranslate(array('s'=>'Make sure the position of module "Newsletter Pro" is lower than module "ganalytics" on the page "Modules  > Positions" tab "Pages header".','mod'=>'newsletterpro'),$_smarty_tpl);?>

	</div>

</div><?php }} ?>
