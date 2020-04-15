<?php
    
	$LINEData = file_get_contents("php://input");
        
	$jsonData = json_decode($LINEData,true);
        
        
        
            $replyToken = $jsonData["events"][0]["replyToken"];
            $text = $jsonData["events"][0]["message"]["text"];
            
           
   
    $servername = "localhost";
    
    $username = "root";
    
    $password = "";
    
    $dbname = "mtr10years";

    
    $mysql = new mysqli($servername, $username, $password, $dbname);
    
    mysqli_set_charset($mysql, "utf8");
    
    if ($mysql->connect_error){
	$errorcode = $mysql->connect_error;
	print("MySQLi(Connection)> ".$errorcode);
}


        function sendMessage($replyJson, $sendInfo){
                $ch = curl_init($sendInfo["URL"]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $sendInfo["AccessToken"])
                    );
                curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);

                $result = curl_exec($ch);



                curl_close($ch);
                return $result;

        }
            $getUser = $mysql->query("SELECT * FROM tbl_member  where uid = '$text'") or die("Error: " . mysqli_error($mysql));
            $getcust = $mysql->query("SELECT * FROM tbl_member  where uid = '$text'") or die("Error: " . mysqli_error($mysql));
	   
            $getuserNum = mysqli_num_rows($getUser); 
            $replyText["type"] = "text";
            if(is_numeric($text)) {
                if(strlen($text) <= 5){
                        if($getuserNum==0){
                            echo "เพิ่ม";

                             $insert = "INSERT INTO tbl_member (uid,token) VALUES ('$text','$replyToken')";  
                                $result = mysqli_query($mysql,$insert) or die("Error: " . mysqli_error($mysql));


                        }else{
                                    echo "ซ้ำ";
                                    while($row = $getcust->fetch_assoc()){
                                    $Name = $row['m_name'];
                                    $Surname = $row['m_lname'];
                                    $CustomerID = $row['uid'];
                                        }
                                        //echo "สวัสดีคุณ"." ".$Name." ".$Surname." "."(#$CustomerID)";
                                    $replyText["text"] = "สวัสดีคุณ $Name $Surname (#$CustomerID)";


                            }
                }else{
                   echo "ตัวอักษรมากกว่า5";
                }
            }else{
                   echo "ไม่ใช่รหัสพนักงาน";
            }

  $lineData['URL'] = "https://api.line.me/v2/bot/message/reply";
  $lineData['AccessToken'] = "jvs0BA1ajDsBM+3xslmHCt+J1cwvhhhvPXGXGoJ8Ld6JHLOcDTOiEKGv7eByGtqZjQICjVfJdpkwcNUD1MlbcmNoYAObqnMUvdgJQCmrLxX8yxyHan2BdLoiDm1Neoe/1CIuIgRdZOH4hoUr6Z72kQdB04t89/1O/w1cDnyilFU=";
  
  $replyJson["replyToken"] = $replyToken;
  $replyJson["messages"][0] = $replyText;

  $encodeJson = json_encode($replyJson);

  $results = sendMessage($encodeJson,$lineData);
  echo $results;
  http_response_code(200);
