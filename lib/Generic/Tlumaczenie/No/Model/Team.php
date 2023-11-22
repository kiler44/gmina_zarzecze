<?php
namespace Generic\Tlumaczenie\No\Model;

use Generic\Tlumaczenie\Tlumaczenie;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
class Team extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
			'teamNumber.etykieta' => 'Lagets navn',
			'teamNumber.opis' => '',
			
			'status.etykieta' => 'Status',
		
			'numberPlate.etykieta' => 'Nummerskilt',
			'numberPlate.opis' => 'Bil nummerskilt',
		
			'email.etykieta' => 'Email',
			'email.opis' => '',
		
			'idUsers.etykieta' => 'Arbeidere',
			'idUsers.opis' => '',
			'idLeader.etykieta' => 'Teamleder',
			'idLeader.opis' => '',
		);
}
?>
