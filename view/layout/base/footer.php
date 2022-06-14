
        </div>
    </main>
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Главная</a></li>
            <li class="nav-item"><a href="/about" class="nav-link px-2 text-muted">О нас</a></li>
            <?php if (isset($listStaticPages)): ?>
                <?php foreach ($listStaticPages as $staticPage): ?>
                    <li><a href="/static/<?=$staticPage['slug']?>" class="nav-link px-2 text-muted"><?=$staticPage['title']?></a></li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
        <p class="text-center text-muted">© 2021 Company, Inc</p>
    </footer>
</body>
</html>