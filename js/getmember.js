window.onload = getInfo();
function getInfo() {
    let request = new XMLHttpRequest();
    request.open('Get', 'http://127.0.0.1/shoppingcar/api/getmember.php');
    request.send();

    request.onload = function() {
        let data = JSON.parse(request.response);
        if(!data['member']){
          alert('請先登入');
          location.href = 'index.html';
        }else{
          let email = document.getElementById('showemail');
          let email2 = document.getElementById('email');
          email.innerHTML = data['memberinfo']['email'];
          email2.innerHTML = data['memberinfo']['email'];
          let name = document.getElementById('showname');
          name.innerHTML = data['memberinfo']['username'];
          let phone = document.getElementById('showphone');
          phone.innerHTML = data['memberinfo']['phone'];
        }
    }
}

function showupdate() {
  let table = document.getElementById('membertable');
  table.setAttribute('style', 'display:none');
  let form = document.getElementById('memberform');
  form.setAttribute('style', 'display:block');
}

function remem() {
  let table = document.getElementById('membertable');
  table.setAttribute('style', 'display:table');
  let form = document.getElementById('memberform');
  form.setAttribute('style', 'display:none');
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
  checkpwd();checkpwdc();checkname();checkphone();
  let check = checkpwd() && checkpwdc() && checkname() && checkphone();
  return check;
}

function golist() {
  location.href = 'goodslist.html';
}
