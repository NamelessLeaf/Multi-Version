<?php

declare(strict_types=1);

namespace NamelessLeaf\Multi-Version;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

/**
 * Made by Namelessleaf
 * Credit to multiprotocol 
 */
class Main extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    /**
     * @param DataPacketReceiveEvent $event
     */
    public function onLogin(DataPacketReceiveEvent $event) {
        $pk = $event->getPacket();
        if (!$pk instanceof LoginPacket) {
            return;
        }
        $player = $event->getPlayer();
        $currentProtocol = ProtocolInfo::CURRENT_PROTOCOL;
        if ($pk->protocol < $currentProtocol) {
            $player->kick(TextFormat::RED . 'Your Minecraft Version Isnt Compatible With This Server' . $currentProtocol);
        } elseif ($pk->protocol > $currentProtocol) {
            $pk->protocol = $currentProtocol;
            $this->getLogger()->alert(TextFormat::GOLD . $player->getName() . "'s protocol version changed to " . $currentProtocol);
        }
    }

}
