<?php
namespace CustomCmd\cmds;

use CustomCmd\customCMD;
use CustomCmd\main;
use pocketmine\command\CommandSender;

class helpCmd extends customCMD{
    public function __construct(main $base)
    {
        parent::__construct("help", $base);
    }

    public function execute(CommandSender $sender, array $args)
    {
        $this->getPlugin()->sendHelp();
    }
}