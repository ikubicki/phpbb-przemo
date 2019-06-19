<?php
/***************************************************************************
*                           lang_statistics.php
*                            -------------------
*   begin                : Tue February 26 2002
*   copyright            : (C) 2002 Nivisec.com
*   email                : admin@nivisec.com
*
*   $Id: lang_statistics.php,v 1.4 2002/11/09 16:04:08 acydburn Exp $
*
***************************************************************************/
/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

// Original Statistics Mod (c) 2002 Nivisec - http://nivisec.com/mods

//
// If you want to credit the Author on the Statistics Page, uncomment the second line.
//
$lang['Version_info'] = '<br />Statistics Mod Version %s'; //%s = number
//$lang['Version_info'] = '<br />Statistics Mod Version %s &copy; 2002 <a href="http://www.opentools.de/board">Acyd Burn</a>';

//
// These Language Variables are available for all installed Modules
//
$lang['Rank'] = 'Rank';
$lang['Percent'] = 'Percent';
$lang['Graph'] = 'Graph';
$lang['Uses'] = 'Uses';
$lang['How_many'] = 'How many';

//
// Main Language
//

//
// Page Header/Footer
//
$lang['Install_info'] = 'Installed on %s'; //%s = date
$lang['Viewed_info'] = 'Statistics Page Loaded %d Times'; //%d = number
$lang['Statistics_title'] = 'Board Statistics';

//
// Statistics Config
//
$lang['Statistics_config_title'] = 'Statistics Configuration';

$lang['Return_limit'] = 'Return Limit';
$lang['Return_limit_desc'] = 'The number of items to include in each ranking. This is auto-passed to all modules by being specified here.';
$lang['Clear_cache'] = 'Clear Module Cache';
$lang['Clear_cache_desc'] = 'Clear all the current cached data for all modules';

//
// Status Messages
//
$lang['Messages'] = 'Admin Messages';
$lang['Updated'] = 'Updated';
$lang['Active'] = 'Active';
$lang['Activate'] = 'Activate';
$lang['Activated'] = 'Activated';
$lang['Not_active'] = 'Not Active';
$lang['Deactivated'] = 'Deactivated';
$lang['Install'] = 'Install';
$lang['Uninstall'] = 'Uninstall';
$lang['Uninstalled'] = 'Uninstalled';
$lang['Move_up'] = 'Move Up';
$lang['Move_down'] = 'Move Down';
$lang['Update_time'] = 'Update Time';
$lang['Auth_settings_updated'] = 'Authorization Settings - [These are always updated]';

//
// Modules Management
//
$lang['Back_to_management'] = 'Back to the Modules Management Screen';
$lang['Statistics_modules_title'] = 'Statistics Module Management';

$lang['Module_name'] = 'Name';
$lang['Directory_name'] = 'Directory Name';
$lang['Status'] = 'Status';
$lang['Update_time_minutes'] = 'Update Time in Hours';
$lang['Update_time_desc'] = 'Time Intervall (in Minutes) of refreshing the cached data with new Data.';
$lang['Auto_set_update_time'] = 'Refresh all modules';
$lang['Uninstall_module'] = 'Uninstall Module';
$lang['Uninstall_module_desc'] = 'Marks the module with "not installed" status, so that you may reinstall it with the install command.  It does not delete the module from your file system, you will manually need to delete the module folder to remove it completely.';
$lang['Active_desc'] = 'Option of if the Module is Active, so it is displayed depending on the set Permissions.';

$lang['Not_allowed_to_install'] = 'You are not able to install this Module. Mostly this is because you haven\'t installed a Mod needed in order to run this Module. Please contact the Author of this Module if you have questions and if the Extra Info printed here makes no sense to you.';
$lang['Wrong_stats_mod_version'] = 'You are not able to install this Module, because your Statistics Mod Version does not match the Version required by the Module. In order to install and run the Module, you need at least Version %s of the Statistics Mod.'; // replace %s with Version (2.1.3 for example)
$lang['Module_install_error'] = 'There was an error of some type installing this module. More than likely some SQL commands could not be exectued, check for failure messages above.';

$lang['Preview_debug_info'] = 'This Module was generated in %f seconds: %d queries were executed.'; // Replace %f with seconds and %d with queries
$lang['Update_time_recommend'] = 'The Statistics Mod recommends (depending on the debug info) a update time of <b>%d</b> Minutes.'; // Replace %d with Minutes

?>