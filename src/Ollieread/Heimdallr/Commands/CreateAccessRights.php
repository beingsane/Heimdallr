<?php namespace Ollieread\Heimdallr\Commands;

use Illuminate\Console\Command;
use Ollieread\Heimdallr\Models\Permission;
use Ollieread\Heimdallr\Models\Resource;
use Ollieread\Heimdallr\Models\Role;
use Symfony\Component\Console\Input\InputArgument;

class CreateAccessRights extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'access:rights';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'The rights for a role.';

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
		$role = $this->argument('role');
        $resource = $this->argument('resource');
        $permissions = $this->argument('permissions');

        $role = Role::where('ident', $role)->first();

        if($role) {
            $resource = Resource::where('ident', $resource)->first();

            if($resource) {
                foreach ($permissions as $permission) {
                    $permission = Permission::where('ident', $permission)->first();

                    if ($permission && !$role->can($resource->ident, $permission)) {
                        $role->rights()->create([
                            'resource_id'       => $resource->id,
                            'permission_id'     => $permission->id
                        ]);

                        $this->info('Added ' . $resource->ident . '.' . $permission->ident . ' to ' . $role->ident . '.');
                    } else {
                        $this->error('Role ' . $role->ident . ' already has ' . $resource->ident . '.' . $permission->ident . '.');
                    }
                }
            } else {
                $this->error('No resource with the ident ' . $this->argument('resource') . ' exists.');
            }
        } else {
            $this->error('No role with the ident ' . $this->argument('role') . ' exists.');
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
			array('role', InputArgument::REQUIRED, 'The role to add the rights for.'),
            array('resource', InputArgument::REQUIRED, 'The resource to add the rights for.'),
            array('permissions', InputArgument::IS_ARRAY, 'The permissions to add.'),
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
