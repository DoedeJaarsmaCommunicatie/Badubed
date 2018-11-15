<?php
/**
 * Created by PhpStorm.
 * User: mitch
 * Date: 2018-10-24
 * Time: 10:08
 */

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
	static $display;
	isset($display) || $display = apply_filters('badubed/display_sidebar', false);
	return $display;
}