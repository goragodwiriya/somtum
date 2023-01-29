<?php
/**
 * @filesource Modules/Index/Models/Index.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Index;

use Somtum\Http\Request;

/**
 * Model สำหรับรับค่าจาก Ajax.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model
{
    /**
     * โหลดเว็บไซต์ด้วย Ajax.
     *
     * @param Request $request
     *
     * @return string
     */
    public function web(Request $request)
    {
        // ตรวจสอบว่าเรียกมาจากภายในไซต์
        if ($request->isReferer()) {
            // ดูค่าที่ส่งมา
            //print_r($_POST);
            // รับค่า URL ที่ส่งมา
            $url = $request->post('url');
            if (!empty($url) && preg_match('/^http/', $url)) {
                // โหลด URL ที่ส่งมา ต้องขึ้นต้นด้วย http เท่านั้น
                $content = @file_get_contents($url);
                // คืนค่า HTML ไปยัง Ajax
                echo $content;
            }
        }
    }

    /**
     * ส่งข้อมูลไปบันทึกด้วย Ajax.
     *
     * @param Request $request
     */
    public function save(Request $request)
    {
        // ตรวจสอบว่าเรียกมาจากภายในไซต์
        if ($request->isReferer()) {
            // รับค่าจากช่องกรอก text
            $name = $request->post('name');
            if ($name === '') {
                // มีการส่งค่า name เป็นค่าว่างมา
                $ret = array('error' => 'กรุณากรอกข้อความ');
            } elseif ($name !== null) {
                // มีการส่งค่า name มา
                $ret = array('name' => $name);
            } else {
                // รับค่าจากการ POST radio
                $ret = $request->getParsedBody();
            }
            // คืนค่าเป็น JSON
            echo json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * อ่านเวลาจาก Server.
     *
     * @param Request $request
     */
    public function time(Request $request)
    {
        // คืนค่าเวลาปัจจุบันจาก Server
        echo date('H:i:s');
    }
}
