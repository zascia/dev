<!-- BEGIN: session -->

<!-- BEGIN: session_false -->

	<span class="txtSessionGrey">{LANG_WELCOME_GUEST}</span> <span class="txtSession">[</span><a href="index.php?act=login&amp;redir={VAL_SELF}" rel="nofollow" class="txtSession">{LANG_LOGIN}</a> <span class="txtSession">|</span> <a href="cart.php?act=reg&amp;redir={VAL_SELF}"  rel="nofollow" class="txtSession">{LANG_REGISTER}</a><span class="txtSession">]</span>

<!-- END: session_false -->



<!-- BEGIN: session_true -->

	<span class="txtSessionGrey">{LANG_WELCOME_BACK} {TXT_USERNAME}</span> <span class="txtSession">[</span><a href="index.php?act=logout"  rel="nofollow" class="txtSession">{LANG_LOGOUT}</a> <span class="txtSession">|</span> <a href="index.php?act=account"  rel="nofollow" class="txtSession">{LANG_YOUR_ACCOUNT}</a><span class="txtSession">]</span>

<!-- END: session_true -->

<!-- BEGIN: session_express -->
	<span class="txtSession">[{LANG_WELCOME_BACK} {TXT_USERNAME} | </span><a href="cart.php?act=upgradeReg&amp;redir={VAL_SELF}"  rel="nofollow" class="txtSession">{LANG_REGISTER}</a> <span class="txtSession">]</span>
<!-- END: session_express -->
<!-- END: session -->
