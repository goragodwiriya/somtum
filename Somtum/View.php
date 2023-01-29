<?php
/**
 * @filesource Somtum/View.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace Somtum;

/**
 * View base class.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Somtum\Base
{
    /**
     * ตัวแปรเก็บเนื่อหาของเว็บไซต์ ที่จะแทนที่หลังจาก render แล้ว.
     *
     * @var array
     */
    protected $after_contents = array();

    /**
     * ตัวแปรเก็บเนื่อหาของเว็บไซต์.
     *
     * @var array
     */
    protected $contents = array();

    /**
     * รายการ header.
     *
     * @var array
     */
    protected $headers = array();

    /**
     * meta tag.
     *
     * @var array
     */
    protected $metas = array();

    /**
     * คำสั่ง Javascript ที่จะแทรกไว้ใน head.
     *
     * @var array
     */
    protected $script = array();

    /**
     * ใส่ไฟล์ CSS ลงใน header.
     *
     * @param string $url
     */
    public function addCSS($url)
    {
        $this->metas[$url] = '<link rel=stylesheet href="'.$url.'">';
    }

    /**
     * ใส่ไฟล์ Javascript ลงใน header.
     *
     * @param string $url
     */
    public function addJavascript($url)
    {
        $this->metas[$url] = '<script src="'.$url.'"></script>';
    }

    /**
     * เพิ่มคำสั่ง Javascript ใส่ลงใน head ก่อนปิด head.
     *
     * @param string $script
     */
    public function addScript($script)
    {
        $this->script[] = $script;
    }

    /**
     * ส่งออกเนื้อหา และ header ตามที่กำหนด.
     *
     * @param string $content เนื้อหา
     */
    public function output($content)
    {
        // send header
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        // output content
        echo $content;
    }

    /**
     * ส่งออกเป็น HTML.
     *
     * @param string|null $template HTML Template ถ้าไม่กำหนด (null) จะใช้ index.html
     */
    public function renderHTML($template = null)
    {
        // default for template
        $this->contents['/{WEBTITLE}/'] = self::$cfg->web_title;
        $this->contents['/{WEBDESCRIPTION}/'] = self::$cfg->web_description;
        $this->contents['/{WEBURL}/'] = WEB_URL;
        $this->contents['/{SKIN}/'] = Template::get();
        foreach ($this->after_contents as $key => $value) {
            $this->contents[$key] = $value;
        }
        $head = '';
        if (!empty($this->metas)) {
            $head .= implode("\n", $this->metas);
        }
        if (!empty($this->script)) {
            $head .= "<script>\n".implode("\n", $this->script)."\n</script>";
        }
        if ($head != '') {
            $this->contents['/(<head.*)(<\/head>)/isu'] = '$1'.$head.'$2';
        }
        // แทนที่ลงใน Template
        if ($template === null) {
            // ถ้าไม่ได้กำหนดมาใช้ index.html
            $template = Template::load('', '', 'index');
        }

        return Template::pregReplace(array_keys($this->contents), array_values($this->contents), $template);
    }

    /**
     * ใส่เนื้อหาลงใน $contens.
     *
     * @param array $array ชื่อที่ปรากฏใน template รูปแบบ array(key1 => val1, key2 => val2)
     */
    public function setContents($array)
    {
        foreach ($array as $key => $value) {
            $this->contents[$key] = $value;
        }
    }

    /**
     * ใส่เนื้อหาลงใน $contens หลัง render แล้ว.
     *
     * @param array $array ชื่อที่ปรากฏใน template รูปแบบ array(key1 => val1, key2 => val2)
     */
    public function setContentsAfter($array)
    {
        foreach ($array as $key => $value) {
            $this->after_contents[$key] = $value;
        }
    }

    /**
     * กำหนด header ให้กับเอกสาร.
     *
     * @param array $array
     */
    public function setHeaders($array)
    {
        foreach ($array as $key => $value) {
            $this->headers[$key] = $value;
        }
    }

    /**
     * ใส่ Tag ลงใน Head ของ HTML.
     *
     * @param array $array
     */
    public function setMetas($array)
    {
        foreach ($array as $key => $value) {
            $this->metas[$key] = $value;
        }
    }
}
