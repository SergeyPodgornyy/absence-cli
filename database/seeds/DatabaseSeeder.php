<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     * @throws \Throwable
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $this->call(UserTableSeeder::class);

            DB::commit();
        } catch (\Exception | \Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
}
