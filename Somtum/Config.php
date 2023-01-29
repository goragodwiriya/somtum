<?php

/**
 * @filesource Somtum/Config.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Somtum;

/**
 * Class สำหรับจัดการกับ Config ของระบบ.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Config
{
    /**
     * default charset.
     *
     * @var string
     */
    public $char_set = 'UTF-8';

    /**
     * template ที่กำลังใช้งานอยู่ (ชื่อโฟลเดอร์).
     *
     * @var string
     */
    public $skin = 'default';

    /**
     * ตั้งค่าเขตเวลาของ Server ให้ตรงกันกับเวลาท้องถิ่น
     * สำหรับ Server ที่อยู่ในประเทศไทยใช้ Asia/Bankok.
     *
     * @var string
     */
    public $timezone = 'Asia/Bangkok';

    /**
     * คำอธิบายเกี่ยวกับเว็บไซต์.
     *
     * @var string
     */
    public $web_description = 'PHP Micro Framework';

    /**
     * ชื่อเว็บไซต์.
     *
     * @var string
     */
    public $web_title = 'Somtum';

    /**
     * @var Singleton สำหรับเรียกใช้ class นี้เพียงครั้งเดียวเท่านั้น
     */
    private static $instance = null;

    /**
     * เรียกใช้งาน Class แบบสามารถเรียกได้ครั้งเดียวเท่านั้น.
     *
     * @return \static
     */
    public static function create()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * อ่านค่าตัวแปร และ แปลงผลลัพท์ตามชนิดของตัวแปรตามที่กำหนดโดย $default เช่น
     * $default = 0 หรือ เลขจำนวนเต็ม ผลลัพท์จะถูกแปลงเป็น int
     * $default = 0.0 หรือตัวเลขมีจุดทศนิยม จำนวนเงิน ผลลัพท์จะถูกแปลงเป็น double
     * $default = true หรือ false ผลลัพท์จะถูกแปลงเป็น true หรือ false เท่านั้น
     * คืนค่า ค่าตัวแปร $key ถ้าไม่พบคืนค่า $default.
     *
     * @param string $key     ชื่อตัวแปร
     * @param mixed  $default (option) ค่าเริ่มต้นหากไม่พบตัวแปร
     *
     * @return mixed
     */
    public function get($key, $default = '')
    {
        if (isset($this->{$key})) {
            $result = $this->{$key};
            if (is_float($default)) {
                // จำนวนเงิน เช่น 0.0
                $result = (float) $result;
            } elseif (is_int($default)) {
                // เลขจำนวนเต็ม เช่น 0
                $result = (int) $result;
            } elseif (is_bool($default)) {
                // true, false
                $result = (bool) $result;
            }
        } else {
            $result = $default;
        }

        return $result;
    }

    /**
     * โหลดไฟล์ config.
     *
     * @param string $file ไฟล์ config (fullpath)
     *
     * @return object
     */
    public static function load($file)
    {
        $config = array();
        if (is_file($file)) {
            $config = include $file;
        }

        return (object) $config;
    }

    /**
     * บันทึกไฟล์ config ของโปรเจ็ค
     * คืนค่า true ถ้าสำเร็จ.
     *
     * @param array  $config
     * @param string $file   ไฟล์ config (fullpath)
     *
     * @return bool
     */
    public static function save($config, $file)
    {
        $f = @fopen($file, 'wb');
        if ($f !== false) {
            if (!preg_match('/^.*\/([^\/]+)\.php?/', $file, $match)) {
                $match[1] = 'config';
            }
            fwrite($f, '<'."?php\n/* $match[1].php */\nreturn ".var_export((array) $config, true).';');
            fclose($f);

            return true;
        } else {
            return false;
        }
    }

    /**
     * เรียกใช้งาน Class แบบสามารถเรียกได้ครั้งเดียวเท่านั้น.
     *
     * @return \static
     */
    protected function __construct()
    {
        if (is_file(ROOT_PATH.'settings/config.php')) {
            $config = include ROOT_PATH.'settings/config.php';
            if (is_array($config)) {
                foreach ($config as $key => $value) {
                    $this->{$key} = $value;
                }
            }
        }
        if (ROOT_PATH != APP_PATH && is_file(APP_PATH.'settings/config.php')) {
            $config = include APP_PATH.'settings/config.php';
            if (is_array($config)) {
                foreach ($config as $key => $value) {
                    $this->{$key} = $value;
                }
            }
        }
    }
}
