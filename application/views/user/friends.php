<div class="content flex-aside">
  <div class="friends user__block">
    <div class="friends-header">
      <ul class="friends-header-list">
        <li class="fr-all-sec <?php if($section=='all') echo 'choosen';?>"><a href="?sec=all&usr=<?php echo $usr['u_id']; ?>">Усі друзі <?php echo $friend_counter; ?></a></li>
        <li class="fr-online-sec <?php if($section=='online') echo 'choosen';?>"><a href="?sec=online&usr=<?php echo $usr['u_id']; ?>">Друзі онлайн</a></li>
      </ul>
      <a href="/diploma/id/<?php echo $usr['u_id']; ?>" class="button find-friends light-blue-color" type="button" name="button">Повернутися на сторінку</a>
    </div>
    <div class="friends-search-block">
      <span class="search picture-s"></span>
      <input class="search-row friends-search-row" type="text" placeholder="Пошук друзів">
    </div>
    <div class="friends-list">
      <?php if(empty($user_list)): ?>
        <div class="friend-list-empty">
          <p>Список друзів порожній</p>
        </div>
      <?php else: ?>
        <?php foreach ($user_list as $user):?>
      <div class="friend-list-item" data-id="<?php echo $user['u_id']; ?>" data-name="<?php echo $user['u_first_name']; ?>" data-surname = "<?php echo $user['u_second_name']; ?>">
        <div class="friend-icon">
          <a href="/diploma/id/<?php echo $user['u_id']; ?>">
          <?php if($user['u_avatar'] == 1): ?>
            <img src="/diploma/public/materials/<?php echo $user['u_id']; ?>/main/1.png" alt="">
          <?php else: ?>
            <img src="/diploma/public/materials/standart/male.png" alt="">
          <?php endif; ?>
          </a>
          <a href="#"></a>
        </div>
        <div class="friend-name">
          <a class="name" href="/diploma/id/<?php echo $user['u_id']; ?>"><?php echo $user['u_first_name'].' '.$user['u_second_name']; ?></a>
          <?php if($user['u_id'] != $_SESSION['user']['id']): ?>
            <a class="message" href="/diploma/messages?usr=<?php echo $user['u_id']; ?>">Повідомлення</a>
          <?php endif; ?>
        </div>
        <div class="friend additional">
          <ul class="additional-list hide">
            <li><a href="/diploma/friends?sec=all&id=<?php echo $user['u_id']; ?>">Переглянути друзів</a></li>
            <li class="remove-friend">Видалити їз друзів</li>
          </ul>
        </div>
      </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <div class="user__block friends-aside">
    <div class="aside-filter">
      <ul class="filter-list">
        <li class="filter-all-friends choosen">
          <a href="?sec=all">
            <?php if($usr['u_id'] == $_SESSION['user']['id']) echo 'Мої друзі';
              else echo 'Друзі ' . $usr['u_first_name']; ?>
          </a>
        </li>
        <li class="filter-subscriptions"><a href="?sec=all_request&usr=<?php echo $usr['u_id']; ?>">Підписки</a></li>
        <li class="filter-subscriptions"><a href="?act=find">Пошук друзів</a></li>
      </ul>
    </div>
  </div>
</div>
