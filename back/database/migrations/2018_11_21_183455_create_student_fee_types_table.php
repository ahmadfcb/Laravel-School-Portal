<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentFeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'student_fee_types', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'name', 191 );
            $table->integer( 'fee' )->nullable();
            $table->boolean( 'editable' )->default( 1 );
        } );

        $monthly_fee = \App\StudentFeeType::create( [
            'name' => 'Monthly Fee',
            'editable' => 0,
            'fee' => null
        ] );

        $fee_fine = \App\StudentFeeType::create( [
            'name' => 'Fee Fine',
            'editable' => 0,
            'fee' => null
        ] );

        \App\Option::insert([
            [
                'name' => 'student_fee_type_monthly_fee_id',
                'value' => $monthly_fee->id
            ],
            [
                'name' => 'student_fee_type_fee_fine_id',
                'value' => $fee_fine->id
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'student_fee_types' );
        \App\Option::where('name', 'student_fee_type_monthly_fee_id')->orWhere('name', 'student_fee_type_fee_fine_id')->delete();
    }
}
