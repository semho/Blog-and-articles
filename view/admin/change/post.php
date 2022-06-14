<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; ?>
<h1><?=$title?></h1>
<form action="/admin/posts/<?=$changeablePost->id?>" method="post" id="formChangePost" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-6">
            <div>
                <label class="small mb-1" for="adminPostName">Название статьи</label>
                <input class="form-control mb-3 <?php if (isset($errors['name'])): ?>error--input<?php endif ?>" id="adminPostName" name="name" type="text" placeholder="Введите Название" value="<?=$changeablePost->name?>">
                <?php if (isset($errors['name'])): ?><span class="error-lk"><?=$errors['name']?></span><?php endif ?>
            </div>
        </div>
        <div class="col-xl-6">
            <div>
                <label class="small mb-1" for="adminPostDescription">Краткое описание</label>
                <input class="form-control mb-3 <?php if (isset($errors['description'])): ?>error--input<?php endif ?>" id="adminPostDescription" name="description" type="text" placeholder="Введите краткое описание" value="<?=$changeablePost->description?>">
                <?php if (isset($errors['description'])): ?><span class="error-lk"><?=$errors['description']?></span><?php endif ?>
            </div>
        </div>
        <div class="col-xl-12">  
            <div class="card-body text-center">
                <img class="mb-2" src="<?=UPLOAD_IMG_POSTS . $changeablePost->img?>" alt="<?=$changeablePost->name?>">
                <div class="small font-italic text-muted mb-4">JPG, JPEG, PNG или GIF размером не более 2 MB</div>
                <?php if (isset($errors['size'])): ?><span class="error-lk"><?=$errors['size']?></span><?php endif ?>
                <?php if (isset($errors['endFile'])): ?><span class="error-lk"><?=$errors['endFile']?></span><?php endif ?>
                <input type="file" name="post-photo" id="post-photo" hidden="">
                <label for="post-photo" class="btn btn-success">Изменить изображение статьи</label>
            </div>
        </div>
        <div class="mb-3">
            <label class="small mb-1" for="textPostAdmin">Текст статьи</label>
            <textarea class="form-control mb-3 <?php if (isset($errors['text'])): ?>error--input<?php endif ?>" name="textPost" id="textPostAdmin"><?=$changeablePost->text?></textarea>
            <?php if (isset($errors['text'])): ?><span class="error-lk"><?=$errors['text']?></span><?php endif ?>
        </div>
        <div class="col-xl-3 wrapBtnAdminUser">
            <button class="btn btn-success" id="saveAdminPost" type="submit">Сохранить изменения</button>
        </div>
    </div>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; 