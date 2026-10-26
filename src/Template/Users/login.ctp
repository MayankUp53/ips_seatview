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
		<link rel="stylesheet" type="text/css" href="<?= $this->Url->build("css");?>/south-street/jquery-ui-1.10.2.custom.min.css" />
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

		<br />
		<br />
		<br />
		<br />
		<br />
		<div style="width:100%;" align="center" class="login">

			<img src="<?= $this->Url->build("/img");?>/logo.png" />
			<br />
			<br />
			<div class="panel panel-info" style="width:50%;">
				<div class="panel-heading">
					<h3 class="panel-title">AmeyoJ Seat Viewer ログイン</h3>
				</div>
				<?php echo $this->Form->create('User');?>
				<table class="table">
					<tbody>
						<tr>
							<td width="25%" style="vertical-align:middle;color:#ffffff;" bgcolor="#20b2aa">ユーザＩＤ</td>
							<td width="25%"><?php echo $this->Form->input('loginid', ['label'=>false, 'div'=>false, 'type' => 'text', 'class'=>'form-control']); ?></td>
							<td width="25%" style="vertical-align:middle;color:#ffffff;" bgcolor="#20b2aa">パスワード</td>
							<td width="25%"><?php echo $this->Form->input('password', ['label'=>false, 'div'=>false, 'type' => 'password', 'class'=>'form-control']); ?></td>
						</tr>
					</tbody>
				</table>
				<?= $this->Flash->render() ?>
				<div style="width:95%;margin-bottom:5px;margin-top:5px;" align="center" class="btn_margin">
					<?php echo $this->Form->submit('ログイン', ['div'=>false, 'name' => 'login', 'type'=>'submit', 'style'=>'width:150px;height:30px;cursor:pointer']); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			</div>


		</div>
			<br />
			<br />
			<br />
			<br />
			<br />
    </body>
</html>

