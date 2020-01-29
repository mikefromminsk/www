<?php include_once "login.php"; ?>
<html>
<head>
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("wallet_addr");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            copyText.setSelectionRange(0, 0);
            copyText.blur();
            document.getElementById("copy_button").innerText = 'coped';
        }
    </script>
</head>
<body>
<table>
    <tr>
        <th>Wallet of user: <?= $user["user_login"] ?></th>
    </tr>
    <tr>
        <td colspan="2">
            <input id="wallet_addr"
                   value="<?= "http://" . $_SERVER["HTTP_HOST"] . str_replace("wallet.php", "send", $_SERVER["SCRIPT_NAME"]) . "?receiver=" . $user["user_login"] ?>"/>
            <button id="copy_button" onclick="copyToClipboard()">copy</button>
        </td>
    </tr>
    <?php
    $coins = select("select *, count(*) as 'coin_count' from domain_keys t1"
        . " left join coins t2 on t1.coin_code = t2.coin_code"
        . " where t1.user_id = " . $user["user_id"]
        . " group by t1.coin_code");
    foreach ($coins as $coin) { ?>
        <tr>
            <td colspan="2">
                <a href="send?token=<?= $token ?>&coin_code=<?= $coin["coin_code"] ?>">
                    <div style="background-color: lightgray;">
                        <big><b><?= $coin["coin_count"] ?></b> <?= $coin["coin_code"] ?></big><br>
                        <small>1 <?= $coin["coin_name"] ?> = 0.001 USD</small>
                    </div>
                </a>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="2">
            <a href="create_coin?token=<?= $token ?>">
                <button style="width: 100%">Create coin</button>
            </a>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <a href="send?token=<?= $token ?>">
                <button style="width: 100%">Send</button>
            </a>
        </td>
        <td>
            <a href="exchange?token=<?= $token ?>">
                <button style="width: 100%">Exchange</button>
            </a>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <a href="stock?stock_token=<?= $user["user_stock_token"] ?>">
                <button style="width: 100%">Stock</button>
            </a>
        </td>
    </tr>
</table>
</body>
</html>
