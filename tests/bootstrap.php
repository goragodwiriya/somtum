<?php
/**
 * tests/bootstrap.php.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 * @copyright 2015 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['DOCUMENT_ROOT'] = dirname(dirname(__FILE__)).'/';
// ตัวแปรที่จำเป็นสำหรับ Framework ใช้ระบุ root folder
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
// ตัวแปรที่จำเป็นสำหรับ Framework ใช้ระบุ root folder
define('BASE_PATH', '/');
// load Somtum
include ROOT_PATH.'Somtum/load.php';
// start application for testing
Somtum::createWebApplication();
