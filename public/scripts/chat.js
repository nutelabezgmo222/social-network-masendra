let ctrlPressed = false;
let currrentUrl;
let isUserActive = false;
let timerId = -1;
let rudeArr = [
  'Не потрібно так казати!',
  'За що ти так :(',
  'як так можна! не потрібно сваритися.',
];
$(document).ready(function(){
  currentUrl = window.location.href;
  $('body').click(function(){
    isUserActive = true;
    if(timerId != -1) {
      clearTimeout(timerId);
    }
    timerId = setTimeout(()=>{isUserActive = false; console.log('user is unactive');}, 15000);
  })
  //laod new messages
  if(currentUrl.search(/\/messages/) != -1) {
    if(currentUrl.search(/\?usr=/) != -1) {
      setInterval(()=>checkNewDialogMessage(), 1000);
      setInterval(()=>readNewDialogMessage(), 1000);
      setInterval(()=>checkForUpdateMessage(), 1000);
    }else {
      setInterval(checkNewMessage, 1000);
    }
  }

  $('.message-value').on('input', function(){
    if($('.message-value').val().trim().length != 0) {
      $('.message-send').addClass('active');
    } else {
      $('.message-send').removeClass('active');
    }
  })
  $('.message-value').on('keypress',function(e) {
    if(e.which == 13) {
      if(ctrlPressed == true) {
        event.preventDefault();
        sendMessage();
        ctrlPressed = false;
      }
    }
  }).on('keyup', function(e) {
    if(e.which == 17) {
      ctrlPressed = false;
    }
  }).on('keydown', function(e) {
    if(e.which == 17) {
      ctrlPressed = true;
    }
  })
  $('.message-send').click(function(e){
    if($(e.target).hasClass('active')){
      if($('.message-value').val().trim().length != 0) {
        if($('.message-value').val().toLowerCase().search(/дур/) != -1) {
          showerror('Не потрібно так казати!');
        }
        sendMessage();
        $(e.target).removeClass('active');
      }
    }
  })
  $('.chat-body').scrollTop(9999);
  $('.message-aside-remove').click(function(){
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        action: 'removeAsidePerson',
        id: $(this).data('id'),
      }
    })
    $(this).closest('.dialogs-list-item').remove();
  })
  $('.friends-search-row').on('input', function(){
    let dialogs = $('.friend-list-item');
    let input = $('.friends-search-row').val().trim().toLowerCase();
    if(input.length == 0) {
      dialogs.each(function(){
        $(this).css('display', 'flex');
      })
      return;
    }
    dialogs.each(function(index) {
      let name = $(this).data('name').toLowerCase();
      let surname = $(this).data('surname').toLowerCase();
      let user = name + ' ' + surname;
      if(user.indexOf(input) == -1) {
        $(this).css('display', 'none');
      }else {
        $(this).css('display', 'flex');
      }
    })
  })
  $('.block-user').click(function(){
    let data = $(this).closest('.chat-additional-list');
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        id: data.data('id'),
        action: 'blockUser',
      },
      success: function(){
        window.location.reload(false);
      }
    })
  })
  $('.unblock-user').click(function(){
    let data = $(this).closest('.chat-additional-list');
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        id: data.data('id'),
        action: 'unblockUser',
      },
      success: function(){
        window.location.reload(false);
      }
    })
  })
  $('.remove-chat-history').click(function() {
    let data = $(this).closest('.chat-additional-list');
    $.ajax({
      url: '',
      method: 'POST',
      data: {
        id: data.data('id'),
        action: 'removeChatHistory',
      },
      success: function(){
        window.location.reload(false);
      }
    })
  })
  $('.friends-list').click(function(e){
    let target = $(e.target);
    if(target.hasClass('friend-delete-conversation')) {
      let data = target.closest('.friend-list-item');
      $.ajax({
        url: '',
        method: 'POST',
        data: {
          id: data.data('id'),
          action: 'removeChatHistory',
        },
      })
      data.remove();
      return;
    }
    if(target.hasClass('friend-last-message') || target.hasClass('friend-last-message-time') || target.hasClass('friend-name') || target.hasClass('friend-content')) {
      let parent = target.closest('.friend-list-chat');
      console.log(parent);
      window.location.href = 'http://localhost/diploma/messages' + `?usr=${parent.data('id')}`;
    }
  })
})
function checkForUpdateMessage() {
  $.ajax({
    url: '',
    method: 'POST',
    dataType: 'JSON',
    data: {
      action: 'checkForUpdateMessage',
    },
    success: function(data){
      if(data.message[0]) {
        if(data.message[0].m_isRead == 1) {
          $('.chat-message.unread.user-message').removeClass('unread');
        }
      }
    }
  })
}
function readNewDialogMessage() {
  if(isUserActive) {
    if($('.chat-message.unread.companion-message').length != 0) {
      let fd = new FormData();
      fd.append('action', 'readMessages');
      navigator.sendBeacon('', fd);
      $('.chat-message.unread.companion-message').removeClass('unread');
    }
  }
}
function checkNewDialogMessage() {
  $.ajax({
    url: '',
    method: 'POST',
    dataType: 'JSON',
    data: {
      action: 'checkNewDialogMessage',
    },
    success: function(data) {
      loadNewDialogMessages(data);
    }
  })
}
function checkNewMessage() {
  $.ajax({
    url: '',
    method: 'POST',
    dataType: 'JSON',
    data: {
      action: 'checkNewMessage',
    },
    success: function(data) {
      if(data.messages) {
        loadNewMessages(data);
      }
    },
  })
}
function loadNewDialogMessages(data) {
  let chat = $('.chat-body');
  let messages = data.messages;
  if(messages.length == 0) {
    return;
  }
  let lastMessage = chat.children().last();
  if( lastMessage.data('id') != messages[0].m_id ) {
    let i = 0;
    while( i < messages.length ) {
      if(lastMessage.data('id') != messages[i].m_id) i++;
      else break;
    }
    i--;
    while(i >= 0) {
      let messageBlock = document.createElement('div');
      messageBlock.classList.add('chat-message');
      messageBlock.dataset.id = messages[i].m_id;
      if(messages[i].u_id == data.user) {
        messageBlock.classList.add('user-message');
      }else {
        messageBlock.classList.add('companion-message');
      }
      if(messages[i].m_isRead == 0) {
        messageBlock.classList.add('unread');
      }
      messageBlock.innerHTML = `<div class="person-page-icon">
                                  <a href="/diploma/id/${messages[i].u_id}">
                                    <img src="/diploma/public/materials/${messages[i].u_id}/main/1.png">
                                  </a>
                                </div>
                                <div class="message-content">
                                  <div class="person-name-block">
                                    <span class="person-name">${messages[i].u_first_name}</span>
                                    <span class="message-time">${messages[i].m_date}</span>
                                  </div>
                                  <div class="message-content-message">${messages[i].m_content}</div>
                                </div> `;
      chat.append(messageBlock);
      chat.scrollTop(9999);
      i--;
    }
  }
}
function loadNewMessages(data) {
  $(data.messages).each(function(index) {
    let isChatExist = false;
    let userId = this.u_id;
    let userName = this.u_first_name;
    let userSurname = this.u_second_name;
    let messageId = this.m_id;
    let messageVal = this.m_content;
    let messageDate = this.m_date;
    let messageCounter = this.newMessageCounter;
    $('.friend-list-item').each(function(){
      if($(this).data('id') == userId) {
        isChatExist = true;
        if( $(this).find('.friend-last-message').data('id') != messageId) {
          $(this).find('.friend-last-message').text(messageVal);
          $(this).find('.friend-last-message').addClass('unread');
          $(this).find('.friend-last-message-time').text(messageDate);
          let block = $(this).find('.friend-content');
          if(!block.find('.friend-new-message-counter').length) {
            let newMessageBlock = document.createElement('div');
            newMessageBlock.className = 'friend-new-message-counter';
            newMessageBlock.innerText = messageCounter;
            block.append(newMessageBlock);
          } else {
            block.find('.friend-new-message-counter').text(messageCounter);
          }
        }
        return false;
      }
    })
    if(!isChatExist) {
      let block = $('.friends-list');
      let newMessageBlock = document.createElement('div');
      newMessageBlock.className = 'friend-list-item friend-list-chat';
      newMessageBlock.dataset.id = userId;
      newMessageBlock.dataset.name = userName;
      newMessageBlock.dataset.surname = userSurname;
      newMessageBlock.innerHTML = `<div class="friend-icon">
                                      <a href="/diploma/id/${userId}"><img src="/diploma/public/materials/${userId}/main/1.png"></a>
                                    </div>
                                  <div class="friend-content">
                                    <div class="friend-name">
                                      ${userName} ${userSurname}
                                    </div>
                                    <div class="friend-last-message" data-id="${messageId}">${messageVal}</div>
                                    <div class="friend-last-message-time">
                                      ${messageDate}
                                    </div>
                                    <div class="friend-new-message-counter">${messageCounter}</div>
                                      <div class="friend-delete-conversation cross-mark">
                                    </div>
                                  </div>`;
    block.prepend(newMessageBlock);
    }
  })
}
function sendMessage() {
  let message = $('.message-value').val().trim();
  $('.message-value').val('');
  $.ajax({
    url: '',
    method: 'POST',
    data: {
      message: message,
      action: 'sendMessage',
    },
  })
}
