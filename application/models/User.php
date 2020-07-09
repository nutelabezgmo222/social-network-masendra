<?php

namespace application\models;

use application\core\Model;

class User extends Model {

	public $error;
	public $personalData = ['site' => 2,'institute' => 3,'hometown' => 4,'activity' => 5,'skype' => 6,'hobby' => 7,'films' => 8,'biography' => 9,];


	public function addPost($post, $file){
		$allowedfileExtensions = array('jpg', 'gif', 'png', 'mp4', 'jpeg');
		$fileTmpPath = $file['uploadedFile']['tmp_name'];
		$fileName = $file['uploadedFile']['name'];
		$fileSize = $file['uploadedFile']['size'];
		$fileType = $file['uploadedFile']['type'];
		$user_id = $_SESSION['user']['id'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		if (in_array($fileExtension, $allowedfileExtensions)) {
			$is_video = 0;
			if($fileExtension == 'mp4') {
				$is_video = 1;
			}
			$params = [
				'p_title' => $post['publish-name'],
				'user_id' => $user_id,
				'is_video' => $is_video,
			];
			$this->db->query('INSERT INTO posts VALUES(NULL, :p_title, NULL, "", :user_id, :is_video, "0" )', $params);
			$post_id = $this->db->lastInsertId();
			$newFileName = $post_id . '.' . $fileExtension;
			$uploadFileDir = "C:\\xampp\\htdocs\\diploma\\public\\materials\\".$user_id."\\aa\\".$newFileName;

			$this->db->query('UPDATE posts SET p_way = "'. $user_id .'/'.'aa'.'/'.$newFileName.'" WHERE p_id = ' . $post_id);
			move_uploaded_file($fileTmpPath, $uploadFileDir);
		}
	}
	public function getUserLastMessage($user, $companion) {
		$params = [
			'user' => $user,
			'id' => $companion,
		];
		return $this->db->row('SELECT m.m_isRead FROM chats c JOIN messages m ON m.chat_id = c.chat_id
			WHERE (c.u_id = :user AND c.companion_id = :id) OR (c.u_id = :id AND c.companion_id = :user) AND m.u_id = :user ORDER BY m.m_date DESC LIMIT 1', $params);
	}
	public function getNewDialogMessages($user, $companion) {
		$params = [
			'user' => $user,
			'id' => $companion,
		];
		return $this->db->row('SELECT c.chat_id, m.m_id, m.m_content, m.m_isRead, m.m_date, u.u_first_name, u.u_second_name, u.u_id
			FROM chats c JOIN messages m ON m.chat_id = c.chat_id JOIN users u ON u.u_id = m.u_id
			WHERE (c.u_id = :user AND c.companion_id = :id) OR (c.u_id = :id AND c.companion_id = :user) ORDER BY m.m_date DESC LIMIT 5 ', $params);
	}
	public function getNewMessages($user) {
		$params = [
			'user' => $user,
		];
		return $this->db->row('SELECT m.m_id, m.m_content, m.m_date, m.chat_id, u.u_first_name, u.u_second_name, u.u_id,
			(SELECT COUNT(m1.m_id) FROM messages m1 WHERE m1.u_id = m.u_id AND m1.m_isRead = 0) as newMessageCounter
			FROM messages m JOIN chats c ON c.chat_id = m.chat_id JOIN users u ON u.u_id = m.u_id WHERE
			(c.u_id = :user OR c.companion_id = :user) AND m.m_isRead = 0 AND m.u_id != :user AND c.last_message_id = m.m_id ', $params);
	}
	public function getPostInfo($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT p.p_title, p.p_access, (SELECT COUNT(c.comment_id) FROM comments c WHERE c.p_id = p.p_id) as commentsCount FROM posts p WHERE p.p_id = :id', $params);
	}
	public function getPostLikes($id) {
		$params = [
			'user_id' => $_SESSION['user']['id'],
			'id' => $id,
		];
		return $this->db->row('SELECT COUNT(p.u_id) as likesNumber, IF(FIND_IN_SET(:user_id, p.u_id), 1 , 0) as userLike FROM posts_likes p WHERE p.p_id = :id', $params);
	}
	public function getUserAccess($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT u_access, u_message_access FROM users WHERE u_id = :id', $params)[0];
	}
	public function getUserPostAccess($id) {
		$params = [
			'id' => $id,
		];
		$pAccess = 3;
		$allP = $this->db->column('SELECT COUNT(p_id) as posts FROM posts WHERE u_id = :id', $params);
		$forAll = $this->db->column('SELECT COUNT(p_id) as posts FROM posts WHERE u_id = :id AND p_access = 0', $params);
		$forFriends = $this->db->column('SELECT COUNT(p_id) as posts  FROM posts WHERE u_id = :id AND p_access = 1', $params);
		$forNoBody = $this->db->column('SELECT COUNT(p_id) as posts FROM posts WHERE u_id = :id AND p_access = 2', $params);
		if($allP == $forAll) {
			$pAccess = 0;
			return $pAccess;
		}
		if($allP == $forFriends) {
			$pAccess = 1;
			return $pAccess;
		}
		if($allP == $forNoBody) {
			$pAccess = 2;
			return $pAccess;
		}
		return $pAccess;
	}

	public function getUserInfo($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT u.u_id, u.u_access, u.u_first_name, u.u_second_name, u.u_gender, u.u_avatar, u.u_status, u.is_online, u.last_action,u.u_message_access,
			u.u_birth_day,u.u_birth_month, u.u_birth_year, c.city_id, c.country_id
			FROM users u LEFT JOIN cities c On c.city_id = u.u_city WHERE u.u_id = :id', $params)[0];
	}
	public function logOut(){
		$this->db->query('UPDATE users SET is_online = 0 WHERE u_id = ' . $_SESSION['user']['id']);
		unset($_SESSION['user']);
		unset($_SESSION['chats']);
	}
	public function getFriendStatus($user, $comp) {
		$params = [
			'user' => $user,
			'comp' => $comp,
		];
		return $this->db->row('SELECT us_status FROM users_subscriptions WHERE u_id = :user AND subscription_u_id = :comp', $params);
	}
	public function getUserAdditional($id, $group) {
		$params = [
			'id' => $id,
			'group'=> $group,
		];
		return $this->db->row('SELECT it.it_id, it.it_title, ui.ui_description
			FROM users_info ui JOIN info_titles it ON ui.ui_title_id  = it.it_id WHERE ui.u_id = :id AND it.it_group = :group', $params);
	}
	public function getUserMutualFriends($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT us1.subscription_u_id, u.u_first_name, u.u_second_name, COUNT(us1.subscription_u_id) as mutualFriends
		FROM (SELECT * FROM users_subscriptions us WHERE us.u_id = :id AND us.us_status = 1) as myFriends
		JOIN users_subscriptions us1 ON us1.u_id = myFriends.subscription_u_id JOIN users u ON us1.subscription_u_id = u.u_id WHERE us1.us_status = 1 AND us1.subscription_u_id != :id
		AND us1.subscription_u_id NOT IN (SELECT us2.subscription_u_id FROM users_subscriptions us2 WHERE us2.u_id = :id AND us2.us_status = 1)
		GROUP BY us1.subscription_u_id LIMIT 2', $params);
	}
	public function changeUserStatus($id, $post){
		$params = [
			'id' => $id,
			'status' => $post['text'],
		];
		$this->db->query('UPDATE users SET u_status = :status WHERE u_id = :id', $params);
	}
	public function changeUserConfidentiality($post) {
		$params = [
			'id' => $_SESSION['user']['id'],
			'u_access' => $post['u_access'],
			'u_m_access' => $post['u_m_access'],
		];
		$this->db->query('UPDATE users SET u_access = :u_access, u_message_access = :u_m_access WHERE u_id = :id', $params);
		if($post['p_access'] != 3) {
			$params = [
				'id' => $_SESSION['user']['id'],
				'p_access' => $post['p_access'],
			];
			$this->db->query('UPDATE posts SET p_access = :p_access WHERE u_id = :id ', $params);
		}
	}
	public function changePostSettings($post) {
		$params = [
			'id' => $post['id'],
			'title' => $post['title'],
			'access' => $post['access'],
		];
		$this->db->query('UPDATE posts SET p_title = :title, p_access =:access WHERE p_id = :id', $params);
	}
	public function getUserNewMessages($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(m.m_id) FROM chats c JOIN messages m ON m.chat_id = c.chat_id
		WHERE (c.u_id = :id OR c.companion_id = :id) AND m.m_isRead = 0 AND m.u_id != :id ', $params);
	}
	public function getUserNewFriends($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(u_id) as friendCount FROM users_subscriptions WHERE us_status = 0 AND subscription_u_id = :id ', $params);
	}
	public function readNewMessages($user_id, $companion_id) {
		$params = [
			'id' => $user_id,
			'cmp'=> $companion_id,
		];
		return $this->db->query('UPDATE messages m JOIN chats c ON c.chat_id = m.chat_id SET m_isRead = "1"
			WHERE ((c.u_id = :id AND c.companion_id = :cmp) OR (c.u_id = :cmp AND c.companion_id = :id)) AND m.u_id = :cmp', $params);
	}
	public function getUserCity($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM users_cities uc JOIN cities c ON c.city_id = uc.city_id JOIN countries ctr ON ctr.country_id = c.country_id WHERE uc.u_id = :id', $params);
	}
	public function getAllCities($country) {
		$params = [
			'id' => $country,
		];
		return $this->db->row('SELECT * FROM cities WHERE country_id = :id', $params);
	}
	public function getUserStatSubs($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(subscription_u_id) FROM users_subscriptions WHERE subscription_u_id =:id AND us_status = 0', $params);
	}
	public function getUserStatFollows($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(subscription_u_id) FROM users_subscriptions WHERE u_id = :id AND us_status = 0', $params);
	}
	public function getUserStatFriends($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(subscription_u_id) FROM users_subscriptions WHERE u_id = :id AND us_status = 1', $params);
	}
	public function getUserStatPosts($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(p_id) FROM posts WHERE u_id = :id', $params);
	}
	public function getUserPosts($id) {
		$params = [
			'user' => $_SESSION['user']['id'],
			'id' => $id,
		];
		return $this->db->row('SELECT p.p_id, p.p_way, p.p_title, p.u_id, p.p_date , p.is_video, (SELECT COUNT(pl.u_id) FROM posts_likes pl WHERE pl.p_id = p.p_id ) as likes,
		COUNT(c.comment_id) as comments, (SELECT COUNT(pl.u_id) FROM posts_likes pl WHERE pl.p_id = p.p_id AND pl.u_id = :user) as isUserLike
		 FROM posts p LEFT JOIN comments c ON p.p_id = c.p_id WHERE p.u_id = :id GROUP BY p.p_id ORDER BY p.p_date DESC ', $params);
	}
	public function getUserSavedPosts($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT p.p_id, p.p_way, p.is_video, (SELECT COUNT(pl.u_id) FROM posts_likes pl WHERE pl.p_id = p.p_id ) as likes,
		COUNT(c.comment_id) as comments, (SELECT COUNT(pl.u_id) FROM posts_likes pl WHERE pl.p_id = p.p_id AND pl.u_id = :id) as isUserLike
		 FROM users_bookmark ub JOIN posts p ON ub.p_id = p.p_id LEFT JOIN comments c ON p.p_id = c.p_id WHERE ub.u_id = :id GROUP BY p.p_id ORDER BY ub.ubook_id DESC ', $params);
	}
	public function isPostSaved($user, $id) {
		$params = [
			'user' => $user,
			'id' => $id,
		];
		return $this->db->column('SELECT COUNT(u_id) FROM users_bookmark WHERE u_id = :user AND p_id = :id', $params);
	}
	public function isUserFriend($id) {
		if(isset($_SESSION['user'])) {
			$params = [
				'page_id' => $id,
				'user_id' => $_SESSION['user']['id'],
			];
			return $this->db->row('SELECT * FROM users_subscriptions WHERE u_id =:user_id AND subscription_u_id = :page_id', $params);
		}
	}
	public function getUserFriends($id, $flag) {
		$params = [
			'user_id' => $id,
		];
		$sql = 'SELECT * FROM users_subscriptions us JOIN users u ON u.u_id = us.subscription_u_id WHERE us.us_status = 1 AND us.u_id = :user_id ';
		if($flag == 'online') {
			$sql .= 'AND u.is_online = 1 ';
		}
		return $this->db->row($sql, $params);
	}

	public function getUserSubscribers($id) {
		$params = [
			'user_id' => $id,
		];
		return $this->db->row('SELECT * FROM users u JOIN users_subscriptions us ON u.u_id = us.u_id WHERE us.subscription_u_id = :user_id AND us.us_status = 0', $params);
	}
	public function getUserSubscriptions($id) {
		$params = [
			'user_id' => $id,
		];
		return $this->db->row('SELECT * FROM users_subscriptions us  JOIN users u ON u.u_id = us.subscription_u_id WHERE us.u_id = :user_id AND us.us_status = 0', $params);
	}

	public function getUsersByFilter($filter) {
		$params = [
			'user_id' => $_SESSION['user']['id'],
		];
		$sql = 'SELECT u.u_id, u.u_first_name, u.u_second_name, u.u_avatar, c.city_title, cnt.country_title, COUNT(us1.u_id) as popularity,
			(SELECT us.us_status FROM users u1 LEFT JOIN users_subscriptions us ON us.subscription_u_id = u1.u_id WHERE u1.u_id = u.u_id AND us.u_id = :user_id ) as us_status
			FROM users u LEFT JOIN users_subscriptions us1 ON us1.subscription_u_id = u.u_id LEFT JOIN cities c ON c.city_id = u.u_city
			LEFT JOIN countries cnt ON cnt.country_id = c.country_id WHERE 1 = 1';
		if($filter['country'] != 0) {
			$sql .= ' AND cnt.country_id = ' . $filter['country'];
		}
		if($filter['gender'] != 2) {
			$sql .= ' AND u.u_gender = ' . $filter['gender'];
		}
		if(isset($filter['isOnline'])) {
			$sql .= ' AND u.is_online = 1';
		}
		if(isset($filter['withPhoto'])) {
			$sql .= ' AND u.u_avatar = 1';
		}
		if(isset($filter['searchRow'])) {
			$filter['searchRow'] .= '%';
			$sql .= ' AND '.'('.'u.u_first_name LIKE "'. $filter['searchRow'] . '" OR u.u_second_name LIKE "'. $filter['searchRow'] . '" )';
		}
		if($filter['age'] != '0') {
			if($filter['age'] == '14') {
				$firstDate = '14';
				$secondDate = '19';
			}
			if($filter['age'] == '19') {
				$firstDate = '19';
				$secondDate = '29';
			}
			if($filter['age'] == '29') {
				$firstDate = '29';
				$secondDate = '39';
			}
			if($filter['age'] == '39') {
				$firstDate = '39';
				$secondDate = '50';
			}
			if($filter['age'] == '50') {
				$firstDate = '50';
				$secondDate = '80';
			}
			$sql .= ' AND  YEAR(CURDATE()) - u.u_birth_year >= ' . $firstDate . ' AND ' .' YEAR(CURDATE()) - u.u_birth_year <= ' . $secondDate ;
		}
		$sql .= ' GROUP BY u.u_id';
		if($filter['sorting'] == 1) {
			$sql .= ' ORDER BY popularity DESC';
		}elseif($filter['sorting'] == 2) {
			$sql .= ' ORDER BY u.u_register_date DESC';
		}
		return $this->db->row($sql, $params);
	}
	public function getCommentsForPost($id) {
		$params = [
			'post_id' => $id,
		];
		return $this->db->row('SELECT c.comment_id, c.comment_text, c.comment_date, c.p_id, c.u_id, u.u_first_name, u.u_second_name, u.u_avatar
			 FROM comments c JOIN users u ON c.u_id = u.u_id WHERE c.p_id = :post_id', $params);
	}
	public function removeComment($id) {
		$params = [
			'c_id' => $id,
		];
		return $this->db->query('DELETE FROM comments WHERE comment_id = :c_id', $params);
	}
	public function removePost($id, $user) {
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM comments WHERE p_id = :id', $params);
		$this->db->query('DELETE FROM posts_likes WHERE p_id = :id', $params);
		$post = $this->db->row('SELECT * FROM posts WHERE p_id = :id', $params);
		unlink("c:/xampp/htdocs/diploma/public/materials/".$post[0]['p_way']);
		$this->db->query('DELETE FROM posts WHERE p_id = :id', $params);
	}
	public function getPostAuthor($id) {
		$params = [
			'post_id' => $id,
		];
		return $this->db->row('SELECT u.u_id, u.u_first_name, u.u_second_name, u.u_avatar, u.u_access, p.p_date  FROM posts p JOIN users u ON p.u_id = u.u_id WHERE p.p_id = :post_id', $params);
	}
	public function addCommentToPost($post) {
		$params = [
			'post_id' => $post['post_id'],
			'text' => $post['text'],
			'user_id' => $_SESSION['user']['id'],
		];
		return $this->db->query('INSERT INTO comments VALUES (NULL, :post_id, :user_id, :text, CURRENT_TIMESTAMP)', $params);
	}
	public function getUserChats($id, $filter) {
		$params = [
			'user_id' => $id,
		];
		$sql = 'SELECT c.chat_id,c.last_message_id, IF(c.u_id = :user_id, c.companion_id, c.u_id) as companion_id, u.u_first_name, u.u_second_name,
		m.u_id as who_send_m, m.m_content, m.m_date, m.m_isRead, (SELECT COUNT(m1.m_id) FROM messages m1 WHERE m1.chat_id = c.chat_id AND m1.u_id != :user_id AND m1.m_isRead = 0) as new_message_counter
		FROM chats c LEFT JOIN users u ON IF(c.u_id = :user_id, c.companion_id, c.u_id) = u.u_id LEFT JOIN messages m ON m.m_id = c.last_message_id
		WHERE (c.u_id = :user_id OR c.companion_id = :user_id)';
		if($filter == 1) {
			$sql .= ' AND m.u_id != :user_id AND m.m_isRead = 0 ';
		}
		$sql .= ' ORDER BY m.m_date DESC';
		return $this->db->row($sql, $params);
	}
	public function getUserForChatStory($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT u.u_id, u.u_first_name, u.u_second_name FROM users u WHERE u.u_id = :id', $params);
	}
	public function getChatStory($companion_id){
		$user_id = $_SESSION['user']['id'];
		$params = [
			'user_id' => $user_id,
			'companion_id' => $companion_id,
		];
		return $this->db->row('SELECT m.m_id,m.m_content, m.u_id, m.m_date, m.m_isRead, u.u_first_name, u.u_second_name, u.u_avatar
			FROM (SELECT c.chat_id FROM chats c WHERE (c.u_id = :user_id AND c.companion_id = :companion_id)
			OR (c.u_id = :companion_id AND c.companion_id = :user_id)) as chat_idTable
			LEFT JOIN messages m ON chat_idTable.chat_id = m.chat_id JOIN users u ON m.u_id = u.u_id ORDER BY m.m_date', $params);
	}
	public function isUserBlock($companion_id) {
		$params = [
			'user_id' => $_SESSION['user']['id'],
			'companion_id' => $companion_id,
		];
		return $this->db->row('SELECT * FROM users_blocks WHERE (u_id = :user_id AND block_id = :companion_id) OR (u_id = :companion_id AND block_id = :user_id) ', $params);
	}
	public function getUserFeed($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT  u.u_id, u.u_first_name, u.u_second_name, u.u_gender, u.is_online, p.p_id, p.p_title, p.p_date, p.p_way, p.is_video,
			(SELECT COUNT(pl.u_id) FROM posts_likes pl WHERE pl.p_id = p.p_id) as likeCounter, (SELECT COUNT(c.comment_id) FROM comments c WHERE c.p_id = p.p_id) as commentCounter,
			(SELECT COUNT(pl1.u_id) FROM posts_likes pl1 WhERE pl1.p_id = p.p_id AND pl1.u_id = :id) as isUserLike
			FROM users_subscriptions us JOIN users u ON us.subscription_u_id = u.u_id JOIN posts p ON u.u_id = p.u_id
			WHERE us.u_id = :id AND (u.u_access = us.us_status OR u.u_access = 0) ORDER BY p.p_date DESC LIMIT 10', $params);
	}
	public function getUserById($id){
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM users WHERE u_id = :id', $params)[0];
	}
	public function getUserFeedComments($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT c.comment_id, c.u_id, c.comment_text, c.comment_date, post_id.p_id, u.u_first_name, u.u_second_name, u.is_online
			FROM(SELECT p.p_id FROM users_subscriptions us JOIN users u1 ON us.subscription_u_id = u1.u_id JOIN posts p ON u1.u_id = p.u_id
			WHERE us.u_id = :id AND (u1.u_access = us.us_status OR u1.u_access = 0) ORDER BY p.p_date) as post_id
			JOIN comments c ON c.p_id = post_id.p_id JOIN users u ON u.u_id = c.u_id', $params);
	}
	public function getDialog($user_id, $compan_id) {
		$params = [
			'first_id' => $user_id,
			'second_id' => $compan_id,
		];
		return $this->db->column('SELECT chat_id FROM chats WHERE (u_id=:first_id AND companion_id=:second_id) OR (u_id=:second_id AND companion_id=:first_id)', $params);
	}
	public function isDialogExist($user_id, $compan_id) {
		$params = [
			'first_id' => $user_id,
			'second_id' => $compan_id,
		];
		return $this->db->column('SELECT COUNT(chat_id) FROM chats WHERE (u_id=:first_id AND companion_id=:second_id) OR (u_id=:second_id AND companion_id=:first_id)', $params);
	}
	public function createDialog($user_id, $compan_id) {
		$params = [
			'first_id' => $user_id,
			'second_id' => $compan_id,
		];
		$this->db->query('INSERT INTO chats VALUES (NULL, :first_id, :second_id, NULL)', $params);
		return $this->db->lastInsertId();
	}
	public function sendMessage($user_id, $dialogId, $message) {
		$params = [
			'first_id' => $user_id,
			'dialog_id' => $dialogId,
			'message' => $message,
		];
		$this->db->query('INSERT INTO messages VALUES (NULL, :first_id, :message, NULL, "0", :dialog_id)', $params);
		$message_id = $this->db->lastInsertId();
		$params = [
			'message_id' => $message_id,
			'dialog_id' => $dialogId,
		];
		$this->db->query('UPDATE chats SET last_message_id = :message_id  WHERE chat_id = :dialog_id', $params);
	}
	public function changePersonalData($data) {
		$user_id = $_SESSION['user']['id'];
		$birthday = isset($data['birthday'])? (empty($data['birthday']) ? [NULL, NULL, NULL] : explode('-', $data['birthday'])) : [NULL, NULL, NULL] ;
		$data['town'] = isset($data['town']) ? $data['town'] : NULL;
		$data['hometown'] = isset($data['hometown']) ? $data['hometown'] : NULL;
		$data['institute'] = isset($data['institute']) ? $data['institute'] : NULL;
		$params = [
			'userId' => $user_id,
			'gender' => $data['gender'],
			'firstName' => $data['name'],
			'secondName' => $data['surname'],
			'birthDay' => $birthday[2],
			'birthMonth' => $birthday[1],
			'birthYear' => $birthday[0],
			'cityId' => $data['town'],
		];
		$this->db->query('UPDATE users SET u_first_name = :firstName, u_second_name = :secondName, u_gender = :gender, u_city = :cityId,
			u_birth_day = :birthDay, u_birth_month = :birthMonth, u_birth_year = :birthYear WHERE u_id =:userId', $params);
		$this->handleAdditionalInfo($user_id, $data['hometown'], $this->personalData['hometown']);
		$this->handleAdditionalInfo($user_id, $data['institute'], $this->personalData['institute']);
	}
	public function changeContactData($data) {
		$user_id = $_SESSION['user']['id'];
		$this->handleAdditionalInfo($user_id, $data['skype'], $this->personalData['skype']);
		$this->handleAdditionalInfo($user_id, $data['site'], $this->personalData['site']);
	}
	public function changeAditionalData($data) {
		$user_id = $_SESSION['user']['id'];
		$this->handleAdditionalInfo($user_id, $data['activity'], $this->personalData['activity']);
		$this->handleAdditionalInfo($user_id, $data['hobby'], $this->personalData['hobby']);
		$this->handleAdditionalInfo($user_id, $data['films'], $this->personalData['films']);
		$this->handleAdditionalInfo($user_id, $data['biography'], $this->personalData['biography']);
	}

	public function handleAdditionalInfo($userId, $data, $dataId) {
		$params = [
			'user' => $userId,
			'infoId' => $dataId,
		];
		if($this->db->column('SELECT COUNT(ui_title_id) FROM users_info WHERE ui_title_id = :infoId AND u_id = :user', $params)) {
			if(strlen($data) != 0) {
				$params = [
					'user' => $userId,
					'info' => $data,
					'infoId' => $dataId,
				];
				$this->db->query('UPDATE users_info SET ui_description = :info WHERE ui_title_id = :infoId AND u_id = :user', $params);
			} else {
				$this->db->query('DELETE FROM users_info WHERE u_id = :user AND ui_title_id = :infoId', $params);
			}
		} else {
			if(strlen($data) != 0) {
				$params = [
					'user' => $userId,
					'info' => $data,
					'infoId' => $dataId,
				];
				$this->db->query('INSERT INTO users_info VALUES(:user, :infoId, :info )', $params);
			}
		}
	}
	public function removeMainPhoto($id) {
		$standartPhoto = "C:\\xampp\\htdocs\\diploma\\public\\materials\\standart\\male.png";
		copy($standartPhoto, "C:\\xampp\\htdocs\\diploma\\public\\materials\\".$id.'\\main\\1.png');
		$this->db->query('UPDATE users set u_avatar = 0 WHERE u_id = ' .$id);
	}
	public function changeMainPhoto($id, $file) {
		$allowedfileExtensions = array('jpg','png', 'jpeg');
		$fileTmpPath = $file['uploadedFile']['tmp_name'];
		$fileName = $file['uploadedFile']['name'];
		$fileSize = $file['uploadedFile']['size'];
		$fileType = $file['uploadedFile']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		if (in_array($fileExtension, $allowedfileExtensions)) {
			$newFileName = '1.png';
			$uploadFileDir = "C:\\xampp\\htdocs\\diploma\\public\\materials\\".$id."\\main\\".$newFileName;
			move_uploaded_file($fileTmpPath, $uploadFileDir);
			$this->db->query('UPDATE users set u_avatar = 1 WHERE u_id = ' .$id);
		}
	}
	public function removeSubscribe($user_id, $subscribe_id) {
		$params = [
			'user' => $user_id,
			'subscribe' => $subscribe_id,
		];
		$this->db->query('UPDATE users_subscriptions SET us_status = 0 WHERE u_id = :subscribe AND subscription_u_id = :user', $params);
		$this->db->query('DELETE FROM users_subscriptions WHERE u_id = :user AND subscription_u_id = :subscribe', $params);
	}
	public function subsribeAtUser($user_id, $subscribe_id) {
		$params = [
			'user' => $user_id,
			'sub' => $subscribe_id,
		];
		$subStatus = $this->db->column('SELECT COUNT(us_id) from users_subscriptions WHERE u_id = :sub AND subscription_u_id = :user', $params);
		if($subStatus != 0) {
			$subStatus = 1;
			$this->db->query('UPDATE users_subscriptions SET us_status = 1 WHERE u_id = :sub AND subscription_u_id = :user', $params);
		}else {
			$subStatus = 0;
		}
		$params = [
			'user' => $user_id,
			'sub' => $subscribe_id,
			'status' => $subStatus,
		];
		$this->db->query('INSERT INTO users_subscriptions VALUES(NULL, :user, :sub, :status)', $params);
	}
	public function blockUser($user_id, $block_id) {
		$params = [
			'user' => $user_id,
			'block' => $block_id,
		];
		$this->db->query('INSERT INTO users_blocks VALUES(NULL, :user, :block)', $params);
	}
	public function unblockUser($user_id, $block_id) {
		$params = [
			'user' => $user_id,
			'block' => $block_id,
		];
		$this->db->query('DELETE FROM users_blocks WHERE u_id = :user AND block_id = :block', $params);
	}
	public function removeChatHistory($user_id, $compan) {
		$params = [
			'user' => $user_id,
			'comp' => $compan,
		];
		$dialog_id = $this->db->row('SELECT chat_id FROM chats WHERE (u_id = :user AND companion_id = :comp) OR (u_id = :comp AND companion_id = :user)', $params);
		if(empty($dialog_id)) return;
		$params['dialog_id'] = $dialog_id[0]['chat_id'];

		$this->db->query('DELETE FROM messages WHERE chat_id = '. $params['dialog_id']);
		$this->db->query('DELETE FROM chats WHERE chat_id = '. $params['dialog_id']);
	}
	public function toggleLikePost($user, $post_id) {
		$params = [
			'user' => $user,
			'id' => $post_id,
		];
		$isUserLike = $this->db->column('SELECT COUNT(u_id) FROM posts_likes WHERE u_id = :user AND p_id = :id', $params);
		if( $isUserLike != 0 ) {
			$this->db->query('DELETE FROM posts_likes WHERE u_id = :user AND p_id = :id', $params);
		} else {
			$this->db->query('INSERT INTO posts_likes VALUES(:id, :user)', $params);
		}
	}
	public function togglePostBook($user, $post_id) {
		$params = [
			'user' => $user,
			'id' => $post_id,
		];
		$isUserSave = $this->db->column('SELECT COUNT(u_id) FROM users_bookmark WHERE u_id = :user AND p_id = :id', $params);
		if( $isUserSave != 0 ) {
			$this->db->query('DELETE FROM users_bookmark WHERE u_id = :user AND p_id = :id', $params);
		} else {
			$this->db->query('INSERT INTO users_bookmark VALUES(NULL, :user, :id)', $params);
		}
	}
}
