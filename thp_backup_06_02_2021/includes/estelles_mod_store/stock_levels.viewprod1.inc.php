<?php  

/*-----------------------------------------------------------------------------
 * Stock Levels for Product Options
 *-----------------------------------------------------------------------------
 * stock_levels.viewprod1.inc.php
 *-----------------------------------------------------------------------------
 * Author:   Estelle Winterflood
 * Email:    cubecart@expandingbrain.com
 * Store:    http://cubecart.expandingbrain.com
 *
 * Date:     October 27, 2006
 * Updated:  December 11, 2007
 * For CubeCart Version:  3.0.x
 *-----------------------------------------------------------------------------
 * SOFTWARE LICENSE AGREEMENT:
 * You must own a valid license for this modification to use it on your
 * CubeCart™ store. Licenses for this modification can be purchased from
 * Estelle Winterflood using the URL above. One license permits you to install
 * this modification on a single CubeCart installation only. This non-exclusive
 * license grants you certain rights to use the modification and is not an
 * agreement for sale of the modification or any portion of it. The
 * modification and accompanied documentation may not be sublicensed, sold,
 * leased, rented, lent, or given away to another person or entity. This
 * modification and accompanied documentation is the intellectual property of
 * Estelle Winterflood.
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

// uses: $_GET[productId]
// may set template variable: JS_VERIFY_STOCK

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

require_once("classes/stockopt.inc.php");
$stock = new stock($db, $_GET['productId']);

if ($stock->hasSelectedStockOptions()) {
	$view_prod->assign("JS_VERIFY_STOCK","if(checkStock()) ");
	$js = "function updateStockLevel() { return; }\nfunction checkStock() { return true; }";
	$js .= 'alert("Please make a note of the following message and contact the store owner...\n\nStock Levels for Product Options has not been installed correctly, make sure all new files are uploaded successfully then carefully check:\n- includes/content/viewProd.inc.php");';
	$js = "<script type=\"text/javascript\">\n<!--\n".$js."\n//-->\n</script>";
	$view_prod->assign('STOCKOPTION_SCRIPT',$js);
}

?>
