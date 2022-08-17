<?php

/**
 * Text shortener for phpBB 3.3.x TextIterator
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

	/** @var bool In BBCode flag */
	protected $inBBCode = false;

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
	public function setText(array $text = []): TextIterator
	{
		$this->splitText = $text;

		return $this;
	}

	/**
	 * Iterate over text
	 *
	 * @param int $targetLength Target length
	 * @return string Shortened text
	 */
	public function iterate(int $targetLength): string
	{
		$length = 0;
		$this->shortenedText = '';
		$isEnd = false;

		foreach ($this->splitText as $part) {
			$curLength = $this->helper->getRealLength($part[0]);

			if (($curLength + $length) > $targetLength && $this->isTag($part[0])) {
				// Do not break inside tag unless necessary
				$newPart = $this->helper->htmlSafeSubstr($part[0], $targetLength - $length);
				$isEnd = true;
			} else {
				$newPart = $part[0];
			}
			$this->shortenedText .= $newPart;
			$length = $this->helper->getRealLength($this->shortenedText);

			$this->handleTags($newPart, $part[1]);

			if ($length >= $targetLength || $isEnd) {
				break;
			}
		}

		$this->closeOpenTags();

		return $this->shortenedText;
	}

	/**
	 * Get whether string is tag
	 *
	 * @param string $string
	 * @return bool True if element is tag, false if not
	 */
	protected function isTag(string $string): bool
	{
		return preg_match('@([<\[]/?[a-zA-Z0-9]+[]>])@i', $string) !== false;
	}

	/**
	 * Handle tags in string part
	 *
	 * @param string $newPart New part
	 * @param int $position Position of part
	 */
	protected function handleTags(string $newPart, int $position): void
	{
		if (preg_match('@(?|((<[A-Z0-9_]+)|(\[\w+)|<s)[^]>]*[]>])@', $newPart, $matches)) {
			if ($matches[1] === '<E>') {
				$this->inSmiley = true;
			} else if ($matches[1] === '<s>') {
				$this->inBBCode = true;
			}

			$this->openTags[$position + mb_strpos($newPart, $matches[1])] = $newPart;
		} else if (preg_match('@(?|(</[A-Z0-9_]+>)|(\[/\w+])|(</s>))@', $newPart, $matches)) {
			if ($matches[1] === '</E>') {
				$this->inSmiley = false;
			} else if ($matches[1] === '</s>') {
				$this->inBBCode = false;
			}

			$tagsReverse = array_reverse($this->openTags, true);
			// Check if tag is ending tag and search for open tag in open tags array
			if (preg_match('@(?|(<)/([A-Z0-9_]+)[^>]*(>)|(\[)/(\w+)[^]]*(])|(<)/(s)(>))@', $matches[1], $regexMatches)) {
				$regex = '@' . preg_quote($regexMatches[1]) . $regexMatches[2] . '[^' . preg_quote($regexMatches[3]) . ']*' . preg_quote($regexMatches[3]) . '@';

				foreach ($tagsReverse as $key => $value) {
					if (preg_match($regex, $value)) {
						unset($this->openTags[$key]);
						break;
					}
				}
			}
		}
	}

	/**
	 * Close all open tags in shortened text
	 */
	protected function closeOpenTags()
	{
		while ($tag = array_pop($this->openTags)) {
			if ($this->inSmiley && $tag === '<E>') {
				$this->shortenedText = mb_substr($this->shortenedText, 0, strripos($this->shortenedText, '<E>'));
				$this->inSmiley = false;
			} else if ($this->inBBCode && $tag === '<s>') {
				$this->shortenedText = mb_substr($this->shortenedText, 0, strripos($this->shortenedText, '<s>'));
				$this->inBBCode = false;
			} else {
				$this->shortenedText .= preg_replace(array('@(<)(\w+)[^>]*(?<!/)(>)@', '@(\[)(\w+)[^]]*(?<!/)(])@i'), array('$1/$2$3', '<e>$1/$2$3</e>'), $tag);
			}
		}

		$this->openTags = [];
	}
}
