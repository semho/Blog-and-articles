<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; ?>
<h1><?=$title?></h1>
<form action="/admin/comments/<?=$changeableComment['comment']->id?>" method="post" id="formChangeComment" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-12">
            <div>
                <label class="small mb-1" for="adminCommentText">Комментарий</label>
                <textarea class="form-control mb-3 <?php if (isset($errors['text'])): ?>error--input<?php endif ?>" name="textComment" id="adminCommentText"><?=$changeableComment['comment']->text?></textarea>
                <?php if (isset($errors['text'])): ?><span class="error-lk"><?=$errors['text']?></span><?php endif ?>
            </div>
        </div>
        <div class="col-xl-4">
            <div>
                Название статьи:
                <?=$changeableComment['post']->name?>
            </div>
        </div>
        <div class="col-xl-4 d-flex justify-content-center">
            <div>
                Email автора:
                <?=$changeableComment['author']->email?>
            </div>
        </div>
        <div class="col-xl-4 mb-3 d-flex justify-content-end">
            <div>
                <?php if ($changeableComment['comment']->is_check == 1): ?>
                    <span class="small mb-1">Модерация пройдена</span>
                    <input type="checkbox" class="btn-check" id="checkboxNo" name="checkboxNo" autocomplete="off" value="no">
                    <label class="btn btn-outline-danger" for="checkboxNo">Вернуть на модерацию</label><br>
                <?php else: ?>
                    <span class="small mb-1">На модерации</span>
                    <input type="checkbox" class="btn-check" id="checkboxYes" name="checkboxYes" autocomplete="off" value="yes">
                    <label class="btn btn-outline-success" for="checkboxYes">Утвердить комментарий</label><br>
                <?php endif ?>
            </div>
        </div>
        <div class="col-xl-3 wrapBtnAdminUser">
            <button class="btn btn-success" id="saveAdminPost" type="submit">Сохранить изменения</button>
        </div>
    </div>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; 