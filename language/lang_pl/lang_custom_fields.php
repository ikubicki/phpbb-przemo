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
$he = true;

$lang['CF_title'] = 'Dodatkowe pola w profilu u�ytkownik�w';
$lang['CF_title_explain'] = 'W tym miejscu masz mo�liwo�� zdefiniowania dowolnej liczby dodatkowych p�l w profilu u�ytkownik�w. Masz mo�liwo�� okre�lenia parametr�w osobno dla ka�dego pola, kt�re dodasz.<br />Znajduj� si� tutaj r�wniez kilka dodatkowych niewidocznych mo�liwo�ci, jak ukrywanie opisu podczas wy�wietlania, multilanguage, obs�uga ikon.<br />Aby pozna� pe�n� obs�ug� kliknij: <a href="http://www.przemo.org/phpBB2/forum/viewtopic.php?t=3147" target="_blank">Tutaj</a>';
$lang['CF_add'] = 'Dodaj dodatkowe pole';
$lang['CF_no_fields'] = 'W bazie nie istniej� �adne pola. U�yj poni�szego formularza aby doda� pole/pola w profilu u�ytkownik�w';
$lang['CF_short_desc'] = 'Nazwa pola';
$lang['CF_long_desc'] = 'D�ugi opis pola (b�dzie widoczny pod nazw�)';
$lang['CF_makelinks'] = 'Automatyczne tworzenie link�w';
$lang['CF_max_value'] = 'Maksymalna ilo�� wpisanych znak�w';
$lang['CF_min_value'] = 'Minimalna ilo�� wpisanych znak�w';
$lang['CF_numerics'] = 'Tylko warto�ci liczbowe';
$lang['CF_require'] = 'Wymagane podczas rejestracji';
$lang['CF_view_post'] = 'Pozycja w widoku tematu';
$lang['CF_post'] = 'Nad postem';
$lang['CF_upost'] = 'Pod postem';
$lang['CF_avatar'] = 'Pod avatarem';
$lang['CF_view_profile'] = 'Widoczne w widoku profilu';
$lang['CF_set_form'] = 'Rodzaj wype�nianego pola';
$lang['CF_text'] = 'pole tekstowe';
$lang['CF_textarea'] = 'pole textarea';
$lang['CF_jumpbox'] = 'Generowanie jumpboxa';
$lang['CF_jumpbox_e'] = 'Mo�esz ustali� tylko kilka mo�liwych pozycji do wyboru, pole wyboru automatycznie zamieni sie w JumpBox z list� pozycji.<br />Kolejne pozycje oddziel przecinkami,<br />przyk�ad: <b>pies,kot</b>';
$lang['CF_added'] = 'Dodatkowe pole: <b>%s</b> dodane do bazy danych.<br /><br />Kliknij %sTutaj%s aby powr�ci� do ustawie� dodatkowych p�l.';
$lang['CF_edited'] = 'Dodatkowe pole: <b>%s</b> zosta�o pomy�lnie zmienione.<br /><br />Kliknij %sTutaj%s aby powr�ci� do ustawie� dodatkowych p�l.';
$lang['CF_delete'] = 'Zaznacz, aby usun�� ca�e dodatkowe pole';
$lang['CF_confirm_delete'] = 'Czy jestes pew' .  (($he) ? 'ien' : 'na') . ', �e chcesz ca�kowicie usun�� to pole ?<br />Pami�taj, �e nie mo�na cofn�� tej operacji i wszystkie dane kt�re wpisywali u�ytkownicy, zostan� utracone!';
$lang['CF_delete_executed'] = 'Pole zosta�o usuni�te z bazy danych<br /><br />Kliknij %sTutaj%s aby powr�ci� do ustawie� dodatkowych p�l.';
$lang['CF_duplicate_desc_short'] = 'Pole o nazwie <b>%s</b> ju� istnieje.';
$lang['CF_too_short'] = 'Pole: <b>%s</b> jest zbyt kr�tkie, minimalna ilo�� znak�w to: %s';
$lang['CF_too_long'] = 'Pole: <b>%s</b> jest zbyt d�ugie, maksymalna ilo�� znak�w to: %s';
$lang['CF_required'] = 'Pole: <b>%s</b> jest wymagane.';
$lang['CF_no_numeric'] = 'Pole: <b>%s</b> musi by� w postaci numerycznej..';
$lang['CF_no_jumpbox'] = 'Pole: <b>%s</b> musi pasowa� do jednej z podanych pozycji.';
$lang['CF_can_allow'] = 'Mo�e u�ywa�: %s';
$lang['CF_no_forum'] = 'Nie wy�wietlaj w forach';
$lang['Prefix_e'] = 'Prefix i Suffix dodatkowego pola mo�na u�y� w celu uzyskania na przyk�ad efektu linku html do Skype:<br />&lt;a href=&quot;callto://<b>warto��_pola</b>&quot;&gt;<b>warto��_pola</b>&lt;/a&gt; W tym przypadku podaj prefix tylko: <b>&lt;a href=&quot;callto://</b> a suffix: <b>&lt;/a&gt;</b> reszta linku zostanie dodana automatycznie. Je�eli prefix nie b�dzie zawiera�: <b>&lt;a href=&quot;</b> lub suffix: <b>&lt;/a&gt;</b> zostan� one tylko do��czone na pocz�tku i ko�cu warto�ci. Prefix i suffix mo�e te� s�u�y� do ustawienia dodatkowego pola w postaci kolejnej ikony pod postem - u�yj w nazwie <b>-#</b> aby wy��czy� opis. <a href="../images/dynamic.html" target="_blank">Obs�uga zamiennik�w</a> Przyk�adowy suffix: &lt;img src=&quot;templates/au_tpl/images/lang_au_lng/icon_msnm.gif&quot; border=&quot;0&quot;&gt;&lt;/a&gt;<br />Zamiennik <b>au_value</b> zamienia na warto�� pola u�ytkownika, co umo�liwia np. stworzenie pola Jabber z ikon� statusu dost�pno�ci u�ytkownika, u�yj -# w nazwie aby ukry� wy�wietlanie warto�ci pola.';
$lang['CF_editable'] = 'U�ytkownik mo�e edytowa� warto��';
$lang['CF_view_by'] = 'Widoczne przez';
$lang['CF_view_by_user'] = 'i u�ytkownik';
?>