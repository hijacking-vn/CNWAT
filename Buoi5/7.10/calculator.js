let readOut = document.getElementById('read-out');
let flagNewNum = false;
let pendingOp = '';
let res = 0;

function pressedNum(num) {
    if (flagNewNum) {
        readOut.value = num;
        flagNewNum = false;
    } else {
        if (readOut.value == "0") {
            readOut.value = num;
        } else {
            readOut.value += num;
        }
    }
}

function operation(op) {
    let val = readOut.value;
    if (flagNewNum && pendingOp != "=") {

    } else {
        flagNewNum = true;
        switch (pendingOp) {
            case '+':
                res+=parseFloat(val);    
            break;
            case '-':
                res-=parseFloat(val);    
                break;
            case '*':
                res*=parseFloat(val);    
                break;
            case '/':
                res/=parseFloat(val);    
                break;
            default:
                res=parseFloat(val);
        }
        readOut.value = res;
        pendingOp=op;
    }
}

function decimal() {
    if (flagNewNum) {
        readOut.value = "0.";
        flagNewNum = false;
    } else if (readOut.value.indexOf(".") == -1) {
        readOut.value += ".";
    }
}

function neg() {
    readOut.value = parseFloat(readOut.value) * (-1);
}

function percent() {
    if (res == 0) {
        res = 1;
    }
    readOut.value = parseFloat(res) * parseFloat(readOut.value) / 100;
}

function clearEntry() {
    readOut.value = "0";
    flagNewNum = true;
}

function clear() {
    res = 0;
    pendingOp = "";
    clearEntry();
}