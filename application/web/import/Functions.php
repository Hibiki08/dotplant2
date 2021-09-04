<?php
namespace import;

use PDO;
use Exception;

class Functions
{
    public $host;
    public $db;
    public $user;
    public $pass;
    public $charset = 'utf8';
    public $pdo;
    public $productObjectId = 3;
    public $values =
        [
            5 => "Производитель",
            6 => "Артикул производителя",
            7 => "Цена (Розница)",
            8 => "Цена (Опт)",
            9 => "Можно купить",
            10 => "На складе",
            11 => "Время отгрузки",
            12 => "Размер",
            13 => "Цвет",
            14 => "aID",
            15 => "Материал",
            16 => "Батарейки",
            17 => "Упаковка",
            18 => "Вес (брутто)",
            25 => "Штрихкод",
        ];

    public function __construct()
    {
        if (file_exists('../db-local.php')) {
            include '../db-local.php';
            $this->host = $host;
            $this->db = $db;
            $this->user = $user;
            $this->pass = $pass;
        } else {
            $this->host = 'localhost';
            $this->db  = 'dotplant2';
            $this->user = 'root';
            $this->pass = '';
        }

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);
    }

    public function slugHelper($name)
    {
        return str_replace('-', '_', $this->createSlug($name));
    }

    public function createSlug($source)
    {
        $source = mb_strtolower($source);
        $translateArray = [
            "ый" => "y", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "c", "ч" => "ch" ,"ш" => "sh", "щ" => "sch", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "-", "." => "", "/" => "-", "_" => "-"
        ];
        $source = preg_replace('#[^a-z0-9\-]#is', '', strtr($source, $translateArray));
        return trim(preg_replace('#-{2,}#is', '-', $source));
    }

    public function trimPlain($text, $length = 150, $dots = '...')
    {
        if (!is_string($text) && empty($text)) {
            return "";
        }
        $length = intval($length);
        $text = trim(strip_tags($text));
        $pos = mb_strrpos(mb_substr($text, 0, $length), ' ');
        $string = mb_substr($text, 0, $pos);
        if (!empty($string)) {
            return $string.$dots;
        } else {
            return "";
        }
    }

    public function urlImage($url)
    {
        $urlData = explode('/', $url);

        return $urlData[count($urlData)-1];
    }
}