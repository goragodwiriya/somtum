<?php
/**
 * @filesource Somtum/Controller.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Somtum;

/**
 * Controller base class.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Somtum\Base
{
    /**
     * View.
     *
     * @var \Somtum\View
     */
    public static $view;
    /**
     * เก็บคลาสของเมนูที่เลือก
     *
     * @var string
     */
    public $menu;
    /**
     * ข้อความไตเติลบาร์.
     *
     * @var string
     */
    public $title;
    /**
     * เนื้อหา.
     *
     * @var string
     */
    public $detail;
    /**
     * เนื้อหา.
     *
     * @var string
     */
    public $description;
    /**
     * เนื้อหา.
     *
     * @var string
     */
    public $keywords;
    /**
     * URL หน้าที่เรียก
     *
     * @var string
     */
    public $canonical = null;
    /**
     * สถานะของเพจ
     * 200 ปกติ
     * 404 ไม่พบ.
     *
     * @var int
     */
    public $status = 200;
    /**
     * Menu Controller.
     *
     * @var \Somtum\Controller
     */
    protected static $menus;

    /**
     * init Class.
     */
    public function __construct()
    {
        // ค่าเริ่มต้นของ Controller
        $this->title = strip_tags(self::$cfg->web_title);
        $this->keywords = $this->title;
        $this->description = $this->title;
        $this->menu = 'home';
        $this->canonical = WEB_URL;
    }

    /**
     * ชื่อเมนูที่เลือก
     *
     * @return string
     */
    public function menu()
    {
        return $this->menu;
    }

    /**
     * ข้อความ title bar.
     *
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * คืนค่า URL ของหน้าที่เลือก
     *
     * @return string
     */
    public function canonical()
    {
        return $this->canonical;
    }

    /**
     * คืนค่าสถานะของเพจ เช่น
     * 200 สำเร็จ
     * 404 ไม่พบ.
     *
     * @return int
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * คืนค่าเนื้อหา.
     *
     * @return string
     */
    public function detail()
    {
        return $this->detail;
    }

    /**
     * คืนค่า description.
     *
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * คืนค่า keywords.
     *
     * @return string
     */
    public function keywords()
    {
        return $this->keywords;
    }
}
