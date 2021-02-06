<center>
<?php if($this->redirect_modul != '' ) { ?>
    <script>
        window.opener.document.location.href="index.php?md=<?php echo $this->redirect_modul?>&<?php echo SID?>";
        window.close();
    </script>
<?php } else { ?>
    <script>
        window.close();
    </script>
<?php } ?>
</center>
