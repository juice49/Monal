<?php
namespace Monal\Libraries;
/**
 * UploadHandler.
 *
 * @author	Arran Jacques
 */

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHandler
{
	/**
	 * If a file name already exists in the given directory then iterate
	 * it.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	Integer
	 * @return	String
	 */
	private static function iterateFileName($destination, $file_name, $extension, $iteration = 0)
	{
		if ($iteration == 0) {
			$concact_file_name = $file_name . '.' . $extension;
		} else {
			$concact_file_name = $file_name . '-' . $iteration . '.' . $extension;
		}
		if (file_exists($destination . '/' . $concact_file_name)) {
			return self::iterateFileName($destination, $file_name, $extension, $iteration + 1);
		} else {
			return $concact_file_name;
		}
	}

	/**
	 * Write a file to the uploads folder.
	 *
	 * @param	Symfony\Component\HttpFoundation\File\UploadedFile
	 * @param	String
	 * @param	String
	 * @return	String / Boolean
	 */
	public static function write(UploadedFile $file, $destination, $file_name)
	{
		$dir_path = '/uploads';
		foreach (explode('/', $destination) as $slug) {
			$dir_path .= '/' . trim($slug, '/');
			if (!file_exists(public_path() . $dir_path)) {
				mkdir(public_path() . $dir_path);
			}
		}
		$file_name = self::iterateFileName(public_path() . $dir_path, trim($file_name), $file->getClientOriginalExtension());
		if ($file->move(public_path() . $dir_path, $file_name)) {
			return $dir_path . '/' . $file_name;
		}
		return false;
	}
}