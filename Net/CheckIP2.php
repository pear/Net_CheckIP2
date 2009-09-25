<?php
/**
 * Copyright (c) 2002-2006 Martin Jansen
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

/**
 * Class to validate the syntax of IPv4 adresses
 *
 * Usage:
 *   <?php
 *   require_once 'Net/CheckIP2.php';
 *
 *   if (Net_CheckIP2::check_ip("your_ip_goes_here")) {
 *       // Syntax of the IP is ok
 *   }
 *   ?>
 *
 * @author   Martin Jansen <mj@php.net>
 * @author   Guido Haeger <gh-lists@ecora.de>
 * @author   Till Klampaeckel <till@php.net>
 * @category Networking
 * @package  Net_CheckIP2
 * @version  @package_version@
 * @license  http://www.opensource.org/licenses/mit-license.html MIT License
 */
class Net_CheckIP2
{
    /**
     * Force usage of check_ip
     */
    private function __construct()
    {}

    /**
     * Validate the syntax of the given IP adress
     *
     * This function splits the IP address in 4 pieces
     * (separated by ".") and checks for each piece
     * if it's an integer value between 0 and 255.
     * If all 4 parameters pass this test, the function
     * returns true.
     *
     * @param  string $ip IP adress
     * @return bool   true if syntax is valid, otherwise false
     */
    public static function check_ip($ip = '')
    {
        if (empty($ip)) {
            return false;
        }
        $parts = explode('.', $ip);
        if (count($parts) != 4) {
            return false;
        }
        for ($i = 0; $i < 4; ++$i) {
            if (!is_numeric($parts[$i])) {
                return false;
            }
            if ($parts[$i] < 0 || $parts[$i] > 255) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if the IP address is reserved (according to RFC1918).
     *
     * Reserved IP addresses are:
     *  o 10.x.x.x
     *  o 192.168.x.x
     *  o 172.16.0.0 to 172.31.255.255
     *
     * @param string $ip The IP address.
     *
     * @return boolean
     * @throws InvalidArgumentException If validation fails.
     *
     8 @link http://www.faqs.org/rfcs/rfc1918.html
     */
    public static function isReserved($ip)
    {
        if (!self::isValid($ip)) {
            throw new InvalidArgumentException("This is an invalid IP address.");
        }
        $ip = explode('.', $ip);
        array_walk($ip, 'intval');

        $a = (int) $ip[0];
        $b = (int) $ip[1];
        $c = (int) $ip[2];
        $d = (int) $ip[3];

        //var_dump($ip, $a, $b, $c, $d);exit;

        if ($a === 10) {
            return true;
        }
        if ($a === 192 && $b === 168) {
            return true;
        }
        if ($a !== 172) {
            return false;
        }
        if ($b >= 16 && $b <= 31) {
            return true;
        }
        return false;
    }

    /**
     * A better pattern.
     *
     * @param string $ip The IP address.
     *
     * @return boolean
     * @uses   self::check_ip()
     */
    public static function isValid($ip)
    {
        return self::check_ip($ip);
    }
}
