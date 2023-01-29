<?php
/**
 * @filesource Modules/Index/Controllers/Write.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Write;

use Somtum\Http\Request;

/**
 * Controller สำหรับการแก้ไขข้อมูล.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Somtum\Controller
{
    /**
     * แก้ไขข้อมูล.
     *
     * @param Request $request
     */
    public function execute(Request $request)
    {
        // ID ที่ต้องการ ตัวเลขเท่านั้น
        $id = (int) $request->get('id');
        // ตรวจสอบรายการที่เลือก
        $page = \Index\Write\Model::get($id);
        if ($page) {
            $this->title = 'แก้ไข '.$page->title;
            $this->description = $this->title;
            $this->keywords = $this->title;
            $this->detail = createClass('Index\Write\View')->render($page);
            $this->menu = $page->page;

            return $this;
        }

        // 404 Page Not Found

        return createClass('Index\Error\Controller')->execute();
    }
}
