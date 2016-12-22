<?php

$to = 'jan@k0s.si';
$subject = 'EPStore - Aktivacija računa';
$message = '
<html>
<head>
  <title>Aktivacija računa</title>
</head>
<body>
  <p>Račun potrdite na naslovu: ...</p>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = 'From: no-reply@epstore.tk';
$headers[] = 'To: jan@k0s.si';
$headers[] = 'X-Mailer: PHP/' . phpversion();

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));
?>