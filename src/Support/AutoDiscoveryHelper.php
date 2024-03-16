<?php

namespace HassanKerdash\Modular\Support;

use Illuminate\Filesystem\Filesystem;

class AutoDiscoveryHelper
{
	protected string $base_path;

	public function __construct(
		protected ModuleRegistry $module_registry,
		protected Filesystem $filesystem
	) {
		$this->base_path = $module_registry->getModulesPath();
	}

	public function commandFileFinder(): FinderCollection
	{
		return FinderCollection::forFiles()
			->name('*.php')
			->inOrEmpty($this->base_path.'/*/src/app/Console/Commands');
	}

	public function factoryDirectoryFinder(): FinderCollection
	{
		return FinderCollection::forDirectories()
			->depth(0)
			->name('factories')
			->inOrEmpty($this->base_path.'/*/src/database/');
	}

	public function migrationDirectoryFinder(): FinderCollection
	{
		return FinderCollection::forDirectories()
			->depth(0)
			->name('migrations')
			->inOrEmpty($this->base_path.'/*/src/database/');
	}

	public function modelFileFinder(): FinderCollection
	{
		return FinderCollection::forFiles()
			->name('*.php')
			->inOrEmpty($this->base_path.'/*/src/app/Models');
	}

	public function bladeComponentFileFinder(): FinderCollection
	{
		return FinderCollection::forFiles()
			->name('*.php')
			->inOrEmpty($this->base_path.'/*/src/View/Components');
	}

	public function bladeComponentDirectoryFinder(): FinderCollection
	{
		return FinderCollection::forDirectories()
			->name('Components')
			->inOrEmpty($this->base_path.'/*/src/View');
	}

	public function routeFileFinder(): FinderCollection
	{
		return FinderCollection::forFiles()
			->depth(0)
			->name('*.php')
			->sortByName()
			->inOrEmpty($this->base_path.'/*/src/routes');
	}

	public function viewDirectoryFinder(): FinderCollection
	{
		return FinderCollection::forDirectories()
			->depth(0)
			->name('views')
			->inOrEmpty($this->base_path.'/*/src/resources/');
	}

	public function langDirectoryFinder(): FinderCollection
	{
		return FinderCollection::forDirectories()
			->depth(0)
			->name('lang')
			->inOrEmpty($this->base_path.'/*/src/resources/');
	}

	public function listenerDirectoryFinder(): FinderCollection
	{
		return FinderCollection::forDirectories()
			->name('Listeners')
			->inOrEmpty($this->base_path.'/*/src');
	}

	public function livewireComponentFileFinder(): FinderCollection
	{
		$directory = $this->base_path.'/*/src';

		if (str_contains(config('livewire.class_namespace'), '\\Http\\'))
			$directory .= '/Http';

		$directory .= '/Livewire';

		return FinderCollection::forFiles()
			->name('*.php')
			->inOrEmpty($directory);
	}

    public function configDirectoryFinder(): FinderCollection
	{
		return FinderCollection::forFiles()
			->name('*.php')
			->inOrEmpty($this->base_path.'/*/src/config/');
	}
}
