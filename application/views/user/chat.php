<div class="content flex-aside">
  <div class="chat user__block">
    <div class="chat-header">
      <div>
        <a class="chat-back" href="/diploma/messages">Назад</a>
      </div>
      <div class="person-page-title">
        <div class="person-page-title-main">
          <a href="/diploma/id/<?php echo $companion['u_id']; ?>"><?php echo $companion['u_first_name'] .' '. $companion['u_second_name']; ?></a>
        </div>
        <div class="person-page-title-status">
          <?php if($companion['is_online'] == 1):?>
            Онлайн
          <?php else: ?>
          <?php echo 'Був онлайн ' . onlineWard($companion['last_action']); ?>
        <?php endif; ?>
        </div>
      </div>
      <div class="chat-additional">
        <div class="tree-dots">
          <span class="middle-dot"></span>
          <ul class="chat-additional-list" data-id='<?php echo $companion['u_id']; ?>'>
            <li class="remove-chat-history">Видалити історію повідомлень</li>
            <?php if(!empty($isBlock)): ?>
              <?php if($isBlock[0]['u_id'] == $_SESSION['user']['id'] || count($isBlock) > 1): ?>
                <li class="unblock-user">Розблокувати користувача</li>
              <?php else: ?>
                <li class="block-user">Заблокувати користувача</li>
              <?php endif; ?>
          <?php elseif($companion['u_id'] != $_SESSION['user']['id']): ?>
            <li class="block-user">Заблокувати користувача</li>
          <?php endif; ?>
          </ul>
        </div>
        <div class="person-page-icon">
          <a href="/diploma/id/<?php echo $companion['u_id']; ?>">
            <img src="/diploma/public/materials/<?php echo $companion['u_id'];?>/main/1.png" alt="img">
          </a>
        </div>
      </div>
    </div>
      <div class="chat-body">
        <?php if(!empty($chatStory)): ?>
          <?php
          $currentDay = $chatStory[0]['m_day'];
          $currentMonth = $chatStory[0]['m_month'];
          $currentYear = $chatStory[0]['m_year'];
        ?>
        <div class="chat-time-block"> <p><?php echo $currentDay . ' ' .$currentMonth; ?> </p></div>
      <?php else: ?>
        <div class="chat-no-message">
          Історія повідомлень відсутня.
        </div>
      <?php endif; ?>
        <?php foreach ($chatStory as $message): ?>
          <?php if($currentDay != $message['m_day'] || $currentMonth != $message['m_month']): ?>
          <?php
            $currentDay = $message['m_day'];
            $currentMonth = $message['m_month'];
            $currentYear = $message['m_year'];
          ?>
          <div class="chat-time-block"><?php echo $currentDay . ' ' .$currentMonth; ?></div>
        <?php endif; ?>
        <div class="chat-message <?php if($message['m_isRead'] == 0) echo 'unread'; ?> <?php if($message['u_id'] == $_SESSION['user']['id']) echo "user-message"; ?>" data-id="<?php echo $message['m_id']; ?>">
          <div class="person-page-icon">
            <a href="/diploma/id/<?php echo $message['u_id']; ?>">
              <img src="/diploma/public/materials/<?php echo $message['u_id']; ?>/main/1.png" alt="">
            </a>
          </div>
          <div class="message-content">
            <div class="person-name-block">
              <span class="person-name"><?php echo $message['u_first_name'] . ' '.$message['u_second_name']; ?></span>
              <span class="message-time"><?php echo getTime($message['m_date']); ?></span>
            </div>
            <div class="message-content-message">
              <?php echo $message['m_content']; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    <div class="chat-footer">
      <?php if(empty($isBlock)): ?>
        <?php if($companion['u_message_access'] == 2): ?>
          <div class="chat-footer-block">
            Користувач обмежив коло людей які можуть надсилати йому повідомлення.
          </div>
        <?php else: ?>
      <div class="chat-input">
        <textarea class="message-value" placeholder="Напишіть повідомлення..."></textarea>
        <span class="message-send"></span>
      </div>
    <?php endif; ?>
    <?php else: ?>
      <?php if($isBlock[0]['u_id'] == $_SESSION['user']['id']): ?>
        <div class="chat-footer-block">
          Ви не можете надсилати повідомлення користувачу якого ви заблокували.
        </div>
      <?php else: ?>
        <div class="chat-footer-block">
          Цей користувач заборонив вам надсилати йому повідомлення.
        </div>
      <?php endif; ?>
    <?php endif; ?>
    </div>
  </div>
  <div class="user__block messages-aside">
    <div class="aside-filter">
      <ul class="filter-list">
        <li class="all-messages"><a href="/diploma/messages">Усі повідомлення</a></li>
        <li class="new-messages"><a href="?sec=unread">Непрочитані</a></li>
      </ul>
    </div>
    <div class="aside-dialogs aside-filter">
      <ul class="filter-list dialogs-list">
        <?php if(isset($_SESSION['chats']['users'])): ?>
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
</div>
