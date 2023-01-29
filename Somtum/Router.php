<?php

/**
 * @filesource Somtum/Router.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Somtum;

/**
 * Router class.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Router extends \Somtum\Base
{
    /**
     * กฏของ Router สำหรับการแยกหน้าเว็บไซต์.
     *
     * @var array
     */
    protected $rules = array(
        // index.php/module/<model|controller|view>/folder/_dir/_method
        '/^[a-z0-9]+\.php\/([a-z]+)\/(model|controller|view)(\/([\/a-z0-9_]+)\/([a-z0-9_]+))?$/i' => array('module', '_mvc', '', '_dir', '_method'),
        // module/<model|controller|view>/_dir
        '/([a-z]+)\/(model|controller|view)\/([a-z0-9_]+)/i' => array('module', '_mvc', '_dir'),
        // module, module.php
        '/^([a-z0-9_]+)(\.php)?$/' => array('module'),
    );

    /**
     * Initial Router.
     *
     * @param string $className คลาสที่จะรับค่าจาก Router
     *
     * @throws \InvalidArgumentException หากไม่พบคลาสเป้าหมาย
     *
     * @return \static
     */
    public function init($className)
    {
        // ตรวจสอบโมดูล
        $modules = $this->parseRoutes($_SERVER['REQUEST_URI'], $_GET);
        if (isset($modules['module']) && isset($modules['_mvc']) && isset($modules['_dir'])) {
            // คลาสจาก URL
            $className = str_replace(' ', '\\', ucwords($modules['module'].' '.str_replace(array('\\', '/'), ' ', $modules['_dir']).' '.$modules['_mvc']));
            $method = empty($modules['_method']) ? 'index' : $modules['_method'];
        } elseif (isset($modules['_class']) && isset($modules['_method'])) {
            // ระบุ Class และ Method มาตรงๆ
            // ต้องเขียนกฏของ Router เองให้รัดกุม
            $className = str_replace('/', '\\', $modules['_class']);
            $method = $modules['_method'];
        } else {
            // ไม่ระบุเมธอดมา เรียกเมธอด index
            $method = empty($modules['_method']) ? 'index' : $modules['_method'];
        }
        if (!class_exists($className)) {
            throw new \InvalidArgumentException('Class '.$className.' not found');
        } elseif (method_exists($className, $method)) {
            // สร้างคลาส
            $obj = new $className();
            // เรียกเมธอด
            $obj->$method(self::$request->withQueryParams($modules));
        } else {
            throw new \InvalidArgumentException('Method '.$method.' not found in '.$className);
        }

        return $this;
    }

    /**
     * แยก path คืนค่าเป็น query string.
     *
     * @assert ('/index.php/Index/Model/Index/web?1234', array()) [==] array( '_mvc' => 'Model', '_dir' => 'Index', 'module' => 'Index', '_method' => 'web')
     * @assert ('/index.php/Index/Model/Index/web', array()) [==] array( '_mvc' => 'Model', '_dir' => 'Index', 'module' => 'Index', '_method' => 'web')
     * @assert ('/print.php/Css/View/Index', array()) [==] array( '_mvc' => 'View', '_dir' => 'Index', 'module' => 'Css')
     * @assert ('/index/model/updateprofile.php', array()) [==] array( '_mvc' => 'model', '_dir' => 'updateprofile', 'module' => 'index')
     * @assert ('/index.php/Alias/Model/Admin/Settings/save', array()) [==] array('module' => 'Alias', '_mvc' => 'Model', '_dir' => 'Admin/Settings', '_method' => 'save')
     * @assert ('/css/view/index.php', array()) [==] array('module' => 'css', '_mvc' => 'view', '_dir' => 'index')
     * @assert ('/module.html', array()) [==] array('module' => 'module')
     * @assert ('/index.php', array('_action' => 'one')) [==] array('_action' => 'one')
     * @assert ('/admin_index.php', array('_action' => 'one')) [==] array('_action' => 'one', 'module' => 'admin_index')
     *
     * @param  string   path     เช่น /a/b/c.html
     * @param array $modules query string
     *
     * @return array
     */
    public function parseRoutes($path, $modules)
    {
        // แยก query string ออก
        $path = parse_url(urldecode($path), PHP_URL_PATH);
        $base_path = preg_quote(BASE_PATH, '/');
        // แยกเอาฉพาะ path ที่ส่งมา ไม่รวม path ของ application และ นามสกุล
        if (preg_match('/^'.$base_path.'(.*)(\.html?|\/)$/u', $path, $match)) {
            $my_path = $match[1];
        } elseif (preg_match('/^'.$base_path.'(.*)$/u', $path, $match)) {
            $my_path = $match[1];
        }
        if (!empty($my_path) && !preg_match('/^[a-z0-9]+\.php$/i', $my_path)) {
            $my_path = rawurldecode($my_path);
            foreach ($this->rules as $patt => $items) {
                if (preg_match($patt, $my_path, $match)) {
                    foreach ($items as $i => $key) {
                        if (!empty($key) && isset($match[$i + 1])) {
                            $modules[$key] = $match[$i + 1];
                        }
                    }
                    break;
                }
            }
        }

        return $modules;
    }
}
