<?php

use App\Exceptions\SeederException;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends JsonSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->fileManager->fromJson(database_path('data/users.json'));

        if ($count = count($users)) {
            $this->preExecutionCheck();

            $progress = $this->getProgressbar();
            $progress->start($count);

            DB::table('users')->insert(\array_map(function ($user) {
                return \array_only($user, ['full_name', 'birth_date', 'start_date', 'vacation_days']);
            }, $users));
            $progress->advance();

            $progress->finish();
            $this->command->getOutput()->writeln('');
        }
    }

    /**
     * @throws SeederException
     */
    protected function preExecutionCheck() : void
    {
        if (DB::table('users')->count()) {
            throw new SeederException('Articles already exists');
        }
    }
}
