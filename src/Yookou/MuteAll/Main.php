<?php

namespace Yookou\MuteAll;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Yookou\MuteAll\commands\MuteAllCommand;
use Yookou\MuteAll\listeners\MuteAllListener;

class Main extends PluginBase {
	use SingletonTrait;

	protected function onLoad() : void {
		self::setInstance($this);
		$this->saveDefaultConfig();
	}

	protected function onEnable() : void {
		$server = $this->getServer();

		$server->getPluginManager()->registerEvents(new MuteAllListener($this), $this);
		$server->getCommandMap()->register("MuteAll", new MuteAllCommand());
	}
}
