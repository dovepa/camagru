//////////////////////////////////////////////////////////////
//                    alert hide msg
//////////////////////////////////////////////////////////////

function hide(){
  try {
    document.getElementById("close")
    .addEventListener("click", function() {
  document.getElementById("hide").hidden = true;
}, false);
  }
  catch(error) {
  }
}

//////////////////////////////////////////////////////////////
//                    Scroll auto Menu
//////////////////////////////////////////////////////////////

function menu(){
  try {
    var a = document.body.scrollTop;

    document.getElementById("menu").style.marginTop = a + "px";
  }
  catch(error) {
  }
 }

//////////////////////////////////////////////////////////////
//                    Infinite scroll
//////////////////////////////////////////////////////////////

function scroll(){
var offset = 28
function getDistFromBottom () {

  var scrollPosition = window.pageYOffset;
  var windowSize     = window.innerHeight;
  var bodyHeight     = document.body.offsetHeight;

  return Math.max(bodyHeight - (scrollPosition + windowSize), 0);

}
var dist = getDistFromBottom ()
window.onscroll = function(){
  dist = getDistFromBottom ()
  var act = true
  if (dist === 0 && act === true){
    act = false

    var xhr = getHttpRequest()
    xhr.open('GET', 'ctrl.php?p=loader&off='+ offset, true)
    // On envoit un header pour indiquer au serveur que la page est appellée en Ajax
    xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
    // On lance la requête
    xhr.send()
    xhr.onreadystatechange = function () {
      xhr.responseText = '';
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            act = true
            offset = offset + 28;
            var d1 = document.getElementById('post');
            d1.insertAdjacentHTML('beforeend', xhr.responseText);
        } else {
          alert('error')
            // Le serveur a renvoyé un status d'erreur
        }
      }
    }

  }
}
};

function scrollh(){
    function getDistFromBottom () {

      var scrollPosition = window.pageYOffset;
      var windowSize     = window.innerHeight;
      var bodyHeight     = document.body.offsetHeight;

      return Math.max(bodyHeight - (scrollPosition + windowSize), 0);

    }
    var dist = getDistFromBottom ()
      dist = getDistFromBottom ()
      var act = true
      if (dist === 0 && act === true){
        act = false

        var xhr = getHttpRequest()
        xhr.open('GET', 'ctrl.php?p=loader2&off='+ offset, true)
        // On envoit un header pour indiquer au serveur que la page est appellée en Ajax
        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
        // On lance la requête
        xhr.send()
        xhr.onreadystatechange = function () {
          xhr.responseText = '';
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                act = true
                offset = offset + 10;
                var d1 = document.getElementById('imgrp');
                d1.insertAdjacentHTML('beforeend', xhr.responseText);
            } else {
              alert('error')
                // Le serveur a renvoyé un status d'erreur
            }
        }

      }
    }
};

function scrollgal(id){
  function getDistFromBottom () {

    var scrollPosition = window.pageYOffset;
    var windowSize     = window.innerHeight;
    var bodyHeight     = document.body.offsetHeight;

    return Math.max(bodyHeight - (scrollPosition + windowSize), 0);

  }
  var dist = getDistFromBottom ()
    dist = getDistFromBottom ()
    var act = true
    if (dist === 0 && act === true){
      act = false

      var xhr = getHttpRequest()
      xhr.open('GET', 'ctrl.php?p=loader3&off='+ offset + '&id=' + id, true)
      // On envoit un header pour indiquer au serveur que la page est appellée en Ajax
      xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
      // On lance la requête
      xhr.send(id)
      xhr.onreadystatechange = function () {
        xhr.responseText = '';
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
              act = true
              offset = offset + 10;
              var d1 = document.getElementById('imgrp');
              d1.insertAdjacentHTML('beforeend', xhr.responseText);
          } else {
            alert('error')
              // Le serveur a renvoyé un status d'erreur
          }
      }

    }
  }
};

//////////////////////////////////////////////////////////////
//                    Remove Pic
//////////////////////////////////////////////////////////////

function removepic(id){
  if (confirm("Are you sure ?")){
    var act = true
    if (act === true){
      act = false

      var xhr = getHttpRequest()
      xhr.open('POST', 'ctrl.php?p=remove', true)
      // On envoit un header pour indiquer au serveur que la page est appellée en Ajax
      xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
      // On lance la requête
      var data = new FormData()
      data.append('item', id)
      xhr.send(data)
      xhr.onreadystatechange = function () {
        xhr.responseText = '';
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
              if (xhr.responseText){
                alert(xhr.responseText)
                document.getElementById(id).hidden = true;
              }
              act = true
          } else {
            alert('error')
              // Le serveur a renvoyé un status d'erreur
          }
        }
      }

    }
  }else{
    alert('operation canceled');
  }
};

//////////////////////////////////////////////////////////////
//                    Remove Com
//////////////////////////////////////////////////////////////

function removecom(id) {
  if (confirm("Are you sure ?")){
    var act = true
    if (act === true){
      act = false

      var xhr = getHttpRequest()
      xhr.open('POST', 'ctrl.php?p=removecom', true)
      // On envoit un header pour indiquer au serveur que la page est appellée en Ajax
      xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
      // On lance la requête
      var data = new FormData()
      data.append('item', id)
      xhr.send(data)
      xhr.onreadystatechange = function () {
        xhr.responseText = '';
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
              if (xhr.responseText){
                alert(xhr.responseText)
                document.getElementById(id + 'com').hidden = true;
              }
              act = true
          } else {
            alert('error')
              // Le serveur a renvoyé un status d'erreur
          }
        }
      }

    }
  }else{
    alert('operation canceled');
  }
};

//////////////////////////////////////////////////////////////
//                    Get Likes
//////////////////////////////////////////////////////////////

function likes(id) {
    var act = true
    if (act === true){
      act = false

      var xhr = getHttpRequest()
      xhr.open('POST', 'ctrl.php?p=likes', true)
      // On envoit un header pour indiquer au serveur que la page est appellée en Ajax
      xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest')
      // On lance la requête
      var data = new FormData()
      data.append('img', id)
      xhr.send(data)
      xhr.onreadystatechange = function () {
        xhr.responseText = '';
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
              if (xhr.responseText){
                document.getElementById(id +"likes").innerHTML = xhr.responseText;
              }
              act = true
          } else {
            alert('error')
              // Le serveur a renvoyé un status d'erreur
          }
        }
      }

    }
};
