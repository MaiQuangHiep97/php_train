<?php
class myURL
{
    public function addParams($key, $value)
    {
        $controller = new Controller();
        $parsed = parse_url($controller->getCurrentPageURL());
        if (isset($parsed['query'])) {
            $query = $parsed['query'];
            parse_str($query, $params);
            if (in_array($key, $params)) {
                unset($params[$key]);
            }
            $params[$key] = $value;
            $string = http_build_query($params);
            $query_new = $parsed['path'].'?'.$string;
        } else {
            $parsed['query'] = $key.'='.$value;
            $query_new = $parsed['path'].'?'.$parsed['query'];
        }
        return $query_new;
    }
}
