<?php

/*
 * Author   :   Sandeep Giri
 * Email    :   sandeep@nurakanbpo.com
 * Date     :   2014/05/15 4:31:03 PM
 * File     :   functions.php 
 * Project  :   ktm197
 * Copyright (c) Nurakan Technologies Pvt. Ltd.
 */

function latLonDistance($lat1, $lon1, $lat2, $lon2, $unit = "K")
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);
    if ($unit == "K")
    {
        return ($miles * 1.609344 * 1000);
    } else if ($unit == "N")
    {
        return ($miles * 0.8684);
    } else
    {
        return $miles;
    }
}

function getSocial($social, $name)
{
    if (strpos($name, 'www.' . $social . '.com'))
        return $name;
    else
        return 'https://' . $social . '.com/' . $name;
}

function getImage($dir, $name, $img, $type = 'gallery')
{
    if (strpos($img, 'http://'))
        return $img;
    if (strpos($img, 'https://'))
        return img;
    $file = $dir . '/uploads/' . $name . '/' . $type . '/' . $img;
    return $file;
}

function formatTime($data) {
    $data = str_replace('AM', '', $data);
    $data = str_replace('PM', '', $data);
    if (date('Y', strtotime($data)) == date('Y')) {
        if (date('Y/m', strtotime($data)) == date('Y/m')) {
            $time = date('Y/m/d', strtotime($data));
            $diff = (int) date('d') - (int) date('d', strtotime($time));
            $diff = (int) $diff;
            switch ($diff) {
                case 0:
                    $one = new DateTime(date('h:i:s'));
                    $two = new DateTime(date('h:i:s', strtotime($data)));
                    $diff = date_diff($one, $two, true);
                    if ($diff->h == 0) {
                        if ($diff->i == 0) {
                            if ($diff->s <= 10) {
                                return 'Just now';
                            } else {
                                return $diff->s . ' seconds ago';
                            }
                        } else {
                            return $diff->i . ' minutes ago';
                        }
                    } else {
                        if ($diff->h == 1)
                            return $diff->h . ' hour ago';
                        if ($diff->h < 12)
                            return $diff->h . ' hours ago';
                        return 'Today ' . date('h:i A', strtotime($data));
                    }
                    break;
                case 1:
                    return 'Yesterday ' . date('h:i A', strtotime($data));
                    break;
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                    return $diff . ' days ago '; //.date('D, h:i A', strtotime($data));
                    break;
                case 7:
                    return 'Last week ' . date('D, h:i A', strtotime($data));
            }
            return date('M d, h:i A', strtotime($data));
        }
        return date('M d, h:i A', strtotime($data));
    }
    return date('Y/m/d h:i A', strtotime($data));
}

/*
function formatTime($data)
{
    if (date('Y', strtotime($data)) == date('Y'))
    {
        if (date('Y/m', strtotime($data)) == date('Y/m'))
        {
            $time = date('Y/m/d', strtotime($data));
            $diff = (int) date('d') - (int) date('d', strtotime($time));
            $diff = (int) $diff;
            switch ($diff) {
                case 0:
                    $one = new DateTime(date('h:i:s'));
                    $two = new DateTime(date('h:i:s', strtotime($data)));                   
                    $diff = date_diff($one, $two, true);
                    print_r($diff);
                    if ($diff->h == 0)
                    {
                        if ($diff->i == 0)
                        {
                            if ($diff->s <= 10)
                            {
                                return 'Just now';
                            } else
                            {
                                return $diff->s . ' seconds ago';
                            }
                        } else
                        {
                            return $diff->i . ' minutes ago';
                        }
                    } else
                    {
                        if ($diff->h == 1)
                        {
                            return $diff->h . ' hour ago';
                        }
                        if ($diff->h < 12)
                        {
                            return $diff->h . ' hours ago';
                        }
                        return 'Today ' . date('h:i A', strtotime($data));
                    }
                    break;
                    
                case 1:
                    return 'Yesterday ' . date('h:i A', strtotime($data));
                    break;
                
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                    return $diff . ' days ago '; //.date('D, h:i A', strtotime($data));
                    break;
                case 7:
                    return 'Last week ' . date('D, h:i A', strtotime($data));
            }
            return date('M d, h:i A', strtotime($data));
        }
        return date('M d, h:i A', strtotime($data));
    }
    return date('Y/m/d h:i A', strtotime($data));
}*/

function getCss($file, $withTag = true)
{
    global $config;
    $file = $config['template'] . DS . 'ui' . DS . 'css' . DS . $file . '.css';
    if ($withTag)
        echo '<style type="text/css">' . file_get_contents($file) . '</style>';
    else
        echo file_get_contents($file);
}

function getExpire($date)
{
    $one = new DateTime(date('Y/m/d'));
    $two = new DateTime(date('Y/m/d', strtotime($date)));
    $diff = date_diff($two, $one);
    if ($diff->y < 0 && $diff->m < 0 && $diff->d < 0)
        return 'Expired on ' . date('d M, Y ', strtotime($date . '+1 year'));
    else
        return 'Expires on ' . date('d M, Y ', strtotime($date . '+1 year'));
}

function getRemark($date)
{
    return 'Not Claimed';
}

function paginateInSession($data)
{
    $pages = ceil((count($data)) / 50);
}

function getPostImage($post)
{
    if (!is_array($post))
        return false;
    global $config;
    $file = $config['uploads'] . $config['sep'] . 'gallery' . $config['sep'] . date('Y/m/d', strtotime($post['post_created']));
    $file = $file . $config['sep'] . $post['post_image'];
    return $file;
}

function cleanTags($s)
{
    $s = preg_replace('%(<p[^>]*>)%i', '', $s);
    $s = str_replace('</p>', '</p><p class="content">', $s);
    $s = preg_replace('%(<div[^>]*>)%i', '', $s);
    $s = str_replace('</div>', '', $s);
    return $s;
}
