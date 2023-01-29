<?php
/**
 * @filesource Modules/Index/Controllers/Index.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Index;

use Somtum\Http\Request;

/**
 * default Controller.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Somtum\Controller
{
    /**
     * แสดงผล.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        // รับค่า URL ที่ต้องการ ถ้าไม่มีใช้ index
        $module = strtolower($request->get('module', 'index'));
        // ตรวจสอบ template ที่เลือก
        if (file_exists('Modules/Index/Views/'.$module.'.html')) {
            // โหลด $module.html
            $template = file_get_contents('Modules/Index/Views/'.$module.'.html');
        } else {
            // ถ้าไม่มีใช้ index.html
            $template = file_get_contents('Modules/Index/Views/index.html');
        }
        // คืนค่า HTML template
        echo $template;
    }
}
