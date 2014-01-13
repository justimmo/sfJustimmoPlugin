<?php /** @var $realty Justimmo\Model\Realty */ ?>

<h1>Realty</h1>
<p>
    <?php echo $realty->getTitle() . ' ' . $realty->getPropertyNumber(); ?>
</p>


<article class="justimmo realty">

    <?php if (!isset($realty)): ?>
        <div class="justimmo realty-no-result">
            <h1><?php echo __('Fehler!'); ?></h1>

            <div class="alert">
                <?php echo __('Keine Ergebnisse'); ?>
                <p><?php echo __('Wir konnten leider keine passenden Objekte zu Ihren Suchkriterien finden.'); ?></p>
                <?php echo __('Vorschläge'); ?>
                <ul>
                    <li><?php echo __('Probieren Sie andere Suchkriterien.'); ?></li>
                    <li><?php echo __('Probieren Sie allgemeinere Suchkriterien.'); ?></li>
                </ul>
            </div>

            <p>
                <a href="<?php echo url_for('@justimmo_realty_list'); ?>">
                    <span class="glyphicon glyphicon-chevron-left"></span> <?php echo __('Ergebnisliste'); ?>
                </a>
            </p>
        </div>
    <?php else: ?>

        <?php $lat = $realty->getLatitude(); ?>
        <?php $lng = $realty->getLongitude(); ?>

        <div class="top-bar">
            <p class="navigation">
                <a href="<?php echo url_for("@justimmo_realty_detail?id=" . $realty->getId()); ?>"><?php echo __('Vorheriges Objekt'); ?></a> /
                <a href="<?php echo url_for('@justimmo_realty_list'); ?>"><?php echo __('zurück zur Übersicht'); ?></a> /
                <a href="<?php echo url_for("@justimmo_realty_detail?id=" . $realty->getId()); ?>"><?php echo __('Nächstes Objekt'); ?></a> /
                <a class="object-expose" href="<?php echo url_for('@justimmo_realty_expose?id=' . $realty->getId()); ?>">Expos&eacute;</a>
            </p>
        </div>

        <h1><?php echo $realty->getTitle(); ?></h1>
        <p>
            <?php echo $realty->getZipCode(); ?>
            <?php echo $realty->getPlace(); ?>
        </p>
        <?php if ($realty->getStatus() != '') : ?>
            <p class="status"><?php echo __($realty->getStatus()); ?></p>
        <?php endif; ?>

        <div class="information">
            <div class="description">
                <div class="gallery royalSlider rsMinW fwImage">
                    <?php
                    $i = 1;
                    /** @var \Justimmo\Model\Attachment $picture */
                    ?>
                    <?php foreach ($realty->getPictures() as $picture): ?>
                        <a class="rsImg"
                           data-rsdelay="1000"
                           data-rsbigimg="<?php echo $picture->getUrl('big2'); ?>"
                           href="<?php echo $picture->getUrl('big2'); ?>">
                            <img
                                alt="<?php echo $realty->getTitle() . " - Photo " . $i++; ?>"
                                class="rsTmb"
                                src="<?php echo $picture->getUrl('medium2'); ?>"
                                width="96"
                                height="72"/>
                        </a>
                    <?php endforeach; ?>
                </div>

                <h2><?php echo __('Immobilienbeschreibung'); ?></h2>

                <?php echo $realty->getDescription(ESC_RAW); ?>

                <?php if (count($realty->getDocuments())): ?>
                    <h2><?php echo __('Dokumente'); ?></h2>

                    <p>
                        <?php /** @var \Justimmo\Model\Attachment $document */ ?>
                        <?php foreach ($realty->getDocuments() as $document): ?>
                            <?php if (strtolower($document->getType()) == "pdf"): ?>
                                <?php echo link_to(substr((string)$document->getTitle(), 0, -4), $document->getUrl()); ?>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>

                <?php if ($lat && $lng): ?>
                    <h2><?php echo __('Karte'); ?></h2>

                    <div class="google-map-canvas"> <?php // @todo: add data-attributes here for the map ?>
                        <div id="#map"></div>
                    </div>
                <?php endif; ?>

                <?php /* if (count($realty->videos->children()) > 0): ?>
                    <?php // @todo: make sure this works! ?>
                    <h2><?php echo __('Videos'); ?></h2>
                    <?php sfContext::getInstance()->getResponse()->addJavascript('/bgMediaManagerPlugin/js/flowplayer/flowplayer-3.1.4.min.js', 'last'); ?>

                    <?php foreach ($realty->videos->video as $video): ?>
                        <a href="#" onclick="jQuery.fancybox('<a href=\'<?php echo $video->pfad; ?>\' style=\'display:block;width:500px;height:400px;padding-bottom:10px;\' id=\'<?php echo $video->id; ?>\'></a>');flowplayer('<?php echo $video->id; ?>','/bgMediaManagerPlugin/js/flowplayer/flowplayer-3.1.5.swf', { clip: {autoBuffering: true, scaling: 'fit'} }); return false;">
                            <img src="/images/video_placeholder.jpg" alt="Video" style="display:block; margin:auto; padding-bottom:10px;"/>
                        </a>
                    <?php endforeach; ?>
                <?php endif; */
                ?>

                <?php if (count($realty->getAttachmentsByType('bilder360'))): ?>
                    <?php // @todo: make sure this works! ?>
                    <h2 name="360"><?php echo __('360° Ansicht'); ?></h2>

                    <?php foreach ($realty->getAttachmentsByType('bilder360') as $image360): ?>
                        <p>
                            <?php echo link_to(image_tag($image360, 'width=100%'), 'http://service.justimmo.at/java/view_360/landscape_generic.php?filename=' . $image360, 'class=fancy-iframe'); ?>
                        </p>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php /* //@todo: leave this out and show it in the gallery???

                     if ($grundrisse->count() > 0) : ?>
                    <?php // @todo: make sure this works! ?>
                    <h2 name="grundriss" class="floorplan-title"><?php echo __('Grundrisse'); ?></h2>

                    <div class="bg_lightbox-row">
                        <?php foreach ($grundrisse as $anhang): ?>
                            <div class="bg_lightbox-image">
                                <a href="<?php echo url_for_api_asset($anhang->daten->big2, 'expose'); ?>" rel="gallery" class="fancy">
                                    <img src="<?php echo url_for_api_asset($anhang->daten->medium2, 's220x155'); ?>" alt="" border="0" class="thumbs"/>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; */
                ?>
            </div>

            <?php include_partial('realty_details', array('realty' => $realty)); ?>
        </div>

        <?php // include_component('immobilien', 'anfrage', array('immobilie' => $realty, 'onr' => $onr, 'id' => $id)); ?>
    <?php endif; ?>
</article>
