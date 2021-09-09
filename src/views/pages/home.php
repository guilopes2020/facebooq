<?=$render('header', ['loggedUser' => $loggedUser]);?>

    <main>
        <section class="container main">

            <?=$render('asideLeft', ['activeMenu' => 'home']);?>

            <section class="feed mt-10">
                
                <div class="row">
                    <div class="column pr-5">
    
                        <?=$render('feed-editor', ['user' => $loggedUser]);?>
    
                        <?php foreach($feed['posts'] as $feedItem): ?>
                            <?=$render('feed-item', [
                                'data' => $feedItem,
                                'logado' => $loggedUser
                            ]);?>
                        <?php endforeach; ?>

                        <div class="feed-pagination">
                            <?php for($q = 0; $q < $feed['pageCount']; $q++): ?>
                                <a class="<?=($q === $feed['currentPage'] ? 'active' : '');?>" href="<?=$base;?>/?page=<?=$q;?>"><?=$q+1;?></a>
                            <?php endfor; ?>
                        </div>    
                    </div>
                    <?=$render('asideRight');?>
                </div>
    
            </section>
        </section>
    </main>
    
    <?=$render('footer')?>