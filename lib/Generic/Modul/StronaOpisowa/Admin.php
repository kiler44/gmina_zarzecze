<?php
namespace Generic\Modul\StronaOpisowa;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Plik\MultiUpload;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\StronaOpisowa;
use Generic\Model\Zalacznik;
use Generic\Model\Galeria;
use Generic\Biblioteka\Cms;
//use function GuzzleHttp\Promise\queue;


/**
 * Moduł odpowiedzialny za edytowanie strony opisowej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

    protected $uprawnienia = array(
        'wykonajIndex',
        'wykonajZapiszPlik',
        'wykonajUsunPlik'
    );

	/**
	 * @var \Generic\Konfiguracja\Modul\StronaOpisowa\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\StronaOpisowa\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$mapper = $this->dane()->StronaOpisowa();

		$strona = $mapper->pobierzDlaKategorii(ID_KATEGORII);

		if (!($strona instanceof StronaOpisowa\Obiekt))
		{
			$strona = new StronaOpisowa\Obiekt();
		}

        $galerie = $this->dane()->Galeria()
            ->zwracaTablice(array('id', 'nazwa'))
            ->szukaj(array(), null, new Galeria\Sorter('nazwa', 'asc'));

        $lista = listaZTablicy($galerie, 'id', 'nazwa');

		$obiektFormularza = new \Generic\Formularz\StronaOpisowa\Edycja();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawObiekt($strona)
            ->ustawListeGalerii($lista)
            ->ustawKategorieLinkow($this->kategoria);
        $obiektFormularza->ustawKonfiguracje($this->k->k);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
		    $wartosci = $obiektFormularza->pobierzWartosci();

			foreach ($wartosci as $klucz => $wartosc)
			{
                if($klucz == 'zalaczniki')
                {
                    $multiUpload = new MultiUpload($wartosci['zalaczniki']['token']);
                    $katalogDocelowy = new \Generic\Biblioteka\Katalog($strona->pobierzKatalog());
                    $zalaczniki = array();
                    $zalaczniki = listaZTablicy($wartosci['zalaczniki']['pliki'], null, 'kolejnosc');
                    $plikiUzytkownika = $multiUpload->przeniesPliki(
                        $zalaczniki,
                        $wartosci['zalaczniki']['pliki'], $katalogDocelowy, 1);

                    continue;
                }

				$strona->$klucz = $wartosc;
			}

			$strona->idProjektu = ID_PROJEKTU;
			$strona->kodJezyka = KOD_JEZYKA;
			$strona->idKategorii = ID_KATEGORII;
			$strona->idAutora = Cms::inst()->profil()->id;
			$strona->dataDodania = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);

			if ($strona->zapisz($mapper))
			{
                if(count($plikiUzytkownika))
                {
                    foreach($plikiUzytkownika as $id => $plik)
                    {
                        if(isset($plik['kod']))
                        {
                            $plik['nazwa'] = Plik::unifikujNazwe($plik['nazwa']);
                            $zalacznikPlik = new Plik($katalogDocelowy.'/'.$plik['nazwa']);

                            $zalacznik = new Zalacznik\Obiekt();
                            $zalacznik->file = $plik['nazwa'];
                            $zalacznik->dateAdded = new \DateTime();
                            $zalacznik->rozmiar = $plik['rozmiar'];
                            $zalacznik->opis = $plik['opis'];
                            $zalacznik->type = $zalacznikPlik->getMimeType();

                            $strona->dodajZalacznik($zalacznik);
                        }
                        elseif(isset($plik['opis']))
                        {
                            $zalacznik = $this->dane()->Zalacznik()->pobierzPoId($id);
                            $zalacznik->opis = $plik['opis'];
                            $zalacznik->zapisz(new Zalacznik\Mapper());
                        }

                    }
                }
				$this->komunikat($this->j->t['index.info_zapisano_dane_strony'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['index.blad_nie_mozna_zapisac_strony'], 'error');
			}
			Router::przekierujDo(Router::urlAdmin($this->kategoria, 'index'));
		}
        else
        {

        }
		$dane['form'] = $obiektFormularza->html();
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}

    public function wykonajZapiszPlik()
    {
        $token = Zadanie::pobierz('token', 'trim');
        $id = Zadanie::pobierz('id', 'trim', 'intval');

        $upload = new Plik\MultiUpload($token);
        $plik = $upload->zapiszPlik($id, 'zalaczniki');

        $return = $upload->pobierzWynikUploadu();

        if (!$wynikSkanowania = $plik->skanuj(true) && $return['success'] == true)
            $return['success'] = false;

        $return['wynikSkanowania'] = $wynikSkanowania;
        $katalog = new Katalog(TEMP_KATALOG . '/public/trash/' . $token, true);

        echo json_encode($return);
        die;
    }

    public function wykonajUsunPlik()
    {
        $ids = Zadanie::pobierz('ids', 'trim', 'strtolower');
        $token = Zadanie::pobierz('token', 'trim');

        $ids = explode(',', $ids);

        foreach ($ids as $key => $val) {
            if ($val < 1) unset($ids[$key]);
        }

        if (is_array($ids) && count($ids) > 0 && !empty($ids)) {
            $mapper = new Zalacznik\Mapper();

            $zalaczniki = $mapper->szukaj(array(
                'status' => 'active',
                'id' => $ids,
            ));

            foreach ($zalaczniki as $zalacznik) {
                $zalacznik->status = 'delete';
                $zalacznik->zapisz($mapper);
                unset($ids[$zalacznik->id]);
            }
            $result = multiuploadUsunPlikiTemp($ids, $token);
        } else {
            $result['success'] = true;
        }

        echo json_encode($result);
        die;
    }



}


