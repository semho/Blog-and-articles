<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; ?>

<h1><?=$title?></h1>
<form action="/admin/users/<?=$changeableUser->id?>" method="post" id="formChangeUser" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-4">
            <!-- Form Group (username)-->
            <div>
                <label class="small mb-1" for="adminUserName">Имя</label>
                <input class="form-control mb-3 <?php if (isset($errors['name'])): ?>error--input<?php endif ?>" id="adminUserName" name="name" type="text" placeholder="Введите Имя" value="<?=$changeableUser->full_name?>">
                <?php if (isset($errors['name'])): ?><span class="error-lk"><?=$errors['name']?></span><?php endif ?>
            </div>
        </div>
        <div class="col-xl-4">
            <!-- Form Group (email)-->
            <div>
                <label class="small mb-1" for="adminUserEmail">Email</label>
                <input class="form-control mb-3 <?php if (isset($errors['email'])): ?>error--input<?php endif ?>" id="adminUserEmail" name="email" type="email" placeholder="Введите Email" value="<?=$changeableUser->email?>">
                <?php if (isset($errors['email'])): ?><span class="error-lk"><?=$errors['email']?></span><?php endif ?>
            </div>
        </div>
        <div class="col-xl-4">
            <label class="small mb-1" for="adminUserSelect">Группа</label>
            <select class="form-select mb-3" id="adminUserSelect" name="adminUserSelect">
                <?php foreach ($groups as $groupsId => $group): ?> 
                    <option value="<?=$groupsId?>" <?php if ($groupsId == $changeableUser->group_id) {?>selected<?php } ?>><?=$group['name']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-xl-12">
            <!-- Form Group (subscription)-->
            <div>
                <?php if ($changeableUser->subscription == 1): ?>
                    <span class="small mb-1">Пользователь подписан на нашу рассылку по email</span>
                    <input type="checkbox" class="btn-check" id="checkboxNo" name="checkboxNo" autocomplete="off" value="no">
                    <label class="btn btn-outline-danger" for="checkboxNo">Убрать подписку</label><br>
                <?php else: ?>
                    <span class="small mb-1">Пользователь НЕ подписан на нашу рассылку по email</span>
                    <input type="checkbox" class="btn-check" id="checkboxYes" name="checkboxYes" autocomplete="off" value="yes">
                    <label class="btn btn-outline-success" for="checkboxYes">Добавить подписку</label><br>
                <?php endif ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="small mb-1" for="descriptionUserAdmin">Подробно</label>
            <textarea class="form-control mb-3" name="description" id="descriptionUserAdmin"><?=$changeableUser->description?></textarea>
        </div>
        <div class="col-xl-3 wrapBtnAdminUser">
            <button class="btn btn-success" id="saveAdminUser" type="submit">Сохранить изменения</button>
        </div>
    </div>
</form>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; 