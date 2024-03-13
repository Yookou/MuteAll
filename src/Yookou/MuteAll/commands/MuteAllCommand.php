<?php

namespace Yookou\MuteAll\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\Server;
use Yookou\MuteAll\Main;
use Yookou\MuteAll\managers\MuteAllManager;

class MuteAllCommand extends Command {
	public function __construct(private Main $plugin) {
		parent::__construct("muteall", "MuteAll players", "/muteall");
		$this->setPermission(DefaultPermissions::ROOT_USER);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if (!$sender instanceof Player) {
			return;
		}

		$config = $this->plugin->getConfig();

		if (!($sender->hasPermission($config->get("permission")) || $sender->getServer()->isOp($sender->getName()))) {
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
}
