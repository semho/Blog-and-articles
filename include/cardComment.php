<div class="d-flex mb-3 p-3 bg-light comment" id="<?=$commentUser['id']?>">
    <div class="text-center">
        <img class="me-3 rounded-circle" src="/img/users/<?=$commentUser['user']['avatar']?>" alt="<?=$commentUser['user']['full_name']?>" width="100" height="100">
        <h6 class="mt-1 mb-0 me-3"><?=$commentUser['user']['full_name']?></h6>
    </div>
    <div class="flex-grow-1 d-block">
        <p class="mt-3 mb-2"><?=$commentUser['text']?></p>
        <time class="timeago text-muted" datetime="<?=$commentUser['date']?>" timeago-id="19"><?=$commentUser['date']?></time> 
        <?php if ($commentUser['is_check'] == 0): ?>
            <span class="moderation">На модерации</span>
            <?php if ($isManager): ?>
                <div>
                    <button class="btn btn-outline-success approveComment" type="button">Утвердить</button>
                    <button class="btn btn-outline-danger rejectComment" type="button">Отклонить</button>
                </div>
            <?php endif ?>
        <?php endif ?>      
    </div>
</div>