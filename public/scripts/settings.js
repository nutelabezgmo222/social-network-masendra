$(document).ready(function(){
  $('.country-input').change(function(){
    let country_id = $(this).val();
    if(country_id == 0) {
      $( ".cities-input" ).html('<option value="0">Не вказано</option>');
      $( ".cities-input" ).prop( "disabled", true );
      return;
    }
    if(country_id != 0 ) {
      $( ".cities-input" ).prop( "disabled", false );
      $.ajax({
        url: '',
        method: 'POST',
        dataType: 'JSON',
        data: {
          country_id: country_id,
          action: 'getCities',
        },
        success: function(data) {
          displayCities(data);
        },
      });

    }
  })
  $('.settings-submit').click(function(){
    let name = $('input[name="name"]');
    let surname = $('input[name="surname"]');
    let birthday = new Date($('input[name="birthday"]').val());
    let yearDiff = Math.floor((new Date().getTime() - birthday.getTime()) / (1000*60*60*24*365) );
    let errors = [];
    if(name.val().length == 0) {
      errors.push(`Вкажіть своє і'мя!`);
    }
    if(surname.val().length == 0) {
      errors.push(`Вкажіть свою фамілію!`);
    }
    if(yearDiff < 14) {
      errors.push(`Вам повинно бути більше 14`);
    }
    if(errors.length != 0) {
      event.preventDefault();
      settingsShowError(errors);
    }
  })
  $('.setting-error-close').click(function(){
    $('.settings-errors-block').removeClass('active');
  })
})

function displayCities(data) {
  let select = $( ".cities-input" )[0];
  select.innerHTML = '';
  data.forEach(function(city) {
    select.innerHTML += `<option <?php value="${city.city_id}">${city.city_title}</option>`;
  })

}

function settingsShowError(errors) {
  $('.settings-error')[0].innerHTML = '';
  errors.forEach(function(error) {
    $('.settings-error')[0].innerHTML += `<p>${error}</p>`;
  })
  $('.settings-errors-block').addClass('active');
  setTimeout(function(){
    $('.settings-errors-block').removeClass('active');
  }, 2500)
}
