<?php
/**
 * @filesource Modules/Index/Views/Index.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Index;

/*
 * default View
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */

class View extends \Somtum\View
{
    /**
     * แสดงผลหน้า Welcome.
     *
     * @return string
     */
    public function render()
    {
        $content = '<html style="height:100%;width:100%"><head>';
        $content .= '<meta charset=utf-8>';
        $content .= '<link href="https://fonts.googleapis.com/css?family=Unica+One" rel="stylesheet">';
        $content .= '<meta name=viewport content="width=device-width, initial-scale=1.0">';
        $content .= '<style>';
        $content .= '.warper{display:inline-block;text-align:center;height:50%;}';
        $content .= '.warper::before{content:"";display:inline-block;height:100%;vertical-align:middle;width:0px;}';
        $content .= '</style>';
        $content .= '</head><body style="height:100%;width:100%;margin:0;font-family:\'Unica One\', cursive, Tahoma, Loma;color:#666;">';
        $content .= '<div class=warper style="display:block"><div class="warper"><div>';
        $content .= '<h1 style="line-height:1;margin:0;text-shadow:3px 3px 0 rgba(0,0,0,0.1);font-weight:normal;font-size:80px;">SOMTUM</h1>';
        $content .= 'PHP Micro Framework';
        $content .= '</div></div></body></html>';

        return $content;
    }
}
