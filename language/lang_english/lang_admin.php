<?php

/***************************************************************************
 *                          lang_admin.php [English]
 *                          -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *     modification         : (C) 2003 Przemo http://www.przemo.org
 *     date modification    : ver. 1.12.1 2005/11/10 19:34
 *
 ****************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

/* CONTRIBUTORS
	2002-12-15	Philip M. White (pwhite@mailhaven.com)
		Fixed many minor grammatical mistakes
*/

//
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//



$lang['Groups'] = 'Group Admin';
$lang['Styles'] = 'Styles Admin';
$lang['General'] = 'General Admin';
$lang['Users'] = 'User Admin';
$lang['Forums'] = 'Forum Admin';

$lang['Configuration'] = 'Configuration';
$lang['Manage'] = 'Management';
$lang['Disallow'] = 'Disallow names';
$lang['Prune'] = 'Pruning';
$lang['Mass_Email'] = 'Mass Email';
$lang['Ranks'] = 'Ranks';
$lang['Smilies'] = 'Smilies';
$lang['Ban_Management'] = 'Ban Control';
$lang['Word_Censor'] = 'Word Censors';
$lang['Export'] = 'Export';
$lang['Create_new'] = 'Create';
$lang['Add_new'] = 'Add';
$lang['Backup_DB'] = 'Backup Database';
$lang['Restore_DB'] = 'Restore Database';

//
// Index
//

$lang['Admin'] = 'Administration';
$lang['Welcome_phpBB'] = 'Welcome to phpBB';
$lang['Admin_intro'] = 'Thank you for choosing phpBB as your forum solution. This screen will give you a quick overview of all the various statistics of your board. You can get back to this page by clicking on the <u>Admin Index</u> link in the left pane. To return to the index of your board, click the phpBB logo also in the left pane. The other links on the left hand side of this screen will allow you to control every aspect of your forum experience, each screen will have instructions on how to use the tools.';
$lang['Main_index'] = 'Forum Index';
$lang['Forum_stats'] = 'Forum Statistics';
$lang['Admin_Index'] = 'Admin Index';
$lang['Preview_forum'] = 'Preview Forum';

$lang['Click_return_admin_index'] = 'Click %sHere%s to return to the Admin Index';

$lang['Statistic'] = 'Statistic';
$lang['Value'] = 'Value';
$lang['Number_posts'] = 'Number of posts';
$lang['Posts_per_day'] = 'Posts per day';
$lang['Number_topics'] = 'Number of topics';
$lang['Topics_per_day'] = 'Topics per day';
$lang['Number_users'] = 'Number of users';
$lang['Users_per_day'] = 'Users per day';
$lang['Board_started'] = 'Board started';
$lang['Avatar_dir_size'] = 'Disk usage';
$lang['Database_size'] = 'Database size';
$lang['Gzip_compression'] = 'Gzip compression';
$lang['Not_available'] = 'Not available';
$lang['f_mail'] = 'Handling function <b>mail</b> on the server';
$lang['search_keywords_max'] = 'Max. number of words which user can use to search.';
$lang['languages_list'] = 'Available languages: %s';
$lang['files_list'] = 'Available files: %s';


//
// DB Utils
//
$lang['Database_Utilities'] = 'Database Utilities';
$lang['Restore'] = 'Restore';
$lang['Backup'] = 'Backup';
$lang['Backup_explain'] = 'Here you can activate automated database backup. The database will be backed up every 24h from the time of activation. <br /> You can chose how many backups are to be stored on the server. The copies will be stored in the directory /db/db_backup The <b>db_backup</b> directory should have write-permissions activated (chmod 777). <br> Here you can also make a backup �on demand� by clicking the link. <br /> The name of the stored file will be i.e. db_backup_phpbb_psmdowhx_date_30-05-2005.sql.gz. The psmdowhx is a random text, which will protect the file from unwanted visitors.  The directory /db_backup/ is not indexable because it contains the file index.html. <br /> You have the option to disable backup of the search and read_history tables. The table search can be rebuilt using the rebuild tool in the admin panel. The tables search and read_history are the most space consuming tables in the database. The read_history table can not be restored in the same way as the search table.';
$lang['db_backup_enable'] = 'Enable automatic copy database';
$lang['db_backup_copies'] = 'Number of copies held';
$lang['db_backup_tables_search'] = 'Copy search table data';
$lang['db_backup_tables_rh'] = 'Copy read_history table data';
$lang['db_backup_link'] = 'Make backup now';
$lang['db_backup_done'] = 'Backup created.';
$lang['db_backup_last'] = 'Last backup: ';

//
// Auth pages
//
$lang['Select_a_User'] = 'Select a User';
$lang['Select_a_Group'] = 'Select a Group';
$lang['Select_a_Forum'] = 'Select a Forum';
$lang['Auth_Control_User'] = 'User Permissions Control';
$lang['Auth_Control_Group'] = 'Group Permissions Control';
$lang['Auth_Control_Forum'] = 'Forum Permissions Control';
$lang['Look_up_User'] = 'Look up User';
$lang['Look_up_Group'] = 'Look up Group';
$lang['Look_up_Forum'] = 'Look up Forum';

$lang['Group_auth_explain'] = 'Here you can alter the permissions and moderator status assigned to each user group. Do not forget when changing group permissions that individual user permissions may still allow the user entry to forums, etc.';
$lang['User_auth_explain'] = 'Here you can alter the permissions and moderator status assigned to each individual user. Do not forget when changing user permissions that group permissions may still allow the user entry to forums, etc.';
$lang['Forum_auth_explain'] = 'Here you can alter the authorisation levels of each forum. You will have both a simple and advanced method for doing this, advanced offers greater control of each forum operation. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.';

$lang['Simple_mode'] = 'Simple Mode';
$lang['Advanced_mode'] = 'Advanced Mode';
$lang['Moderator_status'] = 'Moderator status';

$lang['Allowed_Access'] = 'Allowed Access';
$lang['Disallowed_Access'] = 'Disallowed Access';
$lang['Is_Moderator'] = 'Is Moderator';
$lang['Not_auth_Moderator'] = 'Not Moderator';

$lang['Public'] = 'Public';
$lang['Private'] = 'Private';
$lang['Registered'] = 'Registered';
$lang['Hidden'] = 'Hidden';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'ALL';
$lang['Forum_REG'] = 'REG';
$lang['Forum_PRIVATE'] = 'PRIVATE';
$lang['Forum_MOD'] = 'MOD';
$lang['Forum_ADMIN'] = 'ADMIN';

$lang['View'] = 'View';
$lang['Read'] = 'Read';
$lang['Post'] = 'Post';
$lang['Reply'] = 'Reply';
$lang['Edit'] = 'Edit';
$lang['Sticky'] = 'Sticky';
$lang['Announce'] = 'Announce';
$lang['Vote'] = 'Vote';
$lang['Pollcreate'] = 'Poll create';

$lang['Simple_Permission'] = 'Simple Permission';

$lang['User_Level'] = 'User Level';
$lang['Auth_Admin'] = 'Administrator';
$lang['Group_memberships'] = 'Usergroup memberships (in total: %d)';
$lang['Usergroup_members'] = 'This group has the following members (in total: %d)';

$lang['Forum_auth_updated'] = 'Forum permissions updated';
$lang['Auth_updated'] = 'Permissions have been updated';
$lang['Click_return_userauth'] = 'Click %sHere%s to return to User Permissions';
$lang['Click_return_groupauth'] = 'Click %sHere%s to return to Group Permissions';
$lang['Click_return_forumauth'] = 'Click %sHere%s to return to Forum Permissions';


//
// Banning
//
$lang['Ban_explain'] = 'Here you can control the banning of users. You can achieve this by banning either or both of a specific user or an individual or range of IP addresses or hostnames. These methods prevent a user from even reaching the index page of your board. To prevent a user from registering under a different username you can also specify a banned email address. Please note that banning an email address alone will not prevent that user from being able to log on or post to your board. You should use one of the first two methods to achieve this.';
$lang['Select_username'] = 'Select a Username';
$lang['Ban_IP'] = 'Ban one or more IP addresses or hostnames';
$lang['IP_hostname'] = 'IP addresses or hostnames';
$lang['Ban_IP_explain'] = 'To specify several different IP addresses or hostnames separate them with commas. To specify a range of IP addresses, separate the start and end with a hyphen (-); to specify a wildcard, use an asterisk (*).';

$lang['Ban_email'] = 'Ban one or more email addresses';
$lang['Ban_email_explain'] = 'To specify more than one email address, separate them with commas. To specify a wildcard username, use * like *@hotmail.com';

$lang['Ban_update_sucessful'] = 'The banlist has been updated successfully';
$lang['Click_return_banadmin'] = 'Click %sHere%s to return to Ban Control';


//
// Configuration
//
$lang['General_Config'] = 'General Configuration';
$lang['Click_return_config'] = 'Click %sHere%s to return to General Configuration';

$lang['Server_name'] = 'Domain Name';
$lang['Script_path'] = 'Script path';
$lang['Server_port'] = 'Server Port';
$lang['Acct_activation'] = 'Enable account activation';
$lang['Acc_Admin'] = 'Admin';

$lang['Allow_BBCode'] = 'Allow BBCode';
$lang['Allow_smilies'] = 'Allow Smilies';
$lang['Admin_email'] = 'Admin Email Address';

//
// Forum Management
//

$lang['Forum_admin'] = 'Forum Administration';
$lang['Forum_admin_explain'] = 'From this panel you can add, delete, edit, re-order and re-synchronise categories and forums.<br />Remember: if you want create subforums, you must create first category in selected forum, after it add forums in the create category.';
$lang['Edit_forum'] = 'Edit forum'; 
$lang['Create_forum'] = 'Create new forum';
$lang['Create_category'] = 'Create new category';
$lang['Config_updated'] = 'Forum Configuration Updated Successfully';
$lang['Move_up'] = 'Move up';
$lang['Move_down'] = 'Move down';
$lang['Resync'] = 'Resync';
$lang['No_mode'] = 'No mode was set';
$lang['Forum_edit_delete_explain'] = 'The form below will allow you to customize all the general board options. For User and Forum configurations use the related links on the left hand side';

$lang['Move_contents'] = 'Move all contents';
$lang['Forum_delete'] = 'Delete Forum';
$lang['Forum_delete_explain'] = 'The form below will allow you to delete a forum (or category) and decide where you want to put all topics (or forums) it contained.';

$lang['Forum_settings'] = 'General Forum Settings';
$lang['Forum_name'] = 'Forum name';
$lang['Forum_desc'] = 'Description';
$lang['Forum_status'] = 'Forum status';
$lang['Forum_pruning'] = 'Auto-pruning';

$lang['prune_freq'] = 'Check for topic age every';
$lang['prune_days'] = 'Remove topics that have not been posted to in';
$lang['Set_prune_data'] = 'You have turned on auto-prune for this forum but did not set a frequency or number of days to prune. Please go back and do so';

$lang['Move_and_Delete'] = 'Move and Delete';

$lang['Delete_all_posts'] = 'Delete all posts';
$lang['Edit_Category'] = 'Edit Category';
$lang['Edit_Category_explain'] = 'Use this form to modify a category\'s name.';

$lang['Forums_updated'] = 'Forum and Category information updated successfully';

$lang['Must_delete_forums'] = 'You need to delete all forums before you can delete this category';

$lang['Click_return_forumadmin'] = 'Click %sHere%s to return to Forum Administration';


//
// Smiley Management
//
$lang['smiley_title'] = 'Smiles Editing Utility';
$lang['smile_desc'] = 'From this page you can add, remove and edit the emoticons or smileys that your users can use in their posts and private messages.';

$lang['smiley_config'] = 'Smiley Configuration';
$lang['smiley_code'] = 'Smiley Code';
$lang['smiley_url'] = 'Smiley Image File';
$lang['smile_add'] = 'Add a new Smiley';
$lang['Smile'] = 'Smile';

$lang['Select_pak'] = 'Select Pack (.pak) File';
$lang['replace_existing'] = 'Replace Existing Smiley';
$lang['keep_existing'] = 'Keep Existing Smiley';
$lang['smiley_import_inst'] = 'You should unzip the smiley package and upload all files to the appropriate Smiley directory for your installation. Then select the correct information in this form to import the smiley pack.';
$lang['smiley_import'] = 'Smiley Pack Import';
$lang['choose_smile_pak'] = 'Choose a Smile Pack .pak file';
$lang['import'] = 'Import Smileys';
$lang['smile_conflicts'] = 'What should be done in case of conflicts';
$lang['del_existing_smileys'] = 'Delete existing smileys before import';
$lang['import_smile_pack'] = 'Import Smiley Pack';
$lang['export_smile_pack'] = 'Create Smiley Pack';
$lang['export_smiles'] = 'To create a smiley pack from your currently installed smileys, click %sHere%s to download the smiles.pak file. Name this file appropriately making sure to keep the .pak file extension. Then create a zip file containing all of your smiley images plus this .pak configuration file.';

$lang['smiley_add_success'] = 'The Smiley was successfully added';
$lang['smiley_edit_success'] = 'The Smiley was successfully updated';
$lang['smiley_import_success'] = 'The Smiley Pack was imported successfully!';
$lang['smiley_del_success'] = 'The Smiley was successfully removed';
$lang['Click_return_smileadmin'] = 'Click %sHere%s to return to Smiley Administration';


//
// User Management
//
$lang['User_admin'] = 'User Administration';
$lang['User_admin_explain'] = 'Here you can change your users\' information and certain options. To modify the users\' permissions, please use the user and group permissions system.';

$lang['Look_up_user'] = 'Look up user';

$lang['Admin_user_fail'] = 'Couldn\'t update the user\'s profile.';
$lang['Admin_user_updated'] = 'The user\'s profile was successfully updated.';
$lang['Click_return_useradmin'] = 'Click %sHere%s to return to User Administration';

$lang['User_delete'] = 'Delete this user';
$lang['User_delete_explain'] = 'Click here to delete this user, this cannot be undone.';
$lang['User_deleted'] = 'User was successfully deleted.';

$lang['User_status'] = 'User is active';
$lang['User_allowpm'] = 'Can send Private Messages';
$lang['User_allowavatar'] = 'Can display avatar';

$lang['Admin_avatar_explain'] = 'Here you can see and delete the user\'s current avatar.';

$lang['User_special'] = 'Special admin-only fields';
$lang['User_special_explain'] = 'These fields are not able to be modified by the users. Here you can set their status and other options that are not given to users.';


//
// Group Management
//
$lang['Group_administration'] = 'Group Administration';
$lang['Group_admin_explain'] = 'From this panel you can administer all your usergroups. You can delete, create and edit existing groups. You may choose moderators, toggle open/closed group status and set the group name and description';
$lang['Updated_group'] = 'The group was successfully updated';
$lang['Added_new_group'] = 'The new group was successfully created';
$lang['Deleted_group'] = 'The group was successfully deleted';
$lang['New_group'] = 'Create new group';
$lang['Edit_group'] = 'Edit group';
$lang['group_name'] = 'Group name';
$lang['group_description'] = 'Group description';
$lang['group_moderator'] = 'Group moderator';
$lang['group_status'] = 'Group status';
$lang['group_open'] = 'Open group';
$lang['group_closed'] = 'Closed group';
$lang['group_hidden'] = 'Hidden group';
$lang['group_delete'] = 'Delete group';
$lang['group_delete_check'] = 'Delete this group';
$lang['No_group_name'] = 'You must specify a name for this group';
$lang['No_group_moderator'] = 'You must specify a moderator for this group';
$lang['delete_group_moderator'] = 'Delete the old group moderator?';
$lang['delete_moderator_explain'] = 'If you\'re changing the group moderator, check this box to remove the old moderator from the group. Otherwise, do not check it, and the user will become a regular member of the group.';
$lang['Click_return_groupsadmin'] = 'Click %sHere%s to return to Group Administration.';
$lang['Select_group'] = 'Select a group';
$lang['Look_up_group'] = 'Look up group';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Forum Prune';
$lang['Forum_Prune_explain'] = 'This will delete any topic which has not been posted to within the number of days you select. If you do not enter a number then all topics will be deleted. It will not remove topics in which polls are still running nor will it remove announcements. You will need to remove these topics manually.';
$lang['Do_Prune'] = 'Do Prune';
$lang['Prune_topics_not_posted'] = 'Prune topics with no replies in this many days';
$lang['Topics_pruned'] = 'Topics pruned';
$lang['Prune_success'] = 'Pruning of forums was successful';


//
// Word censor
//
$lang['Words_title'] = 'Word Censoring';
$lang['Words_explain'] = 'From this control panel you can add, edit, and remove words that will be automatically censored on your forums. In addition people will not be allowed to register with usernames containing these words. Wildcards (*) are accepted in the word field, eg. *test* will match detestable, test* would match testing, *test would match detest.';
$lang['Word'] = 'Word';
$lang['Edit_word_censor'] = 'Edit word censor';
$lang['Replacement'] = 'Replacement';
$lang['Add_new_word'] = 'Add new word';

$lang['Must_enter_word'] = 'You must enter a word and its replacement';
$lang['No_word_selected'] = 'No word selected for editing';

$lang['Word_updated'] = 'The selected word censor has been successfully updated';
$lang['Word_added'] = 'The word censor has been successfully added';
$lang['Word_removed'] = 'The selected word censor has been successfully removed';

$lang['Click_return_wordadmin'] = 'Click %sHere%s to return to Word Censor Administration';

//
// Ranks admin
//

$lang['Ranks_title'] = 'Rank Administration';
$lang['Ranks_explain'] = 'Using this form you can add, edit, view and delete ranks. You can also create custom ranks which can be applied to a user via the user management facility';

$lang['Add_new_rank'] = 'Add new rank';

$lang['Rank_title'] = 'Rank Title';
$lang['Rank_title_e'] = 'If you want use rank image with rank word, you can add before rank name: <b>-#</b>';
$lang['Rank_special'] = 'Set as Special Rank';
$lang['Rank_minimum'] = 'Minimum Posts';
$lang['Rank_image'] = 'Rank Image';
$lang['Rank_image_explain'] = 'Use this to define a small image associated with the rank.<br />Ranks images should be in the /templates/Name_style/images/ranks/ for all installed styles';

$lang['Must_select_rank'] = 'You must select a rank';
$lang['No_assigned_rank'] = 'No special rank assigned';

$lang['Rank_updated'] = 'The rank was successfully updated';
$lang['Rank_added'] = 'The rank was successfully added';
$lang['Rank_removed'] = 'The rank was successfully deleted';
$lang['No_update_ranks'] = 'The rank was successfully deleted. However, user accounts using this rank were not updated. You will need to manually reset the rank on these accounts';

$lang['Click_return_rankadmin'] = 'Click %sHere%s to return to Rank Administration';


//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Username Disallow Control';
$lang['Disallow_explain'] = 'Here you can control usernames which will not be allowed to be used. Disallowed usernames are allowed to contain a wildcard character of *. Please note that you will not be allowed to specify any username that has already been registered, you must first delete that name then disallow it';

$lang['Delete_disallow_title'] = 'Remove a Disallowed Username';
$lang['Delete_disallow_explain'] = 'You can remove a disallowed username by selecting the username from this list and clicking submit';

$lang['Add_disallow_title'] = 'Add a disallowed username';
$lang['Add_disallow_explain'] = 'You can disallow a username using the wildcard character * to match any character';
$lang['Disallowed_deleted'] = 'The disallowed username has been successfully removed';
$lang['Disallow_successful'] = 'The disallowed username has been successfully added';
$lang['Disallowed_already'] = 'The name you entered could not be disallowed. It either already exists in the list, exists in the word censor list, or a matching username is present';

$lang['Click_return_disallowadmin'] = 'Click %sHere%s to return to Disallow Username Administration';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Styles Administration';
$lang['Styles_explain'] = 'Using this facility you can add, remove and manage styles (templates and themes) available to your users';
$lang['Styles_addnew_explain'] = 'The following list contains all the themes that are available for the templates you currently have. The items on this list have not yet been installed into the phpBB database. To install a theme simply click the install link beside an entry';

$lang['Select_template'] = 'Select a Template';

$lang['Style'] = 'Style';
$lang['Template'] = 'Template';
$lang['Install'] = 'Install';
$lang['Download'] = 'Download';

$lang['Edit_theme'] = 'Edit Theme';
$lang['Edit_theme_explain'] = 'In the form below you can edit the settings for the selected theme';

$lang['Create_theme'] = 'Create Theme';
$lang['Create_theme_explain'] = 'Use the form below to create a new theme for a selected template. When entering colours (for which you should use hexadecimal notation) you must not include the initial #, i.e.. CCCCCC is valid, #CCCCCC is not';

$lang['Export_themes'] = 'Export Themes';
$lang['Export_explain'] = 'In this panel you will be able to export the theme data for a selected template. Select the template from the list below and the script will create the theme configuration file and attempt to save it to the selected template directory. If it cannot save the file itself it will give you the option to download it. In order for the script to save the file you must give write access to the webserver for the selected template dir. For more information on this see the phpBB 2 users guide.';

$lang['Theme_installed'] = 'The selected theme has been installed successfully';
$lang['Style_removed'] = 'The selected style has been removed from the database. To fully remove this style from your system you must delete the appropriate style from your templates directory.';
$lang['Theme_info_saved'] = 'The theme information for the selected template has been saved. You should now return the permissions on the theme_info.cfg (and if applicable the selected template directory) to read-only';
$lang['Theme_updated'] = 'The selected theme has been updated. You should now export the new theme settings';
$lang['Theme_created'] = 'Theme created. You should now export the theme to the theme configuration file for safe keeping or use elsewhere';

$lang['Confirm_delete_style'] = 'Are you sure you want to delete this style?';

$lang['Download_theme_cfg'] = 'The exporter could not write the theme information file. Click the button below to download this file with your browser. Once you have downloaded it you can transfer it to the directory containing the template files. You can then package the files for distribution or use elsewhere if you desire';
$lang['No_themes'] = 'The template you selected has no themes attached to it. To create a new theme click the Create New link on the left hand panel';
$lang['No_template_dir'] = 'Could not open the template directory. It may be unreadable by the webserver or may not exist';
$lang['Cannot_remove_style'] = 'You cannot remove the style selected since it is currently the forum default. Please change the default style and try again.';
$lang['Style_exists'] = 'The style name to selected already exists, please go back and choose a different name.';

$lang['Click_return_styleadmin'] = 'Click %sHere%s to return to Style Administration';

$lang['Theme_settings'] = 'Theme Settings';
$lang['Theme_element'] = 'Theme Element';
$lang['Simple_name'] = 'Simple Name';
$lang['Save_Settings'] = 'Save Settings';

$lang['Stylesheet'] = 'CSS Stylesheet';
$lang['Background_image'] = 'Background Image';
$lang['Background_color'] = 'Background Colour';
$lang['Theme_name'] = 'Theme Name';
$lang['Link_color'] = 'Link Colour';
$lang['Text_color'] = 'Text Colour';
$lang['VLink_color'] = 'Visited Link Colour';
$lang['ALink_color'] = 'Active Link Colour';
$lang['HLink_color'] = 'Hover Link Colour';
$lang['Tr_color1'] = 'Table Row Colour 1';
$lang['Tr_color2'] = 'Table Row Colour 2';
$lang['Tr_color3'] = 'Table Row Colour 3';
$lang['Tr_class1'] = 'Table Row Class 1';
$lang['Tr_class2'] = 'Table Row Class 2';
$lang['Tr_class3'] = 'Table Row Class 3';
$lang['Th_color1'] = 'Table Header Colour 1';
$lang['Th_color2'] = 'Table Header Colour 2';
$lang['Th_color3'] = 'Table Header Colour 3';
$lang['Th_class1'] = 'Table Header Class 1';
$lang['Th_class2'] = 'Table Header Class 2';
$lang['Th_class3'] = 'Table Header Class 3';
$lang['Td_color1'] = 'Table Cell Colour 1';
$lang['Td_color2'] = 'Table Cell Colour 2';
$lang['Td_color3'] = 'Table Cell Colour 3';
$lang['Td_class1'] = 'Table Cell Class 1';
$lang['Td_class2'] = 'Table Cell Class 2';
$lang['Td_class3'] = 'Table Cell Class 3';
$lang['fontface1'] = 'Font Face 1';
$lang['fontface2'] = 'Font Face 2';
$lang['fontface3'] = 'Font Face 3';
$lang['fontsize1'] = 'Font Size 1';
$lang['fontsize2'] = 'Font Size 2';
$lang['fontsize3'] = 'Font Size 3';
$lang['fontcolor1'] = 'Font Colour 1';
$lang['fontcolor2'] = 'Font Colour 2';
$lang['fontcolor3'] = 'Font Colour 3';
$lang['span_class1'] = 'Span Class 1';
$lang['span_class2'] = 'Span Class 2';
$lang['span_class3'] = 'Span Class 3';

//
// Install Process
//

$lang['Default_lang'] = 'Default board language';
$lang['ftp_info'] = 'Enter Your FTP Information';
$lang['ftp_username'] = 'Your FTP Username';
$lang['Install'] = 'Install';

//
// Modified addons
//

$lang['Poll Admin'] = 'Polls';
$lang['Poll Results'] = 'Polls result';
$lang['Prune_User_Posts'] = 'Mass prune users posts';
$lang['logs'] = 'Connects logs';
$lang['Categories'] = 'Categories';
$lang['Clear_Cache'] = 'Clear Cache';
$lang['Photo_Album'] = 'Photo Album';

$lang['Status_locked'] = 'Locked';
$lang['Status_unlocked'] = 'Unlocked';
$lang['Sort_alpha'] = 'Topic title';
$lang['Sort_fpdate'] = 'Last post time';
$lang['Sort_ttime'] = 'Topic start time';
$lang['Sort_author'] = 'Topic author name';
$lang['User_allowsig'] = 'Can display signature';
$lang['No_group_action'] = 'No action was specified';
$lang['Download2'] = 'Download';

$lang['Active'] = 'Active';
$lang['modules'] = 'Location of modules';
$lang['clock'] = 'Clock';
$lang['l_search_a'] = 'Settlement of Menu Search';
$lang['none'] = 'disable';
$lang['Deactivate'] = 'Disable';
$lang['Logs'] = 'Logs';
$lang['LogsActions'] = 'Log Actions';
$lang['Log_action_title'] = 'Logs Actions';
$lang['Log_action_explain'] = 'Here you can see the actions done by your moderators/administrators';
$lang['Choose_sort_method'] = 'Choose sorting method';
$lang['Id_log'] = 'Log Id';
$lang['Delete_log'] = 'Delete Log';
$lang['Action'] = 'Action';
$lang['Done_by'] = 'Done By';
$lang['User_ip'] = 'User IP';
$lang['Log_delete'] = 'Log delete successfully.';
$lang['Click_return_admin_log'] = 'Click %sHere%s to return to the Log Actions';
$lang['OverallPermissions'] = 'Overall Permissions';
$lang['OverallPermissions'] = 'Set Overall Permissions for all forums';
$lang['l_logsip_e'] = 'Logging disably by default, you can enable it in Configuration menu. To logs working /admin/admin_logs.php permission must be to write: chmod 777 admin_logs.php';
$lang['l_logsip'] = 'Logs of connections';
$lang['Files'] = 'Files';
$lang['Globalannounce'] = 'Global Announce';
$lang['Group_rank'] = 'Grouprank';
$lang['Group_rank_explain'] = 'Here you can say that this rank only can be used by the selected group. This rank is disabled, if this rank is a special rank.';
$lang['Group_Rank_special'] = 'Special- / Grouprank';
$lang['Group_rank_order'] = 'Grouprank order';
$lang['Group_rank_order_moved'] = 'Group moved successfully.';
$lang['Group_rank_order_alreay_moved'] = 'Group already moved.';
$lang['Group_rank_order_could_not_moved'] = 'These Group couldn\'t moved because it is already at the top / bottom.';
$lang['Group_rank_resynced'] = 'Grouporder was resynced succesfully.';
$lang['Group_rank_order_explain'] = 'If a user is a member of two or more groups with own groupranks, the grouprank of the group, witch is higher in this list, will be shown.';

$lang['Inactive_title'] = 'Inactive Users';
$lang['Deleted_user'] = 'User with ID No. #%d deleted';
$lang['Activate_title'] = 'Account Actions';
$lang['Activate'] = 'Activate';
$lang['Waiting_1'] = '(awaits activation since %d day)';
$lang['Waiting_2'] = '(awaits activation since %d days)';
$lang['No_users'] = 'There is no user who awaits an activation.';
$lang['Total_member'] = '<b>%d</b> user awaits activation.';
$lang['Total_members'] = '<b>%d</b> users await activation.';

$lang['Account_block'] = 'Account block';
$lang['Account_block_explain'] = 'here you can view/set or reset users block information';
$lang['Block_until'] = 'Blocked until: %s';// %s is substituded with the date/time
$lang['Block_by'] = 'Blocked by IP: %s';// %s is substituded with the ip addr.
$lang['Last_block_by'] = 'Last blocked by IP: %s';// %s is substituded with the ip addr.
$lang['Unblock_user'] = 'Unblock user account';
$lang['Block_user'] = 'Block user account for %s min';// %s is substituded with the date/time
$lang['Badlogin_count'] = 'Number of bad log in';

$lang['BM_Show_bans_by'] = 'Shows bans';
$lang['BM_All'] = 'All';
$lang['BM_Show'] = 'Show';
$lang['BM_Banned'] = 'Banned';
$lang['BM_Expires'] = 'Expire';
$lang['BM_By'] = 'Banned by';
$lang['BM_Add_a_new_ban'] = 'Add ban';
$lang['BM_Edit_ban'] = 'Edit ban';
$lang['BM_Delete_selected_bans'] = 'Delete selected bans';
$lang['BM_Private_reason'] = 'Private reason';
$lang['BM_Private_reason_explain'] = 'Private reasons will shows only for admins';
$lang['BM_Public_reason'] = 'Public reason';
$lang['BM_Public_reason_explain'] = 'Public reason will be shows only banned users';
$lang['BM_Generic_reason'] = 'Default reason';
$lang['BM_Mirror_private_reason'] = 'Identically like Private reason';
$lang['BM_Other'] = 'Other/put below';
$lang['BM_Expire_time'] = 'Time expire';
$lang['BM_Expire_time_explain'] = 'You can decide when ban will expire.';
$lang['BM_Never'] = 'Never';
$lang['BM_After_specified_length_of_time'] = 'After:';
$lang['BM_Minutes'] = 'Minutes';
$lang['BM_Weeks'] = 'Weeks';
$lang['BM_Months'] = 'Months';
$lang['BM_Years'] = 'Years';

$lang['Custom_fields'] = 'Profile fields';
$lang['shoutbox_on'] = 'ShoutBox on';
$lang['date_on'] = 'Show date';
$lang['sb_make_links'] = 'Make links';
$lang['sb_links_names'] = 'Username link to profile';
$lang['sb_allow_edit'] = 'Allow Administrators to edit messages';
$lang['sb_allow_edit_m'] = 'Allow Moderators to edit messages';
$lang['sb_allow_edit_all'] = 'Allow to edit own messages';
$lang['sb_allow_delete'] = 'Allow Administrators to delete messages';
$lang['sb_allow_delete_m'] = 'Allow Moderators to delete messages';
$lang['sb_allow_delete_all'] = 'Allow to delete own messages';
$lang['sb_allow_guest'] = 'Allow Quests to send messages';
$lang['sb_allow_guest_view'] = 'Shoutbox only visible for guests';
$lang['sb_allow_users'] = 'Allow registered users to send messages';
$lang['sb_allow_users_view'] = 'Shoutbox only visible for registered users';
$lang['delete_days'] = 'Amount of days after messages will be deleted';
$lang['sb_shout_refresh'] = 'Shoutbox refresh rate.<br>How much time shoutbox to retrieve new messages waiting in the queue? Value in seconds, or 5 = 5 seconds';
$lang['sb_shout_group'] = 'Select the group, which will be able to write in shoutboxie. Hold down the CTRL key and select group of mouse.';
$lang['l_usercall'] = 'When you click in the nick moves his name to the field of writing a message.';
$lang['sb_smilies'] = 'Enable pop-up panel of emoticons.';
$lang['sb_count_msg'] = 'Number of viewed messages';
$lang['sb_text_lenght'] = 'Max messages letters';
$lang['sb_word_lenght'] = 'Max word letters';
$lang['setup_shoutbox'] = 'Shoutbox Configuration';
$lang['shout_size'] = 'ShoutBox size';
$lang['sb_banned_send'] = 'Disallow send messages for user';
$lang['sb_banned_send_e'] = 'User IDs of users who can\'t send messages to ShoutBox. Separate multiple user IDs with commas, for example: <b>18, 124</b>';
$lang['sb_banned_view'] = 'Disallow ShoutBox for user';
$lang['sb_banned_view_e'] = 'User IDs of users who can\'t view and use ShoutBox. Separate multiple user IDs with commas, for example: <b>18, 124</b>';

$lang['disallow_forums'] = 'Disallow write in forums';
$lang['disallow_forums_e'] = 'Disallow this user to send post/topics to selected forums. To select more use Ctrl key';
$lang['can_custom_ranks'] = 'Allow own rank';
$lang['can_custom_color'] = 'Allow own color nick';

$lang['group_count'] = 'Number of required posts';
$lang['group_count_explain'] = 'When users have posted more or equal posts than this value <i>(in any forum)</i> then they will be added to this usergroup<br /> This only applys if "' . $lang['Group_count_enable'] . '" are enabled';
$lang['Group_count_enable'] = 'Users automatic added when posting';
$lang['Group_count_update'] = 'Add/Update new users with posts value more or equal';
$lang['Group_count_delete'] = 'Delete/Update old users';

$lang['Optimize_DB'] = 'Optimize Database';
$lang['Optimize'] = 'Optimize';
$lang['Optimize_explain'] = 'The elimination of data leaves in the database of the empty spaces, to eliminate these empty spaces is necessary to optimize database. Here it is possible to optimize the data in the tables of the database.';
$lang['Optimize_Table'] = 'Table';
$lang['Optimize_Record'] = 'Record';
$lang['Optimize_Type'] = 'Type';
$lang['Optimize_Size'] = 'Size';
$lang['Optimize_Status'] = 'Status';
$lang['Optimize_InvertChecked'] = 'Invert Checked';
$lang['Optimize_success'] = 'Optimize databaze success';
$lang['Optimize_NoTableChecked'] = 'No table checked';

$lang['SQL_Admin_No_Access'] = 'You dont have permission to access this menu.<br /><br />Click %sHERE%s to view details.';
$lang['Category_attachment'] = 'Attached to';
$lang['Category_desc'] = 'Description';
$lang['Attach_forum_wrong'] = 'You can\'t attach a forum to a forum';
$lang['Attach_root_wrong'] = 'You can\'t attach a forum to the forum index';
$lang['Forum_name_missing'] = 'You can\'t create a forum without a name';
$lang['Category_name_missing'] = 'You can\'t create a category without a name';
$lang['Only_forum_for_topics'] = 'Topics can only be found in forums';
$lang['Delete_forum_with_attachment_denied'] = 'You can\'t delete forums having sub-levels';
$lang['Category_delete'] = 'Delete Category';
$lang['Category_delete_explain'] = 'The form below will allow you to delete a category and decide where you want to put all forums and categories it contained.';
$lang['Forum_link_url'] = 'Link URL';
$lang['Forum_link_url_explain'] = 'You can set here an URI to a phpBB prog, or a full URL to an external server.<br />Remember you must write http:// first.';
$lang['Forum_link_internal'] = 'phpBB prog';
$lang['Forum_link_internal_explain'] = 'Choose yes if you invoke a program that stands in the phpBB dirs';
$lang['Forum_link_hit_count'] = 'Hit count';
$lang['Forum_link_hit_count_explain'] = 'Choose yes if you want the board to count and display the number of hit using this link';
$lang['Forum_link_with_attachment_deny'] = 'You can\'t set a forum as a link if it has already sub-levels';
$lang['Forum_link_with_topics_deny'] = 'You can\'t set a forum as a link if it has already topics in';
$lang['Forum_attached_to_link_denied'] = 'You can\'t attach a forum or a category to a forum link';

$lang['mass_smilies_add'] = 'Mass add smilies from catalog';
$lang['Click_to_back_smilies'] = 'Smilies added: <b>%s</b><br /><br />Click %sHERE%s to return smilies management';
$lang['Resync_Stats'] = 'Synchronize';
$lang['Rebuild_search'] = 'Rebuild Search';
$lang['Rebuild_search_explain'] = 'Rebuilding the search table, will take a while but will increase the effectivness of the search function.';
$lang['Time_limit'] = 'Time limit';
$lang['Post_limit'] = 'Post limit';
$lang['Finished'] = 'Finished';
$lang['Refresh_rate'] = 'Refresh rate';
$lang['Percentage_complete'] = 'Percentage complete';
$lang['Resync_page_desc_simple'] = 'Welcome to the Resync Forum Statistics admin module addon. You are currently in <strong>simple mode</strong>. If you click the button below, this script will go through your database and set over; All your Forum\'s Topics and Posts counts as well as the last post made in a forum (as seen on the index), All Topic replies counts and the last post in each topic. If you would like to specify exactly which forums you want to resync and what exactly to resync, you should use the Advanced Mode.<br /><b>Before use this tool you should backup your database!</b>'; 
$lang['Resync_all_ask'] = 'Resync all forums and their topics?';
$lang['Resync_options'] = 'Resync Options';
$lang['Resync_forum_topics'] = 'Forum Topics Count';
$lang['Resync_forum_posts'] = 'Forum Posts Count';
$lang['Resync_forum_last_post'] = 'Forum Last Post';
$lang['Resync_topic_replies'] = 'Topic Replies Counts';
$lang['Resync_topic_last_post'] = 'Topic Last Posts';
$lang['Resync_question'] = 'Resync?';
$lang['Resync_do'] = 'Start Resync';
$lang['Resync_redirect'] = '<br /><br />Return to the <a href="%s">Resync Forum Statistics</a><br /><br />Return to the <a href="%s">Admin Index</a>.';
$lang['Resync_completed'] = 'Congratulations, your forum(s) and their topic(s) are now in sync!';
$lang['Resync_no_forums'] = 'You have no forums to be resynced!';
$lang['resume_rebuild'] = '<b>Attention!</b> exist before session of rebuilding, if you want resume it, click %sHERE%s If you want clear information about before rebuilding, click %sHERE%s (not recommend).';
$lang['value_not'] = 'Value: <b>%s</b> not set, check your query<br /><br />Click %sHERE%s to return';
$lang['confirm_clear'] = 'Values not set, you sure to clear this table ?';
$lang['cannot_execute'] = 'Can not execute: <b>%s</b><br /><br />Click %sHERE%s to return.';
$lang['execute_done'] = 'number records: <b>%s</b><br /><br /><b>%s</b><br /><br />CLICK %sHERE%s to return.';
$lang['mysql_e'] = '<span style="color: red"><b>ATTENTION !!!</b></span> This tool is only for advanced users! Wrong use can failure your forum and database!<br />This tool allow you to execute one or more SQL Query. More than one query separate with <b>;</b><br />Before using this tool save your database backup. Tables prefix: <b>%s</b>';
$lang['execute'] = 'execute';
$lang['access_title'] = 'SQL Permission';
$lang['access_explain'] = 'With security reason acces do SQL menu is only for selected main admins.<br />If you dont have access and you think that is wrong, tell it to main admin.<br />If you are main admin you can add new main admins added with ID`s, if you dont know what that mean, dont think about SQL for security your forum :><br />If you are added admin, bottom is form to change lists admins, if you are main admin and dont see this form, click %s<b>HERE</b>%s you will be able to choose your id (default is 2) as main, and you will can add new lists admins.<br /><span style="color: red"><b>Remember</b></span> after add your ID change name or delete <b>/admin/main_admin.php</b> if not your admins will be able to remove you and add yours ID.';
$lang['change_main_admin'] = 'Your ID (more ID\'s separate with comma)';
$lang['IPSearch_Search_by_IP'] = 'Search by IP Address';
$lang['IPSearch_Enter_IP'] = 'Enter an IP Address';
$lang['IPSearch_Search_Results'] = 'IP Address Search Results';
$lang['IPSearch_Enter_an_IP'] = 'Please go back and enter an IP Address.';
$lang['IPSearch_Again'] = 'Search Again?';
$lang['smiley_del_all_success'] = 'All smilies deleted';
$lang['dell_all_smilies'] = 'Delete all smilies !';
$lang['can_topic_color'] = 'Allow use topic color';
$lang['Uninstall18'] = 'Uninstall Modification';
$lang['uninstall_explain'] = 'Here you can uninstall my modification and restore your phpBB 2.0.x<br />First step you may restore SQL database here second step you may restore your phpBB 2.0.x originall files without \'images\' directory and <b>config.php</b> file.';
$lang['Set_new_version'] = 'Set version of new phpBB2 files';
$lang['Uninstall'] = 'Uninstall';
$lang['confirm_uninstall'] = 'Are you sure to uninstall?';
$lang['uninstall_end'] = '<span class="nav"><b>Uninstall result:</b></span><br /><span class="gensmall">If all queries are blue it mean deinstall succeed, try to delete all additionall files from my modification</span>';
$lang['query_executed'] = 'Query execute';
$lang['query_not_executed'] = 'Query not execute';
$lang['Updates'] = 'Updates';

$lang['Report_post'] = 'Report post';
$lang['Report_config_updated'] = 'The settings of the report post hack are updated successfully.';
$lang['Click_return_report_config'] = 'Click %sHere%s to return to the report post hack configuration.';
$lang['Click_return_report_auth'] = 'Click %sHere%s to return to the report post hack permissions.';
$lang['Click_return_report_auth_select'] = 'Click %shere%s to return to the report post hack permissions select.';
$lang['Report_config'] = 'Report post hack - Configuration';
$lang['Report_config_explain'] = 'Here you can customize all settings.';
$lang['Report_popup_size'] = 'Popup size';
$lang['Report_popup_size_explain'] = 'Here you can edit the height and width the size of report popup ( in pixel )';
$lang['Report_popup_links_target'] = 'Popup target';
$lang['Report_popup_links_target_explain'] = 'Here you can customize in witch window the links in the report popup should be shown';
$lang['Report_popup_links_target_0'] = 'As popup';
$lang['Report_popup_links_target_1'] = 'In new window';
$lang['Report_popup_links_target_2'] = 'In the same window';
$lang['Report_only_admin'] = 'Only for admins';
$lang['Report_only_admin_explain'] = 'If you activate this option, only admin receive the reports';
$lang['Report_no_guests'] = 'Allow no Guests';
$lang['Report_no_guests_explain'] = 'If you activate this option, only registered users can report posts';
$lang['No_group_specified'] = 'No group(s) specified';
$lang['Report_already_auth'] = 'This users / group can\'t be added because he / it is already added.';
$lang['Report_auth_field_explain'] = 'You can spectify multiple users in one go using the appropriate combination of mouse and keyboard for your computer and browser';
$lang['Report_permissions_explain'] = 'Here you can lock the report function for special users or disable the reporting of post from special users.';
$lang['Report_no_auth'] = 'Forbid selected users to report';
$lang['Report_disable'] = 'Disable the reporting of post from special users';
$lang['Back'] = 'Back';
$lang['Remove'] = 'Remove';
$lang['Report_post_disable'] = 'Disable Report posts';
$lang['Prune_users'] = 'Prune users'; 
$lang['Ecat'] = 'Category: Edit';
$lang['Dcat'] = 'Category: Delete';
$lang['Rcat'] = 'Category: Reorder';
$lang['Efile'] = 'File: Edit';
$lang['Dfile'] = 'File: Delete';
$lang['Efield'] = 'Custom Field: Edit';
$lang['Dfield'] = 'Custom Field: Delete';
$lang['wrong_config_parametr'] = 'Server Name can not contain <b>%s</b> !';
$lang['Forum_link'] = 'Link redirection';
$lang['User_allow_helped'] = 'Allow "Helped" points';
$lang['User_allow_helped_e'] = 'Allow or disallow using "Helped" button. Hide value of "Helped" points which obtain this user';
$lang['Admin_notepad'] = 'Admin Notepad';
$lang['confirm_deluser'] = 'Are you sure to delete this user ?';
$lang['Forum_moderate'] = 'Moderate forum';
$lang['Forum_moderate_e'] = 'Posts and topics will be waiting for accept by Moderatot or Administrator';
$lang['Tree_req'] = 'Tree topics only';
$lang['Tree_req_grade'] = 'After how much degrees shift will be decrease.<br />0 - Disable permanently forum topics tree';
$lang['Prune_explain'] = 'Will not remove topics with poll or topics mark as: announce, sticky.';
$lang['No_count'] = 'No count posts';
$lang['Forums_shadow'] = 'Forums not associated to exists category';
$lang['Wrong_category'] = 'Wrong category';
$lang['All_forums'] = 'All forums and category';
$lang['log_file_limit_info'] = 'Log file <b>/admin/admin_logs.'.$phpEx.'</b> is too big (%sMb) to open in browser.<br /><br />File was compressed to: <b>%s</b><br /><br />Click %sHere%s to get it.<br /><br />After downloading you need to remove the file from FTP.';
$lang['log_file_limit_error1'] = 'Error in openning: <b>%s</b>';
$lang['log_file_limit_error2'] = 'Error in save compressedfile: <b>%s</b>';

$lang['Confirm_delete_all'] = 'Are you sure to delete all: <b>%s</b> ?';
$lang['Split'] = 'Split';
$lang['Expire'] = 'Expire';
$lang['Warning_delete'] = 'Remove warning';
$lang['Warning_edit'] = 'Edit warning';
$lang['Object'] = 'Object';
$lang['Group_mail_enable'] = 'Group Moderator can use mass email to the group members ?';
$lang['Forum_trash'] = 'Forum as Trash';
$lang['Forum_trash_e'] = 'If you set Forum as Trash, while removing topic, appear additional button to move topic to the Trash';
$lang['Resync_page_posts'] = 'Users synchronization';
$lang['No_themes'] = 'There is no Themes in database';
$lang['Group_prefix'] = 'Prefix will appear before user name';
$lang['Group_no_unsub'] = 'Deny leave';
$lang['Groups_color_explain'] = 'You can favour groups using color, prefix and text style. You can remove from style data Admin, Junior Admin or Moderator color and ascribe to Group color<br />Styles separate with semicolon example: <b>font-weight: bold; font-size: 16px; text-decoration: line-through; font-style: italic; filter: glow(color=#FF0000);height:10</b> and much moreh (max. 255 chars)';
$lang['Group_style'] = 'Styl';
$lang['Separate_topics'] = 'Separate important topics';
$lang['Separate_total'] = 'separate tables';
$lang['Separate_med'] = 'row';
$lang['Show_global_announce'] = 'Show global announces from other forums';
$lang['Advert_title'] = 'Advertising';
$lang['Show_hosts'] = 'Show hosts';
$lang['Forum_no_split'] = 'No split messages';
$lang['Forum_no_helped'] = 'Disable "Helped"';
$lang['topic_tags'] = 'Topic tags, separate with comma, dont use chars <b>[]</b>';
$lang['sort_methods'] = 'Blocked downwards';

$lang['Statistics_management'] = 'Statistics Modules';
$lang['Statistics_config'] = 'Statistics Configuration';
$lang['Acces_menu_denied'] = 'You have not access to this menu';
$lang['Check-files'] = 'System Check';
$lang['New_info'] = 'Please wait while getting new update information ...';
$lang['forum_compress'] = 'script side';
$lang['server_compress'] = 'server side';
$lang['Name'] = 'Name';
$lang['Files_count'] = 'Files count';
$lang['Rows_count'] = 'Rows count';
$lang['Config_setup'] = 'Configuration backup';
$lang['Config_setup_e'] = 'Here you can save current, load saved, set minimal and optimal forum configuration. It concern main configuration, portal settings, warnings, ShoutBox settings, attachments configuration, configuration, album gallerry and report settings.';
$lang['Default_config'] = 'Set default configuration';
$lang['Max_config'] = 'Set optimal configuration';
$lang['Min_config'] = 'Set minimal configuration';
$lang['Save_config'] = 'Save current configuration';
$lang['Saved_config'] = 'Set configuration saved: %s';
$lang['Permissions_List'] = 'Permissions List';
$lang['Forum_auth_list_explain'] = 'This provides a summary of the authorisation levels of each forum. You can edit these permissions, using "Edit forum permissions" button in the bottom of the page. Remember that changing the permission level of forums will affect which users can carry out the various operations within them.';
$lang['Forum_auth_list_explain_ALL'] = 'All users';
$lang['Forum_auth_list_explain_REG'] = 'All registered users';
$lang['Forum_auth_list_explain_PRIVATE'] = 'Only users granted special permission';
$lang['Forum_auth_list_explain_MOD'] = 'Only moderators of this forum';
$lang['Forum_auth_list_explain_ADMIN'] = 'Only administrators';
$lang['Forum_auth_list_explain_auth_view'] = '%s can view this forum';
$lang['Forum_auth_list_explain_auth_read'] = '%s can read posts in this forum';
$lang['Forum_auth_list_explain_auth_post'] = '%s can post in this forum';
$lang['Forum_auth_list_explain_auth_reply'] = '%s can reply to posts this forum';
$lang['Forum_auth_list_explain_auth_edit'] = '%s can edit posts in this forum';
$lang['Forum_auth_list_explain_auth_delete'] = '%s can delete posts in this forum';
$lang['Forum_auth_list_explain_auth_sticky'] = '%s can post sticky topics in this forum';
$lang['Forum_auth_list_explain_auth_announce'] = '%s can post announcements in this forum';
$lang['Forum_auth_list_explain_auth_vote'] = '%s can vote in polls in this forum';
$lang['Forum_auth_list_explain_auth_pollcreate'] = '%s can create polls in this forum';
$lang['Cancel'] = 'Cancel';
$lang['Edit_permissions'] = 'Edit forum permissions';

$lang['Forum_out_of_date'] = 'Your forum is OUT OF DATE! <a href="%s">Download</a> latest version now!';
$lang['Forum_up_to_date'] = 'Your forum is up to date.';
$lang['Forum_search_for_updates'] = 'Check now';
$lang['Forum_last_update_check'] = 'Last updates check %s';
$lang['Forum_last_update_check_minutes_ago'] = '%d minutes ago';
$lang['Forum_last_update_check_hours_ago'] = '%d hours ago';
$lang['Forum_last_update_check_days_ago'] = '%d days ago';
//
// That's all Folks!
// -------------------------------------------------

?>