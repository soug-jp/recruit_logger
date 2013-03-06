<div class="span8">
  <div class="page-header">
    <h2>企業情報登録</h2>
  </div>
  <?php echo $this->Form->create('Company');
  echo $this->Form->input('name');
  echo $this->Form->input('desc');
  echo $this->Form->input('state_id', array('options' => $state_id_list));
  echo $this->Form->input('memo');
  echo $this->Form->hidden('user_id', array('value' => $user_id));
  echo $this->Form->end('submit');
  ?>
</div>

