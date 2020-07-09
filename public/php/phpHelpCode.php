<?php
$config = [
  'host'=>'localhost',
  'name'=>'msdra',
  'password'=>'',
  'user'=>'root',
];
session_start();

$db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].';charset=utf8', $config['user'], $config['password']);

if(isset($_POST['action']) && !empty($_POST['action'])) {
  if($_POST['action'] == 'updateLastAction') {
    $params = [
      'id' => $_SESSION['user']['id'],
    ];
    $sql = 'UPDATE users SET last_action = CURRENT_TIMESTAMP WHERE u_id = '. $params['id'];
    $sth = $db->prepare($sql);
    $sth->execute();
  }
}
 ?>
