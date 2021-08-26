<?php

/**
 * Text shortener for phpBB 3.3.x base class
 * @package phpbb-text-shortener
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Marc1706\TextShortener;

class Shortener
{
	/** @var Helper */
	protected $helper;

	/** @var TextIterator */
	protected $textIterator;

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

	/**
	 * Shortener constructor.
	 */
	public function __construct()
	{
		$this->helper = new Helper();
		$this->textIterator = new TextIterator();
	}

	/**
	 * Set text source
	 *
	 * @param string $text
	 *
	 * @return $this
	 */
	public function setText(string $text): Shortener
	{
		$matches = [];
		// Remove surrounding text
		preg_match('@^(<[rt][ >])(.+)(</[rt][ >])$@s', $text, $matches);

		$this->inputValid = count($matches) && !empty($matches[2]) && $this->helper->getRealLength($matches[2]) != 0 && preg_match('/^<[rt][ >]/', $text);

		if ($this->inputValid)
		{
			$this->text = $matches[2];
			$this->delimiter = array($matches[1], $matches[3]);
			$this->textLength = $this->helper->getRealLength($text);
			$this->splitText = $this->helper->splitText($this->text);
		}

		return $this;
	}

	/**
	 * Shorten text to specified length
	 *
	 * @param int $length
	 *
	 * @return string Shortened text or empty if incorrect input data was supplied
	 */
	public function shortenText(int $length): string
	{
		if (!$this->inputValid) {
			return '';
		}

		if ($length >= $this->textLength) {
			$this->shortenedText = $this->text;
		} else {
			$this->buildShortenedText($length);
		}

		$this->shortenedText = $this->helper->addDelimiters($this->shortenedText, $this->delimiter);

		return $this->shortenedText;
	}

	/**
	 * Build shortened text
	 *
	 * @param int $targetLength Target length
	 */
	protected function buildShortenedText(int $targetLength)
	{
		$this->shortenedText = $this->textIterator->setText($this->splitText)
			->iterate($targetLength);

		$this->shortenedText = rtrim($this->shortenedText) . ' ...';
	}
}
