<?php
    function get_months($startstring, $endstring)
    {
        $time1  = strtotime($startstring);//absolute date comparison needs to be done here, because PHP doesn't do date comparisons
        $time2  = strtotime($endstring);
        $my1     = date('mY', $time1); //need these to compare dates at 'month' granularity
        $my2    = date('mY', $time2);
        $year1 = date('Y', $time1);
        $year2 = date('Y', $time2);
        $years = range($year1, $year2);
        
        foreach($years as $year)
        {
            $months[$year] = array();
            while($time1 < $time2)
            {
                if(date('Y',$time1) == $year)
                {
                    $months[$year][] = date('m', $time1);
                    $time1 = strtotime(date('Y-m-d', $time1).' +1 month');
                }
                else
                {
                    break;
                }
            }
            continue;
        }
        
        return $months;
    }

    function getPrevKey($key, $hash = array())
    {
        $keys = array_keys($hash);
        $found_index = array_search($key, $keys);
        if ($found_index === false || $found_index === 0)
            return false;
        return $keys[$found_index-1];
    }

    function getIndex($name, $array){
        foreach($array as $key => $value){
            if(is_array($value) && $value['name'] == $name)
                  return $key;
        }
        return null;
    }