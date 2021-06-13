<?php

namespace Quaterize\Soupregen;

use pocketmine\{
    Server,
    Player
};

use pocketmine\command\{
    Command,
    CommandSender
};

use Quaterize\Soupregen\Main;

class SoupCommand extends Command {

    /** @var Main */
    private $main;

    public function __construct(Main $main){
        $this->main = $main;

        parent::__construct('soups', 'ADD SOUP ALL INVENTORY');
        $this->setPermission('souppvp.soups');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player){
            $sender->sendMessage($this->main->getConfig()->get('console'));
            return false;
        }

        if(!$this->testPermission($sender)){
            $sender->sendMessage($this->main->getConfig()->get('no-permission'));
            return false;
        }

        $this->main->refill($sender);
    }
}