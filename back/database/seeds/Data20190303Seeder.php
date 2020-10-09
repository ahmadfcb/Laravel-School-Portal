<?php

use Illuminate\Database\Seeder;

class Data20190303Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admission template in sms template table
        if ( \App\SmsTemplate::where( 'template', '{std_name} {son_or_daughter} {father_name}, welcome to {institute_name}.' )->doesntExist() ) {
            $smsTemplate = \App\SmsTemplate::create( [
                'name' => 'Admission template',
                'template' => "{std_name} {son_or_daughter} {father_name}, welcome to {institute_name}."
            ] );

            \App\Option::firstOrCreate( ['name' => 'sms_on_admission'], ['value' => $smsTemplate->id] );
        }
    }
}
