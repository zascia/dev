<!-- BEGIN: view_faqs -->
<div class="boxContent">
<p class="txtContentTitle">{TXT_CAT_TITLE}</p>
<!-- BEGIN: start_page -->
<img src="images/general/faq.jpg" alt="" style="float: right" />
<p>{TXT_START}</p>
<!-- END: start_page -->

<!-- BEGIN: sub_cats -->
<div>
	<ul>
	<!-- BEGIN: sub_cats_loop -->
	<li style="bullet"><a href="index.php?act=viewFAQs&amp;faqCatId={TXT_LINK_CATID}" class="txtDefault">{TXT_FAQ_CATEGORY}</a> ({NO_FAQS})</li>
	<!-- END: sub_cats_loop -->
	</ul>
</div>
<!-- END: sub_cats -->
<br clear="left" />
<div class="pagination">{PAGINATION}</div>
<!-- BEGIN: faqTable -->
<table border="0" width="100%" cellspacing="0" cellpadding="3">
  <!-- BEGIN: faqs -->
	<tr>
		<td valign="top" class="{CLASS}"><a href="index.php?act=viewFAQ&amp;faqId={FAQ_ID}" target="_self" class="txtDefault"><strong>{TXT_Q}</strong></a></td>
	</tr>
	<tr>
		<td valign="top" class="{CLASS}">{TXT_A}</td>
	</tr>
<!-- END: faqs -->
</table>
<!-- END: faqTable -->
<!-- BEGIN: no_faqs -->
<div style="border: 1px solid #E0ECF8; padding: 3px; margin-left: 20px; color: #990000"><img src="images/general/error.gif" alt="" /><br />{TXT_NO_FAQS}</div>
<!-- END: no_faqs -->
<div class="pagination">{PAGINATION}</div>
<br clear="all" />
<!-- BEGIN: back_nav_links -->
<p><a href="javascript:history.back()" class="txtDefault"><img src="images/general/previous.gif" alt="" border="0" />&laquo; Previous Page</a></p>
<!-- END: back_nav_links -->
<!-- BEGIN: faqHome_nav_links -->
<p><a href="index.php?act=viewFAQs" class="txtDefault"><img src="images/general/faq_home.jpg" alt="" border="0" />&laquo; FAQ Start Page</a></p>
<!-- END: faqHome_links -->
<!-- BEGIN: disabled -->
<div style="border: 1px solid #E0ECF8; padding: 3px; margin-left: 20px; color: #990000"><img src="images/general/error.gif" alt="" /><br />{DISABLED}</div>
<p><a href="javascript:history.back()" class="txtDefault"><img src="images/general/previous.gif" alt="" border="0" />&laquo; Back</a></p>
<!-- END: disabled -->
</div>
<!-- END: view_faqs -->