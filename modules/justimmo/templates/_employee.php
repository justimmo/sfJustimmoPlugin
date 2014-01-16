<?php /** @var $employee Justimmo\Model\Employee */ ?>
<?php //@todo: format as vcard - http://rachaelmoore.name/posts/design/html/html5-microdata-team-member/ ?>

<?php if ($employee): ?>
    <?php
    if (!isset($mailto)) {
        $mailto = "mailto:" .
            $employee->getFirstName() . "%20" .
            $employee->getLastName() . "%20" .
            "%3c" . $employee->getEmail() . "%3e";
    }
    ?>

    <div>
        <div>
            <?php
            $employee_pictures = $employee->getPictures();
            $employee_picture = isset($employee_pictures[0]) ? $employee_pictures[0] : null;
            ?>
            <?php if ($employee_picture): ?>
                <img src="<?php echo $employee_picture->getUrl(); ?>"
                     alt="<?php echo $employee->getFirstName() . ' ' . $employee->getLastName(); ?>"/>
            <?php else: ?>
                <img src="/images/assets/employee-no-image.jpg"
                     alt="Placeholder no image"/>
            <?php endif; ?>
        </div>

        <div>
            <p>
                <a href="<?php echo url_for("@justimmo_employee_detail?id=" . $employee->getId()); ?>">
                <?php echo $employee->getTitle() ?><br>
                <?php echo $employee->getFirstName() . ' ' . $employee->getLastName(); ?>
                <?php if ($employee->getPosition()): ?>
                    <br>
                    <span><?php echo $employee->getPosition(); ?></span>
                <?php endif; ?>
                </a>
            </p>

            <p class="tel">
                <?php if ($employee->getPhone()): ?>
                    <span>T</span> <?php echo $employee->getPhone(); ?><br>
                <?php endif; ?>

                <?php if ($employee->getMobile()): ?>
                    <span>M</span> <?php echo $employee->getMobile(); ?><br>
                <?php endif; ?>

                <?php if ($employee->getFax()): ?>
                    <span>F</span> <?php echo $employee->getFax(); ?><br>
                <?php endif; ?>
            </p>

            <?php if ($employee->getEmail()): ?>
                <p class="email">
                    <a href="<?php echo $mailto; ?>">
                        <?php echo __('E-Mail senden &raquo;'); ?>
                    </a>
                </p>
            <?php endif; ?>

            <p>
                <a href="<?php echo url_for("@justimmo_realty_list"); ?>?filter[owner_id]=<?php echo $employee->getId(); ?>">
                    <?php echo __('Objekte anzeigen'); ?> &raquo;
                </a>
            </p>
        </div>
    </div>
<?php endif; ?>
