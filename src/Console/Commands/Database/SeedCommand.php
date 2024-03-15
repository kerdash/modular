<?php

namespace HassanKerdash\Modular\Console\Commands\Database;

use Illuminate\Support\Str;
use HassanKerdash\Modular\Console\Commands\Modularize;

class SeedCommand extends \Illuminate\Database\Console\Seeds\SeedCommand
{
	use Modularize;

	protected function getSeeder()
	{
		if ($module = $this->module()) {
			$default = $this->getDefinition()->getOption('class')->getDefault();
			$class = $this->input->getOption('class');

			if ($class === $default) {
				$class = $module->qualify($default);
			} elseif (! Str::contains($class, 'src\\database\\seeders')) {
				$class = $module->qualify("src\\database\\Seeders\\{$class}");
			}

			return $this->laravel->make($class)
				->setContainer($this->laravel)
				->setCommand($this);
		}

		return parent::getSeeder();
	}
}
