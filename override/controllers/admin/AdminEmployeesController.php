<?php

class AdminEmployeesController extends AdminEmployeesControllerCore
{
    public function __construct()
    {
        parent::__construct();
        
        $this->fields_list['active']['title'] = $this->l('Web access');
        
        $this->fields_list['active_ws'] = array(
            'title' => $this->l('API access'),
            'align' => 'center',
            'active' => 'active_ws',
            'type' => 'bool',
            'class' => 'fixed-width-sm',
            'filter_key' => 'active_ws',
            'filter_type' => 'int',
            'orderby' => false,
        );
        
    }
    
    public function initContent()
    {
        if( $this->context->employee->id_profile == _PS_ADMIN_PROFILE_ ){
            $this->addJS(__PS_BASE_URI__.'js/admin/employee.js');
            $countriesList = CountryCore::getCountries($this->context->language->id);
            $countriesOptions = array();
            foreach($countriesList as $countryData){
                $countriesOptions[ $countryData['id_country'] ] = $countryData['country'];
            }
            
            $employeeCountry = new EmployeeCountry();
            $employeeCountryArray = $employeeCountry->getFields();
            $employeeCountryArray['postcodes'] = '';
            
            $this->context->smarty->assign(array(
                'can_edit' => true,
                'id_employee' => Tools::getValue('id_employee'),
                'employee_area_controller_url' => $this->context->link->getAdminLink('AdminEmployeeArea'),
                'countries_options' => $countriesOptions,
                'employee_country' => $employeeCountryArray
            ));
        }
        else{
            $this->context->smarty->assign(array(
                'can_edit' => false
            ));
            
        }
        
        return parent::initContent();
    }
    
    public function renderList()
    {
        $this->_select = 'pl.`name` AS profile, a.active_ws';
        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'profile` p ON a.`id_profile` = p.`id_profile`
            LEFT JOIN `'._DB_PREFIX_.'profile_lang` pl ON (pl.`id_profile` = p.`id_profile` AND pl.`id_lang` = '
		    .(int)$this->context->language->id.')';
		$this->_use_found_rows = false;
		
		    
		return AdminController::renderList();
		    
    }
    
    public function postProcess()
    {
        if( empty($this->action) && Tools::isSubmit('active_ws'.$this->table) ){
            $this->action = 'active_ws';
        }
        
        parent::postProcess();
    }
    
    public function processActiveWs()
    {
        $this->loadObject(true);
        if (!Validate::isLoadedObject($this->object)) {
            return false;
        }
        
        $this->object->active_ws = !$this->object->active_ws;
        
        $this->object->update();
        
        $this->redirect_after = self::$currentIndex.'&token='.$this->token;
        
        return;
    }
    
    
    public function renderForm()
    {
        // @var Employee $obj
        if (!($obj = $this->loadObject(true))) {
            return;
        }
        
        $available_profiles = Profile::getProfiles($this->context->language->id);
        
        if ($obj->id_profile == _PS_ADMIN_PROFILE_ && $this->context->employee->id_profile != _PS_ADMIN_PROFILE_) {
            $this->errors[] = Tools::displayError('You cannot edit the SuperAdmin profile.');
            return parent::renderForm();
        }
        
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Employees'),
                'icon' => 'icon-user'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'class' => 'fixed-width-xl',
                    'label' => $this->l('First Name'),
                    'name' => 'firstname',
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'class' => 'fixed-width-xl',
                    'label' => $this->l('Last Name'),
                    'name' => 'lastname',
                    'required' => true
                ),
                array(
                    'type' => 'html',
                    'name' => 'employee_avatar',
                    'html_content' => '<div id="employee-thumbnail"><a href="http://www.prestashop.com/forums/index.php?app=core&amp;module=usercp" target="_blank" style="background-image:url('.$obj->getImage().')"></a></div>
					<div class="alert alert-info">'.sprintf($this->l('Your avatar in PrestaShop 1.6.x is your profile picture on %1$s. To change your avatar, log in to PrestaShop.com with your email %2$s and follow the on-screen instructions.'), '<a href="http://www.prestashop.com/forums/index.php?app=core&amp;module=usercp" class="alert-link" target="_blank">PrestaShop.com</a>', $obj->email).'</div>',
                ),
                array(
                    'type' => 'text',
                    'class'=> 'fixed-width-xxl',
                    'prefix' => '<i class="icon-envelope-o"></i>',
                    'label' => $this->l('Email address'),
                    'name' => 'email',
                    'required' => true,
                    'autocomplete' => false
                ),
            ),
        );
        
        if ($this->restrict_edition) {
            $this->fields_form['input'][] = array(
                'type' => 'change-password',
                'label' => $this->l('Password'),
                'name' => 'passwd'
            );
            
            if (Tab::checkTabRights(Tab::getIdFromClassName('AdminModulesController'))) {
                $this->fields_form['input'][] = array(
                    'type' => 'prestashop_addons',
                    'label' => 'PrestaShop Addons',
                    'name' => 'prestashop_addons',
                );
            }
        } else {
            $this->fields_form['input'][] = array(
                'type' => 'password',
                'label' => $this->l('Password'),
                'hint' => sprintf($this->l('Password should be at least %s characters long.'), Validate::ADMIN_PASSWORD_LENGTH),
                'name' => 'passwd'
            );
        }
        
        $this->fields_form['input'] = array_merge($this->fields_form['input'], array(
            array(
                'type' => 'switch',
                'label' => $this->l('Subscribe to PrestaShop newsletter'),
                'name' => 'optin',
                'required' => false,
                'is_bool' => true,
                'values' => array(
                    array(
                        'id' => 'optin_on',
                        'value' => 1,
                        'label' => $this->l('Yes')
                    ),
                    array(
                        'id' => 'optin_off',
                        'value' => 0,
                        'label' => $this->l('No')
                    )
                ),
                'hint' => $this->l('PrestaShop can provide you with guidance on a regular basis by sending you tips on how to optimize the management of your store which will help you grow your business. If you do not wish to receive these tips, you can disable this option.')
            ),
            array(
                'type' => 'default_tab',
                'label' => $this->l('Default page'),
                'name' => 'default_tab',
                'hint' => $this->l('This page will be displayed just after login.'),
                'options' => $this->tabs_list
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Language'),
                'name' => 'id_lang',
                //'required' => true,
                'options' => array(
                    'query' => Language::getLanguages(false),
                    'id' => 'id_lang',
                    'name' => 'name'
                )
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Theme'),
                'name' => 'bo_theme_css',
                'options' => array(
                    'query' => $this->themes,
                    'id' => 'id',
                    'name' => 'name'
                ),
                'onchange' => 'var value_array = $(this).val().split("|"); $("link").first().attr("href", "themes/" + value_array[0] + "/css/" + value_array[1]);',
                'hint' => $this->l('Back office theme.')
            ),
            array(
                'type' => 'radio',
                'label' => $this->l('Admin menu orientation'),
                'name' => 'bo_menu',
                'required' => false,
                'is_bool' => true,
                'values' => array(
                    array(
                        'id' => 'bo_menu_on',
                        'value' => 0,
                        'label' => $this->l('Top')
                    ),
                    array(
                        'id' => 'bo_menu_off',
                        'value' => 1,
                        'label' => $this->l('Left')
                    )
                )
            )
        ));
        
        if ($this->context->employee->id_profile == _PS_ADMIN_PROFILE_) {
            $this->fields_form['input'][] = array(
                'type' => 'switch',
                'label' => $this->l('Web access'),
                'name' => 'active',
                'required' => true,
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
                ),
                'hint' => $this->l('Allow or disallow this employee to log into the Admin panel.')
            );
            $this->fields_form['input'][] = array(
                'type' => 'switch',
                'label' => $this->l('Web API access'),
                'name' => 'active_ws',
                'required' => true,
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
                ),
                'hint' => $this->l('Allow or disallow this employee to log into the mobile application.')
            );
            
            // if employee is not SuperAdmin (id_profile = 1), don't make it possible to select the admin profile
            if ($this->context->employee->id_profile != _PS_ADMIN_PROFILE_) {
                foreach ($available_profiles as $i => $profile) {
                    if ($available_profiles[$i]['id_profile'] == _PS_ADMIN_PROFILE_) {
                        unset($available_profiles[$i]);
                        break;
                    }
                }
            }
            $this->fields_form['input'][] = array(
                'type' => 'select',
                'label' => $this->l('Permission profile'),
                'name' => 'id_profile',
                'required' => true,
                'options' => array(
                    'query' => $available_profiles,
                    'id' => 'id_profile',
                    'name' => 'name',
                    'default' => array(
                        'value' => '',
                        'label' => $this->l('-- Choose --')
                    )
                )
            );
            
            if (Shop::isFeatureActive()) {
                $this->context->smarty->assign('_PS_ADMIN_PROFILE_', (int)_PS_ADMIN_PROFILE_);
                $this->fields_form['input'][] = array(
                    'type' => 'shop',
                    'label' => $this->l('Shop association'),
                    'hint' => $this->l('Select the shops the employee is allowed to access.'),
                    'name' => 'checkBoxShopAsso',
                );
            }
        }
        
        $this->fields_form['submit'] = array(
            'title' => $this->l('Save'),
        );
        
        $this->fields_value['passwd'] = false;
        $this->fields_value['bo_theme_css'] = $obj->bo_theme.'|'.$obj->bo_css;
        
        if (empty($obj->id)) {
            $this->fields_value['id_lang'] = $this->context->language->id;
        }
        
        return AdminController::renderForm();
    }
    
}

