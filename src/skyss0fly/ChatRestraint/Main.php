<?php
namespace skyss0fly\RestrainingOrder;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener {

    private bool $chatRestraintEnabled = true; // Default enabled

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onChat(PlayerChatEvent $event): void {
        if (!$this->chatRestraintEnabled) return;

        $player = $event->getPlayer();

        if ($player->getName() ===$this->getConfig()->get("Muted")) {
            $event->cancel(); // Block message if conditions match
            $player->sendMessage("You are restricted from chatting!");
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "chatrestraint") {
            if (!$sender->hasPermission("chatrestraint.use")) {
                $sender->sendMessage("You don't have permission to use this command.");
                return true;
            }

            $this->chatRestraintEnabled = !$this->chatRestraintEnabled;
            $status = $this->chatRestraintEnabled ? "enabled" : "disabled";
            $sender->sendMessage("Chat Restraint System is now $status. Anyone who is added to the list will not be allowed to talk.");
            return true;
        }
        return false;
    }
}
