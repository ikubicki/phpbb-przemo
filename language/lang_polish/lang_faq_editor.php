<?php

// Check for user gender
$he = ($userdata['user_gender'] != 2) ? true : false;

$lang['faq_editor'] = 'Edytor FAQ';
$lang['faq_editor_explain'] = 'Ten moduł pozwala na edycje i uporządkowanie pytań z FAQ Staraj się <u>nie kasować</u> Oryginalnych wpisów.';

$lang['faq_select_language'] = 'Wybierz język w jakim chcesz edytować FAQ';
$lang['faq_retrieve'] = 'Edytuj FAQ';

$lang['faq_block_delete'] = 'Jesteś pew' .  (($he) ? 'ien' : 'na') . ' że chcesz skasować ten blok?';
$lang['faq_quest_delete'] = 'Jesteś pew' .  (($he) ? 'ien' : 'na') . ' że chcesz skasować to pytanie z odpowiedźą?';

$lang['faq_quest_edit'] = 'Edytuj pytanie i odpowiedź';
$lang['faq_quest_create'] = 'Utwórz nowe pytanie i odpowiedź';

$lang['faq_quest_edit_explain'] = 'Edytuj pytanie i odpowiedź, możesz też zmienić blok';
$lang['faq_quest_create_explain'] = 'Podaj pytanie i odpowiedź';

$lang['faq_block'] = 'Blok';
$lang['faq_quest'] = 'Pytanie';
$lang['faq_answer'] = 'Odpowiedź';

$lang['faq_block_name'] = 'Nazwa bloku';
$lang['faq_block_rename'] = 'Zmień nazwę bloku';
$lang['faq_block_rename_explain'] = 'Zmień nazwę bloku w FAQ';

$lang['faq_block_add'] = 'Dodaj blok';
$lang['faq_quest_add'] = 'Dodaj pytanie';

$lang['faq_no_quests'] = 'W bloku nie ma pytań. To zablokuje wszystkie bloki występujące po tym przed wyświetleniem. Skasuj ten blok lub dodaj jedno lub więcej pytań.';
$lang['faq_no_blocks'] = 'Brak zdefiniowanych bloków';

$lang['faq_write_file'] = 'Błąd zapisu do pliku językowego! (sprawdź uprawnienia pliku (chmod 666)';
$lang['faq_write_file_explain'] = 'Musisz nadać prawa do zapisu dla plików w language/lang_******/lang_bbcode.php i lang_faq.php W systemach unixowych wykonuje się to poleceniem: <b>chmod 666 plik</b> Niektóre klienty posiadające linię poleceń również na to pozwalają na przykład TotalCommander.';

?>