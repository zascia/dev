<?php  

/*-----------------------------------------------------------------------------
 * Stock Levels for Product Options
 *-----------------------------------------------------------------------------
 * stock_levels.cart1.inc.php
 *-----------------------------------------------------------------------------
 * Author:   Estelle Winterflood
 * Email:    cubecart@expandingbrain.com
 * Support:  http://support.expandingbrain.com
 * Store:    http://cubecart.expandingbrain.com
 *
 * Date:     October 22, 2006
 * For CubeCart Version:  3.0.x
 *-----------------------------------------------------------------------------
 * TERMS OF USE:
 * Under no circumstances can this software be sold, given to another person or
 * publically posted without prior written permission from Estelle Winterflood.
 *-----------------------------------------------------------------------------
 * DISCLAIMER:
 * The modification is provided on an "AS IS" basis, without warranty of
 * any kind, including without limitation the warranties of merchantability,
 * fitness for a particular purpose and non-infringement. The entire risk
 * as to the quality and performance of the Software is borne by you.
 * Should the modification prove defective, you and not the author assume 
 * the entire cost of any service and repair. 
 *-----------------------------------------------------------------------------
 */

// uses: $productId, $options
// sets up variables: $stock_level, $productCode
// may modify template variable: VAL_PRODUCT_CODE

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

$stock = new stock($db, $productId);
if ($stock && $stock->hasSelectedStockOptions())
{
	$stockInfo = $stock->getStockLevel($options);
	$stock_level = $stockInfo['stock_level'];
	if ($stock_level == "") {
		$stock_level = 0;
	}
	if (!empty($stockInfo['product_code'])) {
		if ($stock_mod['append_code']) {
			$productCode = $product[0]['productCode'].$stock_mod['append_char'].$stockInfo['product_code'];
		} else {
			$productCode = $stockInfo['product_code'];
		}
		$view_cart->assign("VAL_PRODUCT_CODE",$productCode);
	}
}
else
{
	$stock_level = $product[0]["stock_level"];
}

?>
