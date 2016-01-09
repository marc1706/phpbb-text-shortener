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

	/** @var array Text splitted using preg_split() */
	private $splitText;

	/** @var int Text length */
	private $textLength = 0;

	/** @var bool Flag if input can be used for shortening */
	private $inputValid = false;

	/** @var string Shortened text */
	private $shortenedText;

	/** @var array Delimiters of current text */
	private $delimiter;

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
		// Remove surrounding text
		preg_match('@^(<[rt][ >])(.+)(<\/[rt][ >])$@s', $text, $matches);
		$this->text = $matches[2];
		$this->delimiter = array($matches[1], $matches[3]);
		$this->textLength = $this->getRealLength($text);

		$this->inputValid = !empty($this->text) && $this->textLength !== 0 && preg_match('/^<[rt][ >]/', $text);

		if ($this->inputValid)
		{
			$this->splitText($this->text);
		}

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

		if ($length >= $this->textLength) {
			$this->shortenedText = $this->text;
		} else {
			$this->buildShortenedText($length);
		}

		$this->addDelimiters();

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

	/**
	 * Split text into parts with position info
	 *
	 * @param string $text Text to split
	 */
	protected function splitText($text)
	{
		$this->splitText = preg_split('@([<\[]\/?[a-zA-Z0-9]+[\]>])@i', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_OFFSET_CAPTURE);
	}

	/**
	 * Add delimiters to shortened text
	 */
	protected function addDelimiters()
	{
		$this->shortenedText = $this->delimiter[0] . $this->shortenedText  . ' ...' . $this->delimiter[1];
	}

	protected function buildShortenedText($targetLength)
	{
		$inSmiley = false;
		$length = 0;
		$this->shortenedText = '';

		foreach ($this->splitText as $part) {
			$curLength = $this->getRealLength($part[0]);

			if (($curLength + $length) > $targetLength) {
				$this->shortenedText .= substr($part[0], 0, $targetLength - $length);
			} else {
				$this->shortenedText .= $part[0];
			}
			$length = $this->getRealLength($this->shortenedText);



			if ($length >= $targetLength) {
				break;
			}
		}
	}
}
