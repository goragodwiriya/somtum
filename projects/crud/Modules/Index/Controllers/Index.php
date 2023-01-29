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
use Somtum\Template;

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
        // เริ่มต้นการใช้งาน Template
        Template::init('skin/'.self::$cfg->skin);
        // โหลดเมนู
        $menus = \Somtum\Menu::init(\Index\Menu\Model::getMenus());
        // Controller หลัก
        $page = createClass('Index\Main\Controller')->execute($request);
        // สร้าง View
        $view = new \Somtum\View();
        // Meta
        $view->setMetas(array(
            'description' => '<meta name=description content="'.$page->description().'" />',
            'keywords' => '<meta name=keywords content="'.$page->keywords().'" />',
        ));
        // แทนที่ลงใน template
        $view->setContents(array(
            // เมนู
            '/{MENUS}/' => $menus->render($page->menu()),
            // web title
            '/{TITLE}/' => $page->title(),
            // โหลดหน้าที่เลือก (html)
            '/{CONTENT}/' => $page->detail(),
        ));
        // ส่งออกเป็น HTML
        echo $view->renderHTML();
    }
}
