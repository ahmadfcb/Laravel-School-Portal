<?php

namespace App\Libraries;


use Illuminate\Support\Facades\Session;

class UrlLibrary
{
    private static $keyName = "redirect_back";

    public static function getBackUrl( $fallback = false )
    {
        // if available from session
        if ( Session::has( self::$keyName ) ) {
            return Session::get( self::$keyName );
        } elseif ( request( self::$keyName ) ) {// if redirect back is given in url
            return request( self::$keyName );
        } else { // not given in URL. Get back url from Laravel
            return \URL::previous( $fallback );
        }
    }

    public static function storeOrKeepBackUrl( $fallback = false )
    {
        // if back URL is already stored in the session
        if ( Session::has( self::$keyName ) ) {
            // keep it
            Session::keep( self::$keyName );
        } else { // back URL isn't available in session.
            // store it
            Session::flash( self::$keyName, self::getBackUrl( $fallback ) );
        }
    }
}