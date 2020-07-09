<div class="content messages-block flex-aside">
  <div class="friends messages user__block ">
    <div class="friends-search-block">
      <span class="search picture-s"></span>
      <input class="search-row friends-search-row" type="text" placeholder="Пошук">
    </div>
    <div class="friends-list">
      <?php foreach ($chats as $chat): ?>
      <div class="friend-list-item friend-list-chat" data-id='<?php echo $chat['companion_id']; ?>' data-name="<?php echo $chat['u_first_name']; ?>" data-surname="<?php echo $chat['u_second_name']; ?>">
          <div class="friend-icon">
            <a href="/diploma/id/<?php echo $chat['companion_id']; ?>"><img src="/diploma/public/materials/<?php echo $chat['companion_id']; ?>/main/1.png" alt=""></a>
            <a href="#"></a>
          </div>
        <div class="friend-content">
          <div class="friend-name">
            <?php echo $chat['u_first_name'] . ' ' . $chat['u_second_name']; ?>
          </div>
          <?php if(!empty($chat['m_content'])): ?>
          <div class="friend-last-message <?php if($chat['m_isRead'] == 0) echo 'unread'; ?>" data-id="<?php echo $chat['last_message_id']; ?>">
          <?php if($chat['who_send_m'] == $_SESSION['user']['id']) echo 'Ви:' ?>  <?php echo $chat['m_content']; ?>
          </div>
          <div class="friend-last-message-time">
            <?php echo dateHandler($chat['m_date']); ?>
          </div>
          <?php if($chat['new_message_counter'] != 0) :?>
          <div class="friend-new-message-counter">
            <?php echo $chat['new_message_counter']; ?>
          </div>
          <?php endif; ?>
          <?php endif; ?>
          <div class="friend-delete-conversation cross-mark">
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  </div>
  <div class="user__block messages-aside">
    <div class="aside-filter">
      <ul class="filter-list">
        <li class="all-messages <?php if(!isset($this->route['sec'])) echo 'choosen'; ?>"><a href="/diploma/messages">Усі повідомлення</a></li>
        <li class="new-messages <?php if(isset($this->route['sec'])) echo 'choosen'; ?>"><a href="?sec=unread">Непрочитані</a></li>
      </ul>
    </div>
    <div class="aside-dialogs aside-filter">
    <?php if(isset($_SESSION['chats']['users'])): ?>
      <ul class="filter-list dialogs-list">
          <?php foreach ($_SESSION['chats']['users'] as $savedChat): ?>
        <li class="dialogs-list-item <?php if($savedChat['u_id'] == $this->route['usr']) echo 'choosen'; ?>">
          <a href="/diploma/messages?usr=<?php echo $savedChat['u_id']; ?>">
            <?php echo $savedChat['u_first_name'] . ' ' . $savedChat['u_second_name']; ?>
          </a>
          <div data-id="<?php echo $savedChat['u_id']; ?>" class="message-aside-remove cross-mark"></div>
        </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>
