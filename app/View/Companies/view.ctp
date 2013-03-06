<?php
if (is_null($company['Company']['desc'])) 
  $company['Company']['desc'] = __('no_content');
if (is_null($company['Company']['memo']))
  $company['Company']['memo'] = __('no_content');
?>
<div class="span8">
  <div class="page-header">
    <h2>企業情報</h2>
    <div>
      <?php
        echo $this->Html->link(__('edit'),'/Companies/edit/'.$company['Company']['id']);
        echo '&nbsp;';
        echo $this->Html->link(__('delete'),'/Companies/delete/'.$company['Company']['id']);
      ?>
    </div>
  </div>
  <dl>
    <dt>ID</dt>
      <dd><?php echo h($company['Company']['id']);?></dd>
    <dt><?php echo __('co_name')?></dt>
      <dd><?php echo h($company['Company']['name']);?></dd>
    <dt><?php echo __('co_desc')?></dt>
      <dd><?php echo nl2br(h($company['Company']['desc']))?></dd>
    <dt><?php echo __('co_state')?></dt>
      <dd><?php echo h($company['State']['state']);?></dd>
    <dt><?php echo __('co_memo')?></dt>
      <dd><?php echo nl2br(h($company['Company']['memo']))?></dd>
  </dl>
</div>
