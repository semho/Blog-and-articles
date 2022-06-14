<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/header.php'; ?>
<?php if ($_COOKIE['email'] ??  '') ?>
    <div class="container mt-4">
		<div class="row">
			<div class="col">
                <h2><?=$title?></h2>
                <!-- Форма авторизации -->
                <form action="auth" method="post" id="formAuth">
                    <input type="email" class="form-control mb-3 <?php if (isset($errors['email']) || isset($errors['currentUser'])): ?>error--input<?php endif ?>" name="email" id="email" placeholder="Введите email" value="<?= $_POST['email'] ?? $_COOKIE['email'] ??  '' ?>" required>
                    <?php if (isset($errors['email'])): ?><span class="error-login"><?=$errors['email']?></span><?php endif ?>
                    <?php if (isset($errors['currentUser'])): ?><span class="error-login"><?=$errors['currentUser']?></span><?php endif ?>
                    <input type="password" class="form-control mb-3 <?php if (isset($errors['password']) || isset($errors['noPassword'])): ?>error--input<?php endif ?>" name="password" id="pass" placeholder="Введите пароль" value="<?=(isset($_POST['password'])) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
                    <?php if (isset($errors['password'])): ?><span class="error-login"><?=$errors['password']?></span><?php endif ?>
                    <?php if (isset($errors['noPassword'])): ?><span class="error-login"><?=$errors['noPassword']?></span><?php endif ?>
                    <button class="btn btn-success" name="doAuth" id="doAuth" type="submit">Авторизоваться</button>
                </form>
                <br>
                <p>Если вы еще не зарегистрированы, тогда нажмите <a href="/reg">здесь</a>.</p>
                <p>Вернуться на <a href="/">главную</a>.</p>
                <?php if (isset($error) && !empty($error)) : ?>
                    <p class="error error-server"><?=$error?></p>
                <?php endif ?>
			</div>
		</div>
	</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/footer.php';
