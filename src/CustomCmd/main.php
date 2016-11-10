<?php

namespace CustomCmd;


use CustomCmd\cmds\helpCmd;
use CustomCmd\customCMD;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as C;

class main extends PluginBase implements Listener
{
    const unknown_cmd_msg = C::RED."Unknown command do .help to see available commands";
    const no_permission_msg = C::RED."You don't have necessary permission to use this command!";
    const no_commands_message = C::RED."There are no commands registered";
    const help_title = C::GOLD.">> Commands Available:";

    public $cmds = [];

    public function onEnable()
    {
        $this->getLogger()->alert("Enabled CustomCommand Plugin by BalAnce");
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->registerCustomCmd(new helpCmd($this));
    }

    public function onChat(PlayerChatEvent $ev){
        if ($ev->isCancelled()) return;
        $msg = $ev->getMessage();
        $msg = explode(" ",$msg);
        if (substr($msg[0], 0, 1) === "."){
            $sender = $ev->getPlayer();
            $name = str_replace("."," ",$msg[0]);
            $ev->setCanceled();
            if (!isset($this->cmds[$name])){
                $sender->sendMessage(self::unknown_cmd_msg);
                return;
            }
            $cmd = $this->cmds[$name];
            if ($cmd instanceof customCMD){
                if ($sender->hasPermission($cmd->getPermission()) or $cmd->getPermission() === ""){
                    $cmd->execute($sender, array_shift($msg));
                    return;
                }
                $sender->sendMessage(self::no_permission_msg);
            }
        }
    }

    public function registerCustomCmd(customCMD $class){
        $this->cmds[$class->getName()] = $class;
        if (!is_array($class->getAlias())) return;
        foreach ($class->getAlias() as $alias){
            $this->cmds[$alias] = $class;
        }
    }


    public function sendHelp(Player $p){
        $p->sendMessage(self::help_title);
        $done = [];
        if (count($this->cmds) < 1){
            $p->sendMessage(self::no_commands_message);
            return;
        }
        foreach ($this->cmds as $cmd => $class){
            if ($class instanceof customCMD){
                if (!isset($done[$class->getName()]) and $class->getName() !== "help"){
                    $done[$class->getName()] = 0;
                    if ($p->hasPermission($class->getPermission()) or $class->getPermission() === "") {
                        $p->sendMessage(".{$class->getName()} - {$class->getDesc()}");
                    }
                }
            }
        }
    }



}
