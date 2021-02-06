<?php
if(isset($_REQUEST['special']) && $_REQUEST['special'] == '1')
{

    if($_REQUEST['banner_content'] == '' || $_REQUEST['impression_content'] == '' 
       || $_REQUEST['clickurl'] == '') return;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_REQUEST['banner_content']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($ch);

    $errorNumber = curl_errno($ch);
    if($content == '' || $errorNumber != 0)
    {
        $errorMsg = 'Error: '.curl_error($ch);
        echo $errorMsg;
        return;
    }

    curl_close($ch);

    $impression_content = "<IMG SRC='".urldecode($_REQUEST['impression_content'])."' WIDTH=1 HEIGHT=1 BORDER=0>";
    
    $content = str_replace('$IMPRESSIONURL', $impression_content, $content);
    $content = str_replace('$CLICKURL', $_REQUEST['clickurl'], $content);

    echo $content;
}
else
{
?>
<html>
<head>
<title>Banner</title>
</head>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<?php
echo stripslashes(urldecode($_REQUEST['banner_content']));
?>
<IMG SRC='<?php echo urldecode($_REQUEST['impression_content'])?>' WIDTH=1 HEIGHT=1 BORDER=0>
</body>
</html>
<?php
}
?>
