<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/header.php'; ?>
    <h1><?=$title?></h1>
    <form class="formUnsubscribe mb-3" id="formUnsubscribe">
        <div>
            <label for="emailUnsubscribe" class="form-label">Введи Ваш email, чтобы отписаться от нашей рассылки</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">example@example.com</span>
                    <input type="email" class="form-control" id="emailUnsubscribe" name="email" aria-describedby="basic-addon3" required>
                    <button class="btn btn-outline-success" type="submit" id="buttonUnsubscribe">Отписаться</button>
                </div>
        </div>
    </form>
<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/footer.php';

    