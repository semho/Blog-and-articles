<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; 
?>
<h1><?=$title?></h1>
<form action="/admin/add/page" method="post" id="formAddPage" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-12">
            <div>
                <label class="small mb-1" for="adminPageAddTitle">Заголовок</label>
                <input class="form-control mb-3 <?php if (isset($errors['name']) || isset($errors['slug'])): ?>error--input<?php endif ?>" id="adminPageAddTitle" type="text" name="name" placeholder="Введите Название" value="<?=$_POST['name'] ?? ''?>">
                <?php if (isset($errors['name'])): ?><span class="error-lk"><?=$errors['name']?></span><?php endif ?>
                <?php if (isset($errors['slug'])): ?><span class="error-lk"><?=$errors['slug']?></span><?php endif ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="small mb-1" for="textPageAddAdmin">Текст страницы</label>
            <textarea class="form-control mb-3 <?php if (isset($errors['text'])): ?>error--input<?php endif ?>" name="text" id="textPageAddAdmin"><?=$_POST['text'] ?? ''?></textarea>
            <?php if (isset($errors['text'])): ?><span class="error-lk"><?=$errors['text']?></span><?php endif ?>
        </div>
        <div class="col-xl-3 wrapBtnAdminUser">
            <button class="btn btn-success" id="saveAdminPage" type="submit">Добавить страницу</button>
        </div>
    </div>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; 