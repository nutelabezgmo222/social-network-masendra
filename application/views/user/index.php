<div class="content">
  <div class="user">
    <div class="user__photo-block">
      <div class="user__photo user__block">
        <img src="/diploma/public/materials/<?php echo $user['u_id']; ?>/main/1.png" alt="">
      </div>
      <div class="user__photo-sub user__block">
        <?php if($_SESSION['user']['id'] != $user['u_id']): ?>
        <a class="active-button light-blue-color" href="/diploma/messages?usr=<?php echo($user['u_id']); ?>">Повідомлення</a>
      <?php endif; ?>
        <?php if($is_friend != -1): ?>
          <?php if($is_friend == 1): ?>
            <div class="active-button Msfb carrot-color">
             <p> <?php echo $user['u_first_name'];?> ваш друг</p>
               <div class="Msfb-hide carrot-color">
                 <ul>
                   <li class="Msfb-remove-friend" data-id="<?php echo $user['u_id']; ?>">Видалити с друзів</li>
                 </ul>
               </div>
            </div>
          <?php endif; ?>
          <?php if($is_friend == 0): ?>
            <button class="active-button Mrsubscribeb carrot-color" type="button" data-id="<?php echo $user['u_id']; ?>" name="button">Відписатися</button>
          <?php endif; ?>
        <?php elseif($_SESSION['user']['id'] != $user['u_id']): ?>
            <button class="active-button Matfriendb light-blue-color" type="button" data-id="<?php echo $user['u_id']; ?>" name="button">Підписатися</button>
          <?php else: ?>
            <?php if($user['u_avatar'] == 1): ?>
            <button class="active-button Mdfotob carrot-color" type="button" name="button">Видалити фото</button>
          <?php endif; ?>
            <input type="file" name="uploadedFile" id="user_main_photo" accept="image/*">
            <label for='user_main_photo' class="active-button Mcfotob light-blue-color" name="button">Змінити фото</label>
        <?php endif; ?>
      </div>
    </div>
    <div class="user__info user__block">
      <div class="user__info__header">
        <div class="user__name">
          <?php echo "{$user['u_first_name']} {$user['u_second_name']}";  ?>
        </div>
        <div class="user__status">
          <?php if($user['u_id'] == $_SESSION['user']['id']): ?>
            <input class="userStatus" maxlength="40" type="text" name="userStatus" value="<?php echo $user['u_status']; ?>">
          <?php else: ?>
          <?php echo $user['u_status']; ?>
        <?php endif; ?>
        </div>
        <div class="user__online <?php if($user['is_online']) echo 'online'; ?>">
          <?php if($user['is_online'] == 1): ?>
            Онлайн
          <?php  else:?>
            бу<?php if($user['u_gender'] == 0)echo 'в'; else echo 'ла'; echo ' онлайн ' . onlineWard($user['last_action']); ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="user__info__main">
        <?php if($user['u_id'] != $_SESSION['user']['id'] && $user['u_access'] == 1 && ($is_friend == -1 || $is_friend == 0)): ?>
          <div class="user__description warning">Користувач не надав жодної інформаціі про себе або інформація скрита</div>
          <?php else: ?>
        <?php if(empty($additional_general)): ?>
          <?php if($user['u_id'] == $_SESSION['user']['id']): ?>
          <div class="user__description warning">Що б додати інформацію про себе перейдіть у розділ "Особисті дані"</div>
        <?php else: ?>
          <div class="user__description warning">Користувач не надав жодної інформаціі про себе або інформація скрита</div>
          <?php endif; ?>
        <?php else: ?>
          <div class="user__info-info info-general">
            <div class="user__info-header">
              Основна інформація:
            </div>
            <?php foreach ($additional_general as $info): ?>
            <div class="user__description">
              <div class="user__description-label"><?php echo $info['it_title']; ?>:</div>
              <div class="user__description-labeled"><a href="#"><?php echo $info['ui_description']; ?></a></div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php if(!empty($additional_contact)): ?>
          <div class="user__info-info info-contact">
            <div class="user__info-header">
              Контакти:
            </div>
            <?php foreach ($additional_contact as $info): ?>
            <div class="user__description">
              <div class="user__description-label"><?php echo $info['it_title']; ?>:</div>
              <div class="user__description-labeled"><a href="#"><?php echo $info['ui_description']; ?></a></div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <?php if(!empty($additional_personal)): ?>
          <div class="user_info-show-button">
            Більше інформації
          </div>
          <div class="user__info-info info-personal">
            <div class="user__info-header">
              Особиста інформація:
            </div>
            <?php foreach ($additional_personal as $info): ?>
            <div class="user__description">
              <div class="user__description-label"><?php echo $info['it_title']; ?>:</div>
              <div class="user__description-labeled"><a href="#"><?php echo $info['ui_description']; ?></a></div>
            </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
    <?php endif; ?>
      </div>
    <div class="user__info-stats">
        <a class="page-counter friend-counter" href="/diploma/friends?sec=all&usr=<?php echo $user['u_id']; ?>">
          <div class="count"><?php echo $friend_counter; ?></div>
          <div class="label">друзів</div>
        </a>
        <a class="page-counter fans-counter" href="/diploma/friends?sec=all_request&usr=<?php echo $user['u_id']; ?>">
          <div class="count"><?php echo $sub_counter; ?></div>
          <div class="label">підписників</div>
        </a>
        <a class="page-counter sub-counter" href="/diploma/friends?sec=out_request&usr=<?php echo $user['u_id']; ?>">
          <div class="count"><?php echo $follow_counter; ?></div>
          <div class="label">підписок</div>
        </a>
        <a class="page-counter photo-counter" href="#">
          <div class="count"><?php echo $post_counter; ?></div>
          <div class="label">публікації</div>
        </a>
    </div>
  </div>
  <?php  if($user['u_id'] == $_SESSION['user']['id']) :?>
  <div class="user__action user__block">
    <div class="user__action-photo">
      <div class="add-photo-button light-blue-color">Додати публікацію</div>
      <form enctype="multipart/form-data" action="" class="add-publish-form" method="post">
        <input type="file" name="uploadedFile" id="user_photo_new" accept="media_type">
        <div class="form_group">
          <span class="form-help">Оберіть, що</span>
          <label class="form-photo-button" for="user_photo_new">публікувати</label>
          <div class="publish-preview">
          </div>
        </div>
        <div class="form_group">
          <span class="form-help">та додайте назву за необхідності</span>
          <input class="add-photo-input" type="text" name="publish-name" value="">
        </div>
          <input class="form-submit-photo" type="submit" name="uploadBtn" value="Опублікувати">
      </form>
    </div>
  </div>
<?php endif; ?>
  <div class="user__galery user__block">
    <div class="user__galery-category">
      <ul class="user__list">
        <li class="user__list-item <?php if(!isset($this->route['sec'])) echo 'chosen'; ?>"><a href="/diploma/id/<?php echo $user['u_id']; ?>">Публікації</a></li>
        <li class="user__list-item <?php if(isset($this->route['sec'])) echo 'chosen'; ?>"><a href="?sec=saved">Закладки</a></li>
      </ul>
    </div>
    <div class="user__galery-photos <?php if(empty($posts) || ($user['u_id'] != $_SESSION['user']['id'] && $user['u_access'] == 1 && ($is_friend == -1 || $is_friend == 0)) && !isset($this->route['sec']) ) echo 'empty-galery' ?>">
      <?php if($user['u_id'] != $_SESSION['user']['id'] && $user['u_access'] == 1 && ($is_friend == -1 || $is_friend == 0) && !isset($this->route['sec'])): ?>
        <div class="user__galery-epmty">Користувач обмежив перегляд своєї світлини.</div>
      <?php else: ?>
      <?php if(empty($posts)): ?>
        <?php if($user['u_id'] == $_SESSION['user']['id']): ?>
        <div class="user__galery-epmty">
          Ваша світлина порожня, додайте вашу першу публікацію!
        </div>
        <?php else: ?>
        <div class="user__galery-epmty">
          Світлина користувача порожня, нагадайте йому додати фотографій:)
        </div>
      <?php endif; ?>
      <?php else: ?>
      <?php foreach ($posts as $post): ?>
        <a class="user__galery-photo relative veil photo-veil photo-veil-view" data-id="<?php echo $post['p_id']; ?>" data-way="<?php echo $post['p_way']; ?>" href="?photo=<?php echo implode('',explode('/',substr($post['p_way'], 0, strlen($post['p_way']) - 4))); ?>">
          <div class="watch-count-likes watch-count">
            <span class="picture-s <?php if($post['isUserLike'] != 0) echo 'like-icon'; else echo 'like-empty-icon'; ?>"></span>
            <span class="watch-value"><?php echo $post['likes']; ?></span>
          </div>
          <div class="watch-count-comments watch-count">
            <span class="picture-s comment-icon"></span>
            <span class="watch-value"><?php echo $post['comments']; ?></span>
          </div>
          <div class="galery-img">
            <?php if($post['is_video']): ?>
              <video width="100%" height="100%">
               <source src="/diploma/public/materials/<?php echo $post['p_way']; ?>" type="video/mp4">
              Your browser does not support the video tag.
              </video>
            <?php else: ?>
            <img src="/diploma/public/materials/<?php echo $post['p_way']; ?>" alt="<?php echo $post['p_title']; ?>">
            <?php endif; ?>
          </div>
        </a>
    <?php endforeach; ?>
  <?php endif; ?>
  <?php endif; ?>
    </div>
    </div>
    <div class="user-watch-block hide">
      <div class="user-watch-photo-block">
        <div class="watch-photo">
        </div>
        <div class="watch-comments">
          <div class="person-page-title">
          </div>
          <div class="watch-photo-stats">
            <div class="watch-photo-likes">
              <span class="like-empty-icon picture-s like-watch-post"></span>
              <span class="watch-like-count"></span>
            </div>
            <div class="watch-photo-saved">
              <span class="picture-s save-watch-post"></span>
            </div>
          </div>
          <div class="comments watch-comments">
          </div>
          <div class="add-comment">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
