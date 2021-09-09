<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Cadastro - Facebooq</title>
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
        <h1 style="text-align: center; margin-top: 20px;">Faça seu cadastro</h1>
        <h1><?=$alert ?? '';?></h1>
        <h1><?=$success ?? '';?></h1>
        <form method="POST" action="<?=$base;?>/cadastro">
            <input placeholder="Digite seu nome *" class="input" type="text" name="name" />

            <input placeholder="Digite seu e-mail *" class="input" type="email" name="email" />

            <input placeholder="Digite sua senha *" class="input" type="password" name="password" />

            <input id="birthdate" placeholder="Digite sua data de nascimento *" class="input" type="text" name="birthdate" />

            <input class="button" type="submit" value="Cadastrar" />

            <a href="<?=$base;?>/login">já tem conta? <strong>Faça login</strong></a>
        </form>
    </section>

    <script src="https://unpkg.com/imask"></script>
    <script>
        IMask(
            document.getElementById('birthdate'),
            {
                mask:'00/00/0000'
            }
        );
    </script>
</body>
</html>