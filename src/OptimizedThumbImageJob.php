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


/**
 * @Entity
 * @Table(name="AvDevsOptimizedThumbImageJob")
 */
class OptimizedThumbImageJob extends Object
{
    public static $table = 'AvDevsOptimizedThumbImageJob';

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $avjID;

    /**
     * @Column(type="string")
     */
    protected $jobLastRunDate;

    public function load()
    {
        $db = \Database::connection();
        $rows = $db->GetOne("SELECT jobLastRunDate FROM `".self::$table."`");
        return $rows;
    }

    function tinyPngCompress($source, $tinyPngApiKey) {
        \Tinify\Tinify::setKey($tinyPngApiKey);
        $optimized = \Tinify\Tinify::fromFile($source);
        $optimized->toFile($source);
    }

    public function save($jobLastRunDate){
        $db = \Database::connection();
        return $db->execute("INSERT INTO `".self::$table."` ( `jobLastRunDate` ) VALUES ( ? );", array($jobLastRunDate));
    }

    public function update($jobLastRunDate){
        $db = \Database::connection();
        return $db->execute("UPDATE `".self::$table."` SET   `jobLastRunDate` = ? ;", array($jobLastRunDate));
    }
}