<div class="content flex-aside">
  <div class="settings-block user__block">
    <div class="settings-errors-block">
      <div class="settings-error">

      </div>
      <span class="setting-error-close"></span>
    </div>
    <div class="settings-block-header">
      Основне
    </div>
    <div class="settings-block-body">
      <form class="settings-form" method="post">
        <div class="settings-form-group">
          <div class="settings-form-label">
            Ім'я:
          </div>
          <div class="settings-form-input">
            <input class="settings-input" type="text" name="name" value="<?php echo $user['u_first_name']; ?>">
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Фамілія:
          </div>
          <div class="settings-form-input">
            <input class="settings-input" type="text" name="surname" value="<?php echo $user['u_second_name']; ?>">
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Стать:
          </div>
          <div class="settings-form-input">
            <select class="settings-input" name="gender">
              <option <?php if($user['u_gender']==0) echo 'selected';?> value="0">Чоловіча</option>
              <option <?php if($user['u_gender']==1) echo 'selected';?> value="1">Жіноча</option>
            </select>
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Дата народження:
          </div>
          <div class="settings-form-input">
            <input class="settings-input" type="date" value="<?php echo $user['birthday']; ?>" name="birthday" >
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Країна:
          </div>
          <div class="settings-form-input">
            <select class="settings-input country-input" name="country">
              <option value="0">Не вказано</option>
              <option <?php if($user['country_id']=='1') echo 'selected'; ?> value="1">Україна</option>
              <option <?php if($user['country_id']=='2') echo 'selected'; ?> value="2">Білорусь</option>
              <option <?php if($user['country_id']=='3') echo 'selected'; ?> value="3">Росія</option>
            </select>
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Місто:
          </div>
          <div class="settings-form-input">
            <select class="settings-input cities-input" <?php if(!isset($user['country_id'])) echo 'disabled'; ?> name="town">
              <?php if(isset($cities)): ?>
              <?php foreach ($cities as $city):?>
                <option <?php if($user['city_id'] == $city['city_id']) echo 'selected'; ?> value="<?php echo $city['city_id']; ?>"><?php echo $city['city_title']; ?></option>
              <?php endforeach; ?>
            <?php else: ?>
              <option value="">Не вказано</option>
              <?php endif; ?>
            </select>
          </div>
        </div>
        <?php
          $hometown = '';
          $inst = '';
        foreach ($user_info as $info) {
          if($info['it_id']=='4') {
            $hometown = $info['ui_description'];
          }
          if($info['it_id']=='3') {
            $inst = $info['ui_description'];
          }
        } ?>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Рідне місто:
          </div>
          <div class="settings-form-input">
            <input class="settings-input" type="text" name="hometown" value="<?php echo $hometown; ?>">
          </div>
        </div>
        <div class="settings-form-group">
          <div class="settings-form-label">
            Місце навчання:
          </div>
          <div class="settings-form-input">
            <input class="settings-input" type="text" name="institute" value="<?php echo $inst; ?>">
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
        <li class="settigns-aside-general choosen"><a href="#">Основна інформація</a></li>
        <li class="settigns-aside-contact"><a href="?act=contact">Контакти</a></li>
        <li class="settings-aside-additional"><a href="?act=additional">Додаткова інформація</a></li>
      </ul>
      <ul class="filter-list">
        <li class="settings-aside-confidentiality "><a href="?act=confidentiality">Конфіденційність</a></li>
      </ul>
    </div>
  </div>
</div>
