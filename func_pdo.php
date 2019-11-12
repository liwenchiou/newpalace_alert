<?php

/*
 * PDO数据库操作函数库
 */
if (!function_exists('connect')) {
    /*
     * 数据库连接
     * @param type $dbname
     * @param type $type
     * @param type $host
     * @param type $charset
     * @param type $port
     * @param string $user
     * @param string $pass
     */
    function connect($dbname, $type = 'mysql', $host = '192.168.2.19', $charset = 'utf8', $port = '3306', $user = 'root', $pass = 'admin123')
    {
        $dsn = "{$type}:host={$host};dbname={$dbname};charset={$charset};port={$port}";
        $user = $user;
        $pass = $pass;
        $options = [
            // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //错误模式
            // PDO::ATTR_CASE => PDO::CASE_NATURAL, // 自然名称
            // PDO::ATTR_EMULATE_PREPARES => true, // 启用模拟功能
            // PDO::ATTR_PERSISTENT => true,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            //			echo 'connect ok!';
        } catch (PDOException $e) {
            echo '连接错误'.$e->getMessage();
            die();
        }

        return $pdo;
    }
}
if (!function_exists('insert')) {
    /*
     * 新增数据
     * @param type $pdo
     * @param type $tabname
     * @param type $data
     */
    function insert($pdo, $tabname, $data = [])
    {
        // insert news set title = :title, content = :content;
        $sql = "insert ignore {$tabname} set ";
        foreach (array_keys($data) as $v) {
            $sql .= $v.' =:'.$v.', ';
        }
        $sql = rtrim(trim($sql), ',');
        //		die($sql);
        $stmt = $pdo->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->bindValue(":{$k}", $v);
        }
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('update')) {
    /*
     * 更新数据
     * @param type $pdo
     * @param type $tabname
     * @param type $data
     * @param type $where
     */
    function update($pdo, $tabname, $data = [], $where = '')
    {
        // update news set title = :title, content = :content where id = 1
        $sql = "update $tabname set ";
        foreach (array_keys($data) as $v) {
            $sql .= $v.' = :'.$v.', ';
        }
        $sql = rtrim(trim($sql), ',');
        if (!empty($where)) {
            $sql .= ' where '.$where;
        } else {
            exit('条件不能为空');
        }
        $stmt = $pdo->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->bindValue(":{$k}", $v);
        }
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('find')) {
    /*
     * 查询单条记录
     * @param type $pdo
     * @param type $tabname
     * @param type $fields
     * @param type $where
     */
    function find($pdo, $tabname, $fields, $where = '')
    {
        $sql = 'select ';
        if (is_array($fields)) {
            foreach ($fields as $v) {
                $sql .= $v.',';
            }
        } else {
            $sql .= $fields.',';
        }
        $sql = rtrim(trim($sql), ',');
        $sql .= " from $tabname ";
        if (!empty($where)) {
            $sql .= ' where '.$where;
        }
        $sql .= ' limit 1';
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //				$stmt->setFetchMode(PDO::FETCH_ASSOC);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('select')) {
    /*
     * 查询多条记录
     * @param type $pdo
     * @param type $tabname
     * @param type $fields
     * @param type $where
     * @param type $order
     * @return boolean
     */
    function select($pdo, $tabname, $fields, $where = '', $order = '')
    {
        $sql = 'select ';
        if (is_array($fields)) {
            foreach ($fields as $v) {
                $sql .= $v.',';
            }
        } else {
            $sql .= $fields.',';
        }
        $sql = rtrim(trim($sql), ',');
        $sql .= " from $tabname ";
        if (!empty($where)) {
            $sql .= ' where '.$where;
        }
        if (!empty($order)) {
            $sql .= ' order by '.$order;
        }

        $stmt = $pdo->prepare($sql);
        // die($stmt->queryString);  //查看sql语句
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                //				$stmt->setFetchMode(PDO::FETCH_ASSOC);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('delete')) {
    /*
     * 删除一条记录
     * @param type $pdo
     * @param type $tabname
     * @param type $where
     */
    function delete($pdo, $tabname, $where)
    {
        $sql = "delete from $tabname ";
        if (!empty($where)) {
            $sql .= 'where '.$where;
        } else {
            exit('条件不能为空');
        }
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }
}
