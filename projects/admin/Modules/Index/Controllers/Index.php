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

use Index\Login\Model as Login;
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
        // session cookie
        $request->initSession();
        // ตรวจสอบการ login
        Login::create();
        if (Login::isMember()) {
            // เข้าระบบแล้ว แสดงข้อมูลจาก $_SESSION
            echo '<a href="?action=logout">Logout</a><br>';
            var_dump($_SESSION);
        } else {
            // แสดงฟอร์ม forgot หรือ login
            $action = $request->get('action');
            // ตรวจสอบ $action ต้องเป็น forgot หรือ login เท่านั้น
            $action = $action === 'forgot' ? 'forgot' : 'login';
            // โหลดไฟล์ใน Views มาแสดงผล
            echo file_get_contents(APP_PATH.'Modules/Index/Views/'.$action.'.html');
        }
    }
}
