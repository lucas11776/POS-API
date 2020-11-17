<?php


namespace Tests\Tools;


trait Params
{
    public function urlParams(array $parameters = []): string
    {
        $params = '';
        $paramsKeys = array_keys($parameters);
        $paramsValues = array_values($parameters);
        for($i = 0; $i < count($parameters); $i++) {
            if($i == 0) $params .= '?';
            else $params .= '&';
            $params .= $paramsKeys[$i] . '=' . $paramsValues[$i];
        }
        return $params;
    }
}
