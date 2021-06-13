<?php

namespace Quaterize\Soupregen;

use pocketmine\{Player, Server};

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\tile\Sign;
use pocketmine\item\Item;
use Rushil13579\SoupPvP\RegenMain;
use pocketmine\item\MushroomStew;

use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

	public $refillcd = [];

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$this->getResource("config.yml");

		$this->getServer()->getCommandMap()->register('soups', new SoupCommand($this));
	}

	public function refill($player){
		$soupItemData = $this->getConfig()->get('id');
		$array = explode(':', $soupItemData);
		$soupItem = Item::get((int)$array[0], (int)$array[1], 1);
		$i = 0;
		while($player->getInventory()->canAddItem($soupItem)){
			$player->getInventory()->addItem($soupItem);
			$i++;
		}
		if($i == 0){
			$player->sendTitle($this->getConfig()->get('inv-full'));
		} else {
			$player->sendMessage(str_replace('{count}', $i, $this->getConfig()->get('refilled-msg')));
		}
	}
	public function onInteract(PlayerInteractEvent $e){
    $p = $e->getPlayer();
    $s = $p->getInventory()->getItemInHand();
    if($s instanceof MushroomStew){
      $h = $p->getHealth();
      if($h < 20){
        $p->setHealth($p->getHealth()+5);
        $p->sendTip("§4❤§a+5");
        $p->getInventory()->setItemInHand(Item::get(0,0,1));
        $p->getInventory()->setItemInHand(Item::get(Item::BOWL,0,1));        
      } else {
        return;
      }
    } else {
      return;
    }
  }
}
