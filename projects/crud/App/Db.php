<?php
/**
 * @filesource App/Db.php
 *
 * @copyright 2018 Goragod.com
 * @license https://somtum.kotchasan.com/license/
 *
 * @see https://somtum.kotchasan.com/
 */

namespace App;

/*
 * PDO MySql Database Class (CRUD)
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */

class Db extends \Somtum\Model
{
    /**
     * @var mixed
     */
    private $connection;
    /**
     * @var mixed
     */
    private $error;

    /**
     * create database connection.
     *
     * @return bool
     */
    public function __construct()
    {
        // pdo options
        $options = array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        // pdo connect
        try {
            // connection string
            $sql = 'mysql:host='.self::$cfg->hostname.';dbname='.self::$cfg->dbname;
            // connect to database
            $this->connection = new \PDO($sql, self::$cfg->username, self::$cfg->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * ค้นหาข้อมูลที่กำหนดเองเพียงรายการเดียว
     * พบคืนค่ารายการที่พบเพียงรายการเดียว ไม่พบหรือมีข้อผิดพลาดคืนค่า false.
     *
     * @param string $table      ชื่อตาราง
     * @param array  $conditions ข้อความที่ต้องการค้นหา array(column => value, column => value)
     *
     * @return object|bool
     */
    public function first($table, $conditions)
    {
        $result = $this->search($table, $conditions, 1);
        if (is_array($result) && sizeof($result) == 1) {
            return $result[0];
        }

        return false;
    }

    /**
     * ค้นหาข้อมูลที่กำหนดเอง
     * คืนค่ารายการที่พบ (array) มีข้อผิดพลาดคืนค่า false.
     *
     * @param string $table      ชื่อตาราง
     * @param array  $conditions ข้อความที่ต้องการค้นหา array(column => value, column => value)
     * @param int    $limit      จำนวนผลลัพท์ที่ต้องการ ค่าเริ่มต้น หมายถึงคืนค่าทุกรายการ
     * @param int    $start      ข้อมูลเริ่มต้นที่ต้องการ ค่าเริ่มต้น หมายถึงคืนค่าตั้งแต่รายการแรก
     *
     * @return array|bool
     */
    public function search($table, $conditions, $limit = 0, $start = 0)
    {
        $keys = array();
        $datas = array();
        foreach ($conditions as $field => $value) {
            if (is_array($value)) {
                $keys[] = "`$field` IN :$field";
                $datas[":$field"] = $value;
            } else {
                $keys[] = "`$field`=:$field";
                $datas[":$field"] = $value;
            }
        }
        try {
            $sql = 'SELECT * FROM `'.self::$cfg->prefix.'_'.$table.'` WHERE '.implode(' OR ', $keys);
            if ($start > 0 && $limit > 0) {
                $sql .= ' LIMIT '.$start.','.$limit;
            } elseif ($limit > 0) {
                $sql .= ' LIMIT '.$limit;
            }
            $query = $this->connection->prepare($sql);
            $query->execute($datas);
            $result = array();
            if ($query) {
                while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
                    $result[] = $row;
                }
            }
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            $result = false;
        }

        return $result;
    }

    /**
     * ฟังก์ชั่นเพิ่มข้อมูลใหม่ลงในตาราง
     * สำเร็จ คืนค่า id ที่เพิ่ม, ผิดพลาด คืนค่า false.
     *
     * @param string $table ชื่อตาราง
     * @param array  $save  ข้อมูลที่ต้องการบันทึก array(column => value, column => value)
     *
     * @return int|bool
     */
    public function add($table, $save)
    {
        try {
            $keys = array();
            $values = array();
            foreach ($save as $key => $value) {
                $keys[] = $key;
                $values[":$key"] = $value;
            }
            $sql = 'INSERT INTO `'.self::$cfg->prefix.'_'.$table.'` (`'.implode('`,`', $keys);
            $sql .= '`) VALUES (:'.implode(',:', $keys).');';
            $query = $this->connection->prepare($sql);
            $query->execute($values);

            return $this->connection->lastInsertId();
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();

            return false;
        }
    }

    /**
     * แก้ไขข้อมูล
     * สำเร็จ คืนค่า true.
     *
     * @param string    $table ชื่อตาราง
     * @param array|int $idArr id ที่ต้องการแก้ไข หรือข้อความค้นหารูปแอเรย์ [filed=>value]
     * @param array     $save  ข้อมูลที่ต้องการบันทึก
     *
     * @return bool
     */
    public function edit($table, $idArr, $save)
    {
        try {
            $keys = array();
            $values = array();
            foreach ($save as $key => $value) {
                $keys[] = "`$key`=:$key";
                $values[":$key"] = $value;
            }
            if (is_array($idArr)) {
                $datas = array();
                foreach ($idArr as $key => $value) {
                    $datas[] = "`$key`=:$key";
                    $values[":$key"] = $value;
                }
                $where = sizeof($datas) == 0 ? '' : implode(' AND ', $datas);
            } else {
                $id = (int) $idArr;
                $where = $id == 0 ? '' : '`id`=:id';
                $values[':id'] = $id;
            }
            if ($where == '' || sizeof($keys) == 0) {
                return false;
            } else {
                $sql = 'UPDATE `'.self::$cfg->prefix.'_'.$table.'` SET '.implode(',', $keys).' WHERE '.$where.' LIMIT 1';
                $query = $this->connection->prepare($sql);
                $query->execute($values);

                return true;
            }
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();

            return false;
        }
    }

    /**
     * ลบข้อมูล
     * สำเร็จ คืนค่า true.
     *
     * @param string    $table ชื่อตาราง
     * @param array|int $idArr id ที่ต้องการลบ หรือข้อความค้นหารูปแอเรย์ [filed=>value]
     * @param int       $limit จำนวนรายการที่ต้องการลบ ลบทุกลายการที่พบ , มากกว่า (ค่าเริ่มต้น 1) ลบตามจำนวนที่เลือก
     *
     * @return bool
     */
    public function delete($table, $idArr, $limit = 1)
    {
        try {
            $values = array();
            if (is_array($idArr)) {
                $datas = array();
                foreach ($idArr as $key => $value) {
                    $datas[] = "`$key`=:$key";
                    $values[":$key"] = $value;
                }
                $where = sizeof($datas) == 0 ? '' : implode(' AND ', $datas);
            } else {
                $id = (int) $idArr;
                $where = $id == 0 ? '' : '`id`=:id';
                $values[':id'] = $id;
            }
            if ($where == '' || sizeof($keys) == 0) {
                return false;
            } else {
                $sql = 'DELETE FROM `'.self::$cfg->prefix.'_'.$table.'` WHERE '.$where;
                if ($limit > 0) {
                    $sql .= ' LIMIT '.$limit;
                }
                $query = $this->connection->prepare($sql);
                $query->execute($values);

                return true;
            }
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();

            return false;
        }
    }

    /**
     * ประมวลผลคำสั่ง SQL ที่ไม่ต้องการผลลัพท์ เช่น CREATE INSERT UPDATE
     * สำเร็จ คืนค่าจำนวนแถวที่ทำรายการ มีข้อผิดพลาดคืนค่า false.
     *
     * @param string $sql
     *
     * @return int|bool
     */
    public function query($sql)
    {
        try {
            $this->error = '';
            $query = $this->connection->query($sql);

            return $query->rowCount();
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();

            return false;
        }
    }

    /**
     * ประมวลผลคำสั่ง SQL สำหรับสอบถามข้อมูล คืนค่าผลลัพท์เป็นแอเรย์ของข้อมูลที่ตรงตามเงื่อนไข
     * คืนค่าผลการทำงานเป็น record ของข้อมูลทั้งหมดที่ตรงตามเงื่อนไข ไม่พบข้อมูลคืนค่าเป็น array ว่างๆ ผิดพลาดคืนค่า false.
     *
     * @param string $sql query string
     *
     * @return array|bool
     */
    public function customQuery($sql)
    {
        try {
            $this->error = '';
            $query = $this->connection->query($sql);
            $result = array();
            if ($query) {
                while ($row = $query->fetch(\PDO::FETCH_OBJ)) {
                    $result[] = $row;
                }
            }
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            $result = false;
        }

        return $result;
    }

    /**
     * คืนค่าข้อความผิดพลาด
     * ไม่มี คืนค่าว่าง.
     *
     * @return string
     */
    public function error()
    {
        return $this->error;
    }
}
