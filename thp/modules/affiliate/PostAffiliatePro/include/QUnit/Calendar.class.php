<?php

class QUnit_Calendar 
{ 
    var 
        $daynamefont,$daynamebgcolor,$daynamecolor,$daynamesize,$daynamebold,$daynameitalic, 
        $dayfont,$daybgcolor,$daycolor,$dayactivecolor,$daysize,$daybold,$dayitalic,$showdate,
        $bordersize,$showtimerange, $selectedMonth, $selectedYear, $selectedDay, $errorMessages,
        $inputProcessed;
     
    //------------------------------------------------------------------------
    
    function &getInstance() {
        static $instance;
        if(!is_object($instance)) {
            $instance = new QUnit_Calendar;
        }
        return $instance;
    }
    
    //------------------------------------------------------------------------
    
    function QUnit_Calendar() { 
        if(empty($this->daynamefont)==true) $this->daynamefont="Arial, sans-serif"; 
        if(empty($this->daynamebgcolor)==true) $this->daynamebgcolor="#000060"; 
        if(empty($this->daynamecolor)==true) $this->daynamecolor="#FFFFFF"; 
        if(empty($this->daynamesize)==true) $this->daynamesize="3"; 
        if(empty($this->daynamebold)==true) $this->daynamebold=true; 
        if(empty($this->daynameitalic)==true) $this->daynameitalic=false; 
        if(empty($this->dayfont)==true) $this->dayfont="Arial, sans-serif"; 
        if(empty($this->daybgcolor)==true) $this->daybgcolor="#FFCA00"; 
        if(empty($this->daycolor)==true) $this->daycolor="#000000"; 
        if(empty($this->dayactivecolor)==true) $this->dayactivecolor="#FF0000"; 
        if(empty($this->daysize)==true) $this->daysize="3"; 
        if(empty($this->daybold)==true) $this->daybold=true; 
        if(empty($this->dayitalic)==true) $this->dayitalic=false; 
        if(empty($this->showdate)==true) $this->showdate=true; 
        if(empty($this->bordersize)==true) $this->bordersize="2"; 
        if(empty($this->showtimerange)==true) $this->showtimerange = true;
        $this->inputProcessed = false;
        
        $this->loadSelectedDate();
    } 
    
    //------------------------------------------------------------------------
    
    function draw() { 
        $this->processInput();
        
        $this->drawErrorMessages();
        $this->drawCalendar();
        if($this->showtimerange) $this->drawTimerange();
    } 
    
    //------------------------------------------------------------------------
    
    function drawCalendar() {
        
        $day = $this->selectedDay;
        $month = $this->selectedMonth;
        $year = $this->selectedYear;
        
        if($this->daynamebold==true) { 
            $daynametextprefix="<b>"; 
            $daynametextsuffix="</b>"; 
        }
        
        if($this->daynameitalic==true) { 
            $daynametextprefix.="<i>"; 
            $daynametextsuffix="</i>".$daynametextsuffix; 
        }
        
        if($this->daybold==true) { 
            $daytextprefix="<b>"; 
            $daytextsuffix="</b>"; 
        }
        
        if($this->dayitalic==true) { 
            $daytextprefix.="<i>"; 
            $daytextsuffix="</i>".$daytextsuffix; 
        }
        
        if(checkdate($month,$day,$year)==true) { 
            $maxdays=31; 
            
            while(checkdate($month,$maxdays,$year)==false) {
                $maxdays--;
            }
            
            $startday=1-date("w",mktime(0,0,0,$month,1,$year));
            
            print("<table border='".$this->bordersize."' cellspacing='0' cellpadding='0' align='center'>".
                  "<tr bgcolor='".$this->daybgcolor."'><td>\n"); 
            print("  <table border='0' cellspacing='0' cellpadding='1'>\n");
            
            if($this->showdate==true) {
                print("    <tr bgcolor='".$this->daynamebgcolor."'>".
                      "      <td align=left><a href=\"?cal_year=-1\">< </a></td>".
                      "      <td colspan='5'>".
                      "          <font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'><div align='center'>".
                      "             ".$daynametextprefix.($this->showtimerange ? '<a href="?timerange_set_tr=year&timerange_value='.$year.'">' : '').$year.($this->showtimerange ? '</a>' : '').
                      "          </div></font></td>".
                      "    <td align=right><a href=\"?cal_year=1\">> </a></td>".
                      "    </tr>\n");
                print("    <tr bgcolor='".$this->daynamebgcolor."'>".
                      "      <td align=left><a href=\"?cal_month=-1\">< </a></td>".
                      "      <td colspan='5'>".
                      "          <font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'><div align='center'>".
                      "             ".$daynametextprefix.($this->showtimerange ? '<a href="?timerange_set_tr=month&timerange_value='.$month.'">' : '').date("F",mktime(0,0,0,$month,$day,$year)).($this->showtimerange ? '</a>' : '').$daynametextsuffix.
                      "          </div></font></td>".
                      "    <td align=right><a href=\"?cal_month=1\">> </a></td>".
                      "    </tr>\n");
            }
            
            print("    <tr bgcolor='".$this->daynamebgcolor."'><td align='center'><font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'>".$daynametextprefix." Sun ".$daynametextsuffix."</font></td><td align='center'><font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'>".$daynametextprefix." Mon ".$daynametextsuffix."</font></td><td align='center'><font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'>".$daynametextprefix." Tue ".$daynametextsuffix."</font></td><td align='center'><font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'>".$daynametextprefix." Wed ".$daynametextsuffix."</font></td><td align='center'><font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'>".$daynametextprefix." Thu ".$daynametextsuffix."</font></td><td align='center'><font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'>".$daynametextprefix." Fri ".$daynametextsuffix."</font></td><td align='center'><font face='".$this->daynamefont."' color='".$this->daynamecolor."' size='".$this->daynamesize."'>".$daynametextprefix." Sat ".$daynametextsuffix."</font></td>"); 
            $weekdaycount=0; 
            
            for($daycount=$startday;$daycount<=$maxdays;$daycount++) { 
                if(($weekdaycount%7)==0) {
                    print("</tr>\n    <tr bgcolor='".$this->daybgcolor."'>");
                }
                
                if($daycount>0) { 
                    print("<td align='right'>");
                    
                    if($daycount!=$day || !$this->showtimerange) { 
                        print("<font face='".$this->dayfont."' color='".$this->daycolor."' size='".$this->daysize."'>".$daytextprefix." ".
                              ($this->showtimerange ? '<a href="?timerange_set_tr=day&timerange_value='.$daycount.'">' : '').$daycount.($this->showtimerange ? '</a>' : '').
                              " ".$daytextsuffix."</font>"); 
                    } else {
                        print("<font face='".$this->dayfont."' color='".$this->dayactivecolor."' size='".$this->daysize."'>".$daytextprefix." ".
                              ($this->showtimerange ? '<a href="?timerange_set_tr=day&timerange_value='.$daycount.'">' : '').$daycount.($this->showtimerange ? '</a>' : '').
                              " ".$daytextsuffix."</font>");
                    }
                } else {
                    print("<td>");
                }
                
                print("</td>"); 
                $weekdaycount++; 
            } 
            
            while($weekdaycount%7<>0) { 
                print("<td></td>"); 
                $weekdaycount++; 
            } 
            
            print("</tr>\n  </table>\n"); 
            print("</td></tr></table>\n"); 
        } else {
            print("Incorrect date");
        }
    }
    
    //------------------------------------------------------------------------
    
    function drawTimerange() {
        $timerangeStart = $this->getTimeRangeStart();
        $timerangeEnd = $this->getTimeRangeEnd();
        ?>
            <br><hr width='90%'>
            <form action="index.php" method="POST">
            <input type="hidden" name="timerange_comitted" value="1">
            <table cellpadding="0" cellspacing="0" width="90%">
            <tr><td colspan="4" align="center"><?php echo L_G_TIMERANGE?></td></tr>
            <tr><td><?php echo L_G_FROM?>&nbsp;</td>
                <td><select name="timerange_start_day">
                    <?php for($i=1; $i<=31; $i++) { ?>
                        <option value="<?php echo $i?>" <?php echo ($i == $timerangeStart['day']) ? 'selected' : ''?>><?php echo $i?></option>
                    <?php } ?>
                    </select></td>
                <td><select name="timerange_start_month">
                    <?php for($i=1; $i<=12; $i++) { ?>
                        <option value="<?php echo $i?>" <?php echo ($i == $timerangeStart['month']) ? 'selected' : ''?>><?php echo $i?></option>
                    <?php } ?>
                    </select></td>
                <td><select name="timerange_start_year">
                    <?php for($i=date("Y") - 5; $i <= date("Y") + 5; $i++) { ?>
                        <option value="<?php echo $i?>" <?php echo ($i == $timerangeStart['year']) ? 'selected' : ''?>><?php echo $i?></option>
                    <?php } ?>
                    </select></td>
            </tr>
            <tr><td><?php echo L_G_TO?>&nbsp;</td>
                <td><select name="timerange_end_day">
                    <?php for($i=1; $i<=31; $i++) { ?>
                        <option value="<?php echo $i?>" <?php echo ($i == $timerangeEnd['day']) ? 'selected' : ''?>><?php echo $i?></option>
                    <?php } ?>
                    </select></td>
                <td><select name="timerange_end_month">
                    <?php for($i=1; $i<=12; $i++) { ?>
                        <option value="<?php echo $i?>" <?php echo ($i == $timerangeEnd['month']) ? 'selected' : ''?>><?php echo $i?></option>
                    <?php } ?>
                    </select></td>
                <td><select name="timerange_end_year">
                    <?php for($i=date("Y") - 5; $i <= date("Y") + 5; $i++) { ?>
                        <option value="<?php echo $i?>" <?php echo ($i == $timerangeEnd['year']) ? 'selected' : ''?>><?php echo $i?></option>
                    <?php } ?>
                    </select></td>
            </tr>
            <tr><td colspan="4" align="right"><input type="submit" value="<?php echo L_G_SUBMIT?>"></td></tr>
            </table>
            </form>
        <?php
    }
    
    //------------------------------------------------------------------------
    
    function processInput() {
        if($this->inputProcessed) {
            return;
        }
 
        if (!empty($_REQUEST['cal_year'])) {
            $this->selectedYear += $_REQUEST['cal_year'];
        }
        
        if (!empty($_REQUEST['cal_month'])) {
            $this->selectedMonth += $_REQUEST['cal_month'];
            $this->selectedMonth--;
            if ($this->selectedMonth < 0) {
                while ($this->selectedMonth < 0) { 
                    $this->selectedMonth += 12;
                    $this->selectedYear--;
                }
            } else {
                $this->selectedYear += floor($this->selectedMonth / 12);
                $this->selectedMonth %= 12;
            }
            
            $this->selectedMonth++;
        }
        
        if ($_REQUEST['timerange_comitted'] == '1') {
            if (!checkdate($_POST['timerange_start_month'], $_POST['timerange_start_day'], $_POST['timerange_start_year'])) {
                $this->setErrorMessage(L_G_FROM.' '.L_G_DATE.' '.L_G_NOTVALID);
            }
            
            if (!checkdate($_POST['timerange_end_month'], $_POST['timerange_end_day'], $_POST['timerange_end_year'])) {
                $this->setErrorMessage(L_G_TO.' '.L_G_DATE.' '.L_G_NOTVALID);
            }
            
            if (mktime(0,0,0, $_POST['timerange_start_month'], $_POST['timerange_start_day'], $_POST['timerange_start_year']) > mktime(0,0,0, $_POST['timerange_end_month'], $_POST['timerange_end_day'], $_POST['timerange_end_year'])) {
                $this->setErrorMessage(L_G_TODATELOWERTHANFROMDATE);
            }
            
            if ($this->getErrorMessages() == '') {
                $this->setTimerangeStart($_POST['timerange_start_day'], $_POST['timerange_start_month'], $_POST['timerange_start_year']);
                $this->setTimerangeEnd($_POST['timerange_end_day'], $_POST['timerange_end_month'], $_POST['timerange_end_year']);
            }
        }
        
        if (isset($_REQUEST['timerange_set_tr'])) {
            switch($_REQUEST['timerange_set_tr']) {
                case 'day'   :  $this->setTimerangeDay($_REQUEST['timerange_value']);
                                break;
                case 'month' :  $this->setTimerangeMonth($_REQUEST['timerange_value']);
                                break;
                case 'year'  :  $this->setTimerangeYear($_REQUEST['timerange_value']);
                                break;
            }
        }
        
        $this->saveSelectedDate();
        $this->inputProcessed = true;
    }
    
    //------------------------------------------------------------------------
    
    function setTimerangeStart($day, $month, $year) {
        $_SESSION['timerange_start_day'] = $day;
        $_SESSION['timerange_start_month'] = $month;
        $_SESSION['timerange_start_year'] = $year;
    }
    
    //------------------------------------------------------------------------
    
    function setTimerangeEnd($day, $month, $year) {
        $_SESSION['timerange_end_day'] = $day;
        $_SESSION['timerange_end_month'] = $month;
        $_SESSION['timerange_end_year'] = $year;
    }
    
    //------------------------------------------------------------------------
    
    function setTimerangeDay($day) {
        $this->setTimerangeStart($day, $this->selectedMonth, $this->selectedYear);
        $this->setTimerangeEnd($day, $this->selectedMonth, $this->selectedYear);
    }
    
    //------------------------------------------------------------------------
    
    function setTimerangeMonth($month) {
        $this->setTimerangeStart(1, $month, $this->selectedYear);
        $this->setTimerangeEnd(date("t",mktime(0,0,0,$month,1,$this->selectedYear)), $month, $this->selectedYear);
    }
    
    //------------------------------------------------------------------------
    
    function setTimerangeYear($year) {
        $this->setTimerangeStart(1, 1, $year);
        $this->setTimerangeEnd(31, 12, $year);
    }
    
    //------------------------------------------------------------------------
    
    function getTimeRangeStart() {
        return array("day"   => $_SESSION['timerange_start_day'],
                     "month" => $_SESSION['timerange_start_month'],
                     "year"  => $_SESSION['timerange_start_year']);
    }
    
    //------------------------------------------------------------------------
    
    function getTimeRangeEnd() {
        return array("day"   => $_SESSION['timerange_end_day'],
                     "month" => $_SESSION['timerange_end_month'],
                     "year"  => $_SESSION['timerange_end_year']);
    }
    
    //------------------------------------------------------------------------
    
    function loadSelectedDate() {
        if(!empty($_SESSION['cal_selected_day'])) $this->selectedDay = $_SESSION['cal_selected_day'];
        if(!empty($_SESSION['cal_selected_month'])) $this->selectedMonth = $_SESSION['cal_selected_month'];
        if(!empty($_SESSION['cal_selected_year'])) $this->selectedYear = $_SESSION['cal_selected_year'];
        if(empty($this->selectedMonth)==true) $this->selectedMonth = date("n");
        if(empty($this->selectedYear)==true) $this->selectedYear = date("Y");
        if(empty($this->selectedDay)==true) $this->selectedDay = date("j");
    }
    
    //------------------------------------------------------------------------
    
    function saveSelectedDate() {
        $_SESSION['cal_selected_day'] = $this->selectedDay;
        $_SESSION['cal_selected_month'] = $this->selectedMonth;
        $_SESSION['cal_selected_year'] = $this->selectedYear;
    }
    
    //------------------------------------------------------------------------
    
    function setErrorMessage($msg) {
        $this->errorMessages[] = $msg;
    }
    
    //------------------------------------------------------------------------
    
    function getErrorMessages() {
        return $this->errorMessages;
    }
    
    //------------------------------------------------------------------------
    
    function drawErrorMessages() {
        if(!is_array($this->errorMessages)) {
            return;
        }
        
        foreach ($this->errorMessages as $msg) {
            print($msg.'<br>');
        }
    }
} 
?>
