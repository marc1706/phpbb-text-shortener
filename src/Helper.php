<?php

/**
 * Text shortener for phpBB 3.3.x helper class
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
	 * @param string $string String to check
	 *
	 * @return int Real string length
	 */
	public function getRealLength(string $string): int
	{
		return mb_strlen(preg_replace('@\[([a-zA-Z0-9-_=]+)]|\[([a-zA-Z0-9-_=]+)][^]]+\[/\1]|\[(/?[a-zA-Z0-9-_=]+)]@i', '', strip_tags($string)));
	}

	/**
	 * Split text into parts with position info
	 *
	 * @param string $text Text to split
	 *
	 * @return array Split text
	 */
	public function splitText(string $text): array
	{
		return preg_split('@([<\[]/?[a-zA-Z0-9]+[]>])@i', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE);
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
	public function addDelimiters(string $text, array $delimiter_ary): string
	{
		return $delimiter_ary[0] . $text . $delimiter_ary[1];
	}

	/**
	 * Returns an HTML safe substr of the text, i.e. not cutting inside HTML
	 * entities or tags to prevent invalid markup. It'll opt for an equal or
	 * greater approach to the desired length.
	 *
	 * @param string $text Text to return substr from
	 * @param int $length Desired length of string
	 * @return string Substring of text
	 */
	public function htmlSafeSubstr(string $text, int $length): string
	{
		$substring = '';
		if (preg_match_all('/&(?:#(?:([0-9]+)|[Xx]([0-9A-Fa-f]+))|([A-Za-z0-9]+));|(<\w+[^>]+>)/', $text, $matches))
		{
			foreach ($matches[0] as $match)
			{
				$matchStart = mb_strpos($text, $match);
				$matchLength = mb_strlen($match);
				$matchEnd = $matchStart + $matchLength;
				if ($length >= $matchStart && $length <= $matchEnd)
				{
					$substring .= mb_substr($text, 0, $matchEnd);
					return $substring;
				}
				else if ($length < $matchStart)
				{
					$substring .= mb_substr($text, 0, $length);
					return $substring;
				}

				$cutString = mb_substr($text, 0, $matchEnd);
				$substring .= $cutString;
				$text = mb_substr($text, $matchEnd);
				$length -= $this->getRealLength($cutString);
			}

			if ($length < mb_strlen($text))
			{
				$substring .= mb_substr($text, 0, $length);
			}
			else
			{
				$substring .= $text;
			}
		}
		else
		{
			$substring = mb_substr($text, 0, $length);
		}

		return $substring;
	}
}
