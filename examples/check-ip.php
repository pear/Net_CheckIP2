<?php
require_once 'Net/CheckIP2.php';

$ip_address = '89.247.12.130';
if (Net_CheckIP2::check_ip($ip_address)) {
    echo 'yay!!!';
} else {
    echo 'nay!!! :(';
}

$ip_address = 'some.host.name.domain.tld';
if (Net_CheckIP2::check_ip($ip_address)) {
    echo 'yay!!!';        
} else {
    echo 'nay!!! :(';
}
?>
