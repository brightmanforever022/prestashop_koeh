<?php

/**
 * Creates messages between master and slave and signs them,
 * checks signature of existing messages
 * 
 * Authentication is done by ip address and by crypting with known secret key.
 */
class MSSSMessageCreator
{
    /**
     * Generates text that will be sent from master to slave in request
     * @param type $messages array of messages that need to be sent
     * @param $secret secret password for encryption of message
     */
    static function createMessage(array $messages, $secret)
    {
        $m2sMsg = json_encode($messages);
        return gzencode(self::openssl_blowfish_encrypt_hex($secret, $m2sMsg));
    }
    
    
    static function parseMessage($msg, $secret)
    {
        $message = json_decode(self::openssl_blowfish_decrypt_hex($secret, gzdecode($msg)), true);
        
        if (!$message)
        {
            throw new Exception('Error while decrypting message');
        }
        
        return $message;
    }

    
    static function make_openssl_blowfish_key($key)
    {
        if ("$key" === '')
            return $key;

        $len = (16 + 2) * 4;
        while (strlen($key) < $len) {
            $key .= $key;
        }
        $key = substr($key, 0, $len);
        return $key;
    }

    static function openssl_blowfish_encrypt_hex($key, $str)
    {
        $blockSize = 8;
        $len = strlen($str);
        $paddingLen = intval(($len + $blockSize - 1) / $blockSize) * $blockSize - $len;
        $padding = str_repeat("\0", $paddingLen);
        $data = $str . $padding;
        $key = self::make_openssl_blowfish_key($key);
        $encrypted = openssl_encrypt($data, 'BF-ECB', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        return bin2hex($encrypted);
    }

    static function openssl_blowfish_decrypt_hex($key, $hex)
    {
        $key = self::make_openssl_blowfish_key($key);
        $decrypted = openssl_decrypt(hex2bin($hex), 'BF-ECB', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);
        return rtrim($decrypted, "\0");
    }
}