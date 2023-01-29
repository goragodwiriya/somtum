<?php
/**
 * @filesource Somtum/Menu.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Somtum;

/**
 * คลาสสำหรับแสดงผลเมนูมาตรฐานของ Somtum.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Menu
{
    /**
     * รายการเมนู.
     *
     * @var array
     */
    protected $menus;

    /**
     * สร้าง Object สำหรับจัดการเมนู.
     *
     * @param array $menus รายการเมนู
     *
     * @return \static
     */
    public static function init($menus)
    {
        $obj = new static();
        // โหลดเมนู
        $obj->menus = $menus;
        return $obj;
    }

    /**
     * เมนูรายการแรก (หน้าหลัก).
     *
     * @return string
     */
    public function home()
    {
        $keys = array_keys($this->menus);
        return reset($keys);
    }

    /**
     * แสดงผลเมนู.
     *
     * @param string $select รายการเมนูที่ถูกเลือก
     *
     * @return string
     */
    public function render($select)
    {
        $contents = array();
        $this->execute($this->menus, $select, $contents);

        return implode('', $contents);
    }

    /**
     * สร้างเมนู.
     *
     * @param array  $menus    รายการเมนูลำดับที่จะสร้าง
     * @param string $select   รายการเมนูถูกเลือก
     * @param array  $contents ตัวแปรเก็บรายการเมนู
     */
    protected function execute($menus, $select, &$contents)
    {
        foreach ($menus as $alias => $values) {
            if (isset($values['submenus'])) {
                $contents[] = $this->getItem($alias, $values, true, $select).'<ul>';
                $contents[] = $this->execute($values['submenus'], $select, $contents);
                $contents[] = '</ul>';
            } else {
                $contents[] = $this->getItem($alias, $values, false, $select).'</li>';
            }
        }
    }

    /**
     * ฟังก์ชั่น แปลงเป็นรายการเมนู
     * คืนค่า HTML ของเมนู.
     *
     * @param string|int $name   ชื่อเมนู
     * @param array      $item   แอเรย์ข้อมูลเมนู
     * @param bool       $arrow  true แสดงลูกศรสำหรับเมนูที่มีเมนูย่อย
     * @param string     $select ชื่อเมนูที่ถูกเลือก
     *
     * @return string
     */
    protected function getItem($name, $item, $arrow, $select)
    {
        if (empty($name) && !is_int($name)) {
            $c = '';
        } else {
            $c = array($name);
            if ($name == $select) {
                $c[] = 'select';
            }
            $c = ' class="'.implode(' ', $c).'"';
        }
        if (!empty($item['url'])) {
            $a = array('href="'.$item['url'].'"');
            if (!empty($item['target'])) {
                $a[] = 'target="'.$item['target'].'"';
            }
        }
        if (!empty($item['text'])) {
            $a[] = 'title="'.$item['text'].'"';
        }
        $a = isset($a) ? ' '.implode(' ', $a) : '';
        if ($arrow) {
            return '<li'.$c.'><span class=menu-arrow'.$a.'><span>'.(empty($item['text']) ? '&nbsp;' : htmlspecialchars_decode($item['text'])).'</span></span>';
        } else {
            return '<li'.$c.'><a'.$a.'><span>'.(empty($item['text']) ? '&nbsp;' : htmlspecialchars_decode($item['text'])).'</span></a>';
        }
    }
}
