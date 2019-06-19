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
$lang['Shadow_attachments'] = 'Przegl±danie nieaktywnych za³±czników';
$lang['Forbidden_extensions'] = 'Usuñ lub dodaj rozszerzenie za³±czników';
$lang['Extension_control'] = 'Kontrola rozszerzeñ za³±czników';
$lang['Extension_group_manage'] = 'Kontrola rozszerzeñ za³±czników dla grup';
$lang['Special_categories'] = 'Dodatkowe kategorie';
$lang['Sync_attachments'] = 'Synchronizuj za³±czniki';
$lang['Quota_limits'] = 'Limity Quoty';

// Attachments -> Management
$lang['Attach_settings'] = 'Ustawienia za³±czników';
$lang['Manage_attachments_explain'] = 'Tutaj mo¿esz ustawiæ g³ówne ustawienia modu³u za³±czników. Gdy naci¶niesz przycisk Testuj Ustawienia, modu³ przez chwile bêdzie sprawdza³ czy wszystko dzia³a poprawnie. Je¶li masz problem z wys³aniem pliku, uruchom Test, ¿eby zobaczyæ dok³adne informacje o b³êdach.';
$lang['Attach_filesize_settings'] = 'Ustawienia rozmiarów za³±czników';
$lang['Attach_number_settings'] = 'Ustawienia numerów za³±czników';
$lang['Attach_options_settings'] = 'Ustawienia za³±czników';

$lang['Upload_directory'] = 'Katalog za³±czników';
$lang['Upload_directory_explain'] = 'Podaj ¶cie¿kê od katalogu w którym masz forum. Na przyk³ad \'files\' Przyk³ad: adres forum: http://www.yourdomain.com/phpBB2 a katalog za³±czników: http://www.yourdomain.com/phpBB2/files.';
$lang['Attach_img_path'] = 'Ikony linków za³±czników';
$lang['Attach_img_path_explain'] = 'Ta ikona jest wy¶wietlana za linkiem do za³±cznika w postach u¿ytkowników. Pozostaw to pole puste gdy nie chcesz ¿eby by³a wy¶wietlana. Bêdzie zast±pione przez Extension Groups Management.';
$lang['Attach_topic_icon'] = 'Ikony za³±czników w tematach';
$lang['Attach_topic_icon_explain'] = 'Ta ikona bêdzie wy¶wietlana przed tematem postu je¶li bêdzie w nim za³±cznik. Pozostaw to pole puste gdy nie chcesz ¿eby by³a wy¶wietlana.';
$lang['Attach_display_order'] = 'Kolejno¶æ wy¶wietlania za³±czników';
$lang['Attach_display_order_explain'] = 'Tutaj mo¿esz ustaliæ w jakiej kolejno¶ci bêd± segregowane za³±czniki w postach lub prywatnych wiadomo¶ciach. Mo¿esz ustawiæ (Najnowsze za³±czniki pierwsze) lub (Najstarsze za³±czniki pierwsze).';
$lang['Show_apcp'] = '"Zwiniêty" sposób pokazywania pól dla za³±czników';
$lang['Show_apcp_explain'] = 'Przy zwiniêtym, podczas pisania postu, trzeba klikn±æ na link, po czym otworzy siê pole do za³±czania plików. Przy rozwiniêtym te pola bêd± widoczne zawsze.';

$lang['Max_filesize_attach'] = 'Rozmiar za³±czników';
$lang['Max_filesize_attach_explain'] = 'Maksymalny rozmiar za³±cznika w bajtach (bytes). Gdy ustawisz 0 rozmiar bêdzie nieograniczony.';
$lang['Attach_quota'] = 'Quota dyskowa';
$lang['Attach_quota_explain'] = 'Maksymalny rozmiar dla wszystkich za³±czników, uwarunkowany twoja quot± na koncie lub twoim dysku na serwerze.';
$lang['Max_filesize_pm'] = 'Maksymalny rozmiar za³±czników w skrzynce prywatnej';
$lang['Max_filesize_pm_explain'] = 'Maksymalny rozmiar za³±czników jaki mo¿e mieæ u¿ytkownik w swojej skrzynce na prywatne wiadomo¶ci.'; 
$lang['Default_quota_limit'] = 'Limity Quoty';
$lang['Default_quota_limit_explain'] = 'W tym miejscu mo¿esz ustaliæ automatyczn± ilo¶æ Quoty dyskowej dla nowych u¿ytkowników oraz dla u¿ytkowników bez przypisanej Quoty indywidualnej';

$lang['Max_attachments'] = 'Maksymalna ilo¶æ za³±czników - posty';
$lang['Max_attachments_explain'] = 'Maksymalna ilo¶æ za³±czników w jednym po¶cie.';
$lang['Max_attachments_pm'] = 'Maksymalna ilo¶æ za³±czników - PM';
$lang['Max_attachments_pm_explain'] = 'Maksymalna ilo¶æ za³±czników w jednej prywatnej wiadomo¶ci.';

$lang['Disable_mod'] = 'Wy³±cz modu³ za³±czników';
$lang['Disable_mod_explain'] = 'Ta opcja wy³±cza modu³ za³±czników.';
$lang['PM_Attachments'] = 'W³±cz za³±czniki w PM';
$lang['PM_Attachments_explain'] = 'W³±cza lub wy³±cza mo¿liwo¶æ dodawania za³±czników w prywatnych wiadomo¶ciach';
$lang['Ftp_upload'] = 'W³±cz upload FTP';
$lang['Ftp_upload_explain'] = 'W³±cz lub wy³±cz upload FTP. Je¶li w³±czysz musisz podaæ parametry FTP i katalogu do uploadu plików.';
$lang['Attachment_topic_review'] = 'W³±czyæ pokazywanie za³±czników podczas przegl±dania tematów?';
$lang['Attachment_topic_review_explain'] = 'Je¶li w³±czysz ikona za³±czników bêdzie pokazywana kiedy odpowiesz na post.';

$lang['Ftp_server'] = 'FTP Upload Server';
$lang['Ftp_server_explain'] = 'Tutaj mo¿esz podaæ IP adres lub Host name dla serwera gdzie bêd± kopiowane za³±czniki. Je¶li pozostawisz to pole puste, bêdzie w tym celu wykorzystany serwer gdzie masz zainstalowane forum. UWAGA nie mo¿na podawaæ adresu FTP w ten sposób: ftp:// lub podobny. Poprawny adres to na przyk³ad: ftp.adres.serwera.pl lub adres IP co zmniejszy czas dostêpu.';

$lang['Attach_ftp_path'] = 'Katalog uploadu plików';
$lang['Attach_ftp_path_explain'] = 'Podaj ¶cie¿kê dostêpu do katalogu gdzie bêd± umieszczane pliki. Nie podawaj tutaj adresu FTP, tylko ¶cie¿kê dostêpu do katalogu, adres podajesz wy¿ej.<br /> Na przyk³ad, gdy twój adres do jakiego¶ pliku na FTP wygl±da tak: ftp://adres.serwera.pl/ogolne/pliki/jakis_plik.zip to w tym miejscu wpisujesz: /ogolne/pliki';
$lang['Ftp_download_path'] = 'Katalog downloadu plików';
$lang['Ftp_download_path_explain'] = 'To samo co wy¿ej tylko tutaj podajemy pe³n± ¶cie¿kê np: ftp://adres.serwera.pl/ogolne/pliki';
$lang['Ftp_passive_mode'] = 'Tryb pasywny';
$lang['Ftp_passive_mode_explain'] = 'Tryb pasywny wymaga aby zdalny serwer mia³ otwarty port dla po³±czenia i zwraca³ adres dla tego portu i nas³uchiwa³ na tym porcie';

$lang['No_ftp_extensions_installed'] = 'Niestety nie mo¿esz u¿yæ uploadu FTP gdy¿ serwer PHP nie obs³uguje uploadu FTP';

// Attachments -> Shadow Attachments
$lang['Shadow_attachments_explain'] = 'Tutaj mo¿esz skasowaæ stare lub "nie dzia³aj±ce" za³±czniki, mo¿esz to sprawdziæ klikaj±c na nie';
$lang['Shadow_attachments_file_explain'] = 'Za³±czniki które znajduj± siê w katalogu za³±czników a nie ma ich w bazie za³±czników, w ¿adnym po¶cie ani prywatnej wiadomo¶ci.';
$lang['Shadow_attachments_row_explain'] = 'Za³±czniki które znajduj± siê w katalogu za³±czników a nie ma ich w ¿adnym po¶cie ani prywatnej wiadomo¶ci.';
$lang['Empty_file_entry'] = 'Pusty plik';

// Attachments -> Sync
$lang['Sync_thumbnail_resetted'] = 'Miniatura zresetowana dla za³±cznika: %s'; // replace %s with physical Filename
$lang['Attach_sync_finished'] = 'Synchronizacja za³±czników zakoñczona.';

// Extensions -> Extension Control
$lang['Manage_extensions'] = 'Ustawienia zezwoleñ rozszerzeñ za³±czników';
$lang['Manage_extensions_explain'] = 'Tutaj mo¿esz ustaliæ jakie rozszerzenia za³±czników bêd± akceptowane.';
$lang['Explanation'] = 'Opis';
$lang['Extension_group'] = 'Rozszerzeñ za³±czników dla grup';
$lang['Extension_exist'] = 'Rozszerzenie %s ju¿ istnieje'; // replace %s with the Extension
$lang['Unable_add_forbidden_extension'] = 'Rozszerzenie %s nie znalezione, nie mo¿esz ustawiæ takiego rozszerzenia'; // replace %s with Extension

// Extensions -> Extension Groups Management
$lang['Manage_extension_groups'] = 'Ustawienia rozszerzeñ za³±czników grup';
$lang['Manage_extension_groups_explain'] = 'Tutaj mo¿esz dodawaæ, kasowaæ i zmieniaæ rozszerzenia grup, mo¿esz wy³±czyæ Rozszerzenia Grup, przypisaæ specjaln± kategoriê, zmieniæ ustawienia downloadu, ustawiæ ikonê uploadu która jest wy¶wietlana przed Grupami Rozszerzeñ.';
$lang['Special_category'] = 'Kategoria specjalna';
$lang['Category_images'] = 'Ikony za³±czników';
$lang['Category_stream_files'] = 'Pliki Stream';
$lang['Category_swf_files'] = 'Pliki Flash';
$lang['Allowed'] = 'Zezwól';
$lang['Allowed_forums'] = 'Zezwól na forum';
$lang['Ext_group_permissions'] = 'Prawa grup';
$lang['Download_mode'] = 'Sposób ¶ci±gania';
$lang['Upload_icon'] = 'Prze¶lij ikonê';
$lang['Max_groups_filesize'] = 'Maksymalny rozmiar pliku';
$lang['Extension_group_exist'] = 'Rozszerzenie %s dla grupy ju¿ istnieje'; // replace %s with the group name
$lang['Collapse'] = '+';
$lang['Decollapse'] = '-';

// Extensions -> Special Categories
$lang['Manage_categories'] = 'Ustawienia specjalnych kategorii';
$lang['Manage_categories_explain'] = 'Tutaj mo¿esz ustawiæ specjalne kategorie.';
$lang['Settings_cat_images'] = 'Ustawienia Specjalnych Kategorii: Ikony';
$lang['Settings_cat_streams'] = 'Ustawienia Specjalnych Kategorii: Pliki Stream';
$lang['Settings_cat_flash'] = 'Ustawienia Specjalnych Kategorii: Pliki Flash';
$lang['Display_inlined'] = 'Obrazek jako link';
$lang['Display_inlined_explain'] = 'Ustaw czy obrazek ma byæ pokazywany w po¶cie (Tak) czy ma byæ linkiem do obrazka';
$lang['Max_image_size'] = 'Maksymalny rozmiar obrazka';
$lang['Max_image_size_explain'] = 'Tutaj ustawiasz maksymalny dozwolony rozmiar obrazka (Wysoko¶æ i szeroko¶æ w pikselach).<br />Je¶li podasz warto¶æ 0 nie bêdzie ograniczenia, lecz zbyt du¿y obrazek mo¿e nie pracowaæ poprawnie z PHP.';
$lang['Image_link_size'] = 'Zamiana na link zbyt du¿ego obrazka';
$lang['Image_link_size_explain'] = 'Je¶li za³±czony obrazek przekroczy podane warto¶ci, system wy¶wietli tylko link do niego. Je¶li podasz warto¶ci 0 nie bêdzie ograniczenia, lecz zbyt du¿e zdjêcia mog± nie pracowaæ poprawnie w PHP.';
$lang['Assigned_group'] = 'Wyznaczona grupa';

$lang['Image_create_thumbnail'] = 'Tworzenie minigalerii';
$lang['Image_create_thumbnail_explain'] = 'Ta opcja tworzy i wy¶wietla tylko miniaturki za³±czonych zdjêæ (je¶li s± wiêksze ni¿ maksymalny podany poni¿ej rozmiar zdjêæ galerii), które s± linkami do zdjêæ w oryginalnych rozmiarach. Opcja ta wymaga zainstalowanego programu: Imagick, je¶li nie wiesz czy na serwerze jest on zainstalowany, u¿yj poni¿ej przycisku "Znajd¼ Imagick" Je¶li jest on zainstalowany na serwerze, ¶cie¿ka do aplikacji zostanie automatycznie wpisana w pole "Imagick (Pe³na ¶cie¿ka)" je¶li skrypt nie odnajdzie ¶cie¿ki, zapytaj administratora i wpisz ¶cie¿kê rêcznie.';
$lang['Image_min_thumb_filesize'] = 'Maksymalny rozmiar zdjêæ minigalerii';
$lang['Image_min_thumb_filesize_explain'] = 'Je¶li za³±czane zdjêcia bêd± przekracza³y podan± wielko¶æ i jest zainstalowany Imagick na serwerze, oraz ¶cie¿ka jest podana prawid³owo, galeria zostanie utworzona.';
$lang['Image_imagick_path'] = 'Imagick (Pe³na ¶cie¿ka)';
$lang['Image_imagick_path_explain'] = 'Podaj pe³n± ¶cie¿kê do programu: Imagick, przyk³ad pod systemami Unixowymi: /usr/bin/convert lub windowsowymi: c:/imagemagick/convert.exe Je¶li jej nie znasz, u¿yj przycisku "Znajd¼ Imagick" lub zapytaj administratora.';
$lang['Image_search_imagick'] = 'Znajd¼ Imagick';

$lang['Use_gd2'] = 'U¿yj kompresji GD2';
$lang['Use_gd2_explain'] = 'PHP posiada mo¿liwo¶æ wspó³pracy z mechanizmami GD1 oraz GD2 przy przetwarzaniu obrazów, nale¿y je wybraæ indywidualnie wed³ug jako¶ci uzyskiwanych obrazów';
$lang['Attachment_version'] = 'Wersja modu³u za³±czników: %s'; // %s is the version number

// Extensions -> Forbidden Extensions
$lang['Manage_forbidden_extensions'] = 'Ustawianie niedozwolonych rozszerzeñ plików';
$lang['Manage_forbidden_extensions_explain'] = 'Tutaj mo¿esz dodaæ lub usun±æ niedozwolone rozszerzenia plików. Rozszerzenia php, php3 i php4 s± zabronione z powodów bezpieczeñstwa, je¶li mo¿esz nie kasuj.';
$lang['Forbidden_extension_exist'] = 'Rozszerzenie %s ju¿ istnieje'; // replace %s with the extension
$lang['Extension_exist_forbidden'] = 'Rozszerzenie %s jest w tej chwili ustawione jako zezwolone, najpierw usuñ je z listy rozszerzeñ zezwolonych';  // replace %s with the extension

// Extensions -> Extension Groups Control -> Group Permissions
$lang['Group_permissions_title'] = 'Prawa rozszerzeñ dla grupy -> \'%s\''; // Replace %s with the Groups Name
$lang['Group_permissions_explain'] = 'Tutaj mo¿esz ustawiæ w³a¶ciwo¶ci rozszerzeñ grup dla danego forum (podanych w polu zezwoleñ for). Standardowym ustawieniem jest zezwolenie userom na zamieszczanie plików w dowolnym forum.';
$lang['Note_admin_empty_group_permissions'] = 'NOTE:<br />Within the below listed Forums your Users are normally allowed to attach files, but since no Extension Group is allowed to be attached there, your Users are unable to attach anything. If they try, they will receive Error Messages. Maybe you want to set the Permission \'Post Files\' to ADMIN at these Forums.<br /><br />';
$lang['Add_forums'] = 'Dodaj fora';
$lang['Add_selected'] = 'Dodaj wybrane';
$lang['Perm_all_forums'] = 'WSZYSTKIE FORA';

// Attachments -> Quota Limits
$lang['Manage_quotas'] = 'Zarz±dzanie limitami Quoty dyskowej';
$lang['Manage_quotas_explain'] = 'W tym miejscu mo¿esz dodaæ/usun±æ/zmieniæ limity quoty. Mo¿esz przypisaæ quotê do u¿ytkowników i grup. Aby przypisaæ limit quoty dla u¿ytkownika przejd¼ do edycji jego danych. Aby przypisaæ quotê dla grup, przejd¼ do edycji danych grupy.';
$lang['Assigned_users'] = 'Przypisani u¿ytkownicy';
$lang['Assigned_groups'] = 'Przypisane grupy';
$lang['Quota_limit_exist'] = 'Limit quoty %s istnieje.'; // Replace %s with the Quota Description

// Attachments -> Control Panel
$lang['Control_panel_title'] = 'Panel kontrolny za³±czników';
$lang['Control_panel_explain'] = 'Tutaj mo¿esz przegl±daæ i ustawiaæ wszystkie za³±czniki wys³ane przez u¿ytkowników';
$lang['File_comment_cp'] = 'Komentarz za³±cznika';

// Control Panel -> Search
$lang['Search_wildcard_explain'] = 'U¿yj * by zast±piæ jaki¶ ci±g znaków';
$lang['Size_smaller_than'] = 'Rozmiar (w bajtach) za³±cznika jest mniejsza ni¿';
$lang['Size_greater_than'] = 'Rozmiar (w bajtach) za³±cznika jest wiêksza ni¿';
$lang['Count_smaller_than'] = 'Liczba ¶ci±gniêæ jest mniejsza ni¿';
$lang['Count_greater_than'] = 'Liczba ¶ci±gniêæ jest wiêksza ni¿';
$lang['More_days_old'] = 'Za³±czone X dni wstecz.';
$lang['No_attach_search_match'] = 'Nie znaleziono za³±czników spe³niaj±ce te kryteria';

// Control Panel -> Statistics
$lang['Number_of_attachments'] = 'Ilo¶æ za³±czników';
$lang['Total_filesize'] = '£±czny rozmiar wszystkich za³±czników';
$lang['Number_posts_attach'] = 'Ilo¶æ postów z za³±cznikami';
$lang['Number_topics_attach'] = 'Ilo¶æ tematów z za³±cznikami';
$lang['Number_users_attach'] = 'Ilo¶æ u¿ytkowników którzy za³±czyli pliki';
$lang['Number_pms_attach'] = 'Ca³kowita ilo¶æ za³±czników w prywatnych wiadomo¶ciach';

// Control Panel -> Attachments
$lang['Statistics_for_user'] = 'Statystyki za³±czników dla u¿ytkownika %s'; // replace %s with username
$lang['Size_in_kb'] = 'Rozmiar (KB)';
$lang['Downloads'] = '¦ci±gniêto';
$lang['Post_time'] = 'Data postu';
$lang['Posted_in_topic'] = 'Post w temacie';
$lang['Submit_changes'] = 'Zachowaj zmiany';

// Sort Types
$lang['Sort_Attachments'] = 'Za³±czniki';
$lang['Sort_Size'] = 'Rozmiar';
$lang['Sort_Filename'] = 'Nazwa pliku';
$lang['Sort_Comment'] = 'Komentarz do za³±cznika';
$lang['Sort_Extension'] = 'Rozszerzenie';
$lang['Sort_Downloads'] = '¦ci±gniêto';
$lang['Sort_Posttime'] = 'Data postu';

// View Types
$lang['View_Statistic'] = 'Statystyki';
$lang['View_Search'] = 'Szukaj';
$lang['View_Username'] = 'U¿ytkownik';
$lang['View_Attachments'] = 'Za³±czniki';

// Successfully updated
$lang['Attach_config_updated'] = 'Konfiguracja za³±czników uaktualniona pomy¶lnie';
$lang['Click_return_attach_config'] = 'Kliknij %stutaj%s ¿eby powróciæ do konfiguracji za³±czników';
$lang['Test_settings_successful'] = 'Test konfiguracji zakoñczony, wszystko wygl±da dobrze.';

// Some basic definitions
$lang['Attachments'] = 'Za³±czniki';
$lang['Attachment'] = 'Za³±cznik';
$lang['Extension'] = 'Rozszerzenie';

// Auth pages
$lang['Auth_attach'] = 'Post za³±cznika';
$lang['Auth_download'] = '¦ci±gnij za³±czniki';

?>