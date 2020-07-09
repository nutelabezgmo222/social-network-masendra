<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;

class GuestController extends Controller {

	public function registerAction() {
		$this->view->layout = 'authorize';
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'regSecond') {
				$errors = $this->model->regSecondValidate($_POST);
				echo json_encode($errors);
				exit;
			}
		}
		$this->view->render('Регистрация');
	}

	public function registerFinishAction(){
		$this->view->layout = 'authorize';
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'regLast') {
				try{
					$errors = $this->model->insertUser($_POST);
				}
				catch(Exception $e){
					$error['status'] = 'error';
					$error['message'] = 'Упс щось пішло не так!';
					echo json_encode($error);
					exit;
				}
				$error['status'] = 'success';
				echo json_encode($error);
				exit;
			}
		}
		$this->view->render('Майже все!');
	}

	public function loginAction(){
		$this->view->layout = 'authorize';
		if(isset($_SESSION['user'])) {
			$this->view->redirect('diploma/id/' . $_SESSION['user']['id']);
		}
		if(isset($_POST['action']) && !empty($_POST['action'])) {
			if($_POST['action'] == 'regFirst') {
				$errors = $this->model->regFirstValidate($_POST);
				echo json_encode($errors);
				exit;
			}
			if($_POST['action'] == 'loginUser') {
				$user = $this->model->loginValidate($_POST);
				if (empty($user)) {
					$this->view->message('error',"Логин или пароль введены неверно");
				} else {
					$this->model->setSession_user($user[0]);
					$this->view->location('/diploma/id/' . $_SESSION['user']['id']);
				}
				exit;
			}
		}
		$this->view->render('Авторизация');
	}
}
