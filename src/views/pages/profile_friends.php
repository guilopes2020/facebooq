<?=$render('header', ['loggedUser' => $loggedUser]);?>

<main>
    <section class="container main">

            <?php
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    $_SESSION['success'] = '';
                }
            ?>

        <?=$render('asideLeft', ['activeMenu' => 'friends']);?>

        <section class="feed">

            <div class="row">
                <div class="box flex-1 border-top-flat">
                    <?=$render('perfil_header', ['isFollowing' => $isFollowing, 'user' => $user, 'loggedUser' => $loggedUser]);?>
                </div>
            </div>
            
                <div class="row">

                <div class="column">
                    
                    <div class="box">
                        <div class="box-body">

                            <div class="tabs">
                                <div class="tab-item active" data-for="followers">
                                    Seguidores
                                </div>
                                <div class="tab-item" data-for="following">
                                    Seguindo
                                </div>
                            </div>
                            <div class="tab-content">

                                <div class="tab-body" data-item="followers">
                                    <div class="full-friend-list">
                                        <?php foreach($user->followers as $follower): ?>
                                            <div class="friend-icon">
                                                <a href="<?=$base;?>/perfil/<?=$follower->id;?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?=$base;?>/media/avatars/<?=$follower->avatar;?>" />
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?=$follower->name;?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>    
                                    </div>
                                </div>

                                <div class="tab-body" data-item="following">
                                    <div class="full-friend-list">
                                        <?php foreach($user->following as $followi): ?>
                                            <div class="friend-icon">
                                                <a href="<?=$base;?>/perfil/<?=$followi->id;?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?=$base;?>/media/avatars/<?=$followi->avatar;?>" />
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?=$followi->name;?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endforeach;?>    
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>                        

                <?=$render('asideRight');?>
                
            </div>

        </section>
    </section>
</main>
    
<?=$render('footer')?>