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

namespace pjz9n\itemtimer\config;

use pocketmine\utils\Config as PMConfig;
use pocketmine\utils\TextFormat;

class Config
{
    private static PMConfig $config;

    public static function init(string $filePath): void
    {
        self::$config = new PMConfig($filePath, default: [
            "distance" => 10,
            "show-tick" => 20 * 60 * 5,
            "text" => TextFormat::GRAY . "{time}",
        ]);
    }

    public static function save(): void
    {
        self::$config->save();
    }

    public static function getDistance(): int
    {
        return (int)self::$config->get("distance");
    }

    public static function getShowTick(): int
    {
        return (int)self::$config->get("show-tick");
    }

    public static function getText(): string
    {
        return (string)self::$config->get("text");
    }
}
