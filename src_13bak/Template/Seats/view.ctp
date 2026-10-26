<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyStaff $companyStaff
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Company Staff'), ['action' => 'edit', $companyStaff->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Company Staff'), ['action' => 'delete', $companyStaff->id], ['confirm' => __('Are you sure you want to delete # {0}?', $companyStaff->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Company Staffs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company Staff'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="companyStaffs view large-9 medium-8 columns content">
    <h3><?= h($companyStaff->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Vessel') ?></th>
            <td><?= h($companyStaff->vessel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Msi') ?></th>
            <td><?= h($companyStaff->msi) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tsi') ?></th>
            <td><?= h($companyStaff->tsi) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ope') ?></th>
            <td><?= h($companyStaff->ope) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($companyStaff->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created User Id') ?></th>
            <td><?= $this->Number->format($companyStaff->created_user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated User Id') ?></th>
            <td><?= $this->Number->format($companyStaff->updated_user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted User Id') ?></th>
            <td><?= $this->Number->format($companyStaff->deleted_user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($companyStaff->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated') ?></th>
            <td><?= h($companyStaff->updated) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($companyStaff->deleted) ?></td>
        </tr>
    </table>
</div>
