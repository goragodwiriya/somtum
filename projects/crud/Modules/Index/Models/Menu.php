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
     * @return array
     */
    public static function getMenus()
    {
        return array(
            'home' => array(
                'text' => 'หน้าหลัก',
                'url' => 'index.php',
                'submenus' => array(
                    array(
                        'text' => 'แก้ไข',
                        'url' => 'index.php?module=write&amp;id=1',
                    ),
                ),
            ),
            'about' => array(
                'text' => 'เกี่ยวกับเรา',
                'url' => 'index.php?module=about',
                'submenus' => array(
                    array(
                        'text' => 'แก้ไข',
                        'url' => 'index.php?module=write&amp;id=2',
                    ),
                ),
            ),
        );
    }
}
