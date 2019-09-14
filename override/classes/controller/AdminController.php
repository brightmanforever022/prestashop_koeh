<?php

class AdminController extends AdminControllerCore
{
    public function init()
    {
        session_start();
        
        if( !empty($_SESSION['confirmations']) ){
            $this->confirmations = array_merge($this->confirmations, $_SESSION['confirmations']);
            unset($_SESSION['confirmations']);
        }
        
        // makes employye/admin session never expiring (only cookie lifetime limit affects)
        $this->context->cookie->last_activity = time();
        parent::init();
    }
    
    /**
     * Added check of which fields really updated, to trigger functions only when needed
     *
     * @param ObjectModel &$object Object
     * @param string $table Object table
     */
    protected function copyFromPost(&$object, $table)
    {
        $object->edited_fields = array();
        /* Classical fields */
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, $object) && $key != 'id_'.$table) {
                /* Do not take care of password field if empty */
                if ($key == 'passwd' && Tools::getValue('id_'.$table) && empty($value)) {
                    continue;
                }
                /* Automatically encrypt password in MD5 */
                if ($key == 'passwd' && !empty($value)) {
                    $value = Tools::encrypt($value);
                }
                /** Override. !!! Not well tested, just a draft !!! */
                if( (!is_null($object->{$key}) && !empty($value)) && ($object->{$key} !== $value) ){
                    $object->edited_fields[] = $key; 
                }
                
                $object->{$key} = $value;
            }
        }
    
        /* Multilingual fields */
        $class_vars = get_class_vars(get_class($object));
        $fields = array();
        if (isset($class_vars['definition']['fields'])) {
            $fields = $class_vars['definition']['fields'];
        }
    
        foreach ($fields as $field => $params) {
            if (array_key_exists('lang', $params) && $params['lang']) {
                foreach (Language::getIDs(false) as $id_lang) {
                    if (Tools::isSubmit($field.'_'.(int)$id_lang)) {
                        $object->{$field}[(int)$id_lang] = Tools::getValue($field.'_'.(int)$id_lang);
                    }
                }
            }
        }
    }

    /**
     * Object update
     * Added beforeUpdate method call
     *
     * @return ObjectModel|false|void
     * @throws PrestaShopException
     */
    public function processUpdate()
    {
        /* Checking fields validity */
        $this->validateRules();
        if (empty($this->errors)) {
            $id = (int)Tools::getValue($this->identifier);
            
            /* Object update */
            if (isset($id) && !empty($id)) {
                /** @var ObjectModel $object */
                $object = new $this->className($id);
                if (Validate::isLoadedObject($object)) {
                    /* Specific to objects which must not be deleted */
                    if ($this->deleted && $this->beforeDelete($object)) {
                        // Create new one with old objet values
                        /** @var ObjectModel $object_new */
                        $object_new = $object->duplicateObject();
                        if (Validate::isLoadedObject($object_new)) {
                            // Update old object to deleted
                            $object->deleted = 1;
                            $object->update();
                            
                            // Update new object with post values
                            $this->copyFromPost($object_new, $this->table);
                            $result = $object_new->update();
                            if (Validate::isLoadedObject($object_new)) {
                                $this->afterDelete($object_new, $object->id);
                            }
                        }
                    } else {
                        $this->copyFromPost($object, $this->table);
                        $this->beforeUpdate($object);
                        $result = $object->update();
                        $this->afterUpdate($object);
                    }
                    
                    if ($object->id) {
                        $this->updateAssoShop($object->id);
                    }
                    
                    if (!$result) {
                        $this->errors[] = Tools::displayError('An error occurred while updating an object.').
                        ' <b>'.$this->table.'</b> ('.Db::getInstance()->getMsgError().')';
                    } elseif ($this->postImage($object->id) && !count($this->errors) && $this->_redirect) {
                        $parent_id = (int)Tools::getValue('id_parent', 1);
                        // Specific back redirect
                        if ($back = Tools::getValue('back')) {
                            $this->redirect_after = urldecode($back).'&conf=4';
                        }
                        // Specific scene feature
                        // @todo change stay_here submit name (not clear for redirect to scene ... )
                        if (Tools::getValue('stay_here') == 'on' || Tools::getValue('stay_here') == 'true' || Tools::getValue('stay_here') == '1') {
                            $this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$object->id.'&conf=4&updatescene&token='.$this->token;
                        }
                        // Save and stay on same form
                        // @todo on the to following if, we may prefer to avoid override redirect_after previous value
                        if (Tools::isSubmit('submitAdd'.$this->table.'AndStay')) {
                            $this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$object->id.'&conf=4&update'.$this->table.'&token='.$this->token;
                        }
                        // Save and back to parent
                        if (Tools::isSubmit('submitAdd'.$this->table.'AndBackToParent')) {
                            $this->redirect_after = self::$currentIndex.'&'.$this->identifier.'='.$parent_id.'&conf=4&token='.$this->token;
                        }
                        
                        // Default behavior (save and back)
                        if (empty($this->redirect_after) && $this->redirect_after !== false) {
                            $this->redirect_after = self::$currentIndex.($parent_id ? '&'.$this->identifier.'='.$object->id : '').'&conf=4&token='.$this->token;
                        }
                    }
                    PrestaShopLogger::addLog(sprintf($this->l('%s modification', 'AdminTab', false, false), $this->className), 1, null, $this->className, (int)$object->id, true, (int)$this->context->employee->id);
                } else {
                    $this->errors[] = Tools::displayError('An error occurred while updating an object.').
                    ' <b>'.$this->table.'</b> '.Tools::displayError('(cannot load object)');
                }
            }
        }
        $this->errors = array_unique($this->errors);
        if (!empty($this->errors)) {
            // if we have errors, we stay on the form instead of going back to the list
            $this->display = 'edit';
            return false;
        }
        
        if (isset($object)) {
            return $object;
        }
        return;
    }
    
    public function beforeUpdate(&$object)
    {
        
    }

    /**
     * Get the current objects' list form the database
     *
     * @param int $id_lang Language used for display
     * @param string|null $order_by ORDER BY clause
     * @param string|null $order_way Order way (ASC, DESC)
     * @param int $start Offset in LIMIT clause
     * @param int|null $limit Row count in LIMIT clause
     * @param int|bool $id_lang_shop
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     * 
     * Overriden: 1) check if field is already in select clause
     */
    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false)
    {
        Hook::exec('action'.$this->controller_name.'ListingFieldsModifier', array(
            'select' => &$this->_select,
            'join' => &$this->_join,
            'where' => &$this->_where,
            'group_by' => &$this->_group,
            'order_by' => &$this->_orderBy,
            'order_way' => &$this->_orderWay,
            'fields' => &$this->fields_list,
        ));
        
        if (!isset($this->list_id)) {
            $this->list_id = $this->table;
        }
        
        /* Manage default params values */
        $use_limit = true;
        if ($limit === false) {
            $use_limit = false;
        } elseif (empty($limit)) {
            if (isset($this->context->cookie->{$this->list_id.'_pagination'}) && $this->context->cookie->{$this->list_id.'_pagination'}) {
                $limit = $this->context->cookie->{$this->list_id.'_pagination'};
            } else {
                $limit = $this->_default_pagination;
            }
        }
        
        if (!Validate::isTableOrIdentifier($this->table)) {
            throw new PrestaShopException(sprintf('Table name %s is invalid:', $this->table));
        }
        $prefix = str_replace(array('admin', 'controller'), '', Tools::strtolower(get_class($this)));
        if (empty($order_by)) {
            if ($this->context->cookie->{$prefix.$this->list_id.'Orderby'}) {
                $order_by = $this->context->cookie->{$prefix.$this->list_id.'Orderby'};
            } elseif ($this->_orderBy) {
                $order_by = $this->_orderBy;
            } else {
                $order_by = $this->_defaultOrderBy;
            }
        }
        
        if (empty($order_way)) {
            if ($this->context->cookie->{$prefix.$this->list_id.'Orderway'}) {
                $order_way = $this->context->cookie->{$prefix.$this->list_id.'Orderway'};
            } elseif ($this->_orderWay) {
                $order_way = $this->_orderWay;
            } else {
                $order_way = $this->_defaultOrderWay;
            }
        }
        
        $limit = (int)Tools::getValue($this->list_id.'_pagination', $limit);
        if (in_array($limit, $this->_pagination) && $limit != $this->_default_pagination) {
            $this->context->cookie->{$this->list_id.'_pagination'} = $limit;
        } else {
            unset($this->context->cookie->{$this->list_id.'_pagination'});
        }
        
        /* Check params validity */
        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)
            || !is_numeric($start) || !is_numeric($limit)
            || !Validate::isUnsignedId($id_lang)) {
                throw new PrestaShopException('get list params is not valid');
            }
            
            if (!isset($this->fields_list[$order_by]['order_key']) && isset($this->fields_list[$order_by]['filter_key'])) {
                $this->fields_list[$order_by]['order_key'] = $this->fields_list[$order_by]['filter_key'];
            }
            
            if (isset($this->fields_list[$order_by]) && isset($this->fields_list[$order_by]['order_key'])) {
                $order_by = $this->fields_list[$order_by]['order_key'];
            }
            
            /* Determine offset from current page */
            $start = 0;
            if ((int)Tools::getValue('submitFilter'.$this->list_id)) {
                $start = ((int)Tools::getValue('submitFilter'.$this->list_id) - 1) * $limit;
            } elseif (empty($start) && isset($this->context->cookie->{$this->list_id.'_start'}) && Tools::isSubmit('export'.$this->table)) {
                $start = $this->context->cookie->{$this->list_id.'_start'};
            }
            
            // Either save or reset the offset in the cookie
            if ($start) {
                $this->context->cookie->{$this->list_id.'_start'} = $start;
            } elseif (isset($this->context->cookie->{$this->list_id.'_start'})) {
                unset($this->context->cookie->{$this->list_id.'_start'});
            }
            
            /* Cache */
            $this->_lang = (int)$id_lang;
            $this->_orderBy = $order_by;
            
            if (preg_match('/[.!]/', $order_by)) {
                $order_by_split = preg_split('/[.!]/', $order_by);
                $order_by = bqSQL($order_by_split[0]).'.`'.bqSQL($order_by_split[1]).'`';
            } elseif ($order_by) {
                $order_by = '`'.bqSQL($order_by).'`';
            }
            
            $this->_orderWay = Tools::strtoupper($order_way);
            
            /* SQL table : orders, but class name is Order */
            $sql_table = $this->table == 'order' ? 'orders' : $this->table;
            
            // Add SQL shop restriction
            $select_shop = $join_shop = $where_shop = '';
            if ($this->shopLinkType) {
                $select_shop = ', shop.name as shop_name ';
                $join_shop = ' LEFT JOIN '._DB_PREFIX_.$this->shopLinkType.' shop
							ON a.id_'.$this->shopLinkType.' = shop.id_'.$this->shopLinkType;
                $where_shop = Shop::addSqlRestriction($this->shopShareDatas, 'a', $this->shopLinkType);
            }
            
            if ($this->multishop_context && Shop::isTableAssociated($this->table) && !empty($this->className)) {
                if (Shop::getContext() != Shop::CONTEXT_ALL || !$this->context->employee->isSuperAdmin()) {
                    $test_join = !preg_match('#`?'.preg_quote(_DB_PREFIX_.$this->table.'_shop').'`? *sa#', $this->_join);
                    if (Shop::isFeatureActive() && $test_join && Shop::isTableAssociated($this->table)) {
                        $this->_where .= ' AND EXISTS (
						SELECT 1
						FROM `'._DB_PREFIX_.$this->table.'_shop` sa
						WHERE a.'.$this->identifier.' = sa.'.$this->identifier.' AND sa.id_shop IN ('.implode(', ', Shop::getContextListShopID()).')
					)';
                    }
                }
            }
            
            /* Query in order to get results with all fields */
            $lang_join = '';
            if ($this->lang) {
                $lang_join = 'LEFT JOIN `'._DB_PREFIX_.$this->table.'_lang` b ON (b.`'.$this->identifier.'` = a.`'.$this->identifier.'` AND b.`id_lang` = '.(int)$id_lang;
                if ($id_lang_shop) {
                    if (!Shop::isFeatureActive()) {
                        $lang_join .= ' AND b.`id_shop` = '.(int)Configuration::get('PS_SHOP_DEFAULT');
                    } elseif (Shop::getContext() == Shop::CONTEXT_SHOP) {
                        $lang_join .= ' AND b.`id_shop` = '.(int)$id_lang_shop;
                    } else {
                        $lang_join .= ' AND b.`id_shop` = a.id_shop_default';
                    }
                }
                $lang_join .= ')';
            }
            
            $having_clause = '';
            if (isset($this->_filterHaving) || isset($this->_having)) {
                $having_clause = ' HAVING ';
                if (isset($this->_filterHaving)) {
                    $having_clause .= ltrim($this->_filterHaving, ' AND ');
                }
                if (isset($this->_having)) {
                    $having_clause .= $this->_having.' ';
                }
            }
            
            do {
                $this->_listsql = '';
                
                if ($this->explicitSelect) {
                    foreach ($this->fields_list as $key => $array_value) {
                        // Add it only if it is not already in $this->_select
                        if (isset($this->_select) && (preg_match('/[\s]`?'.preg_quote($key, '/').'`?\s*,/', $this->_select) || preg_match('/[\s]`?'.preg_quote($key, '/').'`?$/', $this->_select) )) {
                            continue;
                        }
                        
                        if (isset($array_value['filter_key'])) {
                            $this->_listsql .= str_replace('!', '.`', $array_value['filter_key']).'` AS `'.$key.'`, ';
                        } elseif ($key == 'id_'.$this->table) {
                            $this->_listsql .= 'a.`'.bqSQL($key).'`, ';
                        } elseif ($key != 'image' && !preg_match('/'.preg_quote($key, '/').'/i', $this->_select)) {
                            $this->_listsql .= '`'.bqSQL($key).'`, ';
                        }
                    }
                    $this->_listsql = rtrim(trim($this->_listsql), ',');
                } else {
                    $this->_listsql .= ($this->lang ? 'b.*,' : '').' a.*';
                }
                
                $this->_listsql .= '
			'.(isset($this->_select) ? ', '.rtrim($this->_select, ', ') : '').$select_shop;
                
                $sql_from = '
			FROM `'._DB_PREFIX_.$sql_table.'` a ';
                $sql_join = '
			'.$lang_join.'
			'.(isset($this->_join) ? $this->_join.' ' : '').'
			'.$join_shop;
                $sql_where = ' '.(isset($this->_where) ? $this->_where.' ' : '').($this->deleted ? 'AND a.`deleted` = 0 ' : '').
                (isset($this->_filter) ? $this->_filter : '').$where_shop.'
			'.(isset($this->_group) ? $this->_group.' ' : '').'
			'.$having_clause;
                $sql_order_by = ' ORDER BY '.((str_replace('`', '', $order_by) == $this->identifier) ? 'a.' : '').$order_by.' '.pSQL($order_way).
                ($this->_tmpTableFilter ? ') tmpTable WHERE 1'.$this->_tmpTableFilter : '');
                $sql_limit = ' '.(($use_limit === true) ? ' LIMIT '.(int)$start.', '.(int)$limit : '');
                
                if ($this->_use_found_rows || isset($this->_filterHaving) || isset($this->_having)) {
                    $this->_listsql = 'SELECT SQL_CALC_FOUND_ROWS
								'.($this->_tmpTableFilter ? ' * FROM (SELECT ' : '').$this->_listsql.$sql_from.$sql_join.' WHERE 1 '.$sql_where.
								$sql_order_by.$sql_limit;
								$list_count = 'SELECT FOUND_ROWS() AS `'._DB_PREFIX_.$this->table.'`';
                } else {
                    $this->_listsql = 'SELECT
								'.($this->_tmpTableFilter ? ' * FROM (SELECT ' : '').$this->_listsql.$sql_from.$sql_join.' WHERE 1 '.$sql_where.
								$sql_order_by.$sql_limit;
								$list_count = 'SELECT COUNT(*) AS `'._DB_PREFIX_.$this->table.'` '.$sql_from.$sql_join.' WHERE 1 '.$sql_where;
                }
                
                $this->_list = Db::getInstance()->executeS($this->_listsql, true, false);
                
                if ($this->_list === false) {
                    $this->_list_error = Db::getInstance()->getMsgError();
                    break;
                }
                
                $this->_listTotal = Db::getInstance()->getValue($list_count, false);
                
                if ($use_limit === true) {
                    $start = (int)$start - (int)$limit;
                    if ($start < 0) {
                        break;
                    }
                } else {
                    break;
                }
            } while (empty($this->_list));
            
            Hook::exec('action'.$this->controller_name.'ListingResultsModifier', array(
                'list' => &$this->_list,
                'list_total' => &$this->_listTotal,
            ));
    }
    
}
