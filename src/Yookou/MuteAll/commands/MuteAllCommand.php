<?php

namespace Yookou\MuteAll\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\Server;
use Yookou\MuteAll\Main;
use Yookou\MuteAll\managers\MuteAllManager;

class MuteAllCommand extends Command implements PluginOwned {
	public function __construct() {
		parent::__construct("muteall", "MuteAll players", "/muteall");
		$this->setPermission("muteall.cmd");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args): void {
		if (!$sender instanceof Player) {
			return;
		}

		$config = $this->getOwningPlugin()->getConfig();

		if (!($sender->hasPermission("muteall.cmd") || $sender->getServer()->isOp($sender->getName()))) {
			return;
		}

		$server = Server::getInstance();
		$manager = MuteAllManager::getInstance();

		if ($manager->isMuted()) {
			$manager->unMuteAll();
			$server->broadcastMessage(str_replace(
				"{player}",
				$sender->getName(),
				$config->getNested("command.unmuteall.broadcast")
			));

			return;
		}

		$manager->muteAll();
		$server->broadcastMessage(str_replace(
			"{player}",
			$sender->getName(),
			$config->getNested("command.muteall.broadcast")
		));
	}

    public function getOwningPlugin(): Main {
        return Main::getInstance();
    }
}
