<?php
$cookie_name = "user";
$cookie_value = $login;
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); //1*30 day
?>
    <html>
    <body>
<?php
if (!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set! Your session will be not supported later";
} else {
    echo "Cookie name '" . $cookie_name . "'is set! You will have access to the site any time at next 30 days. <br>";
    echo "Value is:" . $_COOKIE[$cookie_name];
}
if (count($_COOKIE) > 0) {
    echo "Cookies succesfully enabled!";
} else {
    echo "Cookies are not set :(";
}
?>