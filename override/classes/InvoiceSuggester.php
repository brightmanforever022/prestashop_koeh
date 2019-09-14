<?php

class InvoiceSuggester
{
    /**
     * Suggests most suitable invoice template
     * @param Customer $customer
     * @param Order $order
     */
    public static function guessTemplates(Customer $customer, Order $order)
    {
        /**
         * @var DbQueryCore $query
         */
        $query = new DbQuery();
        $query
            ->select('template_id')
            ->from('invoice_rule')
            ->where('ship_by_invoice = '. intval($customer->ship_by_invoice) )
            ->where('siret_confirmed = '. intval($customer->siret_confirmed) )
            ->where('country LIKE "%|'. intval($customer->id_country) .'|%"')
        ;

        $suggestedTemplates = Db::getInstance()->executeS($query);
        
        if( !is_array($suggestedTemplates) ){
            throw new Exception('DB query error in '. __CLASS__ .': '. Db::getInstance()->getMsgError());
        }
        
        return $suggestedTemplates;
    }
}

