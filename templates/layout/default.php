<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

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
		<!--<link rel="stylesheet" type="text/css" href="<?= $this->Url->build("css");?>/south-street/jquery-ui-1.10.2.custom.min.css" />-->
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
        <style>
            table.seatView{
                margin:15px;
                width:160px;
                border-top:1px solid #ccc;
                border-left:1px solid #ccc;
                border-collapse:collapse;
                border-spacing:0;
                background-color:#ffffff;
                empty-cells:show;
            }
            .seatView th{
                border-right:1px solid #ccc;
                border-bottom:1px solid #ccc;
                color:#b0c4de;
                background-color:#f0f8ff;
                background-position:left top;
                padding:0.2em 0.5em;
                text-align:center;
            }
            .seatView td{
                border-right:1px solid #ccc;
                border-bottom:1px solid #ccc;
                padding:0.3em 1em;
                height: 90px;
                min-width: 105px;
            }
        </style>
    </head>

    <body>
        <header>
            <?= $this->Flash->render() ?>
            <?php
                    $seatview_active = null;
                    $list_active = null;
                    $user_active = null;

                    if($this->request->url == 'seats'){
                        $seatview_active = "active";	
                    }elseif($this->request->url == 'seats/list'){
                        $list_active = "active";
                    }elseif($this->request->url == 'users'){
                        $user_active = "active";
                    }
                ?>
            <div align="" class="container">
            <div class="bs-docs-section clearfix">
                <div class="row">
                <div class="col-lg-12">
                    <div class="bs-component">
                    <nav class="navbar navbar-inverse" style="background-color:#000080;">
                        <div class="container-fluid">
                        <div class="navbar-header" style="background-color:#000080;">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2" style="background-color:#000080;">
                            <ul class="nav navbar-nav">

                            <li class="<?php echo $seatview_active; ?>"><a href="<?= $this->Url->build(["controller" => "Seats","action" => "index"]);?>">シートビュー<span class="sr-only">(current)</span></a></li>
                            <li class="<?php echo $list_active; ?>"><a href="<?= $this->Url->build(["controller" => "Seats","action" => "list"]);?>">リストビュー<span class="sr-only">(current)</span></a></li>
                            <li class="<?php echo $user_active; ?>"><a href="<?= $this->Url->build(["controller" => "Users","action" => "index"]);?>">ユーザ管理<span class="sr-only">(current)</span></a></li>
                            <li><a href="<?= $this->Url->build(["controller" => "Users","action" => "logout"]);?>">ログアウト</a></li>

                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" TARGET="_blank"><?php //echo $this->Session->read('username'); ?></a></li>
                            </ul>
                        </div>
                        </div>
                    </nav>
                    </div>
                </div>
                </div>
            </div>
        </header>


        <div class="container clearfix">
            <?= $this->fetch('content') ?>
        </div>
        <footer>
            <div align="center">
            <p>Copyright © 2023 IPS All Rights Reserved.</p>
            </div>
        </footer>
    </body>
</html>
