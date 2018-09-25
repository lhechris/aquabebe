<?php
    function replacebadchar($str) {
        $str=str_replace("&amp;Acirc;&amp;deg;","°",$str);
        $str=str_replace("&amp;Atilde;&amp;uml;","è",$str);        
        $str=str_replace("&amp;Atilde;&amp;copy;","é",$str);        
        $str=str_replace("&amp;acirc;&amp;sbquo;&amp;not;","€",$str);        
        $str=str_replace("&amp;Atilde;&amp;nbsp;","à",$str);
        $str=str_replace("Ã¨","è",$str);
        $str=str_replace("Ã©","é",$str);
        $str=str_replace("Â°","°",$str);
        $str=str_replace("â‚¬","€",$str);
        $str=str_replace("&amp;amp;Atilde;&amp;amp;uml;","è",$str);
        $str=str_replace("&amp;amp;Atilde;&amp;amp;copy;","é",$str);
        $str=str_replace("&amp;amp;Acirc;&amp;amp;deg;","°",$str);
        $str=str_replace("&amp;amp;acirc;&amp;amp;sbquo;&amp;amp;not;","€",$str);
        $str=str_replace("&amp;amp;Atilde;&amp;amp;nbsp;","à",$str);
        $str=str_replace('\\\\\\',"",$str);
        //$str=str_replace("","",$str);
        return $str;
    }
?>