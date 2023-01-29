<?php
/**
 * @filesource Modules/Index/Controllers/Index.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Login;

/**
 * default Controller.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Somtum\Model
{
    /**
     * เมธอดสำหรับตรวจสอบการ Login.
     */
    public static function create()
    {
        $action = self::$request->request('action');
        if ($action === 'logout') {
            // ออกจากระบบ ทำลาย session
            unset($_SESSION['login']);
        } else {
            // ตรวจสอบการเข้าระบบ
            $username = self::$request->post('login_username');
            $password = self::$request->post('login_password');
            if (!empty($username) && !empty($username)) {
                if ($username == self::$cfg->username && $password == self::$cfg->password) {
                    // username + password ถูกต้อง
                    $_SESSION['login']['username'] = self::$cfg->username;
                }
            }
        }
    }

    /**
     * ตรวจสอบการ Login
     * ถ้าเข้าระบบแล้ว คืนค่าข้อมูลการเข้าระบบ
     * ถ้าไม่ใช่คืนค่า null.
     *
     * @return array|null
     */
    public static function isMember()
    {
        return isset($_SESSION['login']) ? $_SESSION['login'] : null;
    }
}
