<?php

namespace SaxUi\Iconsax;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

class AddCommand extends Command implements PromptsForMissingInput
{
    private const ICON_TYPES = [
        'linear',
        'bold',
        'outline',
        'twotone',
        'bulk',
        'broken',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icon:add {name : The name of the icon} {--type=linear : The type of the icon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an icon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $type = $this->option('type');


        $iconPath = resource_path("views/components/icons/{$type}/{$name}.blade.php");
        $iconStubPath = __DIR__ . "/../stubs/{$type}/{$name}.blade.php";

        $directories = [
            resource_path('views/components'),
            resource_path('views/components/icons'),
            resource_path("views/components/icons/{$type}")
        ];


        $filesystem = new Filesystem;

        if (!in_array($type, self::ICON_TYPES)) {
            $this->error("{$type} is not a valid icon type.");
            return;
        }

        if ($filesystem->exists($iconPath)) {
            $this->error("{$name} already exists.");
            return;
        }

        if (!$filesystem->exists($iconStubPath)) {
            $this->error("{$name} does not exist in {$type} type.");
            return;
        }

        foreach ($directories as $directory) {
            $filesystem->ensureDirectoryExists($directory);
        }

        $filesystem->copy($iconStubPath, $iconPath);

        $this->components->info("Icon {$name} installed successfully.");
    }



    /**
     * Retrieves the icons based on a given value.
     *
     * @param string $value The value used to filter the icons.
     * @return array The filtered icons.
     */
    public function getIcons(string $value)
    {
        $icons = collect();

        $iconFiles = Finder::create()
            ->in(__DIR__ . "/../stubs/{$this->option('type')}")
            ->files();

        foreach ($iconFiles as $file) {
            $icons->push($file->getBasename('.blade.php'));
        }

        $filteredIcons = $icons
            ->filter(fn (string $icon) => stripos($icon, $value) !== false)
            ->values()
            ->toArray();

        return $filteredIcons;
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => fn () => search(
                label: 'What is the name of the icon?',
                options: fn ($value) => strlen($value) > 0 ? $this->getIcons($value) : [],
            ),
        ];
    }

    /**
     * Perform actions after the user was prompted for missing arguments.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        $input->setOption('type', select(
            label: 'Select the type of the icon',
            options: self::ICON_TYPES,
            scroll: 6
        ));
    }
}
