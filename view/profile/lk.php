<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/header.php'; ?>
<h1><?=$title?></h1>
<form action="lk" method="post" id="formLk" enctype="multipart/form-data">
    <div class="row"> 
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Изображение профиля</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="<?=UPLOAD_IMG_PROFILE . $user['avatar']?>" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG, JPEG, PNG или GIF размером не более 2 MB</div>
                    <?php if (isset($errors['size'])): ?><span class="error-lk"><?=$errors['size']?></span><?php endif ?>
                    <?php if (isset($errors['endFile'])): ?><span class="error-lk"><?=$errors['endFile']?></span><?php endif ?>
                    <!-- Profile picture upload button-->
                    <input type="file" name="profile-photo" id="profile-photo" hidden="">
                    <label for="profile-photo" class="btn btn-success">Загрузить новую картинку</label>
                    <!-- Profile picture upload button-->
                    <!-- <button class="btn btn-success" id="btn-img-account" type="button">Загрузить новую картинку</button> -->
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Информация о пользователе</div>
                <div class="card-body">
                    <!-- Form Group (username)-->
                    <div>
                        <label class="small mb-1" for="inputUsername">Ваше имя</label>
                        <input class="form-control mb-3 <?php if (isset($errors['name'])): ?>error--input<?php endif ?>" id="inputUsername" name="name" type="text" placeholder="Введите Ваше имя" value="<?=$user['full_name']?>">
                        <?php if (isset($errors['name'])): ?><span class="error-lk"><?=$errors['name']?></span><?php endif ?>
                    </div>
                    <!-- Form Group (email address)-->
                    <div>
                        <label class="small mb-1" for="inputEmailAddress">Email адрес</label>
                        <input class="form-control mb-3 <?php if (isset($errors['email'])): ?>error--input<?php endif ?>" id="inputEmailAddress" name="email" type="email" placeholder="Введи Ваш Email" value="<?=$user['email']?>">
                        <?php if (isset($errors['email'])): ?><span class="error-lk"><?=$errors['email']?></span><?php endif ?>
                    </div>
                    <div>
                        <?php if ($user['subscription'] == 1): ?>
                            <span class="small mb-1">Вы подписаны на нашу рассылку по email</span>
                            <input type="checkbox" class="btn-check" id="checkboxNo" name="checkboxNo" autocomplete="off" value="no">
                            <label class="btn btn-outline-danger" for="checkboxNo">Хотите отписаться?</label><br>
                        <?php else: ?>
                            <span class="small mb-1">Подпишитесь на нашу рассылку по email</span>
                            <input type="checkbox" class="btn-check" id="checkboxYes" name="checkboxYes" autocomplete="off" value="yes">
                            <label class="btn btn-outline-success" for="checkboxYes">Подписаться?</label><br>
                        <?php endif ?>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1" for="inputEmailAddress">Расскажите о себе</label>
                        <textarea class="form-control mb-3" name="description" id="description"><?=$user['description']?></textarea>
                    </div>
                    <button class="btn btn-success" id="saveProfile" type="submit">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/footer.php';