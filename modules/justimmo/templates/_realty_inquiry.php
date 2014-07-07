<?php // use_helper('sfCryptoCaptcha'); ?>

<div class="inquiry">
    <a name="contact-form"></a>

    <h3><?php echo __('Anfrage zum objekt'); ?></h3>

    <?php if ($sf_user->hasFlash('inquiry_status') && $sf_user->getFlash('inquiry_status') == true): ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Message sent!
        </div>
    <?php else: ?>
        <form method="post"
              action="<?php echo url_for("@justimmo_realty_detail?id=" . $realty_id); ?>#contact-form"
              class="inquiry-contact-form"
              role="form">

            <?php if ($sf_user->hasFlash('inquiry_status') && $sf_user->getFlash('inquiry_status') == false): ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Message not sent!
                </div>
            <?php endif; ?>

            <?php echo $form->renderHiddenFields(); ?>

            <div class="<?php print $form['first_name']->hasError() ? 'has-error' : ''; ?>">
                <?php echo $form['first_name']->renderLabel(__('Vorname') . ' *', array('class' => 'sr-only')); ?>
                <?php echo $form['first_name']->render(array(
                    'class'       => 'form-control',
                    'placeholder' => __('Vorname') . ' *',
                )); ?>
                <?php echo $form['first_name']->renderError(); ?>
            </div>

            <div class="<?php print $form['last_name']->hasError() ? 'has-error' : ''; ?>">
                <?php echo $form['last_name']->renderLabel(__('Nachname') . ' *', array('class' => 'sr-only')); ?>
                <?php echo $form['last_name']->render(array(
                    'class'       => 'form-control',
                    'placeholder' => __('Nachname') . ' *',
                )); ?>
                <?php echo $form['last_name']->renderError(); ?>
            </div>


            <div class="<?php print $form['phone']->hasError() ? 'has-error' : ''; ?>">
                <?php echo $form['phone']->renderLabel(__('Telefon') . ' *', array('class' => 'sr-only')); ?>
                <?php echo $form['phone']->render(array(
                    'class'       => 'form-control',
                    'placeholder' => __('Telefon') . ' *',
                )); ?>
                <?php echo $form['phone']->renderError(); ?>
            </div>

            <div class="<?php print $form['email']->hasError() ? 'has-error' : ''; ?>">
                <?php echo $form['email']->renderLabel(__('E-Mail') . ' *', array('class' => 'sr-only')); ?>
                <?php echo $form['email']->render(array(
                    'class'       => 'form-control',
                    'placeholder' => __('E-Mail') . ' *',
                )); ?>
                <?php echo $form['email']->renderError(); ?>
            </div>

            <div class="<?php print $form['message']->hasError() ? 'has-error' : ''; ?>">
                <?php echo $form['message']->renderLabel(__('Anfrage') . ' *', array('class' => 'sr-only')); ?>
                <?php echo $form['message']->render(array(
                    'class'       => 'form-control',
                    'placeholder' => __('Anfrage') . ' *',
                )); ?>
                <?php echo $form['message']->renderError(); ?>

                <p>
                    <small>
                        <?php echo __('* Pflichtfelder'); ?>
                    </small>
                </p>

                <input type="submit" value="<?php echo __('Absenden'); ?> &raquo;"/>
            </div>

            <?php /*
            <?php echo $form['captcha']->renderLabel(__('Sicherheitsüberprüfung')); ?>
            <div class="bg_objectContactFormCaptchaImage">
                <?php echo captcha_image(); ?>
            </div>

            <div class="<?php print $form['captcha']->hasError() ? 'has-error' : ''; ?>">
                <div class="captcha-reload-btn">
                    <?php echo captcha_reload_button(); ?>
                    <small>
                        <?php echo __('Geben Sie die Zeichen aus <br />dem angezeigten Bild ein.'); ?>
                    </small>
                </div>

                <?php echo $form['captcha']->render(array(
                    'placeholder' => 'Sicherheitscode *',
                    'class'       => 'form-control',
                )); ?>
                <?php echo $form['captcha']->renderError(); ?>
            </div>
            */
            ?>
        </form>
    <?php endif; ?>
</div>
