/*-----------------------------------------------------------------------------
 * Javascript Functions
 *-----------------------------------------------------------------------------
 * stock_levels.js
 *-----------------------------------------------------------------------------
 * Author:   Estelle Winterflood
 * Email:    cubecart@expandingbrain.com
 * Store:    http://cubecart.expandingbrain.com
 *
 * Date:     October 31, 2006
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

// These functions should already be included from estelles_mod_store.js
//function ale(f){var old = window.onload;if (typeof window.onload != 'function') {window.onload = f;} else {window.onload = function() {old();f();}}}function st(e,t){if(e) {e.innerText = t;e.textContent = t;}}function gv(o){var a = [];for(var i=0; i<o.length; ++i) {for(var j=0; o[i] && j<o[i].length; ++j) {if (o[i][j].options)a.push(o[i][j].options[o[i][j].selectedIndex].value);else if (o[i][j].checked)a.push(o[i][j].value);else if (o[i][j].length) {for(var k=0; o[i][j] && k<o[i][j].length; ++k) {if (o[i][j][k].options)a.push(o[i][j][k].options[o[i][j][k].selectedIndex].value);else if (o[i][j][k].checked)a.push(o[i][j][k].value);}}}}return a;}

function sh(e,h){if(e) { e.innerHTML = h;e.htmlContent = h; }}

// Safe guard - prevent javascript errors from incorrect installation
function checkInstallation(showAlert)
{
    if (typeof showAlert == 'undefined')
        var showAlert = false;

    if (typeof sl_elements == 'undefined'
            || typeof sl_validAssignIds == 'undefined'
            || typeof sl_stockInfo == 'undefined'
            // product settings
            || typeof sl_prodCode == 'undefined'
            || typeof sl_totalStock == 'undefined'
            || typeof sl_useStock == 'undefined'
            // store general settings
            || typeof sl_showStockLevel == 'undefined'
            || typeof sl_allowOutOfStock == 'undefined'
            // module settings/language strings
            || typeof sl_appendCode == 'undefined'
            || typeof sl_appendChar == 'undefined'
            || typeof sl_langInStock == 'undefined'
            || typeof sl_langOutOfStock == 'undefined'
            || typeof sl_langVariantOutOfStock == 'undefined'
            || typeof sl_langVariantNotAvail == 'undefined'
            || typeof sl_langOutOfStockAlert == 'undefined'
            || typeof sl_langNotAvailAlert == 'undefined') {
        // if these javascript variables are not set -- indicates installation error!
        if (showAlert) alert("Please make a note of the following message and contact the store owner...\nthen continue your shopping!\n\nStock Levels for Product Options has not been installed correctly, make sure all new files are uploaded successfully then carefully check:\n- styleTemplates/content/viewProd.tpl\n- includes/content/viewProd.inc.php");
        return false;
    }
    return true;
}

function getIndex(assignIds)
{
    var index = '';
    for (var i=0; i<sl_validAssignIds.length; ++i) {
        for (var j=0; j<assignIds.length; ++j) {
            if (sl_validAssignIds[i] == assignIds[j]) {
                if (index.length > 0) index += ',';
                index += sl_validAssignIds[i];
            }
        }
    }
    return index;
}

function updateStockLevel()
{
    if (!checkInstallation()) {
        return;
    }

    var assignIds = [];
    var stockString = '';
    var outStockString = '';
    var prodCode = '';
    var a = gv(sl_elements);
    var incompleteSelection = false;

    for (var i=0; i<a.length; ++i) {
        // compatibility with "Force Selection of Product Options"
        if (a[i].charAt(0)=='0') {
            a.length = 0;
            incompleteSelection = true;
        }
    }

    var index = getIndex(a);
    var stockLevel = -1;

    if (sl_stockInfo[index] != undefined) {
        prodCode   = sl_stockInfo[index][1];
        stockLevel = sl_stockInfo[index][0];
    } else if(index == '') {
        stockLevel = sl_totalStock;
    }
    if (sl_useStock) {
        if (incompleteSelection) {
            // compatibility with "Force Selection of Product Options"
            stockString = outStockString = '';
        } else if (sl_totalStock <= 0) {
            // product entirely sold out
            stockString = '';
            outStockString = sl_langOutOfStock;
        } else if (stockLevel > 0) {
            // this product variant is in stock
            stockString = sl_langInStock;
            if (sl_showStockLevel) stockString += ': ' + stockLevel;
            outStockString = '';
        } else if (stockLevel == 0) {
            // this product variant is sold out
            stockString = '';
            outStockString = sl_langVariantOutOfStock;
        } else {
            // this product variant is not available
            stockString = '';
            outStockString = sl_langVariantNotAvail;
        }
    }

    var inStockSpan    = document.getElementById('inStock');
    var outOfStockSpan = document.getElementById('outOfStock');
    var prodCodeSpan   = document.getElementById('prodCode');

    sh(inStockSpan, stockString);
    sh(outOfStockSpan, outStockString);

    if (prodCode != '' && sl_appendCode) {
        st(prodCodeSpan, sl_prodCode+sl_appendChar+prodCode);
    } else if (prodCode != '' && !sl_appendCode) {
        st(prodCodeSpan, prodCode);
    } else {
        st(prodCodeSpan, sl_prodCode);
    }
}

function checkStock()
{
    if (!checkInstallation(true)) {
        return true;
    }

    if (!sl_useStock) {
        // this product ignores stock levels entirely
        return true;
    }

    var a = gv(sl_elements);
    var index = getIndex(a);
    var stockLevel = -1;

    if (sl_stockInfo[index] != undefined) {
        stockLevel = sl_stockInfo[index][0];
    } else if (index == '') {
        stockLevel = sl_totalStock;
    }

    if (stockLevel > 0) {
        // in stock
        return true;
    } else if (stockLevel == 0 && sl_allowOutOfStock) {
        // out of stock, out of stock purchases ARE permitted
        return true;
    } else if (stockLevel == 0 && !sl_allowOutOfStock) {
        // out of stock, out of stock purchases NOT permitted
        alert(sl_langOutOfStockAlert);
        return false;
    } else {
        // this size/colour/etc marked as "never available"
        alert(sl_langNotAvailAlert);
        return false;
    }
}

