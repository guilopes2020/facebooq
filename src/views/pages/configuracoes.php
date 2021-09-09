<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Configurações - Facebooq</title>
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
        <h1 style="text-align: center; margin-top: 20px;">Faça alterações no seu perfil</h1>
        <h1><?=$alert ?? '';?></h1>
        <h1><?=$success ?? '';?></h1>
        <form method="POST" action="<?=$base;?>/configuracoes">

            <input type="hidden" name="id" value="<?=$loggedUser->id?>">
            <input type="hidden" name="emailAtual" value="<?=$loggedUser->email?>">

            Nome:<br><br>
            <input placeholder="Digite seu nome" class="input" type="text" name="name" value="<?=$loggedUser->name?>" /><br><br>

            E-mail:<br><br>
            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" value="<?=$loggedUser->email?>" /><br><br>

            Senha:<br><br>      
            <input placeholder="Digite sua senha" class="input" type="password" name="password" /><br><br>

            <input placeholder="Digite novamente sua senha" class="input" type="password" name="passwordVerify" /><br><br>

            Data-nasc:<br><br>     
            <input id="birthdate" placeholder="Digite sua data de nascimento" class="input" type="text" name="birthdate" /><br><br>

            Cidade:<br><br>    
            <input placeholder="Digite sua cidade" class="input" type="text" name="city" value="<?=$user->city?>" /><br><br>

            Profissão:<br><br>
            <input placeholder="Digite sua profissão" class="input" type="text" name="work" value="<?=$user->work?>" /><br><br>

            Foto:<br><br>
            <input class="input" type="file" name="avatar"><br><br>

            Capa:<br><br>
            <input class="input" type="file" name="cover"><br><br>

            <input class="button" type="submit" value="Salvar" />
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