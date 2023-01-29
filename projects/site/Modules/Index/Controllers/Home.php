<?php
/**
 * @filesource Modules/Index/Controllers/Home.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Home;

use Somtum\Template;

/*
 * แสดงผลหน้า home
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */

class Controller extends \Somtum\Controller
{
    /**
     * หน้า Home.
     *
     * @return \static
     */
    public function execute()
    {
        $this->title = 'หน้าหลักเว็บไซต์';
        $this->description = 'หน้าหลักเว็บไซต์';
        $this->keywords = 'หน้าหลักเว็บไซต์';
        $this->menu = 'home';
        // โหลด home.html
        $this->detail = Template::load('', '', 'home');

        return $this;
    }
}
