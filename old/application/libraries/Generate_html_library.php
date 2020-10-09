<?php

class Generate_html_library
{
    public $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function branches( $name = 'branch', $default_value = null )
    {
        $branches = $this->ci->branch_model->get();

        $html = "<select name='{$name}' class='form-control'><option value=''>--Select--</option>";
        foreach ( $branches as $branch ) {
            $html .= "<option value='{$branch['name']}' " . set_select( $name, $branch['name'], ( $default_value !== null ? $branch['name'] == $default_value : '' ) ) . " >{$branch['name']}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    public function classes( $name = 'class', $default_value = null )
    {
        $classes = $this->ci->class_model->get();

        $html = "<select name='{$name}' class='form-control'><option value=''>--Select--</option>";
        foreach ( $classes as $class ) {
            $html .= "<option value='{$class['name']}' " . set_select( 'class', $class['name'], ( $default_value !== null ? $class['name'] == $default_value : '' ) ) . " >{$class['name']}</option>";
        }
        $html .= "</select>";

        return $html;
    }

    public function sections( $name = 'section', $default_value = null )
    {
        $sections = $this->ci->section_model->get();

        $html = "<select name='{$name}' class='form-control'><option value=''>--Select--</option>";
        foreach ( $sections as $section ) {
            $html .= "<option value='{$section['name']}' " . set_select( 'section', $section['name'], ( $default_value !== null ? $section['name'] == $default_value : '' ) ) . " >{$section['name']}</option>";
        }
        $html .= "</select>";

        return $html;
    }
}