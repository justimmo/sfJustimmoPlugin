<?php /** @var Justimmo\Model\Realty $realty */ ?>
<?php /** @var baseRealtyFilter $realty_filter */ ?>

<section class="justimmo realty-list">

    <?php if ($pager->count()): ?>

        <h1><?php echo __('Realty List'); ?> (<?php echo $pager->getNbResults(); ?>)</h1>

        <?php
        $order = $sf_params->get('order', null);
        if (!$order) {
            $order = $sf_user->getAttribute('order') . '-' . $sf_user->getAttribute('ordertype');
        }
        ?>
        <section class="justimmo realty-sort">
            <h1><?php echo __('Sort by'); ?>:</h1>

            <a href="<?php echo url_for('@justimmo_realty_list'); ?>/page/<?php echo $pager->getPage(); ?>?order=<?php print $order == 'ZipCode-asc' ? 'ZipCode-desc' : 'ZipCode-asc'; ?>"
               class="<?php $order == 'ZipCode-asc' and print 'ascending'; $order == 'ZipCode-desc' and print 'descending'; ?>">
                <?php echo __('PLZ'); ?>
            </a>

            <a href="<?php echo url_for('@justimmo_realty_list'); ?>/page/<?php echo $pager->getPage(); ?>?order=<?php print $order == 'Price-asc' ? 'Price-desc' : 'Price-asc'; ?>"
               class="<?php $order == 'Price-asc' and print 'ascending'; $order == 'Price-desc' and print 'descending'; ?>">
                <?php echo __('Preis'); ?>
            </a>

            <a href="<?php echo url_for('@justimmo_realty_list'); ?>/page/<?php echo $pager->getPage(); ?>?order=<?php print $order == 'LivingArea-asc' ? 'LivingArea-desc' : 'LivingArea-asc'; ?>"
               class="<?php $order == 'LivingArea-asc' and print 'ascending'; $order == 'LivingArea-desc' and print 'descending'; ?>">
                <?php echo __('Fläche'); ?>
            </a>
        </section>

        <?php foreach ($pager as $realty): ?>
            <a class="<?php echo realty_css_classes($realty); ?>"
               href="<?php echo url_for('@justimmo_realty_detail?id=' . $realty->getId()); ?>"
               title="<?php echo $realty->getTitle(); ?>">
                <div class="image">
                    <img alt="<?php echo $realty->getTitle(); ?>"
                         title="<?php echo $realty->getTitle(); ?>"
                         src="<?php echo realty_picture_url($realty->getPictures(), 0, 'orig'); ?>"/>

                    <span><small>
                        Sorting properties: <?php echo $realty->getZipCode(); ?> - <?php echo $realty->getPurchasePrice(); ?> - <?php echo $realty->getLivingArea(); ?>
                    </small></span>
                </div>

                <div class="description">
                    <h3 class="title">
                        <?php echo $realty->getTitle(); ?>
                    </h3>

                    <p><?php echo mb_substr(text($realty->getDescription()), 0, 200); ?></p>
                </div>

                <div class="details">
                    <?php if ($realty->getRoomCount() > 0): ?>
                        <p>
                            <em><?php echo __('Zimmer'); ?></em>
                            <br>
                            <strong><?php echo $realty->getRoomCount(); ?></strong>
                        </p>
                    <?php endif; ?>

                    <?php if ($realty->getPurchasePrice() > 0): ?>
                        <p>
                            <em><?php echo __('Kauf'); ?></em>
                            <br>
                            <strong><?php echo number_format($realty->getPurchasePrice(), 0, ',', '.'); ?> &euro;</strong>
                        </p>
                    <?php endif; ?>

                    <?php if ($realty->getTotalRent() > 0): ?>
                        <p>
                            <em><?php echo __('Miete'); ?></em>
                            <br>
                            <strong><?php echo number_format($realty->getTotalRent(), 0, ',', '.'); ?> &euro;</strong>
                        </p>
                    <?php endif; ?>

                    <?php if ($realty->getTotalArea() > 0): ?>
                        <p>
                            <em><?php echo __('Fläche'); ?></em>
                            <br>
                            <strong><?php echo number_format($realty->getTotalArea(), 2, ',', '.'); ?> m²</strong>
                        </p>
                    <?php endif; ?>

                    <p>
                        <em><?php echo __('Ort'); ?></em>
                        <br>
                        <strong><?php echo $realty->getPlace(); ?></strong>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>

        <?php // @todo: send sorting information? or is it stored in the session? ?>
        <?php include_partial('pagination', array('pager' => $pager, 'route' => '@justimmo_realty_list')); ?>

        <aside>
            <?php include_partial('realty_filter', array('form' => $realty_filter)); ?>
        </aside>
    <?php else: ?>
        <div class="justimmo realty-no-results">
            <h1><?php echo __('Keine Ergebnisse'); ?></h1>

            <div class="alert">
                <p><?php echo __('Wir konnten leider keine passenden Objekte zu Ihren Suchkriterien finden.'); ?></p>

                <p><strong><?php echo __('Vorschläge'); ?></strong></p>

                <ul>
                    <li><?php echo __('Probieren Sie andere Suchkriterien.'); ?></li>
                    <li><?php echo __('Probieren Sie allgemeinere Suchkriterien.'); ?></li>
                </ul>
            </div>

            <p>
                <?php echo link_to(__('Suche löschen'), "@justimmo_realty_filter_reset"); ?>
            </p>
        </div>
    <?php endif; ?>
</section>
