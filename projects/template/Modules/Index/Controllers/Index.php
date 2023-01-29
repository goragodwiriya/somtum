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
     */
    public function index()
    {
        // เรียกใช้งาน Template ค่าเริ่มต้น หรือ skin/default
        \Somtum\Template::init('skin/'.self::$cfg->skin);
        // โหลด Template index.html
        $template = \Somtum\Template::create('', '', 'index');
        // แอเรย์เก็บตัวแปรของ Template
        $contents = array(
            '/{TITLE}/' => 'ตัวอย่าง',
            '/{CONTENT}/' => 'Hello world!',
        );
        // // แทนที่เนื่อหาที่ต้องการลงใน Template และแสดงผล
        echo $template->pregReplace(array_keys($contents), array_values($contents), $template->render());
    }
}
