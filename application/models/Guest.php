<?php

namespace application\models;

use application\core\Model;

class Guest extends Model {

	public $error;

	public function loginValidate($post) {
		$login = $post['login'];
		$password = $post['password'];
		$params = [
			'login' => $login,
			'password' => $password,
		];
		return $this->db->row('SELECT * FROM users WHERE u_login = :login AND u_password = :password', $params);
	}
	public function isLoginExist($login) {
		$params = [
			'login' => $login,
		];
		return $this->db->column('SELECT COUNT(u_id) FROM users WHERE u_login = :login', $params);
	}
	public function setSession_user($user) {
		$_SESSION['user'] = [];
		$_SESSION['user']['id'] = $user['u_id'];
		$_SESSION['user']['name'] = $user['u_first_name'];
		$this->db->query('UPDATE users SET is_online = 1 WHERE u_id = ' . $user['u_id']);
	}
	public function regFirstValidate($post) {
		$errors = [];
		$name = trim($post['name']);
		$surname = trim($post['surname']);
		$login = trim($post['login']);
		$errors['status'] = 'error';
		if(empty($name)) {
			$errors['mes'] = 'Гей, ти забув ввести своє ім\'я';
			$errors['block'] = 'name';
			return $errors;
		}
		if(empty($surname)) {
			$errors['mes'] = 'І не забудь вказати свою фамілію';
			$errors['block'] = 'surname';
			return $errors;
		}
		if(empty($login)) {
			$errors['mes'] = 'Скоріш придумай собі логін';
			$errors['block'] = 'reg-login';
			return $errors;
		}
		$isLoginUnique = $this->isLoginExist($login);
		if($isLoginUnique != 0) {
			$errors['mes'] = 'Цей логін вже використано придумай інший!';
			$errors['block'] = 'reg-login';
			return $errors;
		}
		$errors['status'] = 'success';

		$_SESSION['register']['name'] = $name;
		$_SESSION['register']['surname'] = $surname;
		$_SESSION['register']['reg-login'] = $login;

		return $errors;
	}

	public function regSecondValidate($post) {
		$firstCheck = $this->regFirstValidate($post);
		if($firstCheck['status'] == 'error') {
			return $firstCheck;
		}

		$errors['status'] = 'error';
		$password = trim($post['password']);
		$repassword = trim($post['repassword']);
		$gender = isset($post['gender']) ? $post['gender'] : NULL;
		$birthday = $post['birthday'] ? explode('-', $post['birthday']) : NULL;
		if($gender == NULL) {
			$errors['mes'] = 'Вкажи свою стать';
			$errors['block'] = 'gender';
			return $errors;
		}
		if(empty($password)) {
			$errors['mes'] = 'Придумай пароль!';
			$errors['block'] = 'password';
			return $errors;
		}
		if(strlen($password) < 6 || strlen($password) > 12) {
			$errors['mes'] = 'Довжина пароля має бути від 6 до 12 символів';
			$errors['block'] = 'password';
			return $errors;
		}
		if($repassword != $password) {
			$errors['mes'] = 'Паролі не збігаються, що ж це коеться....';
			$errors['block'] = 'repassword';
			return $errors;
		}

		if($birthday == NULL) {
			$errors['mes'] = 'Не забудьте вказати свій рік нарождення!';
			$errors['block'] = 'birthday';
			return $errors;
		}
		$currentYear = date('Y');
		if($currentYear - $birthday[0] < 14 || $currentYear - $birthday[0] > 80) {
			$errors['mes'] = 'Що б зареєструватися вам повинно бути від 14 до 80 років!';
			$errors['block'] = 'birthday';
			return $errors;
		}
		$errors['status'] = 'success';

		$_SESSION['register']['password'] = $password;
		$_SESSION['register']['gender'] = $gender;
		$_SESSION['register']['birthday'] = $birthday;

		return $errors;
	}
	public function insertUser($post) {
		$email = $post['email'];
		$user = $_SESSION['register'];
		$standartPhoto = "C:\\xampp\\htdocs\\diploma\\public\\materials\\standart\\male.png";
		$params = [
			'name' => $user['name'],
			'surname' => $user['surname'],
			'login' => $user['reg-login'],
			'password' => $user['password'],
			'gender' => $user['gender'],
			'email' => $email,
			'birth_year' => $user['birthday'][0],
			'birth_month' => $user['birthday'][1],
			'birth_day' => $user['birthday'][2],
		];
		unset($_SESSION['register']);
		$this->db->query('INSERT INTO users VALUES(NULL, :name, :surname, :login, :email, :password, "", :birth_day, :birth_month, :birth_year, "0", :gender, NULL, "2", "0", "0", "0", NULL, NULL, "0", "0")', $params);
		$user_id = $this->db->lastInsertId();
		mkdir("C:\\xampp\\htdocs\\diploma\\public\\materials\\".$user_id, 0700);
		mkdir("C:\\xampp\\htdocs\\diploma\\public\\materials\\".$user_id.'\\aa', 0700);
		mkdir("C:\\xampp\\htdocs\\diploma\\public\\materials\\".$user_id.'\\main', 0700);
		copy($standartPhoto, "C:\\xampp\\htdocs\\diploma\\public\\materials\\".$user_id.'\\main\\1.png');
		return $user_id;
	}
}
