<?php /* Smarty version Smarty-3.1.19, created on 2019-08-19 08:54:32
         compiled from "/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tiny_init.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10623224925d5a47a8cfd999-28873351%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4b75ea1fdf90f0977ddd861f91d36e63324c6fd' => 
    array (
      0 => '/home/koehlert/public_html/modules/newsletterpro/views/templates/admin/tiny_init.tpl',
      1 => 1564052190,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10623224925d5a47a8cfd999-28873351',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'iso_tiny_mce' => 0,
    'css_mails_path' => 0,
    'ad' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5d5a47a8d5d758_13839662',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d5a47a8d5d758_13839662')) {function content_5d5a47a8d5d758_13839662($_smarty_tpl) {?>

<script type="text/javascript">

	var iso     = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['iso_tiny_mce']->value, ENT_QUOTES, 'UTF-8', true);?>
';
	var pathCSS = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['css_mails_path']->value, ENT_QUOTES, 'UTF-8', true);?>
';
	var ad      = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ad']->value, ENT_QUOTES, 'UTF-8', true);?>
';

	function isTinyHigherVersion() 
	{
		if (typeof tinyMCE === 'undefined')
			return true;
		else if (tinyMCE.majorVersion >= 4)
			return true;
		return false;
	};

	jQuery(document).ready(function() {
		var idCurrentLang = NewsletterPro.dataStorage.get('id_current_lang');
		var box = NewsletterPro,
			attachmentsWindow,
			dataModelAttachments,
			dataSourceAttachments,
			dataGridAttachments,
			newsletterTemplate= box.modules.createTemplate.newsletterTemplate;

		box.dataStorage.on('change', 'configuration.NEWSLETTER_TEMPLATE', function(value){
			if (typeof dataSourceAttachments !== 'undefined')
			{
				dataSourceAttachments.transport.read.data = {
					'template_name': box.dataStorage.get('configuration.NEWSLETTER_TEMPLATE')
				};
			}
		});

		function overrideOther(ed)
		{
			if (!confirm('<?php echo smartyTranslate(array('s'=>'Are you sure you want to override the other languages?','mod'=>'newsletterpro'),$_smarty_tpl);?>
'))
				return false;

			var body = $(ed.getBody()),
				lang = ed.lang(),
				box = NewsletterPro,
				newsletterTemplate = box.modules.createTemplate.newsletterTemplate;

			var headerVal = newsletterTemplate.getHeaderByIdLang(lang).val(),
				footerVal = newsletterTemplate.getFooterByIdLang(lang).val();

			newsletterTemplate.parseTiny(function(id, idLang, editor){
				if (Number(idLang) != Number(lang))
				{
					var products = $(editor.dom.select('.clear-newsletter-template-products')),
						bodyClone = body.clone(),
						bodyProducts = bodyClone.find('.clear-newsletter-template-products'),
						content,
						newHeader = newsletterTemplate.getHeaderByIdLang(idLang),
						newFooter = newsletterTemplate.getFooterByIdLang(idLang);

					newHeader.val(headerVal);
					newFooter.val(footerVal);

					if (products.length && bodyProducts.length)
					{
						bodyProducts.replaceWith(products);
					}

					content = bodyClone.get(0).outerHTML;
					editor.setContent(content);
				}
			});
		}

		function insertProducts(ed, global) 
		{
			global = typeof global !== 'undefined' ? global : false;

			var lang = ed.lang(),
				node = ed.selection.getNode(),
				nodeIndex = $(node).parents().index(),
				productsClear = '\
				<table class="clear-newsletter-template-products" border="0" cellspacing="0" cellpadding="0" style="margin: 0; padding: 0; border-collapse: collapse;">\
					<tbody>\
						<tr>\
							<td class="newsletter-products-container">\
							</td>\
						</tr>\
					</tbody>\
				</table>\
			';

			if (global)
			{
				newsletterTemplate.parseTiny(function(id, idLang, editor){

					if (box.components.Product.view.hasOwnProperty(idLang))
					{
						var html,
							content = $(productsClear),
							view = box.components.Product.view[idLang].clone(),
							edit = view.find('.np-edit-product-menu');

						edit.remove();

						if (view.length)
						{
							view.find('td[class^="np-newsletter-column-product-id-"]:last-child').children().css('margin-right', '0');

							html = view.html();
							content.find('.newsletter-products-container').html(html);
							content = content.get(0).outerHTML;

							if (false/*do not set under caret*/ && (Number(lang) == Number(idLang)))
							{
								editor.selection.setContent(content);
							}
							else
							{
								if(Number(lang) != Number(idLang)){ /* ff fix */
									$('#newsletter_content_'+idLang).show();
									$(editor.dom.select('.newsletter-pro-content')).show();
								}
								var newNode = editor.dom.select('td.np-products-target');
								
								if (newNode.length) {
									var span = editor.dom.select('.np-products-template-info-remove');
									if (span.length) {
										$(span).empty();
									}
								} else {
									newNode = editor.dom.select('.newsletter-pro-content td td:eq('+nodeIndex+')');
								}

								editor.selection.setCursorLocation($(newNode).get(0), 0);
								editor.selection.setContent(content);
								if(Number(lang) != Number(idLang)){ /* ff fix */
									$('#newsletter_content_'+idLang).hide();
									$(editor.dom.select('.newsletter-pro-content')).hide();
								}

							}
						}

					}
				});
			}
			else
			{
				if (box.components.Product.view.hasOwnProperty(lang))
				{
					var html,
						content = $(productsClear),
						view = box.components.Product.view[lang].clone(),
						edit = view.find('.np-edit-product-menu');

					edit.remove();

					if (view.length)
					{
						view.find('td[class^="np-newsletter-column-product-id-"]:last-child').children().css('margin-right', '0');

						html = view.html();
						content.find('.newsletter-products-container').html(html);
						content = content.get(0).outerHTML

						ed.selection.setContent(content);
					}
				}
			}
		}

		function refreshStyleLinks(ed, contentCSS)
		{
			var oldContentCSS = ed.settings.content_css,
				oldContentCSSArray = [],
				hasContentCSS = (typeof contentCSS !== 'undefined'),
				newContentCSS,
				newContentCSSArray = [],
				getHref = function(href)
				{
				// var href = link.attr('href'),
					 var sign,
						uidStr,
						regex;

					sign = (/\?/.test(href) ? '&' : '?' );

					uidStr = 'uid=';

					var guid = function(){ return uidStr + box.uniqueId(); };

					if (/(\?|&)uid=/.test(href))
					{
						href = href.replace(/(\?|&)uid=[A-Za-z0-9_-]+/, '$1' + guid());
					}
					else
						href = href + sign + guid();

					return href;
				};

			if (hasContentCSS)
			{
				if (isTinyHigherVersion())
				{
					newContentCSS = contentCSS

					if (typeof contentCSS === 'object')
						newContentCSSArray = contentCSS;
					else if (/,/.test(contentCSS))
						newContentCSSArray = contentCSS.split(',');
					else
						newContentCSSArray = [contentCSS];

				}
				else if (typeof contentCSS === 'object')
				{
					newContentCSS = contentCSS.join(',');
					newContentCSSArray = contentCSS;
				}
				else
				{
					newContentCSS = contentCSS
					newContentCSSArray = [contentCSS];
				}

				ed.settings.content_css = newContentCSS;
			}
	
			if (typeof oldContentCSS === 'object')
				oldContentCSSArray = oldContentCSS;
			else if (/,/.test(oldContentCSS))
				oldContentCSSArray = oldContentCSSArray.split(',');
			else
				oldContentCSSArray = [oldContentCSS];

			$.each(getLinks(ed), function(i, link){
				link = $(link);

				var href = link.attr('href');

				if (newContentCSSArray.length)
				{
					for (var i = 0; i < oldContentCSSArray.length; i++)
					{
						var current = oldContentCSSArray[i].split('/uid=.*/')[0];

						if (href.indexOf(current) != -1) {
							link.remove();
						}
					}
				}
			});

			if (newContentCSSArray.length)
			{
				for (var i = 0; i < newContentCSSArray.length; i++) 
				{
					var href = newContentCSSArray[i];

					ed.dom.loadCSS(href);
				}
			}

			// this is only for refresh style
			if (!newContentCSSArray.length)
			{
				$.each(getLinks(ed), function(i, link){
					link = $(link);

					var href = getHref(link.attr('href'));

					ed.dom.loadCSS(href);

					setTimeout(function(){
						link.remove();
					}, 1000);

				});
			}
		}

		function getLinks(ed)
		{
			return $(ed.dom.select('link'));
		}

		function loadCSS(ed, link)
		{
			ed.dom.loadCSS(link);
		}

		function removeProducts(ed, global) 
		{
			global = typeof global !== 'undefined' ? global : false;

			if (global)
			{
				newsletterTemplate.parseTiny(function(id, idLang, editor){
					var select = $(editor.dom.select('.clear-newsletter-template-products'));
					select.remove();
				});
			}
			else
			{
				var select = $(ed.dom.select('.clear-newsletter-template-products'));
				select.remove();
			}
		}

		function openAttachments(ed)
		{
			if (typeof attachmentsWindow === 'undefined')
			{
				attachmentsWindow = new gkWindow({
					width: 800,
					height: 500,
					setScrollContent: 438,
					title: "<?php echo smartyTranslate(array('s'=>'Attachments','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
					show: function(win)
					{
						if (typeof dataSourceAttachments !== 'undefined')
						{
							dataSourceAttachments.sync();
						}
					},
					content: function(win)
					{
						var template = $('\
							<div class="form-group clearfix">\
								<form id="template-attachment-form" class="defaultForm" method="post" enctype="multipart/form-data">\
									<div class="form-inline">\
										<div class="form-group">\
											<label class="control-label"><span class="label-tooltip"><?php echo smartyTranslate(array('s'=>'File','mod'=>'newsletterpro'),$_smarty_tpl);?>
</span></label>\
										</div>\
										<div class="form-group">\
											<input type="file" class="form-control" name="template_attachment">\
										</div>\
										<div class="form-group pull-right">\
											<a id="btn-add-template-attachment" href="javascript:{}" class="btn btn-default"><i class="icon icon-plus-square"></i> <?php echo smartyTranslate(array('s'=>'Attach File','mod'=>'newsletterpro'),$_smarty_tpl);?>
</a>\
										</div>\
									</div>\
								</form>\
							</div>\
							<div class="form-group clearfix">\
								<table id="np-template-attachments" class="table table-bordered np-send-connection">\
									<thead>\
										<tr>\
											<th class="filename" data-template="filename">'+"<?php echo smartyTranslate(array('s'=>'File Name','mod'=>'newsletterpro'),$_smarty_tpl);?>
"+'</th>\
											<th class="actions" data-template="actions">'+"<?php echo smartyTranslate(array('s'=>'Actions','mod'=>'newsletterpro'),$_smarty_tpl);?>
"+'</th>\
										</tr>\
									</thead>\
								</table>\
							</div>\
							');

						dataModelAttachments = new gk.data.Model({
							'id': 'id_newsletter_pro_attachment'
						});

						dataSourceAttachments = new gk.data.DataSource({
							pageSize: 7,
							transport: {
								read: 
								{
									url: NewsletterPro.dataStorage.get('ajax_url')+'&submit=ajaxGetAttachments',
									dataType: 'json',
									data: {
										'template_name': box.dataStorage.get('configuration.NEWSLETTER_TEMPLATE')
									}
								},
							},
							schema: {
								model: dataModelAttachments
							},
							trySteps: 2,
							errors: {
								read: function(xhr, ajaxOptions, thrownError) 
								{
									dataSourceAttachments.syncStepAvailableAdd(3000, function(){
										dataSourceAttachments.sync();
									});
								}
							},
							done: function() 
							{

							}
						});

						dataGridAttachments = template.find('#np-template-attachments');

						dataGridAttachments.gkGrid({
							dataSource: dataSourceAttachments,
							checkable: false,
							selectable: false,
							currentPage: 1,
							pageable: true,
							template: {
								actions: function(item, value) 
								{
									var deleteAttachment = $('#delete-attachment').gkButton({
										name: 'delete',
										title: "<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
										className: 'attachment-delete pull-right',
										item: item,
										icon: '<i class="icon icon-trash-o"></i> '
									});

									deleteAttachment.on('click', function(){
										$.postAjax({
											'submit': 'ajaxDeleteAttachment', 
											id: item.data.id, 
											filename: item.data.filename
										}).done(function(response){

											if (!response.success)
												box.alertErrors(response.errors);

										}).always(function(){
											dataSourceAttachments.sync();
											box.modules.createTemplate.vars.templateDataSource.sync();
										});

									});

									return deleteAttachment;
								},
								filename: function(item, value)
								{
									return item.data.filename;
								}
							}
						});

						var form = template.find('#template-attachment-form'),
							addAttachment = template.find('#btn-add-template-attachment');

						addAttachment.on('click', function(){
							$.submitAjax({ 'submit': 'ajaxTemplateAttachFile',  name : 'ajaxTemplateAttachFile', form: form, data: {template_name: box.dataStorage.get('configuration.NEWSLETTER_TEMPLATE') }}).done(function(response) {
								if (!response.success)
									NewsletterPro.alertErrors(response.errors);
								else
								{
									dataSourceAttachments.sync();
									box.modules.createTemplate.vars.templateDataSource.sync();
								}
							});
						});

						return template;
					}
				});
			}

			attachmentsWindow.show();
		}

		function tinyNewsletterInit(ed, cfg) 
		{
			NewsletterPro.onObject.run('tinyNewsletter', ed);
			showTiny(cfg);
		}

		function tinyProductsInit(ed, cfg)
		{
			NewsletterPro.onObject.run('tinyProduct', ed);
			showTiny(cfg);
		}

		function tinyDefaultInit(ed, cfg)
		{
			if (ed.id.match(/subscription_template_\d+/))
				NewsletterPro.onObject.run('subscription_template', ed);

			if (ed.id.match(/s_subscribe_message_\d+/))
				NewsletterPro.onObject.run('s_subscribe_message', ed);

			if (ed.id.match(/s_email_subscribe_voucher_message_\d+/))
				NewsletterPro.onObject.run('s_email_subscribe_voucher_message', ed);

			if (ed.id.match(/s_email_subscribe_confirmation_message_\d+/))
				NewsletterPro.onObject.run('s_email_subscribe_confirmation_message', ed);

			showTiny(cfg);
		}

		function showTiny(cfg)
		{
			var digit = cfg.content_name.match(/\d+$/);
			if (!cfg.multilang)
				$('#' + cfg.content_name).show();
			else if (digit.length > 0 && parseInt(digit[0]) == parseInt(idCurrentLang) )
				$('#' + cfg.content_name ).show();	

		}

		function getContentCss(cfg)
		{
			var content_css = pathCSS+'global.css';

			if (typeof cfg.content_css !== 'undefined' && cfg.content_css)
				content_css = cfg.content_css;

			if (typeof content_css === 'string')
				return content_css;
			else
			{
				if (isTinyHigherVersion())
					return content_css;
				else
					return content_css.join(',');
			}
		}

		function getDefaultPlugins()
		{
			var plugins;
			if (isTinyHigherVersion())
				plugins = "colorpicker link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor";
			else
				plugins = "safari,pagebreak,style,table,advimage,advlink,inlinepopups,media,contextmenu,paste,fullscreen,xhtmlxtras,preview";
			return plugins;
		}

		function getNewsletterConfig(cfg)
		{
			var content_css = getContentCss(cfg);

			var newsletter_config =  {
				editor_selector: cfg.class_name,
			  	content_css : content_css,
				verify_html : false,
			  	cleanup : false,
                remove_trailing_brs: false,
				setup : function(ed) 
				{

					if (isTinyHigherVersion())
					{
						ed.addButton('insertProducts', {
				            text: "<?php echo smartyTranslate(array('s'=>'Insert Products (all)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				            icon: 'icon icon-plus-square',
				            onclick: function() {
				            	insertProducts(ed, true);
				            }
				        });

				        ed.addButton('removeProducts', {
							text : "<?php echo smartyTranslate(array('s'=>'Remove Products (all)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							icon: 'icon icon-eraser',
							onclick : function () {
								removeProducts(ed, true);
							}
						});


						ed.addButton('insertProductsCurrent', {
				            text: "<?php echo smartyTranslate(array('s'=>'Insert Products (lang)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				            icon: 'icon icon-plus-square',
				            onclick: function() {
				            	insertProducts(ed, false);
				            }
				        });

				        ed.addButton('removeCurrentProducts', {
							text : "<?php echo smartyTranslate(array('s'=>'Remove Products (lang)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							icon: 'icon icon-eraser',
							onclick : function () {
								removeProducts(ed, false);
							}
						});

						ed.addButton('overrideOther', {
				            text: "<?php echo smartyTranslate(array('s'=>'Make Default','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
				            icon: 'icon icon-pencil-square-o',
				            onclick: function() 
				            {
				            	overrideOther(ed);
				            }
				        });


						ed.addButton('attachments', {
							text : "<?php echo smartyTranslate(array('s'=>'Attachments','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							icon: 'icon icon-file',
							onclick : function () {
								openAttachments(ed);
							}
						});

						ed.on('init', function(e){
							tinyNewsletterInit(ed, cfg);
						});
					}
					else
					{
						var imgPath = NewsletterPro.dataStorage.get('module_img_path');

						ed.addButton('shopLogo', {
							title : "<?php echo smartyTranslate(array('s'=>'Insert shop logo','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'syringe_small.png',
							onclick : function () {
								ed.focus();
								ed.selection.setContent('{shop_logo}');
							}
						});

						ed.addButton('shopName', {
							title : "<?php echo smartyTranslate(array('s'=>'Insert shop name','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'syringe_small.png',
							onclick : function () {
								ed.focus();
								ed.selection.setContent('{shop_name}');
							}
						});

						ed.addButton('insertProducts', {
							title : "<?php echo smartyTranslate(array('s'=>'Insert Products (all)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'add.gif',
							onclick : function () {
								insertProducts(ed, true);
							}
						});

						ed.addButton('removeProducts', {
							title : "<?php echo smartyTranslate(array('s'=>'Remove Products (all)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'cancel.png',
							onclick : function () {
								removeProducts(ed, true);
							}
						});

						ed.addButton('insertProductsCurrent', {
				            title: "<?php echo smartyTranslate(array('s'=>'Insert Products (lang)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'add.gif',
				            onclick: function() {
				            	insertProducts(ed, false);
				            }
				        });

				        ed.addButton('removeCurrentProducts', {
							title : "<?php echo smartyTranslate(array('s'=>'Remove Products (lang)','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'cancel.png',
							onclick : function () {
								removeProducts(ed, false);
							}
						});


						ed.addButton('overrideOther', {
				            title: "<?php echo smartyTranslate(array('s'=>'Make Default','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'asterisk_orange.png',
				            onclick: function() 
				            {
				            	overrideOther(ed);
				            }
				        });

						ed.addButton('attachments', {
							title : "<?php echo smartyTranslate(array('s'=>'Attachments','mod'=>'newsletterpro'),$_smarty_tpl);?>
",
							image : imgPath + 'attach.png',
							onclick : function () {
								openAttachments(ed);
							}
						});

						ed.onInit.add(function(ed) {
							tinyNewsletterInit(ed, cfg);
						});

					}

					ed.refreshStyle = function(contentCSS)
					{
						refreshStyleLinks(this, contentCSS);
					};

					ed.lang = function()
					{
						 return Number(this.id.match(/\d+$/)[0])
					};
				}
			};

			if (isTinyHigherVersion()) 
			{
				newsletter_config['toolbar1'] = "code,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,|,blockquote,colorpicker,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,cleanup,|,media,image";
				newsletter_config['toolbar2'] = "insertProducts,removeProducts,attachments,overrideOther,insertProductsCurrent,removeCurrentProducts";
				newsletter_config['convert_urls'] = false;
				newsletter_config['statusbar'] = true;

				newsletter_config['relative_urls'] = false;
	    		newsletter_config['remove_script_host'] = false;
			} 
			else 
			{
				newsletter_config['width'] = "100%";
		        newsletter_config['height'] = "500";

			  	newsletter_config['toolbar'] = "undo redo | styleselect | bold italic | link image";
				newsletter_config['theme_advanced_buttons1'] = "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect";
				newsletter_config['theme_advanced_buttons2'] = "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor";
				newsletter_config['theme_advanced_buttons3'] = "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen";
				newsletter_config['theme_advanced_buttons4'] = "styleprops,|,cite,abbr,acronym,del,ins,attribs,pagebreak,shopLogo,shopName";
				newsletter_config['theme_advanced_buttons5'] = "insertProducts,removeProducts,attachments,overrideOther,insertProductsCurrent,removeCurrentProducts";
			}

			return newsletter_config;
		}

		function getDefaultConfig(cfg)
		{
			var content_css = getContentCss(cfg);

			var default_config = {
				editor_selector: cfg.class_name,
				content_css : content_css,
				forced_root_block: '', // don't add the <p> tag
				verify_html : false,
			  	cleanup : false,
			  	remove_trailing_brs: false,
				setup : function(ed) 
				{
					if (isTinyHigherVersion()) 
					{
						ed.on('init', function(e){
							if (cfg.config == 'product_config')
								tinyProductsInit(ed, cfg);
							else
								tinyDefaultInit(ed, cfg);
						});
					}
					else 
					{
						ed.onInit.add(function(ed) {
							if (cfg.config == 'product_config')
								tinyProductsInit(ed, cfg);
							else
								tinyDefaultInit(ed, cfg);
						});
					}

					ed.refreshStyle = function()
					{
						refreshStyleLinks(this);
					};
				}
			};

			if (isTinyHigherVersion()) 
			{
				default_config['convert_urls'] = false;
				default_config['statusbar'] = true;

				if (cfg.plugins !== 'undefined' && cfg.plugins != null)
				{
					
					var plugins = getDefaultPlugins();
					plugins += ' ' + cfg.plugins;
					default_config['plugins'] = plugins;
				}

			} 
			else 
			{
				default_config['width'] = "100%";
				default_config['height'] = "400";

				if (cfg.plugins !== 'undefined' && cfg.plugins != null)
				{
					var plugins = getDefaultPlugins();
					plugins += ',' + cfg.plugins;
					default_config['plugins'] = plugins;
				}

				default_config['theme_advanced_buttons1'] = "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect";
				default_config['theme_advanced_buttons2'] = "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor";
				default_config['theme_advanced_buttons3'] = "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen";
				default_config['theme_advanced_buttons4'] = "styleprops,|,cite,abbr,acronym,del,ins,attribs,pagebreak";
			}

			return default_config;
		}

		// Initialize TinyMce Instances
		$.each(NewsletterPro.dataStorage.get('tiny_init'), function(key, cfg){

			var config = getDefaultConfig(cfg);
			switch(cfg.config) 
			{
				case 'default_config':
				  config = getDefaultConfig(cfg);
				  break;
				case 'product_config':
				  config = getDefaultConfig(cfg);
				  break;
				case 'newsletter_config':
				  config = getNewsletterConfig(cfg);
				  break;
				default:
				  config = getDefaultConfig(cfg);
			}

			if (typeof cfg.init_callback !== 'undefined' && cfg.init_callback != null)
			{
				if (eval("typeof "+cfg.init_callback+" === 'function'"))
				{
					var callbackParent = eval(cfg.init_callback.replace(/\.\w+$/, ''));
					eval(cfg.init_callback).call(callbackParent, config, cfg);
				}
				else
					console.error('Tiny Mce init callback function '+cfg.init_callback+' does not exits.');
			}
			else
			{
				tinySetup( config );
			}
		});
	});
</script><?php }} ?>
