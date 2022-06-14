<?php

if ($isManager) {
    include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; 
} else {
    include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/header.php'; 
}
?>
    <h1><?=$title?></h1>
    <div class="row">
        <?php foreach ($chunkPosts as $chunkPost) : ?>
        <div class="col-md-<?=$countCol?>">
            <?php foreach ($chunkPost as $post) : ?>                
            <article class="card mb-4">
                <header class="card-header">
                    <div class="card-meta">
                    <time class="timeago" datetime="<?=$post['date']?>"><?=$post['date']?></time>
                    <a href="/posts/<?=$post['id']?>">
                    <h4 class="card-title"><?=$post['name']?></h4>
                    </a>
                </header>
                <a href="/posts/<?=$post['id']?>">
                    <img class="card-img" src="/img/posts/<?=$post['img']?>" alt="">
                </a>
                <div class="card-body">
                    <p class="card-text"><?=$post['description']?></p>
                </div>
            </article><!-- /.card -->
            <?php endforeach ?>
        </div>
        <?php endforeach ?> 
    </div>
    <?php if ($countPosts < $count) : ?>
        <nav class="nav-pagination" aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?=($start == 0) ? 'disabled' : ''; ?>">
                    <a class="page-link" aria-label="Previous" href="/?page=<?=($page - 1)?>" >
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                    <li class="page-item <?=($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="/?page=<?=$i?>"><?=$i?></a>
                    </li>
                <?php endfor ?>
                <li class="page-item <?=(($count - $start) <= $countPosts) ? 'disabled' : ''; ?>">
                    <a class="page-link" aria-label="Next" href="/?page=<?=($page + 1)?>" >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
        
            </ul>
        </nav>
    <?php endif ?>

    <form class="formSubscription mb-3" id="formSubscription">
        <div>
            <label for="emailSubscription" class="form-label">Подписаться на рассылку</label>
            <?php if (!empty($user)) : ?>
                <input type="hidden" name="userId" id="userId" value="<?=$user->id?>">
                <button class="btn btn-outline-success" type="submit" id="buttonSubscriptionAuth">Подписаться</button>
            <?php else: ?>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">example@example.com</span>
                    <input type="email" class="form-control" id="emailSubscription" name="email" aria-describedby="basic-addon3" required>
                    <input type="hidden" name="noAuth" value="no">
                    <button class="btn btn-outline-success" type="submit" id="buttonSubscriptionNoAuth">Подписаться</button>
                </div>
            <?php endif ?>
        </div>
    </form>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/footer.php';

    