<div class="container ">
  <div class="flex space-between">
  <div class="user__block authorize card">
    <div class="main__logo">
      <img src="/diploma/public/images/logo.png" alt="logo">
    </div>
    <div class="card__header header__logo-title">Masendra</div>
    <div class="card__body">
      <form class="authorize__block form-ajax form" method="POST">
        <div class="form_group">
          <input class="form_control" type="text" name="login" placeholder="Логін">
        </div>
        <div class="form_group">
          <input class="form_control" type="password" name="password" placeholder="Пароль">
        </div>
        <div class="form_group ">
          <button class="submit berry-color loginButton" type="submit">Увійти</button>
        </div>
        <div class="form_group help">
          <a class="">Забули пароль?</a>
        </div>
      </form>
    </div>
  </div>
  <div class="user__block register card">
    <div class="card__header">Вперше в <span class="header__logo-title">Masendra</span>?</div>
    <div class="card__body">
      <form class="authorize__block form" method="POST">
        <div class="form_group">
          <div class="error_modal hide"></div>
          <input class="form_control" type="text" name="name" placeholder="Ваше імя">
        </div>
        <div class="form_group">
          <div class="error_modal hide"></div>
          <input class="form_control" type="text" name="surname" placeholder="Ваша фамілія">
        </div>
        <div class="form_group">
          <div class="error_modal hide"></div>
          <input class="form_control" type="text" name="reg-login" placeholder="Ваш логін">
        </div>
        <div class="form_group">
          <button class="submit berry-color reg-first" type="submit" name="registration">Продовжити</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
