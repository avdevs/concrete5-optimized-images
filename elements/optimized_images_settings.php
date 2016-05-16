<?php
defined('C5_EXECUTE') or die('Access Denied.');

?>
<form  role="role" method="post" action="<?= $view->action('save') ?>">
<div class="form-horizontal">

    <div class="form-group">
        <label class="control-label col-sm-2"><?= t('Image Quality') ?></label>
        <input type="hidden" name="ID" value="<?= $optimizedImagesQuality ? $optimizedImagesQuality['ID'] : ''; ?>">
        <div class="col-sm-10">
            <input type="number" name="optimizedImagesQuality" value="<?= $optimizedImagesQuality ? $optimizedImagesQuality['optimizedImagesQuality'] : ''; ?>">
        </div>
    </div>
</div>
    <button class="pull-right btn btn-success" type="submit" > <?= t('Save') ?> </button>
</form>
