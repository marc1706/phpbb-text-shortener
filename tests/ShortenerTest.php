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
			array('<r>test <E>:D</E> and some more</r>', 11, '<r>test <E>:D</E> and ...</r>'),
			array('<r>test with <B><s>[b]</s>some bold stuff happening<e>[/b]</e></B> plus some other stuff, too</r>', 12, '<r>test with <B><s>[b]</s>so<e>[/b]</e></B> ...</r>'),
			array('<r><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Name:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> Board3 Portal<br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Autor:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> Marc, nickvergessen<br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Beschreibung:<e>[/b]<<r><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Name:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> Board3 Portal<br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Autor:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> Marc, nickvergessen<br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Beschreibung:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR>:<br/>Fügt ein Portal mit diversen Modulen deinem Forum hinzu. Im Admin-Bereich kann man unter Anderem die Einstellungen ändern, die Module verschieben, neue Module hinzufügen und vieles mehr.<br/><IMG src="http://www.w3.org/html/logo/downloads/HTML5_Logo_32.png"><s>[img]</s><URL url="http://www.w3.org/html/logo/downloads/HTML5_Logo_32.png">http://www.w3.org/html/logo/downloads/HTML5_Logo_32.png</URL><e>[/img]</e></IMG><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Version:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR>: 2.1.0<br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Benötigte phpBB Version:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR>: 3.1.5+<br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Features:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR><LIST><s>[list]</s><LI><s>[*]</s>Verschieben, Hinzufügen, Löschen und Änderung von Modulen im Admin-Bereich</LI><LI><s>[*]</s><table>-freies Layout in prosilver</LI><LI><s>[*]</s>Unbegrenzte Anzahl an "Eigenen Blöcken" - Einfach hinzufügen im Admin-Bereich</LI><LI><s>[*]</s>Responsive Design in prosilver</LI><LI><s>[*]</s>Portal auf allen Seiten (linke oder rechte Spalte können auf allen Seiten angezeigt werden)</LI><LI><s>[*]</s>...</LI><e>[/list]</e></LIST><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Screenshots:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR><br/><URL url="http://board3.de/download/file.php?id=601&mode=view"><s>[url=http://board3.de/download/file.php?id=601&mode=view]</s><IMG src="http://board3.de/download/file.php?id=601&t=1"><s>[img]</s>http://board3.de/download/file.php?id=601&t=1<e>[/img]</e></IMG><e>[/url]</e></URL><br/><URL url="http://board3.de/download/file.php?id=626&mode=view"><s>[url=http://board3.de/download/file.php?id=626&mode=view]</s><IMG src="http://board3.de/download/file.php?id=626&t=1"><s>[img]</s>http://board3.de/download/file.php?id=626&t=1<e>[/img]</e></IMG><e>[/url]</e></URL><br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Demo URL:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> none yet<br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>ACP Demo URL:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> <URL url="http://board3.de/acp_demo_v2.1.x/index.html"><s>[url=http://board3.de/acp_demo_v2.1.x/index.html]</s>ACP Demo<e>[/url]</e></URL><br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Download:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR><br/><URL url="http://board3.de/download/file.php?id=644"><s>[url=http://board3.de/download/file.php?id=644]</s>Download Board3 Portal 2.1.0<e>[/url]</e></URL></r>/e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR>:<br/>Fügt ein Portal mit diversen Modulen deinem Forum hinzu. Im Admin-Bereich kann man unter Anderem die Einstellungen ändern, die Module verschieben, neue Module hinzufügen und vieles mehr.<br/><IMG src="http://www.w3.org/html/logo/downloads/HTML5_Logo_32.png"><s>[img]</s><URL url="http://www.w3.org/html/logo/downloads/HTML5_Logo_32.png">http://www.w3.org/html/logo/downloads/HTML5_Logo_32.png</URL><e>[/img]</e></IMG><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Version:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR>: 2.1.0<br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Benötigte phpBB Version:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR>: 3.1.5+<br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Features:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR><LIST><s>[list]</s><LI><s>[*]</s>Verschieben, Hinzufügen, Löschen und Änderung von Modulen im Admin-Bereich</LI><LI><s>[*]</s><table>-freies Layout in prosilver</LI><LI><s>[*]</s>Unbegrenzte Anzahl an "Eigenen Blöcken" - Einfach hinzufügen im Admin-Bereich</LI><LI><s>[*]</s>Responsive Design in prosilver</LI><LI><s>[*]</s>Portal auf allen Seiten (linke oder rechte Spalte können auf allen Seiten angezeigt werden)</LI><LI><s>[*]</s>...</LI><e>[/list]</e></LIST><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Screenshots:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR><br/><URL url="http://board3.de/download/file.php?id=601&mode=view"><s>[url=http://board3.de/download/file.php?id=601&mode=view]</s><IMG src="http://board3.de/download/file.php?id=601&t=1"><s>[img]</s>http://board3.de/download/file.php?id=601&t=1<e>[/img]</e></IMG><e>[/url]</e></URL><br/><URL url="http://board3.de/download/file.php?id=626&mode=view"><s>[url=http://board3.de/download/file.php?id=626&mode=view]</s><IMG src="http://board3.de/download/file.php?id=626&t=1"><s>[img]</s>http://board3.de/download/file.php?id=626&t=1<e>[/img]</e></IMG><e>[/url]</e></URL><br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Demo URL:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> none yet<br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>ACP Demo URL:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR> <URL url="http://board3.de/acp_demo_v2.1.x/index.html"><s>[url=http://board3.de/acp_demo_v2.1.x/index.html]</s>ACP Demo<e>[/url]</e></URL><br/><br/><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Extension Download:<e>[/b]</e></B><e>[/size]</e></SIZE><e>[/color]</e></COLOR><br/><URL url="http://board3.de/download/file.php?id=644"><s>[url=http://board3.de/download/file.php?id=644]</s>Download Board3 Portal 2.1.0<e>[/url]</e></URL></r>',
			5, '<r><COLOR color="purple"><s>[color=purple]</s><SIZE size="120"><s>[size=120]</s><B><s>[b]</s>Exten<e>[/b]</e></B> ...</r>'),
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