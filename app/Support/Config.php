<?php
namespace App\Support;

Class Config {
    public static $Instance;
    protected $Data;
    public static function Init()
    {
       if (static::$Instance == NULL) {
            static::$Instance = new self();
        }
        return static::$Instance;
    }
    public function InitAllConfig($Data)
    {
        $this->Data = $Data;
    }

    public static function getConfig($key = null)
    {
        if ($key) {
            if(!empty(static::$Instance->Data[$key])) return static::$Instance->Data[$key];
            else return false;
        }
        return static::$Instance->Data;
    }
}
