<div class="content flex-aside">
  <div class="friends user__block friendsSearch">
    <div class="friends-header">
      <ul class="friends-header-list">
        <li class="fr-online-sec choosen"><a>Люди</a></li>
      </ul>
    </div>
    <div class="friends-search-block">
      <span class="search picture-s"></span>
      <input class="search-row users-search-row" type="text" name="users-search-row" placeholder="Пошук">
    </div>
    <div class="friends-list search-user-block">
    </div>
  </div>
  <div class="user__block friends-aside">
    <div class="aside-filter">
      <ul class="filter-list">
        <li class="filter-all-friends"><a href="?sec=all">Мої друзі</a></li>
        <li class="filter-subscriptions"><a href="?sec=all_request">Запити в друзі</a></li>
        <li class="filter-subscriptions choosen"><a href="?act=find">Пошук друзів</a></li>
      </ul>
    </div>
    <div class="aside-search filter-block">
      <p class="filter-block-header">Параметри пошуку</p>
      <form class="form ajax-form-search" method="post">
        <div class="form-group">
          <p class="label">Сортування</p>
          <select class="select" name="sort">
            <option value="1">За популярністью</option>
            <option value="2">За датою реєстрації</option>
          </select>
        </div>
        <div class="form-group">
          <p class="label">Регіон</p>
          <select class="select" name="country">
            <option value="0">Будь-який</option>
            <option value="1">Україна</option>
            <option value="2">Білорусь</option>
            <option value="3">Росія</option>
          </select>
        </div>
        <div class="form-group">
          <p class="label">Вік</p>
          <select class="select" name="age">
            <option value="0">Від 14 до 90</option>
            <option value="14">Від 14 до 19</option>
            <option value="19">Від 19 до 29</option>
            <option value="29">Від 29 до 39</option>
            <option value="39">Від 39 до 50</option>
            <option value="50">Від 50 до 90</option>
          </select>
        </div>
        <div class="form-group">
          <p class="label">Стать</p>
          <div class="radio-group">
            <input type="radio" name="gender" value="1">
            <p class="radio-label">Жіноча</p>
          </div>
          <div class="radio-group">
            <input type="radio" name="gender" value="0">
            <p class="radio-label">Чоловіча</p>
          </div>
          <div class="radio-group">
            <input type="radio" name="gender" checked value="2">
            <p class="radio-label">Будь-яка</p>
          </div>
        </div>
        <div class="form-group">
          <div class="check-group">
            <input class="checkbox" type="checkbox" name="with-photo" value="1">
            <p class="check-label">з фотографією</p>
          </div>
          <div class="check-group">
            <input class="checkbox" type="checkbox" name="is-online" value="1">
            <p class="check-label">зараз на сайті</p>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
