<?php
function trace_info($string)
{
    $hdl=fopen("log/info.log","a");
    if ($hdl!==false)
    {
        fwrite($hdl,$string);
        fclose($hdl);
    }
}
function trace_error($string)
{
    $hdl=fopen("log/error.log","a");
    if ($hdl!==false)
    {
        fwrite($hdl,$string);
        fclose($hdl);
    }
}
?>