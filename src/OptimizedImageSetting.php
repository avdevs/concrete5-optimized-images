<?php
namespace Concrete\Package\OptimizedImages\Src;

use Concrete\Core\Foundation\Object,
    Core,
    Database,
    view;


class OptimizedImageSetting extends Object
{
    public static $table = 'atOptimizedImagesSettings';

    /**
     * @Id @Column(ID)
     * @GeneratedValue(strategy="AUTO")
     */
    protected $ID;

    /**
     * @Column(type="integer")
     */
    protected $optimizedImagesQuality;

    public function getID()
    {
        return $this->ID;
    }

    public function getOptimizedImagesQuality()
    {
        return $this->optimizedImagesQuality;
    }

    public function setID($id)
    {
        return $this->ID  = $id;
    }

    public function setOptimizedImagesQuality($optimizedImagesQuality)
    {
        $this->optimizedImagesQuality = $optimizedImagesQuality;
    }

    public function load()
    {
        $db = \Database::connection();
        $rows = $db->GetRow("SELECT * FROM ".self::$table);
        return $rows;
    }

    public function save(){
        $db = Database::connection();
        $result = $db->execute("INSERT INTO `".self::$table."` (`ID`, `optimizedImagesQuality`) VALUES (?, ?);", array($this->ID, $this->optimizedImagesQuality));
    }

    public function update(){
        $db = Database::connection();
        $result = $db->execute("UPDATE `".self::$table."` SET `optimizedImagesQuality` = ? WHERE `ID` = ? ", array($this->optimizedImagesQuality, $this->ID));
    }

}