<div class="content flex-aside">
  <div class="settings-block user__block">
    <div class="settings-block-header">
      Конфіденційність
    </div>
    <div class="settings-block-body">
      <form class="settings-form" method="post">
        <div class="settings-form-group">
          <div class="settings-form-label">
            Хто може бачити мої публікації та інформацію про мене:
          </div>
          <div class="settings-form-input">
            <select class="settings-input" name="u_access">
              <option <?php if($settings['u_access'] == 0) echo 'selected'; ?> value="0">Усі</option>
              <option <?php if($settings['u_access'] == 1) echo 'selected'; ?> value="1">Тільки друзі</option>
            </select>
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Хто може комментувати мої публікації:
          </div>
          <div class="settings-form-input">
            <select class="settings-input" name="p_access">
              <option <?php if($posts_access == 0) echo 'selected'; ?> value="0">Усі</option>
              <option <?php if($posts_access == 1) echo 'selected'; ?> value="1">Тільки друзі</option>
              <option <?php if($posts_access == 2) echo 'selected'; ?> value="2">Ніхто</option>
              <option <?php if($posts_access == 3) echo 'selected'; ?> value="3">Власні налаштування</option>
            </select>
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Хто може писати мені повідомлення:
          </div>
          <div class="settings-form-input">
            <select class="settings-input" name="u_m_access">
              <option <?php if($settings['u_message_access'] == 0) echo 'selected'; ?> value="0">Усі (окрім заблокованних)</option>
              <option <?php if($settings['u_message_access'] == 1) echo 'selected'; ?> value="1">Тільки друзі</option>
              <option <?php if($settings['u_message_access'] == 2) echo 'selected'; ?> value="2">Ніхто</option>
            </select>
          </div>
        </div>
        <div class="settings-form-submit">
          <input class="settings-submit" type="submit" name="confidentialityButton" value="Зберегти">
        </div>
      </form>
    </div>
  </div>
  <div class="user__block settings-aside">
    <div class="aside-filter">
      <ul class="filter-list">
        <li class="settigns-aside-general"><a href="/diploma/settings">Основна інформація</a></li>
        <li class="settigns-aside-contact"><a href="?act=contact">Контакти</a></li>
        <li class="settings-aside-additional"><a href="?act=additional">Додаткова інформація</a></li>
      </ul>
      <ul class="filter-list">
        <li class="settings-aside-confidentiality choosen"><a>Конфіденційність</a></li>
      </ul>
    </div>
  </div>
</div>
