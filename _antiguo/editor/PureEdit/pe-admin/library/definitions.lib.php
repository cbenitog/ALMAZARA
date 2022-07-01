<?php
// Define settings.
define("SITE_TITLE", $settings['site']['title']);
define("SITE_URL", $settings['site']['url']);
define("APP_RSS", $settings['pureedit']['rss']);
define("APP_THEME", $settings['pureedit']['theme']);
define("APP_VERSION", $settings['pureedit']['version']);
define("TABLE_PREFIX", $settings['pureedit']['tablePrefix']);
define("LANG_PACK", $settings['pureedit']['lang']);
define("DATABASE_TYPE", $settings['database']['databaseType']);

// Find out if we are on the dashboard or in a sector.
if(isset($_GET['sector']))
{
    // Define sector.
    $getSector = $Db->select(TABLE_PREFIX . "sectors", $_GET['sector']);
    $resultSector = $Db->fetch_assoc($getSector);

	define("SECTOR_ID", $resultSector['id']);
    define("SECTOR_ABBREV", $resultSector['abbrev']);
    define("SECTOR_TITLE", $resultSector['title']);
}
else
{
    // Define dashboard.
    // Dshbrd doesn't do anything, just for looks on the menu.
	define("SECTOR_ID", 0);
    define("SECTOR_ABBREV", "Dshbrd");
    define("SECTOR_TITLE", "Dashboard");
}
?>