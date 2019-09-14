<?php

require '../../config/config.inc.php';

$burgel = Module::getInstanceByName('burgel');
$burgel->hookActionValidateOrder(['order' => new Order(1912)]);