<?php
function trace_info($string)
{
    $hdl=fopen("./info.log","a");
    if ($hdl!==false)
    {
        fwrite($hdl,$string);
        fclose($hdl);
    }
}
?>