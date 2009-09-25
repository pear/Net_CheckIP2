<?php
/**
 * Check if an ipv4 address is valid.
 *
 * PHP versions 5
 *
 * @category  Networking
 * @package   Net_CheckIP2
 * @author    Till Klampaeckel <till@php.net>
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
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
 * Tests for Net_CheckIP2.
 *
 * @category  Networking
 * @package   Net_CheckIP2
 * @author    Till Klampaeckel <till@php.net>
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
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
            array('1,234.123.123.123', false),
            array('0.1,23.0.0.1', false),
            array('10.9.8.7.6', false),
        );
    }

    /**
     * @dataProvider ipProvider
     */
    public function testIp($ip, $assert)
    {
        $this->assertSame($assert, Net_CheckIP2::isValid($ip));
    }

    public static function reservedIpProvider()
    {
        return array(
            array('10.0.0.0'),
            array('192.168.0.255'),
            array('172.16.0.33'),
            array('172.31.255.255'),
        );
    }

    /**
     * @dataProvider reservedIpProvider
     */
    public function testReserved($ip)
    {
        $this->assertTrue(Net_CheckIP2::isReserved($ip));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testReservedException()
    {
        Net_CheckIP2::isReserved('x.x.x.x');
    }

    public static function classProvider()
    {
        return array(
            array('127.0.0.1', Net_CheckIP2::CLASS_A),
            array('149.76.12.4', Net_CheckIP2::CLASS_B),
            array('193.202.116.8', Net_CheckIP2::CLASS_C),
            array('223.255.255.0', Net_CheckIP2::CLASS_C),
            array('224.0.0.0', false), // Class D, E, F
            array('254.0.0.0', false), // Class D, E, F
        );
    }

    /**
     * @dataProvider classProvider
     */
    public function testIpClass($ip, $classNetwork)
    {
        $this->assertSame($classNetwork, Net_CheckIP2::getClass($ip));
    }
}
