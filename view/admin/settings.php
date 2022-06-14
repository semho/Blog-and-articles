<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; ?>
<h1><?=$title?></h1>
<div class="wrapper-table-posts">
    <form action="/admin/settings" method="post" id="formChangeSettings" enctype="multipart/form-data">
        <div class="row">
            <?php foreach ($settings as $curentSetting): ?>
                <div class="col-xl-12">
                    <div>
                        <label class="small mb-1" for="adminSettingPage">Название настройки: <?=$curentSetting->name?></label>
                        <input class="form-control mb-3 <?php if (isset($errors['int'])): ?>error--input<?php endif ?>" id="adminSettingPage" type="text" name="value" placeholder="Введите число" value="<?=$curentSetting->value?>">
                        <input type="hidden" name="id" value="<?=$curentSetting->id?>">
                        <?php if (isset($errors['int'])): ?><span class="error-lk"><?=$errors['int']?></span><?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
            <div class="col-xl-3 wrapBtnAdminUser">
                <button class="btn btn-success" id="saveAdminPage" type="submit">Сохранить изменения</button>
            </div>
        </div>
    </form>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; ?>