<div class="content">
  <div class="feed ">
    <?php foreach ($feed as $post):?>
    <div class="feed__row user__block" data-id = '<?php echo $post['p_id']; ?>'>
      <div class="feed__row__author">
        <div class="author__icon">
          <img src="/diploma/public/materials/<?php echo $post['u_id'] ?>/main/1.png" alt="icon">
        </div>
        <div class="author__action">
          <div class="author__name">
            <a href="/diploma/id/<?php echo $post['u_id']; ?>"><?php echo $post['u_first_name'].' '.$post['u_second_name']; ?></a>
            <span class="author__action-action">дода<?php echo $post['u_gender'] == 0? 'в' : 'ла';?>  публікацію на сторінку:</span>
          </div>
          <div class="author__date date">
            <?php echo dateWithYear($post['p_date']); ?>
          </div>
        </div>
      </div>
      <div class="feed__row__content">
        <?php   if($post['is_video'] == 1): ?>
        <video src="/diploma/public/materials/<?php echo $post['p_way']; ?>" controls></video>
        <?php else: ?>
        <img src="/diploma/public/materials/<?php echo $post['p_way']; ?>" alt="content">
        <?php endif; ?>
      </div>
      <?php if(!empty($post['p_title'])): ?>
      <div class="feed__row__post-title">
        <?php echo $post['p_title']; ?>
      </div>
    <?php endif; ?>
      <div class="feed__row__score">
        <div class="feed__counter like-counter">
          <span class="picture-s <?php if($post['isUserLike'] != 0) echo 'like-icon'; else echo 'like-empty-icon'; ?> like-the-post"></span>
          <span class="score"><?php echo $post['likeCounter']; ?></span>
        </div>
        <div class="feed__counter comments-counter">
          <span class="picture-s comment-icon"></span>
          <span class="score"><?php echo $post['commentCounter']; ?></span>
        </div>
      </div>
      <div class="feed__row__comments">
        <?php if(isset($post['comments'])): ?>
        <?php foreach ($post['comments'] as $comment): ?>
        <div class="feed__row__comment row-comment" data-id = "<?php echo $comment['comment_id']; ?>">
          <div class="respondent__icon">
            <img src="/diploma/public/materials/<?php echo $comment['u_id'];?>/main/1.png" alt="respondent">
          </div>
          <div class="respondent__action">
            <div class="respondent__name">
              <a href="/diploma/<?php echo $comment['u_id']; ?>"><?php echo $comment['u_first_name'].' '.$comment['u_second_name']; ?></a>
            </div>
            <div class="respondent__comment">
              <?php echo $comment['comment_text']; ?>
            </div>
            <div class="respondent__date date">
              <?php echo dateHandler($comment['comment_date']); ?>
            </div>
          </div>
          <?php if($_SESSION['user']['id'] == $comment['u_id']) : ?>
            <div class="respondent__delete__comment cross-mark">
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <div class="add-comment">
      <div class="person-message" data-id="<?php echo $post['p_id']; ?>">
        <div class="person-icon">
          <a href="/diploma/id/<?php echo $_SESSION['user']['id']; ?>"><img src="/diploma/public/materials/<?php echo $_SESSION['user']['id']; ?>/main/1.png" alt=""></a>
        </div>
        <div class="textarea">
          <textarea name="message" placeholder="Коментувати..."></textarea>
        </div>
      </div>
      <div class="comment-send">
        <button class="send-button cancelComment" type="button" name="button">Скасувати</button>
        <button class="send-button sendComment" type="button" name="button">Надіслати</button>
      </div>
    </div>
    </div>
      </div>
  <?php endforeach; ?>
    <div class="feed__row-last">
      Показано найсвіжіші новини
    </div>
  </div>
</div>
