<?php
/**
 * @filesource Modules/Index/Models/Menu.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Menu;

/**
 * Model สำหรับจัดการเมนู.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model
{
    /**
     * รายการเมนู.
     *
     * @param array $login
     *
     * @return array
     */
    public static function getMenus($login = null)
    {
        return array(
            'home' => array(
                'text' => 'หน้าหลัก',
                'url' => 'index.php',
            ),
            'about' => array(
                'text' => 'เกี่ยวกับเรา',
                'url' => 'index.php?module=about',
            ),
        );
    }
}
