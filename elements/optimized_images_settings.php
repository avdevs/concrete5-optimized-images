<?php
defined('C5_EXECUTE') or die('Access Denied.');

?>
<form  role="role" method="post" action="<?= $view->action('save') ?>">
    <input type="hidden" name="ID" value="<?= $optimizedImageSetting ? $optimizedImageSetting['ID'] : ''; ?>">
    <div class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2"><?= t('TinyPNG API KEY') ?></label>
            <div class="col-sm-10">
                <input type="text" name="tinyPngApiKey" value="<?= $optimizedImageSetting ? $optimizedImageSetting['tinyPngApiKey'] : ''; ?>">
            </div>
        </div>
    </div>
    <button class="pull-right btn btn-success" type="submit" > <?= t('Save') ?> </button>
</form>
