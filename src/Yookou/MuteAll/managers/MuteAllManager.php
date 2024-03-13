<?php

namespace Yookou\MuteAll\managers;

use pocketmine\utils\SingletonTrait;

class MuteAllManager {
	use SingletonTrait;
	public bool $mute = false;

	public function muteAll() : void {
		$this->mute = true;
	}

	public function unMuteAll() : void {
		$this->mute = false;
	}

	public function isMuted() : bool {
		return $this->mute;
	}
}
