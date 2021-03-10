<?php

// Global Function Definition

if ( ! function_exists('chkParams')) {
    function chkParams($params)
    {
        if (gettype($params) !== 'array') {
            return addslashes(trim($params));
        }

        foreach ($params as $key => $value) {
            if (gettype($value) !== 'array') {
                $params[$key] = chkParams($value);
            } else {
                $params[$key] = addslashes(trim($value));
            }
        }

        return $params;
    }
}

if ( ! function_exists('env')) {
    function env($name, $default = '')
    {
        return $_ENV[$name] ?? $default;
    }
}

if ( ! function_exists('dd')) {
    function dd($var)
    {
        $a = var_export($var, true);
        echo "<pre style='position:fixed;top:10px;left:10px;width:100%;height:1000px;z-index:11111;background:white;text-align:left;'>{$a}</pre>";
        exit;
    }
}

if ( ! function_exists('tb')) {
    function tb($tableName)
    {
        return $_ENV['DB_TABLE_PREFIX'] . $tableName;
    }
}
