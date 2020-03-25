<head>
    <title>Login page</title>
    <!-- css -->
<link rel="import" href="styles.css">


    <!-- js INCLUDES?? -->
</head>

<body>
<?php
require_once "db.php";
// esli forma otpravlena nepustaya
//check
$login = $email = test_input($_POST["login"]);
$pwd = test_input($_POST['password']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format...   ";
    echo $emailErr;	
    echo '<html lang="en"><div> <a href="login.php">Needs to Log in?</a> </div></html>';
}
if (!empty($login) && !empty($pwd)) {
    $sql = 'SELECT login, password FROM usersinfo_t WHERE login = :login';
    $params = [':login' => $login];


    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);


    $user = $stmt->fetch(PDO::FETCH_OBJ);
    if ($user) {
        if (password_verifyy($pwd, $user)) {
            $_SESSION['user_login'] = $user->login;
            header('Location: instead.php');
        } else {
            echo 'Password or login typed not correctly';
			echo '<html lang="en"><div> <a href="login.php">Needs to Log in?</a> </div></html>';
        }
    } else {
        echo 'Password or login typed not correctly';
		echo '<html lang="en"><div> <a href="login.php">Needs to Log in?</a> </div></html>';
    }
} else {
    echo 'Password or login typed not correctly';
    echo '<html lang="en"><div> <a href="login.php">Needs to Log in?</a> </div></html>';
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function password_verifyy($pwd, $user)
{
    $local_param = "local_parapa";
    $check = ($pwd) . $local_param;
    return (password_verify((($pwd) . $local_param), $user->password));

}
//bilo uze
//if (!empty(['login'])) {
//$login= strip_tags($_REQUEST['login']);
//}
?>
</body>
