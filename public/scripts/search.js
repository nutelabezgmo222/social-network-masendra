let from = 0;
let to = 10;
let usersList;
let searchPage = false;
let url = window.location.href.split('/');

if(url[url.length-1].includes('friends')) {
  searchPage = true;
  searchByFilters();
}


$(document).ready(function(){
  $('.ajax-form-search').change(searchByFilters);
  $('.users-search-row').on('input', searchByFilters);
  $('.search-user-block').on('click', '.searchSubscribe', function(){
    event.preventDefault();
    let id = $(this).data('id');
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        id: id,
        action: 'subsribeAtUser',
      },
      success: function(){
      }
    })
    $(this).removeClass('searchSubscribe');
    $(this).removeClass('light-blue-color');
    $(this).addClass('carrot-color');
    $(this).addClass('searchRemoveSub');
    $(this).text('Відписатися');
  })
  $('.search-user-block').on('click', '.searchRemoveSub', function(){
    event.preventDefault();
    let id = $(this).data('id');
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        id: id,
        action: 'removeSubscribe',
      },
      success: function(){
      }
    })
    $(this).removeClass('searchRemoveSub');
    $(this).removeClass('carrot-color');
    $(this).addClass('light-blue-color');
    $(this).addClass('searchSubscribe');
    $(this).text('Додати до друзів');
  })
  $(window).scroll(function(){
    if(searchPage) {
      if($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
        if(usersList.searchResult.length > from) {
          from += 10;
          to += 10;
          showSearchResult(usersList, 'add');
        }
      }
    }
  })
});


function searchByFilters(){
  let sorting = $('select[name="sort"]').val();
  let country = $('select[name="country"]').val();
  let age = $('select[name="age"]').val();
  let gender = $('input[name="gender"]:checked').val();
  let isOnline = $('input[name="is-online"]:checked').val();
  let withPhoto = $('input[name="with-photo"]:checked').val();
  let searchRow = $('input[name="users-search-row"]').val().trim();
  let filters = {
    sorting,
    country,
    age,
    gender,
    isOnline,
    withPhoto,
    searchRow,
  }
  $.ajax({
    url: '',
    method: 'POST',
    dataType: 'JSON',
    data: {
      action: 'findUsers',
      filters: filters,
    },
    success: function(data) {
      usersList = data;
      from = 0;
      to = 10;
      showSearchResult(usersList, 'new');
    }
  })
}
function showSearchResult(data, act) {
  let block = $('.friends-list');
  if(act == 'new') {
    block.html('');
  }
  if(data.searchResult.length == 0) {
    block.append(`<div class="friend-list-empty"><p>Ваш запит не дав результатів</p></div>`);
  }
  let user, i;
  for(i = from; i < to ; i++) {
    user = data.searchResult[i];
    if(user == null) {
      return;
    }
    if(user.city_title === null) {
      user.city_title = '';
      user.country_title = '';
    }
    let userBlock = `
      <div class="friend-list-item" data-id="${user.u_id}">
        <div class="friend-icon">
          <a href="/diploma/id/${user.u_id}">
            <img src="/diploma/public/materials/${user.u_id}/main/1.png" alt="photo">
          </a>
          <a href="#"></a>
        </div>
        <div class="friend-name">
          <a class="name" href="/diploma/id/${user.u_id}">${user.u_first_name} ${user.u_second_name}</a>
          <p class="city">${user.city_title} ${user.country_title}</p>
        </div>
        <div class="user-button">`;
      if(user.us_status === null && user.u_id != data.user) {
          userBlock += `<button type="button" class="searchSubscribe active-button light-blue-color" data-id="${user.u_id}" >Додати до друзів</button>`;
      } else if(user.us_status == 1) {
          userBlock += `<button type="button" class="searchRemoveSub active-button carrot-color" data-id="${user.u_id}" >Видалити з друзів</button>`;
      } else if(user.us_status == 0) {
          userBlock += `<button type="button" class="searchRemoveSub active-button carrot-color" data-id="${user.u_id}" >Відписатися</button>`;
      }
      userBlock += `</div></div>`;
      block.append(userBlock);
  }
}
