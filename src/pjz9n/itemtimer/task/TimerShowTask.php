<?php

/*
 * Copyright (c) 2021 PJZ9n.
 *
 * This file is part of ItemTimer.
 *
 * ItemTimer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ItemTimer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ItemTimer. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace pjz9n\itemtimer\task;

use pjz9n\itemtimer\config\Config;
use pjz9n\itemtimer\util\Utils;
use pocketmine\entity\object\ItemEntity;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\world\particle\FloatingTextParticle;

class TimerShowTask extends Task
{
    /** @var array */
    private array $particles = [];

    public function onRun(): void
    {
        $updated = [];//ItemEntity vector3 identifiers
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            foreach (Utils::getAroundEntities($player->getPosition(), Config::getDistance(), ItemEntity::class) as $entity) {
                /** @var ItemEntity $entity */
                if ($entity->getDespawnDelay() <= Config::getShowTick()) {
                    $particle = $this->particles[Utils::vector3Identifier($entity->getPosition())][1] ?? new FloatingTextParticle("");

                    $particle->setText(str_replace("{time}", (string)floor($entity->getDespawnDelay() / 20), Config::getText()));
                    $entity->getWorld()->addParticle($entity->getPosition()->add(0, 0.1, 0), $particle);

                    $this->particles[Utils::vector3Identifier($entity->getPosition())] = [$entity->getPosition(), $particle];
                    $updated[] = Utils::vector3Identifier($entity->getPosition());
                }
            }
        }

        //表示対象ではないものを削除します
        foreach ($this->particles as $identifier => $v) {
            [$position, $particle] = $v;
            if (!in_array($identifier, $updated, true)) {
                $particle->setInvisible(true);
                $position->getWorld()->addParticle($position, $particle);
                unset($this->particles[Utils::vector3Identifier($position)]);
            }
        }
    }
}
