<?php

function _writefile($hdl,$string)
{
    if ($hdl!==false)
    {
        fwrite($hdl,date('Y/m/d H:i:s')." ");
        fwrite($hdl,$string);
        fwrite($hdl,"\n");
        fclose($hdl);
    }
}

function trace_info($string)
{
    $hdl=fopen("log/info.log","a");
    _writefile($hdl,$string);
}

function trace_error($string)
{
    $hdl=fopen("log/error.log","a");
    _writefile($hdl,$string);
}
?>