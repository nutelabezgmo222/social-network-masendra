<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class UserController extends Controller {

	public function indexAction() {
		if(!isset($_SESSION['user'])) {
			$this->view->redirect('diploma/login');
		}
		if(!isset($this->route['id'])) {
			$this->view->redirect('diploma/id/' . $_SESSION['user']['id']);
		}
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'getPostData') {
				$vars = [
					'comments' =>  $this->model->getCommentsForPost($_POST['id']),
					'author' =>  $this->model->getPostAuthor($_POST['id']),
					'post_info' => $this->model->getPostInfo($_POST['id']),
					'user_id' => $_SESSION['user']['id'],
					'isSaved' => $this->model->isPostSaved($_SESSION['user']['id'], $_POST['id']),
					'friend_status' => $this->model->getFriendStatus($_SESSION['user']['id'], $_POST['id']),
				];
				$vars['author'][0]['p_date'] = dateWithYear($vars['author'][0]['p_date']);
				for ($i=0; $i < count($vars['comments']); $i++) {
					$vars['comments'][$i]['comment_date'] = dateHandler($vars['comments'][$i]['comment_date']);
				}
				echo json_encode($vars);
				exit;
			}
			if($_POST['action'] == 'getPostLikes') {
				$likes = $this->model->getPostLikes($_POST['post_id']);
				echo json_encode($likes);
				exit;
			}
			if($_POST['action'] == 'sendComment') {
				$this->model->addCommentToPost($_POST);
				echo '1';
				exit;
			}
			if($_POST['action'] == 'deletePhoto') {
				$this->model->removeMainPhoto($_SESSION['user']['id']);
				exit;
			}
			if($_POST['action'] == 'changeMainPhoto') {
				$this->model->changeMainPhoto($_SESSION['user']['id'], $_FILES);
				echo json_encode('true');
				exit;
			}
			if($_POST['action'] == 'removeSubscribe') {
				$id = $_POST['id'];
				$this->model->removeSubscribe($_SESSION['user']['id'], $id);
				echo json_encode('true');
				exit;
			}
			if($_POST['action'] == 'toggleLikePost') {
				$id = $_POST['id'];
				$this->model->toggleLikePost($_SESSION['user']['id'], $id);
				exit;
			}
			if($_POST['action'] == 'subsribeAtUser') {
				$id = $_POST['id'];
				$this->model->subsribeAtUser($_SESSION['user']['id'], $id);
				echo json_encode('true');
				exit;
			}
			if($_POST['action'] == 'changeUserStatus') {
				$this->model->changeUserStatus($_SESSION['user']['id'], $_POST);
				exit;
			}
			if($_POST['action'] == 'removeComment') {
				$id = $_POST['id'];
				$this->model->removeComment($id);
				exit;
			}
			if($_POST['action'] == 'togglePostBook') {
				$id = $_POST['id'];
				$this->model->togglePostBook($_SESSION['user']['id'], $id);
				exit;
			}
		}
		if(isset($_POST['uploadBtn']) && !empty($_POST['uploadBtn'])){
			$this->model->addPost($_POST, $_FILES);
			unset($_POST['uploadBtn']);
		}
		$vars = [
			'user' => $this->model->getUserInfo($this->route['id']),
			'additional_general' => $this->model->getUserAdditional($this->route['id'], 1),
			'additional_contact' => $this->model->getUserAdditional($this->route['id'], 2),
			'additional_personal' => $this->model->getUserAdditional($this->route['id'], 3),
			'sub_counter' => $this->model->getUserStatSubs($this->route['id']),
			'follow_counter' => $this->model->getUserStatFollows($this->route['id']),
			'friend_counter' => $this->model->getUserStatFriends($this->route['id']),
			'post_counter' => $this->model->getUserStatPosts($this->route['id']),
			'is_friend' => $this->model->isUserFriend($this->route['id']),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		if(empty($vars['is_friend'])) {
			$vars['is_friend'] = -1;
		} else {
			$vars['is_friend'] = $vars['is_friend'][0]['us_status'];
		}
		if(isset($this->route['sec']) && !(empty($this->route['sec']))) {
			if($this->route['sec'] == 'saved') {
				$vars['posts'] = $this->model->getUserSavedPosts($_SESSION['user']['id']);
			}
		}else {
				$vars['posts'] = $this->model->getUserPosts($this->route['id']);
		}
		$this->view->render('Главная страница', $vars);
	}

	public function outAction(){
		if(isset($_SESSION['user'])) {
			$this->model->logOut();
			$this->view->redirect('diploma/login');
		}
	}

	public function feedAction(){
		$id = $_SESSION['user']['id'];

		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'sendComment') {
				$this->model->addCommentToPost($_POST);
				echo json_encode('feed');
				exit;
			}
			if($_POST['action'] == 'toggleLikePost') {
				$id = $_POST['id'];
				$this->model->toggleLikePost($_SESSION['user']['id'], $id);
				exit;
			}
			if($_POST['action'] == 'removeComment') {
				$id = $_POST['id'];
				$this->model->removeComment($id);
				exit;
			}
		}

		$vars = [
			'feed' => $this->model->getUserFeed($id),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		$comments = $this->model->getUserFeedComments($id);
		$feedLength = count($vars['feed']);
		$commentsLength = count($comments);
		for ($i = 0; $i < $feedLength ; $i++) {
			for ($j = 0; $j < $commentsLength; $j++) {
				if($vars['feed'][$i]['p_id'] == $comments[$j]['p_id']){
					$vars['feed'][$i]['comments'][] = $comments[$j];
				}
			}
		}
		$this->view->render('Стрічка новин', $vars);
	}
	public function friendsAction() {
		$section = 'all';
		$userId = $_SESSION['user']['id'];

		if(isset($this->route['usr'])){
			$userId = $this->route['usr'];
		}
		if(isset($this->route['sec'])) {
			$section = $this->route['sec'];
		}
		$vars = [
			'user_list' => $this->model->getUserFriends($userId, $section),
			'friend_counter' => $this->model->getUserStatFriends($userId, $section),
			'usr' => $this->model->getUserById($userId),
			'section' => $section,
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		if(isset($_POST['getData']) && !empty($_POST['getData'])) {
			echo json_encode($vars);
			exit;
		}
		$this->view->render('Лист друзів', $vars);
	}
	public function friendsSearchAction(){
		$filters = [
			'country' => 0,
			'gender' => 2,
			'sorting' => 1,
			'age' => 0,
		];
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'findUsers') {
					$data['searchResult'] = $this->model->getUsersByFilter($_POST['filters']);
					$data['user'] = $_SESSION['user']['id'];
					echo json_encode($data);
					exit;
				}
				if($_POST['action'] == 'removeSubscribe') {
					$id = $_POST['id'];
					$this->model->removeSubscribe($_SESSION['user']['id'], $id);
					echo json_encode('true');
					exit;
				}
				if($_POST['action'] == 'subsribeAtUser') {
					$id = $_POST['id'];
					$this->model->subsribeAtUser($_SESSION['user']['id'], $id);
					echo json_encode('true');
					exit;
				}
		}
		$vars = [
			'user_list' => $this->model->getUsersByFilter($filters),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];

		$this->view->render('Пошук друзів', $vars);
	}
	public function friendsRequestAction(){
		$section = 'all_request';
		$userId = $_SESSION['user']['id'];
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'removeSubscribe') {
				$id = $_POST['id'];
				$this->model->removeSubscribe($_SESSION['user']['id'], $id);
				echo json_encode('true');
				exit;
			}
			if($_POST['action'] == 'subsribeAtUser') {
				$id = $_POST['id'];
				$this->model->subsribeAtUser($_SESSION['user']['id'], $id);
				echo json_encode('true');
				exit;
			}
		}
		if(isset($this->route['usr'])) {
			$userId = $this->route['usr'];
		}
		if(isset($this->route['sec'])) {
			$section = $this->route['sec'];
		}
		if($this->route['sec'] == "all_request") {
			$usersList = $this->model->getUserSubscribers($userId);
		}
		if($this->route['sec'] == "out_request") {
			$usersList = $this->model->getUserSubscriptions($userId);
		}
		$vars = [
			'users_list' => $usersList,
			'usr' => $this->model->getUserById($userId),
			'section' => $section,
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		$this->view->render('Друзі', $vars);
	}

  public function messagesAction(){
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'removeAsidePerson') {
				$id = $_POST['id'];
				foreach ($_SESSION['chats']['users'] as $key => $user) {
					if($user['u_id'] == $id) {
						unset($_SESSION['chats']['users'][$key]);
						unset($_SESSION['chats']['id'][$key]);
					}
				}
			}
			if($_POST['action'] == 'removeChatHistory') {
				$id = $_POST['id'];
				$this->model->removeChatHistory($_SESSION['user']['id'], $id);
				exit;
			}
			if($_POST['action'] == 'checkNewMessage') {
				$user = $_SESSION['user']['id'];
				$vars = [];
				$newMessages = $this->model->getNewMessages($user);
				if(!empty($newMessages)) {
					$vars = [
						'messages' => $newMessages,
					];
					foreach ($vars['messages'] as $key => $val) {
						$vars['messages'][$key]['m_date'] = dateHandler($val['m_date']);
					}
				}
				echo json_encode($vars);
				exit;
			}
		}
		$filter = 0;
		if(isset($this->route['sec'])) {
			if($this->route['sec'] == 'unread') {
				$filter = 1;
			}
		}
		$vars = [
			'chats' => $this->model->getUserChats($_SESSION['user']['id'], $filter),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
    $this->view->render('Повідомлення', $vars);
  }

	public function chatAction(){
		if(!isset($_SESSION['chats'])) {
			$_SESSION['chats']['users'] = [];
			$_SESSION['chats']['id'] = [];
		}elseif(count($_SESSION['chats']['id']) >= 4 && !in_array($this->route['usr'], $_SESSION['chats']['id'])){
			array_shift($_SESSION['chats']['id']);
			array_shift($_SESSION['chats']['users']);
		}
		if(!in_array($this->route['usr'], $_SESSION['chats']['id'])) {
			$_SESSION['chats']['id'][] = $this->route['usr'];
			$_SESSION['chats']['users'][] = $this->model->getUserForChatStory($this->route['usr'])[0];
		}
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'sendMessage') {
				$user_id = $_SESSION['user']['id'];
				$companion_id = $this->route['usr'];
				if(!$this->model->isDialogExist($user_id, $companion_id)) {
					$dialogId = $this->model->createDialog($user_id, $companion_id);
				}else {
					$dialogId = $this->model->getDialog($user_id, $companion_id);
				}
				echo $this->model->sendMessage($user_id, $dialogId, $_POST['message']);
				exit;
			}
			if($_POST['action'] == 'removeAsidePerson') {
				$id = $_POST['id'];
				foreach ($_SESSION['chats']['users'] as $key => $user) {
					if($user['u_id'] == $id) {
						unset($_SESSION['chats']['users'][$key]);
						unset($_SESSION['chats']['id'][$key]);
					}
				}
				exit;
			}
			if($_POST['action'] == 'blockUser') {
				$id = $_POST['id'];
				$this->model->blockUser($_SESSION['user']['id'], $id);
				exit;
			}
			if($_POST['action'] == 'unblockUser') {
				$id = $_POST['id'];
				$this->model->unblockUser($_SESSION['user']['id'], $id);
				exit;
			}
			if($_POST['action'] == 'removeChatHistory') {
				$id = $_POST['id'];
				$this->model->removeChatHistory($_SESSION['user']['id'], $id);
				exit;
			}
			if($_POST['action'] == 'checkForUpdateMessage') {
				$companion = $this->route['usr'];
				$vars = [
					'message' => $this->model->getUserLastMessage($_SESSION['user']['id'], $companion),
				];
				echo json_encode($vars);
				exit;
			}
			if($_POST['action'] == 'readMessages') {
				$companion = $this->route['usr'];
				$this->model->readNewMessages($_SESSION['user']['id'], $companion);
				exit;
			}
			if($_POST['action'] == 'checkNewDialogMessage') {
				$id = $this->route['usr'];
				$vars = [
					'messages' => $this->model->getNewDialogMessages($_SESSION['user']['id'], $id),
					'user' => $_SESSION['user']['id'],
				];
				foreach ($vars['messages'] as $key => $val) {
					$vars['messages'][$key]['m_date'] = getTime($val['m_date']);
				}
				echo json_encode($vars);
				exit;
			}
		}
		$this->model->readNewMessages($_SESSION['user']['id'], $this->route['usr']);
		$vars = [
		 	'chatStory'=> $this->model->getChatStory($this->route['usr']),
			'companion' => $this->model->getUserInfo($this->route['usr']),
			'isBlock' => $this->model->isUserBlock($this->route['usr']),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		for ($i=0; $i < count($vars['chatStory']); $i++) {
			$vars['chatStory'][$i]['m_day'] = getDay($vars['chatStory'][$i]['m_date']);
			$vars['chatStory'][$i]['m_month'] = getMonth($vars['chatStory'][$i]['m_date']);
			$vars['chatStory'][$i]['m_year'] = getYear($vars['chatStory'][$i]['m_date']);
		}
		$this->view->render('Повідомлення', $vars);
	}

	public function albumsAction() {
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'getPostData') {
				$vars = [
					'comments' =>  $this->model->getCommentsForPost($_POST['id']),
					'author' =>  $this->model->getPostAuthor($_POST['id']),
					'post_info' => $this->model->getPostInfo($_POST['id']),
					'user_id' => $_SESSION['user']['id'],
					'isSaved' => $this->model->isPostSaved($_SESSION['user']['id'], $_POST['id']),
					'friend_status' => $this->model->getFriendStatus($_SESSION['user']['id'], $_POST['id']),
				];
				$vars['author'][0]['p_date'] = dateWithYear($vars['author'][0]['p_date']);
				for ($i=0; $i < count($vars['comments']); $i++) {
					$vars['comments'][$i]['comment_date'] = dateHandler($vars['comments'][$i]['comment_date']);
				}
				echo json_encode($vars);
				exit;
			}
			if($_POST['action'] == 'getPostSettings') {
				$vars = [
					'postSettings' => $this->model->getPostInfo($_POST['id']),
				];
				echo json_encode($vars);
				exit;
			}
			if($_POST['action'] == 'getPostLikes') {
				$likes = $this->model->getPostLikes($_POST['post_id']);
				echo json_encode($likes);
				exit;
			}
			if($_POST['action'] == 'toggleLikePost') {
				$id = $_POST['id'];
				$this->model->toggleLikePost($_SESSION['user']['id'], $id);
				exit;
			}
			if($_POST['action'] == 'changePostSettings') {
				$this->model->changePostSettings($_POST);
				exit;
			}
			if($_POST['action'] == 'removePost') {
				$id = $_POST['id'];
				$user = $_SESSION['user']['id'];
				$this->model->removePost($id, $user);
				exit;
			}
			if($_POST['action'] == 'sendComment') {
				$this->model->addCommentToPost($_POST);
				echo '1';
				exit;
			}
		}
		$vars = [
			'albums' => $this->model->getUserPosts($_SESSION['user']['id']),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		$this->view->render('Мої фотографіїї', $vars);
	}

	public function settingsAction() {
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'getCities') {
				$cities = $this->model->getAllCities($_POST['country_id']);
				echo json_encode($cities);
				exit;
			}
		}
		if(isset($_POST['additionalSettings']) && !empty($_POST['additionalSettings'])) {
			$this->model->changePersonalData($_POST);
		}
		$vars = [
			'user' => $this->model->getUserInfo($_SESSION['user']['id']),
			'user_info' => $this->model->getUserAdditional($_SESSION['user']['id'], 1),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		if(isset($vars['user']['country_id'])) {
			$vars['cities'] = $this->model->getAllCities($vars['user']['country_id']);
		}
		$vars['user']['birthday'] = makeDate($vars['user']['u_birth_day'], $vars['user']['u_birth_month'], $vars['user']['u_birth_year']);
		$this->view->render('Редагування моєї сторінки', $vars);
	}
	public function settingsAdditionalAction() {
		if(isset($_POST['additionalSettings']) && !empty($_POST['additionalSettings'])) {
			$this->model->changeAditionalData($_POST);
		}
		$vars = [
			'user_info' => $this->model->getUserAdditional($_SESSION['user']['id'], 3),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		$this->view->render('Редагування моєї сторінки', $vars);
	}
	public function settingsContactAction() {
		if(isset($_POST['additionalSettings']) && !empty($_POST['additionalSettings'])) {
			$this->model->changeContactData($_POST);
		}
		$vars = [
			'user_info' => $this->model->getUserAdditional($_SESSION['user']['id'], 2),
			'new_messages_counter' => $this->model->getUserNewMessages($_SESSION['user']['id']),
			'new_friends_counter' => $this->model->getUserNewFriends($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		$this->view->render('Редагування моєї сторінки', $vars);
	}
	public function confidentialityAction() {
		if(isset($_POST['confidentialityButton']) && !empty($_POST['confidentialityButton'])) {
			$this->model->changeUserConfidentiality($_POST);
		}
		$vars = [
			'settings' => $this->model->getUserAccess($_SESSION['user']['id']),
			'posts_access' => $this->model->getUserPostAccess($_SESSION['user']['id']),
			'mutual_friends' => $this->model->getUserMutualFriends($_SESSION['user']['id']),
		];
		$this->view->render('Конфіденційність', $vars);
	}

}
