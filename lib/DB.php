<?php

namespace Lib;

use PDO;
use PDOException;

/**
 * Class DB
 * PDO wrapper singleton
 * @package Lib
 */
class DB
{
    private static $instance;
    private static $statement;

    // PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION //에러출력
    // PDO::ATTR_ERRMODE=> PDO::ERRMODE_SILENT // 에러 출력하지 않음
    // PDO::ATTR_ERRMODE=> PDO::ERRMODE_WARNING // Warning만 출력
    private static function getInstance()
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    $_ENV['DB_CONNECTION']
                    . ':host=' . $_ENV['DB_HOST']
                    . ';port=' . $_ENV['DB_PORT']
                    . ';dbname=' . $_ENV['DB_DATABASE']
                    . ';charset=utf8mb4',
                    $_ENV['DB_USERNAME'],
                    $_ENV['DB_PASSWORD'],
                    self::getOption()
                );
            } catch (PDOException $e) {
                die('db connection die: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    private static function executeBind($query, $params = null)
    {
        self::$statement = self::getInstance()->prepare($query);

        if ( ! is_null($params) && ! empty($params) && is_array($params)) {
            foreach ($params as $k => $v) {
                if (gettype($v) == 'integer') {
                    self::$statement->bindValue(':' . $k, $v, PDO::PARAM_INT);
                } else {
                    self::$statement->bindValue(':' . $k, $v);
                }
            }
        }

        return self::$statement->execute();
    }

    public static function getOption()
    {
        return [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_FOUND_ROWS => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
    }

    public static function getStatement()
    {
        return self::$statement;
    }

    //get one of row
    public static function first($query, $params = null)
    {
        self::executeBind(self::queryFilter($query), $params);

        return self::$statement->fetch();
    }

    //get Rows

    /**
     * 조회한 데이터를 가져옵니다.
     *
     * @param string $query
     * @param array|null $params
     * @param bool $fetchAll false 이면 ->fetch() 를 이용해 row를 하나씩 가져와야 합니다.
     * @return array
     */
    public static function get($query, $params = null, $fetchAll = true)
    {
        self::executeBind(self::queryFilter($query), $params);

        if ( ! $fetchAll) {
            return self::$statement;
        }

        $rows = self::$statement->fetchAll();

        if (is_array($rows) && count($rows) > 0) {
            return $rows;
        }

        return [];
    }

    public static function insert($query, $params = null)
    {
        return self::executeBind(self::queryFilter($query), $params);
    }

    // TODO:: set, where 조건 분리
    public static function update($query, $params = null)
    {
        return self::executeBind(self::queryFilter($query), $params);
    }

    public static function delete($query, $params = null)
    {
        return self::executeBind(self::queryFilter($query), $params);
    }

    public static function setPdoMode($key, $value)
    {
        self::getInstance()->setAttribute($key, $value);
    }

    public static function beginTransaction()
    {
        self::getInstance()->beginTransaction();
    }

    public static function commit()
    {
        self::getInstance()->commit();
    }

    public static function rollback()
    {
        self::getInstance()->rollback();
    }

    public static function lastInsertId()
    {
        return self::getInstance()->lastInsertId();
    }

    public static function resultCount()
    {
        return self::$statement->rowCount();
    }

    public static function hasError()
    {
        return self::$statement->errorCode() !== '00000';
    }

    public static function errorCode()
    {
        return self::$statement->errorCode();
    }

    public static function multiInsert($tableName, $data)
    {
        //Will contain SQL snippets.
        $rowsSQL = [];

        //Will contain the values that we need to bind.
        $toBind = [];

        //Get a list of column names to use in the SQL statement.
        $columnNames = array_keys($data[0]);

        //Loop through our $data array.
        foreach ($data as $arrayIndex => $row) {
            $params = [];
            foreach ($row as $columnName => $columnValue) {
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue;
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }

        //Construct our SQL statement
        $sql = "INSERT INTO `{$tableName}` ("
            . implode(", ", $columnNames)
            . ') VALUES '
            . implode(", ", $rowsSQL);

        //Prepare our PDO statement.
        self::$statement = self::getInstance()->prepare($sql);

        //Bind our values.
        foreach ($toBind as $param => $val) {
            self::$statement->bindValue($param, $val);
        }

        //Execute our statement (i.e. insert the data).
        return self::$statement->execute();
    }

    private static function queryFilter($query)
    {
        $query = trim(str_replace("\r", " ", $query));

        return $query;
    }

    public static function debugQuery()
    {
        self::$statement->debugDumpParams();
    }
}
