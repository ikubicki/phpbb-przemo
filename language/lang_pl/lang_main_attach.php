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
$he = true;

//
// Attachment Mod Main Language Variables
//

// Auth Related Entries
$lang['Rules_attach_can'] = '<b>Mo�esz</b> za��cza� pliki na tym forum';
$lang['Rules_attach_cannot'] = '<b>Nie mo�esz</b> za��cza� plik�w na tym forum';
$lang['Rules_download_can'] = '<b>Mo�esz</b> �ci�ga� za��czniki na tym forum';
$lang['Rules_download_cannot'] = '<b>Nie mo�esz</b> �ci�ga� za��cznik�w na tym forum';
$lang['Sorry_auth_view_attach'] = 'Nie masz zezwolenia na �ci�ganie lub przegl�danie za��cznik�w na tym forum.';

// Viewtopic -> Display of Attachments
$lang['Description'] = 'Opis'; // used in Administration Panel too...
$lang['Downloaded'] = 'Pobra�';
$lang['Download'] = 'Pobierz'; // this Language Variable is defined in lang_admin.php too, but we are unable to access it from the main Language File
$lang['Filesize'] = 'Rozmiar';
$lang['Viewed'] = 'Wy�wietle�';
$lang['Download_number'] = 'Plik �ci�gni�to %d raz(y)'; // replace %d with count
$lang['Extension_disabled_after_posting'] = 'Rozszerzenie \'%s\' usuni�te z forum przez admina, dlatego za��cznik nie b�dzie pokazany.'; // used in Posts and PM's, replace %s with mime type

// Posting/PM -> Initial Display
$lang['Attach_posting_cp'] = 'Panel kontrolny za��czania plik�w';
$lang['Attach_posting_cp_explain'] = 'Je�li klikniesz na "Za��cz plik", zobaczysz pole na dodanie za��cznika.<br />Je�li klikniesz na za��czony plik, zobaczysz liste za��czonych plik�w, b�dzie mo�na j� zmieni�.<br />Je�li chcesz "nadpisa�" (Wys�a� nowsz� wersj� pliku) na istniej�cy juz za��cznik, musisz klikn�� na linku, nie dodawaj pliku drugi raz.';

// Posting/PM -> Posting Attachments
$lang['Add_attachment'] = 'Dodaj za��cznik';
$lang['Add_attachment_title'] = 'Za��cz plik';
$lang['Add_attachment_explain'] = 'Je�li nie chcesz za��cza� pliku do tego postu, pozostaw to pole puste';
$lang['File_name'] = 'Nazwa za��cznika';
$lang['File_comment'] = 'Komentarz za��cznika';

// Posting/PM -> Posted Attachments
$lang['Posted_attachments'] = 'Za��czony plik';
$lang['Options'] = 'Opcje';
$lang['Update_comment'] = 'Zmie� komentarz';
$lang['Delete_attachments'] = 'Usu� za��czniki';
$lang['Delete_attachment'] = 'Usu� za��cznik';
$lang['Delete_thumbnail'] = 'Usu� miniatur�';
$lang['Upload_new_version'] = 'Wy�lij uaktualniony plik';

// Errors -> Posting Attachments
$lang['Invalid_filename'] = '%s jest nieprawid�ow� nazw�'; // replace %s with given filename
$lang['Attachment_php_size_na'] = 'Plik ma za du�y rozmiar.<br />Nie mo�na pobra� wielko�ci pliku zdefiniowanej w PHP.';
$lang['Attachment_php_size_overrun'] = 'Plik ma za du�y rozmiar.<br />Maksymalny dozwolony rozmiar to: %d MB.'; // replace %d with ini_get('upload_max_filesize')
$lang['Disallowed_extension'] = 'Rozszerzenie %s jest niedozwolone'; // replace %s with extension (e.g. .php) 
$lang['Disallowed_extension_within_forum'] = 'Nie masz uprawnie� do za��czania plik�w z rozszerzeniem %s na tym forum'; // replace %s with the Extension
$lang['Attachment_too_big'] = 'Plik ma za du�y rozmiar.<br />Maksymalny dozwolony rozmiar to: %d %s'; // replace %d with maximum file size, %s with size var
$lang['Attach_quota_reached'] = 'Niestety Limit na wszystkie za��czniki na tym forum zosta� przekroczony. Prosze skontaktowa� si� z administratorem forum.';
$lang['Too_many_attachments'] = 'Plik nie mo�e by� za��czony, limit %d w tym po�cie zosta� przekroczony'; // replace %d with maximum number of attachments
$lang['Error_imagesize'] = 'Za��cznik-obraz musi by� mniejszy ni� %d pixeli szeroko�ci i %d pixeli wysoko�ci'; 
$lang['General_upload_error'] = 'B��d wysy�ania za��cznika (nie mo�na skopiowa� do okre�lonego katalogu: %s, skontaktuj si� z administratorem forum.'; // replace %s with local path

$lang['Error_empty_add_attachbox'] = 'Musisz poda� warto�� w polu \'Dodaj za��cznik\'.';
$lang['Error_missing_old_entry'] = 'Nie mo�na uaktualni� pliku, nie znaleziono starego za��cznika';

// Errors -> PM Related
$lang['Attach_quota_sender_pm_reached'] = 'Pojemno�� twojej prywatnej skrzynki na za��czniki zosta�a przekroczona. Usu� kilka starych plik�w i spr�buj ponownie.';
$lang['Attach_quota_receiver_pm_reached'] = 'Maksymalna dozwolona ilo�� plik�w w skrzynce odbiorcy, zosta�a przekroczona. Poinformuj go o tym, lub poczekaj a� miejsce zostanie zwolnione.';

// Errors -> Download
$lang['No_attachment_selected'] = 'Nie ma zaznaczonego za��cznika do �ci�gni�cia lub pokazania.';
$lang['Error_no_attachment'] = 'Wybrany za��cznik ju� nie istnieje';

// Delete Attachments
$lang['Confirm_delete_attachments'] = 'Czy na pewno skasowa� wybrane za��czniki?';
$lang['Error_deleted_attachments'] = 'Could not delete Attachments.';

// General Error Messages
$lang['file_not_delete'] = 'Nie mo�esz usun�� tego pliku.';
$lang['Attachment_feature_disabled'] = 'Ta cecha pliku jest wy��czona.';

$lang['Directory_does_not_exist'] = 'Katalog \'%s\' nie istnieje lub nie zosta� znaleziony.'; // replace %s with directory
$lang['Directory_is_not_a_dir'] = 'Sprawdz czy \'%s\' jest katalogiem.'; // replace %s with directory
$lang['Directory_not_writeable'] = 'Katalog \'%s\' nie ma praw do zapisu. Musisz utworzy� �cie�k� i katalog z prawami do zapisu (chmod -R nazwa_katalogu 777) (lub sprawdz w�a�ciciela katalogu).<br />If you have only plain ftp-access change the \'Attribute\' of the directory to rwxrwxrwx.'; // replace %s with directory

$lang['Ftp_error_connect'] = 'Nie moge si� po��czy� z serwerem FTP: \'%s\'. Sprawdz ustawienia serwera.';
$lang['Ftp_error_login'] = 'Nie mog� si� zalogowa� na serwer FTP. U�ytkownik \'%s\' lub has�o nieprawidlowe. Sprawdz ustawienia serwera FTP.';
$lang['Ftp_error_path'] = 'Brak dost�pu do serwera FTP: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_upload'] = 'Nie moge skopiowa� pliku do katalogu: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_delete'] = 'Nie mog� usun�� pliku z katalogu: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_pasv_mode'] = 'B��d w��czenia/wy��czenia Trybu pasywnego';

// Attach Rules Window
$lang['Rules_page'] = 'Ustawienia za��cznik�w';
$lang['Attach_rules_title'] = 'Dozwolone rozszerzenia i rozmiary za��cznik�w dla grup';
$lang['Group_rule_header'] = 'Maksymalny rozmiar %s to: %s'; // Replace first %s with Extension Group, second one with the Size STRING
$lang['Allowed_extensions_and_sizes'] = 'Dozwolone rozszerzenia i rozmiary';
$lang['Note_user_empty_group_permissions'] = 'NOTKA:<br />You are normally allowed to attach files within this Forum, <br />but since no Extension Group is allowed to be attached here, <br />you are unable to attach anything. If you try, <br />you will receive an Error Message.<br />';

// Quota Variables
$lang['Upload_quota'] = 'Quota Uploadu';
$lang['Pm_quota'] = 'Quota w prywatnych wiadomo�ciach';
$lang['User_upload_quota_reached'] = 'Przekroczy�' .  (($he) ? 'e' : 'a') . '� maksymalny limit uploadu (%d %s)'; // replace %d with Size, %s with Size Lang (MB for example)

// User Attachment Control Panel
$lang['User_acp_title'] = 'Panel U�ytkownik�w';
$lang['UACP'] = 'Panel kontrolny za��cznik�w';
$lang['User_uploaded_profile'] = 'Upload ca�kowity: %s';
$lang['User_quota_profile'] = 'Quota: %s';
$lang['Upload_percent_profile'] = '%d%% ca�o�ci';

// Common Variables
$lang['Bytes'] = 'Bajt�w';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';
$lang['Attach_search_query'] = 'Szukaj za��cznik�w';
$lang['Test_settings'] = 'Test ustawie�';
$lang['Not_assigned'] = 'Nie skojarzone';
$lang['No_file_comment_available'] = 'Brak komentarza do za��cznika';
$lang['Attachbox_limit'] = 'Wykorzystanie za��cznik�w w skrzynce: ';
$lang['No_quota_limit'] = 'Brak limitu Quoty';
$lang['Unlimited'] = 'Bez limitu';

?>