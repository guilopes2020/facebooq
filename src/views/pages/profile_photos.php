<?=$render('header', ['loggedUser' => $loggedUser]);?>

<main>
    <section class="container main">

            <?php
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    $_SESSION['success'] = '';
                }
            ?>

        <?=$render('asideLeft', ['activeMenu' => 'fotos']);?>

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
                                <div class="full-user-photos">
                                    <?php if(count($user->photos) == 0): ?>
                                        <?=$user->name;?> não possui fotos.
                                    <?php endif; ?>    
                                    <?php foreach($user->photos as $photo): ?>
                                        <div class="user-photo-item">
                                            <a href="#modal-<?=$photo->id;?>" rel="modal:open">
                                                <img src="<?=$base;?>/media/uploads/<?=$photo->body;?>" />
                                            </a>
                                            <div id="modal-<?=$photo->id;?>" style="display:none">
                                                <img src="<?=$base;?>/media/uploads/<?=$photo->body;?>" />
                                            </div>
                                        </div>
                                    <?php endforeach; ?>    
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