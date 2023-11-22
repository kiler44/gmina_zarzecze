<?php
namespace Generic\Konfiguracja\Modul\PlikiPubliczne;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['index.akceptowane_rozszerzenia']
 * @property bool $k['index.podglad_obrazkow']
 * @property string $k['index.szablon_managera']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.akceptowane_rozszerzenia' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'obrazy' => 'yuv, bmp, gif, jpg, png, psd, psp, pspimage, thm, tif, ai, drw, eps, ps, svg, 3dm, pln',
			'flash' => 'swf, flv',
			'dokumenty' => 'doc, docx, log, msg, pages, rtf, txt, wpd, wps, odf, odt',
			'audio' => 'aac, aif, iff, mp3, mpa, ra, wav, wma',
			'wideo' => '3g2, 3gp, asf, asx, avi, flv, mov, mp4, mpg, rm, swf, vob, wmv, rmvb',
			'archiwa' => '7z, deb, gz, pkg, rar, sit, sitx, tar.gz, zip, zipx',
			),
		),

	'index.podglad_obrazkow' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'index.szablon_managera' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'szablon_manager_plikow.tpl',
		),

	);
}
