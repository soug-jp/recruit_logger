<div class="span8">
  <div class="page-header">
    <h2>企業情報編集</h2>
  </div>
  <?php echo $this->Form->create('Company');?>
  <?php 
    echo $this->Form->hidden('id');
    echo $this->Form->input('name');
    echo $this->Form->input('state_id',array('options'=>$state_list));
    echo $this->Form->hidden('user_id');
    echo $this->Form->input('desc');
    echo $this->Form->input('memo');
    echo $this->Form->end(__('send'));
  ?>
</div>
