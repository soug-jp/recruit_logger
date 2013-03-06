<div class="hero-unit span8">
<h2 class="page-title">あなたの就活状況グラフ</h2>
<div class="container">

<script language="javascript" src="http://www.google.com/jsapi"></script>
<div id="chart"></div>
<script type="text/javascript">
      var queryString = '';
      var dataUrl = '';

      function onLoadCallback() {
        if (dataUrl.length > 0) {
          var query = new google.visualization.Query(dataUrl);
          query.setQuery(queryString);
          query.send(handleQueryResponse);
        } else {
          var dataTable = new google.visualization.DataTable();
          dataTable.addRows(7);

          dataTable.addColumn('number');
          dataTable.setValue(0, 0, <?php echo $st[0]?>);
          dataTable.setValue(1, 0, <?php echo $st[1]?>);
          dataTable.setValue(2, 0, <?php echo $st[2]?>);
          dataTable.setValue(3, 0, <?php echo $st[3]?>);
          dataTable.setValue(4, 0, <?php echo $st[4]?>);
          dataTable.setValue(5, 0, <?php echo $st[5]?>);
          dataTable.setValue(6, 0, <?php echo $st[6]?>);

          draw(dataTable);
        }
      }

      function draw(dataTable) {
        var vis = new google.visualization.ImageChart(document.getElementById('chart'));
        var options = {
          chxl: '1:<?php foreach(array_reverse($states,true) as $st):?><?php echo '|'.$st['state']?><?php endforeach;?>',
          chxp: '',
          chxr: '0,0,<?php echo $range?>|1,0,90',
          chxs: '',
          chxtc: '',
          chxt: 'x,y',
          chbh: 'a',
          chs: '800x300',
          cht: 'bhs',
          chco: '4D89F9',
          chds: '0,<?php echo $range?>',
          chdl: '',
          chma: '|10,5',
          chtt: 'あなたの就活状況',
        };
        vis.draw(dataTable, options);
      }

      function handleQueryResponse(response) {
        if (response.isError()) {
          alert('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
          return;
        }
        draw(response.getDataTable());
      }

      google.load("visualization", "1", {packages:["imagechart"]});
      google.setOnLoadCallback(onLoadCallback);

    </script>
    </div>
</div>

<div class="span8">
<h2 class="page-title">企業一覧</h2>
<?php echo $this->Html->link(__('new company'),'/Companies/add')?>
<table class="table table-striped">
  <tr>
    <th>ID</th>
    <th>企業名</th>
    <th>状況</th>
    <th>操作</th>
  </tr>
  <?php foreach ($companies as $company): ?>
  <tr>
    <td><?php echo $company['Company']['id']?></td>
    <td><?php echo $company['Company']['name']?></td>
    <td><?php echo $states[$company['Company']['state_id']]['state']?></td>
    <td><?php 
      echo $this->Html->link(__('view'),'/Companies/view/'.$company['Company']['id']);
      echo '&nbsp;';
      echo $this->Html->link(__('edit'),'/Companies/edit/'.$company['Company']['id']);
      echo '&nbsp;';
      echo $this->Html->link(__('delete'),'/Companies/delete/'.$company['Company']['id']);
    ?></td>
  </tr>
  <?php endforeach;?>
</table>
</div>
