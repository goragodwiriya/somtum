<?php
/**
 * @filesource projects/site/index.php.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */
/**
 * 0 default
 * 2 แสดงผลข้อผิดพลาดและคำเตือนออกทางหน้าจอ (ใช้เฉพาะตอนออกแบบเท่านั้น).
 */
define('DEBUG', 0);

// load Somtum
include '../../Somtum/load.php';
// Initial Somtum Framework
Somtum::createWebApplication()->run();
