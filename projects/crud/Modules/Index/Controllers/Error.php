<?php
/**
 * @filesource Modules/Index/Controllers/Home.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Error;

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
        $this->title = '404 Page Not Found!';
        $this->detail = $this->detail;
        $this->description = 'หน้าหลักเว็บไซต์';
        $this->keywords = $this->title;
        $this->menu = 'home';

        return $this;
    }
}
