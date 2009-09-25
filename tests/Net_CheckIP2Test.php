<?php
/**
 * Check if an ipv4 address is valid.
 *
 * PHP versions 5
 *
 * @category  Net
 * @package   Net_CheckIP2
 * @author    Till Klampaeckel <till@php.net>
 * @copyright Copyright (c) 2007 Contaxis Limited
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/Net_CheckIP2
 */

/**
 * PHPUnit_Framework_TestCase
 * @ignore
 */
require_once 'PHPUnit/Framework/TestCase.php';

set_include_path(
    realpath(dirname(__FILE__) . '/../')
    . ':' . get_include_path()
);

/**
 * File_IMC
 */
require_once "Net/CheckIP2.php";

/**
 * Tests for File_IMC.
 *
 * @category  Net
 * @package   Net_CheckIP2
 * @author    Till Klampaeckel <till@php.net>
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Net_CheckIP2
 */
class Net_CheckIP2Test extends PHPUnit_Framework_TestCase
{
    public static function ipProvider()
    {
        return array(
            array('192.168.10.2', true),
            array('10.0.0.1', true),
            array('0.0.0.0', true),
            array('', false),
            array('255.255.255.255', true),
            array('172.16.0.0', true),
            array('172.31.255.255', true),
            array('192.168.0.256', false),
            array('a.123.123.123', false),
        );
    }

    /**
     * @dataProvider ipProvider
     */
    public function testIp($ip, $assert)
    {
        $this->assertSame($assert, Net_CheckIP2::check_ip($ip));
    }
}
