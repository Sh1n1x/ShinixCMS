<?php
$app->get('/blog/:size_img', function($size_img) use($parser,$ImageManager) {
	$pdo = getConnection();
	$size_img2 = explode('x',$size_img);
	$selectStatement = $pdo->select(['B.id,B.title,B.content,B.created,M.file,M.name'])
						 ->from('an_blog as B')
						 ->leftJoin('an_medias as M', 'B.img_id', '=', 'M.id')
						 ->where('B.online','=',1)
						 ->orderBy('B.created','DESC');
	$stmt = $selectStatement->execute();
	$data = $stmt->fetchAll(PDO::FETCH_CLASS);
  foreach($data as $v){
  if(file_exists('../uploads/'.$v->file) && is_array($size_img2) && is_numeric($size_img2[0]) && is_numeric($size_img2[1])){
      $name = str_replace($v->name,$v->name.'_'.$size_img,$v->file);
      if(!file_exists('../uploads/'.$name)){
        $ImageManager->make('../uploads/'.$v->file)->crop($size_img2[0], $size_img2[1])->save('../uploads/'.$name);
        $filename_from_url = parse_url('../uploads/'.$v->file);
      }
      $v->file = $name;
    }
    $v->content = strip_tags($parser->defaultTransform($v->content));
  }
  
 echo json_encode($data);
});

$app->get('/blog/article/:slug/:id', function ($slug, $id) use($parser) {
  $id = intval($id);
  $pdo = getConnection();
  $sct = $pdo->select(['id,slug,title,content'])->from('an_blog')->where('id','=',$id);
  $stmt = $sct->execute();
  $data = $stmt->fetch();
  $data['content'] = $parser->defaultTransform($data['content']);
  echo json_encode($data);
});

$app->get('/blog/admin', function () {
  $pdo = getConnection();
  $sct = $pdo->select(['id,title,created'])->from('an_blog');
  $stmt = $sct->execute();
  $data = $stmt->fetchAll();
  echo json_encode($data);
});

/**
* ENREGISTREMENT D'UN ARTICLE EXISTANT
**/
$app->get('/blog/admin/edit/:id', function ($id) use($app) {
  $id = intval($id);
  $pdo = getConnection();
  $sct = $pdo->select(['id,title,content,online'])->from('an_blog')->where('id','=',$id);
  $stmt = $sct->execute();
  $data = $stmt->fetch();
  if(isset($data['id'])){
    echo json_encode($data);
  } else {
    $app->response->setStatus(404);
  }
});
$app->post('/blog/admin/edit/:id', function ($id) use ($app) {
  $post = json_decode($app->request->getBody());
  $id = intval($id);
  if(isset($post->title,$post->content,$post->online,$id) && is_numeric($id)){
    $pdo = getConnection();
    $sct = $pdo->update(['title'=>$post->title,'slug'=>slugify($post->title),'content'=>$post->content,'online'=>$post->online])
               ->table('an_blog')
               ->where('id','=',$id);
    $stmt = $sct->execute();
  }
});

/**
* ENREGISTREMENT D'UN NOUVEL ARTICLE
**/
$app->post('/blog/admin/new', function () use($app) {
  $pdo = getConnection();
  //on va créer un article vierge (pour avoir uniquement l'ID),
  //mais avant il faut qu'on vérifie s'il n'en existe pas un
  $stmt = $pdo->select(['id'])->from('an_blog')->where('online','=',9)->limit(1);
  $sq = $stmt->execute();
  $data = $sq->fetch();
  if(isset($data['id'])){
    echo json_encode($data);
  } else{
    $sql = $pdo->insert(['online,created'])->into('an_blog')->values([9, date('Y-m-d H:i:s')]);
    $new = $sql->execute();
    $data = ['id'=>$new];
    echo json_encode($data);
  }
});

/**
* UPLOAD IMG
**/
$app->post('/blog/upload/:id', function($id) use ($app) {
  $handle = new upload($_FILES['file']);
  if ($handle->uploaded) {
    $handle->file_auto_rename = true;
    $handle->allowed = array('image/*');
    $handle->process('../uploads/blog/'.date('Y').'/'.date('m'));
    if ($handle->processed) {
      $pdo = getConnection();
      $add = $pdo->insert(['name','file','module','ref_id'])
                 ->into('an_medias')
                 ->values([
                      $handle->file_src_name_body,
                      'blog/'.date('Y').'/'.date('m').'/'.$handle->file_src_name,
                      'blog',
                      $id
                 ]);
      $add->execute();
      $handle->clean();
    } else {
      echo 'error : ' . $handle->error;
    }
  }
});
/**
* SELECT IMG
**/
$app->get('/blog/img/:id', function($id) use($ImageManager) {
  $id = intval($id);
  $pdo = getConnection();
  $sct = $pdo->select(['file','id','name'])
             ->from('an_medias')
             ->where('ref_id','=',$id);
  $stmt = $sct->execute();
  $data = $stmt->fetchAll(PDO::FETCH_CLASS);
  foreach($data as $v){
    if(file_exists('../uploads/'.$v->file)){
      $name = str_replace($v->name,$v->name.'_200x200',$v->file);
      if(!file_exists('../uploads/'.$name)){
        $ImageManager->make('../uploads/'.$v->file)->crop(200, 200)->save('../uploads/'.$name);
        $filename_from_url = parse_url('../uploads/'.$v->file);
      }
      $v->file = $name;
    }
  }
  echo json_encode($data);
});
