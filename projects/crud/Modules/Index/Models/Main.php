<?php
/**
 * @filesource Modules/Index/Models/Main.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Main;

/**
 * Model สำหรับหน้า Main.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Somtum\Model
{
    /**
     * ค้นหาหน้าเพจสำหรับแสดงผล.
     *
     * @param string $page
     *
     * @return array
     */
    public static function get($page)
    {
        // เรียกใช้งาน คลาสภายนอก
        $db = new \App\Db();
        // SELECT * FROM `gcms_index` WHERE `page`=:page LIMIT 1

        return $db->first('index', array('page' => $page));
    }
}
