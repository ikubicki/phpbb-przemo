<?php
$lang['Advert_explain'] = 'W tym miejscu możesz wyposażyć swoją stronę główną (szczegóły na forum dyskusyjnym skryptu) o linki i bannery reklamowe w prawej kolumnie i w stopce.<br />Masz do dyspozycji wiele opcji jak: czas wygaśnięcia, włączenie powiadamiania o wygasaniu na e-mail osoby zainteresowanej linkiem, możliwość zliczania kliknięć i inne.';

$lang['Advert'] = 'Nagłówkowy kod HTML prawej kolumny<br /><span class="gensmall"><a href="../images/dynamic.html" target="_blank">Obsługa zamienników</a></span>';
$lang['Advert_foot'] = 'Kod HTML stopki prawej kolumny';
$lang['Ad_view_hide'] = 'Możliwość ukrywania przez użytkowników';
$lang['Ad_registered_users'] = 'Zalogowanych';
$lang['Ad_staff_users'] = 'Moderatorów, Administratorów';
$lang['Disable'] = 'Wyłączone';
$lang['Ad_width'] = 'Szerokość prawej kolumny';

$lang['Ad_link_setp'] = 'Wpisy';
$lang['Ad_add_link'] = 'Dodaj wpis';
$lang['Ad_days'] = 'Ilość dni';
$lang['Ad_Position'] = 'Pozycja';
$lang['Pos_left'] = 'Z boku';
$lang['Pos_down'] = 'Na dole';
$lang['Pos_no'] = 'Ukryj';
$lang['Ad_separator'] = 'Separator dolnych linków';
$lang['Ad_separator_l'] = 'Separator górnych linków';
$lang['Add_link_e'] = 'Jeżeli podasz e-mail, będzie wysłane na niego powiadomienie na 7 dni przed datą wygaśnięcia (deaktywacji) linku/bannera. Jeżeli chcesz dodać link/banner na stałe, pozostaw pole puste, czas nie będzie odliczany. Treść email\'a możesz zmienić w pliku languages/lang_polish/advert.tpl. Gdy używasz tagów <b>A</b> używaj tylko w takiej kolejności: <b>&lt;a href=&quot;</b> Gdy włączysz zliczanie kliknięć, link/banner będzie linkiem lokalnym np. <b>ad.php?id=7</b> a statystyki kliknięć będą dostępne po wejściu na http://adres.pl/ad.php Kliknięcia są blokowane w cookies na 60 minut, co jednak nie jest najlepszym zabezpieczeniem w przypadku próby celowego nabicia licznika. <a href="../images/dynamic.html" target="_blank">Obsługa zamienników</a>';
$lang['Ad_clicks'] = 'Zliczanie kliknięć';
$lang['Save'] = 'Zapisz';
$lang['empty_html'] = 'Musisz podać kod HTML';
$lang['Config_ad_updated'] = 'Konfiguracja została zapisana';
$lang['Config_ad_not_updated'] = 'Nie wykryto zmian, wpis nie został zmieniony';
$lang['New_entry_added'] = 'Nowa pozycja została dodana';
$lang['Ad_list_entry'] = 'Istniejące wpisy';
$lang['Ad_list_order'] = 'Kolejność';
$lang['Ad_up'] = 'w górę';
$lang['Ad_down'] = 'w dół';
$lang['Last_update'] = 'ostatnia aktualizacja';
$lang['Added'] = 'Dodany';
$lang['delete_entry'] = 'Usuń wpis';

$lang['Ad_clicks_list'] = 'Odwiedzalność';
$lang['Ad_clicks_visit'] = 'Kliknięć';
$lang['Ad_clicks_day'] = 'Dziennie';
$lang['email_title'] = 'Za 7 dni wygaśnie link na "%s"';

// Advertisement person
$lang['Adv_explain'] = 'Zaproszone osoby to system uzyskiwania punktów przez użytkowników za ilość osób którym polecili forum i osoby te zarejestrowały się na forum. Aby aktywować system, utwórz dodatkowe pole w (Użytkownicy > Pola w profilu) o nazwie: <b>adv_person</b> skonfiguruj go odpowiednio według potrzeb. Po aktywacji każdy użytkownik w widoku swojego profilu będzie widział link, który może wysłać znajomym. Gdy osoba zaproszona wejdzie na forum, będzie je przeglądać i zarejestruje się, osobie polecającej zostanie dodana jedna osoba zaproszona.<br />Poniżej znajduje się lista osób wraz z osobami zaproszonymi. Jeżeli polecający ma więcej na liczniku osób zaproszonych niż wskazuje na to lista, oznacza to, że osoby zaproszone zostały usunięte z forum. Dodatkowo zaproszone osoby z takimi samymi adresami IP są zliczani jako jedna osoba, oraz osoby zarejestrowane w odstępie mniejszym niż ustawiony, od tej samej osoby polecającej, również w celu zapobiegnięcia nadużyciom.';
$lang['Adv_time'] = 'Ilość minut przez którą nowe zaproszone osoby nie będą dodawane od momentu zarejestrowania ostatniej zaproszonej osoby dla danego użytkownika (polecającego).';
$lang['Adv_counter'] = 'Licznik';
$lang['Ad_visit'] = 'Wizyt';
$lang['Ad_last_visit'] = 'Ostatnia wizyta';

?>