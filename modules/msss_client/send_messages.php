<?php

/*
 * Script sends messages to server. Should be called by cron.
 */
//return;
//define('_PS_MODE_DEV_', true);
require '../../config/config.inc.php';
require 'lib/MSSSMessageCreator.php';
require 'lib/MSSSClientStockUpdater.php';
require 'lib/MSSSRequestSender.php';
require 'lib/MSSSLog.php';

// read messages that need to be sent
$stockUpdater = new MSSSClientStockUpdater();
$messages = $stockUpdater->getMessagesToSend();

/*
echo "messages:\n";
print_r($messages);
exit;
*/

// check if we need to send something
if (!count($messages))
{
    return;
}

// create message
$msgToSend = MSSSMessageCreator::createMessage($messages, Configuration::get('MSSS_CLIENT_SECRET'));

// send message
$answer = MSSSRequestSender::sendPostRequest(Configuration::get('MSSS_CLIENT_SERVER_NOTIFICATION_URL'), array('msg' => $msgToSend,
    'sourceId'=>  Configuration::get('MSSS_CLIENT_SOURCE_ID')));

//echo "answer: \n";
//print_r($answer); 
//exit;

// check answer
if ($answer['status'] != '200')
{
    // send message to admin about error
    MSSSLog::reportError('bad response from central server. Please report to developer.', "status: {$answer['status']}\nresponse: {$answer['responseBody']}\n" . 
            print_r($messages, true));

    // mark messages processed with error
    $stockUpdater->markMessagesProcessedWithError();
}
else
{
    // update stock
    $newQuantities = json_decode($answer['responseBody'], true);
    if (!is_array($newQuantities))
    {
        $errors = 'Please report to developer. Unexpected answer from central server: '.print_r($answer['responseBody'], true);
        // mark messages processed with error
        $stockUpdater->markMessagesProcessedWithError();
    }
    else
    {
        $errors = MSSSClientStockUpdater::updateStockBySku($newQuantities);
    }
    if (!empty($errors))
    {
        MSSSLog::reportError('errors at '._PS_BASE_URL_.' during stock update after notification send to vipdress', $errors);
    }
    else
    {
        $stockUpdater->markMessagesProcessed();
    }
}