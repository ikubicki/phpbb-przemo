<?php
/***************************************************************************
 *             lang_custom_fields.php [Polish]
 *             -------------------
 *	begin       : Monday, May 10, 2004
 *	copyright   : (C) 2004 Przemo http://www.przemo.org/phpBB2/
 *	email       : przemo@przemo.org
 *
 ***************************************************************************/

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

$lang['CF_title'] = 'Dodatkowe pola w profilu użytkowników';
$lang['CF_title_explain'] = 'W tym miejscu masz możliwość zdefiniowania dowolnej liczby dodatkowych pól w profilu użytkowników. Masz możliwość określenia parametrów osobno dla każdego pola, które dodasz.<br />Znajduję się tutaj równiez kilka dodatkowych niewidocznych możliwości, jak ukrywanie opisu podczas wyświetlania, multilanguage, obsługa ikon.<br />Aby poznać pełną obsługę kliknij: <a href="http://www.przemo.org/phpBB2/forum/viewtopic.php?t=3147" target="_blank">Tutaj</a>';
$lang['CF_add'] = 'Dodaj dodatkowe pole';
$lang['CF_no_fields'] = 'W bazie nie istnieją żadne pola. Użyj poniższego formularza aby dodać pole/pola w profilu użytkowników';
$lang['CF_short_desc'] = 'Nazwa pola';
$lang['CF_long_desc'] = 'Długi opis pola (będzie widoczny pod nazwą)';
$lang['CF_makelinks'] = 'Automatyczne tworzenie linków';
$lang['CF_max_value'] = 'Maksymalna ilość wpisanych znaków';
$lang['CF_min_value'] = 'Minimalna ilość wpisanych znaków';
$lang['CF_numerics'] = 'Tylko wartości liczbowe';
$lang['CF_require'] = 'Wymagane podczas rejestracji';
$lang['CF_view_post'] = 'Pozycja w widoku tematu';
$lang['CF_post'] = 'Nad postem';
$lang['CF_upost'] = 'Pod postem';
$lang['CF_avatar'] = 'Pod avatarem';
$lang['CF_view_profile'] = 'Widoczne w widoku profilu';
$lang['CF_set_form'] = 'Rodzaj wypełnianego pola';
$lang['CF_text'] = 'pole tekstowe';
$lang['CF_textarea'] = 'pole textarea';
$lang['CF_jumpbox'] = 'Generowanie jumpboxa';
$lang['CF_jumpbox_e'] = 'Możesz ustalić tylko kilka możliwych pozycji do wyboru, pole wyboru automatycznie zamieni sie w JumpBox z listą pozycji.<br />Kolejne pozycje oddziel przecinkami,<br />przykład: <b>pies,kot</b>';
$lang['CF_added'] = 'Dodatkowe pole: <b>%s</b> dodane do bazy danych.<br /><br />Kliknij %sTutaj%s aby powrócić do ustawień dodatkowych pól.';
$lang['CF_edited'] = 'Dodatkowe pole: <b>%s</b> zostało pomyślnie zmienione.<br /><br />Kliknij %sTutaj%s aby powrócić do ustawień dodatkowych pól.';
$lang['CF_delete'] = 'Zaznacz, aby usunąć całe dodatkowe pole';
$lang['CF_confirm_delete'] = 'Czy jestes pew' .  (($he) ? 'ien' : 'na') . ', że chcesz całkowicie usunąć to pole ?<br />Pamiętaj, że nie można cofnąć tej operacji i wszystkie dane które wpisywali użytkownicy, zostaną utracone!';
$lang['CF_delete_executed'] = 'Pole zostało usunięte z bazy danych<br /><br />Kliknij %sTutaj%s aby powrócić do ustawień dodatkowych pól.';
$lang['CF_duplicate_desc_short'] = 'Pole o nazwie <b>%s</b> już istnieje.';
$lang['CF_too_short'] = 'Pole: <b>%s</b> jest zbyt krótkie, minimalna ilość znaków to: %s';
$lang['CF_too_long'] = 'Pole: <b>%s</b> jest zbyt długie, maksymalna ilość znaków to: %s';
$lang['CF_required'] = 'Pole: <b>%s</b> jest wymagane.';
$lang['CF_no_numeric'] = 'Pole: <b>%s</b> musi być w postaci numerycznej..';
$lang['CF_no_jumpbox'] = 'Pole: <b>%s</b> musi pasować do jednej z podanych pozycji.';
$lang['CF_can_allow'] = 'Może używać: %s';
$lang['CF_no_forum'] = 'Nie wyświetlaj w forach';
$lang['Prefix_e'] = 'Prefix i Suffix dodatkowego pola można użyć w celu uzyskania na przykład efektu linku html do Skype:<br />&lt;a href=&quot;callto://<b>wartość_pola</b>&quot;&gt;<b>wartość_pola</b>&lt;/a&gt; W tym przypadku podaj prefix tylko: <b>&lt;a href=&quot;callto://</b> a suffix: <b>&lt;/a&gt;</b> reszta linku zostanie dodana automatycznie. Jeżeli prefix nie będzie zawierał: <b>&lt;a href=&quot;</b> lub suffix: <b>&lt;/a&gt;</b> zostaną one tylko dołączone na początku i końcu wartości. Prefix i suffix może też służyć do ustawienia dodatkowego pola w postaci kolejnej ikony pod postem - użyj w nazwie <b>-#</b> aby wyłączyć opis. <a href="../images/dynamic.html" target="_blank">Obsługa zamienników</a> Przykładowy suffix: &lt;img src=&quot;templates/au_tpl/images/lang_au_lng/icon_msnm.gif&quot; border=&quot;0&quot;&gt;&lt;/a&gt;<br />Zamiennik <b>au_value</b> zamienia na wartość pola użytkownika, co umożliwia np. stworzenie pola Jabber z ikoną statusu dostępności użytkownika, użyj -# w nazwie aby ukryć wyświetlanie wartości pola.';
$lang['CF_editable'] = 'Użytkownik może edytować wartość';
$lang['CF_view_by'] = 'Widoczne przez';
$lang['CF_view_by_user'] = 'i użytkownik';
?>