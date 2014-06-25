<form action="<?php echo url_for("@justimmo_realty_filter"); ?>" method="post" class="justimmo realty-filter-form">
    <table>
        <?php
        echo $form;
        ?>
        <tr>
            <td>
                <input value="Search" type="submit"/>

                <p>
                    <?php echo link_to(__('Suche löschen'), "@justimmo_realty_filter_reset"); ?>
                </p>
            </td>
        </tr>
    </table>
</form>
