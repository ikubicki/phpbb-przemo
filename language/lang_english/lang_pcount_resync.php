<?php
/***************************************************************************
 *                            lang_pcount_resync.php [English]
 *                              -------------------
 *     begin                : Fri Sep 06 2002
 *     copyright            : (C) 2002 Adam Alkins
 *     email                : phpbb@rasadam.com
 *	  $Id: lang_pcount_resync.php,v 1.5 2003/07/12 15:48:42 rasadam Exp $: 
 *    
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['Resync_page_desc_simple'] = 'Welcome the the User Post Count Resyncer. You can Press the resync button to resync all the post counts to their true figure by recounting the amound of actual posts they made.<br /><br />Batch Mode allows you to resync accounts in steps, and is useful for large boards. Batch Mode also provides progress updates while resyncing, therefore if the script dies before finishing (Memory limit reached or timeout), you can resume at that position by entering the batch number (Leave blank to start at the beginning. The Resyncs per batch specifies how many Resyncs it will run per batch. If Batch is set as on and amount is left blank, it will default to 50 per batch.';
$lang['Resync_page_desc_adv'] = 'Welcome the the User Post Count Resyncer. You can select which Forums you would like to Resync either a specific user or all users in the defined forums. Press the resync button to resync the post counts by recounting the amound of actual posts they made based on your criteria.<br /><br />Batch Mode allows you to resync accounts in steps, and is useful for large boards. Batch Mode also provides progress updates while resyncing, therefore if the script dies before finishing (Memory limit reached or timeout), you can resume at that position by entering the batch number (Leave blank to start at the beginning. The Resyncs per batch specifies how many Resyncs it will run per batch. If Batch is set as on and amount is left blank, it will default to 50 per batch.';

$lang['Resync_batch_mode'] = 'Batch Mode';
$lang['Resync_batch_number'] = 'Batch Number';
$lang['Resync_batch_amount'] = 'Resyncs per Batch';
$lang['Resync_finished'] = 'Finished';

$lang['Resync_completed'] = 'Resync Successfully Completed';

$lang['Resync_question'] = 'Resync?';

$lang['Resync_check_all'] = 'Check box to Resync all Users:';

$lang['Resync_do'] = 'Do Resync';

$lang['Resync_redirect'] = '<br /><br />Return to the <a href="%s">Post Count Resyncing Tool</a><br /><br />Return to the <a href="%s">Admin Index</a>.';
$lang['Resync_invalid'] = 'Invalid Settings - No users to Resync';

?>
