<?php namespace Ollieread\Heimdallr\Commands;

use Illuminate\Console\Command;
use Ollieread\Heimdallr\Models\Permission;
use Symfony\Component\Console\Input\InputArgument;

class CreateAccessPermission extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'access:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new permission to Heimdallr.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $name = $this->argument('name');
        $ident = $this->argument('ident');
        $description = $this->argument('description');
        $route = $this->argument('route');

        if(Permission::where('ident', $ident)->count() == 0) {
            $permission = Permission::create([
                'name'          => $name,
                'ident'         => $ident,
                'description'   => $description,
                'route'         => $route
            ]);

            $this->info('Created new permission ' . $name . ' (' . $ident . ':' . $permission->id . ')');
        } else {
            $this->error('A permission with that ident currently exists, idents must be unique');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('name', InputArgument::REQUIRED, 'The name for the permission.'),
            array('ident', InputArgument::REQUIRED, 'The ident for the permission.'),
            array('route', InputArgument::REQUIRED, 'The route for the permission.'),
            array('description', InputArgument::OPTIONAL, 'The description for the permission.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
