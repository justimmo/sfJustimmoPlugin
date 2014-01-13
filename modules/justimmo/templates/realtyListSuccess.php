<?php /** @var Justimmo\Model\Realty $realty */ ?>
<?php /** @var baseRealtyFilter $filter_realty */ ?>

<section class="justimmo realty-list">

    <?php if ($pager->count()): ?>

        <h1><?php echo __('Realty List'); ?></h1>

        <?php
        $order = $sf_params->get('order', null);
        if (!$order) {
            $order = $sf_user->getAttribute('order') . '-' . $sf_user->getAttribute('ordertype');
        }
        ?>
        <section class="justimmo realty-sort">
            <h1><?php echo __('Sort by'); ?>:</h1>

            <a href="<?php echo url_for('@justimmo_realty_list'); ?>?order=<?php print $order == 'postcode-asc' ? 'postcode-desc' : 'postcode-asc'; ?>"
               class="<?php $order == 'postcode-asc' and print 'ascending'; ?>">
                <?php echo __('PLZ'); ?>
            </a>

            <a href="<?php echo url_for('@justimmo_realty_list'); ?>?order=<?php print $order == 'price-asc' ? 'price-desc' : 'price-asc'; ?>"
               class="<?php $order == 'price-asc' and print 'ascending'; ?>">
                <?php echo __('Preis'); ?>
            </a>

            <a href="<?php echo url_for('@justimmo_realty_list'); ?>?order=<?php print $order == 'area-asc' ? 'area-desc' : 'area-asc'; ?>"
               class="<?php $order == 'area-asc' and print 'ascending'; ?>">
                <?php echo __('Fläche'); ?>
            </a>
        </section>

        <?php foreach ($pager as $realty): ?>
            <?php
            $realty_classes = array(
                'justimmo',
                'realty',
                'realty-' . $realty->getId(),
            );
            if ($realty->getStatus() != '') {
                array_push(
                    $realty_classes,
                    'realty-' . preg_replace('/\W+/', '', strtolower(strip_tags($realty->getStatus())))
                );
            }
            ?>

            <a class="<?php echo implode(' ', $realty_classes); ?>"
               href="<?php echo url_for('@justimmo_realty_detail?id=' . $realty->getId()); ?>"
               title="<?php echo $realty->getTitle(); ?>">
                <div class="image">
                    <?php
                    $pictures = $realty->getPictures();
                    /** @var Justimmo\Model\Attachment $first_picture */
                    $first_picture = $pictures[0];
                    $picture_url = '';
                    if (isset($first_picture)) {
                        $picture_url = $first_picture->getUrl('orig');
                    }
                    ?>

                    <img alt="<?php echo $realty->getTitle(); ?>"
                         title="<?php echo $realty->getTitle(); ?>"
                         src="<?php echo $picture_url == '' ? '/images/noimage.jpg' : $picture_url; ?>"/>
                </div>

                <div class="description">
                    <h3 class="title">
                        <?php echo $realty->getTitle(); ?>
                    </h3>

                    <p><?php echo $realty->getDescription(); ?></p>
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
            <?php include_partial('filter_realty', array('form' => $filter_realty)); ?>
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
