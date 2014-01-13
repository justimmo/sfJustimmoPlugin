<form action="<?php echo url_for("@justimmo_realty_filter"); ?>" method="post">
    <table>
        <?php
        echo $form;
        ?>
        <tr>
            <td>
                <input value="Search" type="submit"/>
            </td>
        </tr>
    </table>
</form>
