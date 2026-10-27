<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompanyStaff $companyStaff
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Company Staffs'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="companyStaffs form large-9 medium-8 columns content">
    <?= $this->Form->create($companyStaff) ?>
    <fieldset>
        <legend><?= __('Add Company Staff') ?></legend>
        <?php
            echo $this->Form->control('vessel');
            echo $this->Form->control('msi');
            echo $this->Form->control('tsi');
            echo $this->Form->control('ope');
            echo $this->Form->control('created_user_id');
            echo $this->Form->control('updated_user_id');
            echo $this->Form->control('deleted', ['empty' => true]);
            echo $this->Form->control('deleted_user_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
