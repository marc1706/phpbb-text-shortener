<?php

/**
 * Text shortener for phpBB 3.2.x helper class
 * @package phpbb-text-shortener
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Marc1706\TextShortener;

class Helper
{
	/**
	 * Get real length of text without xml tags and BBCode
	 *
	 * @param $string String to check
	 *
	 * @return int Real string length
	 */
	public function getRealLength($string)
	{
		return strlen(preg_replace('@\[([a-zA-Z0-9-_]+)\].+\[/\1\]|\[(\/?[a-zA-Z0-9-_]+)\]@i', '', strip_tags($string)));
	}

	/**
	 * Split text into parts with position info
	 *
	 * @param string $text Text to split
	 *
	 * @return string Split text
	 */
	public function splitText($text)
	{
		return preg_split('@([<\[]\/?[a-zA-Z0-9]+[\]>])@i', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE);
	}

	/**
	 * Add delimiters to text
	 *
	 * @param string $text Text to add delimiters to
	 * @param array $delimiter_ary Array with starting delimiter at 0 and
	 *		ending delimiter at 1
	 *
	 * @return string Text with delimiters
	 */
	public function addDelimiters($text, $delimiter_ary)
	{
		return $delimiter_ary[0] . $text . $delimiter_ary[1];
	}
}
