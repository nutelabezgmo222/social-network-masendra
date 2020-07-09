<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/diploma/public/css/style.css">
        <link rel="stylesheet" href="/diploma/public/css/feed.css">
        <link rel="stylesheet" href="/diploma/public/css/master.css">
    </head>
    <body class="body">
      <header class="header">
        <div class="wrapper">
          <div class="header__body">
            <div class="header__logo">
              <span class="header__logo-picture picture-s"></span>
              <span class="header__logo-title">Masendra</span>
            </div>
            <div class="header__search">
              <span class="header__search-picture search picture-s"></span>
              <input type="text" placeholder="Пошук">
            </div>
            <div class="header__navigation">
              <span class="header__nagivation-picture feed-icon picture-s"></span>
              <span class="header__nagivation-picture settings-icon picture-s"></span>
              <span class="header__nagivation-picture notifications-icon picture-s"></span>
              <span class="header__nagivation-picture home-icon picture-s"></span>
            </div>
          </div>
        </div>
      </header>
      <main class="main">
        <div class="wrapper main-wrapper">
          <div class="main__aside-navigation">
            <ul class="main__navigation">
              <li class="main__navigation-item"><a href="/diploma/"><span class="main__navigation-picture home-icon picture-s"></span> Моя сторінка</a></li>
              <li class="main__navigation-item"><a href="/diploma/feed"><span class="main__navigation-picture feed-icon picture-s"></span> Новини</a></li>
              <li class="main__navigation-item">
                <a href="/diploma/messages">
                  <span class="main__navigation-picture message picture-s"></span>
                   Повідомлення
                   <?php  if(!empty($new_messages_counter)): ?>
                   <span class="new-message-counter">+<?php echo $new_messages_counter; ?></span>
                 <?php endif; ?>
                 </a>
               </li>
              <li class="main__navigation-item">
                <a href="/diploma/friends">
                  <span class="main__navigation-picture friend picture-s"></span>
                   Друзі
                   <?php  if(!empty($new_friends_counter)): ?>
                   <span class="new-friends-counter">+<?php echo $new_friends_counter; ?></span>
                 <?php endif; ?>
                 </a>
               </li>
              <li class="main__navigation-item"><a href="/diploma/albums"><span class="main__navigation-picture photo picture-s"></span> Публікації</a></li>
            </ul>
            <?php if(!empty($mutual_friends)): ?>
            <ul class="main__recommendation">
              <li class="main__navigation-inscription">Рекомендації для вас</li>
              <?php foreach ($mutual_friends as $friend): ?>
              <li class="main__navigation-item">
                <a href="/diploma/id/<?php echo $friend['subscription_u_id']; ?>" class="follow">
                  <?php echo $friend['u_first_name'] . ' ' . $friend['u_second_name'];?>
                </a><span><?php echo $friend['mutualFriends']; ?> спільних друзів</span>
            <?php endforeach; ?>
            </ul>
          <?php endif; ?>
          </div>
          <?php echo $content; ?>
        </div>
      </main>
      <div class="main__settings hide">
        <div class="settings__block">
          <ul class="settings__list col-list">
            <li class="settings-personal-data">Особисті дані</li>
            <li class="settings-confidentiality">Конфіденційність</li>
            <li class="settings-out">Вийти</li>
            <li class="settings-cancel">Відміна</li>
          </ul>
        </div>
      </div>
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
              <li><a href="#">Конфіденційність</a> </li>
              <li><a href="#">Популярні люди</a> </li>
            </ul>
          </div>
          <div class="footer__author">
            © Masendra від Масика, 2020
          </div>
        </div>
      </footer>
      <script src="/diploma/public/scripts/jquery-3.4.1.min.js"></script>
      <script src="/diploma/public/scripts/form.js"></script>
      <script src="/diploma/public/scripts/main.js"></script>
      <script src="/diploma/public/scripts/search.js"></script>
      <script src="/diploma/public/scripts/chat.js"></script>
      <script src="/diploma/public/scripts/settings.js"></script>
    </body>
</html>
