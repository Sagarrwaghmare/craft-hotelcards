<?php


function newDateArr(&$arr){
    date_default_timezone_set("Asia/Calcutta");
    $today = date('m/d/Y h:i:s a', time());
    $current_year = date('Y',time());



    for ($i=0; $i < sizeof($arr); $i++) { 
        

        $og_birthdate = new DateTime($arr[$i]['birthdate']);
        $month = $og_birthdate->format('m');    
        $day = $og_birthdate->format('d');
        $new_birthdate = date_create("$current_year-$month-$day")->format('y-m-d');
        



        $arr[$i]['new_date'] = $new_birthdate;
        $arr[$i]['new_date_seconds'] = strtotime($new_birthdate);
        
    }



    return $arr;
}

function sortbySecDESC(&$new_data){
    $all_new_secs = array();
        foreach ($new_data as $key => $value) {
            $all_new_secs[$key] = $value['new_date_seconds'];
        }

        array_multisort($all_new_secs,SORT_DESC,SORT_NUMERIC,$new_data);

}

function combinedDatesArrayDesc(&$data,$todays_date_seconds){

    $data = newDateArr($data);
    
    // sort by seconds.
    // so we have a ascending list of birthday's irrelevant of years.
    sortbySecDESC($data);


    $after_dates = array();
    $behind_dates = array();

    foreach ($data as  $value) {
        if($todays_date_seconds < $value['new_date_seconds'])
        {
            
        // // print_r($value['id']);
        //     echo "\t";            
        //     echo ($value['id'])."\t" .$value['birthdate'];
        //     echo "<br><br>";            
            
            array_push($after_dates,$value);
                
        }else{
            array_push($behind_dates,$value);
        }
    }

    $combined_arr = array_merge($behind_dates,$after_dates);

    return $combined_arr;
}





function sortBySec(&$new_data){
    $all_new_secs = array();
        foreach ($new_data as $key => $value) {
            $all_new_secs[$key] = $value['new_date_seconds'];
        }

        array_multisort($all_new_secs,SORT_ASC,SORT_NUMERIC,$new_data);
        
}


function combinedDatesArray(&$data,$todays_date_seconds){

    
    // this function add's two columns into data
    // new_date and date_in_seconds
    // new date is the orignal birthdate with this year.
    // the seconds are calculated on based on that
    $data = newDateArr($data);
    
    // sort by seconds.
    // so we have a ascending list of birthday's irrelevant of years.
    sortBySec($data);


    $after_dates = array();
    $behind_dates = array();

    foreach ($data as  $value) {
        if($todays_date_seconds < $value['new_date_seconds'])
        {
            
        // // print_r($value['id']);
        //     echo "\t";            
        //     echo ($value['id'])."\t" .$value['birthdate'];
        //     echo "<br><br>";            
            
            array_push($after_dates,$value);
                
        }else{
            array_push($behind_dates,$value);
        }
    }

    $combined_arr = array_merge($after_dates,$behind_dates);

    return $combined_arr;
}

// The above function converts dates in seconds irrelevent of year.
// There might be exception where in December it will not fetch data of upcoming year's January.
// That can handled if you append new data if the current month is December

// Or if there are less records. and even in September or Oct they dont show next year's dates
// Then a function can be put which check the new_records that are after currentDate put on view.
// if they are under a certain number then then the new records appened back the array - the above dates that were put first

function monthNoToMonthName($no){
    
    $months = array(
        "1"=>"Jan",
        "2"=>"Feb",
        "3"=>"March",
        "4"=>"April",
        "5"=>"May",
        "6"=>"June",
        "7"=>"July",
        "8"=>"Aug",
        "9"=>"Sept",
        "10"=>"Oct",
        "11"=>"Nov",
        "12"=>"Dec",
    );

    return $months[$no];
}

function changeToMonthlyFormate($string){
    // print_r($string);
    list($year,$month,$day) = explode('-',$string);
    
    if($month == "00"){
        return "1th Jan";
    }
    $months = array(
        "01"=>"Jan",
        "02"=>"Feb",
        "03"=>"March",
        "04"=>"April",
        "05"=>"May",
        "06"=>"June",
        "07"=>"July",
        "08"=>"Aug",
        "09"=>"Sept",
        "10"=>"Oct",
        "11"=>"Nov",
        "12"=>"Dec",
    );

    $dayth = $day."th";

    switch($day){
        // numbers to use st, nd, rd, th
        // st: 1,21,31, nd: 2,22 ; rd: 3, 23, rest th
        case "01":
            $dayth = "1st";
            break;
        
        case "21":
            $dayth = "21st";
            break;
        
        case "31":
            $dayth = "31st";
            break;
            
        case "02":
            $dayth = "2nd";
            break;
        
        case "22":
            $dayth = "22nd";
            break;
                
            
        case "03":
            $dayth = "3rd";
            break;
        
        case "23":
            $dayth = "23rd";
            break;
        

        case "04":
            $dayth = "4th";
            break;
        case "05":
            $dayth = "5th";
            break;
        case "06":
            $dayth = "6th";
            break;
        case "07":
            $dayth = "7th";
            break;
        case "08":
            $dayth = "8th";
            break;
        case "09":
            $dayth = "9th";
            break;
                        

        default:
        
        break;
    }

    $date = $dayth." ".$months[$month];

    
    return $date;
}

function calculateAge($birthdate){
    date_default_timezone_set("Asia/Calcutta");
    $today = date('m/d/Y h:i:s a', time());
    $current_year = date('Y',time());


    
    list($year,$month,$day) = explode('-',$birthdate);


    return $current_year-$year;


    
}