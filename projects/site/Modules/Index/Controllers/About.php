<?php
/**
 * @filesource Modules/Index/Controllers/About.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\About;

use Somtum\Template;

/*
 * แสดงผลหน้า about
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */

class Controller extends \Somtum\Controller
{
    /**
     * หน้า About.
     *
     * @return \static
     */
    public function execute()
    {
        $this->title = 'เกี่ยวกับเว็บไซต์';
        $this->description = 'เกี่ยวกับเว็บไซต์';
        $this->keywords = 'เกี่ยวกับเว็บไซต์';
        $this->menu = 'about';
        // โหลด home.html
        $this->detail = Template::load('', '', 'about');

        return $this;
    }
}
