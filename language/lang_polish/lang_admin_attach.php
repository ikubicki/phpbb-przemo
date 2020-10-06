<?php
/***************************************************************************
 *                      lang_admin_attach.php [Polish]
 *                      -------------------
 *     begin            : Thu Feb 07 2002
 *     copyright        : (C) 2002 Meik Sievertsen
 *     email            : acyd.burn@gmx.de
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/




//
// Attachment Mod Admin Language Variables
//

// Modules, this replaces the keys used
$lang['Control_Panel'] = 'Panel kontrolny';
$lang['Shadow_attachments'] = 'Przeglądanie nieaktywnych załączników';
$lang['Forbidden_extensions'] = 'Usuń lub dodaj rozszerzenie załączników';
$lang['Extension_control'] = 'Kontrola rozszerzeń załączników';
$lang['Extension_group_manage'] = 'Kontrola rozszerzeń załączników dla grup';
$lang['Special_categories'] = 'Dodatkowe kategorie';
$lang['Sync_attachments'] = 'Synchronizuj załączniki';
$lang['Quota_limits'] = 'Limity Quoty';

// Attachments -> Management
$lang['Attach_settings'] = 'Ustawienia załączników';
$lang['Manage_attachments_explain'] = 'Tutaj możesz ustawić główne ustawienia modułu załączników. Gdy naciśniesz przycisk Testuj Ustawienia, moduł przez chwile będzie sprawdzał czy wszystko działa poprawnie. Jeśli masz problem z wysłaniem pliku, uruchom Test, żeby zobaczyć dokładne informacje o błędach.';
$lang['Attach_filesize_settings'] = 'Ustawienia rozmiarów załączników';
$lang['Attach_number_settings'] = 'Ustawienia numerów załączników';
$lang['Attach_options_settings'] = 'Ustawienia załączników';

$lang['Upload_directory'] = 'Katalog załączników';
$lang['Upload_directory_explain'] = 'Podaj ścieżkę od katalogu w którym masz forum. Na przykład \'files\' Przykład: adres forum: http://www.yourdomain.com/phpBB2 a katalog załączników: http://www.yourdomain.com/phpBB2/files.';
$lang['Attach_img_path'] = 'Ikony linków załączników';
$lang['Attach_img_path_explain'] = 'Ta ikona jest wyświetlana za linkiem do załącznika w postach użytkowników. Pozostaw to pole puste gdy nie chcesz żeby była wyświetlana. Będzie zastąpione przez Extension Groups Management.';
$lang['Attach_topic_icon'] = 'Ikony załączników w tematach';
$lang['Attach_topic_icon_explain'] = 'Ta ikona będzie wyświetlana przed tematem postu jeśli będzie w nim załącznik. Pozostaw to pole puste gdy nie chcesz żeby była wyświetlana.';
$lang['Attach_display_order'] = 'Kolejność wyświetlania załączników';
$lang['Attach_display_order_explain'] = 'Tutaj możesz ustalić w jakiej kolejności będą segregowane załączniki w postach lub prywatnych wiadomościach. Możesz ustawić (Najnowsze załączniki pierwsze) lub (Najstarsze załączniki pierwsze).';
$lang['Show_apcp'] = '"Zwinięty" sposób pokazywania pól dla załączników';
$lang['Show_apcp_explain'] = 'Przy zwiniętym, podczas pisania postu, trzeba kliknąć na link, po czym otworzy się pole do załączania plików. Przy rozwiniętym te pola będą widoczne zawsze.';

$lang['Max_filesize_attach'] = 'Rozmiar załączników';
$lang['Max_filesize_attach_explain'] = 'Maksymalny rozmiar załącznika w bajtach (bytes). Gdy ustawisz 0 rozmiar będzie nieograniczony.';
$lang['Attach_quota'] = 'Quota dyskowa';
$lang['Attach_quota_explain'] = 'Maksymalny rozmiar dla wszystkich załączników, uwarunkowany twoja quotą na koncie lub twoim dysku na serwerze.';
$lang['Max_filesize_pm'] = 'Maksymalny rozmiar załączników w skrzynce prywatnej';
$lang['Max_filesize_pm_explain'] = 'Maksymalny rozmiar załączników jaki może mieć użytkownik w swojej skrzynce na prywatne wiadomości.'; 
$lang['Default_quota_limit'] = 'Limity Quoty';
$lang['Default_quota_limit_explain'] = 'W tym miejscu możesz ustalić automatyczną ilość Quoty dyskowej dla nowych użytkowników oraz dla użytkowników bez przypisanej Quoty indywidualnej';

$lang['Max_attachments'] = 'Maksymalna ilość załączników - posty';
$lang['Max_attachments_explain'] = 'Maksymalna ilość załączników w jednym poście.';
$lang['Max_attachments_pm'] = 'Maksymalna ilość załączników - PM';
$lang['Max_attachments_pm_explain'] = 'Maksymalna ilość załączników w jednej prywatnej wiadomości.';

$lang['Disable_mod'] = 'Wyłącz moduł załączników';
$lang['Disable_mod_explain'] = 'Ta opcja wyłącza moduł załączników.';
$lang['PM_Attachments'] = 'Włącz załączniki w PM';
$lang['PM_Attachments_explain'] = 'Włącza lub wyłącza możliwość dodawania załączników w prywatnych wiadomościach';
$lang['Ftp_upload'] = 'Włącz upload FTP';
$lang['Ftp_upload_explain'] = 'Włącz lub wyłącz upload FTP. Jeśli włączysz musisz podać parametry FTP i katalogu do uploadu plików.';
$lang['Attachment_topic_review'] = 'Włączyć pokazywanie załączników podczas przeglądania tematów?';
$lang['Attachment_topic_review_explain'] = 'Jeśli włączysz ikona załączników będzie pokazywana kiedy odpowiesz na post.';

$lang['Ftp_server'] = 'FTP Upload Server';
$lang['Ftp_server_explain'] = 'Tutaj możesz podać IP adres lub Host name dla serwera gdzie będą kopiowane załączniki. Jeśli pozostawisz to pole puste, będzie w tym celu wykorzystany serwer gdzie masz zainstalowane forum. UWAGA nie można podawać adresu FTP w ten sposób: ftp:// lub podobny. Poprawny adres to na przykład: ftp.adres.serwera.pl lub adres IP co zmniejszy czas dostępu.';

$lang['Attach_ftp_path'] = 'Katalog uploadu plików';
$lang['Attach_ftp_path_explain'] = 'Podaj ścieżkę dostępu do katalogu gdzie będą umieszczane pliki. Nie podawaj tutaj adresu FTP, tylko ścieżkę dostępu do katalogu, adres podajesz wyżej.<br /> Na przykład, gdy twój adres do jakiegoś pliku na FTP wygląda tak: ftp://adres.serwera.pl/ogolne/pliki/jakis_plik.zip to w tym miejscu wpisujesz: /ogolne/pliki';
$lang['Ftp_download_path'] = 'Katalog downloadu plików';
$lang['Ftp_download_path_explain'] = 'To samo co wyżej tylko tutaj podajemy pełną ścieżkę np: ftp://adres.serwera.pl/ogolne/pliki';
$lang['Ftp_passive_mode'] = 'Tryb pasywny';
$lang['Ftp_passive_mode_explain'] = 'Tryb pasywny wymaga aby zdalny serwer miał otwarty port dla połączenia i zwracał adres dla tego portu i nasłuchiwał na tym porcie';

$lang['No_ftp_extensions_installed'] = 'Niestety nie możesz użyć uploadu FTP gdyż serwer PHP nie obsługuje uploadu FTP';

// Attachments -> Shadow Attachments
$lang['Shadow_attachments_explain'] = 'Tutaj możesz skasować stare lub "nie działające" załączniki, możesz to sprawdzić klikając na nie';
$lang['Shadow_attachments_file_explain'] = 'Załączniki które znajdują się w katalogu załączników a nie ma ich w bazie załączników, w żadnym poście ani prywatnej wiadomości.';
$lang['Shadow_attachments_row_explain'] = 'Załączniki które znajdują się w katalogu załączników a nie ma ich w żadnym poście ani prywatnej wiadomości.';
$lang['Empty_file_entry'] = 'Pusty plik';

// Attachments -> Sync
$lang['Sync_thumbnail_resetted'] = 'Miniatura zresetowana dla załącznika: %s'; // replace %s with physical Filename
$lang['Attach_sync_finished'] = 'Synchronizacja załączników zakończona.';

// Extensions -> Extension Control
$lang['Manage_extensions'] = 'Ustawienia zezwoleń rozszerzeń załączników';
$lang['Manage_extensions_explain'] = 'Tutaj możesz ustalić jakie rozszerzenia załączników będą akceptowane.';
$lang['Explanation'] = 'Opis';
$lang['Extension_group'] = 'Rozszerzeń załączników dla grup';
$lang['Extension_exist'] = 'Rozszerzenie %s już istnieje'; // replace %s with the Extension
$lang['Unable_add_forbidden_extension'] = 'Rozszerzenie %s nie znalezione, nie możesz ustawić takiego rozszerzenia'; // replace %s with Extension

// Extensions -> Extension Groups Management
$lang['Manage_extension_groups'] = 'Ustawienia rozszerzeń załączników grup';
$lang['Manage_extension_groups_explain'] = 'Tutaj możesz dodawać, kasować i zmieniać rozszerzenia grup, możesz wyłączyć Rozszerzenia Grup, przypisać specjalną kategorię, zmienić ustawienia downloadu, ustawić ikonę uploadu która jest wyświetlana przed Grupami Rozszerzeń.';
$lang['Special_category'] = 'Kategoria specjalna';
$lang['Category_images'] = 'Ikony załączników';
$lang['Category_stream_files'] = 'Pliki Stream';
$lang['Category_swf_files'] = 'Pliki Flash';
$lang['Allowed'] = 'Zezwól';
$lang['Allowed_forums'] = 'Zezwól na forum';
$lang['Ext_group_permissions'] = 'Prawa grup';
$lang['Download_mode'] = 'Sposób ściągania';
$lang['Upload_icon'] = 'Prześlij ikonę';
$lang['Max_groups_filesize'] = 'Maksymalny rozmiar pliku';
$lang['Extension_group_exist'] = 'Rozszerzenie %s dla grupy już istnieje'; // replace %s with the group name
$lang['Collapse'] = '+';
$lang['Decollapse'] = '-';

// Extensions -> Special Categories
$lang['Manage_categories'] = 'Ustawienia specjalnych kategorii';
$lang['Manage_categories_explain'] = 'Tutaj możesz ustawić specjalne kategorie.';
$lang['Settings_cat_images'] = 'Ustawienia Specjalnych Kategorii: Ikony';
$lang['Settings_cat_streams'] = 'Ustawienia Specjalnych Kategorii: Pliki Stream';
$lang['Settings_cat_flash'] = 'Ustawienia Specjalnych Kategorii: Pliki Flash';
$lang['Display_inlined'] = 'Obrazek jako link';
$lang['Display_inlined_explain'] = 'Ustaw czy obrazek ma być pokazywany w poście (Tak) czy ma być linkiem do obrazka';
$lang['Max_image_size'] = 'Maksymalny rozmiar obrazka';
$lang['Max_image_size_explain'] = 'Tutaj ustawiasz maksymalny dozwolony rozmiar obrazka (Wysokość i szerokość w pikselach).<br />Jeśli podasz wartość 0 nie będzie ograniczenia, lecz zbyt duży obrazek może nie pracować poprawnie z PHP.';
$lang['Image_link_size'] = 'Zamiana na link zbyt dużego obrazka';
$lang['Image_link_size_explain'] = 'Jeśli załączony obrazek przekroczy podane wartości, system wyświetli tylko link do niego. Jeśli podasz wartości 0 nie będzie ograniczenia, lecz zbyt duże zdjęcia mogą nie pracować poprawnie w PHP.';
$lang['Assigned_group'] = 'Wyznaczona grupa';

$lang['Image_create_thumbnail'] = 'Tworzenie minigalerii';
$lang['Image_create_thumbnail_explain'] = 'Ta opcja tworzy i wyświetla tylko miniaturki załączonych zdjęć (jeśli są większe niż maksymalny podany poniżej rozmiar zdjęć galerii), które są linkami do zdjęć w oryginalnych rozmiarach. Opcja ta wymaga zainstalowanego programu: Imagick, jeśli nie wiesz czy na serwerze jest on zainstalowany, użyj poniżej przycisku "Znajdź Imagick" Jeśli jest on zainstalowany na serwerze, ścieżka do aplikacji zostanie automatycznie wpisana w pole "Imagick (Pełna ścieżka)" jeśli skrypt nie odnajdzie ścieżki, zapytaj administratora i wpisz ścieżkę ręcznie.';
$lang['Image_min_thumb_filesize'] = 'Maksymalny rozmiar zdjęć minigalerii';
$lang['Image_min_thumb_filesize_explain'] = 'Jeśli załączane zdjęcia będą przekraczały podaną wielkość i jest zainstalowany Imagick na serwerze, oraz ścieżka jest podana prawidłowo, galeria zostanie utworzona.';
$lang['Image_imagick_path'] = 'Imagick (Pełna ścieżka)';
$lang['Image_imagick_path_explain'] = 'Podaj pełną ścieżkę do programu: Imagick, przykład pod systemami Unixowymi: /usr/bin/convert lub windowsowymi: c:/imagemagick/convert.exe Jeśli jej nie znasz, użyj przycisku "Znajdź Imagick" lub zapytaj administratora.';
$lang['Image_search_imagick'] = 'Znajdź Imagick';

$lang['Use_gd2'] = 'Użyj kompresji GD2';
$lang['Use_gd2_explain'] = 'PHP posiada możliwość współpracy z mechanizmami GD1 oraz GD2 przy przetwarzaniu obrazów, należy je wybrać indywidualnie według jakości uzyskiwanych obrazów';
$lang['Attachment_version'] = 'Wersja modułu załączników: %s'; // %s is the version number

// Extensions -> Forbidden Extensions
$lang['Manage_forbidden_extensions'] = 'Ustawianie niedozwolonych rozszerzeń plików';
$lang['Manage_forbidden_extensions_explain'] = 'Tutaj możesz dodać lub usunąć niedozwolone rozszerzenia plików. Rozszerzenia php, php3 i php4 są zabronione z powodów bezpieczeństwa, jeśli możesz nie kasuj.';
$lang['Forbidden_extension_exist'] = 'Rozszerzenie %s już istnieje'; // replace %s with the extension
$lang['Extension_exist_forbidden'] = 'Rozszerzenie %s jest w tej chwili ustawione jako zezwolone, najpierw usuń je z listy rozszerzeń zezwolonych';  // replace %s with the extension

// Extensions -> Extension Groups Control -> Group Permissions
$lang['Group_permissions_title'] = 'Prawa rozszerzeń dla grupy -> \'%s\''; // Replace %s with the Groups Name
$lang['Group_permissions_explain'] = 'Tutaj możesz ustawić właściwości rozszerzeń grup dla danego forum (podanych w polu zezwoleń for). Standardowym ustawieniem jest zezwolenie userom na zamieszczanie plików w dowolnym forum.';
$lang['Note_admin_empty_group_permissions'] = 'NOTE:<br />Within the below listed Forums your Users are normally allowed to attach files, but since no Extension Group is allowed to be attached there, your Users are unable to attach anything. If they try, they will receive Error Messages. Maybe you want to set the Permission \'Post Files\' to ADMIN at these Forums.<br /><br />';
$lang['Add_forums'] = 'Dodaj fora';
$lang['Add_selected'] = 'Dodaj wybrane';
$lang['Perm_all_forums'] = 'WSZYSTKIE FORA';

// Attachments -> Quota Limits
$lang['Manage_quotas'] = 'Zarządzanie limitami Quoty dyskowej';
$lang['Manage_quotas_explain'] = 'W tym miejscu możesz dodać/usunąć/zmienić limity quoty. Możesz przypisać quotę do użytkowników i grup. Aby przypisać limit quoty dla użytkownika przejdź do edycji jego danych. Aby przypisać quotę dla grup, przejdź do edycji danych grupy.';
$lang['Assigned_users'] = 'Przypisani użytkownicy';
$lang['Assigned_groups'] = 'Przypisane grupy';
$lang['Quota_limit_exist'] = 'Limit quoty %s istnieje.'; // Replace %s with the Quota Description

// Attachments -> Control Panel
$lang['Control_panel_title'] = 'Panel kontrolny załączników';
$lang['Control_panel_explain'] = 'Tutaj możesz przeglądać i ustawiać wszystkie załączniki wysłane przez użytkowników';
$lang['File_comment_cp'] = 'Komentarz załącznika';

// Control Panel -> Search
$lang['Search_wildcard_explain'] = 'Użyj * by zastąpić jakiś ciąg znaków';
$lang['Size_smaller_than'] = 'Rozmiar (w bajtach) załącznika jest mniejsza niż';
$lang['Size_greater_than'] = 'Rozmiar (w bajtach) załącznika jest większa niż';
$lang['Count_smaller_than'] = 'Liczba ściągnięć jest mniejsza niż';
$lang['Count_greater_than'] = 'Liczba ściągnięć jest większa niż';
$lang['More_days_old'] = 'Załączone X dni wstecz.';
$lang['No_attach_search_match'] = 'Nie znaleziono załączników spełniające te kryteria';

// Control Panel -> Statistics
$lang['Number_of_attachments'] = 'Ilość załączników';
$lang['Total_filesize'] = 'Łączny rozmiar wszystkich załączników';
$lang['Number_posts_attach'] = 'Ilość postów z załącznikami';
$lang['Number_topics_attach'] = 'Ilość tematów z załącznikami';
$lang['Number_users_attach'] = 'Ilość użytkowników którzy załączyli pliki';
$lang['Number_pms_attach'] = 'Całkowita ilość załączników w prywatnych wiadomościach';

// Control Panel -> Attachments
$lang['Statistics_for_user'] = 'Statystyki załączników dla użytkownika %s'; // replace %s with username
$lang['Size_in_kb'] = 'Rozmiar (KB)';
$lang['Downloads'] = 'Ściągnięto';
$lang['Post_time'] = 'Data postu';
$lang['Posted_in_topic'] = 'Post w temacie';
$lang['Submit_changes'] = 'Zachowaj zmiany';

// Sort Types
$lang['Sort_Attachments'] = 'Załączniki';
$lang['Sort_Size'] = 'Rozmiar';
$lang['Sort_Filename'] = 'Nazwa pliku';
$lang['Sort_Comment'] = 'Komentarz do załącznika';
$lang['Sort_Extension'] = 'Rozszerzenie';
$lang['Sort_Downloads'] = 'Ściągnięto';
$lang['Sort_Posttime'] = 'Data postu';

// View Types
$lang['View_Statistic'] = 'Statystyki';
$lang['View_Search'] = 'Szukaj';
$lang['View_Username'] = 'Użytkownik';
$lang['View_Attachments'] = 'Załączniki';

// Successfully updated
$lang['Attach_config_updated'] = 'Konfiguracja załączników uaktualniona pomyślnie';
$lang['Click_return_attach_config'] = 'Kliknij %stutaj%s żeby powrócić do konfiguracji załączników';
$lang['Test_settings_successful'] = 'Test konfiguracji zakończony, wszystko wygląda dobrze.';

// Some basic definitions
$lang['Attachments'] = 'Załączniki';
$lang['Attachment'] = 'Załącznik';
$lang['Extension'] = 'Rozszerzenie';

// Auth pages
$lang['Auth_attach'] = 'Post załącznika';
$lang['Auth_download'] = 'Ściągnij załączniki';

?>