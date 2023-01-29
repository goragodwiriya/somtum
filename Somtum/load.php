<?php
/**
 * @filesource Somtum/Load.php
 *
 * ไฟล์หลักสำหรับกำหนดค่าเริ่มต้นในการโหลดเฟรมเวิร์ค
 * ต้อง include ไฟล์นี้ก่อนเสมอ
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */
/**
 * การแสดงข้อผิดพลาด
 * 0 (default) ปิดการแสดงผลข้อผิดพลาดของ PHP
 * 2 แสดงผลข้อผิดพลาดและคำเตือนออกทางหน้าจอ (ใช้เฉพาะตอนออกแบบเท่านั้น).
 */
if (defined('DEBUG') && DEBUG > 0) {
    /* ขณะออกแบบ แสดง error และ warning ของ PHP */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
}
/**
 * ไดเรคทอรี่ของ Framework.
 */
$vendorDir = str_replace('load.php', '', __FILE__);
if (DIRECTORY_SEPARATOR != '/') {
    $vendorDir = str_replace('\\', '/', $vendorDir);
}
define('VENDOR_DIR', $vendorDir);
/*
 * พาธของ Server ตั้งแต่ระดับราก เช่น D:/htdocs/Somtum/
 */
$docRoot = dirname($vendorDir);
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $docRoot.'/');
}
/**
 *  document root (Server).
 */
$contextPrefix = '';
if (isset($_SERVER['APPL_PHYSICAL_PATH'])) {
    $docRoot = rtrim(realpath($_SERVER['APPL_PHYSICAL_PATH']), DIRECTORY_SEPARATOR);
    if (DIRECTORY_SEPARATOR != '/' && $docRoot != '') {
        $docRoot = str_replace('\\', '/', $docRoot);
    }
} elseif (strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) !== false) {
    $docRoot = rtrim(realpath($_SERVER['DOCUMENT_ROOT']), DIRECTORY_SEPARATOR);
    if (DIRECTORY_SEPARATOR != '/' && $docRoot != '') {
        $docRoot = str_replace('\\', '/', $docRoot);
    }
} else {
    $dir = basename($docRoot);
    $ds = explode($dir, dirname($_SERVER['SCRIPT_NAME']), 2);
    $appPath = '';
    if (sizeof($ds) > 1) {
        $contextPrefix = $ds[0].$dir;
        $appPath = $ds[1];
        if (DIRECTORY_SEPARATOR != '/') {
            $contextPrefix = str_replace('\\', '/', $contextPrefix);
        }
    }
    if (!defined('APP_PATH')) {
        define('APP_PATH', $docRoot.$appPath.'/');
    }
    if (!defined('BASE_PATH')) {
        define('BASE_PATH', $contextPrefix.$appPath.'/');
    }
}

/*
 * พาธของ Application เช่น D:/htdocs/Somtum/
 */
if (!defined('APP_PATH')) {
    $appPath = dirname($_SERVER['SCRIPT_NAME']);
    if (DIRECTORY_SEPARATOR != '/') {
        $appPath = str_replace('\\', '/', $appPath);
    }
    define('APP_PATH', rtrim($docRoot.$appPath, '/').'/');
}
/*
 *  http หรือ https
 */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'].'://';
} elseif ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) {
    $scheme = 'https://';
} else {
    $scheme = 'http://';
}
/*
 * host name
 */
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $host = trim(current(explode(',', $_SERVER['HTTP_X_FORWARDED_HOST'])));
} elseif (empty($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['SERVER_NAME'];
} else {
    $host = $_SERVER['HTTP_HOST'];
}
if (!defined('HOST')) {
    define('HOST', $host);
}
/*
 * ไดเร็คทอรี่ที่ติดตั้งเว็บไซต์ตั้งแต่ DOCUMENT_ROOT
 * เช่น Somtum/
 */
if (!defined('BASE_PATH')) {
    if (empty($_SERVER['CONTEXT_DOCUMENT_ROOT'])) {
        define('BASE_PATH', str_replace($docRoot, '', APP_PATH));
    } else {
        $basePath = str_replace($_SERVER['CONTEXT_DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_NAME']));
        if (DIRECTORY_SEPARATOR != '/') {
            $basePath = str_replace('\\', '/', $basePath);
        }
        define('BASE_PATH', rtrim($basePath, '/').'/');
    }
}
/*
 * URL ของเว็บไซต์รวม path เช่น http://domain.tld/folder
 */
if (!defined('WEB_URL')) {
    define('WEB_URL', $scheme.$host.$contextPrefix.str_replace($docRoot, '', ROOT_PATH));
}
/**
 * ฟังก์ชั่นใช้สำหรับสร้างคลาส.
 *
 * @param string $className ชื่อคลาส
 * @param mixed  $param
 *
 * @return \static
 */
function createClass($className, $param = null)
{
    return new $className($param);
}
/**
 * ตรวจสอบและคืนค่าชื่อไฟล์รวมพาธของคลาส.
 *
 * @param string $className
 *
 * @return string|null คืนค่าไฟล์รวมพาธของคลาส ถ้าไม่พบคืนค่า null
 */
function getClassPath($className)
{
    if (preg_match_all('/([\/\\])([a-zA-Z]+)/', $className, $match)) {
        $className = ROOT_PATH.implode(DIRECTORY_SEPARATOR, $match[1]).'.php';
        if (is_file($className)) {
            return $className;
        } elseif (isset($match[1][2])) {
            $className = 'Modules'.DIRECTORY_SEPARATOR.$match[1][0].DIRECTORY_SEPARATOR.$match[1][2].'s'.DIRECTORY_SEPARATOR.$match[1][1].'.php';
            if (is_file(APP_PATH.$className)) {
                return APP_PATH.$className;
            } elseif (is_file(ROOT_PATH.$className)) {
                return ROOT_PATH.$className;
            }
        } else {
            $className = APP_PATH.implode(DIRECTORY_SEPARATOR, $match[1]).'.php';
            if (is_file($className)) {
                return $className;
            }
        }
    }

    return null;
}
/*
 * โหลดคลาสโดยอัตโนมัติตามชื่อของ Classname เมื่อมีการเรียกใช้งานคลาส
 * PSR-4
 *
 * @param string $className
 */
spl_autoload_register(function ($className) {
    $file = getClassPath($className);
    if ($file !== null) {
        require $file;
    }
});

/**
 * โหลดคลาสเริ่มต้น.
 */
require VENDOR_DIR.'Base.php';
require VENDOR_DIR.'Config.php';
require VENDOR_DIR.'Router.php';
require VENDOR_DIR.'Http/Request.php';
require VENDOR_DIR.'Somtum.php';
require VENDOR_DIR.'Controller.php';
