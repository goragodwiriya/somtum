<?php
/**
 * @filesource Modules/Index/Views/Write.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Write;

use Somtum\Template;

/**
 * View สำหรับหน้า Write.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Somtum\View
{
    /**
     * ฟอร์มแก้ไข
     *
     * @param object $page
     *
     * @return string
     */
    public function render($page)
    {
        // โหลดฟอร์ม write.html
        $template = Template::load('', '', 'write');
        // แทนที่ข้อมูลลงใน templlate
        $this->setContents(array(
            '/{TITLE}/' => $page->title,
            '/{KEYWORDS}/' => $page->keywords,
            '/{DESCRIPTION}/' => $page->description,
            '/{DETAIL}/' => $page->detail,
            '/{ID}/' => $page->id,
        ));
        // คืนค่าฟอร์ม HTML

        return $this->renderHTML($template);
    }
}
