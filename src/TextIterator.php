<?php

/**
 * Text shortener for phpBB 3.2.x TextIterator
 * @package phpbb-text-shortener
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Marc1706\TextShortener;

class TextIterator
{
	/** @var Helper */
	protected $helper;

	/** @var array Text array split with preg_split() */
	protected $splitText = [];

	/** @var string Shortened text */
	protected $shortenedText;

	/** @var bool In smiley flag */
	protected $inSmiley = false;

	/**
	 * TextIterator constructor.
	 */
	public function __construct()
	{
		$this->helper = new Helper();
	}

	/**
	 * Set split text array
	 *
	 * @param array $text
	 *
	 * @return $this Returns self for chained calls
	 */
	public function setText($text = [])
	{
		$this->splitText = $text;

		return $this;
	}

	public function iterate($targetLength)
	{
		$inSmiley = false;
		$length = 0;
		$this->shortenedText = '';

		foreach ($this->splitText as $part) {
			$curLength = $this->helper->getRealLength($part[0]);

			if (($curLength + $length) > $targetLength) {
				$this->shortenedText .= substr($part[0], 0, $targetLength - $length);
			} else {
				$this->shortenedText .= $part[0];
			}
			$length = $this->helper->getRealLength($this->shortenedText);

			if ($length >= $targetLength) {
				break;
			}
		}

		return $this->shortenedText;
	}
}
