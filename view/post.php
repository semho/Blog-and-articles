<?php

if ($isManager) {
    include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; 
} else {
    include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/header.php'; 
}
?>
    <div class="row">
        <div class="col-md-12">
            <article class="card mb-4">
                <header class="card-header text-center">
                    <div class="card-meta">
                    <time class="timeago" datetime="<?=$post['date']?>"><?=$post['date']?></time>
                    <h1 class="card-title"><?=$post['name']?></h1>
                </header>
                <img class="card-img" src="/img/posts/<?=$post['img']?>" alt="">
                <div class="card-body">
                    <p class="card-text"><?=$post['text']?></p>
                </div>
            </article><!-- /.card -->
        </div>
    </div>
    
    <h3>Комментарии</h3>
    <div class="comments-box">
        <!-- если группа пользователей админ или менеджер -->
        <?php if ($isManager): ?>
            <?php foreach ($allCommentsUsers as $commentUser) : ?>
                <?php require $_SERVER["DOCUMENT_ROOT"] . '/include/cardComment.php' ?>
            <?php endforeach ?>
        <!-- иначе группа пользователей авторизированные пользователи -->
        <?php elseif ($isAuthUser): ?>
            <?php foreach ($commentsIsCheckAndUser as $commentUser) : ?>
                <?php require $_SERVER["DOCUMENT_ROOT"] . '/include/cardComment.php' ?>
            <?php endforeach ?>
        <!-- иначе все остальные -->
        <?php else: ?>
            <?php foreach ($commentsUsers as $commentUser) : ?>
                <?php require $_SERVER["DOCUMENT_ROOT"] . '/include/cardComment.php' ?>
            <?php endforeach ?>
        <?php endif ?>
    </div>

    <div class="mt-5">
        <form id="formComment">
            <h5>Добавление нового комментария</h5>
            <input type="hidden" id="userComment" name="name" value=<?=$user->id ?? false ?>>
            <input type="hidden" id="postId" name="post" value=<?=$post['id'] ?? false ?>>
            <input type="hidden" id="groupId" name="group" value=<?=$user->group_id ?? false ?>>
            <textarea class="form-control mt-3 comment-textarea" rows="3" name="comment" placeholder="Напишите комментарий..."></textarea>
            <button type="submit" class="btn btn-success mt-3">Опубликовать</button>
        </form>
    </div>
    

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Требуется авторизация</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"></button>
            </div>
            <div class="toast-body">
                <a href="/auth">Авторизация</a>
                <a href="/reg">Регистрация</a>
            </div>
        </div>
    </div>
<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/footer.php';

    