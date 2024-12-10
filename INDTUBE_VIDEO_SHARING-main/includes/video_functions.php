<?php


function getYouTubeVideoId($url)
{
    $parts = parse_url($url);

    if ($parts === false)
    {
        return false;
    }

    if (isset($parts['query'])) 
    {
        parse_str($parts['query'], $query);
        if (isset($query['v'])) 
        {
            $videoId=$query['v'];
            return $videoId;
        }
        else
        {
            $pathParts=explode('/', parse_url($url, PHP_URL_PATH));

            if ($pathParts !== false && isset($pathParts[1])) {
                return $pathParts[1];
            }
        }
    } 
    
    return false;
}

?>
