<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->Form->create('User',['type'=>'file', 'url'=>'/users/add']); ?>
<div class="panel panel-primary filterable fixMargin" style="border-color:#4169E1;">
    <div class="panel-heading" style="background-color:#4169E1;border-color:#4169E1;">
        <h3 class="panel-title">ユーザ新規登録</h3>
    </div>
    <table class="table">
        <tbody>
            <tr>
                <td style="vertical-align:middle" width="15%">#</td>
                <td width="35%"><?= $this->Form->text("id", ["class"=>"form-control", "placeholder"=>"Auto", "readonly"=>"readonly"]); ?></td>
                <td width="15%"></td>
                <td width="35%"></td>
            </tr>
            <tr>
                <td style="vertical-align:middle">ユーザID</td>
                <td><?= $this->Form->text("user_id", ["class"=>"form-control", "size"=>20, "required"=>"true"]); ?></td>
                <td style="vertical-align:middle">ユーザ名</td>
                <td><?= $this->Form->text("user_name", ["class"=>"form-control", "size"=>20, "required"=>"true"]); ?></td>
            </tr>
            <!--<tr>
                <td>CCID</td>
                <td><?= $this->Form->text("contact_center_id", ["class"=>"form-control", "size"=>2, "required"=>"true"]); ?></td>
                <td>キャンペーンID</td>
                <td><?= $this->Form->text("campaign_id", ["class"=>"form-control", "size"=>3]); ?></td>
            </tr>-->
        </tbody>
    </table>
</div>

<div align="center">
    <a href="<?= $this->Url->build(['controller'=>'users', 'action'=>'index']); ?>">
        <input type="button" style="width:130px;cursor:pointer" class="btn btn-dark" value="戻　る">
    </a>
    <button id="submit" style="width:130px;cursor:pointer" class="btn btn-info" type="submit">登　録</button>
</div>

<?= $this->Form->end();?>
<br><br>
