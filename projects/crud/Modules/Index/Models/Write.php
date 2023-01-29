<?php
/**
 * @filesource Modules/Index/Models/Write.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Index\Write;

use Somtum\Http\Request;

/**
 * Model สำหรับหน้า Write.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Somtum\Model
{
    /**
     * คืนค่ารายการที่ $id.
     *
     * @param int $id
     *
     * @return array
     */
    public static function get($id)
    {
        $db = new \App\Db();
        // SELECT * FROM `gcms_index` WHERE `id`=:id LIMIT 1

        return $db->first('index', array('id' => $id));
    }

    /**
     * รับค่า submit จากฟอร์ม
     *
     * @param Request $request
     */
    public function submit(Request $request)
    {
        // ตรวจสอบว่าเรียกมาจากไซต์ตัวเองหรือไม่
        if ($request->isReferer()) {
            // ตรวจสอบว่ามีอะไรส่งมาบ้าง
            //var_dump($_POST);
            $save = array(
                'title' => $request->post('title'),
                'keywords' => $request->post('keywords'),
                'description' => $request->post('description'),
                'detail' => $request->post('detail'),
            );
            // connect database
            $db = new \App\Db();
            // ตรวจสอบรายการที่แก้ไข
            $search = $db->first('index', array('id' => (int) $request->post('id')));
            if ($search) {
                // บันทึกการแก้ไข
                //$db->edit('index', $search->id, $save);
                // ตรวจสอบว่ามีอะไรส่งมาบ้าง
                var_dump($save);
                // คืนค่า
                echo 'บันทึกเรียบร้อย';
            } else {
                echo 'ไม่พบรายการที่เลือก';
            }
        } else {
            echo 'File Not Found!';
        }
    }
}
