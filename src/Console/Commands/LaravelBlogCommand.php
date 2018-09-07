<?php

namespace Xoborg\LaravelBlog\Console\Commands;

use Illuminate\Console\Command;
use Xoborg\LaravelBlog\Models\Author;

class LaravelBlogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-blog:author {userId?} {--A|add : Add userc from DB as author} {--R|remove : Remove user from DB as author} {--L|list : List of authors}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage laravel-blog authors';

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
    public function handle()
    {
		if ($this->hasOption('add') && $this->option('add')) {
			return $this->addUser();
		} else if ($this->hasOption('remove') && $this->option('remove')) {
			return $this->removeUser();
		} elseif ($this->hasOption('list') && $this->option('list')) {
			return $this->authorList();
		}

		$this->error('                                                 ');
		$this->error('  Write `php artisan laravel-blog:user --help`.  ');
		return $this->error('                                                 ');
    }

	/**
	 * Adds the user as Author
	 *
	 * @return mixed
	 */
	public function addUser()
	{
		try {
			$userId = $this->argument('userId');

			if ($userId == null) {
				$this->error('                                             ');
				$this->error('  Not enough arguments (missing: "userId").  ');
				return $this->error('                                             ');
			}

			if (Author::where('user_id', $userId)->exists()) {
				$this->error('                                 ');
				$this->error('  The user is already an author  ');
				return $this->error('                                 ');
			}

			if (app(config('auth.providers.users.model'))->find($userId) == null) {
				$this->error('                                      ');
				$this->error('  The user does not exists in the DB  ');
				return $this->error('                                      ');
			}

			Author::create([
				'user_id' => $userId
			]);

			return $this->info('User added');
		} catch (\Throwable $exception) {
			return $this->error($exception->getMessage());
		}
    }

	/**
	 * Remove the user as Author
	 *
	 * @return mixed
	 */
	public function removeUser()
	{
		try {
			$userId = $this->argument('userId');

			if ($userId == null) {
				$this->error('                                             ');
				$this->error('  Not enough arguments (missing: "userId").  ');
				return $this->error('                                             ');
			}

			$author = Author::find($userId);

			if (!$author) {
				$this->error('                             ');
				$this->error('  The user is not an author  ');
				return $this->error('                             ');
			}

			$author->delete();

			return $this->info('User removed');
		} catch (\Throwable $exception) {
			return $this->error($exception->getMessage());
		}
    }

	/**
	 * Remove the user as Author
	 *
	 * @return mixed
	 */
	public function authorList()
	{
		$headers = [
			'id', 'name', 'email'
		];

		$users = app(config('auth.providers.users.model'))->whereIn('id', Author::all(['user_id'])->toArray())
			->get(['id', 'name', 'email'])
			->toArray();

		return $this->table($headers, $users);
    }
}
