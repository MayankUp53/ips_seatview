<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php //var_dump($data);?>

<script>
$(function(){
    /*$(function(){
        setInterval(function(){
            if ($('.inputFile')[0].files[0] == undefined){
                $('.preview').children('img').remove();
            }
        },1000);
    });*/

    //画像ファイルプレビュー表示
    /*$('.inputFile').on("change", function() {
        var file = this.files[0];

            reader = new FileReader(),
            $preview = $(".preview");
            t = this;

        // 画像ファイル以外の場合は何もしない
        if(file.type.indexOf("image") < 0){
            return false;
        }

        // ファイル読み込みが完了した際のイベント登録
        reader.onload = (function(file) {
        return function(e) {
            //既存のプレビューを削除
            $preview.empty();
            // .prevewの領域の中にロードした画像を表示するimageタグを追加
            $preview.append($('<img>').attr({
                    src: e.target.result,
                    width: "100px",
                    class: "preview",
                    title: file.name
                }));
        };
        })(file);
        reader.readAsDataURL(file);
    });*/
});
</script>
<!-- Test -->
<!--<div class="preview"/>-->

<?= $this->Form->create('User',['type'=>'file', 'url'=>'/users/edit/'.$id]); ?>
<div class="panel panel-primary filterable fixMargin" style="border-color:#ff8c00;">
    <div class="panel-heading" style="background-color:#ff8c00;border-color:#ff8c00;">
        <h3 class="panel-title">Edit User</h3>
    </div>

    <table class="table">
        <tbody>
            <tr>
                <td style="vertical-align:middle" width="15%">#</td>
                <td width="35%"><?= $this->Form->text("id", ["class"=>"form-control", "placeholder"=>"Auto", "readonly"=>"readonly", "value"=> $data['id']]); ?></td>
                <td width="15%"></td>
                <td width="35%"></td>
            </tr>
            <tr>
                <td style="vertical-align:middle">ユーザID</td>
                <td><?= $this->Form->text("user_id", ["class"=>"form-control", "size"=>20, "required"=>"true", "value"=>$data['user_id'] ]); ?></td>
                <td style="vertical-align:middle">ユーザ名</td>
                <td><?= $this->Form->text("user_name", ["class"=>"form-control", "size"=>20, "required"=>"true", "value"=>$data['user_name'] ]); ?></td>
            </tr>
            <!--<tr>
                <td>CCID</td>
                <td><?= $this->Form->text("contact_center_id", ["class"=>"form-control", "size"=>2, "required"=>"true", "value"=>$data['contact_center_id'] ]); ?></td>
                <td>キャンペーンID</td>
                <td><?= $this->Form->text("campaign_id", ["class"=>"form-control", "size"=>3, "value"=>$data['campaign_id'] ]); ?></td>
            </tr>-->
            <tr>
                <td style="vertical-align:middle">更新者</td>
                <td><?= $data['updated_user_id'] ?></td>
                <td style="vertical-align:middle">更新日時</td>
                <td><?= date('Y/m/d h:m', strtotime($data['updated']));?></td>
            </tr>
            <tr>
                <td style="vertical-align:middle">登録者</td>
                <td><?= $data['created_user_id'] ?></td>
                <td style="vertical-align:middle">登録日時</td>
                <td><?= date('Y/m/d h:m', strtotime($data['created']));?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <div align="center">
        <a href="<?= $this->Url->build(['controller'=>'users', 'action'=>'index']); ?>">
            <input type="button" style="width:130px;cursor:pointer" class="btn btn-dark" value="戻　る">
        </a>
        <button id="submit" style="width:130px;cursor:pointer" class="btn btn-warning" type="submit">更　新</button>
    </div>
<?= $this->Form->end();?>
<br>
</div>
