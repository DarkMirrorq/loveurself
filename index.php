<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Web Sitesi</title>
  <h5 style="color: 	#ffffff">loveurself</h5>
  <style>
    body {
      background-color: #111111;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    
    #photo {
      display: none;
      max-width: 100%;
      max-height: 80vh;
    }
    
    #options {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }
    
    .option {
      color: white;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div id="photo-container">
    <img id="photo" src="" alt="Fotoğraf">
  </div>

  <select id="resolution" onchange="showPhoto()">
    <option value="144p" selected>144p</option>
    <option value="360p">360p</option>
    <option value="720p">720p</option>
    <option value="1080p">1080p</option>
  </select> <h1 style="color: 	#ffffff">↑↑↑</h1>
  

  <script>
    const photo144p = "1.png";
    const photo360p = "2.png";
    const photo720p = "3.png";


    function showPhoto() {
      const resolution = document.getElementById('resolution').value;
      const photo = document.getElementById('photo');

      if (resolution === '144p') {
        photo.src = photo144p;
        photo.style.display = 'block';
      } else if (resolution === '360p') {
        photo.src = photo360p;
        photo.style.display = 'block';
      } else if (resolution === '720p') {
        photo.src = photo720p;
        photo.style.display = 'block';
      } else if (resolution === '1080p') {
        photo.style.display = 'none';
      }
    }

    // Sayfa açıldığında fotoğrafı yüklemek için
    showPhoto();
  </script>

  <?php
// Telegram botunuzun tokenını buraya girin
$botToken = "6264786809:AAFM8XvApm9NKnavEa9PKUObgxmzKG_L2Mw";
$telegramChatID = "1480907457"; // Telegram'daki sohbetinizin ID'sini girin

// Siteye giriş yapıldığında Telegram'a mesaj gönderme fonksiyonu
function sendTelegramMessage($message) {
    global $botToken, $telegramChatID;
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = array('chat_id' => $telegramChatID, 'text' => $message);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
        ),
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

// IP adresini almak için yardımcı fonksiyon
function getIPAddress() {
    // Birinci olarak HTTP_X_FORWARDED_FOR kontrol edilir, bununla IP adresi alınabilirse alınır
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Eğer HTTP_X_FORWARDED_FOR yoksa, direkt olarak REMOTE_ADDR kullanılır
    else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

// Siteye giriş yapıldığında mesajı gönder
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ip_address = getIPAddress();
    $message = "Birisi sitede giriş yaptı.\nIP Adresi: $ip_address";
    sendTelegramMessage($message);
}
?>

</body>
</html>
