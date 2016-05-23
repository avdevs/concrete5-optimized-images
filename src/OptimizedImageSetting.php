<?php
namespace Concrete\Package\OptimizedImages\Src;

use Concrete\Core\Foundation\Object,
    Core,
    Database,
    view;


/**
 * @Entity
 * @Table(name="OptimizedImagesSettings")
 */
class OptimizedImageSetting extends Object
{
    public static $table = 'OptimizedImagesSettings';

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $ID;

    /**
     * @Column(type="string")
     */
    protected $tinyPngApiKey;

    public function __construct($data = null)
    {
        if ($data) {
            $this->ID = $data['ID'];
            $this->tinyPngApiKey = $data['tinyPngApiKey'];
        }
    }

    public function getID()
    {
        return $this->ID;
    }

    public function setID($id)
    {
        return $this->ID  = $id;
    }

    public function getTinyPngApiKey()
    {
        return $this->tinyPngApiKey;
    }

    public function setTinyPngApiKey($tinyPngApiKey)
    {
        return $this->tinyPngApiKey  = $tinyPngApiKey;
    }

    public function load()
    {
        $db = \Database::connection();
        $rows = $db->GetRow("SELECT * FROM ".self::$table);
        return $rows;
    }

    public function save(){
        $db = Database::connection();
        return $db->execute("INSERT INTO `".self::$table."` (`ID`, `tinyPngApiKey`) VALUES (?, ?);", array($this->ID, $this->tinyPngApiKey));
    }

    public function update(){
        $db = Database::connection();
        return $db->execute("UPDATE `".self::$table."` SET `tinyPngApiKey` = ? WHERE `ID` = ? ", array($this->tinyPngApiKey, $this->ID));
    }

}