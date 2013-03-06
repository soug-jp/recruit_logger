<div class="span8">
<h3>ユーザー情報編集</h3>
<?php echo $this->Form->create('User');?>
<dl>

  <dt>メールアドレス（非公開）</dt>
  <dd><?php echo $this->Form->input('User.mail',array('label'=>false));?></dd>

  <dt>文理選択</dt>
  <dd><?php echo $this->Form->input('User.sciences',array('label'=>false));?></dd>

  <dt>自己紹介</dt>
  <dd><?php echo $this->Form->input('User.desc',array('label'=>false));?></dd>

  <dt>ユーザー情報公開設定</dt>
  <dd><?php echo $this->Form->input('User.visibility',array('label' => false));?></dd>
</dl>
<?php 
echo $this->Form->input('User.twitter_id',array('type'=>'hidden'));
echo $this->Form->input('User.id',array('type' =>'hidden'));

echo $this->Form->end(__('Update'));?>
</div>
