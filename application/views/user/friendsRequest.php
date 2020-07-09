<div class="content flex-aside">
  <div class="friends user__block">
    <div class="friends-header">
      <ul class="friends-header-list">
        <li class="<?php if($section =='all_request') echo 'choosen'; ?>"><a href="?sec=all_request&usr=<?php echo $usr['u_id'];?>">Вхідні</a></li>
        <li class="<?php if($section =='out_request') echo 'choosen'; ?>"><a href="?sec=out_request&usr=<?php echo $usr{'u_id'}; ?>">Вихідні</a></li>
      </ul>
      <a href="/diploma/id/<?php echo $usr['u_id']; ?>" class="button find-friends light-blue-color" type="button" name="button">Повернутися на сторінку</a>
    </div>
    <div class="friends-list hr-top">
      <?php if(empty($users_list)): ?>
        <div class="friend-list-empty">
          Список порожній
        </div>
      <?php endif; ?>
      <?php foreach ($users_list as $user): ?>
      <div class="friend-list-item" data-id="<?php echo $user['u_id']; ?>">
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
          <a class="name" href="/diploma/id/<?php echo $user['u_id']; ?>"><?php echo $user['u_first_name'] . ' ' . $user['u_second_name'];?></a>
          <?php if($_SESSION['user']['id'] != $user['u_id']): ?>
            <?php if($this->route['sec']=='out_request'): ?>
            <a class="Mrsubscribeb item-button carrot-color" data-id="<?php echo $user['u_id']; ?>" href="#">Відписатися</a>
            <?php else: ?>
            <a class="Matfriendb item-button light-blue-color" data-id="<?php echo $user['u_id']; ?>" href="#">Додати до друзів</a>
        <?php endif; ?>
        <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="user__block friends-aside">
    <div class="aside-filter">
      <ul class="filter-list">
        <li class="filter-all-friends">
          <a href="?sec=all&usr=<?php echo $usr['u_id'];?>">
            <?php if($usr['u_id'] == $_SESSION['user']['id']) echo 'Мої друзі';else echo 'Друзі ' . $usr['u_first_name']; ?>
          </a>
        </li>
        <li class="filter-subscriptions choosen"><a href="#">Підписки</a></li>
        <li class="filter-subscriptions"><a href="?act=find">Пошук друзів</a></li>
      </ul>
    </div>
  </div>
</div>
