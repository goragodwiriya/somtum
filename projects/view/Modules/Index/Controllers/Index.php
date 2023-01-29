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
        // กำหนด skin ให้กับ template
        \Somtum\Template::init('skin/'.self::$cfg->skin);
        // View
        $view = new \Somtum\View();
        // เนื้อหา
        $view->setContents(array(
            '/{TITLE}/' => 'ทดสอบ',
            '/{CONTENT}/' => 'Hello World!',
        ));
        // ส่งออก เป็น HTML
        echo $view->renderHTML();
    }
}
