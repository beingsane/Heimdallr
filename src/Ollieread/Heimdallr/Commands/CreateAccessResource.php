<?php namespace Ollieread\Heimdallr\Commands;

use Illuminate\Console\Command;
use Ollieread\Heimdallr\Models\Resource;
use Symfony\Component\Console\Input\InputArgument;

class CreateAccessResource extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'access:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new resource to Heimdallr.';

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

        if(Resource::where('ident', $ident)->count() == 0) {
            $resource = Resource::create([
                'name'          => $name,
                'ident'         => $ident,
                'description'   => $description,
                'route'         => $route
            ]);

            $this->info('Created new resource ' . $name . ' (' . $ident . ':' . $resource->id . ')');
        } else {
            $this->error('A resource with that ident currently exists, idents must be unique');
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
            array('name', InputArgument::REQUIRED, 'The name for the resource.'),
            array('ident', InputArgument::REQUIRED, 'The ident for the resource.'),
            array('route', InputArgument::REQUIRED, 'The route for the resource.'),
            array('description', InputArgument::OPTIONAL, 'The description for the resource.'),
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
