<?php
require_once 'db.php';

if ($_POST['action'] == 'saveAllowed')
{
    if (!isset($_POST['allow']))
        $currencies = json_encode([]);
    else
        $currencies = json_encode($_POST['allow']);

    $user = $_SESSION['user_login'];

    $data = [
        'rates'=> $currencies,
        'login'=> $user
    ];
    $sql = "UPDATE usersinfo_t SET rates=:rates WHERE login=:login";

    $stmt = $dbh->prepare($sql);

    $stmt->execute($data);
    if ($stmt) {
        if (!isset($_POST['allow'])) {
            print_r('Allowed currencies removed');
        } else {
            print_r('Allowed currencies saved');
        }
    }
} elseif ($_POST['action'] == 'saveUserSelected') {
    if (!isset($_POST['select']))
        $currencies = json_encode([]);
    else
        $currencies = json_encode($_POST['select']);

    $user = $_SESSION['user_login'];

    $data = [
        'rates'=> $currencies,
        'login'=> $user
    ];
    $sql = "UPDATE usersinfo_t SET rates=:rates WHERE login=:login";

    $stmt = $dbh->prepare($sql);

    $stmt->execute($data);
    if ($stmt) {
        if (!isset($_POST['select'])) {
            print_r('Selected currencies removed');
        } else {
            print_r('Selected currencies saved');
        }
    }
}