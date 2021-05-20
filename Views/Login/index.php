<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=BASE_URL.'Assets/css/login.css';?>">
</head>
<body>
    <div class="loginarea">
        <form method="POST">
            <input type="email" name="email" placeholder="Digite Seu e-mail">
            <input type="password" name="password" placeholder="Digite a Sua Senha">
            <input type="submit" value="Enviar" >

            <?php if(isset($error) && !empty($error)):?>
                <div class="warning">
                    <?=$error;?>
                </div>    
            <?php endif;?>
        </form>
    </div>
</body>
</html>