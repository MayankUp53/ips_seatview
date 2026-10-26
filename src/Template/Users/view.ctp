<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Disp Cd') ?></th>
            <td><?= h($user->disp_cd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Name') ?></th>
            <td><?= h($user->user_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Loginid') ?></th>
            <td><?= h($user->loginid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remark1') ?></th>
            <td><?= h($user->remark1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remark2') ?></th>
            <td><?= h($user->remark2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remark3') ?></th>
            <td><?= h($user->remark3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth') ?></th>
            <td><?= $this->Number->format($user->auth) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created User Id') ?></th>
            <td><?= $this->Number->format($user->created_user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated User Id') ?></th>
            <td><?= $this->Number->format($user->updated_user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted User Id') ?></th>
            <td><?= $this->Number->format($user->deleted_user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated') ?></th>
            <td><?= h($user->updated) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($user->deleted) ?></td>
        </tr>
    </table>
</div>
