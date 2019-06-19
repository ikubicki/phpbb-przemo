<?php
/***************************************************************************
 *                          lang_main.php [English]
 *                          -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2001 The phpBB Group
 *     email                : support@phpbb.com
 *     modification         : (C) 2003 Przemo http://www.przemo.org
 *     date modification    : ver. 1.12.4 2005/12/10 1:14
 *
 ****************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 ***************************************************************************/

//
// CONTRIBUTORS:
//	 Add your details here if wanted, e.g. Name, username, email address, website
// 2002-08-27  Philip M. White        - fixed many grammar problems
//

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

$lang['ENCODING'] = 'iso-8859-1';
$lang['DIRECTION'] = 'ltr';
$lang['DATE_FORMAT'] = 'd M Y'; // This should be changed to the default date format for your language, php date() format

// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.
// $lang['TRANSLATION'] = '';

//
// Common, these terms are used
// extensively on several pages
//

$lang['Forum'] = 'Forum';
$lang['Category'] = 'Category';
$lang['Topic'] = 'Topic';
$lang['Topics'] = 'Topics';
$lang['Replies'] = 'Replies';
$lang['Views'] = 'Views';
$lang['Post'] = 'Post';
$lang['Posts'] = 'Posts';
$lang['Posted'] = 'Posted';
$lang['Username'] = 'Username';
$lang['Password'] = 'Password';
$lang['Email'] = 'Email';
$lang['Poster'] = 'Poster';
$lang['Author'] = 'Author';
$lang['Time'] = 'Time';
$lang['Hours'] = 'Hours';
$lang['Message'] = 'Message';

$lang['1_Day'] = '1 Day';
$lang['7_Days'] = '7 Days';
$lang['2_Weeks'] = '2 Weeks';
$lang['1_Month'] = '1 Month';
$lang['3_Months'] = '3 Months';
$lang['6_Months'] = '6 Months';
$lang['1_Year'] = '1 Year';

$lang['Jump_to'] = 'Jump to';
$lang['Submit'] = 'Submit';
$lang['Reset'] = 'Reset';
$lang['Cancel'] = 'Cancel';
$lang['Preview'] = 'Preview';
$lang['Confirm'] = 'Confirm';
$lang['Yes'] = 'Yes';
$lang['No'] = 'No';
$lang['Enabled'] = 'Enabled';
$lang['Disabled'] = 'Disabled';
$lang['Error'] = 'Error';

$lang['Next'] = 'Next';
$lang['Previous'] = 'Previous';
$lang['Goto_page'] = 'Goto page';
$lang['Joined'] = 'Joined';
$lang['IP_Address'] = 'IP Address';

$lang['Select_forum'] = 'Select a forum';
$lang['View_newest_post'] = 'View newest post';
$lang['Page_of'] = 'Page <b>%d</b> of <b>%d</b>'; // Replaces with: Page 1 of 2 for example

$lang['ICQ'] = 'ICQ Number';
$lang['AIM'] = 'Number Gadu-Gadu';
$lang['MSNM'] = 'MSN Messenger';
$lang['YIM'] = 'Yahoo Messenger';

$lang['Forum_Index'] = '%s Forum Index'; // eg. sitename Forum Index, %s can be removed if you prefer

$lang['Post_new_topic'] = 'Post new topic';
$lang['Reply_to_topic'] = 'Reply to topic';
$lang['Reply_with_quote'] = 'Reply with quote';

$lang['Click_return_topic'] = 'Click %sHere%s to return to the topic'; // %s's here are for uris, do not remove!
$lang['Click_return_forum'] = 'Click %sHere%s to return to the forum';
$lang['Click_view_message'] = 'Click %sHere%s to view your message';
$lang['Click_return_group'] = 'Click %sHere%s to return to group information';

$lang['Admin_panel'] = 'Go to Administration Panel';

$lang['Board_disable'] = 'This board is currently unavailable.';

//
// Global Header strings
//
$lang['Registered_users'] = 'Registered Users:';
$lang['Browsing_forum'] = 'Users browsing this forum:';
$lang['Online_users_zero_total'] = 'In total there are <b>0</b> users online :: ';
$lang['Online_users_total'] = 'In total there are <b>%d</b> users online :: ';
$lang['Online_user_total'] = 'In total there is <b>%d</b> user online :: ';
$lang['Reg_users_zero_total'] = '0 Registered, ';
$lang['Reg_users_total'] = '%d Registered, ';
$lang['Reg_user_total'] = '%d Registered, ';
$lang['Hidden_users_zero_total'] = '0 Hidden and ';
$lang['Hidden_user_total'] = '%d Hidden and ';
$lang['Hidden_users_total'] = '%d Hidden and ';
$lang['Guest_users_zero_total'] = '0 Guests';
$lang['Guest_users_total'] = '%d Guests';
$lang['Guest_user_total'] = '%d Guest';
$lang['Record_online_users'] = 'Most users ever online was <b>%s</b> on %s'; // first %s = number of users, second %s is the date.

$lang['Admin_online_color'] = 'Administrator';
$lang['Mod_online_color'] = 'Moderator';

$lang['You_last_visit'] = 'You last visited on %s'; // %s replaced by date/time
$lang['Current_time'] = 'The time now is %s'; // %s replaced by time

$lang['Flood_Search'] = 'You cannot search so fast. Wait a few seconds and try again or refresh page.';
$lang['Search_your_posts'] = 'View your posts';
$lang['Search_unanswered'] = 'View unanswered posts';

$lang['Register'] = 'Register';
$lang['Profile'] = 'Profile';
$lang['Edit_profile'] = 'Edit your profile';
$lang['Search'] = 'Search';
$lang['Memberlist'] = 'Memberlist';
$lang['FAQ'] = 'FAQ';
$lang['BBCode_guide'] = 'BBCode Guide';
$lang['Usergroups'] = 'Usergroups';
$lang['Last_Post'] = 'Last Post';
$lang['Moderator'] = 'Moderator';
$lang['Moderators'] = 'Moderators';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'Our users have posted a total of <b>0</b> articles'; // Number of posts
$lang['Posted_articles_total'] = 'Our users have posted a total of <b>%d</b> articles'; // Number of posts
$lang['Posted_article_total'] = 'Our users have posted a total of <b>%d</b> article'; // Number of posts
$lang['Registered_users_zero_total'] = 'We have <b>0</b> registered users'; // # registered users
$lang['Registered_users_total'] = 'We have <b>%d</b> registered users'; // # registered users
$lang['Registered_user_total'] = 'We have <b>%d</b> registered user'; // # registered users
$lang['Newest_user'] = 'The newest registered user is <b>%s%s%s</b>'; // a href, username, /a 

$lang['No_new_posts'] = 'No new posts';
$lang['New_posts'] = 'New posts';
$lang['New_post'] = 'New post';
$lang['No_new_posts_hot'] = 'No new posts [ Popular ]';
$lang['New_posts_hot'] = 'New posts [ Popular ]';
$lang['No_new_posts_locked'] = 'No new posts [ Locked ]';
$lang['New_posts_locked'] = 'New posts [ Locked ]';
$lang['Forum_is_locked'] = 'Forum is locked';


//
// Login
//
$lang['Login'] = 'Log in';
$lang['Logout'] = 'Log out';

$lang['Forgotten_password'] = 'I forgot my password';

$lang['Log_me_in'] = 'Log me on automatically each visit';

//
// Index page
//
$lang['No_Posts'] = 'No Posts';
$lang['No_forums'] = 'This board has no forums';

$lang['Private_Message'] = 'Private Message';
$lang['Private_Messages'] = 'Private Messages';
$lang['Who_is_Online'] = 'Who is Online';

$lang['Mark_all_forums'] = 'Mark all forums read';
$lang['Forums_marked_read'] = 'All forums have been marked read';


//
// Viewforum
//
$lang['View_forum'] = 'View Forum';

$lang['Forum_not_exist'] = 'The forum you selected does not exist.';

$lang['Display_topics'] = 'Display topics from previous';

$lang['Topic_Announcement'] = '<b>Announcement:</b>';
$lang['Topic_Sticky'] = '<b>Sticky:</b>';
$lang['Topic_Moved'] = '<b>Moved:</b>';
$lang['Topic_Poll'] = '<b>[ Poll ]</b>';

$lang['Mark_all_topics'] = 'Mark all topics read';
$lang['Topics_marked_read'] = 'The topics for this forum have now been marked read';

$lang['Rules_post_can'] = 'You <b>can</b> post new topics in this forum';
$lang['Rules_post_cannot'] = 'You <b>cannot</b> post new topics in this forum';
$lang['Rules_reply_can'] = 'You <b>can</b> reply to topics in this forum';
$lang['Rules_reply_cannot'] = 'You <b>cannot</b> reply to topics in this forum';
$lang['Rules_edit_can'] = 'You <b>can</b> edit your posts in this forum';
$lang['Rules_edit_cannot'] = 'You <b>cannot</b> edit your posts in this forum';
$lang['Rules_delete_can'] = 'You <b>can</b> delete your posts in this forum';
$lang['Rules_delete_cannot'] = 'You <b>cannot</b> delete your posts in this forum';
$lang['Rules_vote_can'] = 'You <b>can</b> vote in polls in this forum';
$lang['Rules_vote_cannot'] = 'You <b>cannot</b> vote in polls in this forum';
$lang['Rules_moderate'] = 'You <b>can</b> %smoderate this forum%s'; // %s replaced by a href links, do not remove! 

$lang['No_topics_post_one'] = 'There are no posts in this forum.<br />Click on the <b>Post New Topic</b> link on this page to post one.';
$lang['No_topics_post_one_ignore'] = 'There are no topics which are not ignored, click "Show ignore topics" link to see all topics';

//
// Viewtopic
//
$lang['View_topic'] = 'View topic';

$lang['Guest'] = 'Guest';
$lang['Post_subject'] = 'Post subject';
$lang['View_next_topic'] = 'Next topic';
$lang['View_previous_topic'] = 'Previous topic';
$lang['Submit_vote'] = 'Submit Vote';
$lang['View_results'] = 'View Results';

$lang['No_newer_topics'] = 'There are no newer topics in this forum';
$lang['No_older_topics'] = 'There are no older topics in this forum';
$lang['No_posts_topic'] = 'No posts exist for this topic';

$lang['Display_posts'] = 'Display posts from previous';
$lang['All_Posts'] = 'All Posts';
$lang['Newest_First'] = 'Newest First';
$lang['Oldest_First'] = 'Oldest First';

$lang['Back_to_top'] = 'Back to top';

$lang['Read_profile'] = 'View user\'s profile';
$lang['Visit_website'] = 'Visit poster\'s website';
$lang['Edit_delete_post'] = 'Edit/Delete this post';
$lang['View_IP'] = 'View IP address of poster';
$lang['Delete_post'] = 'Delete this post';

$lang['wrote'] = 'wrote'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = 'Quote'; // comes before bbcode quote output.
$lang['Code'] = 'Code'; // comes before bbcode code output.

$lang['Edited_time_total'] = 'Last edited by %s on %s; edited %d time in total'; // Last edited by me on 12 Oct 2001; edited 1 time in total
$lang['Edited_times_total'] = 'Last edited by %s on %s; edited %d times in total'; // Last edited by me on 12 Oct 2001; edited 2 times in total

$lang['Lock_topic'] = 'Lock this topic';
$lang['Unlock_topic'] = 'Unlock this topic';
$lang['Move_topic'] = 'Move this topic';
$lang['Delete_topic'] = 'Delete this topic';
$lang['Split_topic'] = 'Split this topic';

$lang['Stop_watching_topic'] = 'Stop watching this topic';
$lang['Start_watching_topic'] = 'Watch this topic for replies';
$lang['No_longer_watching'] = 'You are no longer watching this topic';
$lang['You_are_watching'] = 'You are now watching this topic';

$lang['Total_votes'] = 'Total Votes';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Message body';
$lang['Topic_review'] = 'Topic review';

$lang['No_post_mode'] = 'No post mode specified';

$lang['Post_a_new_topic'] = 'Post a new topic';
$lang['Post_a_reply'] = 'Post a reply';
$lang['Post_topic_as'] = 'Post topic as';
$lang['Edit_Post'] = 'Edit post';
$lang['Options'] = 'Options';

$lang['Post_Announcement'] = 'Announcement';
$lang['Post_Sticky'] = 'Sticky';
$lang['Post_Normal'] = 'Normal';

$lang['Confirm_delete'] = 'Are you sure you want to delete this post?';
$lang['Confirm_delete_poll'] = 'Are you sure you want to delete this poll?';

$lang['Flood_Error'] = 'You cannot make another post so soon after your last; please try again in a short while.';
$lang['Empty_subject'] = 'You must specify a subject when posting a new topic.';
$lang['Empty_message'] = 'You must enter a message when posting.';
$lang['Forum_locked'] = 'This forum is locked: you cannot post, reply to, or edit topics.';
$lang['Topic_locked'] = 'This topic is locked: you cannot edit posts or make replies.';
$lang['No_topic_id'] = 'You must select a topic to reply to';
$lang['No_valid_mode'] = 'You can only post, reply, edit, or quote messages. Please return and try again.';
$lang['No_such_post'] = 'There is no such post or topic. Please return and try again.';
$lang['Edit_own_posts'] = 'Sorry, but you can only edit your own posts.';
$lang['Delete_own_posts'] = 'Sorry, but you can only delete your own posts.';
$lang['Cannot_delete_replied'] = 'Sorry, but you may not delete posts that have been replied to.';
$lang['Cannot_delete_poll'] = 'Sorry, but you cannot delete an active poll.';
$lang['Empty_poll_title'] = 'You must enter a title for your poll.';
$lang['To_few_poll_options'] = 'You must enter at least two poll options.';
$lang['To_many_poll_options'] = 'You have tried to enter too many poll options.';
$lang['Already_voted'] = 'You have already voted in this poll.';
$lang['No_vote_option'] = 'You must specify an option when voting.';

$lang['Add_poll'] = 'Add a Poll';
$lang['Add_poll_explain'] = 'If you do not want to add a poll to your topic, leave the fields blank.';
$lang['Poll_question'] = 'Poll question';
$lang['Poll_option'] = 'Poll option';
$lang['Add_option'] = 'Add option';
$lang['Update'] = 'Update';
$lang['Delete'] = 'Delete';
$lang['Poll_for'] = 'Run poll for';
$lang['Days'] = 'Days';
$lang['Poll_for_explain'] = '[ Enter 0 or leave blank for a never ending poll ]';
$lang['Delete_poll'] = 'Delete Poll';

$lang['Disable_HTML_post'] = 'Disable HTML in this post';
$lang['Disable_BBCode_post'] = 'Disable BBCode in this post';
$lang['Disable_Smilies_post'] = 'Disable Smilies in this post';

$lang['HTML_is_ON'] = 'HTML is <u>ON</u>';
$lang['HTML_is_OFF'] = 'HTML is <u>OFF</u>';
$lang['BBCode_is_ON'] = '%sBBCode%s is <u>ON</u>';
$lang['BBCode_is_OFF'] = '%sBBCode%s is <u>OFF</u>';
$lang['Smilies_are_ON'] = 'Smilies are <u>ON</u>';
$lang['Smilies_are_OFF'] = 'Smilies are <u>OFF</u>';

$lang['Attach_signature'] = 'Attach signature (signatures can be changed in profile)';
$lang['Notify'] = 'Notify me when a reply is posted';

$lang['Stored'] = 'Your message has been entered successfully.';
$lang['Deleted'] = 'Your message has been deleted successfully.';
$lang['Poll_delete'] = 'Your poll has been deleted successfully.';
$lang['Vote_cast'] = 'Your vote has been cast.';

$lang['Topic_reply_notification'] = 'Topic Reply Notification';

$lang['bbcode_b_help'] = 'Bold text: [b]text[/b] (alt+b)';
$lang['bbcode_i_help'] = 'Italic text: [i]text[/i] (alt+i)';
$lang['bbcode_u_help'] = 'Underline text: [u]text[/u] (alt+u)';
$lang['bbcode_q_help'] = 'Quote text: [quote]text[/quote] (alt+q)';
$lang['bbcode_c_help'] = 'Code display: [code]code[/code] (alt+c)';
$lang['bbcode_l_help'] = 'List: [list]text[/list] (alt+l)';
$lang['bbcode_o_help'] = 'Ordered list: [list=]text[/list] (alt+o)';
$lang['bbcode_p_help'] = 'Insert image: [img]http://image_url[/img] (alt+p)';
$lang['bbcode_w_help'] = 'Insert URL: [url]http://url[/url] or [url=http://url]URL text[/url] (alt+w)';
$lang['bbcode_a_help'] = 'Close all open bbCode tags';
$lang['bbcode_s_help'] = 'Font color: [color=red]text[/color] Tip: you can also use color=#FF0000';
$lang['bbcode_f_help'] = 'Font size: [size=x-small]small text[/size]';

$lang['Emoticons'] = 'Emoticons';
$lang['More_emoticons'] = 'View more Emoticons';

$lang['Font_color'] = 'Font colour';
$lang['color_default'] = 'Default';
$lang['color_dark_red'] = 'Dark Red';
$lang['color_red'] = 'Red';
$lang['color_orange'] = 'Orange';
$lang['color_brown'] = 'Brown';
$lang['color_yellow'] = 'Yellow';
$lang['color_green'] = 'Green';
$lang['color_olive'] = 'Olive';
$lang['color_cyan'] = 'Cyan';
$lang['color_blue'] = 'Blue';
$lang['color_dark_blue'] = 'Dark Blue';
$lang['color_indigo'] = 'Indigo';
$lang['color_violet'] = 'Violet';
$lang['color_white'] = 'White';
$lang['color_black'] = 'Black';

$lang['Font_size'] = 'Font size';
$lang['font_tiny'] = 'Tiny';
$lang['font_small'] = 'Small';
$lang['font_normal'] = 'Normal';
$lang['font_large'] = 'Large';
$lang['font_huge'] = 'Huge';

$lang['Close_Tags'] = 'Close Tags';
$lang['Styles_tip'] = 'Tip: Styles can be applied quickly to selected text';


//
// Private Messaging
//
	$lang['Private_Messaging'] = 'Private Messaging';

$lang['Login_check_pm'] = 'Log in to check your private messages';
$lang['New_pms'] = 'You have %d <span class=\'pm\'>*<b>new</b>*</span> messages';
$lang['New_pm'] = 'You have %d <span class=\'pm\'>*<b>new</b>*</span> message';
$lang['No_new_pm'] = 'You have no new messages';
$lang['Unread_pms'] = 'You have %d unread messages';
$lang['Unread_pm'] = 'You have %d unread message';
$lang['No_unread_pm'] = 'You have no unread messages';
$lang['You_new_pm'] = 'A new private message is waiting for you in your Inbox';
$lang['You_new_pms'] = 'New private messages are waiting for you in your Inbox';
$lang['You_no_new_pm'] = 'No new private messages are waiting for you';
$lang['Unread_message'] = 'Unread message';
$lang['Read_message'] = 'Read message';

$lang['Read_pm'] = 'Read message';
$lang['Post_new_pm'] = 'Post message';
$lang['Post_reply_pm'] = 'Reply to message';
$lang['Post_quote_pm'] = 'Quote message';
$lang['Edit_pm'] = 'Edit message';

$lang['Inbox'] = 'Inbox';
$lang['Outbox'] = 'Outbox';
$lang['Savebox'] = 'Savebox';
$lang['Sentbox'] = 'Sentbox';
$lang['Flag'] = 'Flag';
$lang['Subject'] = 'Subject';
$lang['From'] = 'From';
$lang['To'] = 'To';
$lang['Date'] = 'Date';
$lang['Mark'] = 'Mark';
$lang['Sent'] = 'Sent';
$lang['Saved'] = 'Saved';
$lang['Delete_marked'] = 'Delete Marked';
$lang['Delete_all'] = 'Delete All';
$lang['Save_marked'] = 'Save Marked';
$lang['Save_message'] = 'Save Message';
$lang['Delete_message'] = 'Delete Message';

$lang['Display_messages'] = 'Display messages from previous';
$lang['All_Messages'] = 'All Messages';

$lang['No_messages_folder'] = 'You have no messages in this folder';

$lang['PM_disabled'] = 'Private messaging has been disabled on this board.';
$lang['Cannot_send_privmsg'] = 'Sorry, but the administrator has prevented you from sending private messages.';
$lang['No_to_user'] = 'You must specify a username to whom to send this message.';

$lang['Disable_HTML_pm'] = 'Disable HTML in this message';
$lang['Disable_BBCode_pm'] = 'Disable BBCode in this message';
$lang['Disable_Smilies_pm'] = 'Disable Smilies in this message';

$lang['Message_sent'] = 'Your message has been sent.';

$lang['Click_return_inbox'] = 'Click %sHere%s to return to your Inbox';
$lang['Click_return_index'] = 'Click %sHere%s to return to the Index';

$lang['Send_a_new_message'] = 'Send a new private message';
$lang['Send_a_reply'] = 'Reply to a private message';
$lang['Edit_message'] = 'Edit private message';

$lang['Notification_subject'] = 'New Private Message has arrived';

$lang['Find_username'] = 'Find a username';
$lang['Find'] = 'Find';
$lang['No_match'] = 'No matches found.';

$lang['No_post_id'] = 'No post ID was specified';
$lang['No_such_folder'] = 'No such folder exists';

$lang['Mark_all'] = 'Mark all';
$lang['Unmark_all'] = 'Unmark all';

$lang['Confirm_delete_pm'] = 'Are you sure you want to delete this message?';
$lang['Confirm_delete_pms'] = 'Are you sure you want to delete these messages?';

$lang['Inbox_size'] = 'Your Inbox is %d%% full';
$lang['Sentbox_size'] = 'Your Sentbox is %d%% full'; 
$lang['Savebox_size'] = 'Your Savebox is %d%% full';

$lang['Click_view_privmsg'] = 'Click %sHere%s to visit your Inbox';


//
// Profiles/Registration
//

$lang['Preferences'] = 'Preferences';

$lang['Website'] = 'Website';
$lang['Location'] = 'Location';
$lang['Email_address'] = 'E-mail address';
$lang['Send_private_message'] = 'Send private message';
$lang['Interests'] = 'Interests';
$lang['Poster_rank'] = 'Poster rank';

$lang['Total_posts'] = 'Total posts';
$lang['User_post_pct_stats'] = '%.2f%% of total';
$lang['User_post_day_stats'] = '%.2f posts per day';
$lang['Search_user_posts'] = 'Find all posts by %s';

$lang['No_user_id_specified'] = 'That user does not exist.';

$lang['Date_format'] = 'Date format';

$lang['Confirm_password'] = 'Confirm password';

$lang['Avatar'] = 'Avatar';

$lang['No_user_specified'] = 'No user was specified';
$lang['Flood_email_limit'] = 'You cannot send another e-mail at this time. Try again later.';
$lang['Email_sent'] = 'The e-mail has been sent.';
$lang['Send_email'] = 'Send e-mail';
$lang['Empty_subject_email'] = 'You must specify a subject for the e-mail.';
$lang['Empty_message_email'] = 'You must enter a message to be e-mailed.';

//
// Memberslist
//
$lang['Select_sort_method'] = 'Select sort method';
$lang['Sort'] = 'Sort';
$lang['Sort_Top_Ten'] = 'Top ten posters';
$lang['Sort_Joined'] = 'Joined date';
$lang['Sort_Username'] = 'Username';
$lang['Sort_Ascending'] = 'Ascending';
$lang['Sort_Descending'] = 'Descending';

//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Group Control Panel';
$lang['Group_member_details'] = 'Group Membership Details';

$lang['Group_Information'] = 'Group Information';
$lang['Group_name'] = 'Group name';
$lang['Group_description'] = 'Group description';
$lang['Group_membership'] = 'Group membership';
$lang['Group_Members'] = 'Group Members';
$lang['Group_Moderator'] = 'Group Moderator';
$lang['Pending_members'] = 'Pending Members';

$lang['Group_type'] = 'Group type';
$lang['Group_open'] = 'Open group';
$lang['Group_closed'] = 'Closed group';
$lang['Group_hidden'] = 'Hidden group';

$lang['Memberships_pending'] = 'Memberships pending';

$lang['No_groups_exist'] = 'No Groups Exist';
$lang['Group_not_exist'] = 'That user group does not exist';

$lang['Join_group'] = 'Join Group';
$lang['No_group_members'] = 'This group has no members';
$lang['Group_hidden_members'] = 'This group is hidden, you cannot view its membership';
$lang['Group_joined'] = 'You have successfully subscribed to this group.<br />You will be notified when your subscription is approved by the group moderator';
$lang['Group_request'] = 'A request to join your group %s has been made.';
$lang['Group_added'] = 'You have been added to usergroup %s.';
$lang['Already_member_group'] = 'You are already a member of this group';
$lang['User_is_member_group'] = 'User is already a member of this group';
$lang['Group_type_updated'] = 'Successfully updated group type.';

$lang['Could_not_anon_user'] = 'You cannot make Anonymous a group member.';

$lang['Confirm_unsub'] = 'Are you sure you want to unsubscribe from this group?';
$lang['Confirm_unsub_pending'] = 'Your subscription to this group has not yet been approved, are you sure you want to unsubscribe?';

$lang['Unsub_success'] = 'You have been un-subscribed from this group.';

$lang['Approve_selected'] = 'Approve Selected';
$lang['Deny_selected'] = 'Deny Selected';
$lang['Remove_selected'] = 'Remove Selected';
$lang['Add_member'] = 'Add Member';
$lang['Not_group_moderator'] = 'You are not this group\'s moderator, therefore you cannot perform that action.';

$lang['Login_to_join'] = 'Log in to join or manage group memberships';
$lang['This_open_group'] = 'This is an open group, click to request membership';
$lang['Member_this_group'] = 'You are a member of this group';
$lang['Pending_this_group'] = 'Your membership of this group is pending';
$lang['Are_group_moderator'] = 'You are the group moderator';
$lang['None'] = 'None';
$lang['Unsubscribe'] = 'Unsubscribe';
$lang['View_Information'] = 'View Information';


//
// Search
//
$lang['Search_query'] = 'Search Query';
$lang['Search_options'] = 'Search Options';

$lang['Search_keywords'] = 'Search for Keywords';
$lang['Search_keywords_explain'] = 'You can use <u>AND</u> to define words which must be in the results, <u>OR</u> to define words which may be in the result and <u>NOT</u> to define words which should not be in the result. Use * as a wildcard for partial matches<br />To search phrase embrance it in the <b>"</b>quotation<b>"</b>';
$lang['Search_author'] = 'Search for Author';
$lang['Search_author_explain'] = 'Use * as a wildcard for partial matches';

$lang['Search_for_any'] = 'Search for any terms or use query as entered';
$lang['Search_for_all'] = 'Search for all terms';
$lang['Search_title_msg'] = 'Search topic title, explain and message text';
$lang['Search_msg_only'] = 'Search message text only';
$lang['Search_title_only'] = 'Search topic title only';
$lang['Search_title_e_only'] = 'Search topic explain only';

$lang['Return_first'] = 'Return first';
$lang['characters_posts'] = 'characters of posts';

$lang['Search_previous'] = 'Search previous';

$lang['Sort_by'] = 'Sort by';
$lang['Sort_Time'] = 'Post time';
$lang['Sort_Topic_Title'] = 'Topic title';

$lang['Display_results'] = 'Display results as';
$lang['All_available'] = 'All available';
$lang['No_searchable_forums'] = 'You do not have permissions to search any forum on this site';

$lang['No_search_match'] = 'No topics or posts met your search criteria';
$lang['Found_search_match'] = 'Search found %d match';
$lang['Found_search_matches'] = 'Search found %d matches';

$lang['Close_window'] = 'Close Window';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = 'Sorry, but only %s can post announcements in this forum.';
$lang['Sorry_auth_sticky'] = 'Sorry, but only %s can post sticky messages in this forum.'; 
$lang['Sorry_auth_read'] = 'Sorry, but only %s can read topics in this forum.'; 
$lang['Sorry_auth_delete'] = 'Sorry, but only %s can delete posts in this forum.';
$lang['Sorry_auth_post'] = 'Sorry, but only %s can post topics in this forum.'; 
$lang['Sorry_auth_reply'] = 'Sorry, but only %s can reply to posts in this forum.';
$lang['Sorry_auth_edit'] = 'Sorry, but only %s can edit posts in this forum.'; 
$lang['Sorry_auth_vote'] = 'Sorry, but only %s can vote in polls in this forum.';

// These replace the %s in the above strings
$lang['Auth_Anonymous_users']  = '<b>not logged users</b>';
$lang['Auth_Registered_Users'] = '<b>registered users</b>';
$lang['Auth_Users_granted_access'] = '<b>users granted special access</b>';
$lang['Auth_Moderators'] = '<b>moderators</b>';
$lang['Auth_Administrators'] = '<b>administrators</b>';

$lang['Not_Authorised'] = 'Not Authorised';

$lang['You_been_banned'] = 'You have been banned from this forum.<br />Please contact the webmaster or board administrator for more information.';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'There are 0 Registered users and ';
$lang['Reg_users_online'] = 'There are %d Registered users and ';
$lang['Reg_user_online'] = 'There is %d Registered user and ';
$lang['Hidden_users_zero_online'] = '0 Hidden users online';
$lang['Hidden_users_online'] = '%d Hidden users online';
$lang['Hidden_user_online'] = '%d Hidden user online';
$lang['Guest_users_online'] = 'There are %d Guest users online';
$lang['Guest_users_zero_online'] = 'There are 0 Guest users online';
$lang['Guest_user_online'] = 'There is %d Guest user online';
$lang['No_users_browsing'] = 'There are no users currently browsing this forum';

$lang['Online_explain'] = '';

$lang['Forum_Location'] = 'Forum Location';
$lang['Last_updated'] = 'Last Updated';

$lang['Forum_index'] = 'Forum index';
$lang['Logging_on'] = 'Logging on';
$lang['Posting_message'] = 'Posting a message';
$lang['Searching_forums'] = 'Searching forums';
$lang['Viewing_profile'] = 'Viewing profile';
$lang['Viewing_online'] = 'Viewing who is online';
$lang['Viewing_member_list'] = 'Viewing member list';
$lang['Viewing_priv_msgs'] = 'Viewing Private Messages';
$lang['Viewing_FAQ'] = 'Viewing FAQ';


//
// Moderator Control Panel
//
	
$lang['Select'] = 'Select';
$lang['Move'] = 'Move';
$lang['Lock'] = 'Lock';
$lang['Unlock'] = 'Unlock';
$lang['Topics_Moved'] = 'The selected topics have been moved.';

//
// Timezones ... for display on each page
//

$lang['datetime']['Sunday'] = 'Sunday';
$lang['datetime']['Monday'] = 'Monday';
$lang['datetime']['Tuesday'] = 'Tuesday';
$lang['datetime']['Wednesday'] = 'Wednesday';
$lang['datetime']['Thursday'] = 'Thursday';
$lang['datetime']['Friday'] = 'Friday';
$lang['datetime']['Saturday'] = 'Saturday';
$lang['datetime']['Sun'] = 'Sun';
$lang['datetime']['Mon'] = 'Mon';
$lang['datetime']['Tue'] = 'Tue';
$lang['datetime']['Wed'] = 'Wed';
$lang['datetime']['Thu'] = 'Thu';
$lang['datetime']['Fri'] = 'Fri';
$lang['datetime']['Sat'] = 'Sat';
$lang['datetime']['January'] = 'January';
$lang['datetime']['February'] = 'February';
$lang['datetime']['March'] = 'March';
$lang['datetime']['April'] = 'April';
$lang['datetime']['May'] = 'May';
$lang['datetime']['June'] = 'June';
$lang['datetime']['July'] = 'July';
$lang['datetime']['August'] = 'August';
$lang['datetime']['September'] = 'September';
$lang['datetime']['October'] = 'October';
$lang['datetime']['November'] = 'November';
$lang['datetime']['December'] = 'December';
$lang['datetime']['Jan'] = 'Jan';
$lang['datetime']['Feb'] = 'Feb';
$lang['datetime']['Mar'] = 'Mar';
$lang['datetime']['Apr'] = 'Apr';
$lang['datetime']['May'] = 'May';
$lang['datetime']['Jun'] = 'Jun';
$lang['datetime']['Jul'] = 'Jul';
$lang['datetime']['Aug'] = 'Aug';
$lang['datetime']['Sep'] = 'Sep';
$lang['datetime']['Oct'] = 'Oct';
$lang['datetime']['Nov'] = 'Nov';
$lang['datetime']['Dec'] = 'Dec';

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = 'Information';
$lang['Critical_Information'] = 'Critical Information';

$lang['General_Error'] = 'General Error';
$lang['Critical_Error'] = 'Critical Error';
$lang['An_error_occured'] = 'An Error Occurred';
$lang['A_critical_error'] = 'A Critical Error Occurred';

//
// Modified addons
//

$lang['2_Days'] = '2 Days';
$lang['3_Days'] = '3 Days';
$lang['4_Days'] = '4 Days';
$lang['5_Days'] = '5 Days';
$lang['6_Days'] = '6 Days';
$lang['left'] = 'left side';
$lang['center'] = 'center';
$lang['right'] = 'right side';
$lang['registered_users'] = 'registered users';
$lang['posts'] = 'posts';
$lang['topics'] = 'topics';
$lang['Search_new_unread'] = 'View unread posts';
$lang['Search_new'] = 'View posts since last visit';
$lang['visitors_txt'] = 'This board have totally';
$lang['visitors_txt2'] = 'visitors';
$lang['Sticky_topic'] = 'Sticky this topic';
$lang['Announce_topic'] = 'Announce this topic';
$lang['Normal_topic'] = 'Reset this topic to normal';
$lang['Sticky'] = 'Sticky';
$lang['Announce'] = 'Announcement';
$lang['Normalise'] = 'Normal';
$lang['Mark_topic_unread'] = 'Mark current topic unread';
$lang['Mark_topic_read'] = 'Mark current topic read';
$lang['Statistics'] = 'Statistics';
$lang['Comments'] = 'Comments';
$lang['Welcome'] = 'Welcome';
$lang['Poll'] = 'Poll';
$lang['Vote'] = 'Vote';
$lang['bbcode_y_help'] = 'Font Center: [center]text[/center] (alt+y)';
$lang['bbcode_e_help'] = 'Fade text: [fade]some text[/fade] (alt+e)';
$lang['bbcode_k_help'] = 'Scrolling text: [scroll]text[/scroll] (alt+k)';
$lang['bbcode_s2_help'] = 'Shadow Color: [shadow=red]text[/shadow] Tip: this makes your text shadowed';
$lang['bbcode_g_help'] = 'Glow Color: [glow=red]text[/glow] Tip: this makes your text glow';
$lang['bbcode_h_help'] = 'Hide: [hide]message[/hide] (alt+h)';
$lang['Shadow_color'] = 'Shadow Color';
$lang['Glow_color'] = 'Glow Color';
$lang['write_link_text'] = 'Enter the text to be displayed for the link';
$lang['write_address'] = 'Enter the full URL for the link';
$lang['img_address'] = 'Enter the address to your image';
$lang['stream_address'] = 'Enter file address';
$lang['GG'] = 'Number Gadu-Gadu :: %s';
$lang['STAT_GG'] = 'User Gadu-gadu status';
$lang['GG_wait'] = 'Message waiting for receive.<br />Will be deliveret when user swich on Gadu-gadu<br /> or user is on <b>"invisible"</b> status or <b>"only for friends"</b>';
$lang['GG_full'] = 'User mailbox its full! Cannot send message.';
$lang['GG_send'] = 'Message delivery to user';
$lang['GG_not_send'] = 'Message not delivert, try another one or refresh page';
$lang['Last_visit'] = 'Last active';
$lang['Never'] = 'Never';
$lang['Sort_Last_visit'] = 'Date last active';
$lang['Page_loading_wait'] = 'Page Loading... please wait!';
$lang['Page_loading_stop'] = 'This page still doesn\'t show? Click <span onclick="hideLoadingPage()" style="cursor: pointer">Here<\/span>';
$lang['Quick_Reply'] = 'Quick Reply';
$lang['QuoteSelelected'] = 'Quote selected';
$lang['QuoteSelelectedEmpty'] = 'Select a text anywhere on a page and try again';
$lang['Quick_Reply_smilies'] = 'All emoticons';
$lang['Age'] = 'Age';
$lang['Year'] = 'Year';
$lang['Month'] = 'Month';
$lang['Day'] = 'Day';
$lang['l_whoisonline'] = 'View details';
$lang['new_topicsss'] = 'New topics:';
$lang['new_postsss'] = 'New posts:';
$lang['unread_topicsss'] = 'Unread topics:';
$lang['unread_postsss'] = 'Unread posts:';
$lang['Board_style'] = 'Board Style';
$lang['l_level'] = 'Level';
$lang['Ignore_list'] = 'Ignore Function';
$lang['Ignore_users'] = 'These Users are in your Ignore List';
$lang['Ignore_add'] = 'Add User to Ignore List';
$lang['Ignore_delete'] = 'Remove User from Ignore List';
$lang['Ignore_added'] = 'User added to Ignore List';
$lang['Ignore_deleted'] = 'User removed from Ignore List';
$lang['Ignore_submit'] = 'Ignore User';
$lang['Ignore_exists'] = 'User is Already on Ignore List';
$lang['Click_return_ignore'] = 'Click %sHERE%s to view the Ignore Page';
$lang['Ignore_user_warn'] = 'You cannot Ignore Yourself!!!';
$lang['Post_user_ignored'] = 'You have added this person to your <b>Ignore List</b>.';
$lang['Click_view_ignore'] = 'Click %sHERE%s to view this post.<br />';
$lang['Search_for'] = 'Search for';
$lang['cicq'] = 'ICQ';

$lang['Print_View'] = 'Printable version';
$lang['Wrong_reg_key'] = 'Wrong Validation';
$lang['Validation'] = 'Validation';
$lang['Msg_Icon_No_Icon'] = 'No';
$lang['messageicon'] = 'Topic icon';
$lang['postmsgicon'] = 'Topic/Message icon';
$lang['Topic_view_users'] = 'Who viewed this topic';
$lang['Topic_time'] = 'Last viewed';
$lang['Topic_count'] = 'View count';
$lang['Topic_global_announcement'] = '<b>Global Announcement:</b>';
$lang['Post_global_announcement'] = 'Global Announcement';
$lang['Forum_not_exist'] = 'No such forum exists';
$lang['Enter_forum_password'] = 'Enter forum password';
$lang['Incorrect_forum_password'] = 'Incorrect forum password';
$lang['Only_alpha_num_chars'] = 'The password must be between 3-20 characters and can only contain alphanumeric characters (A-Z, a-z, 0-9).';
$lang['Album'] = 'Album';
$lang['l_whois'] = 'Whois';
$lang['Staff'] = 'Staff Site';
$lang['Admin'] = 'Administrator';
$lang['Junior'] = 'Junior Admin';
$lang['Period'] = 'since <b>%d</b> days';
$lang['Topic_bookmark'] = 'Add this topic to your bookmarks';
$lang['Day_users'] = 'Users last %s hours:';
$lang['last_visitors_more'] = 'Full list';
$lang['search_keywords_error'] = 'You used too many words during attempt to search. Max. you can use: <b>%s</b>.';
$lang['hidden_user'] = 'Hidden';
$lang['post_expire'] = 'Post expire:';
$lang['topic_expire'] = 'Expire:';
$lang['expire_unlimit'] = 'Unlimit';
$lang['l_expire_p'] = 'Post/topic time expire';
$lang['Tree_width_topic'] = 'Topic tree deepness in pixels';
$lang['l_expire_p_e'] = 'Choose how long post/topic will be on the forum. After will be automatically deleted.';
$lang['expire_e'] = 'Set after how much days topic will be removed';
$lang['announce-stick'] = 'Stick topic - mark topic as announce or global announce';
$lang['Merge_post'] = 'Merge posts in this topic';
$lang['Merge_posts'] = 'Merge selected posts';
$lang['post_expire_q'] = 'Expire';
$lang['Password_not_complex'] = 'The specifyed password, does not confirm this sites complexity rules, you should verify that: the password ';
$lang['Ignore_mini'] = 'Ignore';
$lang['pm_mini'] = 'PM';
$lang['aim_mini'] = 'GG';
$lang['quote_mini'] = 'Quote';
$lang['edit_mini'] = 'Edit';
$lang['mini_reply'] = 'REPLY';
$lang['mini_newtopic'] = 'NEW TOPIC';
$lang['mini_locked'] = 'CLOSED';

$lang['too_long_word'] = 'Word too long';
$lang['login_to_shoutcast'] = 'You must be logged in to use shoutbox or sending messages is avaliable only for Administrators and Moderators';
$lang['sb_banned_send'] = 'You can\'t send messages';
$lang['l_alert_sb'] = 'Are you sure you want to delete this message?';
$lang['l_refresh_sb'] = 'Empty shoutbox received 100 responses from the server to continue to press this button.';
$lang['sb_restriction'] = 'Shoutbox has been disabled or you receive a ban.';
$lang['l_cancel_sb'] = 'Cancel';
$lang['l_edit_sb'] = 'Save';
$lang['emotki'] = 'Emots';
$lang['Email_explain'] = 'If you have mail e.g. john@johny.com then to first field type john and to second johny.com';

$lang['banned_forum'] = 'You cannot write on this forum.';

$lang['edit_time_past'] = 'You\'re not allowed to edit your post. You have to edit your post within <b>%d</b> minutes, after you posted your message.';
$lang['This_closed_group'] = 'This is a closed group, %s';
$lang['This_hidden_group'] = 'This is a hidden group, %s';
$lang['No_more'] = 'no more users accepted';
$lang['No_add_allowed'] = 'automatic user addition is not allowed';
$lang['Join_auto'] = 'You may join this group, since your post count meet the group criteria';
$lang['Permissions'] = 'Permissions';
$lang['quote_image'] = 'Image';
$lang['Gender'] = 'Gender';
$lang['Male'] = 'Male'; 
$lang['Female'] = 'Female'; 
$lang['No_gender_specify'] = 'I dont know :)';
$lang['not_gg_account'] = 'Not number or password for GG gate. Contact with administrator';
$lang['not_gg_addresat'] = 'Recipient is empty';
$lang['wrong_gg_addresat'] = 'Bad format recipient number';
$lang['not_gg_msg'] = 'Message is empty';
$lang['gg_too_long'] = 'Message too long, max chars is: 1800';
$lang['topic_expire_mod'] = 'Expire after: ';
$lang['Forum_link_visited'] = 'This link has been visited %d times';
$lang['Redirect'] = 'Redirect';
$lang['Never'] = 'Never';
$lang['login_require'] = 'Access to this part of forum require logged in.';
$lang['login_require_register'] = 'If you not registered, click %sHere%s to register.';

$lang['generate_time'] = 'Page generated in';
$lang['second'] = 'second';
$lang['seconds'] = 'seconds';
$lang['Warnings'] = 'Reprimand users';
$lang['Warnings_viewtopic'] = 'Reprimends';
$lang['warnings_banned_info'] = '<b>You are banned !</b><br /><br />You have: <b>%s</b> warnings with value: <b>%s</b>. Max. value is: <b>%s</b><br /><br />Last warning: <b>%s</b><br />Reason: <i>%s</i>';
$lang['disallow_posting'] = 'You exceed warnings limit. You can not posting new posts and topics.<br /><br />Click %sHERE%s to view warnings page.';
$lang['warnings_lastwar_info'] = '<b>You get new warning !</b><br /><br />Click %sHERE%s to see it.';
$lang['support'] = '<br /><br />If you can not fix this problem,<br />you can find help, or ask question at: <a href="http://www.przemo.org/phpBB2/" target="_blank">http://www.przemo.org/phpBB2/</a>';
$lang['poster_posts'] = 'You posted in this topic';
$lang['Sort_per_letter'] = 'Show only usernames starting with';
$lang['Others'] = 'others';
$lang['All'] = 'all';
$lang['ignore_topic_added'] = 'Selected topic/s added to your ignore list.<br />Don`t will be display in the unread topic list (or topics since last visit)<br /><br />Click %sHERE%s to view your topics ignore list.<br /><br />Click %sHERE%s to return index.';
$lang['ignore_topic_unignored'] = 'Selected topic/s removed  from your list.<br /><br />Click %sHERE%s to see your ignore list.<br /><br />Click %sHERE%s to back.';
$lang['ignore_mark'] = 'Ignore selected topics';
$lang['ignore_topics'] = 'Ignored topics';
$lang['list_ignore'] = 'Your list ignored topics';
$lang['list_ignore_e'] = 'Topic with no reply from last 3 months are automatically removed from list';
$lang['ignore_list_empty'] = 'Your ignore topics list is empty.<br /><br />Click %sHERE%s to return index';
$lang['ignore_topic'] = 'Ignore this topic';
$lang['current_topic_ignore'] = 'You ignored this topic';
$lang['bbcode_ct_help'] = 'Topic color, showing on view forum';
$lang['topic_color'] = 'Topic color';
$lang['15_min'] = '15 min';
$lang['30_min'] = '30 min';
$lang['1_Hour'] = '1 Hour';
$lang['2_Hour'] = '2 Hours';
$lang['6_Hour'] = '6 Hours';
$lang['12_Hour'] = '12 Hours';
$lang['icons'] = 'All post/topic icons';
$lang['your_posts'] = 'your posts';
$lang['replys_last_post'] = 'replies since your last post';
$lang['unread_posts'] = 'unread posts';
$lang['not_poster_post'] = 'You don`t posting this topic';
$lang['lang_q_quote_e'] = 'You can quote selected words. Mark words to quote and click here. You can quote more times';
$lang['ignore_topic_submit_e'] = 'It add topics to your ignore list. Topics not will be show in the list topics and search results';
$lang['data'] = 'The Administrator violate the forum script <a href="http://www.przemo.org/phpBB2/">phpBB modified by Przemo</a> using rules.<br />Forum was block !<br /><br />E-mail to: przemo@przemo.org for more information';
$lang['more_topicicons'] = 'You can choose more icons. If you click here it open new window with more icons';
$lang['online_minutes'] = 'Minutes online: <b>%s</b>';
$lang['online_hours'] = 'Hours online: <b>%s</b>';
$lang['Viewing_topic'] = 'View topic';
$lang['gg_header_info_pm'] = 'Otrzyma³es nowa prywatna wiadomosc od: %s';
$lang['gg_notify_topic'] = 'In your topic: "%s" user: %s post reply';
$lang['l_notify_gg_privmsg'] = 'Link to your private message inbox: %s';
$lang['l_notify_gg_topic'] = 'To view topic click: %s';
$lang['generate_queries'] = 'SQL queries';
$lang['unread_post'] = 'Unread post';
$lang['refresh'] = 'Refresh';
$lang['new_board_topic'] = 'On the forum %s user %s post new topic: %s';
$lang['new_board_post'] = 'On the forum %s user %s post reply in topic: %s';
$lang['Search_post_time'] = 'Show posts last:</span><br /><span class="gensmall">It shows posted posts before choosing time. You can set shows method Topics and Posts';
$lang['user_not_allowpm'] = 'You can not send private message to this user because he has disabled private messaging';
$lang['open_all_new_window'] = 'Open all links in new windows';

$lang['s_email_friend'] = 'Notify friend about this topic';
$lang['s_email_friend_f_name'] = 'Friend name:';
$lang['s_email_friend_f_email'] = 'Friend email:';
$lang['s_email_friend_title'] = '%s just look this thread: %s';
$lang['s_email_friend_message'] = 'I read %s on the %s You must see it! Here is a link: %s';

$lang['mstr'] = 'Automatic repair table';
$lang['rrtf'] = "The table %s is damage, attempt to auto repair failed:\n%s\n%s\nTry repair manually, execute query: REPAIR TABLE %s";
$lang['rrts'] = "The table %s was damage, attempt to auto repair propably successfull:\n%s\n If not try repair manually, execute query REPAIR TABLE %s";
$lang['rrsum'] = 'Occured fine error, the script was attempt to repair and notice board administrator.';

$lang['Report_no_access'] = 'You haven\'t the permission to use this function of the report post hack!';
$lang['Report_disabled'] = 'Posts of this user can\'t be reported.';
$lang['Report_post_already_reported'] = 'This post is already reported';
$lang['Report_post_self'] = 'You can\'t report your own post.';
$lang['Report_already_removed'] = 'This report is already removed.';
$lang['Report_no_posts'] = 'No (additional) reported posts!';
$lang['Report_no_title'] = 'No title';
$lang['Reporter'] = 'Reporter';
$lang['Report_posts'] = 'Reported posts';
$lang['Report_popup_text'] = 'Follow posts has been reported:';
$lang['Report_deleted'] = 'Report removed.';
$lang['Report_post_reported'] = 'Report submitted. Thank you.';
$lang['Report_post'] = 'Report this post to Moderator/Admin.';
$lang['Report_del'] = 'Remove report.';
$lang['Report_no_popup'] = 'Open report popup on new reports';
$lang['Report_no_mail'] = 'Notify per email if someone report a post';
$lang['Report_reload_window'] = 'Reload window';
$lang['Report_no_auth'] = 'You can\'t report posts because you aren\'t logged in or this function is locked for you.';
$lang['Report_open_popup'] = 'Open report popup';
$lang['Report_list'] = 'Report list';
$lang['added'] = 'Added';
$lang['Voted_show'] = 'Voted : '; // it means :  users that voted  (the number of voters will follow)
$lang['Results_after'] = 'Results will be visible after the poll expires';
$lang['Poll_expires'] = 'Poll expires in : ';
$lang['Minutes'] = 'Minutes';
$lang['Max_vote'] = 'Maximum selections';
$lang['Max_vote_explain'] = '[ Enter 1 or leave blank to allow only one selection ]';
$lang['Max_voting_1_explain'] = 'Please select only ';
$lang['Max_voting_2_explain'] = ' answers';
$lang['Max_voting_3_explain'] = ' (selections above limit will be ignored)';
$lang['Vhide'] = 'Hide';
$lang['Hide_vote'] = 'Results';
$lang['Tothide_vote'] = 'Sum of votes';
$lang['Hide_vote_explain'] = ' [ Hide until poll expires ]';
$lang['rname'] = 'Quick register';

$lang['helped_confirm'] = 'If you are this topic author and this reply help you, you can add one HELPED point for this user<br /><br />Click %sHERE%s to add point, or click %sHERE%s to cancel and return topic';
$lang['helped_delete_confirm'] = 'Are you sure to delete point <b>helped</b> for this post ?<br /><br />Click %sHERE%s to remove point, or %sHERE%s to return';
$lang['helped_added'] = 'Helped point added.<br />Click %sHERE%s to return.';
$lang['He_helped'] = 'If this post help you, click to add point for this user';
$lang['He_helped_delete'] = 'Remove point \'helped\' for this post';
$lang['help_1'] = '';
$lang['help_more'] = ' times';
$lang['postrow_help'] = '<b>Helped:</b> ';
$lang['postrow_help_she'] = '<b>Helped:</b> ';
$lang['helped'] = 'Helped';
$lang['Joined_she'] = 'Joined';
$lang['that_same_msg'] = 'You can not post twice that same messages !';
$lang['Seeker'] = 'Search users';
$lang['No_split_post'] = 'No split this message';
$lang['too_many_voting'] = 'Max voting is: <b>%s</b> for this pool, but you mark: <b> %s</b>.<br />Vote has not added, go back and vote one more time.';
$lang['failed_sending_email'] = 'Failed sending email<br />Maybe wrong e-mail address was hand, otherwise Admin should check email setting or disable sending email by forum.';

$lang['notify_message'] = 'Your %s which you write on: %s, was delete by Administrator or Moderator%s';
$lang['your_post'] = 'Your post:';
$lang['Reason'] = 'Reason';
$lang['subject_notify_delete'] = 'Your %s was delete';
$lang['topic_link'] = "\n\rTopic link: %s";
$lang['forum_service'] = 'Forum service';
$lang['confirm_report_post'] = 'Are you sure you want to report this post to the Moderator and Administrator?';
$lang['Accept'] = 'Accept';
$lang['Reject'] = 'Reject';
$lang['Accept-reject'] = 'Accept/Reject choosed';
$lang['Post_no_approved'] = 'Waiting for accept';
$lang['Print_topic'] = 'This is only a print version to view the full version of the theme, click HERE';
$lang['Loser_protect'] = 'ATTENTION! You trying to reply on the <b>%s</b> page of topic, topic contain <b>%s</b> pages. Read first all topic before reply !!!<br /><br />Click %sHere%s to go to next page. Click%sHere%s if you sure want reply without reading all topic.';
$lang['User_deleted'] = 'Deleted';
$lang['Account_delete'] = 'Account deletedon %s';
$lang['User_report_post'] = 'A User has reported a post';
$lang['Subject_e'] = 'Subject explain';
$lang['Subject_e_info'] = 'not obligatory';
$lang['show_ignore_topics'] = 'Show ignore topics';
$lang['footer'] = 'Forum footer was modified, forum will not work corectly!<br />Set the footer corectly.<br /><br />Pattern: <b>Powered by &lt;a href=&quot;http://www.phpbb.com&quot; target=&quot;_blank&quot; class=&quot;copyright&quot;&gt;phpBB&lt;/a&gt; modified by &lt;a href=&quot;http://www.przemo.org/phpBB2/&quot; class=&quot;copyright&quot; target=&quot;_blank&quot;&gt;Przemo&lt;/a&gt; &amp;copy; 2003 phpBB Group</b>';
$lang['db_backup_done'] = 'Forum has started backup database.<br />Please come back in a minute.';
$lang['Freak_undo'] = 'Use Ctrl+Z to Undo';
$lang['Today'] = 'Today';
$lang['Yesterday'] = 'Yesterday';
$lang['TA_Locked'] = 'Closed';
$lang['TA_Unocked'] = 'Opened';
$lang['TA_Moved'] = 'Moved';
$lang['TA_Expired'] = 'Expired';
$lang['TA_Who'] = 'by';
$lang['TA_Delete'] = 'Delete this information';
$lang['Comment_post'] = 'Add comment to this post';
$lang['Comment_added'] = 'Comment added by : %s';
$lang['Topic_important'] = 'Valuable';
$lang['First_post'] = 'First post';
$lang['Post_history'] = 'Post edit history';
$lang['Custom_Rank'] = 'User defined rank';
$lang['Your_topic_moved'] = 'Your topic on %s was moved';
$lang['Your_topic_moved_message'] = 'Your topic: "%s" in the forum: "%s" was moved to forum: "%s" Topic link: %s %s';
$lang['Important_topics'] = 'Important topics';
$lang['View_next_unread_posts'] = 'View next unread posts';
$lang['Go'] = 'Go';
$lang['adv_person'] = 'Advert persons';
$lang['adv_person_link'] = 'If you want advertise your friend on this forum, copy this link: %s';
$lang['Invalid_session'] = 'Session expired or session ID number is incorrect.<br />Try again.';
$lang['Not_admin'] = 'You have no Admin authorisation';
$lang['Posting_disabled'] = 'Posting is disabled.';
$lang['Registering_disabled'] = 'Registering is disabled.';
$lang['Pruning_unread_posts'] = 'Your account exceed maximum amount of unread posts: <b>%s</b> Information about unread posts was removed, without posts writen through last: <b>%s</b> days.<br />Removed unread posts: <b>%s</b><br />You may read posts or mar all as read.<br />You can use search to find posts writen through last choosed time.';
//
// That's all Folks!
// -------------------------------------------------

?>