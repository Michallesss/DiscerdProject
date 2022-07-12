//forms validation (sign up, login, send)

function messages() {
    let content=document.forms['message']['content'].value;
    if(content=="") {
        return false;
    }
}

function log_in() {
    let login=document.forms['login']['lg_login'].value;
    let password=document.forms['login']['lg_password'].value;
    let is_good=true;

    if(login=="") {
        document.getElementById('lg_login').innerHTML="Fill login";
        is_good=false;
    }
    if(password=="") {
        document.getElementById('lg_password').innerHTML="Fill password";
        is_good=false;
    }

    return is_good;
}

function sign_up() {
    let login=document.forms['signup']['rg_login'].value;
    let password=document.forms['signup']['rg_password'].value;
    let password2=document.forms['signup']['rg_password2'].value;
    let nick=document.forms['signup']['rg_nick'].value;
    let email=document.forms['signup']['rg_email'].value;
    let phone=document.forms['signup']['rg_phone'].value;
    let is_good=true;

    //login
    if((login.length<3) || (login.length>30)) {
        document.getElementById('rg_login').innerHTML="Login must have minimaly 3 and max 20 letters";
        is_good=false;
    }
    if(login=="") {
        document.getElementById('rg_login').innerHTML="Fill login";
        is_good=false;
    }
    //password
    if((password.length<8) || (password.length>20)) {
        document.getElementById('rg_password').innerHTML="Password must have minimaly 8 and max 20 letters";
        is_good=false;
    }
    if(password=="") {
        document.getElementById('rg_password').innerHTML="Fill password";
        is_good=false;
    }
    if((password2!=password) || (password2=="")) {
        document.getElementById('rg_password2').innerHTML="Passwords are not the same";
        is_good=false;
    }
    //nick
    if(nick.length>30) {
        document.getElementById('rg_email').innerHTML="Nick must have max 20 letters";
        is_good=false;
    }
    //email
    if(email.length>30) {
        document.getElementById('rg_email').innerHTML="Email must have max 30 letters";
        is_good=false;
    }
    //phone
    if(phone.toString().length>9) {
        document.getElementById('rg_phone').innerHTML="Phone must have max 9 numbers";
        is_good=false;
    }
    if((phone!="") && (phone!=parseInt(phone))) {
        document.getElementById('rg_phone').innerHTML="Phone can only consist numbers";
        is_good=false;
    }

    return is_good;
}

function searches() {
    document.getElementById('sr_error').innerHTML="";
    let content=document.forms['search']['search'].value;

    if(content=="") {
        document.getElementById('sr_error').innerHTML="Fill search field";
        return false;
    }
}