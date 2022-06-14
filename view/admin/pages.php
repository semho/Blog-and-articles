<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; ?>
<h1><?=$title?></h1>
<div class="wrapper-table-pages">
    <table class="table table-striped table-hover table-pages">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Заголовок</th>
                <th scope="col">ЧПУ</th>
                <th scope="col">Изменить</th>
                <th scope="col">Удалить</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pages as $curentPage): ?>
                <tr>
                    <th scope="row"><?=$curentPage->id?></th>
                    <td><?=$curentPage->title?></td>
                    <td><?=$curentPage->slug?></td>
                    <td>
                        <a href="/admin/pages/<?=$curentPage->id?>">
                            <img src="/img/users/change.png" width="20px" alt="Редактировать">
                        </a>
                    </td>
                    <td>
                        <a href="#" class="link-delete-page" data-bs-page="<?=$curentPage->id?>">
                            <img src="/img/users/delete.png" width="20px" alt="Удалить">
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <a href="/admin/add/page" class="nav-link px-2 link-secondary">
        <button type="button" class="btn btn-success">Добавить новую страницу</button>
    </a>
</div>

<div class="row">
    <div class="col-xl-6">
        <label class="small mb-1" for="adminRecordsSelect">Показывать записи по</label>
        <select class="form-select" id="adminRecordsSelect" name="adminRecordsSelect">
            <option value="10" <?php if ($countRecords == 10): ?>selected<?php endif?>>10</option>
            <option value="20" <?php if ($countRecords == 20): ?>selected<?php endif?>>20</option>
            <option value="50" <?php if ($countRecords == 50): ?>selected<?php endif?>>50</option>
            <option value="200" <?php if ($countRecords == 200): ?>selected<?php endif?>>200</option>
            <option value="<?=$count?>" <?php if ($countRecords == $count): ?>selected<?php endif?>>Все</option>
        </select>
    </div>
    <?php if ($countRecords < $count) : ?>
    <div class="col-xl-6 d-flex justify-content-end">
        <nav class="nav-pagination mt-4" aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?=($start == 0) ? 'disabled' : ''; ?>">
                    <a class="page-link" aria-label="Previous" href="/admin/pages?page=<?=($pageGet - 1)?>&count=<?=$countRecords?>" >
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $pagesCount; $i++) : ?>
                    <li class="page-item <?=($pageGet == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="/admin/pages?page=<?=$i?>&count=<?=$countRecords?>"><?=$i?></a>
                    </li>
                <?php endfor ?>
                <li class="page-item <?=(($count - $start) <= $countRecords) ? 'disabled' : ''; ?>">
                    <a class="page-link" aria-label="Next" href="/admin/pages?page=<?=($pageGet + 1)?>&count=<?=$countRecords?>" >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
        
            </ul>
        </nav>
    <?php endif ?>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; ?>