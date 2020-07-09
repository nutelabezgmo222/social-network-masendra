<div class="content">
  <div class="user__block albums">
    <div class="albums-header">
      <h3>Мої публікації</h3>
    </div>
    <div class="album">
      <?php if(!empty($albums)): ?>
        <?php $curYear = getYear($albums[0]['p_date']); ?>
      <div class="album-year">
        <p><?php echo $curYear; ?> рік</p>
      </div>
      <div class="album-photos">
      <?php foreach ($albums as $albumItem):?>
      <?php if($curYear != getYear($albumItem['p_date'])):?>
          <?php $curYear =  getYear($albumItem['p_date']);?>
        </div>
          <div class="album-year">
            <p><?php echo $curYear; ?> рік</p>
          </div>
        <div class="album-photos">
      <?php endif; ?>
        <div class="album-photo" >
          <div class="album-veil">
            <a class="photo-veil photo-veil-settings" data-id="<?php echo $albumItem['p_id']; ?>" data-way="<?php echo $albumItem['p_way']; ?>" href="?photo=<?php echo implode('',explode('/',substr($albumItem['p_way'], 0, strlen($albumItem['p_way']) - 4))); ?>">
              <span class="photo-veil-inscription" >Редагувати</span>
            </a>
            <a class="photo-veil photo-veil-view" data-id="<?php echo $albumItem['p_id']; ?>" data-way="<?php echo $albumItem['p_way']; ?>" href="?photo=<?php echo implode('',explode('/',substr($albumItem['p_way'], 0, strlen($albumItem['p_way']) - 4))); ?>">
              <span class="photo-veil-inscription" >Подивитися</span>
            </a>
            <?php if($albumItem['is_video']): ?>
              <video width="100%" height="100%">
               <source src="/diploma/public/materials/<?php echo $albumItem['p_way']; ?>" type="video/mp4">
              Your browser does not support the video tag.
              </video>
            <?php else: ?>
            <img src="/diploma/public/materials/<?php echo $albumItem['p_way']; ?>">
            <?php endif; ?>
          </div>
        </div>
    <?php endforeach; ?>
    </div>
  <?php endif; ?>
    </div>
    <div class="user-watch-block hide">
      <div class="user-watch-photo-block">
        <div class="watch-photo">
        </div>
        <div class="watch-settings-block">
          <div class="settings-post-block">
            <div class="settings-label">
              Назва
            </div>
            <div class="settings-input">
              <textarea name="post-title" maxlength="45"></textarea>
            </div>
          </div>
          <div class="settings-post-block">
            <div class="settings-label">
              Усього комментарів : <span class="watch-comment-counter"></span>
            </div>
            <button class="settings-remove" type="button" name="remove_commentars">Видалити усі комментарі</button>
          </div>
          <div class="settings-post-block">
            <div class="settings-label">
              Хто може комментувати цю публікацію
            </div>
            <div class="settings-radio-group">
              <div class="settings-group-label">
                Усі
              </div>
              <input type="radio" name="commentsGroup" value="0" checked>
              <div class="settings-group-label">
                Друзі
              </div>
              <input type="radio" name="commentsGroup" value="1">
              <div class="settings-group-label">
                Ніхто
              </div>
              <input type="radio" name="commentsGroup" value="2">
            </div>
          </div>
          <div class="settings-post-block settings-down">
            <button class="settings-save" type="button" name="button">Зберегти зміни</button>
            <button class="settings-post-remove" type="button" name="button">Видалити публікацію</button>
          </div>
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
