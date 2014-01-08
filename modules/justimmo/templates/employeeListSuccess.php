<?php /** @var $employee Justimmo\Model\Employee */ ?>

<section>
    <h1>Employee List</h1>
    <?php foreach ($employees as $employee): ?>
        <p>
            <a href="<?php echo url_for("@justimmo_employee_detail?id=" . $employee->getId()); ?>">
                <?php echo $employee->getFirstName() . ' ' . $employee->getLastName(); ?>
            </a>
        </p>
    <?php endforeach; ?>
</section>
