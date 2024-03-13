<?php

namespace Yookou\MuteAll\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use Yookou\MuteAll\Main;
use Yookou\MuteAll\managers\MuteAllManager;

class MuteAllListener implements Listener {
	public function __construct(private Main $plugin) {
	}

	public function onPlayerChat(PlayerChatEvent $event) {
		$sender = $event->getPlayer();

		if ($sender->hasPermission($this->plugin->getConfig()->get("permission")) || $sender->getServer()->isOp($sender->getName())) {
			return;
		}

		if (!MuteAllManager::getInstance()->isMuted()) {
			return;
		}

		$sender->sendMessage($this->plugin->getConfig()->get("mute-message"));
		$event->cancel();
	}
}
