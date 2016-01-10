<?php

/**
 * Text shortener for phpBB 3.2.x base class
 * @package phpbb-text-shortener
 * @copyright (c) Marc Alexander <admin@m-a-styles.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Marc1706\TextShortener\tests;

require_once __DIR__ . '/../vendor/autoload.php';

class ShortenerTest extends \PHPUnit_Framework_TestCase
{
	/** @var \Marc1706\TextShortener\Shortener */
	protected $shortener;

	public function setUp()
	{
		parent::setUp();

		$this->shortener = new \Marc1706\TextShortener\Shortener();
	}

	public function dataShorten()
	{
		return array(
			array('<r>This is an example post in your phpBB3 installation. Everything seems to be working. You may delete this post if you like and continue to set up your board. During the installation process your first category and your first forum are assigned an appropriate set of permissions for the predefined usergroups admini<I><s>[i]</s>strators, bots, global moderators, guests, registered users and registered COPPA users. If you also choose to delete your first category and your first forum, do not <e>[/i]</e></I>forget to assign permissions <B><s>[b]</s>for all these<e>[/b]</e></B> usergroups for all new categories and forums you create. It is recommended to rename your first category and your first forum and copy permissions from these while creating new categories and forums. Have fun!<br/>
<IMG src="https://www.phpbb.com/assets/images/images/bg_forumatic_front_page.png?v2015122401"><s>[img]</s><URL url="https://www.phpbb.com/assets/images/images/bg_forumatic_front_page.png?v2015122401">https://www.phpbb.com/assets/images/images/bg_forumatic_front_page.png?v2015122401</URL><e>[/img]</e></IMG><br/>
<br/>
This is an example post in your phpBB3 installation.  <E>:D</E>  Everything seems to be working. You may delete this post if you like and continue to set up your board. During the installation process your first category and your first forum are assigned an appropriate set of permissions for the predefined usergroups administrators, bots, global moderators, guests, registered users and registered COPPA users. If you also choose to delete your first category and your first forum, do not forget to assign permissions for all these usergroups for all new categories and forums you create. It is recommended to rename your first category and your first forum and copy permissions from these while creating new categories and forums. Have fun!</r>', 300, '<r>This is an example post in your phpBB3 installation. Everything seems to be working. You may delete this post if you like and continue to set up your board. During the installation process your first category and your first forum are assigned an appropriate set of permissions for the predefined user ...</r>'),
			array('<r>This is an example post in your phpBB3 installation. Everything seems to be working. You may delete this post if you like and continue to set up your board. During the installation process your first category and your first forum are assigned an appropriate set of permissions for the predefined usergroups admini<I><s>[i]</s>strators, bots, global moderators, guests, registered users and registered COPPA users. If you also choose to delete your first category and your first forum, do not <e>[/i]</e></I>forget to assign permissions <B><s>[b]</s>for all these<e>[/b]</e></B> usergroups for all new categories and forums you create. It is recommended to rename your first category and your first forum and copy permissions from these while creating new categories and forums. Have fun!<br/>
<IMG src="https://www.phpbb.com/assets/images/images/bg_forumatic_front_page.png?v2015122401"><s>[img]</s><URL url="https://www.phpbb.com/assets/images/images/bg_forumatic_front_page.png?v2015122401">https://www.phpbb.com/assets/images/images/bg_forumatic_front_page.png?v2015122401</URL><e>[/img]</e></IMG><br/>
<br/>
This is an example post in your phpBB3 installation.  <E>:D</E>  Everything seems to be working. You may delete this post if you like and continue to set up your board. During the installation process your first category and your first forum are assigned an appropriate set of permissions for the predefined usergroups administrators, bots, global moderators, guests, registered users and registered COPPA users. If you also choose to delete your first category and your first forum, do not forget to assign permissions for all these usergroups for all new categories and forums you create. It is recommended to rename your first category and your first forum and copy permissions from these while creating new categories and forums. Have fun!</r>', 200, '<r>This is an example post in your phpBB3 installation. Everything seems to be working. You may delete this post if you like and continue to set up your board. During the installation process your first ...</r>'),
			array('nope', 300, ''),
			array('<r>one</r>', 300, '<r>one</r>'),
			array('<r>test <E>:D</E></r>', 6, '<r>test ...</r>'),
			array('<r>test with <B><s>[b]</s>some bold stuff happening<e>[/b]</e></B> plus some other stuff, too</r>', 12, '<r>test with <B><s>[b]</s>so<e>[/b]</e></B> ...</r>'),
		);
	}

	/**
	 * @dataProvider dataShorten
	 */
	public function testShorten($input, $length, $expected)
	{
		$this->assertEquals($expected, $this->shortener->setText($input)
			->shortenText($length));
	}
}