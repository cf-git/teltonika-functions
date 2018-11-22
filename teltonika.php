<?php
/**
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018, Ukraine, Sergei Shubin <is.captain.fail@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * @package      : zt2
 * @author       : Shubin Sergei
 * @user         : CF
 * @copyright    : Copyright (c) 2018, Ukraine, Sergei Shubin <is.captain.fail@gmail.com>
 * @license      : http://opensource.org/licenses/MIT	MIT License
 * @since        : Version 1.0.0 (last revision: 2018-01-03)
 */
function isAuthTeltonika(string $hex) {
    $firstByte = substr($hex, 0, 8);
    return hexdec($firstByte) !== 0;
}

function parseImeiTeltonika(string $hex) {
    $hexImei = substr($hex, 4);
    $imei = hex2bin($hexImei);
    $str = '';
    foreach (str_split(strrev((string)$imei)) as $i => $d) {
        $str .= $i % 2 !== 0 ? $d * 2 : $d;
    }
    if (array_sum(str_split($str)) % 10 === 0 && strlen($imei) == 15) return $imei;
    return false;
}

function parseTeltonika (string $text, &$success) {
    $response = ['info' => []];
    $responsep['info']['crc'] = substr($text, strlen($text)-8);
    $dl = hexdec(substr($text, 8, 8))*2;
    $avl = substr($text, 16, $dl);
    $pos = 0;
    $responsep['info']['codec'] = substr($avl, $pos, 2);
    $pos += 2;
    $success = $responsep['info']['avlCount'] = hexdec(substr($avl, $pos, 2));
    $pos += 2;

    for ($r = 0; $r < $responsep['info']['avlCount']; $r++) {
        $response[$r] = ['gps' => [], 'io' => [], 'ioAll' => [], 'ioAllHex' => []];
        /** timestamp: string|ISO Date Time */
        $response[$r]['dateHex'] = hexdec(substr($avl, $pos, 16));
        $response[$r]['date'] = date('Y-m-d H:i:s', (int)(hexdec(substr($avl, $pos, 16))/1000));
        $pos+=16;

        /** priority: integer  */
        $response[$r]['priority']= hexdec(substr($avl, $pos, 2));
        $pos+=2;

        /** longitude: float */
        $response[$r]['gps']['longitude'] = hexdec(substr($avl, $pos, 8))/10000000;
        $pos+=8;

        /** latitude: float */
        $response[$r]['gps']['latitude'] = hexdec(substr($avl, $pos, 8))/10000000;
        $pos+=8;

        /** altitude: integer|smallIntager */
        $response[$r]['gps']['altitude'] = hexdec(substr($avl, $pos, 4));
        $pos+=4;

        /** angle integer|smallIntager */
        $response[$r]['gps']['angle'] = hexdec(substr($avl, $pos, 4));
        $pos+=4;

        /** satellites integer|tynyIntager */
        $response[$r]['gps']['satellites'] = hexdec(substr($avl, $pos, 2));
        $pos+=2;

        /** speed: integer|smallIntager */
        $response[$r]['gps']['speed'] = hexdec(substr($avl, $pos, 4));
        $pos+=4;

        /** eventId: integer|tynyIntager - Event IO ID */
        $response[$r]['eventId'] = hexdec(substr($avl, $pos, 2));
        $pos+=2;

        /** ioCount integer|tynyIntager - count of elements */
        $response[$r]['ioCount'] = hexdec(substr($avl, $pos, 2));
        $pos+=2;

        /** oneBytesCount integer|tynyIntager - count of elements with one byte */
        $response[$r]['io']['oneBytesCount'] = hexdec(substr($avl, $pos, 2));
        $pos+=2;

        $response[$r]['io']['oneBytes'] = [];
        if ($response[$r]['io']['oneBytesCount']) {
            for ($bi = 0; $bi < $response[$r]['io']['oneBytesCount']; $bi++)
            {
                $id = substr($avl, $pos, 2);
                $did = hexdec($id);
                $pos+=2;

                $val = substr($avl, $pos, 2);
                $dval = hexdec($val);
                $pos+=2;
                $response[$r]['io']['oneBytes'][$did] = $dval;
                $response[$r]['ioAllHex'][$did] = $val;
                $response[$r]['ioAll'][$did] = $dval;
            }
        }

        /** twoBytesCount integer|tynyIntager - count of elements with two byte */
        $response[$r]['io']['twoBytesCount'] = hexdec(substr($avl, $pos, 2));
        $pos+=2;

        $response[$r]['io']['twoBytes'] = [];
        if ($response[$r]['io']['twoBytesCount']) {
            for ($bi = 0; $bi < $response[$r]['io']['twoBytesCount']; $bi++)
            {
                $id = substr($avl, $pos, 2);
                $did = hexdec($id);
                $pos+=2;

                $val = substr($avl, $pos, 4);
                $dval = hexdec($val);
                $pos+=4;
                $response[$r]['io']['twoBytes'][$did] = $dval;
                $response[$r]['ioAllHex'][$did] = $val;
                $response[$r]['ioAll'][$did] = $dval;
            }
        }

        /** fourBytesCount integer|tynyIntager - count of elements with four byte */
        $response[$r]['io']['fourBytesCount'] = hexdec(substr($avl, $pos, 2));
        $pos+=2;

        $response[$r]['io']['fourBytes'] = [];
        if ($response[$r]['io']['fourBytesCount']) {
            for ($bi = 0; $bi < $response[$r]['io']['fourBytesCount']; $bi++)
            {
                $id = substr($avl, $pos, 2);
                $did = hexdec($id);
                $pos+=2;

                $val = substr($avl, $pos, 8);
                $dval = hexdec($val);
                $pos+=8;
                $response[$r]['io']['fourBytes'][$did] = $dval;
                $response[$r]['ioAllHex'][$did] = $val;
                $response[$r]['ioAll'][$did] = $dval;
            }
        }

        /** eightBytesCount integer|tynyIntager - count of elements with eight byte */
        $response[$r]['io']['eightBytesCount'] = hexdec(substr($avl, $pos, 2));
        $pos+=2;

        $response[$r]['io']['eightBytes'] = [];
        if ($response[$r]['io']['eightBytesCount']) {
            for ($bi = 0; $bi < $response[$r]['io']['eightBytesCount']; $bi++)
            {
                $id = substr($avl, $pos, 2);
                $did = hexdec($id);
                $pos+=2;

                $val = substr($avl, $pos, 16);
                $dval = hexdec($val);
                $pos+=16;
                $response[$r]['io']['eightBytes'][$did] = $dval;
                $response[$r]['ioAllHex'][$did] = $val;
                $response[$r]['ioAll'][$did] = $dval;
            }
        }
    }
    return $response;
}
