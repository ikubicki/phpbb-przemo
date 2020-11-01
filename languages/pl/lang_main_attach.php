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
$lang['Rules_attach_can'] = '<b>Możesz</b> załączać pliki na tym forum';
$lang['Rules_attach_cannot'] = '<b>Nie możesz</b> załączać plików na tym forum';
$lang['Rules_download_can'] = '<b>Możesz</b> ściągać załączniki na tym forum';
$lang['Rules_download_cannot'] = '<b>Nie możesz</b> ściągać załączników na tym forum';
$lang['Sorry_auth_view_attach'] = 'Nie masz zezwolenia na ściąganie lub przeglądanie załączników na tym forum.';

// Viewtopic -> Display of Attachments
$lang['Description'] = 'Opis'; // used in Administration Panel too...
$lang['Downloaded'] = 'Pobrań';
$lang['Download'] = 'Pobierz'; // this Language Variable is defined in lang_admin.php too, but we are unable to access it from the main Language File
$lang['Filesize'] = 'Rozmiar';
$lang['Viewed'] = 'Wyświetleń';
$lang['Download_number'] = 'Plik ściągnięto %d raz(y)'; // replace %d with count
$lang['Extension_disabled_after_posting'] = 'Rozszerzenie \'%s\' usunięte z forum przez admina, dlatego załącznik nie będzie pokazany.'; // used in Posts and PM's, replace %s with mime type

// Posting/PM -> Initial Display
$lang['Attach_posting_cp'] = 'Panel kontrolny załączania plików';
$lang['Attach_posting_cp_explain'] = 'Jeśli klikniesz na "Załącz plik", zobaczysz pole na dodanie załącznika.<br />Jeśli klikniesz na załączony plik, zobaczysz liste załączonych plików, będzie można ją zmienić.<br />Jeśli chcesz "nadpisać" (Wysłać nowszą wersję pliku) na istniejący juz załącznik, musisz kliknąć na linku, nie dodawaj pliku drugi raz.';

// Posting/PM -> Posting Attachments
$lang['Add_attachment'] = 'Dodaj załącznik';
$lang['Add_attachment_title'] = 'Załącz plik';
$lang['Add_attachment_explain'] = 'Jeśli nie chcesz załączać pliku do tego postu, pozostaw to pole puste';
$lang['File_name'] = 'Nazwa załącznika';
$lang['File_comment'] = 'Komentarz załącznika';

// Posting/PM -> Posted Attachments
$lang['Posted_attachments'] = 'Załączony plik';
$lang['Options'] = 'Opcje';
$lang['Update_comment'] = 'Zmień komentarz';
$lang['Delete_attachments'] = 'Usuń załączniki';
$lang['Delete_attachment'] = 'Usuń załącznik';
$lang['Delete_thumbnail'] = 'Usuń miniaturę';
$lang['Upload_new_version'] = 'Wyślij uaktualniony plik';

// Errors -> Posting Attachments
$lang['Invalid_filename'] = '%s jest nieprawidłową nazwą'; // replace %s with given filename
$lang['Attachment_php_size_na'] = 'Plik ma za duży rozmiar.<br />Nie można pobrać wielkości pliku zdefiniowanej w PHP.';
$lang['Attachment_php_size_overrun'] = 'Plik ma za duży rozmiar.<br />Maksymalny dozwolony rozmiar to: %d MB.'; // replace %d with ini_get('upload_max_filesize')
$lang['Disallowed_extension'] = 'Rozszerzenie %s jest niedozwolone'; // replace %s with extension (e.g. .php) 
$lang['Disallowed_extension_within_forum'] = 'Nie masz uprawnień do załączania plików z rozszerzeniem %s na tym forum'; // replace %s with the Extension
$lang['Attachment_too_big'] = 'Plik ma za duży rozmiar.<br />Maksymalny dozwolony rozmiar to: %d %s'; // replace %d with maximum file size, %s with size var
$lang['Attach_quota_reached'] = 'Niestety Limit na wszystkie załączniki na tym forum został przekroczony. Prosze skontaktować się z administratorem forum.';
$lang['Too_many_attachments'] = 'Plik nie może być załączony, limit %d w tym poście został przekroczony'; // replace %d with maximum number of attachments
$lang['Error_imagesize'] = 'Załącznik-obraz musi być mniejszy niż %d pixeli szerokości i %d pixeli wysokości'; 
$lang['General_upload_error'] = 'Błąd wysyłania załącznika (nie można skopiować do określonego katalogu: %s, skontaktuj się z administratorem forum.'; // replace %s with local path

$lang['Error_empty_add_attachbox'] = 'Musisz podać wartość w polu \'Dodaj załącznik\'.';
$lang['Error_missing_old_entry'] = 'Nie można uaktualnić pliku, nie znaleziono starego załącznika';

// Errors -> PM Related
$lang['Attach_quota_sender_pm_reached'] = 'Pojemność twojej prywatnej skrzynki na załączniki została przekroczona. Usuń kilka starych plików i spróbuj ponownie.';
$lang['Attach_quota_receiver_pm_reached'] = 'Maksymalna dozwolona ilość plików w skrzynce odbiorcy, została przekroczona. Poinformuj go o tym, lub poczekaj aż miejsce zostanie zwolnione.';

// Errors -> Download
$lang['No_attachment_selected'] = 'Nie ma zaznaczonego załącznika do ściągnięcia lub pokazania.';
$lang['Error_no_attachment'] = 'Wybrany załącznik już nie istnieje';

// Delete Attachments
$lang['Confirm_delete_attachments'] = 'Czy na pewno skasować wybrane załączniki?';
$lang['Error_deleted_attachments'] = 'Could not delete Attachments.';

// General Error Messages
$lang['file_not_delete'] = 'Nie możesz usunąć tego pliku.';
$lang['Attachment_feature_disabled'] = 'Ta cecha pliku jest wyłączona.';

$lang['Directory_does_not_exist'] = 'Katalog \'%s\' nie istnieje lub nie został znaleziony.'; // replace %s with directory
$lang['Directory_is_not_a_dir'] = 'Sprawdz czy \'%s\' jest katalogiem.'; // replace %s with directory
$lang['Directory_not_writeable'] = 'Katalog \'%s\' nie ma praw do zapisu. Musisz utworzyć ścieżkę i katalog z prawami do zapisu (chmod -R nazwa_katalogu 777) (lub sprawdz właściciela katalogu).<br />If you have only plain ftp-access change the \'Attribute\' of the directory to rwxrwxrwx.'; // replace %s with directory

$lang['Ftp_error_connect'] = 'Nie moge się połączyć z serwerem FTP: \'%s\'. Sprawdz ustawienia serwera.';
$lang['Ftp_error_login'] = 'Nie mogę się zalogować na serwer FTP. Użytkownik \'%s\' lub hasło nieprawidlowe. Sprawdz ustawienia serwera FTP.';
$lang['Ftp_error_path'] = 'Brak dostępu do serwera FTP: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_upload'] = 'Nie moge skopiować pliku do katalogu: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_delete'] = 'Nie mogę usunąć pliku z katalogu: \'%s\'. Sprawdz ustawienia FTP.';
$lang['Ftp_error_pasv_mode'] = 'Błąd włączenia/wyłączenia Trybu pasywnego';

// Attach Rules Window
$lang['Rules_page'] = 'Ustawienia załączników';
$lang['Attach_rules_title'] = 'Dozwolone rozszerzenia i rozmiary załączników dla grup';
$lang['Group_rule_header'] = 'Maksymalny rozmiar %s to: %s'; // Replace first %s with Extension Group, second one with the Size STRING
$lang['Allowed_extensions_and_sizes'] = 'Dozwolone rozszerzenia i rozmiary';
$lang['Note_user_empty_group_permissions'] = 'NOTKA:<br />You are normally allowed to attach files within this Forum, <br />but since no Extension Group is allowed to be attached here, <br />you are unable to attach anything. If you try, <br />you will receive an Error Message.<br />';

// Quota Variables
$lang['Upload_quota'] = 'Quota Uploadu';
$lang['Pm_quota'] = 'Quota w prywatnych wiadomościach';
$lang['User_upload_quota_reached'] = 'Przekroczył' .  (($he) ? 'e' : 'a') . 'ś maksymalny limit uploadu (%d %s)'; // replace %d with Size, %s with Size Lang (MB for example)

// User Attachment Control Panel
$lang['User_acp_title'] = 'Panel Użytkowników';
$lang['UACP'] = 'Panel kontrolny załączników';
$lang['User_uploaded_profile'] = 'Upload całkowity: %s';
$lang['User_quota_profile'] = 'Quota: %s';
$lang['Upload_percent_profile'] = '%d%% całości';

// Common Variables
$lang['Bytes'] = 'Bajtów';
$lang['KB'] = 'KB';
$lang['MB'] = 'MB';
$lang['Attach_search_query'] = 'Szukaj załączników';
$lang['Test_settings'] = 'Test ustawień';
$lang['Not_assigned'] = 'Nie skojarzone';
$lang['No_file_comment_available'] = 'Brak komentarza do załącznika';
$lang['Attachbox_limit'] = 'Wykorzystanie załączników w skrzynce: ';
$lang['No_quota_limit'] = 'Brak limitu Quoty';
$lang['Unlimited'] = 'Bez limitu';

?>