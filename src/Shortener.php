<?php

/**
 * Text shortener for phpBB 3.2.x base class
 * @package phpbb-text-shortener
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Marc1706\TextShortener;

class Shortener
{
	/** @var string Text */
	private $text;

	/** @var int Text length */
	private $textLength = 0;

	/** @var bool Flag if input can be used for shortening */
	private $inputValid = false;

	/** @var string Shortened text */
	private $shortenedText;

	/** @todo: Needed? */
	public function __construct()
	{

	}

	/**
	 * Set text source
	 *
	 * @param $text
	 *
	 * @return $this
	 */
	public function setText($text)
	{
		$this->text = $text;
		$this->textLength = strlen($text);

		$this->inputValid = !empty($this->text) && $this->textLength !== 0;

		return $this;
	}

	/**
	 * Shorten text to specified length
	 *
	 * @param $length
	 *
	 * @return string Shortened text or empty if incorrect input data was supplied
	 */
	public function shortenText($length)
	{
		if (!$this->inputValid) {
			return '';
		}

		return $this->shortenedText;
	}

	/**
	 * Get real length of text without xml tags and BBCode
	 *
	 * @param $string String to check
	 *
	 * @return int Real string length
	 */
	protected function getRealLength($string)
	{
		return strlen(preg_replace('@\[([a-zA-Z0-9-_]+)\].+\[/\1\]@i', '', strip_tags($string)));
	}
}
