<?php 

class AdminCategoriesController extends AdminCategoriesControllerCore
{
	public function renderForm()
	{
		$this->initToolbar();
	
		/** @var Category $obj */
		$obj = $this->loadObject(true);
		$context = Context::getContext();
		$id_shop = $context->shop->id;
		$selected_categories = array((isset($obj->id_parent) && $obj->isParentCategoryAvailable($id_shop))? (int)$obj->id_parent : (int)Tools::getValue('id_parent', Category::getRootCategory()->id));
		$unidentified = new Group(Configuration::get('PS_UNIDENTIFIED_GROUP'));
		$guest = new Group(Configuration::get('PS_GUEST_GROUP'));
		$default = new Group(Configuration::get('PS_CUSTOMER_GROUP'));
	
		$unidentified_group_information = sprintf($this->l('%s - All people without a valid customer account.'), '<b>'.$unidentified->name[$this->context->language->id].'</b>');
		$guest_group_information = sprintf($this->l('%s - Customer who placed an order with the guest checkout.'), '<b>'.$guest->name[$this->context->language->id].'</b>');
		$default_group_information = sprintf($this->l('%s - All people who have created an account on this site.'), '<b>'.$default->name[$this->context->language->id].'</b>');
	
		if (!($obj = $this->loadObject(true))) {
			return;
		}
	
		$image = _PS_CAT_IMG_DIR_.$obj->id.'.jpg';
		$image_url = ImageManager::thumbnail($image, $this->table.'_'.(int)$obj->id.'.'.$this->imageType, 350,
				$this->imageType, true, true);
		$image_size = file_exists($image) ? filesize($image) / 1000 : false;
	
		$this->fields_form = array(
				'tinymce' => true,
				'legend' => array(
						'title' => $this->l('Category'),
						'icon' => 'icon-tags'
				),
				'input' => array(
						array(
								'type' => 'text',
								'label' => $this->l('Name'),
								'name' => 'name',
								'lang' => true,
								'required' => true,
								'class' => 'copy2friendlyUrl',
								'hint' => $this->l('Invalid characters:').' <>;=#{}',
						),
						array(
								'type' => 'switch',
								'label' => $this->l('Displayed'),
								'name' => 'active',
								'required' => false,
								'is_bool' => true,
								'values' => array(
										array(
												'id' => 'active_on',
												'value' => 1,
												'label' => $this->l('Enabled')
										),
										array(
												'id' => 'active_off',
												'value' => 0,
												'label' => $this->l('Disabled')
										)
								)
						),
						array(
								'type'  => 'categories',
								'label' => $this->l('Parent category'),
								'name'  => 'id_parent',
								'tree'  => array(
										'id'                  => 'categories-tree',
										'selected_categories' => $selected_categories,
										'disabled_categories' => (!Tools::isSubmit('add'.$this->table) && !Tools::isSubmit('submitAdd'.$this->table)) ? array($this->_category->id) : null,
										'root_category'       => $context->shop->getCategory()
								)
						),
						array(
								'type' => 'textarea',
								'label' => $this->l('Description'),
								'name' => 'description',
								'autoload_rte' => true,
								'lang' => true,
								'hint' => $this->l('Invalid characters:').' <>;=#{}'
						),
						array(
								'type' => 'file',
								'label' => $this->l('Image'),
								'name' => 'image',
								'display_image' => true,
								'image' => $image_url ? $image_url : false,
								'size' => $image_size,
								'delete_url' => self::$currentIndex.'&'.$this->identifier.'='.$this->_category->id.'&token='.$this->token.'&deleteImage=1',
								'hint' => $this->l('Upload a category logo from your computer.'),
						),
						array(
								'type' => 'textarea',
								'label' => $this->l('Meta title'),
								'name' => 'meta_title',
								'lang' => true,
								'rows' => 5,
								'cols' => 100,
								'hint' => $this->l('Forbidden characters:').' <>;=#{}'
						),
						array(
								'type' => 'textarea',
								'label' => $this->l('Meta description'),
								'name' => 'meta_description',
								'lang' => true,
								'rows' => 5,
								'cols' => 100,
								'hint' => $this->l('Forbidden characters:').' <>;=#{}'
						),
						array(
								'type' => 'tags',
								'label' => $this->l('Meta keywords'),
								'name' => 'meta_keywords',
								'lang' => true,
								'hint' => $this->l('To add "tags," click in the field, write something, and then press "Enter."').'&nbsp;'.$this->l('Forbidden characters:').' <>;=#{}'
						),
						array(
								'type' => 'text',
								'label' => $this->l('Friendly URL'),
								'name' => 'link_rewrite',
								'lang' => true,
								'required' => true,
								'hint' => $this->l('Only letters, numbers, underscore (_) and the minus (-) character are allowed.')
						),
                                                array(
                                                                'type' => 'select',
                                                                'label' => $this->l('Default sorting'),
                                                                'name' => 'def_product_sort',
                                                                'hint' => $this->l('Default product sort in category page for customer. Top sellert  works by stages:'
                                                                        . '1. Sort products so they go in following order: top_seller, new, top seller, new...'
                                                                        . '2. Products that are same variants separated from each other on distance configured in blocklayered module config.'),
                                                                'options' => array(
                                                                    'query' => array(
                                                                        array('id' => '', 'name'=>$this->l('Default')),
                                                                        array('id' => 'top_seller', 'name'=>$this->l('Top seller')),
                                                                        ),
                                                                        'id'=>'id',
                                                                        'name'=>'name'),
                                                ),
                                                array(
								'type' => 'text',
								'label' => $this->l('Number of pages sorted by position'),
								'name' => 'top_seller_sort_config',
                                                    'col'=>3,
								'required' => false,
								'hint' => $this->l('In case if value in this field greater then 0, then n first pages will be sorted by position and sort by top seller algorithm will start on next pages.')
						),
				),
				'submit' => array(
						'title' => $this->l('Save'),
						'name' => 'submitAdd'.$this->table.($this->_category->is_root_category && !Tools::isSubmit('add'.$this->table) && !Tools::isSubmit('add'.$this->table.'root') ? '': 'AndBackToParent')
				)
		);
		
		// show color related fields only for color category
		if ($obj->id_parent==Configuration::get('AJAX_FILTER_COLOR_CATEGORY_ID') || 
			(isset($selected_categories[0]) && $selected_categories[0]==Configuration::get('AJAX_FILTER_COLOR_CATEGORY_ID')))
		{
			$this->fields_form['input'][] = array(
					'type' => 'color',
					'label' => $this->l('Color'),
					'name' => 'color_code',
					'hint' => $this->l('Hex code of color with # in start'),
					'required' => true,);
				
			$this->fields_form['input'][] = array(
					'type' => 'select',
					'label' => $this->l('Mark color'),
					'name' => 'filter_mark_color',
					'hint' => $this->l('Color of check mark in filter'),
					'options' => array(
							'query' => array(
								array('id' => '', 'name'=>$this->l('Auto')),
								array('id' => 'white', 'name' => $this->l('White')),
							    array('id' => 'black', 'name' => $this->l('Black'))),
							'id'=>'id',
							'name'=>'name'
							
					),
					//'cast' => 'strval',
					//'required' => true,
					);
		}
		
		$this->fields_form['input'][] = array(
				'type' => 'group',
				'label' => $this->l('Group access'),
				'name' => 'groupBox',
				'values' => Group::getGroups(Context::getContext()->language->id),
				'info_introduction' => $this->l('You now have three default customer groups.'),
				'unidentified' => $unidentified_group_information,
				'guest' => $guest_group_information,
				'customer' => $default_group_information,
				'hint' => $this->l('Mark all of the customer groups which you would like to have access to this category.')
		);
		
		
		$this->tpl_form_vars['shared_category'] = Validate::isLoadedObject($obj) && $obj->hasMultishopEntries();
		$this->tpl_form_vars['PS_ALLOW_ACCENTED_CHARS_URL'] = (int)Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL');
		$this->tpl_form_vars['displayBackOfficeCategory'] = Hook::exec('displayBackOfficeCategory');
	
		// Display this field only if multistore option is enabled
		if (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && Tools::isSubmit('add'.$this->table.'root')) {
			$this->fields_form['input'][] = array(
					'type' => 'switch',
					'label' => $this->l('Root Category'),
					'name' => 'is_root_category',
					'required' => false,
					'is_bool' => true,
					'values' => array(
							array(
									'id' => 'is_root_on',
									'value' => 1,
									'label' => $this->l('Yes')
							),
							array(
									'id' => 'is_root_off',
									'value' => 0,
									'label' => $this->l('No')
							)
					)
			);
			unset($this->fields_form['input'][2], $this->fields_form['input'][3]);
		}
		// Display this field only if multistore option is enabled AND there are several stores configured
		if (Shop::isFeatureActive()) {
			$this->fields_form['input'][] = array(
					'type' => 'shop',
					'label' => $this->l('Shop association'),
					'name' => 'checkBoxShopAsso',
			);
		}
	
		// remove category tree and radio button "is_root_category" if this category has the root category as parent category to avoid any conflict
		if ($this->_category->id_parent == (int)Configuration::get('PS_ROOT_CATEGORY') && Tools::isSubmit('updatecategory')) {
			foreach ($this->fields_form['input'] as $k => $input) {
				if (in_array($input['name'], array('id_parent', 'is_root_category'))) {
					unset($this->fields_form['input'][$k]);
				}
			}
		}
	
		if (!($obj = $this->loadObject(true))) {
			return;
		}
	
		$image = ImageManager::thumbnail(_PS_CAT_IMG_DIR_.'/'.$obj->id.'.jpg', $this->table.'_'.(int)$obj->id.'.'.$this->imageType, 350, $this->imageType, true);
	
		$this->fields_value = array(
				'image' => $image ? $image : false,
				'size' => $image ? filesize(_PS_CAT_IMG_DIR_.'/'.$obj->id.'.jpg') / 1000 : false
		);
	
		// Added values of object Group
		$category_groups_ids = $obj->getGroups();
	
		$groups = Group::getGroups($this->context->language->id);
		// if empty $carrier_groups_ids : object creation : we set the default groups
		if (empty($category_groups_ids)) {
			$preselected = array(Configuration::get('PS_UNIDENTIFIED_GROUP'), Configuration::get('PS_GUEST_GROUP'), Configuration::get('PS_CUSTOMER_GROUP'));
			$category_groups_ids = array_merge($category_groups_ids, $preselected);
		}
		foreach ($groups as $group) {
			$this->fields_value['groupBox_'.$group['id_group']] = Tools::getValue('groupBox_'.$group['id_group'], (in_array($group['id_group'], $category_groups_ids)));
		}
	
		$this->fields_value['is_root_category'] = (bool)Tools::isSubmit('add'.$this->table.'root');
		return AdminController::renderForm();
	}
	
}