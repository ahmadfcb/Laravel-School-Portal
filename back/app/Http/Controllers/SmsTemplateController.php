<?php

namespace App\Http\Controllers;

use App\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware( 'CheckPrivilege:sms_template_view' );
        $this->middleware( 'CheckPrivilege:sms_template_delete' )->only( 'delete' );
    }

    public function index( SmsTemplate $smsTemplateEdit )
    {
        $title = "SMS Templates";

        $smsTemplates = SmsTemplate::orderBy( 'template' )->get();

        return view( 'sms_template.index', compact(
            'title',
            'smsTemplates',
            'smsTemplateEdit'
        ) );
    }

    public function add( Request $request, SmsTemplate $smsTemplateEdit )
    {
        $this->validate( $request, [
            'name' => 'nullable|string|max:191',
            'template' => 'required|string|max:65000'
        ] );

        $name = $request->name;
        $template = $request->template;

        // if sms template edit is given. Update record
        if ( $smsTemplateEdit->id !== null ) {

            if ( !\Auth::user()->userHasPrivilege( 'sms_template_edit' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            $smsTemplateEdit->name = $name;
            $smsTemplateEdit->template = $template;
            $smsTemplateEdit->save();
            return redirect()->route( 'dashboard.sms.templates' )->with( 'msg', "SMS template updated successfully!" );
        } else { // create new

            if ( !\Auth::user()->userHasPrivilege( 'sms_template_add' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            SmsTemplate::create( ['name' => $name, 'template' => $template] );
            return back()->with( 'msg', "SMS Template has been created." );
        }
    }

    public function delete( SmsTemplate $smsTemplate )
    {
        $smsTemplate->delete();
        return redirect()->route( 'dashboard.sms.templates' )->with( 'msg', "SMS Template has been deleted successfully." );
    }
}
