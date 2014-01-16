<?php /** @var $employee Justimmo\Model\Employee */ ?>

<section>
    <h1>Employee List</h1>

    <?php foreach ($categories as $category => $employees_in_category): ?>
        <h2><?php echo $category; ?></h2>

        <?php foreach ($employees_in_category as $employee): ?>
            <?php include_partial('employee', array('employee' => $employee)); ?>
        <?php endforeach; ?>

    <?php endforeach; ?>

</section>
