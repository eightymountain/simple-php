<?php


namespace Lib;


class Layout
{
    public const VIEW_PATH = 'pages';
    public const VIEW_LAYOUT_PATH = 'layout';

    public static function head()
    {
        require join(DIRECTORY_SEPARATOR, [__ROOT__, self::VIEW_PATH, self::VIEW_LAYOUT_PATH, 'head.php']);
    }

    public static function foot()
    {
        require join(DIRECTORY_SEPARATOR, [__ROOT__, self::VIEW_PATH, self::VIEW_LAYOUT_PATH, 'foot.php']);
    }

}