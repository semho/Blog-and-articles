<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; ?>

<h1><?=$title?></h1>
<div class="wrapper-table-comments">
    <table class="table table-striped table-hover table-comments">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Комментарий</th>
                <th scope="col">К статье</th>
                <th scope="col">Email автора</th>
                <th scope="col">Модерация пройдена</th>
                <th scope="col">Изменить</th>
                <th scope="col">Удалить</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comments as $curentComment): ?>
                <tr>
                    <th scope="row"><?=$curentComment['id']?></th>
                    <td><?=$curentComment['text']?></td>
                    <td><?=$curentComment['post']?></td>
                    <td><?=$curentComment['email']?></td>
                    <td><?=$curentComment['is_check']?></td>
                    <td>
                        <a href="/admin/comments/<?=$curentComment['id']?>">
                            <img src="/img/users/change.png" width="20px" alt="Редактировать">
                        </a>
                    </td>
                    <td>
                        <a href="#" class="link-delete-comment" data-bs-comment="<?=$curentComment['id']?>">
                            <img src="/img/users/delete.png" width="20px" alt="Удалить">
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
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
                    <a class="page-link" aria-label="Previous" href="/admin/comments?page=<?=($page - 1)?>&count=<?=$countRecords?>" >
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $pages; $i++) : ?>
                    <li class="page-item <?=($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="/admin/comments?page=<?=$i?>&count=<?=$countRecords?>"><?=$i?></a>
                    </li>
                <?php endfor ?>
                <li class="page-item <?=(($count - $start) <= $countRecords) ? 'disabled' : ''; ?>">
                    <a class="page-link" aria-label="Next" href="/admin/comments?page=<?=($page + 1)?>&count=<?=$countRecords?>" >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
        
            </ul>
        </nav>
    <?php endif ?>
    </div>
</div>


<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; ?>