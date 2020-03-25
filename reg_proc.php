<?php
require_once "db.php";
?>
<html lang="en">
<head>
    <title>Login page</title>
    <!-- css -->
<link rel="import" href="styles.css">


    <!-- js INCLUDES?? -->
</head>
<body>
<?php

//already registered
if (empty($_POST["email"])) {
    $emailErr = "Email / login is required. <br>";
    echo $emailErr;
} else {
    $login = $email = test_input($_POST["email"]);
    $pwd = test_input($_POST["password"]);
    if ($_POST["password"] != $_POST["confirm"]) {
        echo 'Confirmation of the password is incorrect!';
		echo '<html lang="en"><div> <a href="reg.php">Needs to register again?</a> </div></html>';
		die();
    }
    // dl9 logina
    //if (!preg_match("/^[a-zA-Z ]*$/",$email)) {
    //   $emailErr = "Only letters and white space allowed";
    //  echo $emailErr;
    //  }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format...  <br> ";
        echo $emailErr;
		echo '<html lang="en"><div> <a href="reg.php">Needs to register again?</a> </div></html>';
		die();
    }
}
if (!empty($login) && !empty($pwd) && empty($emailErr)) {
    $sql_check = 'SELECT EXISTS( SELECT login FROM usersinfo_t WHERE login = :login)';
    $stmt_check = $dbh->prepare($sql_check);
    $stmt_check->execute([':login' => $login]);

    if ($stmt_check->fetchColumn()) {		
		echo 'User with this login / e-mail already exists';
		echo '<html lang="en"><div> <a href="reg.php">Needs to register again?</a> </div></html>';
		die();
    };
    $local_param = "local_parapa";
    $pwd .= $local_param;
    $pwd = password_hash($pwd, PASSWORD_DEFAULT);

    $admin = true; // 1
    $sql = 'SELECT rates FROM usersinfo_t WHERE admin = :admin'; // ustanavvit' reitu kak u admina
    $params = [':admin' => $admin];

    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_OBJ);
    $stmt_rates = $user->rates;
    $sql = 'INSERT INTO usersinfo_t(login, password, rates) VALUES (:login, :pwd, :stmt_rates)';
    $params = ['login' => $login, 'pwd' => $pwd, 'stmt_rates' => $stmt_rates];

    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    echo 'You successfully registered!';
    echo '<html lang="en"><div> <a href="reg.php">Needs to register again?</a> </div></html>';
    echo '<html lang="en"><div> <a href="login.php">Needs to Log in?</a> </div></html>';
    // header('Location: login.php');
//href login.php;
} else {
    //  echo $emailErr ;
    echo 'Please, type all needed info correctly! Error while register.';
	echo '<html lang="en"><div> <a href="reg.php">Needs to register again?</a> </div></html>';
}
// $website = test_input($_POST["website"]);
// if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
//   $websiteErr = "Invalid URL";
// }
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
</body>
