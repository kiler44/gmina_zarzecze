<?php
namespace Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Walidator;


/**
 * Walidator sprawdzający poprawność uploadu pliku
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class PoprawnyUpload extends Walidator
{

	protected $trescBledow = array(
		'walidator_poprawny_upload_UPLOAD_ERR_OK' => 'Kopiowanie pliku zakończyło się sukcesem.',
		'walidator_poprawny_upload_UPLOAD_ERR_INI_SIZE' => 'Rozmiar pliku przekroczył wartość upload_max_filesize z pliku php.ini.',
		'walidator_poprawny_upload_UPLOAD_ERR_FORM_SIZE' => 'Rozmiar pliku przekroczył wartość MAX_FILE_SIZE z formularza HTML.',
		'walidator_poprawny_upload_UPLOAD_ERR_PARTIAL' => 'Plik został skopiowany tylko częściowo.',
		'walidator_poprawny_upload_UPLOAD_ERR_NO_FILE' => 'Żaden plik nie został skopiowany.',
		'walidator_poprawny_upload_UPLOAD_ERR_NO_TMP_DIR' => 'Brak katalogu tymczasowego.',
		'walidator_poprawny_upload_UPLOAD_ERR_CANT_WRITE' => 'Nie można zapisać pliku na dysk.',
		'walidator_poprawny_upload_UPLOAD_ERR_EXTENSION' => 'Kopiowanie pliku wstrzymane przez rozszerzenie PHP.',
	);

	private $kodyBledowUploadu  = array(
		UPLOAD_ERR_OK => 'walidator_poprawny_upload_UPLOAD_ERR_OK',
		UPLOAD_ERR_INI_SIZE => 'walidator_poprawny_upload_UPLOAD_ERR_INI_SIZE',
		UPLOAD_ERR_FORM_SIZE => 'walidator_poprawny_upload_UPLOAD_ERR_FORM_SIZE',
		UPLOAD_ERR_PARTIAL => 'walidator_poprawny_upload_UPLOAD_ERR_PARTIAL',
		UPLOAD_ERR_NO_FILE => 'walidator_poprawny_upload_UPLOAD_ERR_NO_FILE',
		UPLOAD_ERR_NO_TMP_DIR => 'walidator_poprawny_upload_UPLOAD_ERR_NO_TMP_DIR',
		UPLOAD_ERR_CANT_WRITE => 'walidator_poprawny_upload_UPLOAD_ERR_CANT_WRITE',
		UPLOAD_ERR_EXTENSION => 'walidator_poprawny_upload_UPLOAD_ERR_EXTENSION',
	);


	private $wymusUpload;



	function __construct($wymusUpload = false)
	{
		$this->wymusUpload = (bool)$wymusUpload;
	}



	function sprawdz($wartosc)
	{
		if (is_array($wartosc['name']))
		{
			if (isset($wartosc['error']))
			{
				foreach ($wartosc['error'] as $kodBledu)
				{
					if (!($kodBledu === UPLOAD_ERR_OK || (!$this->wymusUpload && $kodBledu === UPLOAD_ERR_NO_FILE)))
					{
						$this->ustawBlad($this->kodyBledowUploadu[$kodBledu]);
						return false;
					}
				}
			}
		}
		else
		{
			if (isset($wartosc['error']))
			{
				$kodBledu = $wartosc['error'];
				if (!($kodBledu === UPLOAD_ERR_OK || (!$this->wymusUpload && $kodBledu === UPLOAD_ERR_NO_FILE)))
				{
					$this->ustawBlad($this->kodyBledowUploadu[$kodBledu]);
					return false;
				}
			}
		}
		return true;
	}
}
