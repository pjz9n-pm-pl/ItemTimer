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

namespace pjz9n\itemtimer\util;

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\world\Position;

final class Utils
{
    /**
     * $positionからの距離が$distance以内のエンティティを全て返す
     *
     * TODO もっと最適化できるかも
     */
    public static function getAroundEntities(Position $position, float $distance, string $entityType = Entity::class): array
    {
        $entities = [];

        foreach ($position->getWorld()->getEntities() as $entity) {
            if ($position->distance($entity->getPosition()) <= $distance) {
                if ($entity instanceof $entityType) {
                    $entities[] = $entity;
                }
            }
        }

        return $entities;
    }

    public static function vector3Identifier(Vector3 $vector3): string
    {
        return "{$vector3->getX()}:{$vector3->getY()}:{$vector3->getZ()}";
    }

    private function __construct()
    {
        //NOOP
    }
}
