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

namespace pjz9n\itemtimer;

use pjz9n\itemtimer\config\Config;
use pjz9n\itemtimer\task\TimerShowTask;
use pocketmine\plugin\PluginBase;
use Webmozart\PathUtil\Path;

class Main extends PluginBase
{
    protected function onEnable(): void
    {
        Config::init(Path::join([$this->getDataFolder(), "config.yml"]));

        $this->getScheduler()->scheduleRepeatingTask(new TimerShowTask(), 20/*1sec*/);
    }

    protected function onDisable(): void
    {
        Config::save();
    }
}
