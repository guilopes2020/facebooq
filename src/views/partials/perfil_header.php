<div class="box-body">
    <div class="profile-cover" style="background-image: url('<?=$base;?>/media/covers/<?=$user->cover;?>');"></div>
    <div class="profile-info m-20 row">
        <div class="profile-info-avatar">
            <a href="<?=$base;?>/perfil/<?=$user->id;?>">
                <img src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" />
            </a>
        </div>
        <div class="profile-info-name">
            <a style="text-decoration: none; color: #224b7a;" href="<?=$base;?>/perfil/<?=$user->id;?>">
                <div class="profile-info-name-text"><?=$user->name;?></div>
            </a>
            
            <?php if(!empty($user->city)): ?>
                <div class="profile-info-location"><?=$user->city;?></div>
            <?php endif; ?>
        </div>
        <div class="profile-info-data row">
            <?php if($user->id != $loggedUser->id): ?>
                <div class="profile-info-item m-width-20">
                    <a class="profile-info-seguir" href="<?=$base;?>/perfil/<?=$user->id;?>/follow"><?=(!$isFollowing) ? 'Seguir' : 'Deixar de seguir';?></a>      
                </div>
            <?php endif; ?>    
            <div class="profile-info-item m-width-20">
                <a style="text-decoration: none;" href="<?=$base;?>/perfil/<?=$user->id;?>/amigos">
                <div class="profile-info-item-n"><?=count($user->followers);?></div>
                <div class="profile-info-item-s"><?=(count($user->followers) > 1) ? 'Seguidores' : 'Seguidor';?></div>
                </a>
            </div>
            <div class="profile-info-item m-width-20">
                <a style="text-decoration: none;" href="<?=$base;?>/perfil/<?=$user->id;?>/amigos">
                    <div class="profile-info-item-n"><?=count($user->following);?></div>
                    <div class="profile-info-item-s">Seguindo</div>
                </a>
            </div>
            <div class="profile-info-item m-width-20">
                <a style="text-decoration: none;" href="<?=$base;?>/perfil/<?=$user->id;?>/fotos">
                    <div class="profile-info-item-n"><?=count($user->photos);?></div>
                    <div class="profile-info-item-s">Fotos</div>
                </a>
            </div>
        </div>
    </div>
</div>