<?php
$cakeDescription = 'AmeyoJ Seat Viewer';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" >
        
        <?= $this->Html->charset() ?>

        <title><?= $this->fetch('title') ?></title>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>

		<!-- CSS -->
		<?= $this->Html->css('bootstrap'); ?>
		<?= $this->Html->css('bootstrap.min'); ?>
		<?= $this->Html->css('style'); ?>
		<?= $this->Html->css('bootstrap-datepicker.css'); ?>
		<?= $this->Html->css('jquery.timepicker.css'); ?>
		<?= $this->Html->css('jquery.datetimepicker.min'); ?>
		
		<!-- JS -->
		<?= $this->Html->script('jquery'); ?>
		<?= $this->Html->script('jquery-ui'); ?>
		<?= $this->Html->script('jquery.ui.datepicker-ja'); ?>
		<?= $this->Html->script('jquery.timepicker'); ?>
		<?= $this->Html->script('jquery.datetimepicker.full'); ?>
		<?= $this->Html->script('jquery.datetimepicker.full.min'); ?>
		<?= $this->Html->script('jquery.datetimepicker.min'); ?>
    </head>
	<body>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">シートビュー編集</h3>
            </div>
            <?php echo $this->Form->create('Seat',array('type'=>'post','url'=>'/Seats/edit/'.$location));?>
            <table class="table">
                <tbody>
                    <tr height="35">
                        <td width="30%" style="vertical-align:middle;color:#ffffff;" bgcolor="#4169E1">座席位置</td>
                        <td style="vertical-align:middle">&nbsp;&nbsp;&nbsp;&nbsp;<?= $location ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                    <tr height="35">
                        <td width="30%" style="vertical-align:middle;color:#ffffff;" bgcolor="crimson">内線番号</td>
                        <td><?= $this->Form->text("extension", ["class"=>"form-control", "size"=>10, "value"=>$data->extension]); ?></td>
                    </tr>
                    <tr height="35">
                        <td width="30%" style="vertical-align:middle;color:#ffffff;" bgcolor="crimson">ユーザ</td>
                        <td><?= $this->Form->select("user_id",$userNameOpt,["class"=> "form-control","empty"=>"選択してください", "value"=>$data->user_id]); ?></td>
                    </tr>
                </tbody>
            </table>
            <div style="width:95%;margin-bottom:5px;margin-top:5px;" align="center" class="btn_margin">
                <button style="width:150px;height:30px;cursor:pointer" onclick="edit();" class="btn-info btn-xs" >更　新</button>
            </div>
            <br><br>
            <?php echo $this->Form->end(); ?>
        </div>

        <?php 
            $session = $this->request->session();
            if ($session->read('edit_submit')=='yes'){?>
                <script>
                    $(document).ready(function() {
                        //親画面をリロード
                        window.opener.location.reload();
                        //画面（子画面）を閉じる
                        window.close();
                    });
                </script>
            <?php } ?>
            <script>
                function edit(){
                    $(form).submit();
                };
            </script>
	</body>
</html>