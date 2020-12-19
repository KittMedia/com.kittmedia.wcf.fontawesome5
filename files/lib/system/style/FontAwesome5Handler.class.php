<?php
namespace wcf\system\style;
use wcf\data\style\ActiveStyle;
use wcf\data\style\Style;
use wcf\data\style\StyleEditor;
use wcf\system\cache\builder\StyleCacheBuilder;
use wcf\system\exception\SystemException;
use wcf\system\request\RequestHandler;
use wcf\system\SingletonFactory;
use wcf\system\WCF;
use wcf\util\JSON;

/**
 * Handles Font Awesome 5 icons.
 * 
 * @author	Matthias Kittsteiner
 * @copyright	2020 KittMedia
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
class FontAwesome5Handler extends SingletonFactory {
	/**
	 * list of FontAwesome icons excluding the `fa-`-prefix
	 * @var string[]
	 */
	protected $icons = [];
	
	/**
	 * Returns the list of FontAwesome icons excluding the `fa-`-prefix,
	 * optionally encoding the list as JSON.
	 * 
	 * @param	boolean		$toJSON		encode array as a JSON string
	 * @return	string|\string[]	JSON string or PHP array of strings
	 */
	public function getIcons($toJSON = false) {
		if (empty($this->icons)) {
			$this->parseVariables();
		}
		
		if ($toJSON) {
			return JSON::encode($this->icons);
		}
		
		return $this->icons;
	}
	
	/**
	 * Reads the available icon names from the variable definition file.
	 */
	protected function parseVariables() {
		$content = file_get_contents(WCF_DIR.'style/fontAwesome/base/_variables.scss');
		preg_match_all('~\$fa-var-([a-z0-9\-]+)~', $content, $matches);
		
		$this->icons = $matches[1];
	}
}
