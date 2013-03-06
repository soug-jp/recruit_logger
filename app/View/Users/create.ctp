<div class="span6">
<h3>Your Twitter ID: <?php echo $twitter_id?>, Your Twitter Screen Name: <?php echo $twname?></h3>
<?php
echo $this->Form->create('User');

echo $this->Form->input('User.mail',array('label'=>__('Mail Address')));
echo $this->Form->input('User.desc',array('label'=>__('Description')));
echo $this->Form->input('User.sciences');
echo $this->Form->input('User.visibility');
echo $this->Form->hidden('User.twitter_id', array('value'=>$twitter_id));
echo $this->Form->end(__('Register'));
?>
</div>
