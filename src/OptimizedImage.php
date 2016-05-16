<?php
namespace Concrete\Package\OptimizedImages\Src;

use Concrete\Core\Foundation\Object,
    Core;


class OptimizedImage extends Object
{
    public static $table = 'AvDevsFilesToBeOptimized';

    public function load()
    {
        $db = \Database::connection();
        $rows = $db->GetAll("SELECT fv.* FROM fileVersions fv left join AvDevsFilesToBeOptimized avd on (fv.fID = avd.fID) WHERE avd.fID IS NULL AND fv.fvIsApproved = 1 AND fv.fvExtension IN ('jpg','gif','jpeg','png','bmp')");
        return $rows;
    }

    function compress($source, $destination, $quality) {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') {
            $image = @imagecreatefromjpeg($source);
            imagejpeg($image, $destination, $quality);
            imagedestroy($image);
        }elseif ($info['mime'] == 'image/gif') {
            $image = @imagecreatefromgif($source);
            imagegif($image, $destination, $quality);
            imagedestroy($image);
        }elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
            imagealphablending($image, false);
            imagesavealpha($image, true);
            imagepng($image,$destination, $quality);
            imagedestroy($image);
        }

        return $destination;
    }

    public function save($fID){
        $db = \Database::connection();
        $result = $db->execute("INSERT INTO `".self::$table."` ( `fID` ) VALUES ( ? );", array($fID));
    }
}