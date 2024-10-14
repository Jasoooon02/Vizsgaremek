function saveLoginData() {
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;


  var data = {
    username: username,
    password: password
  };

  
  var jsonData = JSON.stringify(data);


  var blob = new Blob([jsonData], {type: 'application/json'});


  var downloadLink = document.createElement('a');
  downloadLink.href = URL.createObjectURL(blob);
  downloadLink.download = 'loginData.json';
  downloadLink.click();
}

