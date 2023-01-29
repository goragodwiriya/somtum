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
     * เรียกใช้งาน defaultController.
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        echo createClass('Index\Index\View')->render();
    }
}
