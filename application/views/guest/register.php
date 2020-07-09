<div class="container flex">
  <div class="user__block register card">
    <div class="card__header">Вітаю до <span class="header__logo-title">Masendra</span>!</div>
    <div class="card__body">
      <form class="authorize__block form" method="POST" autocomplete="off">
        <div class="row">
          <div class="col-1-2">
            <div class="form_group">
              <label>Введіть імя</label>
              <div class="error_modal hide"></div>
              <input class="form_control" type="text" name="name" placeholder="Ваше імя"
              value="<?php echo isset($_SESSION['register']['name'])?$_SESSION['register']['name']:''; ?>">
            </div>
            <div class="form_group">
              <label>Введіть фамілію</label>
              <div class="error_modal hide"></div>
              <input class="form_control" type="text" name="surname" placeholder="Ваша фамілія"
              value="<?php echo isset($_SESSION['register']['surname'])?$_SESSION['register']['surname']:''; ?>">
            </div>
            <div class="form_group">
              <label>Придумайте логін</label>
              <div class="error_modal hide"></div>
              <input class="form_control" type="text" name="reg-login" placeholder="Ваш логін"
              value="<?php echo isset($_SESSION['register']['reg-login'])?$_SESSION['register']['reg-login']:''; ?>">
            </div>
          </div>
          <div class="col-1-2">
            <div class="form_group">
              <label>Вкажіть стать</label>
              <div class="error_modal hide"></div>
              <div class="radio_group">
                <div class="radio">
                  <label>Чоловіча</label>
                  <input class="form_control radio" type="radio" name="gender" value="0">
                </div>
                <div class="radio">
                  <label>Жіноча</label>
                  <input class="form_control radio" type="radio" name="gender" value="1">
                </div>
              </div>
            </div>
            <div class="form_group">
              <label>Придумайте пароль</label>
              <div class="error_modal hide"></div>
              <input class="form_control" type="password" name="password" placeholder="Ваш пароль">
            </div>
            <div class="form_group">
              <div class="error_modal hide"></div>
              <input class="form_control" type="password" name="repassword" placeholder="Підвердіть пароль">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form_group form_group">
              <label>Дата народження</label>
              <div class="form_group">
                <div class="error_modal hide"></div>
                <input class="form_control" type="date" name="birthday"  value="2000-01-01" max="2008-01-01" min="1920-01-01">
              </div>
            </div>
            <div class="form_group">
              <button class="submit berry-color reg-second" type="submit" name="registration">Продовжити</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
