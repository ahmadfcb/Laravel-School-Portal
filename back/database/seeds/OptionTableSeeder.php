<?php

use App\Option;
use App\PerformanceScale;
use App\PerformanceType;
use Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::firstOrCreate( ['name' => 'send_automatic_sms'], ['value' => '0'] );

        // add id of the absent attendance type to the option table only if it isn't already added in the table
        // means it has null value
        if ( Option::find( 'absent_attendance_type_id' ) === null ) {
            // find absent attendance type
            $absentAttendanceType = \App\StudentAttendanceType::where( \DB::raw( "lower(`name`)" ), 'like', '%absent%' )->first();
            if ( $absentAttendanceType !== null ) {
                Option::create( [
                    'name' => 'absent_attendance_type_id',
                    'value' => $absentAttendanceType->id
                ] );
            }
        }

        // adding default student performance scale record to the options table
        Option::firstOrCreate(['name' => 'default_performance_scale_id'], ['value' => PerformanceScale::first(['id'])->id]);
    }
}
