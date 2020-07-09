<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/diploma/public/css/style.css">
        <link rel="stylesheet" href="/diploma/public/css/master.css">
        <link href="https://fonts.googleapis.com/css2?family=Gotu&display=swap" rel="stylesheet">
    </head>
    <body>
      <header class="header">
        <div class="wrapper">
          <div class="header__body">
            <div class="header__logo inscription-m">
              <span class="header__logo-picture picture-s"></span>
              <span class="header__logo-title">Masendra</span>
            </div>
          </div>
        </div>
      </header>
      <main class="main">
        <div class="wrapper">
          <?php echo $content; ?>
        </div>
      </main>
      <div class="body-cat-img">
        <div class="cat-error-block">
        </div>
      </div>
      <footer class="footer">
        <div class="wrapper">
          <div class="footer__links">
            <ul class="user__list">
              <li><a href="#">Інформація</a></li>
              <li><a href="#">Допомога</a></li>
              <li><a href="#">Конфіденціальність</a> </li>
              <li><a href="#">Популярні люди</a> </li>
            </ul>
          </div>
          <div class="footer__author">
            © Masendra від Масика, 2020
          </div>
        </div>
      </footer>
      <script src="/diploma/public/scripts/jquery-3.4.1.min.js"></script>
      <script src="/diploma/public/scripts/register.js"></script>
    </body>
</html>
