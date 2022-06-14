<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_header.php'; ?>
<h1><?=$title?></h1>
<div class="row">
    <div class="col-xl-6">
        <h3><?=$titleNoAuth?></h3>
        <div class="wrapper-table-no-auth-subscriptions">
            <table class="table table-striped table-hover table-no-auth-subscriptions">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Email</th>
                        <th scope="col">Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersNoAuth as $curentUsersNoAuth): ?>
                        <tr>
                            <th scope="row"><?=$curentUsersNoAuth->id?></th>
                            <td><?=$curentUsersNoAuth->email?></td>
                            <td>
                                <a href="#" class="link-delete-no-auth-subscription" data-bs-no-auth-subscription="<?=$curentUsersNoAuth->id?>">
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
                <label class="small mb-1" for="adminRecordsSelectNoAuth">Показывать записи по</label>
                <select class="form-select" id="adminRecordsSelectNoAuth" name="adminRecordsSelectNoAuth">
                    <option value="10" <?php if ($countRecordsNoAuth == 10): ?>selected<?php endif?>>10</option>
                    <option value="20" <?php if ($countRecordsNoAuth == 20): ?>selected<?php endif?>>20</option>
                    <option value="50" <?php if ($countRecordsNoAuth == 50): ?>selected<?php endif?>>50</option>
                    <option value="200" <?php if ($countRecordsNoAuth == 200): ?>selected<?php endif?>>200</option>
                    <option value="<?=$countNoAuth?>" <?php if ($countRecordsNoAuth == $countNoAuth): ?>selected<?php endif?>>Все</option>
                </select>
            </div>
            <?php if ($countRecordsNoAuth < $countNoAuth) : ?>
            <div class="col-xl-6 d-flex justify-content-end">
                <nav class="nav-pagination mt-4" aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?=($startNoAuth == 0) ? 'disabled' : ''; ?>">
                            <a class="page-link" aria-label="Previous" href="/admin/subscriptions?pageNoAuth=<?=($pageNoAuth - 1)?>&countNoAuth=<?=$countRecordsNoAuth?>&pageAuth=<?=$pageAuth?>&countAuth=<?=$countRecordsAuth?>" >
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $pagesNoAuth; $i++) : ?>
                            <li class="page-item <?=($pageNoAuth == $i) ? 'active' : ''; ?>">
                                <a class="page-link" href="/admin/subscriptions?pageNoAuth=<?=$i?>&countNoAuth=<?=$countRecordsNoAuth?>&pageAuth=<?=$pageAuth?>&countAuth=<?=$countRecordsAuth?>"><?=$i?></a>
                            </li>
                        <?php endfor ?>
                        <li class="page-item <?=(($countNoAuth - $startNoAuth) <= $countRecordsNoAuth) ? 'disabled' : ''; ?>">
                            <a class="page-link" aria-label="Next" href="/admin/subscriptions?pageNoAuth=<?=($pageNoAuth + 1)?>&countNoAuth=<?=$countRecordsNoAuth?>&pageAuth=<?=$pageAuth?>&countAuth=<?=$countRecordsAuth?>" >
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                
                    </ul>
                </nav>
            </div>
            <?php endif ?>
        </div>
    </div>
    <div class="col-xl-6">
        <h3><?=$titleAuth?></h3>
        <div class="wrapper-table-auth-subscriptions">
            <table class="table table-striped table-hover table-auth-subscriptions">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Email</th>
                        <th scope="col">Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usersAuth as $curentUsersAuth): ?>
                        <tr>
                            <th scope="row"><?=$curentUsersAuth->id?></th>
                            <td><?=$curentUsersAuth->email?></td>
                            <td>
                                <a href="#" class="link-delete-auth-subscription" data-bs-auth-subscription="<?=$curentUsersAuth->id?>">
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
                <label class="small mb-1" for="adminRecordsSelectAuth">Показывать записи по</label>
                <select class="form-select" id="adminRecordsSelectAuth" name="adminRecordsSelectAuth">
                    <option value="10" <?php if ($countRecordsAuth == 10): ?>selected<?php endif?>>10</option>
                    <option value="20" <?php if ($countRecordsAuth == 20): ?>selected<?php endif?>>20</option>
                    <option value="50" <?php if ($countRecordsAuth == 50): ?>selected<?php endif?>>50</option>
                    <option value="200" <?php if ($countRecordsAuth == 200): ?>selected<?php endif?>>200</option>
                    <option value="<?=$countAuth?>" <?php if ($countRecordsAuth == $countAuth): ?>selected<?php endif?>>Все</option>
                </select>
            </div>
            <?php if ($countRecordsAuth < $countAuth) : ?>
            <div class="col-xl-6 d-flex justify-content-end">
                <nav class="nav-pagination mt-4" aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?=($startAuth == 0) ? 'disabled' : ''; ?>">
                            <a class="page-link" aria-label="Previous" href="/admin/subscriptions?pageNoAuth=<?=$pageNoAuth?>&countNoAuth=<?=$countRecordsNoAuth?>&pageAuth=<?=($pageAuth - 1)?>&countAuth=<?=$countRecordsAuth?>" >
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($j = 1; $j <= $pagesAuth; $j++) : ?>
                            <li class="page-item <?=($pageAuth == $j) ? 'active' : ''; ?>">
                                <a class="page-link" href="/admin/subscriptions?pageNoAuth=<?=$pageNoAuth?>&countNoAuth=<?=$countRecordsNoAuth?>&pageAuth=<?=$j?>&countAuth=<?=$countRecordsAuth?>"><?=$j?></a>
                            </li>
                        <?php endfor ?>
                        <li class="page-item <?=(($countAuth - $startAuth) <= $countRecordsAuth) ? 'disabled' : ''; ?>">
                            <a class="page-link" aria-label="Next" href="/admin/subscriptions?pageNoAuth=<?=$pageNoAuth?>&countNoAuth=<?=$countRecordsNoAuth?>&pageAuth=<?=($pageAuth + 1)?>&countAuth=<?=$countRecordsAuth?>" >
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                
                    </ul>
                </nav>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . VIEW_DIR . 'layout/admin_footer.php'; ?>