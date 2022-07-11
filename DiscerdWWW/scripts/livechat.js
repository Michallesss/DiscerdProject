//live chat (chat.php, group.php, server.php)

function livechat() { //updateing messages
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        document.querySelector('.content').innerHTML=this.responseText;
    }

    let type=document.getElementById("type").value;
    let channel=document.getElementById("channel").value;

    if(type=="server") {
        let server=document.getElementById("server").value;
        xhttp.open("GET", "actions/receiveserver.php?server="+server+"&channel="+channel);
    }
    else {
        xhttp.open("GET", "actions/receive"+type+".php?"+type+"="+channel);
    }
    xhttp.send();

    setTimeout("livechat();",1000);
}

/*function send() { //(async) sending messages
    //async messsages sending
    //https://youtu.be/7xjDgKMxiQo?t=2242
}*/

/*function members() { 
    //async getting info about chat/group/server members
}*/