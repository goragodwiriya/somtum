<?php
/**
 * @filesource Modules/Index/Controllers/Main.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Main;

use Somtum\Http\Request;

/**
 * Controller หลักสำหรับตรวจสอบหน้าที่เรียก
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Somtum\Controller
{
    /**
     * ตรวจสอบหน้าที่เรียกจากฐานข้อมูล.
     *
     * @param Request $request
     */
    public function execute(Request $request)
    {
        // รับค่าจาก $_GET[module] ถ้าไม่มีคืนค่า home
        $module = $request->get('module', 'home');
        if ($module === 'write') {
            // หน้าแก้ไขข้อมูล
            return createClass('Index\Write\Controller')->execute($request);
        } else {
            // หน้าแสดงข้อมูล
            $page = \Index\Main\Model::get($module);
            if ($page) {
                $this->title = $page->title;
                $this->description = $page->description;
                $this->keywords = $page->keywords;
                $this->detail = $page->detail;
                $this->menu = $module;
                // คืนค่า Controller และข้อมูลจากฐานข้อมูล

                return $this;
            }
        }

        // 404 Page Not Found

        return createClass('Index\Error\Controller')->execute();
    }
}
