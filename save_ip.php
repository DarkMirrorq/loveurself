<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  $ip = $data['ip'];

  // IP'leri kaydedeceğiniz dosyanın adı
  $fileName = 'ips.txt';

  // IP'yi dosyaya ekleyin (dosya yoksa oluşturur)
  file_put_contents($fileName, $ip . PHP_EOL, FILE_APPEND);
}
