<?php /** @var $employee Justimmo\Model\Employee */ ?>

<h1>Employee</h1>
<p>
    <?php echo $employee->getFirstName() . ' ' . $employee->getLastName(); ?>
</p>

<p>
    <a href="<?php echo url_for("@justimmo_employee_list"); ?>">Employee List</a>
</p>
