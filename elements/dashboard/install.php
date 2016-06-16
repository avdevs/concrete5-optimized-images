<?php
defined('C5_EXECUTE') or die('Access Denied.');
?>
<div class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-2"><?= t('TinyPNG API KEY') ?></label>
        <div class="col-sm-10">
            <input type="text" name="tinyPngApiKey" value="<?= $tinyPngApiKey ? $tinyPngApiKey : ''; ?>">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2"><?= t('Allow Custom Thumbnail Image Optimization') ?></label>
        <div class="col-sm-10">
            <input type="checkbox" name="allowCustomThumbOptimize" value="1" <?= $allowCustomThumbOptimize ? 'checked' :''; ?>>
        </div>
    </div>
</div>


