

<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bejstyle.css">
  <title>OTP Ellenőrzés</title>
</head>
<body>

  <div class="otp-box">
    <form action="verify_otp.php" method="POST">
      <div class="user-box">
        <input type="email" name="email" value="kelemenjanos400@gmail.com" readonly required>
      </div>
      <div class="user-box">
        <input type="text" name="otp" placeholder="Egyszer használatos kód" required>
      </div>
      <button type="submit" class="button">OTP Ellenőrzése</button>
    </form>
  </div>

</body>
</html>

