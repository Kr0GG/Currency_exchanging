<html lang="en">
<head>
<?php
require_once __DIR__ . '/api/api.php';
require_once 'db.php';
?>
    <title>Login page</title>
    <!-- css -->
<link rel="import" href="styles.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

    <script type="text/javascript">
        $(function () {
            $('form').submit(function (e) {
                var $form = $(this);
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize()
                }).done(function (response) {
                    if (response !== '') {
                        alert(response)
                    }
                }).fail(function () {
                    console.log('fail');
                });
                //отмена действия по умолчанию для кнопки submit
                e.preventDefault();
            });
        });
    </script>

    <script type="text/javascript">
        function popup() {
            document.getElementById('welcome').innerHTML = 'Be careful, this page only for technical support.';
        }
    </script>
</head>
<body onload="popup()">
<legend>Admin's page.</legend>
<div id="welcome"></div>


<?php
$admin = true;
$sql = 'SELECT login FROM usersinfo_t  WHERE admin = :admin';
$params = [':admin' => $admin];

$stmt = $dbh->prepare($sql);
$stmt->execute($params);

$user = $stmt->fetch(PDO::FETCH_OBJ);
$user_sesn = htmlentities($_SESSION['user_login']);
if (isset($_SESSION['user_login']) & ($user_sesn === $user->login)) {
    echo 'You are administrator, ' . htmlentities($_SESSION['user_login']) . '!' . '<br>';
    echo '<a href="logout.php">Logout</a><br>';
    $crlist = get_crypto_currencies_list();

    $sql = "SELECT rates FROM usersinfo_t WHERE login=:login";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['login' => $_SESSION['user_login']]);
    $rates = $stmt->fetch();
    if (strlen($rates['rates'])){
        $rates = json_decode($rates['rates']);
    } else {
        $rates = json_decode("[]");
    }
    ?>
    <form action="sendData.php" method="post">
        <span>Select allowed currencies:</span>
        <input type="hidden" name="action" value="saveAllowed">
        <?php foreach ($crlist['currencies'] as $key => $value): ?>
            <div style="display:block">
                <input type="checkbox" name="allow[]" id="<?= $value ?>"
                       <?= in_array($value, $rates) ? "checked" : "" ?> value="<?= $value; ?>">
                <label for="<?= $value; ?>"><?= $value; ?></label>
            </div>
        <?php endforeach; ?>
        <input class="btn btn-lg btn-primary" type="submit" onclick="" value="Save">
    </form>
    <?php
} else {
    die ('You don\'t have access to this page!');
}
?>
</html>