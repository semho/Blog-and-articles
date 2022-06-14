<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/header.php'; ?>
<?php if ($_COOKIE['email'] ??  '') ?>
    <div class="container mt-4">
		<div class="row">
			<div class="col">
                <h2><?=$title?></h2>
                <!-- Форма регистрации -->
                <form action="reg" method="post" id="formReg">
                    <input type="text" class="form-control mb-3 <?php if (isset($errors['name'])): ?>error--input<?php endif ?>" name="fullName" id="fullName" placeholder="Введите Имя" value="<?=(isset($_POST['fullName'])) ? htmlspecialchars($_POST['fullName']) : ''; ?>" required>
                    <?php if (isset($errors['name'])): ?><span class="error-login"><?=$errors['name']?></span><?php endif ?>
                    <input type="email" class="form-control mb-3 <?php if (isset($errors['email'])): ?>error--input<?php endif ?>" name="newEmail" id="newEmail" placeholder="Введите Email" value="<?=(isset($_POST['newEmail'])) ? htmlspecialchars($_POST['newEmail']) : ''; ?>" required>
                    <?php if (isset($errors['email'])): ?><span class="error-login"><?=$errors['email']?></span><?php endif ?>
                    <input type="password" class="form-control mb-3 <?php if (isset($errors['password'])): ?>error--input<?php endif ?>" name="newPassword" id="newPassword" placeholder="Введите пароль" required>
                    <?php if (isset($errors['password'])): ?><span class="error-login"><?=$errors['password']?></span><?php endif ?>
                    <input type="password" class="form-control mb-3 <?php if (isset($errors['accuracyPassword'])): ?>error--input<?php endif ?>" name="newPassword2" id="newPassword2" placeholder="Повторите пароль" required>
                    <?php if (isset($errors['accuracyPassword'])): ?><span class="error-login"><?=$errors['accuracyPassword']?></span><?php endif ?>
                    <label for="checkbox">
                        <input type="checkbox" name="checkbox" value="yes" id="checkbox" required> Cогласен с <a href="/static/pravila-polzovaniya-saitom">правилами</a> сайта    
                    </label>
                    <?php if (isset($errors['check'])): ?><span class="error-login error-login--check"><?=$errors['check']?></span><?php endif ?>
                    <br>
                    <br>
                    <button class="btn btn-success" name="doReg" id="doReg" type="submit">Зарегистрировать</button>
                </form>
                <br>
                <p>Если вы зарегистрированы, тогда нажмите <a href="/auth">здесь</a>.</p>
                <p>Вернуться на <a href="/">главную</a>.</p>
                <?php if (isset($error) && !empty($error)) : ?>
                    <p class="error error-server"><?=$error?></p>
                <?php endif ?>
			</div>
		</div>
	</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/footer.php';
