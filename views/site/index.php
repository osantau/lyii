<?php

/** @var yii\web\View $this */

$this->title = Yii::$app->name;
?>
<div class="site-index">

   <div class="jumbotron text-center bg-transparent">
      <h1 class="display-4"><?= $this->title ?></h1>
      <div class="alert alert-info" role="alert">
      <p>Pentru a utiliza aceasta aplicatie trebuie sa va autentificati !</p>
      <a href="/site/login" class="btn btn-lg btn-success">Autentificare</a>
</div>
   </div>
</div>