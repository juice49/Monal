<?php

class Text {

	/**
	 * Convert a string to snake_case allowing only alpha, underscore
	 * and space characters.
	 *
	 * @param	String
	 * @return	String
	 */
	public static function snakeCaseString($string)
	{
		// Trim whitespace from ends.
		$snake_case = trim($string);
		// Strip all characters except alpha, hypen, underscore and spaces.
		$snake_case = preg_replace('/[^a-zA-Z\-_ ]/', '', $snake_case);
		// Convert hyphens to spaces.
		$snake_case = str_replace('-', ' ', $snake_case);
		// Replace mutiple spaces with one space.
		$snake_case = preg_replace('!\s+!', ' ', $snake_case);
		// Convert spaces to underscores
		$snake_case = str_replace(' ', '_', $snake_case);
		// Covert to lowercase.
		return strtolower($snake_case);
	}
}