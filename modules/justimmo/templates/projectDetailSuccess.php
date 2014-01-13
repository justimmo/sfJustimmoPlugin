<?php /** @var $project Justimmo\Model\Project */ ?>

<div>
    <ul>
        <li>
            <?php echo link_to(__('Projekt Liste'), url_for("@justimmo_project_list"), array('class' => 'js-history-back')); ?>
        </li>
        <li>
            <a class="scroll-to" href="#lage"><?php echo __('Lage'); ?></a>
        </li>

        <?php if ($project->countRealties() > 0): ?>
            <li>
                <a class="scroll-to" href="#realties"><?php echo __('Objekte'); ?></a>
            </li>
        <?php endif; ?>
    </ul>
</div>


<h1><?php echo $project->getTitle(); ?></h1>
<p>
    <?php echo $project->getPlace(); ?>

    <?php // @todo: where/what is naehe ?>
    <?php //isset($project->immobilien->immobilie->naehe) && $project->immobilien->immobilie->naehe != '' and print ", " . $project->immobilien->immobilie->naehe; ?>
</p>

<?php
/*
$i = 1;
$gallery_images_count = count($project->bilder->bild);
?>

<div class="bg_object__gallery royalSlider rsDefaultInv fwImage <?php $gallery_images_count == 1 and print 'no-thumbs'; ?>">
    <?php foreach ($project->bilder->bild as $bild): ?>
        <a class="rsImg"
           data-toggle="modal"
           data-rsdelay="1000"
           data-rsbigimg="<?php echo $bild->pfad; ?>"
           href="<?php echo $bild->pfad; ?>">
            <img class="rsTmb"
                 src="<?php echo $bild->pfad; ?>"
                 alt="<?php echo $project->titel . " - Photo " . $i++; ?>"
                 height="72" width="96">
        </a>
    <?php endforeach; ?>
</div>
 */
?>

<?php if (strlen($project->getDescription()) > 0): ?>
    <h2><?php echo __('Projektbeschreibung'); ?></h2>

    <?php echo $project->getDescription(ESC_RAW); ?>
<?php endif; ?>

<?php if ($project->countRealties() > 0): ?>
    <h2 id="realties"><?php echo $project->countRealties() . ' ' . __('Verfügbare Objekte'); ?></h2>

    <?php include_partial('project_realties_table', array('realties' => $project->getRealties())); ?>
<?php endif; ?>
</div>

<div class="aside">
    <h2><?php echo __('Kontakt'); ?></h2>
    <?php // include_component('immobilien', 'teamMember', array('team_member_id' => $project->kontaktperson->personennummer)); ?>

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
    <?php if (false): ?>
        <hr>

        <h2 id="lage"><?php echo __('Lage'); ?></h2>
        <p><?php echo $project->strasse; ?> <?php echo $project->hausnummer; ?>, <?php echo $project->plz; ?> <?php echo $project->ort; ?></p>

        <div class="google-map-canvas">
            <div id="map_canvas"
                 data-title="<?php echo $project->titel; ?>"
                 data-address="<?php echo $project->strasse; ?> <?php echo $project->hausnummer; ?>, <?php echo $project->plz; ?> <?php echo $project->ort; ?>"></div>
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
