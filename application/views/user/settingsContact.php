<div class="content flex-aside">
  <div class="settings-block user__block">
    <div class="settings-block-header">
      Основне
    </div>
    <div class="settings-block-body">
      <form class="settings-form" method="post">
        <?php
          $skype = '';
          $site = '';
        foreach ($user_info as $info) {
          if($info['it_id']=='6') {
            $skype = $info['ui_description'];
          }
          if($info['it_id']=='2') {
            $site = $info['ui_description'];
          }
        } ?>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Skype:
          </div>
          <div class="settings-form-input">
            <input class="settings-input" type="text" name="skype" value="<?php echo $skype; ?>">
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Особистий сайт:
          </div>
          <div class="settings-form-input">
            <input class="settings-input" type="text" name="site" value="<?php echo $site; ?>">
          </div>
        </div>
        <div class="settings-form-submit">
          <input class="settings-submit" type="submit" name="additionalSettings" value="Зберегти">
        </div>
      </form>
    </div>
  </div>
  <div class="user__block settings-aside">
    <div class="aside-filter">
      <ul class="filter-list">
        <li class="settigns-aside-general"><a href="/diploma/settings">Основна інформація</a></li>
        <li class="settigns-aside-contact choosen"><a href="#">Контакти</a></li>
        <li class="settings-aside-additional"><a href="?act=additional">Додаткова інформація</a></li>
      </ul>
      <ul class="filter-list">
        <li class="settings-aside-confidentiality "><a href="?act=confidentiality">Конфіденційність</a></li>
      </ul>
    </div>
  </div>
</div>
