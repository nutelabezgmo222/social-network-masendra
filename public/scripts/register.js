let name = $('input[name="name"]');
let surname = $('input[name="surname"]');
let login = $('input[name="reg-login"]');
let password = $('input[name="password"]');
let repassword = $('input[name="repassword"]');
let birthday = $('input[name="birthday"]');
let email = $('input[name="email"]');
let emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

$(document).ready(function(){
  $('.loginButton').click(function(){
    event.preventDefault();
    $.ajax({
      url: '',
      method: 'POST',
      dataType: 'JSON',
      data: {
        action: 'loginUser',
        login: $('input[name="login"]').val().trim(),
        password: $('input[name="password"]').val().trim(),
      },
      success: function(result){
        let data = result;
        if(data.url) {
          window.location.href = data.url;
        }else {
          if(data.status) {
            alert(data.message);
          }
        }
      },
    })
  })
  $('.reg-first').click(function(){
    event.preventDefault();
  $.ajax({
      url: '',
      method: 'POST',
      dataType: "JSON",
      data: {
        name: name.val(),
        surname: surname.val(),
        login: login.val(),
        action: 'regFirst',
      },
      success: function(data) {
        let obj = data;
        if(obj.status == 'error') {
          showError(obj.mes);
        }else if(obj.status == 'success') {
          window.location.href = '/diploma/register';
        }
      }
    })
  })
  $('.reg-second').click(function(){
    event.preventDefault();
    $.ajax({
        url: '',
        method: 'POST',
        dataType: "JSON",
        data: {
          name: name.val(),
          surname: surname.val(),
          login: login.val(),
          password: password.val(),
          repassword: repassword.val(),
          birthday: birthday.val(),
          gender: $('input[name="gender"]:checked').val(),
          action: 'regSecond',
        },
        success: function(data) {
          let obj = data;
          if(obj.status == 'error') {
            showError(obj.mes);
          }else if(obj.status == 'success') {
            window.location.href = '/diploma/register?act=finish';
          }
        }
      })
  })
  $('.reg-last').click(function(){
    event.preventDefault();
    let patternCheck = email.val().search(emailPattern);
    if(patternCheck == -1) {
      let obj = {
        block: 'email',
        mes: 'Будь ласка вкажіть ваш справжній еmail!',
      }
      showError(obj.mes);
      return;
    }
  $.ajax({
        url: '',
        method: 'POST',
        dataType: "JSON",
        data: {
          email: email.val(),
          action: 'regLast',
        },
        success: function(data) {
          let obj = data;
          console.log(data);
          if(obj.status == 'success') {
            showFinish();
          }
        }
      })
  })
  $(email).on('input',function(){
    let patternCheck = email.val().search(emailPattern);
    if(patternCheck == -1) {
      email.removeClass('valid');
      email.addClass('invalid');
    }
    if(patternCheck == 0) {
      email.removeClass('invalid');
      email.addClass('valid');
    }
  })
})

function showError(error){
  $('.cat-error-block').text(error);
  $('.cat-error-block').addClass('active');
  setTimeout(()=>{$('.cat-error-block').removeClass('active');}, 7000)
}

function showFinish() {
  let element =`<div class="card__header">Дякуємо за реєстрацію!</div>
                <div class="card__body">
                  <p>Ви успішно зареєструвались, тепер перейдіть на головну сторінку та авторизуйтесь :)</p>
                  <a href="/diploma/login" class="submit berry-color return" type="submit">Повернутися</a>
                </div>`;
  $('.register.card').html(element);
}
