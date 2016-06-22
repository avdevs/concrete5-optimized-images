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

    public function save($jobLastRunDate){
        $db = \Database::connection();
        return $db->execute("INSERT INTO `".self::$table."` ( `jobLastRunDate` ) VALUES ( ? );", array($jobLastRunDate));
    }

    public function update($jobLastRunDate){
        $db = \Database::connection();
        return $db->execute("UPDATE `".self::$table."` SET   `jobLastRunDate` = ? ;", array($jobLastRunDate));
    }
}