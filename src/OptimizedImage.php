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
 * @Table(name="AvDevsFilesToBeOptimized")
 */
class OptimizedImage extends Object
{
    public static $table = 'AvDevsFilesToBeOptimized';

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $avID;

    /**
     * @Column(type="integer")
     */
    protected $fID;

    public function load()
    {
        $db = \Database::connection();
        $rows = $db->GetAll("SELECT fv.* FROM FileVersions fv left join AvDevsFilesToBeOptimized avd on (fv.fID = avd.fID) WHERE avd.fID IS NULL AND fv.fvIsApproved = 1");
        return $rows;
    }

    public function getLastRecord()
    {
        $db = \Database::connection();
        $rows = $db->GetOne("SELECT fv.fID FROM FileVersions fv left join AvDevsFilesToBeOptimized avd on (fv.fID = avd.fID) WHERE avd.fID IS NULL AND fv.fvIsApproved = 1 ORDER BY fv.fID DESC LIMIT 1");
        return $rows;
    }

    function tinyPngCompress($source, $tinyPngApiKey) {
        try {
            \Tinify\Tinify::setKey($tinyPngApiKey);
            \Tinify\validate();
        } catch(\Tinify\Exception $e) {
            return $e->getMessage(); // Validation of API key
        }

        try {
            $optimized = \Tinify\Tinify::fromFile($source);
            $optimized->toFile($source);
            return false;
        } catch(\Tinify\AccountException $e) {
            return $e->getMessage(); // Verify API key and account limit.
        } catch(\Tinify\ClientException $e) {
            return $e->getMessage(); // Check source image and request options.
        } catch(\Tinify\ServerException $e) {
            return $e->getMessage(); // Temporary issue with the Tinify API.
        } catch(\Tinify\ConnectionException $e) {
            return $e->getMessage(); // A network connection error occurred.
        } catch(Exception $e) {
            return $e->getMessage(); // Something else went wrong, unrelated to the Tinify API.
        }
    }

    public function save($fID){
        $db = \Database::connection();
        return $db->execute("INSERT INTO `".self::$table."` ( `fID` ) VALUES ( ? );", array($fID));
    }

}