<?php
require_once 'db.php';
require_once __DIR__ . '/api/api.php';
?>
<html lang="en">
<head>
    <title>Let's take with us most actual information!</title>
    <!-- css -->
<link rel="import" href="styles.css">

    <!-- jq INCLUDES? -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
</head>

<body>
<legend>Let's take with us most actual information!</legend>
<?php
$stmt_rates = (get_crypto_currencies_list())['currencies'];
//print_r(json_encode($stmt_rates));
//var_dump(json_encode($stmt_rates));


if (isset($_SESSION['user_login'])) {

    $login = htmlentities($_SESSION['user_login']);
    echo 'Hello, ' . $login . '!' . '<br>';
    echo 'You visited this site ' . $_COOKIE['page_visit'] . ' times per 3000 last seconds! <br>';
	echo '<a href="Adminka">Page for Administrator only</a> <br>';
    echo '<a href="logout.php">Logout</a><br>';
    $sql = 'SELECT rates FROM usersinfo_t  WHERE admin = :admin';
    $params = [':admin' => true];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $admin = $stmt->fetch(PDO::FETCH_OBJ);

//    $qiwi_currencies = get_qiwi_currencies_list();
?>
<ul id="my_list">
    <?php
    $sql = "SELECT * FROM usersinfo_t WHERE login=:login";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['login' => $_SESSION['user_login']]);
    $user = $stmt->fetch();
    if (strlen($user['rates'])) {
        $selected = json_decode($user['rates']);
    } else {
        $selected = json_decode("[]");
    }
    $sql = "SELECT * FROM usersinfo_t WHERE admin=:bool ORDER BY id DESC LIMIT 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(['bool' => 1]);
    $admin = $stmt->fetch();
    if (strlen($admin['rates'])) {
        $allowed = json_decode($admin['rates']);
    } else {
        $allowed = json_decode("[]");
    }
    ?>    
    <form  action="sendData.php" method="post" id="selected">
        <input type="hidden" name="action" value="saveUserSelected">
        <div id="selected-list">
            <?php if (count($selected)): ?>
                <span>Selected currencies:</span>
                <?php foreach ($selected as $key => $value):
						if (in_array($value, $allowed)): ?>
                        <li><?= $value ?></li> <!-- php echo var -->
                        <input type="hidden" name="select[]" id="<?= $value ?>" value="<?= $value; ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if (!$user['admin']): ?>
            <p>Click the button to append an item to the end of the list.</p>
            <?php foreach ($allowed as $key => $value): ?>
                <?php if (!in_array($value, $selected)): ?>
                    <button class="btn btn-lg btn-primary" onclick="addItem('<?= $value ?>')" id="btn<?= $value ?>"><?= $value ?></button>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!$user['admin']): ?>
            <button type="button" onclick="showAll()" id="showall" class="btn btn-lg btn-primary">Reset (to show all available currencies).</button>
            <button type="submit" id="submit" class="btn btn-lg btn-primary">Send</button>
        <?php endif; ?>
    </form>
</ul>
<script>

    function showAll() {
        document.getElementById('selected-list').remove();
        document.getElementById('submit').click();
    }

    $(function () {
        $('#selected').submit(function (e) {
            var $form = $(this);
            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize()
            }).done(function (response) {
                if (response !== '') {
                    if (response === 'Selected currencies removed') {
                        document.location.reload()
                    } else {
                        alert(response)
                    }
                }
            }).fail(function () {
                console.log('fail');
            });
            //отмена действия по умолчанию для кнопки submit
            e.preventDefault();
        });
    });

    function addItem(item) {
        var appendTo = document.getElementById("selected-list");
        var textnode = document.createTextNode(item);
        var node = document.createElement("LI");
        node.appendChild(textnode);
        appendTo.appendChild(node);

        var hiddennode = document.createElement("input");
        hiddennode.setAttribute('type', 'hidden');
        hiddennode.setAttribute('name', 'select[]');
        hiddennode.setAttribute('value', item);
        appendTo.appendChild(hiddennode);
        document.getElementById('btn' + item).remove();
    }
</script>


<form method="post">
<input  class="btn btn-lg btn-primary"type="submit" name="add" value="More information" />
<input  class="btn btn-lg btn-primary"type="submit" name="hide" value="Hide more information / Reload" />
</form>

<?php 
   $result = array_intersect($selected, $allowed);
	$qiwi_currencies = get_qiwi_currencies_list('RUB');
    $qiwi = get_qiwi_currencies_prices('RUB', $qiwi_currencies['currencies']);
	if(isset($_POST['add']))  echo '<br>At this moment Qiwi have this rates -  <br>';
    foreach ($qiwi as $rate) {
        $amount = $rate['price'] < 1 ? 100 : 1;
        $price = $amount > 1 ? $rate['price'] * $amount : $rate['price'];
  if(isset($_POST['add']))  echo "For {$amount} {$rate['from']}: " . round($price, 2) . " {$rate['to']}<br>";
    }
	
 $url = 'https://rocketbank.ru/public/exchange_rates';
	if(isset($_POST['add']))  echo '<br>На данный момент РокетБанк имеет курсы / At this moment RocketBank have this rates -  <br>'; //add for russians~
    $content = file_get_contents($url);
    $result = json_decode($content);

    foreach ($result->rates as $currency => $data) {
        $currency_name = '';
        if ($currency == 'usd') $currency_name = 'доллара';
        else if ($currency == 'eur') $currency_name = 'евро';
        else continue;
		if(isset($_POST['add'])) echo "Для $currency_name: курс покупки $data->buy, курс продажи $data->sell,<br>Курс ЦБ (для ознакомления): $data->cb <br>";
    }

	  if(isset($_POST['add'])) echo "<br>For any questions you can contact us - krogxg@gmail.com.<br>
	  Offers you to test our telegram bot / Предлагаем вам также воспользоваться нашим Telegram ботом - @KroHelper_BOT! <br>";

// $content = str_replace('buy','Курс для покупки', $content);
// выводим спарсенный текст.
    $currencies = [];
    foreach ($selected as $item) {
        if (in_array($item, $allowed)) {
            $currencies[] = $item;
        }
    }
    if (count($currencies)) {
        $currencies = join(',', $currencies);
        $url = "https://min-api.cryptocompare.com/data/pricemulti?fsyms={$currencies}&tsyms=RUB";
        $result = json_decode(file_get_contents($url));
//    $result = get_qiwi_currencies_prices('RUB', ['EUR', 'USD']);
//    $result = json_decode(file_get_contents($url));
        echo "<br> <br> At this moment crypyo rates ({$currencies}) - <br>";

        foreach ($result as $key => $value) {
            echo "Цена за 1 {$key}: $value->RUB" . " руб.<br>";
        }
    }
    echo "<br><br> Site needs time to update info / Для обновления данных требуется время.";
} else {
    die ('You don\'t have access to this page!');
} ?>
</body>