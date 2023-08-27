function validation() {
    let mhs = document.getElementById('ma-hoc-sinh').value;
    let hoTen = document.getElementById('ho-ten').value;
    let ngaySinh = document.getElementById('ngay-sinh').value;
    let diaChi = document.getElementById('dia-chi').value;
    let lop = document.getElementById('lop').value;
    let dToan = document.getElementById('diem-toan').value;
    let dLy = document.getElementById('diem-ly').value;
    let dHoa = document.getElementById('diem-hoa').value;

    let submitOK = true;
    document.getElementById('err-ma-hoc-sinh').innerHTML='';
    document.getElementById('err-ho-ten').innerHTML='';
    document.getElementById('err-ngay-sinh').innerHTML='';
    document.getElementById('err-dia-chi').innerHTML='';
    document.getElementById('err-lop').innerHTML='';
    document.getElementById('err-diem-toan').innerHTML='';
    document.getElementById('err-diem-ly').innerHTML='';
    document.getElementById('err-diem-hoa').innerHTML='';

    if (mhs.length <= 0 || mhs.length > 8) {
        document.getElementById('err-ma-hoc-sinh').innerHTML += 'Mã học sinh không được để trống, tối đa 8 ký tự<br>';
        submitOK = false;
    }
    if (hoTen.length <= 0 || hoTen.length > 50) {
        document.getElementById('err-ho-ten').innerHTML= 'Họ tên không được để trống, tối đa 50 ký tự<br>';
        submitOK = false;
    }
    if (isNaN(new Date(ngaySinh))) {
        document.getElementById('err-ngay-sinh').innerHTML= 'Ngày không hợp lệ.<br>';
        submitOK = false;
    }
    if (diaChi.length <= 0 || diaChi.length > 150) {
        document.getElementById('err-dia-chi').innerHTML= 'Địa chỉ không được để trống, tối đa 150 ký tự<br>';
        submitOK = false;
    }
    if (lop.length <= 0 || lop.length > 6) {
        document.getElementById('err-lop').innerHTML= 'Lớp không được để trống, tối đa 6 ký tự<br>';
        submitOK = false;
    }

    if (dToan.length==0 || !isFloat(dToan)) {
        document.getElementById('err-diem-toan').innerHTML= 'Điểm toán không được để trống, phải là số thực.<br>';
        submitOK = false;
    }else{
        let dToanVal =  parseFloat(dToan);
        if (dToanVal<0 || dToanVal>10){
            document.getElementById('err-diem-toan').innerHTML= 'Điểm toán phải trong khoảng [0; 10]<br>';
            submitOK = false;
        }
    }
    if (dHoa.length==0 || !isFloat(dHoa)) {
        document.getElementById('err-diem-hoa').innerHTML= 'Điểm hóa không được để trống, phải là số thực.<br>';
        submitOK = false;
    }else{
        let dHoaVal =  parseFloat(dHoa);
        if (dHoaVal<0 || dHoaVal>10){
            document.getElementById('err-diem-hoa').innerHTML= 'Điểm hóa phải trong khoảng [0; 10]<br>';
            submitOK = false;
        }
    }
    if (dLy.length==0 || !isFloat(dLy)) {
        document.getElementById('err-diem-ly').innerHTML= 'Điểm lý không được để trống, phải là số thực.<br>';
        submitOK = false;
    }else{
        let dTLyVal =  parseFloat(dLy);
        if (dTLyVal<0 || dTLyVal>10){
            document.getElementById('err-diem-lý').innerHTML= 'Điểm lý phải trong khoảng [0; 10]<br>';
            submitOK = false;
        }
    }
    if (submitOK) submit();
}

function isFloat(num){
    const regex = /^-?\d+(\.\d+)?$/;
    return regex.test(num);
}