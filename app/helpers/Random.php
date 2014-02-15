<?php
/**
 * Random.
 *
 * Generate random strings.
 *
 * @author	Arran Jacques
 */

class Random
{ 
	/**
	 * Classical Latin alphabet in lower case.
	 *
	 * @var		String
	 */
	private static $alpha_lower_case = 'abcdefghijklmnopqrstuvwxyz';

	/**
	 * Classical Latin alphabet in upper case.
	 *
	 * @var		String
	 */
	private static $alpha_upper_case = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	/**
	 * Digits
	 *
	 * @var		String
	 */
	private static $numeric = '0123456789';

	/**
	 * Generate a random string of x length form a supplied string of
	 * characters.
	 *
	 * @param	String
	 * @param	Integer
	 * @return	String
	 */
	public static function from($chars = '', $length = 10)
	{
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $randomString;
	}

	/**
	 * Generate a random string of x length consisting of letters from
	 * the classical Latin alphabet.
	 *
	 * @param	Integer
	 * @return	String
	 */
	public static function letters($length = 10)
	{
		return self::from(self::$alpha_lower_case . self::$alpha_upper_case, $length);
	}

	/**
	 * Generate a random string of x length consisting of lower case
	 * letters from the classical Latin alphabet.
	 *
	 * @param	Integer
	 * @return	String
	 */
	public static function upperCaseLetters($length = 10)
	{
		return self::from(self::$alpha_upper_case, $length);
	}

	/**
	 * Generate a random string of x length consisting of upper case
	 * letters from the classical Latin alphabet.
	 *
	 * @param	Integer
	 * @return	String
	 */
	public static function lowerCaseLetters($length = 10)
	{
		return self::from(self::$alpha_lower_case, $length);
	}

	/**
	 * Generate a random string of x length consisting of numerical
	 * characters.
	 *
	 * @param	Integer
	 * @return	String
	 */
	public static function digits($length = 10)
	{
		return self::from(self::$numeric, $length);
	}
}