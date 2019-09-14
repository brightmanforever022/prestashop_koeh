<?php


class MassmailManager
{

    public function __construct()
    {}
    
    static public function setReceivers($customersList)
    {
        foreach( $customersList as $customerData ){
            
            $massmailReceiver = new MassmailReceiver();
            $massmailReceiver->id_customer = intval($customerData['id_customer']);
            
            $receiverOptions = new MassmailReceiverOptions();
            
            if( isset($customerData['attachments']) ){
                if( is_string($customerData['attachments']) ){
                    $receiverOptions->attachments[] = $customerData['attachments'];
                }
                elseif( is_array($customerData['attachments']) ){
                    $receiverOptions->attachments = $customerData['attachments'];
                }
                
            }
            
            $massmailReceiver->options = json_encode($receiverOptions);
            
            $massmailReceiver->save();
        }
    }
}

