<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $table = "sms_templates";

    /*
     * Methods
     */

    /**
     * Replaces place holders withh their values. Should be loaded: fatherRecord, branch, currentClass, section
     * @param integer|SmsTemplate $smsTemplate Template content
     * @param null|integer|Student $student Student ID or Student model
     * @return string
     */
    public static function renderTemplateContent( $smsTemplate, $student = null )
    {
        //if ( ( $smsTemplate instanceof SmsTemplate ) == false ) {
            //$smsTemplate = SmsTemplate::findOrFail( $smsTemplate );
        //}
        $renderedText = $smsTemplate;

        $renderedText = str_replace( '{institute_name}', ( config('app.name') ?? '' ), $renderedText );

        // replacements related student
        if ( $student !== null ) {
            if ( ( $student instanceof Student ) == false ) {
                $student = Student::findOrFail( $student );
            }

            $renderedText = str_replace( '{std_pin}', ( $student->pin ?? '' ), $renderedText );
            $renderedText = str_replace( '{std_name}', ( $student->name ?? '' ), $renderedText );
            $renderedText = str_replace( '{father_name}', ( $student->fatherRecord->name ?? '' ), $renderedText );
            $renderedText = str_replace( '{son_or_daughter}', ( $student->gender == 'male' ? 'son' : 'daughter' ), $renderedText );
            $renderedText = str_replace( '{std_branch}', ( $student->branch->name ?? '' ), $renderedText );
            $renderedText = str_replace( '{std_class}', ( $student->currentClass->name ?? '' ), $renderedText );
            $renderedText = str_replace( '{std_section}', ( $student->section->name ?? '' ), $renderedText );
        }

        return $renderedText;
    }
}
