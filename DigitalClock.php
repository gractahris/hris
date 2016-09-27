<?php

/*
 * PHP-Digital Clock
 * @author Angelos Staboulis
 * @town Komotini
 * @country Greece
 */
class DigitalClock {
    /**Print Digital Clock**/
    function jsDigitalClock($left,$top){
                    $div1='"div1"';
                    $proc='"printTime()"';
                    //$style="margin-left:$left"."px;"."margin-top:$top"."px;margin-right:$width"."px;"."margin-bottom:$height"."px;";
                    echo "<div id=".$div1.">";
                    $retvalue="<script language=javascript>".
                           "var int=self.setInterval(".$proc.",1000);".   
                           "function printTime(){".
                           "var d=new Date();".
                           "var t=d.toLocaleTimeString();".
                           "document.getElementById(".$div1.").innerHTML=t;".
                           "}". 
                           "</script>";
                    echo $retvalue;
					// echo "Proc=>".$proc;
                    echo "</div>";     
    }
   
    /** Get Hours **/
    function getHours(){
      $hours=getdate();
      return $hours["hours"];
    }
    /** Get Minutes **/
    function getMinutes(){
      $minutes=getdate();
      return $minutes["minutes"];
        
    }
    /** Get Seconds **/
    function getSeconds(){
      $seconds=getdate();
      return $seconds["seconds"];
    }
	
	function getDateToday(){
      $getDateToday=getdate();
      return $getDateToday;
        
    }
	
	function getMonth(){
      $month=getdate();
      return $month["month"];
        
    }
	
	function getYear(){
      $year=getdate();
      return $year["year"];
        
    }
	
	function getDay(){
      $mday=getdate();
      return $mday["mday"];
        
    }
	
	function getMonthNo(){
      $mon=getdate();
      return $mon["mon"];
        
    }
	
	
}

?>
