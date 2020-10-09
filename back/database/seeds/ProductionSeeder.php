<?php

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call( PrivilegesTableSeeder::class );

        $this->call( Data20190303Seeder::class );

        $this->call( OptionTableSeeder::class );

        $this->call( StudentsTableSeeder::class );
    }
}
