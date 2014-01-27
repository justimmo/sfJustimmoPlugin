<?php /** @var $project Justimmo\Model\Project */ ?>
<div class="top-bar">
    <p class="navigation">
        <a href="<?php echo url_for("@justimmo_project_list"); ?>"><?php echo __('Projekt Liste'); ?></a> /
        <?php if ($project->countRealties() > 0): ?>
            <a href="#realties"><?php echo __('Objekte'); ?></a> /
        <?php endif; ?>
        <a href="#location"><?php echo __('Lage'); ?></a> /
        <a href="#contact"><?php echo __('Kontakt'); ?></a>
    </p>
</div>


<h1><?php echo $project->getTitle(); ?></h1>
<p>
    <?php echo $project->getPlace(); ?>,
    <?php echo $project->getZipCode(); ?>
</p>

<div class="gallery">
    <?php
    $i = 1;
    /** @var \Justimmo\Model\Attachment $picture */
    ?>
    <?php foreach ($project->getPictures() as $picture): ?>
        <a href="<?php echo $picture->getUrl('orig'); ?>">
            <img alt="<?php echo $picture->getTitle() . " - Photo " . $i++; ?>"
                 src="<?php echo api_pic_url_replace($picture->getUrl('orig'), 'small'); ?>"/>
        </a>
    <?php endforeach; ?>
</div>

<?php if (strlen($project->getDescription()) > 0): ?>
    <h2><?php echo __('Projektbeschreibung'); ?></h2>

    <?php echo $project->getDescription(ESC_RAW); ?>
<?php endif; ?>

<?php if ($project->countRealties() > 0): ?>
    <h2 id="realties"><?php echo $project->countRealties() . ' ' . __('Verfügbare Objekte'); ?></h2>

    <?php include_partial('project_realties_table', array('realties' => $project->getRealties())); ?>
<?php endif; ?>

<aside>
    <h2 id="contact"><?php echo __('Kontakt'); ?></h2>
    <?php include_partial('employee', array('employee' => $project->getContact())); ?>

    <?php /*
    <?php if (count($project->videos->children()) > 0): ?>
        <hr>

        <h2><?php echo __('Video'); ?></h2>

        <?php sfContext::getInstance()->getResponse()->addJavascript('/bgMediaManagerPlugin/js/flowplayer/flowplayer-3.1.4.min.js', 'last'); ?>

        <?php $video_id = 1; ?>

        <?php foreach ($project->videos->video as $video): ?>
                    <a class="video"
                       data-toggle="modal"
                       data-target="#videoModal_<?php echo $video_id; ?>"
                       style="background-image: url(<?php echo $video->bild_gross; ?>);"
                       href="<?php echo $video->pfad; ?>">
                        <img src="/images/assets/play_icon.png" alt="Play video" class="play"/>
                    </a>

                    <div class="modal fade" id="videoModal_<?php echo $video_id++; ?>"
                         aria-labelledby="Video"
                         aria-hidden="true"
                         tabindex="-1"
                         role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2><?php echo $project->titel; ?></h2>
                                </div>
                                <div class="modal-body">

            ?>
            <div data-swf="//releases.flowplayer.org/5.4.3/flowplayer.swf"
                 style="background-image: url(<?php echo $video->bild_gross; ?>);"
                 class="video flowplayer minimalist no-volume no-mute"
                 data-ratio="0.562" data-embed="false">
                <video>
                    <source type="video/mp4" src="<?php echo $video->pfad; ?>"/>
                </video>
            </div>
            <?php
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-submit pull-left" data-dismiss="modal"><?php echo __('Schließen'); ?></button>
<!--                                    <button type="button" class="btn btn-submit pull-right" data-dismiss="modal">--><?php //echo __('Fullscreen'); ?><!--</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
            ?>
        <?php endforeach; ?>
    <?php endif; ?>


    <?php if ($project->dokumente->children()): ?>
        <hr>

        <h2><?php echo __('Downloads'); ?></h2>

        <?php foreach ($project->dokumente->dokument as $dokument): ?>
            <a href="<?php echo $dokument->pfad; ?>" target="_blank" class="block-link <?php $dokument->format == "pdf" and print 'pdf'; ?>">
                <?php echo $dokument->titel; ?> &raquo;
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
*/
    ?>

    <!--    --><?php //if ($project->strasse && $project->hausnummer && $project->plz && $project->ort): ?>
    <?php if ($project->getStreet()): ?>
        <h2 id="location"><?php echo __('Lage'); ?></h2>
        <p><?php echo $project->getStreet(); ?> <?php echo $project->getHouseNumber(); ?>, <?php echo $project->getZipCode(); ?> <?php echo $project->getPlace(); ?></p>

        <div class="google-map-canvas">
            <div id="map" class="google-map"
                 data-title="<?php echo $project->getTitle(); ?>"
                 data-address="<?php echo $project->getStreet(); ?> <?php echo $project->getHouseNumber(); ?>, <?php echo $project->getZipCode(); ?> <?php echo $project->getPlace(); ?>">
            </div>
        </div>
    <?php endif; ?>

    <?php /*
    <?php if ($project->bilder360->children()): ?>
        <?php // @todo: make sure 360 works ?>
        <h2><?php echo __('360° Ansicht'); ?></h2>

        <?php foreach ($project->bilder360->bild as $image360): ?>
            <p>
                <?php echo link_to(image_tag($image360->pfad, 'width=100%'), 'http://service.justimmo.at/java/view_360/landscape_generic.php?filename=' . $image360->pfad, 'class=fancy-iframe'); ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
*/
    ?>
</aside>
