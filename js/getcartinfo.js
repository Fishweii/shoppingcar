window.onload = getInfo();
function getInfo() {
    let request = new XMLHttpRequest();
    request.open('Get', 'http://127.0.0.1/shoppingcar/api/getcartinfo.php');
    request.send();

    request.onload = function() {
        let data = JSON.parse(request.response);
        if(!data['member']){
          alert('請先登入');
          location.href = 'index.html';
        }else if(!data['cartsinfo']){
            alert('購物車沒東西快去買');
            location.href = 'goodslist.html';
        }else{
          let carts = data['cartsinfo'];
          for(let i = 0;i < carts.length; i++){
            let cartslist = document.getElementById('cartslist');
            let cartsitem = document.createElement('tr');
            cartsitem.setAttribute('id','carts'+ (data['cartsinfo'][i]['infoid']));
            let str = "";
            str += "<td>"+data['cartsinfo'][i]['goodsname']+"</td><td><select id="+data['cartsinfo'][i]['goodsid']+" onchange='newamount(this.id)'>";
            for(let j = 1;j <= data['cartsinfo'][i]['goodstock']; j++){
              if(j != data['cartsinfo'][i]['amount']){
                str += "<option value='" + j + "'>" + j +"</option>";
              }else{
                str += "<option value='" + j + "' selected>" + j +"</option>";
              }
            }
            str += "</select></td><td id='price"+data['cartsinfo'][i]['goodsid']+"'>"+data['cartsinfo'][i]['prices']
            +"</td><td><button type='button' name='button' id = '" + (data['cartsinfo'][i]['infoid']) + "' onclick = 'deletegood(this.id)'>移除商品</button></td>";
            cartslist.appendChild(cartsitem);
            document.getElementById('carts'+ (data['cartsinfo'][i]['infoid'])).innerHTML = str;
          }
          let totalprices = 0;
          for(let i = 0;i < carts.length; i++){
            let priceid = document.getElementById('price' + data['cartsinfo'][i]['goodsid']);
            totalprices += parseInt(priceid.innerHTML);
          }
          let str = "<tr><td><button type='button' onclick='deletecart()'>清空購物車</button></td><td></td><td id='totalprice'>"+totalprices+"</td><td></tr>";
          let totalitem = document.createElement('tr');
          totalitem.setAttribute('id', 'total');
          let cartslist = document.getElementById('cartslist');
          cartslist.appendChild(totalitem);
          document.getElementById('total').innerHTML = str;
        }
    }
}

function newamount(id) {
  let selectid = document.getElementById(id);
  let idvalue = selectid.options[selectid.selectedIndex].value;
  let request = new XMLHttpRequest();
  request.open('POST', 'http://127.0.0.1/shoppingcar/api/alteramount.php', true);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
  request.send('goods=' + id +'&amount=' + idvalue);
  request.onload = function () {
    let priceid = document.getElementById('price' + id);
    let data = JSON.parse(request.response);
    let oldprice = priceid.innerHTML;
    let totalid = document.getElementById('totalprice');
    totalid.innerHTML = parseInt(totalid.innerHTML) - parseInt(oldprice) + parseInt(data['price']);
    priceid.innerHTML = data['price'];
  };
}

function deletegood(infoid) {
  let request = new XMLHttpRequest();
  request.open('POST', 'http://127.0.0.1/shoppingcar/api/deletegood.php', true);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
  request.send('infoid=' + infoid);
  request.onload = function () {
    let trid = document.getElementById('carts' + infoid);
    let pricenode = trid.lastChild.previousSibling.innerHTML;
    let totalprice = document.getElementById('totalprice');
    totalprice.innerHTML = parseInt(totalprice.innerHTML) - parseInt(pricenode);
    trid.parentNode.removeChild(trid);

    let data = JSON.parse(request.response);
    if(data['nogoods']){
      alert('購物車沒有商品~快去買');
      location.href = "goodslist.html";
    }
  }
}

function deletecart() {
  let request = new XMLHttpRequest();
  request.open('POST', 'http://127.0.0.1/shoppingcar/api/deletecart.php', true);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
  request.send();
  request.onload = function () {
    alert('購物車已清空');
    location.href = "goodslist.html";
  }
}
