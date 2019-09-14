<?php

class EmployeeArea
{
    public static function getEmployeeCountries($id_employee, $id_lang)
    {
        /**
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query
            ->select('ec.id_employee_country, ec.id_country, cl.name AS country_name,
                GROUP_CONCAT(ep.postcode ORDER BY ep.postcode ASC  SEPARATOR "|") AS postcodes')
            ->from('employee_country', 'ec')
            ->innerJoin('country_lang', 'cl',
                'cl.id_country = ec.id_country AND cl.id_lang = '. $id_lang)
            ->leftJoin('employee_postcode', 'ep', 'ep.id_employee_country = ec.id_employee_country')
            ->where('ec.id_employee = '. $id_employee)
            ->orderBy('cl.name ASC')
            ->groupBy('ec.id_employee_country')
        ;

        return Db::getInstance()->executeS($query);
                    
    }

    public static function setListSqlConditions($customerTableAlias, $id_employee, $queryParts)
    {
        $queryParts['join'] .= ' INNER JOIN `'._DB_PREFIX_.'employee_country` eac
            ON eac.id_country = '. $customerTableAlias .'.id_country AND eac.id_employee = '. $id_employee;
        $queryParts['join'] .= ' INNER JOIN `'._DB_PREFIX_.'employee_postcode` eap
            ON eap.id_employee_country = eac.id_employee_country';
        $queryParts['where'] .= ' AND '.$customerTableAlias.'.postcode LIKE CONCAT(REPLACE(eap.postcode, "*", ""), "%")';
    }
    
    public static function isCustomerInEmployeeArea($id_employee, $id_customer)
    {
        $employeeAreas = self::getEmployeeCountries($id_employee, Configuration::get('PS_LANG_DEFAULT'));
        
        if( !is_array($employeeAreas) ){
            throw new Exception('Returned value not an array');
        }

        if( !count($employeeAreas) ){
            return true;
        }
        
        $customer = new Customer($id_customer);
        
        foreach( $employeeAreas as $employeeArea ){
            if( $employeeArea['id_country'] == $customer->id_country ){
                $employeeCountryPostcodesList = Db::getInstance()->executeS('
                    SELECT *
                    FROM `'._DB_PREFIX_.'employee_postcode`
                    WHERE id_employee_country = '. $employeeArea['id_employee_country'] .'
                ');
                foreach($employeeCountryPostcodesList as $employeeCountryPostcode){
                    if( $employeeCountryPostcode['postcode'] == '*' ){
                        return true;
                    }
                    
                    $postcodeRegex = '#^'. preg_quote( $employeeCountryPostcode['postcode'], '#') .'.*#';
                    if( preg_match($postcodeRegex, $customer->postcode) ){
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
}

