<div class="span8">
<h2 class="page-title">ユーザー情報</h2>
<?php if ($user):?>
  <dl>
    
    <?php if ($uid == $user['User']['id']):?>
    <dt>Twitter ID（非公開）</dt>
    <dd><?php echo h($user['Twitter']['id'])?></dd>
    <?php endif;?>

    <dt>Twitter 表示名</dt>
    <dd><?php echo h($user['Twitter']['screen_name'])?></dd>

    <?php if ($uid == $user['User']['id']):?>
    <dt>メールアドレス（非公開）</dt>
    <dd><?php echo h($user['User']['mail'])?></dd>
    <?php endif;?>

    <dt>自己紹介</dt>
    <dd><?php echo nl2br(h($user['User']['desc']))?></dd>

    <dt>文理</dt>
    <dd><?php echo h(($user['User']['sciences'])?'理系':'文系')?></dd>

    <dt>ユーザー情報公開設定</dt>
    <dd><?php echo h(($user['User']['visibility'])?'公開':'非公開')?></dd>

  </dl>
<?php else:?>
  <dl>ユーザー情報は公開されていません。</dl>
<?php endif;?>

  <?php if ($uid == $user['User']['id']): ?>
  <?php echo $this->Html->link('編集','edit');?>
  <?php endif;?>
</div>
