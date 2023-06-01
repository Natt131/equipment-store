<?php


$depth = 1;
print_r(getList($depth));  


function getList($depth)  
{
    $lists = getDepth($depth);
    return $lists; 
 }

function getUrl($request_url)
{
    $countValid = 0;
    $brokenCount =0;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // We want to get the respone
    $result = curl_exec($ch);
    $regex = '|<a.*?href="(.*?)"|';
    preg_match_all($regex, $result, $parts);
    $links = $parts[1];
    $lists = array();
    foreach ($links as $link)
    {
        $url = htmlentities($link);
        $result =getFlag($url);
        if($result == true)
        {
            $UrlLists["clean"][$countValid] =$url;
            $countValid++; 
        } 
        else
        {
            $UrlLists["broken"][$brokenCount]= "broken->".$url;
            $brokenCount++;
        }  

    }
    curl_close($ch);
    return $UrlLists;
}
function ZeroDepth($list)
{
    $request_url = $list;
    $listss["0"]["0"] = getUrl($request_url);
    $lists["0"]["0"]["clean"] = array_unique($listss["0"]["0"]["clean"]);
    $lists["0"]["0"]["broken"] = array_unique($listss["0"]["0"]["broken"]);
    return $lists; 
}

function getDepth($depth)
{        
   // $list =OW_URL_HOME;
    $list = "https://mirolia.by/";//enter the url of website
    $lists =ZeroDepth($list);
    for($i=1;$i<=$depth;$i++)
    {
        $l= $i;
        $l= $l-1;
        $depthArray=1;
        foreach($lists[$l][$l]["clean"] as $depthUrl)
        { 
            $request_url = $depthUrl;
            $lists[$i][$depthArray]["requst_url"]=$request_url;
            $lists[$i][$depthArray] = getUrl($request_url);

        }  

    }
    return $lists;   
}

function getFlag($url) 
{
    $url_response = array();
    $curl = curl_init();
    $curl_options = array();
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_URL] = $url;
    $curl_options[CURLOPT_NOBODY] = true;
    $curl_options[CURLOPT_TIMEOUT] = 60;
    curl_setopt_array($curl, $curl_options);
    curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($status == 200) 
    { 
        return true;
    } 
    else 
    {
        return false;
    }
    curl_close($curl);
}