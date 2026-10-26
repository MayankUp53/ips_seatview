<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="panel panel-primary filterable fixMargin" style="border-color:#000080;">
	<div class="panel-heading" style="background-color:#000080;border-color:#000080;">
		<h3 class="panel-title">ユーザ一覧</h3>
	</div>
	<table class="table table-hover ">
		<tr style="vertical-align:middle;color:#808080;font-weight:bold;" bgcolor="#fff">
			<th width="18%">#</th>
			<th width="18%">ユーザID</th>
            <th width="18%">ユーザ名</th>
			<!--<th width="18%">CCID</th>
            <th width="18%">キャンペーンID</th>-->
            <th width="18%">操作</th>
		</tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $this->Number->format($user->id) ?></td>
            <td><?= h($user->user_id) ?></td>
            <td><?= h($user->user_name) ?></td>
            <!--<td><?= h($user->contact_center_id) ?></td>
            <td><?= h($user->campaign_id) ?></td>-->
            <td class="actions">
                <?= $this->Html->link(__('編集'), ['action' => 'edit', $user->id]) ?>
                <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user->id], ['confirm' => __('本当に削除してもよろしいですか # {0}?', $user->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
	</table>
    <div align="center">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('最初')) ?>
            <?= $this->Paginator->prev('< ' . __('前へ')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次へ') . ' >') ?>
            <?= $this->Paginator->last(__('最後') . ' >>') ?>
        </ul>
    </div>
	<div align="center">&nbsp;
        <?php 
        //echo $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ;
        echo $this->Paginator->counter('{{page}} / {{pages}} ページ, {{current}} 件目 / 全 {{count}} 件');
        ?>
    </div>

    <br>
    <div align="center">
        <!--<a href="<?= $this->Url->build(['controller'=>'settings', 'action'=>'index']); ?>">
            <input type="button" style="width:130px;cursor:pointer" class="btn btn-dark" value="Back">
        </a>-->
        <a href="<?= $this->Url->build(['controller'=>'users', 'action'=>'add']); ?>">
            <input name="add" type="button" style="width:150px;cursor:pointer" onclick="" class="btn btn-primary" value="新規登録">
        </a>
    </div>
    <br><br>
</div>
