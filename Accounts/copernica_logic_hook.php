<?php

    if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
   
    class copernica_class
    {
        function updateCopernica($bean, $event, $arguments)
        {
            //SET DATABASE ID; here it is testdb            
            $databaseID = 43;
            // the token, Gereate this ID from Copernica Dashboard
            $token = 'XXXXX';

            $email_to_find = $bean->copernica_email_c;
            $name = $bean->copernica_name_c;
            
            // find email with 
            $data = array(
                'Email' => $bean->copernica_email_c
            );

            $url = array();
            foreach ($data as $key => $value){
                // make the url encoded query string    
                $url[] = 'fields[]='.urlencode($key.'=='.$value);
            }
            $url = implode('&', $url);  
            //Copernica REST API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.copernica.com/database/$databaseID/profiles/?access_token=$token&$url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // note the PUT here
            curl_setopt($ch, CURLOPT_HEADER, false);
            // execute the request
            $output = curl_exec($ch);
            // close curl resource to free up system resources
            curl_close($ch);
            //decode jason output
            $result = json_decode($output);
            
            if($result->total > 0){
                //update that record
                $update = array(
                    "Name" => $bean->copernica_name_c
                );
                $data_string = json_encode($update);

                $chUpdate = curl_init();
                curl_setopt($chUpdate, CURLOPT_URL, "https://api.copernica.com/database/$databaseID/profiles/?access_token=$token&$url");
                curl_setopt($chUpdate, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chUpdate, CURLOPT_POST, true);
                curl_setopt($chUpdate, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here
                curl_setopt($chUpdate, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($chUpdate, CURLOPT_HEADER, false);
                curl_setopt($chUpdate, CURLOPT_HTTPHEADER, array(             
                    'Content-Type: application/json',               
                    'Content-Length: ' . strlen($data_string)
                ));
                // execute the request
                $outputUpdate = curl_exec($chUpdate);                
                curl_close($chUpdate);                
                $GLOBALS['log']->fatal('if part..Update Record...');                
            }
            if($result->total == 0){
                //Create a New Entry
                $add_data = array (
                    'Name' => $bean->copernica_name_c,
                    'Email' => $bean->copernica_email_c
                );
                // json encode data
                $data_string = json_encode($add_data);
                // set up the curl resource
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.copernica.com/database/$databaseID/profiles?access_token=$token");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string)                             
                ));
                // execute the request
                $output = curl_exec($ch);
                // output the profile information - includes the header
                //echo($output) . PHP_EOL;
                if(curl_errno($ch)){
                    $error = curl_error($ch);
                }
                // close curl resource to free up system resources
                curl_close($ch);                 
                $GLOBALS['log']->fatal('Else part..Add Record...'.$error);
            }//End of if/else
        }//End of func
    }//End of Class
?>