<?php
/***************************************************************************
 *                      lang_main.php [Polish]
 *                      -------------------
 * begin                : Sat Dec 16 2000
 * copyright            : (C) 2001 The phpBB Group
 * email                : support@phpbb.com
 * modification         : (C) 2003 Przemo http://www.przemo.org
 * date modification    : ver. 1.12.5 2005/12/10 1:14
 *
 ****************************************************************************/

/***************************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 ***************************************************************************/

//
// Translation by Mike Paluchowski and Radek Kmiecicki
// http://www.phpbb.pl/
//


//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//



// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

setlocale(LC_ALL, 'pl');
// @setlocale (LC_ALL, 'pl_PL.iso-8859-2', 'pl_PL.latin2', 'pl_PL', 'pl', 'polish');
$lang['ENCODING'] = 'utf-8';
$lang['DIRECTION'] = 'ltr';
$lang['DATE_FORMAT'] = 'd M Y';

//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = 'Forum';
$lang['Category'] = 'Kategoria';
$lang['Topic'] = 'Temat';
$lang['Topics'] = 'Tematy';
$lang['Replies'] = 'Odpowiedzi';
$lang['Views'] = 'Wyświetleń';
$lang['Post'] = 'Post';
$lang['Posts'] = 'Posty';
$lang['Posted'] = 'Wysłany';
$lang['Email'] = 'E-mail';
$lang['Poster'] = 'Wysłał';
$lang['Author'] = 'Autor';
$lang['Time'] = 'Czas';
$lang['Hours'] = 'Godzin';
$lang['Message'] = 'Wiadomość';

$lang['1_Day'] = '1 Dzień';
$lang['7_Days'] = '7 Dni';
$lang['2_Weeks'] = '2 Tygodnie';
$lang['1_Month'] = '1 Miesiąc';
$lang['3_Months'] = '3 Miesiące';
$lang['6_Months'] = '6 Miesięcy';
$lang['1_Year'] = '1 Rok';

$lang['Jump_to'] = 'Skocz do';
$lang['Submit'] = 'Wyślij';
$lang['Reset'] = 'Wyczyść';
$lang['Cancel'] = 'Anuluj';
$lang['Preview'] = 'Podgląd';
$lang['Confirm'] = 'Zatwierdź';
$lang['Yes'] = 'Tak';
$lang['No'] = 'Nie';
$lang['Enabled'] = 'Włączony';
$lang['Disabled'] = 'Wyłączony';
$lang['Error'] = 'Błąd';

$lang['Next'] = 'Dalej';
$lang['Previous'] = 'Wstecz';
$lang['Goto_page'] = 'Idź do strony';
$lang['Joined'] = 'Dołączył';
$lang['IP_Address'] = 'Adres IP';

$lang['Select_forum'] = 'Wybierz forum';
$lang['View_newest_post'] = 'Zobacz najnowszy post';
$lang['Page_of'] = 'Strona <b>%d</b> z <b>%d</b>';

$lang['ICQ'] = 'Numer ICQ';
$lang['AIM'] = 'Numer Gadu-Gadu';
$lang['MSNM'] = 'MSN Messenger';
$lang['YIM'] = 'Yahoo Messenger';

$lang['Forum_Index'] = '%s Strona Główna';

$lang['Post_new_topic'] = 'Napisz nowy temat';
$lang['Reply_to_topic'] = 'Odpowiedz do tematu';
$lang['Reply_with_quote'] = 'Odpowiedz z cytatem';

$lang['Click_return_topic'] = 'Kliknij %sTutaj%s aby powrócić do tematu';
$lang['Click_return_forum'] = 'Kliknij %sTutaj%s aby powrócić na forum';
$lang['Click_view_message'] = 'Kliknij %sTutaj%s aby zobaczyć swoją wiadomość';
$lang['Click_return_group'] = 'Kliknij %sTutaj%s aby powrócić do informacji o grupach';

$lang['Admin_panel'] = 'Panel Administracyjny';

$lang['Board_disable'] = 'To forum jest teraz wyłączone.';

//
// Global Header strings
//
$lang['Registered_users'] = 'Zarejestrowani Użytkownicy:';
$lang['Browsing_forum'] = 'Użytkownicy przeglądający to forum:';
$lang['Online_users_zero_total'] = 'Na Forum jest <b>0</b> użytkowników :: ';
$lang['Online_users_total'] = 'Na Forum jest <b>%d</b> użytkowników :: ';
$lang['Online_user_total'] = 'Na Forum jest <b>%d</b> użytkownik :: ';
$lang['Reg_users_zero_total'] = '0 Zarejestrowanych, ';
$lang['Reg_users_total'] = '%d Zarejestrowanych, ';
$lang['Reg_user_total'] = '%d Zarejestrowany, ';
$lang['Hidden_users_zero_total'] = '0 Ukrytych i ';
$lang['Hidden_users_total'] = '%d Ukrytych i ';
$lang['Hidden_user_total'] = '%d Ukryty i ';
$lang['Guest_users_zero_total'] = '0 Gości';
$lang['Guest_users_total'] = '%d Gości';
$lang['Guest_user_total'] = '%d Gość';
$lang['Record_online_users'] = 'Najwięcej użytkowników <b>%s</b> było obecnych %s';

$lang['Admin_online_color'] = 'Administrator';
$lang['Mod_online_color'] = 'Moderator';

$lang['You_last_visit'] = 'Ostatnie twoje odwiedziny: %s';
$lang['Current_time'] = 'Obecny czas to %s';

$lang['Flood_Search'] = 'Nie możesz wyszukiwać tak szybko. Odczekaj kilka sekund i spróbuj ponownie lub odśwież stronę.';
$lang['Search_your_posts'] = 'Zobacz swoje posty';
$lang['Search_unanswered'] = 'Zobacz posty bez odpowiedzi';

$lang['Register'] = 'Rejestracja';
$lang['Profile'] = 'Profil';
$lang['Edit_profile'] = 'Zmień swój profil';
$lang['Search'] = 'Szukaj';
$lang['Memberlist'] = 'Użytkownicy';
$lang['FAQ'] = 'FAQ';
$lang['BBCode_guide'] = 'Przewodnik BBCode';
$lang['Usergroups'] = 'Grupy';
$lang['Last_Post'] = 'Ostatni post';
$lang['Moderator'] = 'Moderator';
$lang['Moderators'] = 'Moderatorzy';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'Nasi użytkownicy napisali <b>0</b> postów';
$lang['Posted_articles_total'] = 'Nasi użytkownicy napisali <b>%d</b> postów';
$lang['Posted_article_total'] = 'Nasi użytkownicy napisali <b>%d</b> wiadomość';
$lang['Registered_users_zero_total'] = 'Mamy <b>0</b> zarejestrowanych użytkowników';
$lang['Registered_users_total'] = 'Mamy <b>%d</b> zarejestrowanych użytkowników';
$lang['Registered_user_total'] = 'Mamy <b>%d</b> zarejestrowanego użytkownika';
$lang['Newest_user'] = 'Ostatnio zarejestrowana osoba: <b>%s%s%s</b>';

$lang['No_new_posts'] = 'Brak nowych postów';
$lang['New_posts'] = 'Nowe posty';
$lang['New_post'] = 'Nowy post';
$lang['No_new_posts_hot'] = 'Brak nowych postów [ Popularny ]';
$lang['New_posts_hot'] = 'Nowe posty [ Popularny ]';
$lang['No_new_posts_locked'] = 'Brak nowych postów [ Zablokowany ]';
$lang['New_posts_locked'] = 'Nowe posty [ Zablokowany ]';
$lang['Forum_is_locked'] = 'Forum Zablokowane';


//
// Login
//
$lang['Login'] = 'Zaloguj';
$lang['Logout'] = 'Wyloguj';
$lang['Forgotten_password'] = 'Zapomniałem hasła';
$lang['Log_me_in'] = 'Zaloguj mnie automatycznie przy każdej wizycie';


//
// Index page
//
$lang['No_Posts'] = 'Brak Postów';
$lang['No_forums'] = 'Brak Forów';

$lang['Private_Message'] = 'Prywatna Wiadomość';
$lang['Private_Messages'] = 'Prywatne Wiadomości';
$lang['Who_is_Online'] = 'Kto jest na Forum';

$lang['Mark_all_forums'] = 'Oznacz wszystkie fora jako przeczytane';
$lang['Forums_marked_read'] = 'Wszystkie fora oznaczono jako przeczytane';


//
// Viewforum
//
$lang['View_forum'] = 'Zobacz Forum';

$lang['Forum_not_exist'] = 'Wybrane przez Ciebie forum nie istnieje';

$lang['Display_topics'] = 'Wyświetl tematy z ostatnich';

$lang['Topic_Announcement'] = '<b>Ogłoszenie:</b>';
$lang['Topic_Sticky'] = '<b>Przyklejony:</b>';
$lang['Topic_Moved'] = '<b>Przesunięty:</b>';
$lang['Topic_Poll'] = '<b>[ Ankieta ]</b>';

$lang['Mark_all_topics'] = 'Oznacz wszystkie tematy jako przeczytane';
$lang['Topics_marked_read'] = 'Tematy na tym forum zostały oznaczone jako przeczytane';

$lang['Rules_post_can'] = '<b>Możesz</b> pisać nowe tematy';
$lang['Rules_post_cannot'] = '<b>Nie możesz</b> pisać nowych tematów';
$lang['Rules_reply_can'] = '<b>Możesz</b> odpowiadać w tematach';
$lang['Rules_reply_cannot'] = '<b>Nie możesz</b> odpowiadać w tematach';
$lang['Rules_edit_can'] = '<b>Możesz</b> zmieniać swoje posty';
$lang['Rules_edit_cannot'] = '<b>Nie możesz</b> zmieniać swoich postów';
$lang['Rules_delete_can'] = '<b>Możesz</b> usuwać swoje posty';
$lang['Rules_delete_cannot'] = '<b>Nie możesz</b> usuwać swoich postów';
$lang['Rules_vote_can'] = '<b>Możesz</b> głosować w ankietach';
$lang['Rules_vote_cannot'] = '<b>Nie możesz</b> głosować w ankietach';
$lang['Rules_moderate'] = '<b>Możesz</b> %smoderować to forum%s';

$lang['No_topics_post_one'] = 'Nie ma żadnych postów na tym forum<br />Kliknij na przycisk <b>Nowy Temat</b> aby coś napisać';
$lang['No_topics_post_one_ignore'] = 'Nie ma więcej tematów których nie ignorujesz na tym forum, kliknij link "Pokaż ignorowane tematy" aby zobaczyć wszystkie tematy';

//
// Viewtopic
//
$lang['View_topic'] = 'Zobacz temat';

$lang['Guest'] = 'Gość';
$lang['Post_subject'] = 'Temat postu';
$lang['View_next_topic'] = 'Następny temat';
$lang['View_previous_topic'] = 'Poprzedni temat';
$lang['Submit_vote'] = 'Wyślij Głos';
$lang['View_results'] = 'Zobacz Wyniki';

$lang['No_newer_topics'] = 'Nie ma nowszych tematów na tym forum';
$lang['No_older_topics'] = 'Nie ma starszych tematów na tym forum';
$lang['No_posts_topic'] = 'Nie istnieją żadne posty dla tego tematu';

$lang['Display_posts'] = 'Wyświetl posty z ostatnich';
$lang['All_Posts'] = 'Wszystkie Posty';
$lang['Newest_First'] = 'Najpierw Nowsze';
$lang['Oldest_First'] = 'Najpierw Starsze';

$lang['Back_to_top'] = 'Powrót do góry';

$lang['Read_profile'] = 'Zobacz profil autora';
$lang['Visit_website'] = 'Odwiedź stronę autora';
$lang['Edit_delete_post'] = 'Zmień/Usuń ten post';
$lang['View_IP'] = 'Zobacz IP autora';
$lang['Delete_post'] = 'Usuń ten post';

$lang['wrote'] = 'napisał/a';
$lang['Quote'] = 'Cytat';
$lang['Code'] = 'Kod';

$lang['Edited_time_total'] = 'Ostatnio zmieniony przez %s %s, w całości zmieniany %d raz';
$lang['Edited_times_total'] = 'Ostatnio zmieniony przez %s %s, w całości zmieniany %d razy';

$lang['Lock_topic'] = 'Zablokuj ten temat';
$lang['Unlock_topic'] = 'Odblokuj ten temat';
$lang['Move_topic'] = 'Przesuń ten temat';
$lang['Delete_topic'] = 'Usuń ten temat';
$lang['Split_topic'] = 'Podziel ten temat';

$lang['Stop_watching_topic'] = 'Przestań śledzić ten temat';
$lang['Start_watching_topic'] = 'Śledź odpowiedzi w tym temacie';
$lang['No_longer_watching'] = 'Nie śledzisz tego tematu';
$lang['You_are_watching'] = 'Śledzisz ten temat';

$lang['Total_votes'] = 'Wszystkich Głosów';

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Treść wiadomości';
$lang['Topic_review'] = 'Przegląd tematu';

$lang['No_post_mode'] = 'Nie określono typu postu';

$lang['Post_a_new_topic'] = 'Napisz nowy temat';
$lang['Post_a_reply'] = 'Napisz odpowiedź';
$lang['Post_topic_as'] = 'Napisz temat jako';
$lang['Edit_Post'] = 'Zmień post';
$lang['Options'] = 'Opcje';

$lang['Post_Announcement'] = 'Ogłoszenie';
$lang['Post_Sticky'] = 'Przyklejony';
$lang['Post_Normal'] = 'Normalny';

$lang['Confirm_delete'] = 'Czy na pewno chcesz usunąć ten post?';
$lang['Confirm_delete_poll'] = 'Czy na pewno chcesz usunąć tę ankietę?';

$lang['Flood_Error'] = 'Nie możesz wysłać nowego postu tak szybko po poprzednim, zaczekaj chwilę i spróbuj ponownie';
$lang['Empty_subject'] = 'Musisz wpisać temat jeśli wysyłasz nowy wątek';
$lang['Empty_message'] = 'Musisz wpisać wiadomość przed wysłaniem';
$lang['Forum_locked'] = 'To forum jest zablokowane, nie możesz pisać dodawać ani zmieniać na nim czegokolwiek';
$lang['Topic_locked'] = 'Ten temat jest zablokowany bez możliwości zmiany postów lub pisania odpowiedzi';
$lang['No_topic_id'] = 'Musisz wybrać temat do wysłania odpowiedzi';
$lang['No_valid_mode'] = 'Możesz jedynie pisać nowe, odpowiadać, zmieniać lub cytować wiadomości, wróć i spróbuj ponownie';
$lang['No_such_post'] = 'Taki post lub temat nie istnieje, być może został przed chwilą usunięty, wróć i spróbuj ponownie';
$lang['Edit_own_posts'] = 'Możesz zmieniać jedynie swoje posty';
$lang['Delete_own_posts'] = 'Możesz usuwać jedynie swoje posty';
$lang['Cannot_delete_replied'] = 'Nie możesz usuwać postów, na które jest odpowiedź';
$lang['Cannot_delete_poll'] = 'Nie możesz usunąć aktywnej ankiety';
$lang['Empty_poll_title'] = 'Musisz wpisać tytuł dla ankiety';
$lang['To_few_poll_options'] = 'Musisz wpisać przynajmniej dwie opcje ankiety';
$lang['To_many_poll_options'] = 'Podano zbyt wiele opcji dla ankiety';
$lang['Already_voted'] = 'Zapisano już twój głos w tej ankiecie';
$lang['No_vote_option'] = 'Musisz wybrać opcję podczas głosowania';

$lang['Add_poll'] = 'Dodaj Ankietę';
$lang['Add_poll_explain'] = 'Jeżeli nie chcesz dodawać ankiety do tego tematu, pozostaw pola puste';
$lang['Poll_question'] = 'Pytanie do ankiety';
$lang['Poll_option'] = 'Opcja ankiety';
$lang['Add_option'] = 'Dodaj opcję';
$lang['Update'] = 'Aktualizuj';
$lang['Delete'] = 'Usuń';
$lang['Poll_for'] = 'Czas trwania';
$lang['Days'] = 'Dni';
$lang['Poll_for_explain'] = '[ Wpisz 0 lub pozostaw puste dla niekończącej się ankiety ]';
$lang['Delete_poll'] = 'Usuń Ankietę';

$lang['Disable_HTML_post'] = 'Wyłącz HTML w tym poście';
$lang['Disable_BBCode_post'] = 'Wyłącz BBCode w tym poście';
$lang['Disable_Smilies_post'] = 'Wyłącz Uśmieszki w tym poście';

$lang['HTML_is_ON'] = 'HTML: <u>TAK</u>';
$lang['HTML_is_OFF'] = 'HTML: <u>NIE</u>';
$lang['BBCode_is_ON'] = '%sBBCode%s: <u>TAK</u>';
$lang['BBCode_is_OFF'] = '%sBBCode%s: <u>NIE</u>';
$lang['Smilies_are_ON'] = 'Uśmieszki: <u>TAK</u>';
$lang['Smilies_are_OFF'] = 'Uśmieszki: <u>NIE</u>';

$lang['Attach_signature'] = 'Dodaj podpis (może być zmieniony w profilu)';
$lang['Notify'] = 'Powiadom mnie gdy ktoś odpowie';

$lang['Stored'] = 'Wiadomość została zapisana';
$lang['Deleted'] = 'Wiadomość została usunięta';
$lang['Poll_delete'] = 'Ankieta została usunięta';
$lang['Vote_cast'] = 'Twój głos został zapisany';

$lang['Topic_reply_notification'] = 'Powiadomienie o Odpowiedzi';

$lang['bbcode_b_help'] = 'Tekst pogrubiony: [b]tekst[/b] Rada: zaznacz tekst i kliknij';
$lang['bbcode_i_help'] = 'Tekst kursywą: [i]tekst[/i] Rada: zaznacz tekst i kliknij';
$lang['bbcode_u_help'] = 'Tekst podkreślony: [u]tekst[/u] Rada: zaznacz tekst i kliknij';
$lang['bbcode_q_help'] = 'Cytat: [quote]tekst[/quote] Rada: zaznacz tekst i kliknij';
$lang['bbcode_c_help'] = 'Pokaż kod: [code]kod[/code] Rada: zaznacz tekst i kliknij';
$lang['bbcode_l_help'] = 'Lista: [list]tekst[/list] Rada: zaznacz tekst i kliknij';
$lang['bbcode_o_help'] = 'Lista uporządkowana: [list=]tekst[/list] Rada: zaznacz tekst i kliknij';
$lang['bbcode_p_help'] = 'Wstaw obrazek: [img]http://adres_obrazka[/img] Rada: Kliknij i wpisz adres';
$lang['bbcode_w_help'] = '[url]http://adres[/url] Rada: Kliknij wpisz nazwę i adres';
$lang['bbcode_a_help'] = 'Zamknij wszystkie otwarte tagi bbCode';
$lang['bbcode_s_help'] = 'Kolor czcionki: [color=red]tekst[/color] Rada: zaznacz tekst i wybierz kolor';
$lang['bbcode_f_help'] = 'Rozmiar czcionki: [size=x-small]mały tekst[/size] Rada: zaznacz tekst i wybierz rozmiar';

$lang['Emoticons'] = 'Ikony Emocji';
$lang['More_emoticons'] = 'Więcej Ikon';

$lang['Font_color'] = 'Kolor';
$lang['color_default'] = 'Domyślny';
$lang['color_dark_red'] = 'Ciemnoczerwony';
$lang['color_red'] = 'Czerwony';
$lang['color_orange'] = 'Pomarańczowy';
$lang['color_brown'] = 'Brązowy';
$lang['color_yellow'] = 'Żółty';
$lang['color_green'] = 'Zielony';
$lang['color_olive'] = 'Oliwkowy';
$lang['color_cyan'] = 'Błękitny';
$lang['color_blue'] = 'Niebieski';
$lang['color_dark_blue'] = 'Ciemnoniebieski';
$lang['color_indigo'] = 'Purpurowy';
$lang['color_violet'] = 'Fioletowy';
$lang['color_white'] = 'Biały';
$lang['color_black'] = 'Czarny';

$lang['Font_size'] = 'Rozmiar';
$lang['font_tiny'] = 'Minimalny';
$lang['font_small'] = 'Mały';
$lang['font_normal'] = 'Normalny';
$lang['font_large'] = 'Duży';
$lang['font_huge'] = 'Ogromny';

$lang['Close_Tags'] = 'Zamknij Tagi';
$lang['Styles_tip'] = 'Rada: Style mogą być stosowane szybko do zaznaczonego tekstu';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'Prywatne Wiadomości';

$lang['Login_check_pm'] = 'Zaloguj&nbsp;się,&nbsp;by&nbsp;sprawdzić&nbsp;wiadomości';
$lang['New_pms'] = 'Masz %d <span class=\'pm\'>*<b>nowe</b>*</span> wiadomości';
$lang['New_pm'] = 'Masz %d <span class=\'pm\'>*<b>nową</b>*</span> wiadomość';
$lang['No_new_pm'] = 'Nie&nbsp;masz&nbsp;wiadomości';
$lang['Unread_pms'] = 'Masz %d nieprzeczytanych wiadomości';
$lang['Unread_pm'] = 'Masz %d nieprzeczytaną wiadomość';
$lang['No_unread_pm'] = 'Nie masz nieprzeczytanych wiadomości';
$lang['You_new_pm'] = 'Nowa prywatna wiadomość czeka na Ciebie w Skrzynce';
$lang['You_new_pms'] = 'Nowe prywatne wiadomości czekają na Ciebie w Skrzynce';
$lang['You_no_new_pm'] = 'Nie ma dla Ciebie żadnych nowych prywatnych wiadomości';
$lang['Unread_message'] = 'Nowa wiadomość';
$lang['Read_message'] = 'Przeczytana wiadomość';

$lang['Read_pm'] = 'Odczytaj wiadomość';
$lang['Post_new_pm'] = 'Napisz wiadomość';
$lang['Post_reply_pm'] = 'Odpowiedz na post';
$lang['Post_quote_pm'] = 'Cytuj wiadomość';
$lang['Edit_pm'] = 'Zmień wiadomość';

$lang['Inbox'] = 'Skrzynka';
$lang['Outbox'] = 'Do Wysłania';
$lang['Savebox'] = 'Zapisane';
$lang['Sentbox'] = 'Wysłane';
$lang['Flag'] = 'Flaga';
$lang['Subject'] = 'Temat';
$lang['From'] = 'Od';
$lang['To'] = 'Do';
$lang['Date'] = 'Data';
$lang['Mark'] = 'Zaznacz';
$lang['Sent'] = 'Wysłana';
$lang['Saved'] = 'Zapisana';
$lang['Delete_marked'] = 'Usuń Zaznaczone';
$lang['Delete_all'] = 'Usuń Wszystkie';
$lang['Save_marked'] = 'Zapisz Zaznaczone';
$lang['Save_message'] = 'Zapisz Wiadomość';
$lang['Delete_message'] = 'Usuń Wiadomość';

$lang['Display_messages'] = 'Wyświetl wiadomości z ostatnich';
$lang['All_Messages'] = 'Wszystkie Wiadomości';

$lang['No_messages_folder'] = 'Nie masz wiadomości w tym folderze';

$lang['PM_disabled'] = 'Prywatne Wiadomości zostały wyłączone na tym forum';
$lang['Cannot_send_privmsg'] = 'Administrator zabronił Ci wysyłać prywatnych wiadomości';
$lang['No_to_user'] = 'Musisz wpisać nazwę użytkownika aby wysłać tę wiadomość';

$lang['Disable_HTML_pm'] = 'Wyłącz HTML w tej wiadomości';
$lang['Disable_BBCode_pm'] = 'Wyłącz BBCode w tej wiadomości';
$lang['Disable_Smilies_pm'] = 'Wyłącz Uśmieszki w tej wiadomości';

$lang['Message_sent'] = 'Wiadomość została wysłana';

$lang['Click_return_inbox'] = 'Kliknij %sTutaj%s aby powrócić do Skrzynki';
$lang['Click_return_index'] = 'Kliknij %sTutaj%s aby powrócić do Strony Głównej';

$lang['Send_a_new_message'] = 'Wyślij nową prywatną wiadomość';
$lang['Send_a_reply'] = 'Odpowiedz na prywatną wiadomość';
$lang['Edit_message'] = 'Zmień prywatną wiadomość';

$lang['Notification_subject'] = 'Nadeszła nowa Prywatna Wiadomość';

$lang['Find_username'] = 'Znajdź użytkownika';
$lang['Find'] = 'Znajdź';
$lang['No_match'] = 'Nie znaleziono pasujących';

$lang['No_post_id'] = 'Nie wybrano postów';
$lang['No_such_folder'] = 'Nie istnieje taki folder';

$lang['Mark_all'] = 'Zaznacz wszystkie';
$lang['Unmark_all'] = 'Odznacz wszystkie';

$lang['Confirm_delete_pm'] = 'Czy na pewno chcesz usunąć tę wiadomość?';
$lang['Confirm_delete_pms'] = 'Czy na pewno chcesz usunąć te wiadomości?';

$lang['Inbox_size'] = 'Wiadomości w Skrzynce zajmują %d%%';
$lang['Sentbox_size'] = 'Wysłane wiadomości zajmują %d%%';
$lang['Savebox_size'] = 'Zapisane wiadomości zajmują %d%%';

$lang['Click_view_privmsg'] = 'Kliknij %sTutaj%s aby odwiedzić twoją Skrzynkę';


//
// Profiles/Registration
//

$lang['Preferences'] = 'Preferencje';

$lang['Website'] = 'Strona WWW';
$lang['Location'] = 'Skąd';
$lang['Email_address'] = 'Adres email';
$lang['Send_private_message'] = 'Wyślij prywatną wiadomość';
$lang['Interests'] = 'Zainteresowania';
$lang['Poster_rank'] = 'Ranga';

$lang['Total_posts'] = 'Postów';
$lang['User_post_pct_stats'] = '%d%% z całości';
$lang['User_post_day_stats'] = '%.2f postów dziennie';
$lang['Search_user_posts'] = 'Znajdź wszystkie posty %s';

$lang['No_user_id_specified'] = 'Wybrany użytkownik nie istnieje';

$lang['Date_format'] = 'Format Daty';

$lang['Avatar'] = 'Avatar';

$lang['No_user_specified'] = 'Nie określono żadnego użytkownika';
$lang['Flood_email_limit'] = 'Nie możesz teraz wysłać kolejnego email\'a. Spróbuj ponownie za jakiś czas.';
$lang['Email_sent'] = 'Email został wysłany';
$lang['Send_email'] = 'Wyślij email';
$lang['Empty_subject_email'] = 'Musisz określić temat dla email\'a';
$lang['Empty_message_email'] = 'Musisz wpisać wiadomość do wysłania';

//
// Memberslist
//
$lang['Select_sort_method'] = 'Metoda sortowania';
$lang['Sort'] = 'Sortuj';
$lang['Sort_Top_Ten'] = '10 najaktywniejszych';
$lang['Sort_Joined'] = 'Data przyłączenia';
$lang['Sort_Username'] = 'Nazwa użytkownika';
$lang['Sort_Ascending'] = 'Rosnąco';
$lang['Sort_Descending'] = 'Malejąco';

//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Panel Kontrolny Grupy';
$lang['Group_member_details'] = 'Członkostwo w Grupach';

$lang['Group_Information'] = 'Informacje o Grupie';
$lang['Group_name'] = 'Nazwa Grupy';
$lang['Group_description'] = 'Opis Grupy';
$lang['Group_membership'] = 'Twoje członkostwo';
$lang['Group_Members'] = 'Członkowie Grupy';
$lang['Group_Moderator'] = 'Moderator Grupy';
$lang['Pending_members'] = 'Członkowie Oczekujący';

$lang['Group_type'] = 'Typ grupy';
$lang['Group_open'] = 'Grupa otwarta';
$lang['Group_closed'] = 'Grupa zamknięta';
$lang['Group_hidden'] = 'Grupa ukryta';

$lang['Memberships_pending'] = 'Oczekujesz na przyjęcie';

$lang['No_groups_exist'] = 'Żadna grupa nie istnieje';
$lang['Group_not_exist'] = 'Taka grupa nie istnieje';

$lang['Join_group'] = 'Dołącz';
$lang['No_group_members'] = 'Ta grupa nie ma członków';
$lang['Group_hidden_members'] = 'Ta grupa jest ukryta, nie możesz zobaczyć listy jej członków';
$lang['Group_joined'] = 'Dołączono Cię do tej grupy<br />Zostaniesz powiadomionu kiedy Twoje członkostwo zostanie zaakceptowane przez moderatora';
$lang['Group_request'] = 'Prośba o przyłączenie do grupy %s';
$lang['Group_added'] = 'Dodano Cię do grupy %s';
$lang['Already_member_group'] = 'Jesteś już członkiem tej grupy';
$lang['User_is_member_group'] = 'Użytkownik jest już członkiem tej grupy';
$lang['Group_type_updated'] = 'Zaktualizowano typ grupy';

$lang['Could_not_anon_user'] = 'Anonimowy nie może być członkiem grupy';

$lang['Confirm_unsub'] = 'Czy na pewno chcesz opuścić tą grupę?';
$lang['Confirm_unsub_pending'] = 'Twoje członkostwo w tej grupie nie zostało jeszcze zaakceptowane, czy na pewno chcesz je zakończyć?';

$lang['Unsub_success'] = 'Nie jesteś już być członkiem tej grupy.';

$lang['Approve_selected'] = 'Zaakceptuj Wybrane';
$lang['Deny_selected'] = 'Odrzuć Wybrane';
$lang['Remove_selected'] = 'Usuń Wybrane';
$lang['Add_member'] = 'Dodaj Członka';
$lang['Not_group_moderator'] = 'Nie jesteś moderatorem tej grupy i nie możesz wykonać tego działania.';

$lang['Login_to_join'] = 'Zaloguj się aby dołączyć do grupy lub zarządzać jej członkostwem';
$lang['This_open_group'] = 'To jest grupa otwarta, kliknij aby poprosić o członkostwo';
$lang['Member_this_group'] = 'Jesteś członkiem tej grupy';
$lang['Pending_this_group'] = 'Twoje członkowstwo w tej grupie czeka na akceptację';
$lang['Are_group_moderator'] = 'Jesteś moderatorem tej grupy';
$lang['None'] = 'Brak';
$lang['Unsubscribe'] = 'Opuść';
$lang['View_Information'] = 'Zobacz Informacje';


//
// Search
//
$lang['Search_query'] = 'Poszukiwane Zapytanie';
$lang['Search_options'] = 'Opcje Wyszukiwania';

$lang['Search_keywords'] = 'Szukaj Słów Kluczowych';
$lang['Search_keywords_explain'] = 'Możesz używać <u>AND</u> aby określać, które słowa muszą znaleźć się w wynikach, <u>OR</u> dla tych, które mogą się tam znaleźć i <u>NOT</u> dla tych, które nie mogą wystąpić. Znak * zastępuje dowolny ciąg znaków.<br />Żeby wyszukać wyrażenie, wpisz je pomiędzy <b>"</b>cudzysłowami<b>"</b><br />Nie będą znalezione znaki specjalne, za wyjątkiem: <b>@ . - _</b>';
$lang['Search_author'] = 'Szukaj Autora';
$lang['Search_author_explain'] = 'Użyj * jako zamiennika dowolnego ciągu znaków';

$lang['Search_for_any'] = 'Szukaj któregokolwiek słowa lub wyrażenia';
$lang['Search_for_all'] = 'Szukaj wszystkich słów';
$lang['Search_title_msg'] = 'Przeszukaj tytuł, opis i tekst wiadomości';
$lang['Search_msg_only'] = 'Przeszukaj tylko tekst wiadomości';
$lang['Search_title_only'] = 'Przeszukaj tylko tytuł wiadomości';
$lang['Search_title_e_only'] = 'Przeszukaj tylko opis tematu';

$lang['Return_first'] = 'Pokaż pierwsze';
$lang['characters_posts'] = 'znaków z postu';

$lang['Search_previous'] = 'Przeszukaj ostanie';

$lang['Sort_by'] = 'Sortuj według';
$lang['Sort_Time'] = 'Czas wysłania';
$lang['Sort_Topic_Title'] = 'Tytuł tematu';

$lang['Display_results'] = 'Pokaż wyniki jako';
$lang['All_available'] = 'Wszystkie dostępne';
$lang['No_searchable_forums'] = 'Nie masz uprawnień do przeszukiwania któregokolwiek forum na tej stronie';

$lang['No_search_match'] = 'Nie znaleziono tematów ani postów pasujących do Twoich kryteriów';
$lang['Found_search_match'] = 'Znaleziono %d wynik';
$lang['Found_search_matches'] = 'Znalezionych wyników: %d';

$lang['Close_window'] = 'Zamknij Okno';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following \'user\' arrays
$lang['Sorry_auth_announce'] = 'Tylko %s mogą pisać ogłoszenia na tym forum.';
$lang['Sorry_auth_sticky'] = 'Tylko %s mogą pisać tematy przyklejone na tym forum.';
$lang['Sorry_auth_read'] = 'Tylko %s mogą czytać tematy na tym forum.';
$lang['Sorry_auth_delete'] = 'Tylko %s mogą usuwać posty na tym forum.';
$lang['Sorry_auth_post'] = 'Tylko %s mogą pisać nowe tematy na tym forum.'; 
$lang['Sorry_auth_reply'] = 'Tylko %s mogą odpowiadać w tematach na tym forum.';
$lang['Sorry_auth_edit'] = 'Tylko %s mogą edytować posty na tym forum.'; 
$lang['Sorry_auth_vote'] = 'Tylko %s mogą głosować w ankietach na tym forum.';

// These replace the %s in the above strings
$lang['Auth_Anonymous_users']  = '<b>niezalogowani użytkownicy</b>';
$lang['Auth_Registered_Users'] = '<b>zarejestrowani użytkownicy</b>';
$lang['Auth_Users_granted_access'] = '<b>użytkownicy z uprawnieniami dostępu</b>';
$lang['Auth_Moderators'] = '<b>moderatorzy</b>';
$lang['Auth_Administrators'] = '<b>administratorzy</b>';

$lang['Not_Authorised'] = 'Nie posiadasz uprawnień';

$lang['You_been_banned'] = 'Wyrzucono Cię z tego forum!<br />Skontaktuj się z webmasterem lub administratorem forum jeżeli chcesz wyjaśnić tą sytuację.';


//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'Na Forum jest 0 Zarejestrowanych i ';
$lang['Reg_users_online'] = 'Na forum jest %d Zarejestrowanych i ';
$lang['Reg_user_online'] = 'Na forum jest %d Zarejestrowany użytkownik i ';
$lang['Hidden_users_zero_online'] = '0 Ukrytych użytkowników';
$lang['Hidden_users_online'] = '%d Ukrytych użytkowników';
$lang['Hidden_user_online'] = '%d Ukryty użytkownik';
$lang['Guest_users_zero_online'] = 'Na Forum jest 0 Gości';
$lang['Guest_users_online'] = 'Na Forum jest %d Gości';
$lang['Guest_user_online'] = 'Na Forum jest %d Gość';
$lang['No_users_browsing'] = 'Obecnie nie ma żadnych użytkowników na tym forum';

$lang['Online_explain'] = '';

$lang['Forum_Location'] = 'Lokalizacja';
$lang['Last_updated'] = 'Na forum';

$lang['Forum_index'] = 'Strona Główna';
$lang['Logging_on'] = 'Loguje się';
$lang['Posting_message'] = 'Pisze wiadomość';
$lang['Searching_forums'] = 'Przeszukuje fora';
$lang['Viewing_profile'] = 'Ogląda profil';
$lang['Viewing_online'] = 'Przegląda listę obecnych na forum';
$lang['Viewing_member_list'] = 'Ogląda listę użytkowników';
$lang['Viewing_priv_msgs'] = 'Ogląda Prywatne Wiadomości';
$lang['Viewing_FAQ'] = 'Ogląda FAQ';


//
// Moderator Control Panel
//

$lang['Select'] = 'Wybierz';
$lang['Move'] = 'Przenieś';
$lang['Lock'] = 'Zablokuj';
$lang['Unlock'] = 'Odblokuj';
$lang['Topics_Moved'] = 'Wybrane tematy zostały przeniesione';

//
// Timezones ... for display on each page
//

$lang['datetime']['Sunday'] = 'Niedziela';
$lang['datetime']['Monday'] = 'Poniedziałek';
$lang['datetime']['Tuesday'] = 'Wtorek';
$lang['datetime']['Wednesday'] = 'Środa';
$lang['datetime']['Thursday'] = 'Czwartek';
$lang['datetime']['Friday'] = 'Piątek';
$lang['datetime']['Saturday'] = 'Sobota';
$lang['datetime']['Sun'] = 'Nie';
$lang['datetime']['Mon'] = 'Pon';
$lang['datetime']['Tue'] = 'Wto';
$lang['datetime']['Wed'] = 'Śro';
$lang['datetime']['Thu'] = 'Czw';
$lang['datetime']['Fri'] = 'Pią';
$lang['datetime']['Sat'] = 'Sob';
$lang['datetime']['January'] = 'Styczeń';
$lang['datetime']['February'] = 'Luty';
$lang['datetime']['March'] = 'Marzec';
$lang['datetime']['April'] = 'Kwiecień';
$lang['datetime']['May'] = 'Maj';
$lang['datetime']['June'] = 'Czerwiec';
$lang['datetime']['July'] = 'Lipiec';
$lang['datetime']['August'] = 'Sierpień';
$lang['datetime']['September'] = 'Wrzesień';
$lang['datetime']['October'] = 'Październik';
$lang['datetime']['November'] = 'Listopad';
$lang['datetime']['December'] = 'Grudzień';
$lang['datetime']['Jan'] = 'Sty';
$lang['datetime']['Feb'] = 'Lut';
$lang['datetime']['Mar'] = 'Mar';
$lang['datetime']['Apr'] = 'Kwi';
$lang['datetime']['May'] = 'Maj';
$lang['datetime']['Jun'] = 'Cze';
$lang['datetime']['Jul'] = 'Lip';
$lang['datetime']['Aug'] = 'Sie';
$lang['datetime']['Sep'] = 'Wrz';
$lang['datetime']['Oct'] = 'Paź';
$lang['datetime']['Nov'] = 'Lis';
$lang['datetime']['Dec'] = 'Gru';

//
// Errors (not related to a
// specific failure on a page)
//
$lang['Information'] = 'Informacja';
$lang['Critical_Information'] = 'Istotna Informacja';

$lang['General_Error'] = 'Błąd Ogólny';
$lang['Critical_Error'] = 'Błąd Krytyczny';
$lang['An_error_occured'] = 'Wystąpił Błąd';
$lang['A_critical_error'] = 'Wystąpił Krytyczny Błąd';

//
// Modified addons
//

$lang['2_Days'] = '2 Dni';
$lang['3_Days'] = '3 Dni';
$lang['4_Days'] = '4 Dni';
$lang['5_Days'] = '5 Dni';
$lang['6_Days'] = '6 Dni';
$lang['left'] = 'z lewej';
$lang['center'] = 'na środku';
$lang['right'] = 'z prawej';
$lang['registered_users'] = 'zarejestrowanych użytkowników';
$lang['posts'] = 'postów';
$lang['topics'] = 'tematów';
$lang['Search_new_unread'] = 'Zobacz posty nieprzeczytane';
$lang['Search_new'] = 'Zobacz posty od ostatniej wizyty';
$lang['visitors_txt'] = 'To forum odwiedzono już';
$lang['visitors_txt2'] = 'razy';
$lang['Sticky_topic'] = 'Przyklej ten temat';
$lang['Announce_topic'] = 'Oznacz jako ogłoszenie';
$lang['Normal_topic'] = 'Oznacz jako normalny';
$lang['Sticky'] = 'Przyklejony';
$lang['Announce'] = 'Ogłoszenie';
$lang['Normalise'] = 'Normalny';
$lang['Mark_topic_unread'] = 'Oznacz temat jako nieczytany';
$lang['Mark_topic_read'] = 'Oznacz temat jako przeczytany';
$lang['Statistics'] = 'Statystyki';
$lang['Comments'] = 'Komentarze';
$lang['Welcome'] = 'Witamy';
$lang['Poll'] = 'Ankieta';
$lang['Vote'] = 'Głosuj';
$lang['bbcode_y_help'] = 'Wyśrodkowanie: [center]tekst[/center] Rada: zaznacz tekst i kliknij';
$lang['bbcode_e_help'] = 'Zanikający tekst: [fade]text[/fade] Rada: zaznacz tekst i kliknij';
$lang['bbcode_k_help'] = 'Przewijany tekst: [scroll]tekst[/scroll] Rada: zaznacz tekst i kliknij';
$lang['bbcode_s2_help'] = 'Cień: [shadow=red]text[/shadow] Rada: zaznacz tekst i wybierz kolor';
$lang['bbcode_g_help'] = 'Ogień: [glow=red]text[/glow] Rada: zaznacz tekst i wybierz kolor';
$lang['bbcode_h_help'] = 'Ukryj: [hide]tekst[/hide] Rada: zaznacz tekst i kliknij';
$lang['Shadow_color'] = 'Cień';
$lang['Glow_color'] = 'Ogień';
$lang['write_link_text'] = 'Wpisz tekst który będzie pokazywany jako nazwa linku';
$lang['write_address'] = 'Podaj adres';
$lang['img_address'] = 'Podaj adres do obrazka';
$lang['stream_address'] = 'Podaj adres pliku';
$lang['GG'] = 'Gadu-Gadu użytkownika :: %s';
$lang['STAT_GG'] = 'Status Gadu-Gadu użytkownika';
$lang['GG_wait'] = 'Wiadomość oczekuje w kolejce na odebranie.<br />Zostanie dostarczona gdy adresat włączy gadu-gadu<br /> lub adresat ma w tej chwili status <b>"niewidoczny"</b> bądź "tylko dla znajomych".';
$lang['GG_full'] = 'Skrzynka odbiorcza adresata jest pełna, wiadomość nie została dostarczona.';
$lang['GG_send'] = 'Wiadomość została dostarczona do adresata';
$lang['GG_not_send'] = 'Wiadomość nie została dostarczona, spróbuj jeszcze raz (odśwież strone).';
$lang['Last_visit'] = 'Ostatnia wizyta';
$lang['Never'] = 'Nigdy';
$lang['Sort_Last_visit'] = 'Data ostatniej aktywności';
$lang['Page_loading_wait'] = 'Ładowanie strony... proszę czekać!';
$lang['Page_loading_stop'] = 'Jeśli strona nie chce się załadować kliknij <span onclick="hideLoadingPage()" style="cursor: pointer">Tutaj<\/span>';
$lang['Quick_Reply'] = 'Szybka odpowiedź';
$lang['QuoteSelelected'] = 'Cytowanie selektywne';
$lang['QuoteSelelectedEmpty'] = 'Zaznacz najpierw tekst';
$lang['Quick_Reply_smilies'] = 'Wszystkie emotikony';
$lang['Age'] = 'Wiek';
$lang['Year'] = 'Rok';
$lang['Month'] = 'Miesiąc';
$lang['Day'] = 'Dzień';
$lang['l_whoisonline'] = 'zobacz szczegółowo';
$lang['new_topicsss'] = 'Nowych tematów:';
$lang['new_postsss'] = 'Nowych postów:';
$lang['unread_topicsss'] = 'Nieczytanych tematów';
$lang['unread_postsss'] = 'Nieczytanych postów';
$lang['Board_style'] = 'Styl forum';
$lang['l_level'] = 'Poziom';
$lang['Ignore_list'] = 'Lista ignorowanych';
$lang['Ignore_users'] = 'Ten użytkownik jest na twojej liście ignorowanych';
$lang['Ignore_add'] = 'Dodaj użytkownika do listy ignorowanych';
$lang['Ignore_delete'] = 'Usuń użytkownika z listy ignorowanych';
$lang['Ignore_added'] = 'Użytkownik dodany do listy ignorowanych';
$lang['Ignore_deleted'] = 'Użytkownik usunięty z listy ignorowanych';
$lang['Ignore_submit'] = 'Dodaj do listy ignorowanych';
$lang['Ignore_exists'] = 'Użytkownik jest już na twojej liście ignorowanych';
$lang['Click_return_ignore'] = 'Kliknij %sTutaj%s żeby przejść do swojej listy ignorowanych';
$lang['Ignore_user_warn'] = 'Nie możesz się samemu ignorować!';
$lang['Post_user_ignored'] = 'Użytkownik został dodany do twojej listy <b>ignorowanych</b>.';
$lang['Click_view_ignore'] = 'Kliknij %sTutaj%s żeby zobaczyć jego post.<br />';
$lang['Search_for'] = 'Szukaj w tym dziale';
$lang['cicq'] = 'ICQ';

$lang['Print_View'] = 'Wersja do druku';
$lang['Wrong_reg_key'] = 'Nieprawidłowy kod!';
$lang['Validation'] = 'Uwierzytelnianie';
$lang['Msg_Icon_No_Icon'] = 'Bez';
$lang['messageicon'] = 'Ikona tematu';
$lang['postmsgicon'] = 'Ikona Tematu/Postu';
$lang['Topic_view_users'] = 'Kto przeglądał temat';
$lang['Topic_time'] = 'Ostatnio oglądany';
$lang['Topic_count'] = 'Oglądany';
$lang['Topic_global_announcement'] = '<b>Ważne ogłoszenie:</b>';
$lang['Post_global_announcement'] = 'Ważne ogłoszenie';
$lang['Forum_not_exist'] = 'Nie znaleziono forum';
$lang['Enter_forum_password'] = 'Podaj hasło działu';
$lang['Incorrect_forum_password'] = 'Błędne hasło';
$lang['Only_alpha_num_chars'] = 'Hasło może zawierać od 3 do 20 znaków z zakresu: (A-Z, a-z, 0-9)';
$lang['l_whois'] = 'Whois';
$lang['Staff'] = 'Obsługa';
$lang['Admin'] = 'Administrator';
$lang['Junior'] = 'Junior Admin';
$lang['Period'] = 'Na forum od <b>%d</b> dni';
$lang['Topic_bookmark'] = 'Dodaj temat do Ulubionych';
$lang['Day_users'] = 'Przez ostatnie %s godziny byli na forum:';
$lang['last_visitors_more'] = 'Pełna lista';
$lang['search_keywords_error'] = 'Użyłeś za dużo słów przy próbie szukania. <br>Możesz ich wykorzystać (maksymalnie): <b>%s</b>.';
$lang['hidden_user'] = 'Ukryte';
$lang['post_expire'] = 'Post wygaśnie:';
$lang['topic_expire'] = 'Wygaśnie';
$lang['expire_unlimit'] = 'Bez limitu';
$lang['l_expire_p'] = 'Czas ważności postu/tematu';
$lang['Tree_width_topic'] = 'Skok drzewa tematu w pixelach';
$lang['l_expire_p_e'] = 'Wybierz, po ilu dniach post ma być automatycznie usunięty. Jeśli jest to nowy temat, zostanie usunięty w całości.';
$lang['expire_e'] = 'Ustaw, po ilu dniach temat ma być skasowany';
$lang['announce-stick'] = 'Przyklejanie tematów, oznaczanie jako ogłoszenie lub jako globalne ogłoszenie';
$lang['Merge_post'] = 'Scalaj posty w tym temacie';
$lang['Merge_posts'] = 'Scalaj wybrane posty';
$lang['post_expire_q'] = 'Wygaśnie za';
$lang['Password_not_complex'] = 'Hasło ';
$lang['Ignore_mini'] = 'Ignoruj';
$lang['pm_mini'] = 'PM';
$lang['aim_mini'] = 'GG';
$lang['quote_mini'] = 'Cytuj';
$lang['edit_mini'] = 'Edytuj';
$lang['mini_reply'] = 'ODPOWIEDZ';
$lang['mini_newtopic'] = 'NOWY TEMAT';
$lang['mini_locked'] = 'ZAMKNIĘTY';

$lang['too_long_word'] = 'Za długie słowo';
$lang['login_to_shoutcast'] = 'Musisz się zalogować żeby wysłać wiadomość lub wysyłanie wiadomości jest możliwe tylko dla Administratorów i Moderatorów';
$lang['sb_banned_send'] = 'Nie możesz wysyłać wiadomości';
$lang['l_alert_sb'] = 'Czy na pewno chcesz usunąć wiadomość?';
$lang['l_refresh_sb'] = 'Shoutbox otrzymał 100 pustych odpowiedzi od serwera, aby kontynuować naciśnij ten przycisk.';
$lang['sb_restriction'] = 'Shoutbox został wyłączony lub otrzymaśe bana.';
$lang['l_cancel_sb'] = 'Anuluj';
$lang['l_edit_sb'] = 'Zapisz';
$lang['emotki'] = 'Buźki';
$lang['Email_explain'] = 'Jeżeli twój mail to np. janek@jan.pl to w pierwsze pole wpisz janek, a w drugie jan.pl';

$lang['banned_forum'] = 'Administrator zablokował Tobie możliwość pisania w tym forum';

$lang['edit_time_past'] = 'Nie możesz juz zmienić swojego postu. Post można zmieniać przez <b>%d</b> minut, Od momentu jego wysłania';
$lang['This_closed_group'] = 'To jest zamknięta grupa, %s';
$lang['This_hidden_group'] = 'To jest ukryta grupa, %s';
$lang['No_more'] = 'nowi użytkownicy nie będą przyjmowani';
$lang['No_add_allowed'] = 'automatyczne przyjmowanie użytkowników nie jest dozwolone';
$lang['Join_auto'] = 'Możesz dołączyć do grupy jeśli ilość twoich postów osiągnie wystarczającą wartość';
$lang['Permissions'] = 'Zezwolenia';
$lang['quote_image'] = 'Obrazek';
$lang['Gender'] = 'Płeć';
$lang['Male'] = 'Mężczyzna';
$lang['Female'] = 'Kobieta';
$lang['No_gender_specify'] = 'Nie wiadomo :)';
$lang['not_gg_account'] = 'Brak numeru lub hasła bramki GG. Poinformuj administratora';
$lang['not_gg_addresat'] = 'Brak adresata';
$lang['wrong_gg_addresat'] = 'Zły format numeru adresata';
$lang['not_gg_msg'] = 'Brak treści wiadomości';
$lang['gg_too_long'] = 'Długość wiadomości nie może przekraczać 1800 znaków';
$lang['topic_expire_mod'] = 'Wygaśnie za: ';
$lang['Forum_link_visited'] = 'Odwiedzono %d razy';
$lang['Redirect'] = 'Przeniesienie';
$lang['Never'] = 'Nigdy';
$lang['login_require'] = 'Dostęp do tej części forum wymaga zalogowania się.';
$lang['login_require_register'] = 'Jeżeli nie jesteś jeszcze zarejestrowany, kliknij %sTutaj%s żeby przejść do formularza rejestracyjnego.';

$lang['generate_time'] = 'Strona wygenerowana w';
$lang['second'] = 'sekundy';
$lang['seconds'] = 'sekund';
$lang['Warnings'] = 'Ostrzeżenia';
$lang['Warnings_viewtopic'] = 'Ostrzeżeń';
$lang['warnings_banned_info'] = '<b>Masz zakaz wstępu na forum!</b><br /><br />Na swoim koncie masz ostrzeżeń: <b>%s</b> o łącznej wartości: <b>%s</b>. Wartość po której użytkownik jest banowany to: <b>%s</b><br /><br />Ostatnie ostrzeżenie dostał' .  (($he) ? 'e' : 'a') . 'ś: <b>%s</b><br />Powód: <i>%s</i>';
$lang['disallow_posting'] = 'Przekroczono limit ostrzeżeń. Nie możesz pisać nowych postów ani tematów.<br /><br />Kliknij %sTutaj%s żeby przejść do strony ostrzeżeń.';
$lang['warnings_lastwar_info'] = '<b>Wystawiono Ci ostrzeżenie!</b><br /><br />Kliknij %sTutaj%s żeby je zobaczyć.<br /><br />Może być konieczne ponowne zalogowanie.';
$lang['support'] = '<br /><br />Jeśli nie potrafisz znaleźć rozwiązania tego problemu,<br />możesz spróbować poszukać, lub zadać pytanie na forum: <a href="http://www.przemo.org/phpBB2/" target="_blank">http://www.przemo.org/phpBB2/</a>';
$lang['poster_posts'] = 'Brał' .  (($he) ? 'e' : 'a') . 'ś udział w tej dyskusji';
$lang['Sort_per_letter'] = 'Pokaż użytkowników na literę';
$lang['Others'] = 'inna';
$lang['All'] = 'wszystkich';
$lang['ignore_topic_added'] = 'Wybrany temat/tematy zostały dodane do listy ignorowanych.<br />Nie będziesz ich widział' .  (($he) ? '' : 'a') . ' w liście tematów, oraz w liście tematów nieprzeczytanych (lub "od ostatniej wizyty" w zależności od ustawień forum)<br /><br />Kliknij %sTutaj%s żeby zobaczyć swoją liste ignorowanych tematów.<br /><br />Kliknij %sTutaj%s żeby wrócić na stronę główną.';
$lang['ignore_topic_unignored'] = 'Wybrany temat/tematy zostały usunięte z twojej listy ignorowanych tematów.<br /><br />Kliknij %sTutaj%s żeby zobaczyć swoją liste ignorowanych tematów.<br /><br />Kliknij %sTutaj%s żeby wrócić na stronę główną.';
$lang['ignore_mark'] = 'Ignoruj zaznaczone tematy';
$lang['ignore_topics'] = 'Ignorowane tematy';
$lang['list_ignore'] = 'Lista tematów które ignorujesz';
$lang['list_ignore_e'] = 'Z listy automatycznie są kasowane tematy w których nie pojawiła się odpowiedź przez ostatnie 3 miesiące';
$lang['ignore_list_empty'] = 'Nie ignorujesz żadnego tematu.<br /><br />Kliknij %sTutaj%s żeby wrócić na stronę główną.';
$lang['ignore_topic'] = 'Ignoruj ten temat';
$lang['current_topic_ignore'] = 'Ignorujesz ten temat';
$lang['bbcode_ct_help'] = 'Kolor tematu, widoczny w widoku tematów';
$lang['topic_color'] = 'Kolor tematu';
$lang['15_min'] = '15 Minut';
$lang['30_min'] = '30 Minut';
$lang['1_Hour'] = '1 Godziny';
$lang['2_Hour'] = '2 Godzin';
$lang['6_Hour'] = '6 Godzin';
$lang['12_Hour'] = '12 Godzin';
$lang['icons'] = 'Wszystkie ikony postu/tematu';
$lang['your_posts'] = 'twoich postów';
$lang['replys_last_post'] = 'odpowiedzi od czasu twojego ostatniego postu';
$lang['unread_posts'] = 'postów nieprzeczytanych';
$lang['not_poster_post'] = 'Nie brał' .  (($he) ? 'e' : 'a') . 'ś udziału w tej dyskusji';
$lang['lang_q_quote_e'] = 'Po zaznaczeniu części tekstu który chcesz cytować i kliknięciu tutaj, tekst wraz ze znacznikami BBCode pojawi się na dole w szybkiej odpowiedzi. Możesz użyć kilkukrotnie.';
$lang['ignore_topic_submit_e'] = 'Dodaje zaznaczone wyżej tematy do twojej listy ignorowanych tematów. Nie będą one wyświetlane w widoku forum, oraz w wynikach wyszukiwania.';
$lang['data'] = 'Administrator forum narusza zasady korzystania ze skryptu forum dyskusyjnego <a href="http://www.przemo.org/phpBB2/">phpBB modified by Przemo</a><br />Forum zostało zablokowane !<br /><br />Więcej informacji można uzyskać pisząc na e-mail: przemo@przemo.org';
$lang['more_topicicons'] = 'Masz do wyboru większą ilość ikon, po kliknięciu w to pole, otworzy się okno z dodatkowymi ikonami.';
$lang['online_minutes'] = 'Jest na forum minut: <b>%s</b>';
$lang['online_hours'] = 'Jest na forum godzin: <b>%s</b>';
$lang['Viewing_topic'] = 'Czyta temat';
$lang['gg_header_info_pm'] = 'Otrzymał' .  (($he) ? 'e' : 'a') . 'ś nową prywatną wiadomość od: %s';
$lang['gg_notify_topic'] = 'W obserwowanym przez Ciebie temacie: "%s" użytkownik: %s napisał odpowiedź';
$lang['l_notify_gg_privmsg'] = 'Link do twojej skrzynki: %s';
$lang['l_notify_gg_topic'] = 'Żeby zobaczyć temat kliknij: %s';
$lang['generate_queries'] = 'Zapytań do SQL';
$lang['unread_post'] = 'Nieczytany post';
$lang['refresh'] = 'Odśwież';
$lang['new_board_topic'] = 'Na forum %s użytkownik %s napisał nowy temat: %s';
$lang['new_board_post'] = 'Na forum %s użytkownik %s napisał odpowiedź w temacie: %s';
$lang['Search_post_time'] = 'Wyświetl posty z ostatnich';
$lang['Search_post_time_e'] = 'Wyświetla posty napisane w ciągu ostatniego wybranego czasu. Można wybrać metodę wyświetlania: Posty i Tematy';
$lang['user_not_allowpm'] = 'Nie możesz wysłać prywatnej wiadomości do tego użytkownika. Użytkownik wyłączył prywatne wiadomości.';
$lang['open_all_new_window'] = 'Otwórz wszystkie w nowych oknach';

$lang['s_email_friend'] = 'Powiadom znajomego o tym temacie';
$lang['s_email_friend_f_name'] = 'Imię znajomego:';
$lang['s_email_friend_f_email'] = 'Email znajomego:';
$lang['s_email_friend_title'] = '%s zobacz temat na: %s';
$lang['s_email_friend_message'] = 'Przeczytał' .  (($he) ? 'e' : 'a') . 'm temat %s na %s i pomyślał' .  (($he) ? 'e' : 'a') . 'm, że musisz go zobaczyć! Naprawdę warto! Tutaj jest link: %s';

$lang['mstr'] = 'Automatyczna naprawa tabeli w bazie SQL';
$lang['rrtf'] = "Tabela %s uległa uszkodzeniu, próba automatycznej naprawy nie powiodła się:\n%s\n%s\nSpróbuj naprawić tabelę ręcznie wykonując zapytanie: REPAIR TABLE %s";
$lang['rrts'] = "Tabela %s uległa uszkodzeniu, próba automatycznej naprawy prawdopodobnie powiodła się:\n%s\n Jeśli nie, spróbuj wykonac zapytanie ręcznie: REPAIR TABLE %s";
$lang['rrsum'] = 'Wystąpił drobny problem techniczny, skrypt dokonał próby naprawy i wysłał powiadomienie do Administratora forum<br />Sprobuj odświeżyć stronę';

$lang['Report_no_access'] = 'Nie masz możliwości używania tej opcji';
$lang['Report_disabled'] = 'Post tego użytkownika nie może zostać zgłoszony';
$lang['Report_post_already_reported'] = 'Ten post został już zgłoszony wcześniej';
$lang['Report_post_self'] = 'Nie możesz zgłaszać swoich postów';
$lang['Report_already_removed'] = 'Ten post został usunięty';
$lang['Report_no_posts'] = 'Nie ma zgłoszonych żadnych postów';
$lang['Report_no_title'] = 'Brak tytułu';
$lang['Reporter'] = 'Zgłaszający';
$lang['Report_posts'] = 'Zgłoszone posty';
$lang['Report_popup_text'] = 'Następujące posty zostały zgłoszone:';
$lang['Report_deleted'] = 'Zgłoszenie usunięte.';
$lang['Report_post_reported'] = 'Zgłoszenie zostało wysłane. Dziękujemy.';
$lang['Report_post'] = 'Zgłoś ten post do Moderatora i Administratora';
$lang['Report_del'] = 'Usuń zgłoszenie';
$lang['Report_no_popup'] = 'Otwórz popup o zgłoszonych postach';
$lang['Report_no_mail'] = 'Powiadom na e-mail o zgłoszonych postach';
$lang['Report_reload_window'] = 'Odśwież okno';
$lang['Report_no_auth'] = 'Nie możesz zgłosić postów, ta funkcja została Ci odebrana, lub nie jestes zalogowany.';
$lang['Report_open_popup'] = 'Otwórz popup zgłoszeń';
$lang['Report_list'] = 'Lista zgłoszeń';
$lang['added'] = 'Dodano';
$lang['Voted_show'] = 'Głosowań: '; // it means :  users that voted  (the number of voters will follow)
$lang['Results_after'] = 'Wynik będzie pokazany po zakończeniu trwania ankiety';
$lang['Poll_expires'] = 'Zakończenie ankiety za: ';
$lang['Minutes'] = 'Minut';
$lang['Max_vote'] = 'Maksimum "zaznaczeń"';
$lang['Max_vote_explain'] = '[ Wpisz 1 lub pozostaw puste dla jednego "zaznaczenia" ]';
$lang['Max_voting_1_explain'] = 'Wybierz tylko ';
$lang['Max_voting_2_explain'] = ' odpowiedzi';
$lang['Max_voting_3_explain'] = ' (więcej odpowiedzi będzie ignorowane)';
$lang['Vhide'] = 'Ukryj';
$lang['Hide_vote'] = 'Wynik';
$lang['Tothide_vote'] = 'Sumę głosów';
$lang['Hide_vote_explain'] = ' [ Ukrycie do czasu zakończenia ankiety ]';
$lang['rname'] = 'Szybka rejestracja';

$lang['helped_confirm'] = 'Jesteś ' .  (($he) ? 'autorem' : 'autorką') . ' tego tematu, jeżeli ta odpowiedź Ci pomogła, możesz dodać jeden punkt "POMÓGŁ" temu użytkownikowi<br /><br />Kliknij %sTUTAJ%s aby dodać punkt, lub kliknij %sTUTAJ%s aby anulować i powrócić do tematu';
$lang['helped_delete_confirm'] = 'Jesteś ' .  (($he) ? 'pewien' : 'pewna') . ' że chcesz usunąć punkt "POMÓGŁ" dla tego postu ?<br /><br />Kliknij %sTUTAJ%s jeżeli chcesz usunąć punkt, lub %sTUTAJ%s aby powrócić do tematu';
$lang['helped_added'] = 'Punkt został dodany<br /><br />Kliknij %sTUTAJ%s aby powrócic do tematu.';
$lang['He_helped'] = 'Jeżeli ten post pomógł Ci, kliknij aby dodać punkt temu użytkownikowi';
$lang['He_helped_delete'] = 'Usuń punkt \'pomógł\' dla tego postu';
$lang['help_1'] = ' raz';
$lang['help_more'] = ' razy';
$lang['postrow_help'] = '<b>Pomógł:</b> ';
$lang['postrow_help_she'] = '<b>Pomogła:</b> ';
$lang['helped'] = 'Pomógł';
$lang['Joined_she'] = 'Dołączyła';
$lang['that_same_msg'] = 'Nie możesz wysłać dwóch takich samych wiadomości !';
$lang['Seeker'] = 'Szukaj użytkowników';
$lang['No_split_post'] = 'Nie łącz tego postu';
$lang['too_many_voting'] = 'W tej sondzie maksymalną wartością oddanych głosów jest: <b>%s</b>, Ty zaznaczył' .  (($he) ? 'e' : 'a') . 'ś <b> %s</b>.<br />Głos nie został oddany, wróć i zagłosuj jeszcze raz.';
$lang['failed_sending_email'] = 'Bład wysyłania email\'a<br />Może został podany zły adres e-mail, w przeciwnym razie Administrator pownien sprawdzić przyczynę lub wyłaczyć wysyłanie email\'i przez forum.';

$lang['Print_topic'] = 'To jest tylko wersja do druku, aby zobaczyć pełną wersję tematu, kliknij TUTAJ';

$lang['notify_message'] = 'Twój %s napisany przez Ciebie na: %s, został usunięty przez Administratora lub Moderatora%s';
$lang['your_post'] = ' Twój post:';
$lang['Reason'] = 'Powód';
$lang['subject_notify_delete'] = 'Twój %s został usunięty';
$lang['topic_link'] = "\n\rLink do tematu: %s";
$lang['forum_service'] = 'Obsługa forum';
$lang['confirm_report_post'] = 'Czy na pewno chcesz zgłosić ten post do Moderatora i Administratora?';
$lang['Accept'] = 'Zaakceptuj';
$lang['Reject'] = 'Odrzuć';
$lang['Accept-reject'] = 'Zaakceptuj/Odrzuć wybrane';
$lang['Post_no_approved'] = 'Oczekuje na akceptację';
$lang['Loser_protect'] = 'UWAGA! Próbujesz odpowiedziec w temacie na <b>%s</b> stronie tematu, temat zawiera stron <b>%s</b>.<br />Przeczytaj cały temat aby w nim odpowiedzieć!<br /><br />Kliknij %sTutaj%s aby przejść do następnej strony tematu.<br />Kliknij %sTutaj%s jeśli jesteś przekonanan' .  (($he) ? 'y' : 'a') . ', że chcesz odpowiedzieć nie czytając całego tematu.';
$lang['User_deleted'] = 'Usunięty';
$lang['Account_delete'] = 'Usunięcie konta na %s';
$lang['User_report_post'] = 'Użytkownik zgłosił post';
$lang['Subject_e'] = 'Opis tematu';
$lang['Subject_e_info'] = 'nieobowiązkowy';
$lang['show_ignore_topics'] = 'Pokaż ignorowane tematy';
$lang['footer'] = 'Stopka forum została zmodyfikowana, forum nie będzie działać prawidłowo!<br />Ustaw prawidłowo stopkę w pliku overall_footer.tpl, musi być ona widoczna w przegladarce, nie może zawierać "sztuczek" maskujacych.<br /><br />Wzór: <b>Powered by &lt;a href=&quot;http://www.phpbb.com&quot; target=&quot;_blank&quot; class=&quot;copyright&quot;&gt;phpBB&lt;/a&gt; modified by &lt;a href=&quot;http://www.przemo.org/phpBB2/&quot; class=&quot;copyright&quot; target=&quot;_blank&quot;&gt;Przemo&lt;/a&gt; &amp;copy; 2003 phpBB Group</b>';
$lang['db_backup_done'] = 'W tym momencie forum rozpoczęło tworzenie kopii zapasowej bazy danych.<br />Proszę wrócić na forum za minutę.';
$lang['Freak_undo'] = 'Ctrl+Z aby cofnąć';
$lang['Today'] = 'Dzisiaj';
$lang['Yesterday'] = 'Wczoraj';
$lang['TA_Locked'] = 'Zamknięty';
$lang['TA_Unocked'] = 'Otwarty';
$lang['TA_Moved'] = 'Przesunięty';
$lang['TA_Expired'] = 'Wygaszony';
$lang['TA_Who'] = 'przez';
$lang['TA_Delete'] = 'Usuń tą informację';
$lang['Comment_post'] = 'Dopisz komentarz do postu';
$lang['Comment_added'] = 'Komentarz dodany przez: %s';
$lang['Topic_important'] = 'Wartość merytoryczna';
$lang['First_post'] = 'Pierwszy post';
$lang['Post_history'] = 'Historia edycji postu';
$lang['Custom_Rank'] = 'Tytuł użytkownika';
$lang['Your_topic_moved'] = 'Twój temat na %s został przesunięty';
$lang['Your_topic_moved_message'] = 'Napisany przez Ciebie temat: "%s" w forum: "%s" został przesunięty do forum: "%s" Link do tematu: %s %s';
$lang['Important_topics'] = 'Ważne tematy';
$lang['View_next_unread_posts'] = 'Zobacz kolejne nieczytane posty';
$lang['Go'] = 'Idź';
$lang['adv_person'] = 'Zaproszone osoby';
$lang['adv_person_link'] = 'Aby zaprosić znajomego na to forum, skopiuj ten link: %s';
$lang['Invalid_session'] = 'Sesja połączenia wygasła lub numer ID sesji jest nieprawidłowy.<br />Spróbuj ponownie.';
$lang['Not_admin'] = 'Nie posiadasz uprawnień administratora.';
$lang['Posting_disabled'] = 'Pisanie postów i tematów zostało wyłączone.';
$lang['Registering_disabled'] = 'Rejestracja została wyłączona.';
$lang['Pruning_unread_posts'] = 'Twoje konto przekroczyło maksymalną ilość nieprzeczytanych postów: <b>%s</b> Zostały usunięte informacje o nieczytanych postach z wyjątkiem postów napisanych przez ostatnie: <b>%s</b> dni<br />Ilość usuniętych nieczytanych postów: <b>%s</b><br /><br />Aby nie otrzymywać tego komunikatu, przeczytaj oznaczone tematy, lub oznacz wszystkie jako przeczytane.<br />W każdej chwili możesz skorzystać z wyszukiwarki postów aby odszukać posty napisane w ciągu ostatniego wybranego czasu.';
$lang['Votes'] = 'Głosy';
$lang['Topic_gallery'] = 'Umieść obrazy dodawane w temacie do ogólnej galerii';
$lang['Topic_gallery_e'] = 'Wybranie tej opcji automatycznie doda wszystkie obrazy zawarte w tagach [IMG] z tematu i odpowiedzi do galerii ogólnej';
//
// That's all Folks!
// -------------------------------------------------

?>