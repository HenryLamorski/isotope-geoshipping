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
 * Attributes
 */
\Isotope\Model\Shipping::registerModelType('geoShipping', 'Isotope\Model\Shipping\GeoShipping');
