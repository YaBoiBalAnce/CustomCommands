<?php
/**
 * Created by PhpStorm.
 * User: JeremyMorales
 * Date: 11/9/16
 * Time: 3:26 PM
 */

namespace CustomCmd;


use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;

class customCMD
{
    public $name;
    public $plugin;
    public $alias = [];
    public $description = "";
    public $perm = "";

    public function __construct($name, PluginBase $base){
        $this->name = $name;
        $this->plugin = $base;
    }

    public function execute(CommandSender $sender,array $args){

    }

    public function getName(){
        return $this->name;
    }

    public function setAlias(array $alias){
        $this->alias = $alias;
    }

    public function getAlias(){
        return $this->alias;
    }

    public function setDescription($desc){
        $this->description = $desc;
    }

    public function getDesc(){
        return $this->description;
    }

    public function setPermission($perm){
        $this->perm = $perm;
    }

    public function getPermission(){
        return $this->perm;
    }

    public function getPlugin(){
        return $this->plugin;
    }

}