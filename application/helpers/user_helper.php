<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------
 *
 * MiOWL                                                     (v1) | codename dave
 *
 * ------------------------------------------------------------------------------
 *
 * Copyright (c) 2012, Alan Wynn
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * ------------------------------------------------------------------------------
 */

if (!function_exists('is_verified'))
{
    function is_verified()
    {
        $CI =& get_instance();
        if($CI->session->userdata('authed'))
            return $CI->owl_model->is_x('verified');
    }
}


if (!function_exists('is_admin'))
{
    function is_admin()
    {
        $CI =& get_instance();
        if($CI->session->userdata('authed'))
            return $CI->owl_model->is_x('admin');
    }
}


if (!function_exists('is_editor'))
{
    function is_editor()
    {
        $CI =& get_instance();
        if($CI->session->userdata('authed'))
            return $CI->owl_model->is_x('editor');
    }
}


if (!function_exists('is_owner'))
{
    function is_owner()
    {
        $CI =& get_instance();
        if($CI->session->userdata('authed'))
            return $CI->owl_model->is_x('owner');
    }
}


if (!function_exists('is_member'))
{
    function is_member($owl = FALSE)
    {
        $CI =& get_instance();
        if($CI->session->userdata('authed'))
            return $CI->owl_model->is_member();
        else
            return FALSE;
    }
}


// eof.