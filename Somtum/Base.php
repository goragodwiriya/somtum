<?php

/**
 * @filesource Somtum/Base.php
 *
 * Class แม่ของระบบ
 * Class ส่วนใหญ่จะสืบทอดมาจาก Class นี้
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Somtum;

/**
 * Somtum base class.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Base
{
    /**
     * Config class.
     *
     * @var Config
     */
    protected static $cfg;

    /**
     * Server request class.
     *
     * @var Somtum\Http\Request
     */
    protected static $request;
}
