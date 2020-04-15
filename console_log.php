<?php 
	$LINEData = file_get_contents("php://input");
        
        
	$jsonData = json_decode($LINEData,true);
       
        
            $replyToken = $jsonData["events"][0]["replyToken"];
            $text = $jsonData["events"][0]["message"]["text"];
        
         	echo '<script>console.log("'.htmlspecialchars(stripslashes(str_replace(array("\r", "\n"), '', var_export($LINEData, true)))).'")</script>';
                echo '<script>console.log("'.htmlspecialchars(stripslashes(str_replace(array("\r", "\n"), '', var_export($replyToken, true)))).'")</script>';
                echo '<script>console.log("'.htmlspecialchars(stripslashes(str_replace(array("\r", "\n"), '', var_export($text, true)))).'")</script>';
                
                echo "$LINEData";
                echo "$replyToken";
                echo "$text";
                
                print_r($LINEData);
                print_r($replyToken);
                print_r($text);
               
                http_response_code(200);
                
                
        
	
        
            
