<?php

$app->post('/users/check_session', function() use ($app) {
  $post = json_decode($app->request->getBody());
  if(isset($post->username,$post->password,$post->level)){
    $pdo = getConnection();
    $stmt = $pdo->select(['id'])
                ->from('an_users')
                ->where('username','=',$post->username)
                ->where('password','=',$post->password)
                ->where('level','=',$post->level);
    $stmt->count();
    $sq = $stmt->execute();
    $login = $sq->fetchColumn();
    //selection de l'utilisateur
    if ($login == 1) {
         echo '{"message":"ok"}';
     } else {
          $app->response->setStatus(300);
          echo '{"message":"error"}';
     }
  } else {
       $app->response->setStatus(300);
       echo '{"message":"error"}';
  }
});

$app->post('/users/login', function() use ($app) {
  $post = json_decode($app->request->getBody());
  if(isset($post->username,$post->password)){
    $pdo = getConnection();
    $stmt = $pdo->select()
                ->from('an_users')
                ->where('username','=',$post->username)
                ->limit(1);
    $sq = $stmt->execute();
    $login = $sq->fetch();
    //selection de l'utilisateur
    if (isset($login['id']) && password_verify($post->password, $login['password'])) {
      //check hash = password alors ok
         /* Valid */
         echo json_encode($login);
     } else {
          $app->response->setStatus(300);
          echo '{"message":"error"}';
     }
  }
});
$app->post('/users/register', function() use ($app) {
  $post = json_decode($app->request->getBody());
  if(isset($post->email,$post->username,$post->password,$post->password2)){
    $pdo = getConnection();
    $error = 0;
    $error_txt = [];
    $stmt = $pdo->select(['id'])->from('an_users')->where('username','=',$post->username);
    $stmt->count();
    $sq = $stmt->execute();
    $count_username = $sq->fetchColumn();
    if($count_username != 0){
      $error_txt['username'] = "username exist";
      $error++;
    }
    $stmt = $pdo->select(['id'])->from('an_users')->where('email','=',$post->email);
    $stmt->count();
    $sq = $stmt->execute();
    $count_email = $sq->fetchColumn();
    if($count_email != 0){
      $error_txt['email'] = "email exist";
      $error++;
    }

    if (!filter_var($post->email, FILTER_VALIDATE_EMAIL)) {
      $error_txt['email_format'] = "invalid email format";
      $error++;
    }
    if(strlen($post->username) > 30 && strlen($post->username)<2){
      $error_txt['username_size'] = 'error size';
      $error++;
    }
    if(strlen($post->password)>30 && strlen($post->password2)<6){
      $error_txt['password_size'] = 'error size';
      $error++;
    }
    if($post->password != $post->password2){
      $error_txt['password_match'] = 'password not match';
      $error++;
    }
    if($error == 0){
      $hash = password_hash($post->password, PASSWORD_BCRYPT, array("cost" => 10));
      $sql = $pdo->insert(['username,password,email,created'])
                 ->into('an_users')
                 ->values([$post->username,$hash,$post->email, date('Y-m-d H:i:s')]);
      $new = $sql->execute();
      echo '{"message":"ok"}';
    } else {
      $app->response->setStatus(300);
      echo '{"message":'.json_encode($error_txt).'}';
    }
  }
});
