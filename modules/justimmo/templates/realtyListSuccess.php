<?php /** @var $realty Justimmo\Model\Realty */ ?>

<?php foreach ($realties as $realty): ?>
    <p>
        <a href="<?php echo url_for("@justimmo_realty_detail?id=" . $realty->getId()); ?>">
            <?php echo $realty->getTitle() . ' ' . $realty->getPropertyNumber(); ?>
        </a>
    </p>
<?php endforeach;
