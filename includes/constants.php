<?php
/***************************************************************************
 *                               constants.php
 *                            -------------------
 *   begin                : Saturday', Feb 13', 2001
 *   copyright            : ('C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *   modification         : (C) 2005 Przemo www.przemo.org/phpBB2/
 *   date modification    : ver. 1.12.0 2005/10/04 20:20
 *
 *   $Id: constants.php,v 1.47.2.6 2005/10/30 15:17:14 acydburn Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License', or
 *   ('at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// Debug Level
define('DEBUG', 1); // Debugging on
//define('DEBUG', 0); // Debugging off

// User Levels <- Do not change the values of USER or ADMIN
define('DELETED', -1);
define('ANONYMOUS', -1);
define('USER', 0);
define('ADMIN', 1);
define('MOD', 2);

// User related
define('USER_ACTIVATION_NONE', 0);
define('USER_ACTIVATION_SELF', 1);
define('USER_ACTIVATION_ADMIN', 2);
define('USER_AVATAR_NONE', 0);
define('USER_AVATAR_UPLOAD', 1);
define('USER_AVATAR_REMOTE', 2);
define('USER_AVATAR_GALLERY', 3);

// Group settings
define('GROUP_OPEN', 0);
define('GROUP_CLOSED', 1);
define('GROUP_HIDDEN', 2);

// Forum state
define('FORUM_UNLOCKED', 0);
define('FORUM_LOCKED', 1);


// Topic status
define('TOPIC_UNLOCKED', 0);
define('TOPIC_LOCKED', 1);
define('TOPIC_MOVED', 2);
define('TOPIC_WATCH_NOTIFIED', 1);
define('TOPIC_WATCH_UN_NOTIFIED', 0);


// Topic types
define('POST_NORMAL', 0);
define('POST_STICKY', 1);
define('POST_ANNOUNCE', 2);
define('POST_GLOBAL_ANNOUNCE', 3);

// Topic posts actions
define('UNLOCKED', 1);
define('LOCKED', 2);
define('MOVED', 3);
define('EXPIRED', 4);
define('EDITED', 5);

// SQL codes
define('BEGIN_TRANSACTION', 1);
define('END_TRANSACTION', 2);

// Error codes
define('GENERAL_MESSAGE', 200);
define('GENERAL_ERROR', 202);
define('CRITICAL_MESSAGE', 203);
define('CRITICAL_ERROR', 204);


// Private messaging
define('PRIVMSGS_READ_MAIL', 0);
define('PRIVMSGS_NEW_MAIL', 1);
define('PRIVMSGS_SENT_MAIL', 2);
define('PRIVMSGS_SAVED_IN_MAIL', 3);
define('PRIVMSGS_SAVED_OUT_MAIL', 4);
define('PRIVMSGS_UNREAD_MAIL', 5);
define('PRIVMSGS_SERVICE', 6);

// URL PARAMETERS
define('POST_TOPIC_URL', 't');
define('POST_CAT_URL', 'c');
define('POST_FORUM_URL', 'f');
define('POST_USERS_URL', 'u');
define('POST_POST_URL', 'p');
define('POST_GROUPS_URL', 'g');

define('CR_TIME', time());

// Forum unique hash
$hash_1 = 'VUc5M1pYSmxaQ0JpZVNBOFlTQm9jbVZtUFNKb2RIUndPaTh2ZDNkM0xuQm9jR0ppTG1OdmJTSWdkR0Z5WjJWMFBTSmZZbXhoYm1zaUlHsiTnNZWE56UFNKamIzQjVjbWxuYUhRaVBuQm9jRUpDUEM5aFBpQnRiMlJwWm1sbFpDQmllU0E4WVNCb2NtVm1QU0pvZEhSd09pOHZkM2QzTG5CeWVtVnRieTV2Y21jdmNHaHdRa0l5THlJZ1kyeGhjM005SW1OdmNIbHlhV2RvZENJZ2RHRnlaMlYwUFNKZllteGhibXNpUGxCeWVtVnRiend2WVQ0Z0ptTnZjSGs3SURJd01ETWdjR2h3UWtJZ1IzSnZkWEE9';
$hash_2 = 'UENFdExTQlFiM2RsY21Wa0lHSjVJSEJvY0VKQ0lHMXZaR2xtYVdWa0lIWXhMamtnWW5rZ2NISjZaVzF2SUNnZ2FIUjBjRG92TDNkM2R5NXdjbnBsYlc4dWIzSm5MM0JvY0VKQ01pOGdLU0F0TFQ0PQ==';

// Session parameters
define('SESSION_METHOD_COOKIE', 100);
define('SESSION_METHOD_GET', 101);

// Page numbers for session handling
define('PAGE_INDEX', 0);
define('PAGE_LOGIN', -1);
define('PAGE_SEARCH', -2);
define('PAGE_REGISTER', -3);
define('PAGE_PROFILE', -4);
define('PAGE_VIEWONLINE', -6);
define('PAGE_VIEWMEMBERS', -7);
define('PAGE_FAQ', -8);
define('PAGE_POSTING', -9);
define('PAGE_PRIVMSGS', -10);
define('PAGE_GROUPCP', -11);
define('PAGE_DOWNLOAD', -12);
define('PAGE_TOPIC_VIEW', -13);
define('PAGE_IGNORE', -14);
define('PAGE_STAFF', -15);
define('PAGE_STATISTICS', -16);
define('PAGE_SHOUTBOX', -17);
define('PAGE_ADMIN_PANEL', -18);

// Auth settings
define('AUTH_LIST_ALL', 0);
define('AUTH_ALL', 0);
define('AUTH_REG', 1);
define('AUTH_ACL', 2);
define('AUTH_MOD', 3);
define('AUTH_ADMIN', 5);
define('AUTH_VIEW', 1);
define('AUTH_READ', 2);
define('AUTH_POST', 3);
define('AUTH_REPLY', 4);
define('AUTH_EDIT', 5);
define('AUTH_DELETE', 6);
define('AUTH_ANNOUNCE', 7);
define('AUTH_STICKY', 8);
define('AUTH_POLLCREATE', 9);
define('AUTH_VOTE', 10);
define('AUTH_ATTACH', 11);
define('AUTH_GLOBALANNOUNCE', 12);

// Table names
define('ADV_TABLE', $table_prefix . 'advertisement');
define('ADV_PERSON_TABLE', $table_prefix . 'adv_person');
define('ANTI_ROBOT_TABLE', $table_prefix . 'anti_robotic_reg');
define('AUTH_ACCESS_TABLE', $table_prefix . 'auth_access');
define('ATTACH_CONFIG_TABLE', $table_prefix . 'attachments_config');
define('BANLIST_TABLE', $table_prefix . 'banlist');
define('CATEGORIES_TABLE', $table_prefix . 'categories');
define('CONFIG_TABLE', $table_prefix . 'config');
define('DISALLOW_TABLE', $table_prefix . 'disallow');
define('FIELDS_TABLE', $table_prefix . 'profile_fields');
define('FORUMS_TABLE', $table_prefix . 'forums');
define('GROUPS_TABLE', $table_prefix . 'groups');
define('IGNORE_TABLE', $table_prefix . 'ignores');
define('JR_ADMIN_TABLE', $table_prefix . 'jr_admin_users');
define('LOGS_TABLE', $table_prefix . 'logs');
define('MODULES_TABLE', $table_prefix . 'stats_modules');
define('MASS_EMAIL', $table_prefix . 'mass_email');
define('READ_HIST_TABLE', $table_prefix . 'read_history');
define('POSTS_TABLE', $table_prefix . 'posts');
define('POSTS_TEXT_TABLE', $table_prefix . 'posts_text');
define('POSTS_HISTORY_TABLE', $table_prefix . 'posts_text_history');
define('PRIVMSGS_TABLE', $table_prefix . 'privmsgs');
define('PRIVMSGS_TEXT_TABLE', $table_prefix . 'privmsgs_text');
define('PRUNE_TABLE', $table_prefix . 'forum_prune');
define('RANKS_TABLE', $table_prefix . 'ranks');
define('SEARCH_TABLE', $table_prefix . 'search_results');
define('SEARCH_WORD_TABLE', $table_prefix . 'search_wordlist');
define('SEARCH_MATCH_TABLE', $table_prefix . 'search_wordmatch');
define('SESSIONS_TABLE', $table_prefix . 'sessions');
define('SESSIONS_KEYS_TABLE', $table_prefix.'sessions_keys');
define('SMILIES_TABLE', $table_prefix . 'smilies');
define('SHOUTBOX_CONFIG_TABLE', $table_prefix . 'shoutbox_config');
define('SHOUTBOX_TABLE', $table_prefix . 'shoutbox');
define('STATS_CONFIG_TABLE', $table_prefix . 'stats_config');
define('THEMES_TABLE', $table_prefix . 'themes');
define('THEMES_NAME_TABLE', $table_prefix . 'themes_name');
define('TOPICS_TABLE', $table_prefix . 'topics');
define('TOPICS_IGNORE_TABLE', $table_prefix . 'topics_ignore');
define('TOPICS_WATCH_TABLE', $table_prefix . 'topics_watch');
define('TOPIC_VIEW_TABLE', $table_prefix . 'topic_view');
define('USER_GROUP_TABLE', $table_prefix . 'user_group');
define('USERS_TABLE', $table_prefix . 'users');
define('WARNINGS_TABLE', $table_prefix . 'users_warnings');
define('WORDS_TABLE', $table_prefix . 'words');
define('VOTE_DESC_TABLE', $table_prefix . 'vote_desc');
define('VOTE_RESULTS_TABLE', $table_prefix . 'vote_results');
define('VOTE_USERS_TABLE', $table_prefix . 'vote_voters');

?>