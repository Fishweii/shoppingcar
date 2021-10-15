function gosignup() {
  location.href = 'signup.html';
}
function checkmail() {
  let check = false;
  let emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
  let email = document.getElementById('email').value;
  if(!emailRule.test(email)){
    document.getElementById('checkmail').innerHTML = "請輸入正確的電子信箱";
    check = false;
  }else{
    document.getElementById('checkmail').innerHTML = "";
    check = true;
  }
  return check;
}

function checkpwd() {
  let check = false;
  let pwd = document.getElementById('pwd').value;
  if(pwd.length < 1 || pwd.length >12){
    document.getElementById('checkpwd').innerHTML = "密碼需介於1~12個字中間";
    check = false;
  }else{
    document.getElementById('checkpwd').innerHTML = "";
    check = true;
  }
  checkpwdc();
  return check;
}

function checkpwdc () {
  let check = false;
  let pwd = document.getElementById('pwd').value;
  let pwdc = document.getElementById('pwdc').value;
  if(pwd != pwdc){
    document.getElementById('checkpwdc').innerHTML = "兩次密碼不相符";
    check = false;
  }else {
    document.getElementById('checkpwdc').innerHTML = "";
    check = true;
  }
  return check;
}

function checkname() {
  let check = false;
  let username = document.getElementById('username').value;
  if(username == "") {
    document.getElementById('checkname').innerHTML = "請輸入姓名";
    check = false;
  }else {
    document.getElementById('checkname').innerHTML = "";
    check = true;
  }
  return check;
}

function checkphone() {
  let check = false;
  let phoneRule = /^[09]{2}\d{8}$/;
  let phone = document.getElementById('phone').value;

  if(!phoneRule.test(phone)){
    document.getElementById('checkphone').innerHTML = "電話格式錯誤";
    check = false;
  }else{
    document.getElementById('checkphone').innerHTML = "";
    check = true;
  }
  return check;
}

function check() {
  checkmail();checkpwd();checkpwdc();checkname();checkphone();
  let check = checkmail() && checkpwd() && checkpwdc() && checkname() && checkphone();
  return check;
}
