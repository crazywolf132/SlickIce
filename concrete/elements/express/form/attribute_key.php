<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div class="form-group">
    <label class="control-label"><?=$label?>
        <?php

        if ($control->isRequired()) {
            print $renderer->getRequiredHtmlElement();
        }
        ?>
    </label>

    <?=$key->render('composer', $value)?>
</div>
