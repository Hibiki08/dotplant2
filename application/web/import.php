<?php
include 'importFunctions.php';
$import = new \app\web\importFunctions();
$start = (isset($_GET['start']))?$_GET['start']:1;

if (isset($_GET['alterheralter'])) {
    $import->pdo->query('ALTER TABLE `product` CHANGE `slug` `slug` VARCHAR(180)');
    echo 'ok';
    exit;
}

if (isset($_GET['categoryImages'])) {
    chmod($_SERVER['DOCUMENT_ROOT'] . '/files/category', 0777);
    $import->categoryImages();
    echo 'ok';
    exit;
}
/*
if (!isset($_GET['clear'])) {
    echo $import->clearGoods();
    echo 'ok';
    exit;
}
*/

if (isset($_GET['describer'])) {
    $c = $import->pdo->query('DESCRIBE `payment_type`');
//    $res = $c->fetch();
//    print_r($res);
    foreach ($c as $row) {
        echo $row['Field'] . '<br />';
    }
    echo 'ok';
    exit;
}

if (!isset($_GET['stage'])) {
    echo $import->createCategory();
} else {
    echo $import->createSubCategory($start);
}

//var_dump($import->categoryInsert(1,1, "фалосы"));
