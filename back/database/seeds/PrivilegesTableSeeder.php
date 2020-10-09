<?php

use Illuminate\Database\Seeder;

class PrivilegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Privilege::firstOrCreate( ['name' => 'promote_demote_student'], ['title' => 'Promote Demote Student'] );

        \App\Privilege::firstOrCreate( ['name' => 'sms_template_view'], ['title' => 'View SMS Templates'] );
        \App\Privilege::firstOrCreate( ['name' => 'sms_template_delete'], ['title' => 'Delete SMS Templates'] );
        \App\Privilege::firstOrCreate( ['name' => 'sms_template_edit'], ['title' => 'Edit SMS Templates'] );
        \App\Privilege::firstOrCreate( ['name' => 'sms_template_add'], ['title' => 'Add SMS Templates'] );

        \App\Privilege::firstOrCreate( ['name' => 'send_manual_sms'], ['title' => 'Send Manual SMS'] );

        \App\Privilege::firstOrCreate( ['name' => 'update_assigned_student_class_fee'], ['title' => "Update Assigned Student's class fee"] );

        \App\Privilege::firstOrCreate( ['name' => 'view_defaulters_list'], ['title' => "View Defaulter's list"] );

        \App\Privilege::firstOrCreate( ['name' => 'generate_students_fee'], ['title' => "Generate Students' Fee"] );

        \App\Privilege::firstOrCreate( ['name' => 'student_performance_edit'], ['title' => "Student Performance Edit"] );
    }
}
