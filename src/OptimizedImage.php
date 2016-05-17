<?php
namespace Concrete\Package\OptimizedImages\Src;

use Concrete\Core\Foundation\Object,
    Core;


require_once(DIR_PACKAGES."/optimized_images/vendor/tinypng/lib/Tinify/Exception.php");
require_once(DIR_PACKAGES."/optimized_images/vendor/tinypng/lib/Tinify/ResultMeta.php");
require_once(DIR_PACKAGES."/optimized_images/vendor/tinypng/lib/Tinify/Result.php");
require_once(DIR_PACKAGES."/optimized_images/vendor/tinypng/lib/Tinify/Source.php");
require_once(DIR_PACKAGES."/optimized_images/vendor/tinypng/lib/Tinify/Client.php");
require_once(DIR_PACKAGES."/optimized_images/vendor/tinypng/lib/Tinify.php");


class OptimizedImage extends Object
{
    public static $table = 'AvDevsFilesToBeOptimized';

    public function load()
    {
        $db = \Database::connection();
        $rows = $db->GetAll("SELECT fv.* FROM fileVersions fv left join AvDevsFilesToBeOptimized avd on (fv.fID = avd.fID) WHERE avd.fID IS NULL AND fv.fvIsApproved = 1 AND fv.fvExtension IN ('jpg','gif','jpeg','png','bmp')");
        return $rows;
    }

    function tinyPngCompress($source, $tinyPngApiKey) {
        \Tinify\Tinify::setKey($tinyPngApiKey);
        $optimized = \Tinify\Tinify::fromFile($source);
        $optimized->toFile($source);
    }

    public function save($fID){
        $db = \Database::connection();
        return $db->execute("INSERT INTO `".self::$table."` ( `fID` ) VALUES ( ? );", array($fID));
    }

    public function on_file_add(){
        echo "dsdsadsad dsa ads"; die;
    }
}