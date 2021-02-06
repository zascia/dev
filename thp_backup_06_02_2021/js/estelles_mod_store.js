/*-----------------------------------------------------------------------------
 * Javascript Functions
 *-----------------------------------------------------------------------------
 * estelles_mod_store.js
 *-----------------------------------------------------------------------------
 * Author:   Estelle Winterflood
 * Email:    cubecart@expandingbrain.com
 * Support:  http://support.expandingbrain.com
 * Store:    http://cubecart.expandingbrain.com
 *
 * Date:     October 31, 2006
 * Updated:  December 6, 2006
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

function ale(f){var old = window.onload;if (typeof window.onload != 'function') {window.onload = f;} else {window.onload = function() {old();f();}}}function st(e,t){if(e) {e.innerText = t;e.textContent = t;}}function gv(o){var a = [];for(var i=0; i<o.length; ++i) {for(var j=0; o[i] && j<o[i].length; ++j) {if (o[i][j].options)a.push(o[i][j].options[o[i][j].selectedIndex].value);else if (o[i][j].checked)a.push(o[i][j].value);else if (o[i][j].length) {for(var k=0; o[i][j] && k<o[i][j].length; ++k) {if (o[i][j][k].options)a.push(o[i][j][k].options[o[i][j][k].selectedIndex].value);else if (o[i][j][k].checked)a.push(o[i][j][k].value);}}}}return a;}
