<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Login - Facebooq</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/login.css" />
</head>
<body>
    <header>
        <div class="container">
            <a href=""><img src="<?=$base;?>/assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <h1><?=$alert ?? '';?></h1>
        <h1><?=$success ?? '';?></h1>
        <form method="POST" action="<?=$base;?>/login">
            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" />

            <input class="button" type="submit" value="Acessar o sistema" />

            <a href="<?=$base;?>/cadastro">Ainda não tem conta? <strong>Cadastre-se</strong></a>
        </form>
    </section>
</body>
</html>