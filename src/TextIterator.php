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

	/** @var array Open tags array */
	protected $openTags = [];

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
		$length = 0;
		$this->shortenedText = '';

		foreach ($this->splitText as $part) {
			$curLength = $this->helper->getRealLength($part[0]);

			if (($curLength + $length) > $targetLength && !$this->isTag($part[0])) {
				$newPart = substr($part[0], 0, $targetLength - $length);
			} else {
				$newPart = $part[0];
			}
			$this->shortenedText .= $newPart;
			$length = $this->helper->getRealLength($this->shortenedText);

			$this->handleTags($newPart, $part[1]);

			if ($length >= $targetLength) {
				break;
			}
		}

		$this->closeOpenTags();

		return $this->shortenedText;
	}

	protected function isTag($string)
	{
		return preg_match('@([<\[]\/?[a-zA-Z0-9]+[\]>])@i', $string);
	}

	protected function handleTags($newPart, $position)
	{
		if (preg_match('@([<\[][a-zA-Z0-9]+[\]>])@i', $newPart, $matches)) {
			if ($matches[1] === '<E>') {
				$this->inSmiley = true;
			}

			$this->openTags[$position + strpos($newPart, $matches[1])] = $newPart;
		} else if (preg_match('@([<\[]\/[a-zA-Z0-9]+[\]>])@i', $newPart, $matches)) {
			if ($matches[1] === '</E>') {
				$this->inSmiley = false;
			}

			$tagsReverse = array_reverse($this->openTags, true);
			if ($key = array_search(preg_replace('@([<\[])\/([a-zA-Z0-9]+)([\]>])@i', '$1$2$3', $matches[1]), $tagsReverse, true)) {
				unset($this->openTags[$key]);
			}
		}
	}

	protected function closeOpenTags()
	{
		while ($tag = array_pop($this->openTags)) {
			if ($this->inSmiley && $tag === '<E>') {
				$this->shortenedText = substr($this->shortenedText, 0, strripos($this->shortenedText, '<E>'));
				$this->inSmiley = false;
			} else {
				$this->shortenedText .= preg_replace(array('@(<)([a-zA-Z0-9]+)(>)@i', '@(\[)([a-zA-Z0-9]+)(\])@i'), array('$1/$2$3', '<e>$1/$2$3</e>'), $tag);
			}
		}

		$this->openTags = [];
	}
}
