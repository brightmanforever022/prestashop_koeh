<?php

// Wheelronix Ltd. development team
// site: http://www.wheelronix.com
// mail: info@wheelronix.com

class Module extends ModuleCore
{
    /*
     * Turns a string into an array with language IDs as keys. This array can
     * be used to create multilingual fields for prestashop
     *
     * @access private
     * @scope static
     * @param mixed $field    - A field to turn into multilingual
     *
     * @return array
     */
    static function getMultilangField($field)
    {
        $languages = Language::getLanguages();
        $res = array();

        foreach ($languages as $lang)
            $res[$lang['id_lang']] = $field;

        return $res;
    }
}
