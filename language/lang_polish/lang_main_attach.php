<?php
/***************************************************************************
 *                            lang_main_attach.php [English]
 *                              -------------------
 *     begin                : Thu Feb 07 2002
 *     copyright            : (C) 2002 Meik Sievertsen
 *     email                : acyd.burn@gmx.de
 *
 *     $Id: lang_main_attach.php,v 1.15 2002/11/03 23:54:52 meik Exp $
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

// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

//
// Attachment Mod Main Language Variables
//

// Auth Related Entries
$lang['Rules_attach_can'] = '<b>Mo¿esz</b> za³±czaæ pliki na tym forum';
$lang['Rules_attach_cannot'] = '<b>Nie mo¿esz</b> za³±czaæ plików na tym forum';
$lang['Rules_download_can'] = '<b>Mo¿esz</b> ¶ci±gaæ za³±czniki na tym forum';
$lang['Rules_download_cannot'] = '<b>Nie mo¿esz</b> ¶ci±gaæ za³±czników na tym forum';
$lang['Sorry_auth_view_attach'] = 'Nie masz zezwolenia na ¶ci±ganie lub przegl±danie za³±czników na tym forum.';

// Viewtopic -> Display of Attachments
$lang['Description'] = 'Opis'; // used in Administration Panel too...
$lang['Downloaded'] = 'Pobrañ';
$lang['Download'] = 'Pobierz'; // this Language Variable is defined in lang_admin.php too, but we are unable to access it from the main Language File
$lang['Filesize'] = 'Rozmiar';
$lang['Viewed'] = 'Wy¶wietleñ';
$lang['Download_number'] = 'Plik ¶ci±gniêto %d raz(y)'; // replace %d with count
$lang['Extension_disabled_after_posting'] = 'Rozszerzenie \'%s\' usuniête z forum przez admina, dlatego za³±cznik nie bêdzie pokazany.'; // used in Posts and PM's, replace %s with mime type

// Posting/PM -> Initial Display
$lang['Attach_posting_cp'] = 'Panel kontrolny za³±czania plików';
$lang['Attach_posting_cp_explain'] = 'Je¶li klikniesz na "Za³±cz plik", zobaczysz pole na dodanie za³±cznika.<br />Je¶li klikniesz na za³±czony plik, zobaczysz liste za³±czonych plików, bêdzie mo¿na j± zmieniæ.<br />Je¶li chcesz "nadpisaæ" (Wys³aæ nowsz± wersjê pliku) na istniej±cy juz za³±cznik, musisz klikn±æ na linku, nie dodawaj pliku drugi raz.';

// Posting/PM -> Posting Attachments
$lang['Add_attachment'] = 'Dodaj za³±cznik';
$lang['Add_attachment_title'] = 'Za³±cz plik';
$lang['Add_attachment_explain'] = 'Je¶li nie chcesz za³±czaæ pliku do tego postu, pozostaw to pole puste';
$lang['File_name'] = 'Nazwa za³±cznika';
$lang['File_comment'] = 'Komentarz za³±cznika';

// Posting/PM -> Posted Attachments
$lang['Posted_attachments'] = 'Za³±czony plik';
$lang['Options'] = 'Opcje';
$lang['Update_comment'] = 'Zmieñ komentarz';
$lang['Delete_attachments'] = 'Usuñ za³±czniki';
$lang['Delete_attachment'] = 'Usuñ za³±cznik';
$lang['Delete_thumbnail'] = 'Usuñ miniaturê';
$lang['Upload_new_version'] = 'Wy¶lij uaktualniony plik';

// Errors -> Posting Attachments
$lang['Invalid_filename'] = '%s jest nieprawid³ow± nazw±'; // replace %s with given filename
$lang['Attachment_php_size_na'] = 'Plik ma za du¿y rozmiar.<br />Nie mo¿na pobraæ wielko¶ci pliku zdefiniowanej w PHP.';
$lang['Attachment_php_size_overrun'] = 'Plik ma za du¿y rozmiar.<br />Maksymalny dozwolony rozmiar to: %d MB.'; // replace %d with ini_get('upload_max_filesize')
$lang['Disallowed_extension'] = 'Rozszerzenie %s jest niedozwolone'; // replace %s with extension (e.g. .php) 
$lang['Disallowed_extension_within_forum'] = 'Nie masz uprawnieñ do za³±czania plików z rozszerzeniem %s na tym forum'; // replace %s with the Extension
$lang['Attachment_too_big'] = 'Plik ma za du¿y rozmiar.<br />Maksymalny dozwolony rozmiar to: %d %s'; // replace %d with maximum file size, %s with size var
$lang['Attach_quota_reached'] = 'Niestety Limit na wszystkie za³±czniki na tym forum zosta³ przekroczony. Prosze skontaktowaæ siê z administratorem forum.';
$lang['Too_many_attachments'] = 'Plik nie mo¿e byæ za³±czony, limit %d w tym po¶cie zosta³ przekroczony'; // replace %d with maximum number of attachments
$lang['Error_imagesize'] = 'Za³±cznik-obraz musi byæ mniejszy ni¿ %d pixeli szeroko¶ci i %d pixeli wysoko¶ci'; 
$lang['General_upload_error'] = 'B³±d wysy³ania za³±cznika (nie mo¿na skopiowaæ do okre¶lonego katalogu: %s, skontaktuj siê z administratorem forum.'; // replace %s with local path

$lang['Error_empty_add_attachbox'] = 'Musisz podaæ warto¶æ w polu \'Dodaj za³±cznik\'.';
$lang['Error_missing_old_entry'] = 'Nie mo¿na uaktualniæ pliku, nie znaleziono starego za³±cznika';

// Errors -> PM Related
$lang['Attach_quota_sender_pm_reached'] = 'Pojemno¶æ twojej prywatnej skrzynki na za³±czniki zosta³a przekroczona. Usuñ kilka starych plików i spróbuj ponownie.';
$lang['Attach_quota_receiver_pm_reached'] = 'Maksymalna dozwolona ilo¶æ plików w skrzynce odbiorcy, zosta³a przekroczona. Poinformuj go o tym, lub poczekaj a¿ miejsce zostanie zwolnione.';

// Errors -> Download
$lang['No_attachment_selected'] = 'Nie ma zaznaczonego za³±cznika do ¶ci±gniêcia lub pokazania.';
$lang['Error_no_attachment'] = 'Wybrany za³±cznik ju¿ nie istnieje';

// Delete Attachments
$lang['Confirm_delete_attachments'] = 'Czy na pewno skasowaæ wybrane za³±czniki?';
$lang['Error_deleted_attachments'] = 'Could not delete Attachments.';

// General Error Messages
$lang['file_not_delete'] = 'Nie mo¿esz usun±æ tego pliku.';
$lang['Attachment_feature_disabled'] = 'Ta cecha pliku jest wy³±czona.';

$lang['Directory_does_not_exist'] = 'Katalog \'%s\' nie istnieje lub nie zosta³ znaleziony.'; // replace %s with directory
$lang['Directory_is_not_a_dir'] = 'Sprawdz czy \'%s\' jest katalogiem.'; // replace %s with directory
$lang['Directory_not_writeable'] = 'Katalog \'%s\' nie ma praw do zapisu. Musisz utworzyæ ¶cie¿kê i katalog z prawami do zapisu (chmod -R nazwa_katalogu 777) (lub sprawdz w³a¶ciciela katalogu).<br />If you have only plain ftp-access change the \'Attribute\' of the directory to rwxrwxrwx.'; // replace %s with directory

$lang['Ftp_error_connect'] = 'Nie moge siê po³±czyæ z serwerem FTP: \'%s\'. Sprawdz ustawienia serwera.';
$lang['Ftp_error_login'] = 'Nie mogê siê zalogowaæ na serwer FTP. U¿ytkownik \'%s\' lub has³o nieprawidlowe. Sprawdz ustawienia serwera FTP.';
$lang['Ftp_error_path'] = 'Brak dostêpu do serwera FTP: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_upload'] = 'Nie moge skopiowaæ pliku do katalogu: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_delete'] = 'Nie mogê usun±æ pliku z katalogu: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_pasv_mode'] = 'B³±d w³±czenia/wy³±czenia Trybu pasywnego';

// Attach Rules Window
$lang['Rules_page'] = 'Ustawienia za³±czników';
$lang['Attach_rules_title'] = 'Dozwolone rozszerzenia i rozmiary za³±czników dla grup';
$lang['Group_rule_header'] = 'Maksymalny rozmiar %s to: %s'; // Replace first %s with Extension Group, second one with the Size STRING
$lang['Allowed_extensions_and_sizes'] = 'Dozwolone rozszerzenia i rozmiary';
$lang['Note_user_empty_group_permissions'] = 'NOTKA:<br />You are normally allowed to attach files within this Forum, <br />but since no Extension Group is allowed to be attached here, <br />you are unable to attach anything. If you try, <br />you will receive an Error Message.<br />';

// Quota Variables
$lang['Upload_quota'] = 'Quota Uploadu';
$lang['Pm_quota'] = 'Quota w prywatnych wiadomo¶ciach';
$lang['User_upload_quota_reached'] = 'Przekroczy³' .  (($he) ? 'e' : 'a') . '¶ maksymalny limit uploadu (%d %s)'; // replace %d with Size, %s with Size Lang (MB for example)

// User Attachment Control Panel
$lang['User_acp_title'] = 'Panel U¿ytkowników';
$lang['UACP'] = 'Panel kontrolny za³±czników';
$lang['User_uploaded_profile'] = 'Upload ca³kowity: %s';
$lang['User_quota_profile'] = 'Quota: %s';
$lang['Upload_percent_profile'] = '%d%% ca³o¶ci';

// Common Variables
$lang['Bytes'] = 'Bajtów';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';
$lang['Attach_search_query'] = 'Szukaj za³±czników';
$lang['Test_settings'] = 'Test ustawieñ';
$lang['Not_assigned'] = 'Nie skojarzone';
$lang['No_file_comment_available'] = 'Brak komentarza do za³±cznika';
$lang['Attachbox_limit'] = 'Wykorzystanie za³±czników w skrzynce: ';
$lang['No_quota_limit'] = 'Brak limitu Quoty';
$lang['Unlimited'] = 'Bez limitu';

?>