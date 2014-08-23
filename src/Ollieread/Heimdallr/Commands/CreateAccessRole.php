<?php namespace Ollieread\Heimdallr\Commands;

use Illuminate\Console\Command;
use Ollieread\Heimdallr\Models\Role;
use Symfony\Component\Console\Input\InputArgument;

class CreateAccessRole extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'access:role';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add a new role to Heimdallr.';

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
        $level = $this->argument('level');

        if(Role::where('ident', $ident)->count() == 0) {
            $role = Role::create([
                'name'          => $name,
                'ident'         => $ident,
                'description'   => $description,
                'level'         => $level
            ]);

            $this->info('Created new role ' . $name . ' (' . $ident . ':' . $role->id . ')');
        } else {
            $this->error('A role with that ident currently exists, idents must be unique');
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
			array('name', InputArgument::REQUIRED, 'The name for the role.'),
            array('ident', InputArgument::REQUIRED, 'The ident for the role.'),
            array('level', InputArgument::OPTIONAL, 'The level for the role.'),
            array('description', InputArgument::OPTIONAL, 'The description for the role.'),
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
