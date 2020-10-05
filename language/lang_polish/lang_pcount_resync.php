<?php
/***************************************************************************
 *                      lang_pcount_resync.php [Polish]
 *                      -------------------
 *     begin            : Fri Sep 06 2002
 *     copyright        : (C) 2002 Adam Alkins
 *     email            : phpbb@rasadam.com
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

$lang['Resync_page_desc_simple'] = 'W wielu przypadkach licznik post�w u�ytkownik�w nie odzwierciedla prawdziwej ilo�ci post�w kt�r� u�ytkownik ma na forum. Podczas kasowania tematu, postu licznik post�w u�ytkownik�w jest zmniejszany. Jednak w przypadku gdy kasujemy ca�e forum, lub forum ma ustawione czyszczenie, licznik post�w u�ytkownik�w celowo nie jest zmniejszany.<br />To narz�dzie umo�liwia synchronizacje licznika post�w wszystkich u�ytkownik�w do rzeczywistej warto�ci.<br />Synchronizacj� mo�na wykona� w trybie prostym, dla wszystkich for�w i wszystkich u�ytkownik�w, oraz w trybie zaawansowanym, wybieraj�c forum (dla for z du�� ilo�ci� post�w i u�ytkownik�w), lub u�ytkownika.<br /><b>Uwaga</b> Funkcja ta synchronizuje r�wnie� (tylko w trybie prostym) niekt�re tabele w kt�rych istnieje u�ytkownik, kt�rego nie ma w tabeli u�ytkownik�w, oraz przywraca moderatorom usuni�tych grup poziom zwyk�ego u�ytkownika, je�eli w danej chwili nie s� moderatorami.';
$lang['Resync_page_desc_adv'] = '';

$lang['Resync_batch_mode'] = 'Batch mode';
$lang['Resync_batch_number'] = 'Batch Number';
$lang['Resync_batch_amount'] = 'Resyncs per Batch';
$lang['Resync_finished'] = 'Zako�czone';

$lang['Resync_completed'] = 'Synchronizacja zako�czona pomy�lnie';

$lang['Resync_question'] = 'Synchronizacja?';

$lang['Resync_check_all'] = 'Zaznacz aby zsynchronizowa� liczniki wszystkich u�ytkownik�w:';

$lang['Resync_do'] = 'Synchronizacja';

$lang['Resync_redirect'] = '<br /><br />Wr�� do <a href="%s">Synchronizacji u�ytkownik�w</a><br /><br />Wr�� do <a href="%s">Panelu Administracyjnego</a>.';
$lang['Resync_invalid'] = 'B��dne ustawienia - Brak u�ytkownik�w do synchronizacji';

?>
