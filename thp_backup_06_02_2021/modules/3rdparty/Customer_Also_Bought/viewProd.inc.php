<?php 

/*****************************************************************
*                           MOD INFO
****************************************************************
* Target     : CubeCart version 3.0.x
*              --------------------------------------------------
*
* File info  : CUstomers also bought v1.1 (c)206-2007 Milos Homola
*
* Author     : Milos Homola aka conVict
* Contact    : milos@cc3.biz
* Downloaded from : http://cc3.biz
*
* Special notes: Always backup your files!
* Author takes no responsibility for any damages (real or imagined)
* that occur as a result of using these modifications.
*
* Do not distribute this code in any manner without written approval
* by author! It is illegal to re-distribute this code freely or to
* resale the code without permission.
****************************************************************/


	$cab_config = fetchDbConfig("Customer_Also_Bought");
	if ($cab_config['status']==1) {

		function showIN ($query, $column){
			global $glob, $db;

			$result = $db->select($query);

			if ($result==TRUE){

					for ($i=0;$i<count($result);$i++) {	$resultIN .= "'".$result[$i][$column]."',";	}
					return substr($resultIN, 0, -1);

			} else {

				return 0;
			}
		}

		$prod_orders_query = "SELECT cart_order_id FROM ".$glob['dbprefix']."CubeCart_order_inv WHERE productId = ".$db->mySQLSafe($_GET['productId']);
		$prod_orders_numrows = $db->numrows($prod_orders_query);

		if ($prod_orders_numrows>0) {
			$cab_config['sqlver']=1;

			$cab_orders = showIN ("SELECT a.cart_order_id FROM ".$glob['dbprefix']."CubeCart_order_inv a, ".$glob['dbprefix']."CubeCart_order_sum b WHERE a.cart_order_id = b.cart_order_id AND (b.status = 2 OR b.status = 3) AND a.productId = ".$db->mySQLSafe($_GET['productId']),"cart_order_id");

			if ($cab_config['mode']==0) {

				$cab_whereIN = showIN ("SELECT customer_id FROM ".$glob['dbprefix']."CubeCart_order_sum WHERE cart_order_id IN (".$cab_orders.")","customer_id");
				$cab_where   = showIN ("SELECT cart_order_id FROM ".$glob['dbprefix']."CubeCart_order_sum WHERE customer_id IN (".$cab_whereIN.") AND (status = 2 OR status = 3)","cart_order_id");

			} else {
				$cab_where = $cab_orders;
			}

			$cab_query = "SELECT DISTINCT a.*, b.cat_name FROM ".$glob['dbprefix']."CubeCart_inventory a, ".$glob['dbprefix']."CubeCart_category b, ".$glob['dbprefix']."CubeCart_order_inv c WHERE a.cat_id = b.cat_id AND a.productId = c.productId AND ((a.stock_level>0 AND a.useStockLevel=1) OR a.useStockLevel=0) AND a.hidden!='yes' AND a.hidden_cat!='yes' AND c.cart_order_id IN (".$cab_where.")";

			$productResults = $db->select($cab_query);

			if ($productResults==true) {
				for ($i=0; $i<count($productResults); $i++) {if ($productResults[$i]['productId']==$prodArray[0]['productId']) {unset($productResults[$i]);};}
				sort($productResults);
			}

			if ($productResults[0]['productId']>0):

			if ($cab_config['random']==1) {mt_srand ((double) microtime() * 1000000); shuffle ($productResults);}

			$cab_max_prods = (count($productResults)>$cab_config['pmax']) ? $cab_config['pmax'] : count($productResults);

			for ($i=0; $i<$cab_max_prods; $i++){

				// alternate class for row
				$view_prod->assign("CLASS",cellColor($i, $tdEven="tdEven", $tdOdd="tdOdd"));
				$view_prod->assign("CPA_PRODID",$productResults[$i]['productId']);
				$view_prod->assign("CURR_URL",currentPage());

				// image
				if ($cab_config['pimage']==1) {
				  	if(file_exists($GLOBALS['rootDir']."/images/uploads/thumbs/thumb_".$productResults[$i]['image'])){
						$view_prod->assign("CPA_PRODIMAGE",$GLOBALS['rootRel']."images/uploads/thumbs/thumb_".$productResults[$i]['image']);
					} else {
						$view_prod->assign("CPA_PRODIMAGE",$GLOBALS['rootRel']."skins/".$config['skinDir']."/styleImages/thumb_nophoto.gif");
					}
					$view_prod->parse("view_prod.prod_also.repeat_prod.prod_image");
				}

				// name
				$view_prod->assign("CPA_PRODNAME", str_replace('\\','',validHTML($productResults[$i]['name'])));

				// description
				if ($cab_config['pdesc']==1) {
					$view_prod->assign("CPA_PROD_DESC", substr(strip_tags($productResults[$i]['description']),0,$config['productPrecis'])."&hellip;");
					$view_prod->parse("view_prod.prod_also.repeat_prod.prod_desc");
				}

				// price
				if ($cab_config['price']==1) {
					if(salePrice($productResults[$i]['price'], $productResults[$i]['sale_price'])==FALSE){
						$view_prod->assign("CPA_PRICE",priceFormat($productResults[$i]['price']));
					} else {
						$view_prod->assign("CPA_PRICE","<span class='txtOldPrice'>".priceFormat($productResults[$i]['price'])."</span>");
					}
					$salePrice = salePrice($productResults[$i]['price'], $productResults[$i]['sale_price']);
					$view_prod->assign("CPA_SALE_PRICE", priceFormat($salePrice));
					$view_prod->parse("view_prod.prod_also.repeat_prod.prod_price");
				}

				// category
				if ($cab_config['pcat']==1) {
				  	$view_prod->assign("CPA_PRODCAT", $productResults[$i]['cat_name']);
					$view_prod->parse("view_prod.prod_also.repeat_prod.prod_cat");
				}

				// buy button
				if ($cab_config['pbuy']==1) {
					if($config['outofstockPurchase']==1){
						$view_prod->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
						$view_prod->parse("view_prod.prod_also.repeat_prod.prod_buy.prod_buy2");
					} elseif($productResults[$i]['useStockLevel']==1 && $productResults[$i]['stock_level']>0){
						$view_prod->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
						$view_prod->parse("view_prod.prod_also.repeat_prod.prod_buy.prod_buy2");
					} elseif($productResults[$i]['useStockLevel']==0){
						$view_prod->assign("BTN_BUY",$lang['front']['viewCat']['buy']);
						$view_prod->parse("view_prod.prod_also.repeat_prod.prod_buy.prod_buy2");
					}

					$view_prod->parse("view_prod.prod_also.repeat_prod.prod_buy");
				}

				// more button
				if ($cab_config['pmore']==1) {
					$view_prod->assign("BTN_MORE",$lang['front']['viewCat']['more']);
					$view_prod->parse("view_prod.prod_also.repeat_prod.prod_more");
				}

				$view_prod->parse("view_prod.prod_also.repeat_prod");
			}
			$view_prod->assign("CPA_TXT",sprintf($lang['front']['viewProd']['customer_also_bought'], str_replace('\\','',validHTML($prodArray[0]['name']))));
			$view_prod->parse("view_prod.prod_also");

			endif;
		}
	}
?>
