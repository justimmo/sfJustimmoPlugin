<?php /** @var $realty Justimmo\Model\Realty */ ?>

<h1>Realty</h1>
<p>
    <?php echo $realty->getTitle() . ' ' . $realty->getPropertyNumber(); ?>
</p>

<p>
    <a href="<?php echo url_for("@justimmo_realty_expose?id=".$realty->getId()); ?>">Expose</a>
</p>
