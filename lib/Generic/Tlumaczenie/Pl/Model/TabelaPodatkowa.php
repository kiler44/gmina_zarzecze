<?php
namespace Generic\Tlumaczenie\Pl\Model;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['id.etykieta']
 * @property string $t['id.opis']
 * @property string $t['idProjektu.etykieta']
 * @property string $t['idProjektu.opis']
 * @property string $t['nrTabeli.etykieta']
 * @property string $t['nrTabeli.opis']
 * @property string $t['rok.etykieta']
 * @property string $t['rok.opis']
 * @property string $t['kwotaOd.etykieta']
 * @property string $t['kwotaOd.opis']
 * @property string $t['kwotaDo.etykieta']
 * @property string $t['kwotaDo.opis']
 * @property string $t['podatek.etykieta']
 * @property string $t['podatek.opis']
 * @property string $t['rodzaj.etykieta']
 * @property string $t['rodzaj.opis']
 * @property array $t['rodzaj']
 */
class ModulTabelaPodatkowa extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
		'id.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'id.opis' => '',//TODO: Podaj tłumaczenie opisu

		'idProjektu.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'idProjektu.opis' => '',//TODO: Podaj tłumaczenie opisu

		'nrTabeli.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'nrTabeli.opis' => '',//TODO: Podaj tłumaczenie opisu

		'rok.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'rok.opis' => '',//TODO: Podaj tłumaczenie opisu

		'kwotaOd.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'kwotaOd.opis' => '',//TODO: Podaj tłumaczenie opisu

		'kwotaDo.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'kwotaDo.opis' => '',//TODO: Podaj tłumaczenie opisu

		'podatek.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'podatek.opis' => '',//TODO: Podaj tłumaczenie opisu

		'rodzaj.etykieta' => '',//TODO: Podaj tłumaczenie etykiety
		'rodzaj.opis' => '',//TODO: Podaj tłumaczenie opisu
		'rodzaj.wartosci' => array(
			'kwotowy' => '',//TODO: Podaj tłumaczenie wartości
			'procentowy' => '',//TODO: Podaj tłumaczenie wartości
		),

	);
}