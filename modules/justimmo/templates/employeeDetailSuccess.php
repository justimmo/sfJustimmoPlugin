<?php /** @var $employee Justimmo\Model\Employee */ ?>

<?php include_partial('employee', array('employee' => $employee)); ?>

<p>
    <a href="<?php echo url_for("@justimmo_employee_list"); ?>">Employee List</a>
</p>
