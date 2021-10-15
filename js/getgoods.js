window.onload = getInfo();
function getInfo() {
    let request = new XMLHttpRequest();
    request.open('Get', 'http://127.0.0.1/shoppingcar/api/getgoods.php');
    request.send();

    request.onload = function() {
        let data = JSON.parse(request.response);
        if(!data['member']){
          alert('請先登入');
          location.href = 'index.html';
        }else{
          let goods = data['goodsinfo'];
          for(let i = 0;i < goods.length; i++){
            let goodslist = document.getElementById('goodslist');
            let goodsitem = document.createElement('tr');
            goodsitem.setAttribute('id','goods'+ (i + 1));
            let str = "";
            str += "<td>"+data['goodsinfo'][i]['name']+"</td>"
            +"<td>"+data["goodsinfo"][i]["stock"]+"</td><td>"+data["goodsinfo"][i]["prices"]
            +"</td><td><button type='button' name='button' id = '" + (i + 1) + "' onclick = 'addcart(this.id)'>加入購物車</button></td>";
            goodslist.appendChild(goodsitem);
            document.getElementById('goods'+ (i + 1)).innerHTML = str;
          }
        }
    }
}

function logout() {
  let request = new XMLHttpRequest();
  request.open('Get', 'http://127.0.0.1/shoppingcar/api/logout.php');
  request.send();
  request.onload = function()  {
    alert('登出成功');
    location.href = 'index.html';
  }
}

function gomember() {
  location.href = 'member.html';
}

function addcart(id) {
  let request = new XMLHttpRequest();
  request.open('POST', 'http://127.0.0.1/shoppingcar/api/addcarts.php', true);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
  request.onload = function () {

  };
  request.send('goodsid=' + id);
}

function gocart() {
  location.href = "cartlist.html";
}
