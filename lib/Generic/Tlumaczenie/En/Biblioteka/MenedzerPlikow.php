<?php
namespace Generic\Tlumaczenie\En\Biblioteka;

use Generic\Tlumaczenie\Tlumaczenie;


/**
 * @property string $t['menedzer_plikow_nazwa']
 * @property string $t['menedzer_plikow_menu']
 * @property string $t['menedzer_plikow_brak']
 * @property string $t['menedzer_plikow_wyslij']
 * @property string $t['menedzer_plikow_glowna']
 * @property string $t['menedzer_plikow_stworz']
 * @property string $t['menedzer_plikow_usun']
 * @property string $t['menedzer_plikow_zmienNazwe']
 * @property string $t['menedzer_plikow_kom_kopiowanie']
 * @property string $t['menedzer_plikow_kom_kopiowanieBlad']
 * @property string $t['menedzer_plikow_kom_przenoszenie']
 * @property string $t['menedzer_plikow_kom_przenoszenieBlad']
 * @property string $t['menedzer_plikow_kom_nowyKatalog']
 * @property string $t['menedzer_plikow_kom_nowyKatalogBlad']
 * @property string $t['menedzer_plikow_kom_zmianaNazwy']
 * @property string $t['menedzer_plikow_kom_zmianaNazwyBlad']
 * @property string $t['menedzer_plikow_kom_upload']
 * @property string $t['menedzer_plikow_kom_uploadBlad']
 * @property string $t['menedzer_plikow_kom_usun']
 * @property string $t['menedzer_plikow_kom_usunBlad']
 * @property string $t['menedzer_plikow_kom_zleRozszerzenie']
 * @property string $t['menedzer_plikow_kom_zlaSciezka']
 * @property string $t['menedzer_plikow_kom_domyslny']
 * @property string $t['menedzer_plikow_kom_pustePole']
 * @property string $t['menedzer_plikow_kom_zlaSciezka']
 * @property string $t['menedzer_plikow_kom_zlaSciezkaMin']
 * @property string $t['menedzer_plikow_kom_zlaNazwa']
 * @property string $t['menedzer_plikow_kom_zlyRozmiar']
 * @property string $t['menedzer_plikow_kom_zmianaNazwy']
 * @property string $t['menedzer_plikow_poprawNazwe']
 * @property string $t['menedzer_plikow_kom_przenoszenieOff']
 * @property string $t['menedzer_plikow_kom_uploadOff']
 * @property string $t['menedzer_plikow_kom_zmianaNazwyOff']
 * @property string $t['menedzer_plikow_kom_usuwanieOff']
 * @property string $t['menedzer_plikow_kom_tworzenieKatalogowOff']
 * @property string $t['menedzer_plikow_brak_sciezka']
 * @property string $t['menedzer_etykieta_upload']
 */
class MenedzerPlikow extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'menedzer_plikow_nazwa' => 'Files manager',
		'menedzer_plikow_menu' => 'Directory tree',
		'menedzer_plikow_brak' => '..',
		'menedzer_plikow_wyslij' => 'Upload',
		'menedzer_plikow_glowna' => 'Main directory',
		'menedzer_plikow_stworz' => 'Create directory',
		'menedzer_plikow_usun' => 'Are you sure you want to remove selected element?',
		'menedzer_plikow_zmienNazwe' => 'Enter new filename:',
		'menedzer_plikow_kom_kopiowanie' => 'Selected files have been copied',
		'menedzer_plikow_kom_kopiowanieBlad' => 'Selected files couldn\'t be copied',
		'menedzer_plikow_kom_przenoszenie' => 'Selected files have been moved',
		'menedzer_plikow_kom_przenoszenieBlad' => 'You cannot move files here',
		'menedzer_plikow_kom_nowyKatalog' => 'Directory created',
		'menedzer_plikow_kom_nowyKatalogBlad' => 'Directory couldn\'t be created',
		'menedzer_plikow_kom_zmianaNazwy' => 'Filename changed',
		'menedzer_plikow_kom_zmianaNazwyBlad' => 'Filename couldn\'t be changed',
		'menedzer_plikow_kom_upload' => 'File uploaded successfully',
		'menedzer_plikow_kom_uploadBlad' => 'Error occured while file upload',
		'menedzer_plikow_kom_usun' => 'Selected files have been removed',
		'menedzer_plikow_kom_usunBlad' => 'Error occured while files removing',
		'menedzer_plikow_kom_zleRozszerzenie' => 'File with this extension is not allowed',
		'menedzer_plikow_kom_zlaSciezka' => 'This path is incorrect',
		'menedzer_plikow_kom_domyslny' => 'Drag and drop files here',
		'menedzer_plikow_kom_pustePole' => 'Directory name was not entered',
		'menedzer_plikow_kom_zlaSciezka' => 'Entered pathname is icorrect',
		'menedzer_plikow_kom_zlaSciezkaMin' => 'Entered pathname for thumbnails is incorrect',
		'menedzer_plikow_kom_zlaNazwa' => 'Entered filename is incorrect',
		'menedzer_plikow_kom_zlyRozmiar' => 'Maximum file size exceeded (%s)',
		'menedzer_plikow_kom_zmianaNazwy' => 'The entered filename was automaticly corrected to: %s',
		'menedzer_plikow_poprawNazwe' => 'The entered filename is incorrect, please enter correct now',
		'menedzer_plikow_kom_przenoszenieOff' => 'Moving files disabled',
		'menedzer_plikow_kom_uploadOff' => 'Files upload to this server is disabled',
		'menedzer_plikow_kom_zmianaNazwyOff' => 'Changing of filenames are disabled',
		'menedzer_plikow_kom_usuwanieOff' => 'Removing of files disabled',
		'menedzer_plikow_kom_tworzenieKatalogowOff' => 'Creating of new directories disabled',
		'menedzer_plikow_brak_sciezka' => 'The files manager is not configured properly, please refer this issue to the system administrator',
		'menedzer_etykieta_upload' => 'Upload files',
		'menedzer_etykieta_katalogi' => 'New Directory',
		'menadzer_etykieta_kolumna_nazwa' => 'Name',
		'menadzer_etykieta_kolumna_typ' => 'Type',
		'menadzer_etykieta_kolumna_rozmiar' => 'Size',
		'menadzer_etykieta_kolumna_data' => 'Date',
	);
}