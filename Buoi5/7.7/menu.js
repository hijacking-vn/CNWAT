const liTagList = document.getElementsByTagName('li');
const tooltip = document.getElementById('tooltip');

for (let i = 0; i < liTagList.length; i++) {
    liTagList[i].onmouseover = function (e) {
        tooltip.style.display = 'block';
        // Đặt vị trí tooltip theo vị trí chuột
        tooltip.style.left = (e.clientX + 10) + 'px';
        // Đặt vị trí tooltip theo vị trí chuột
        tooltip.style.top = (e.clientY + 20) + 'px';
        // Hiển thị nội dung của <li> trong tooltip
        tooltip.textContent = e.target.textContent;
    }

    liTagList[i].onmouseout = function () {
        // Ẩn tooltip khi con chuột rời khỏi <li>
        tooltip.style.display = 'none';
    }

    liTagList[i].onclick = function () {
        for (let j = 0; j < liTagList.length; j++) {
            if (j == i) {
                liTagList[j].classList.add('selected');
                document.getElementById('page-title').style.display = 'block';
                document.getElementById('page-title').innerHTML = liTagList[i].textContent;
            } else {
                liTagList[j].classList.remove('selected');
            }
        }
    }
}
