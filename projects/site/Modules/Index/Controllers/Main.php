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
     * ตรวจสอบหน้าที่เรียก และส่งต่อการทำงานไปยังโมดูลที่เกี่ยวข้อง.
     *
     * @param Request $request
     */
    public function execute(Request $request)
    {
        // รับค่าจาก $_GET['module']ถ้าไม่มีคืนค่า home
        $module = $request->get('module', 'home');
        // ชื่อคลาสที่ต้องการ เช่น Index\Home\Controller
        $className = 'Index\\'.ucfirst($module).'\\Controller';
        if (preg_match('/^[a-z]+$/i', $module) && class_exists($className)) {
            // ประมวลผลหน้าที่เรียก
            return createClass($className)->execute($request);
        }
        // ไม่พบคืนค่าหน้า Home

        return createClass('Index\Home\Controller')->execute($request);
    }
}
