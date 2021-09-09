<?=$render('header', ['loggedUser' => $loggedUser]);?>

<main>
    <section class="container main">

            <?php
                if (isset($_SESSION['success'])) {
                    echo $_SESSION['success'];
                    $_SESSION['success'] = '';
                }
            ?>

        <?=$render('asideLeft', ['activeMenu' => 'profile']);?>

        <section class="feed">

                <div class="row">
                    <div class="box flex-1 border-top-flat">
                    <?=$render('perfil_header', ['isFollowing' => $isFollowing, 'user' => $user, 'loggedUser' => $loggedUser]);?>
                    </div>
                </div>
            
                <div class="row">

                    <div class="column side pr-5">
                        
                        <div class="box">
                            <div class="box-body">
                                
                                <div class="user-info-mini">
                                    <img src="<?=$base;?>/assets/images/calendar.png" />
                                    <?= date('d/m/Y', strtotime($user->birthdate)); ?> (<?=$user->ageYears;?> anos)
                                </div>
                                
                                <?php if(!empty($user->city)): ?>
                                    <div class="user-info-mini">
                                        <img src="<?=$base;?>/assets/images/pin.png" />
                                        <?=$user->city;?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if(!empty($user->city)): ?>
                                    <div class="user-info-mini">
                                        <img src="<?=$base;?>/assets/images/work.png" />
                                        <?=$user->work;?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                        <div class="box">
                            <div class="box-header m-10">
                                <div class="box-header-text">
                                    Seguindo
                                    <span><?=count($user->following);?></span>
                                </div>
                                <div class="box-header-buttons">
                                    <a href="<?=$base;?>/perfil/<?=$user->id?>/amigos">ver todos</a>
                                </div>
                            </div>
                            <div class="box-body friend-list">
                                <?php for($q = 0; $q < 9; $q++): ?>
                                    <?php if(isset($user->following[$q])): ?>
                                        <div class="friend-icon">
                                            <a href="<?=$base;?>/perfil/<?=$user->following[$q]->id;?>">
                                                <div class="friend-icon-avatar">
                                                    <img src="<?=$base;?>/media/avatars/<?=$user->following[$q]->avatar;?>" />
                                                </div>
                                                <div class="friend-icon-name">
                                                    <?=$user->followin[$q]->name;?>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>    
                                <?php endfor; ?>    
                        </div>
                    </div>

                </div>
                <div class="column pl-5">

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span><?=count($user->photos);?></span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base;?>/perfil/<?=$user->id;?>/fotos">ver todas</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">
                            <?php for($q = 0; $q < 4; $q++): ?>
                                <?php if(isset($user->photos[$q])): ?>
                                    <div class="user-photo-item">
                                        <a href="#modal-<?=$user->photos[$q]->id;?>" rel="modal:open">
                                            <img src="<?=$base;?>/media/uploads/<?=$user->photos[$q]->body;?>" />
                                        </a>
                                        <div id="modal-<?=$user->photos[$q]->id;?>" style="display:none">
                                        <img src="<?=$base;?>/media/uploads/<?=$user->photos[$q]->body;?>" />
                                        </div>
                                    </div>
                                <?php endif; ?>    
                            <?php endfor; ?>   
                        </div>
                    </div>
                    <?php if($user->id == $loggedUser->id): ?>
                        <?=$render('feed-editor', ['user' => $loggedUser]);?>    
                    <?php endif; ?>

                    <?php foreach($feed['posts'] as $feedItem): ?>
                            <?=$render('feed-item', [
                                'data' => $feedItem,
                                'logado' => $loggedUser
                            ]);?>
                        <?php endforeach; ?>

                        <div class="feed-pagination">
                            <?php for($q = 0; $q < $feed['pageCount']; $q++): ?>
                                <a class="<?=($q === $feed['currentPage'] ? 'active' : '');?>" href="<?=$base;?>/perfil/<?=$user->id;?>?page=<?=$q;?>"><?=$q+1;?></a>
                            <?php endfor; ?>
                        </div>
                </div>

                <?=$render('asideRight');?>
                
            </div>

        </section>
    </section>
</main>
    
<?=$render('footer')?>