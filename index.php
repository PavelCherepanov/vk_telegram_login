<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="POST">
            <p>
                <label for="login">Логин</label>
                <input name="login" type="text">
            </p>
            
            <p>
                <label for="password">Пароль</label>
                <input name="password" type="password">
            </p>           
            

            <input type="submit">
        </form>

        <br>

        <form action="message.php" method="GET">
            <p>
                <label for="tMessage">Отправить сообщение в Telegram</label>
                <input name="tMessage" type="text">
            </p>
            <p>
                <input type="submit">
            </p>
            
            <p>
                <label for="vkMessage">Отправить пост в VK</label>
                <input name="vkMessage" type="text">
            </p>
            <p>
            <input type="submit">
            </p>
        </form>

        <!-- <form action="login.php" method="POST">
            <p>
                <label for="login">Логин</label>
                <input name="login" type="text">
            </p>
            
            <p>
                <label for="password">Пароль</label>
                <input name="password" type="password">
            </p>           
            

            <input type="submit">
        </form> -->
        <?php
            $params = array(
                'client_id'     => '',
                'redirect_uri'  => 'http://1laba/login.php',
                'scope'         => 'email',
                'response_type' => 'code',
                'state'         => 'http://1laba'
            );



        $url = 'https://oauth.vk.com/authorize?' . urldecode(http_build_query($params));
        echo $url."<br>";
        echo '<p><a href="' . $url . '">Войти через ВКонтакте</a><p>';

        ?>
      
    </div>
    
</body>
</html>