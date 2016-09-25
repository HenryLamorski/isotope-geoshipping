<?php
/**
 * GeoShipping extension for Isotope eCommerce provides an shipping-method that calculates the shippingprice based on kilometers between shop-postalcode and shipping-postalcode
 *
 * Copyright (c) 2016 Henry Lamorski
 *
 * @package GeoShipping
 * @author  Henry Lamorski <henry.lamorski@mailbox.org>
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_iso_shipping']['palettes']['geoShipping'] = str_replace
(
'{note_legend:hide},note;',
'{note_legend:hide},note;{geoshipping_legend:hide},gs_minprice,gs_maxprice,gs_postalcodes;',
$GLOBALS['TL_DCA']['tl_iso_shipping']['palettes']['flat']
);


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_iso_shipping']['fields']['gs_minprice'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_minprice'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('maxlength'=>13, 'rgxp'=>'price', 'tl_class'=>'w50'),
    'sql'                   => "decimal(12,2) NOT NULL default '0.00'",
);

$GLOBALS['TL_DCA']['tl_iso_shipping']['fields']['gs_maxprice'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_maxprice'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('maxlength'=>13, 'rgxp'=>'price', 'tl_class'=>'w50'),
    'sql'                   => "decimal(12,2) NOT NULL default '0.00'",
);

$GLOBALS['TL_DCA']['tl_iso_shipping']['fields']['gs_postalcodes'] = array
(
	'label'            => &$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_postalcodes'],
    'exclude'               => true,
    'inputType'             => 'textarea',
    'eval'                  => array('style'=>'height:40px', 'tl_class'=>'clr'),
    'sql'                   => "text NULL",
);

$GLOBALS['TL_DCA']['tl_iso_shipping']['fields']['price']['label'] = &$GLOBALS['TL_LANG']['tl_iso_shipping']['price'];
