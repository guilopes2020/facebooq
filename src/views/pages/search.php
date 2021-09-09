<?=$render('header', ['loggedUser' => $loggedUser]);?>

<main>
    <section class="container main">

            <?php
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    $_SESSION['success'] = '';
                }
            ?>

        <?=$render('asideLeft', ['activeMenu' => 'search']);?>

        <section class="feed">

        <div class="full-friend-list">
            <?php foreach($users as $user): ?>
                <div class="friend-icon">
                    <a href="<?=$base;?>/perfil/<?=$user->id;?>">
                        <div class="friend-icon-avatar">
                            <img src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" />
                        </div>
                        <div class="friend-icon-name">
                            <?=$user->name;?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>    
        </div>       

        </section>
    </section>
</main>
    
<?=$render('footer')?>