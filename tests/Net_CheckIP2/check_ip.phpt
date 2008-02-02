--TEST--
Net_CheckIP2::check_ip() 
--FILE--
<?php
require_once 'Net/CheckIP2.php';
$is_ip = Net_CheckIP2::check_ip('82.96.79.2');
var_dump($is_ip);
?>
--EXPECT--
bool(true)
