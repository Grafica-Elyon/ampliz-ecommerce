<?php

namespace MisterPrint\BO;

class FranquiaUtil
{
    public static function getIdFranquia()
    {
        return isset($_SESSION['app_franquia']) ? $_SESSION['app_franquia'] : config("app", "franquia");
    }
}
