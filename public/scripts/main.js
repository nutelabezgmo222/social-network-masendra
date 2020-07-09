let navigation = $('.header__navigation')[0];
let settings = $('.main__settings')[0];
let watchPhoto = $('.user-watch-block');
let galery = $('.user__galery-photos');
let album = $('.album');
let publishPreview = $('.publish-preview');
let publishButton = $('.form-submit-photo');
let newFriendsCounter = $('.new-friends-counter');
let watchPostId;


$(document).ready(function(){
  settings.addEventListener('click', settingsAction);
  navigation.addEventListener('click', headerNavigate);
  watchPhoto.click(closeWatch);
  galery.click(openWatch);
  album.click(openWatch);
  $('.respondent__delete__comment').click(function(){
    let data = $(this).closest('.row-comment');
    let counter = data.parent().prev().find('.comments-counter').find('.score');
    let fd = new FormData();
    fd.append('action', 'removeComment');
    fd.append('id', data.data('id'));
    navigator.sendBeacon('', fd);
    data.remove();
    counter.text(counter.text() - 1);
  })
  $('body').click(function(){
    let fd = new FormData();
    fd.append('action', 'updateLastAction');
    navigator.sendBeacon('/diploma/public/php/phpHelpCode.php',fd);
  })
  $('.userStatus').change(function(){
    let data = $(this).val().trim();
    $.ajax({
      url:'',
      method: 'POST',
      data: {
        text: data,
        action: 'changeUserStatus',
      }
    })
  })
  $('.like-the-post').click(function(){
    let current = $(this);
    let data = current.closest('.feed__row');
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        id: data.data('id'),
        action: 'toggleLikePost',
      },
    })
    let score = current.next();
    if(current.hasClass('like-empty-icon')) {
      current.removeClass('like-empty-icon');
      current.addClass('like-icon');
      score.text( + score.text() + 1 );
    }else {
      current.addClass('like-empty-icon');
      current.removeClass('like-icon');
      score.text( + score.text() - 1 );
    }
  })
  $('.like-watch-post').click(function(){
    let current = $(this);
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        id: watchPostId,
        action: 'toggleLikePost',
      },
    })
    let score = current.next();
    if(current.hasClass('like-empty-icon')) {
      current.removeClass('like-empty-icon');
      current.addClass('like-icon');
      score.text( + score.text() + 1 );
    }else {
      current.addClass('like-empty-icon');
      current.removeClass('like-icon');
      score.text( + score.text() - 1 );
    }
  })

  $('.Mdfotob').click(function(){
    event.preventDefault();
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        action: 'deletePhoto',
      },
      success: function(){
        window.location.reload(false);
      }
    })
  })
  $('.Msfb-remove-friend').click(function(){
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
        window.location.reload(false);
      }
    })
  })
  $('.Mrsubscribeb').click(function(){
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
        window.location.reload(false);
      }
    })
  })
  $('.Matfriendb').click(function(){
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
        window.location.reload(false);
      }
    })
  })
  $('.add-comment').on('click', $('.textarea textarea'), function(){
    $('.textarea textarea').parent().parent().next().css('display', 'flex');
  })
  $('.add-comment').click(function(e) {
    let target = $(e.target);
    if(target.hasClass('sendComment')) {
      let block = target.closest('.comment-send').prev();
      if(block.data('id')) {
        watchPostId = block.data('id');
      }
      let textarea = block.find('.textarea textarea');
      if(textarea.val().trim().length == 0) {
        return;
      }
      sendComment(watchPostId, textarea.val().trim());
      textarea.val('');
    }
    if(target.hasClass('cancelComment')) {
      $('.comment-send').css('display', 'none');
      let textarea = $('.textarea textarea');
      textarea.val('');
    }
  })
  $('.user_info-show-button').click(function(){
    let additional = $('.info-personal');
    additional.slideToggle('slow');
    if($(this).hasClass('active')){
      $(this).text('Більше інформації');
    }else{
      $(this).text('Менше інформації');
    }
    $(this).toggleClass('active');
  })

  publishButton.click(function(){
    if(!publishButton.hasClass('active')){
      event.preventDefault();
    }
  })
  $('.add-photo-button').click(function(){
    $('.add-publish-form').slideToggle('slow');
    if($(this).hasClass('active')){
      $(this).text('Додати публікацію');
      $(this).addClass('light-blue-color');
      $(this).removeClass('active');
      $(this).removeClass('carrot-color');
      $('#user_photo_new')[0].value = '';
      publishPreview.css('display', 'none');
      publishButton.removeClass('active');
    }else{
      $(this).removeClass('light-blue-color');
      $(this).addClass('active');
      $(this).addClass('carrot-color');
      $(this).text('Відмінити');
    }

  })
  $('#user_photo_new').change(function(){
    readURL(this);
  })
  $('#user_main_photo').change(function(){
    if (this.files && this.files[0]) {
      let arr = ['image/png', 'image/jpg', 'image/jpeg'];
      let type = this.files[0].type;
      if(arr.includes(type)){
        let fd = new FormData();
        fd.append('uploadedFile', this.files[0]);
        fd.append('action', 'changeMainPhoto');
        $.ajax({
          url: '',
          type: 'POST',
          dataType: 'json',
          data: fd,
          processData: false,
          contentType: false,
          cache: false,
          success: function(data){
            window.location.reload(false);
          }
        })
      } else {
        showerror('Хлопче..чи дівча обирай файл з розширенням .png чи .jpg');
      }
    }
  })
  $('.watch-comments').click(function(e) {
    let target = $(e.target);
    if(target.hasClass('respondent__delete__comment')) {
      let data = $(target).closest('.row-comment');
      let fd = new FormData();
      fd.append('action', 'removeComment');
      fd.append('id', data.data('id'));
      navigator.sendBeacon('', fd);
      $(data).remove();
    }
  })
  $('.save-watch-post').click(function() {
    if($(this).hasClass('star-empty-icon')) {
      $('.save-watch-post').addClass('star-icon');
      $('.save-watch-post').removeClass('star-empty-icon');
    }else {
      $('.save-watch-post').addClass('star-empty-icon');
      $('.save-watch-post').removeClass('star-icon');
    }
    let fd = new FormData();
    fd.append('action', 'togglePostBook');
    fd.append('id', watchPostId);
    navigator.sendBeacon('', fd);
  })
  $('.settings-post-remove').click(function(){
    let fd = new FormData();
    fd.append('action' , 'removePost');
    fd.append('id', watchPostId);
    navigator.sendBeacon('', fd);
    $('.user-watch-block').addClass('hide');
    $('.body').removeClass('stop-scroll');
    if($('.user-watch-block').find('video')[0]) {
      $('.user-watch-block').find('video')[0].pause();
    }
    history.pushState(null, null, currentUrl);
    alert('Публікація була видалена');
    window.location.reload(false);
  })
  $('.settings-save').click(function(){
    let fd = new FormData();
    let title = $('textarea[name="post-title"]').val();
    let p_access = $('input[name="commentsGroup"]:checked').val();
    fd.append('action', 'changePostSettings');
    fd.append('title', title);
    fd.append('access', p_access);
    fd.append('id', watchPostId);
    navigator.sendBeacon('', fd);
    alert('Операція проведена успішно');
  })
})

function readURL(input) {
  if (input.files && input.files[0]) {
    let arr = ['image/png', 'image/jpg', 'video/mp4', 'image/jpeg'];
    let type = input.files[0].type;
    let content;
    if(arr.includes(type)){
      let reader = new FileReader();
      if(type.slice(-3)=='mp4'){
        content = document.createElement('video');
      }else {
        content = document.createElement('img');
      }
      reader.onload = function(e) {
        $(content).attr('src', e.target.result);
        publishPreview.css('display', 'block');
        publishPreview.html(content);
        publishButton.addClass('active');
      }
      reader.readAsDataURL(input.files[0]);
    }else {
      publishPreview.css('display', 'none');
      publishButton.removeClass('active');
      showerror('Тобі потрібно обрати файл з розширенням .png, .jpg чи .mp4 мяу...хочу риби..');
    }
  }
}
function showerror(error){
  $('.cat-error-block').text(error);
  $('.cat-error-block').addClass('active');
  setTimeout(()=>{$('.cat-error-block').removeClass('active');}, 7000)
}

function openWatch(e) {
  event.preventDefault();
  let target = $(e.target).closest('.photo-veil');
  if(target.hasClass('photo-veil')) {
    currentUrl = window.location.href;
    history.pushState(null, null, target.attr('href'));
    $('.person-page-title').html('');
    $('.comments').html('');
    let photoSrc = target.data('way');
    watchPostId = target.data('id');
    let watchImg = $('.watch-photo')[0];
    let format = photoSrc.slice(-3);
    if(format == 'mp4') {
      watchImg.innerHTML = `
        <video width="100%" height="100%" controls>
         <source src="/diploma/public/materials/${photoSrc}" type="video/mp4">
         Нажаль ваш браузер не підтримує відео.
        </video>
      `;
    }else {
      watchImg.innerHTML = `
        <img src="/diploma/public/materials/${photoSrc}" alt="photo">
      `;
    }
    if(target.hasClass('photo-veil-view')) {
      $('.watch-comments').css('display', 'flex');
      $('.watch-settings-block').css('display', 'none');
      getPostLikes(watchPostId);
      loadPost();
    }else {
      if(target.hasClass('photo-veil-settings')) {
      $('.watch-comments').css('display', 'none');
      $('.watch-settings-block').css('display', 'flex');
      loadPostSettings();
      }
    }
    watchPhoto.removeClass('hide');
    $('.body').addClass('stop-scroll');
  }
}
function loadPostSettings(){
  $.ajax({
    url: '',
    type: 'POST',
    dataType: 'JSON',
    data: {
      id: watchPostId,
      action: 'getPostSettings',
    },
    success: function(data) {
      showPostSettings(data);
    }
  })
}
function showPostSettings(data) {
  data = data.postSettings[0];
  $('textarea[name="post-title"]').text(data.p_title);
  $('.watch-comment-counter').text(data.commentsCount);
  $('input[name="commentsGroup"]').each(function(){
    if(this.value == data.p_access) {
      this.checked = 'checked';
    }
  })
}
function loadPost() {
  $.ajax({
    url: '',
    type: 'POST',
    data: {
      id: watchPostId,
      action: 'getPostData',
    },
    success: function(data) {
      showComments(data);
    }
  })
}

function showComments(data) {
  let comments = $('.comments');
  let author = $('.person-page-title')[0];
  data = JSON.parse(data);
  let commentsValue = data.comments;
  let authorValue = data.author[0];
  let postInfo = data.post_info[0];
  let friendStatus = data.friend_status;
  let userId = data.user_id;
  let isSaved = data.isSaved;
  author.innerHTML = `  <div class="person-page-icon">
                          <a href="/diploma/id/${authorValue.u_id}">
                          <img src="/diploma/public/materials/${authorValue.u_id}/main/1.png" alt="icon">
                          </a>
                        </div>
                        <div class="person-page-title-main">
                          <a href="/diploma/id/${authorValue.u_id}">${authorValue.u_first_name} ${authorValue.u_second_name}</a>
                        </div>
                        <div class="person-page-title-date">
                          <p>${authorValue.p_date}</p>
                        </div>`
  if(postInfo.p_title) {
    author.innerHTML += `<div class="person-post-title">${postInfo.p_title}</div>`;
  }
  if(isSaved != 0) {
    $('.save-watch-post').addClass('star-icon');
    $('.save-watch-post').removeClass('star-empty-icon');
  }else {
    $('.save-watch-post').addClass('star-empty-icon');
    $('.save-watch-post').removeClass('star-icon');
  }
  comments.html('');
  $('.add-comment').html('');
  if(postInfo.p_access != 0 && (friendStatus.length == 0 || friendStatus.friend_status != postInfo.p_access) && authorValue.u_id != userId) {
      let p = document.createElement('p');
      p.className = 'comments-empty';
      p.innerText = 'Користувач обмежив коло людей які можуть комментувати цей запис';
      if(commentsValue.length == 0) {
        comments.append(p);
      }else {
        $('.add-comment').append(p);
      }
    }else {
      addCommentField(userId);
      if(commentsValue.length == 0){
          let p = document.createElement('p');
          p.className = 'comments-empty';
          p.innerText = 'Будьте першим кто напише комментарій!';
          comments.append(p);
      }
    }
  commentsValue.forEach(function(comment) {
    let commVeil = document.createElement('div');
    commVeil.className = 'comment row-comment';
    commVeil.dataset.id = comment.comment_id;
    commVeil.innerHTML = `<div class="respondent__icon">
                            <a href="/diploma/id/${comment.u_id}"><img src="/diploma/public/materials/${comment.u_id}/main/1.png" alt="respondent"></a>
                          </div>
                          <div class="respondent__action">
                            <div class="respondent__name">
                              <a href="/diploma/id/${comment.u_id}">${comment.u_first_name} ${comment.u_second_name}</a>
                            </div>
                          <div class="respondent__comment">
                            <p>${comment.comment_text}</p>
                          </div>
                          <div class="respondent__date date">
                            <p>${comment.comment_date}</p>
                          </div>
                          </div>`;
    if(comment.u_id == userId || authorValue.u_id == userId ) {
      commVeil.innerHTML += `<div class="respondent__delete__comment cross-mark"></div>`;
    }
    comments.append(commVeil);
  })
}
function addCommentField(id){
  let commentBlock = $('.add-comment')[0];
  commentBlock.innerHTML = `<div class="person-message">
                <div class="person-icon">
                  <a href="/diploma/id/${id}">
                    <img src="/diploma/public/materials/${id}/main/1.png" alt="">
                  </a>
                </div>
                <div class="textarea">
                  <textarea name="message" placeholder="Коментувати..."></textarea>
                </div>
              </div>
              <div class="comment-send">
                <button class="send-button cancelComment" type="button" name="button">Скасувати</button>
                <button class="send-button sendComment" type="button" name="button">Надіслати</button>
              </div>`;
}
function sendComment(postId, text) {
  $.ajax({
    type: 'POST',
    url: '',
    dataType: 'JSON',
    data: {
      post_id: postId,
      text: text,
      action: 'sendComment',
    },
    success: function(data) {
      if(data == 'feed') {
        window.location.reload(false);
      }else {
        loadPost();
      }
    }
  })
}
function closeWatch(e){
  let target = $(e.target);
  if(target.hasClass('user-watch-block')) {
    target.addClass('hide');
    $('.body').removeClass('stop-scroll');
    if($('.user-watch-block').find('video')[0]) {
      $('.user-watch-block').find('video')[0].pause();
    }
    history.pushState(null, null, currentUrl);
  }
}

function headerNavigate(e){
  let target = e.target;
  if(target.nodeName == 'SPAN') {
    if(target.classList.contains('settings-icon')) {
      showSettings();
      return;
    }
    if(target.classList.contains('home-icon')) {
      window.location.href = '/diploma/';
    }
    if(target.classList.contains('feed-icon')) {
      window.location.href = '/diploma/feed';
    }
  }
}

function showSettings(){
  $('.body').addClass('stop-scroll');
  let scroll = $(window).scrollTop();
  $('.settings__block').css('top', `calc(300px + ${scroll}px)`)
  settings.classList.remove('hide');
}

function settingsAction(e){
  let target = e.target.classList;
  if(target.contains('main__settings') || target.contains('settings-cancel')) {
    settings.classList.add('hide');
    $('.body').removeClass('stop-scroll');
    return;
  }
  if(target.contains('settings-out')) {
    window.location.href = '/diploma/out';
  }
  if(target.contains('settings-personal-data')) {
    window.location.href = '/diploma/settings';
  }
  if(target.contains('settings-confidentiality')) {
    window.location.href = '/diploma/settings?act=confidentiality';
  }
}
function getPostLikes(postId) {
  $.ajax({
    url: '',
    method: 'POST',
    dataType: 'JSON',
    data: {
      post_id: postId,
      action: 'getPostLikes',
    },
    success: function(data) {
      $('.watch-like-count').text(data[0]['likesNumber']);
      if(data[0]['userLike'] == 1 ) {
        $('.watch-like-count').prev().removeClass('like-empty-icon').addClass('like-icon');
      }else {
        $('.watch-like-count').prev().removeClass('like-icon').addClass('like-empty-icon');
      }
    }
  })
}
