
document.getElementById("name").focus();

document.getElementById("name").onblur = function () {
    this.value = chuanHoa(this.value);
};

document.getElementById("name").onkeyup = function (e) {
    doKeyup(e, this, 'address');
};

document.getElementById("address").onkeyup = function (e) {
    doKeyup(e, this, 'male');
}

document.getElementById("male").onkeyup = function (e) {
    doKeyup(e, this, 'female');
}

document.getElementById("female").onkeyup = function (e) {
    doKeyup(e, this, 'dob');
}

document.getElementById("dob").onkeyup = function (e) {
    doKeyup(e, this, 'email');
}

document.getElementById("email").onkeyup = function (e) {
    doKeyup(e, this, 'phone-number');
}

document.getElementById("phone-number").onkeyup = function (e) {
    doKeyup(e, this, 'eng');
}

document.getElementById("eng").onkeyup = function (e) {
    doKeyup(e, this, 'management');
}

document.getElementById("management").onkeyup = function (e) {
    doKeyup(e, this, 'cntt');
}

document.getElementById("cntt").onkeyup = function (e) {
    doKeyup(e, this, 'username');
}

document.getElementById("username").onkeyup = function (e) {
    doKeyup(e, this, 'pass');
}

document.getElementById("pass").onkeyup = function (e) {
    doKeyup(e, this, 're-pass');
}

document.getElementById("re-pass").onkeyup = function (e) {
    doKeyup(e, this, 'note');
}

function doKeyup(e, myself, nextcontrolid) {
    if (window.event) e = window.event; //de chay ca tren IE
    if (e.keyCode == 13) {
        document.getElementById(nextcontrolid).focus();
    }
}

function chuanHoa(name) {
    desName = name;
    ss = desName.split(' ');
    desName = "";
    for (i = 0; i < ss.length; i++)
        if (ss[i].length > 0) {
            if (desName.length > 0) desName += " ";
            desName += ss[i].substring(0, 1).toUpperCase();
            desName += ss[i].substring(1).toLowerCase();
        }
    return desName;
}

function validateEmail(mail) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.value.match(mailformat)) {
        return true;
    }
    return false;
}

function validateDate(date) {
    p = date.split('/');
    if (p.length != 3) return false;
    if (isNaN(p[0]) || isNaN(p[1]) || isNaN(p[2])) return false;

    dd = parseInt(p[0]);
    mm = parseInt(p[1]);
    yyyy = parseInt(p[2]);

    if (mm > 12 || mm < 1) return false;
    if (mm == 1 || mm == 3 || mm == 5 || mm == 7 || mm == 8 || mm == 10 || mm == 12) {
        if (dd > 31) return false;
    } else if (mm == 2) {
        if (yyyy % 2 == 0 && yyyy % 100 != 0) {
            if (dd > 29) return false;
        } else if (dd > 28) {
            return false;
        }
    } else if (dd > 30) return false;

    if (dd < 1) return false;

    date = new Date();
    if (yyyy > date.getFullYear() || yyyy < 1950) return false;
    
    return true;
}

function correctRePassw(){
    p = document.getElementById('pass').value;
    rp = document.getElementById('re-pass').value;

    return p==rp;
}

function isEmpty(input){
    return input=='';
}

function chapNhan(){
    submitOk = true;

    document.getElementById('err-name').innerHTML='';
    document.getElementById('err-dob').innerHTML='';
    document.getElementById('err-email').innerHTML='';
    document.getElementById('err-username').innerHTML='';
    document.getElementById('err-pass').innerHTML='';
    document.getElementById('err-re-pass').innerHTML='';

    if (isEmpty(document.getElementById('pass').value)){
        document.getElementById('err-pass').innerHTML='Chưa nhập password.';
        document.getElementById('pass').focus();
        submitOk=false;
    }else if (isEmpty(document.getElementById('pass').value)){
        document.getElementById('err-re-pass').innerHTML='Chưa nhập lại password.';
        document.getElementById('re-pass').focus();
        submitOk=false;
    } else if (!correctRePassw){
        document.getElementById('err-pass').innerHTML='Mật khẩu và mật khẩu nhập lại không trùng nhau.';
        document.getElementById('re-pass').focus();
        submitOk=false;
    }

    if (isEmpty(document.getElementById('err-name').value)){
        document.getElementById('err-username').innerHTML='Chưa nhập tên sử dụng.';
        document.getElementById('username').focus;
        submitOk=false;
    }

    if (isEmpty(document.getElementById('email').value)){
        document.getElementById('err-email').innerHTML='Chưa nhập E-mail.';
        document.getElementById('email').focus();
        submitOk=false;
    }else if (!validateEmail(document.getElementById('email').value)){
        document.getElementById('err-email').innerHTML='E-mail không hợp lệ.';
        document.getElementById('email').focus();
        submitOk=false;
    }

    if (isEmpty(document.getElementById('dob').value)){
        document.getElementById('err-dob').innerHTML='Ngày sinh chưa nhập.';
        document.getElementById('dob').focus();
        submitOk=false;
    }else if (!validateDate(document.getElementById('dob').value)){
        document.getElementById('err-dob').innerHTML='Ngày sinh không hợp lệ.';
        document.getElementById('dob').focus();
        submitOk=false;
    }

    if (isEmpty(document.getElementById('name').value)){
        document.getElementById('err-name').innerHTML='Chưa nhập tên.';
        document.getElementById('name').focus();
        submitOk=false;
    }

    if (submitOk)
        document.getElementById('register').submit();
}

function boQua(){
    location.reload();
}

