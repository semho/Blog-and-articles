<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/js/main.js" defer></script>
    <title>Document</title>
</head>
<body>
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
            <h3>Hiking trips</h3>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="/" class="nav-link px-2 link-secondary">Главная</a></li>
            <li><a href="/about" class="nav-link px-2 link-dark">О нас</a></li>
            <?php if (isset($listStaticPages)): ?>
                <?php foreach ($listStaticPages as $staticPage): ?>
                    <li><a href="/static/<?=$staticPage['slug']?>" class="nav-link px-2 link-dark"><?=$staticPage['title']?></a></li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
        <div class="text-end">
            <?php if (isset($user)) : ?>
                <a href="/lk" class="d-flex nav-link px-2 link-secondary lk-header align-items-center">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                        <metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon </metadata>
                        <g>
                            <path d="M500,10C228.8,10,10,228.8,10,500c0,271.3,218.8,490,490,490c271.3,0,490-218.8,490-490C990,228.8,771.3,10,500,10z M804.5,822C794,657.5,619,613.8,619,613.8s106.8-71.8,68.3-217c-19.3-75.3-91-131.3-189-131.3c-98,0-169.7,56-189,131.3c-38.5,145.2,68.2,217,68.2,217S202.5,652.3,192,822C109.7,739.7,57.3,626,57.3,500C57.3,255,255,57.3,500,57.3C745,57.3,942.8,255,942.8,500C942.8,626,890.2,739.7,804.5,822z"/>
                        </g>
                    </svg>
                    <span class="user"><?=$user->full_name?></span>
                </a>
                <a href="/logout" class="nav-link px-2 link-secondary">
                    <button type="button" class="btn btn-success">Выйти</button>
                </a>
            <?php else: ?>
                <a href="/auth" class="nav-link px-2 link-secondary">
                    <button type="button" class="btn btn-outline-success me-2">Войти</button>
                </a>
                <a href="/reg" class="nav-link px-2 link-secondary">
                    <button type="button" class="btn btn-success">Регистрация</button>
                </a>
            <?php endif ?>
        </div>
    </header>
    <main class="main pt-4">
        <div class="container">
        
        