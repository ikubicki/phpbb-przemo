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

$lang['CF_title'] = 'Dodatkowe pola w profilu u¿ytkowników';
$lang['CF_title_explain'] = 'W tym miejscu masz mo¿liwo¶æ zdefiniowania dowolnej liczby dodatkowych pól w profilu u¿ytkowników. Masz mo¿liwo¶æ okre¶lenia parametrów osobno dla ka¿dego pola, które dodasz.<br />Znajdujê siê tutaj równiez kilka dodatkowych niewidocznych mo¿liwo¶ci, jak ukrywanie opisu podczas wy¶wietlania, multilanguage, obs³uga ikon.<br />Aby poznaæ pe³n± obs³ugê kliknij: <a href="http://www.przemo.org/phpBB2/forum/viewtopic.php?t=3147" target="_blank">Tutaj</a>';
$lang['CF_add'] = 'Dodaj dodatkowe pole';
$lang['CF_no_fields'] = 'W bazie nie istniej± ¿adne pola. U¿yj poni¿szego formularza aby dodaæ pole/pola w profilu u¿ytkowników';
$lang['CF_short_desc'] = 'Nazwa pola';
$lang['CF_long_desc'] = 'D³ugi opis pola (bêdzie widoczny pod nazw±)';
$lang['CF_makelinks'] = 'Automatyczne tworzenie linków';
$lang['CF_max_value'] = 'Maksymalna ilo¶æ wpisanych znaków';
$lang['CF_min_value'] = 'Minimalna ilo¶æ wpisanych znaków';
$lang['CF_numerics'] = 'Tylko warto¶ci liczbowe';
$lang['CF_require'] = 'Wymagane podczas rejestracji';
$lang['CF_view_post'] = 'Pozycja w widoku tematu';
$lang['CF_post'] = 'Nad postem';
$lang['CF_upost'] = 'Pod postem';
$lang['CF_avatar'] = 'Pod avatarem';
$lang['CF_view_profile'] = 'Widoczne w widoku profilu';
$lang['CF_set_form'] = 'Rodzaj wype³nianego pola';
$lang['CF_text'] = 'pole tekstowe';
$lang['CF_textarea'] = 'pole textarea';
$lang['CF_jumpbox'] = 'Generowanie jumpboxa';
$lang['CF_jumpbox_e'] = 'Mo¿esz ustaliæ tylko kilka mo¿liwych pozycji do wyboru, pole wyboru automatycznie zamieni sie w JumpBox z list± pozycji.<br />Kolejne pozycje oddziel przecinkami,<br />przyk³ad: <b>pies,kot</b>';
$lang['CF_added'] = 'Dodatkowe pole: <b>%s</b> dodane do bazy danych.<br /><br />Kliknij %sTutaj%s aby powróciæ do ustawieñ dodatkowych pól.';
$lang['CF_edited'] = 'Dodatkowe pole: <b>%s</b> zosta³o pomy¶lnie zmienione.<br /><br />Kliknij %sTutaj%s aby powróciæ do ustawieñ dodatkowych pól.';
$lang['CF_delete'] = 'Zaznacz, aby usun±æ ca³e dodatkowe pole';
$lang['CF_confirm_delete'] = 'Czy jestes pew' .  (($he) ? 'ien' : 'na') . ', ¿e chcesz ca³kowicie usun±æ to pole ?<br />Pamiêtaj, ¿e nie mo¿na cofn±æ tej operacji i wszystkie dane które wpisywali u¿ytkownicy, zostan± utracone!';
$lang['CF_delete_executed'] = 'Pole zosta³o usuniête z bazy danych<br /><br />Kliknij %sTutaj%s aby powróciæ do ustawieñ dodatkowych pól.';
$lang['CF_duplicate_desc_short'] = 'Pole o nazwie <b>%s</b> ju¿ istnieje.';
$lang['CF_too_short'] = 'Pole: <b>%s</b> jest zbyt krótkie, minimalna ilo¶æ znaków to: %s';
$lang['CF_too_long'] = 'Pole: <b>%s</b> jest zbyt d³ugie, maksymalna ilo¶æ znaków to: %s';
$lang['CF_required'] = 'Pole: <b>%s</b> jest wymagane.';
$lang['CF_no_numeric'] = 'Pole: <b>%s</b> musi byæ w postaci numerycznej..';
$lang['CF_no_jumpbox'] = 'Pole: <b>%s</b> musi pasowaæ do jednej z podanych pozycji.';
$lang['CF_can_allow'] = 'Mo¿e u¿ywaæ: %s';
$lang['CF_no_forum'] = 'Nie wy¶wietlaj w forach';
$lang['Prefix_e'] = 'Prefix i Suffix dodatkowego pola mo¿na u¿yæ w celu uzyskania na przyk³ad efektu linku html do Skype:<br />&lt;a href=&quot;callto://<b>warto¶æ_pola</b>&quot;&gt;<b>warto¶æ_pola</b>&lt;/a&gt; W tym przypadku podaj prefix tylko: <b>&lt;a href=&quot;callto://</b> a suffix: <b>&lt;/a&gt;</b> reszta linku zostanie dodana automatycznie. Je¿eli prefix nie bêdzie zawiera³: <b>&lt;a href=&quot;</b> lub suffix: <b>&lt;/a&gt;</b> zostan± one tylko do³±czone na pocz±tku i koñcu warto¶ci. Prefix i suffix mo¿e te¿ s³u¿yæ do ustawienia dodatkowego pola w postaci kolejnej ikony pod postem - u¿yj w nazwie <b>-#</b> aby wy³±czyæ opis. <a href="../images/dynamic.html" target="_blank">Obs³uga zamienników</a> Przyk³adowy suffix: &lt;img src=&quot;templates/au_tpl/images/lang_au_lng/icon_msnm.gif&quot; border=&quot;0&quot;&gt;&lt;/a&gt;<br />Zamiennik <b>au_value</b> zamienia na warto¶æ pola u¿ytkownika, co umo¿liwia np. stworzenie pola Jabber z ikon± statusu dostêpno¶ci u¿ytkownika, u¿yj -# w nazwie aby ukryæ wy¶wietlanie warto¶ci pola.';
$lang['CF_editable'] = 'U¿ytkownik mo¿e edytowaæ warto¶æ';
$lang['CF_view_by'] = 'Widoczne przez';
$lang['CF_view_by_user'] = 'i u¿ytkownik';
?>