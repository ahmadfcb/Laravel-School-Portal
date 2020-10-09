<?php

namespace App\Libraries;


class MenuGenerator
{
    public static function mainSideBarMenuItem( $user, $route_url, $current_url, $link_name, $privileges = null, $parent = false, $fa_icon_name = 'home' )
    {
        $html = '<li class="' . ( $route_url == $current_url ? "active" : "" ) . '">';
        $html .= '<a href="' . $route_url . '">';

        if ( $parent === true ) {
            $html .= '<i class="fa fa-lg fa-fw fa-' . $fa_icon_name . '"></i>';
            $html .='<span class="menu-item-parent">';
        }

        $html .= $link_name;

        if($parent === true){
            $html .= '</span>';
        }

        $html .= '</a>';
        $html .= '</li>';

        // if some privilege is present
        if ( $privileges !== null ) {
            // if provided privilege doesn't exists
            if ( !$user->userHasPrivilege( $privileges, false ) ) {
                $html = '';
            }
        }
        return $html;
    }
}