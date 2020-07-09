<div class="content flex-aside">
  <div class="settings-block settings-additional user__block">
    <div class="settings-block-header">
      Додаткове
    </div>
    <div class="settings-block-body">
      <form class="settings-form" method="post">
        <?php
          $activity = '';
          $hoby = '';
          $films = '';
          $biography = '';
        foreach ($user_info as $info) {
          if($info['it_id']=='5') {
            $activity = $info['ui_description'];
            continue;
          }
          if($info['it_id']=='7') {
            $hoby = $info['ui_description'];
            continue;
          }
          if($info['it_id']=='8') {
            $films = $info['ui_description'];
            continue;
          }
          if($info['it_id']=='9') {
            $biography = $info['ui_description'];
            continue;
          }
        } ?>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Діяльність:
          </div>
          <div class="settings-form-input">
            <textarea class="settings-input" name="activity"><?php echo $activity; ?></textarea>
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Захоплення:
          </div>
          <div class="settings-form-input">
            <textarea class="settings-input" name="hobby"><?php echo $hoby; ?></textarea>
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Улюблені фільми:
          </div>
          <div class="settings-form-input">
          <textarea class="settings-input" name="films"><?php echo $films; ?></textarea>
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Про себе:
          </div>
          <div class="settings-form-input">
            <textarea class="settings-input" name="biography"><?php echo $biography; ?></textarea>
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
        <li class="settigns-aside-contact"><a href="?act=contact">Контакти</a></li>
        <li class="settings-aside-additional choosen"><a href="#">Додаткова інформація</a></li>
      </ul>
      <ul class="filter-list">
        <li class="settings-aside-confidentiality "><a href="?act=confidentiality">Конфіденційність</a></li>
      </ul>
    </div>
  </div>
</div>
