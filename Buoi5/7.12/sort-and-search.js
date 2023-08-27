let col = 0;
let dir = "";
let table = document.getElementById("data-table");

// sort by product code
table.rows[0].cells[1].onclick = function () {
    if (col != 0) {
        // col = 1 or 2
        table.rows[0].cells[col].classList.remove(dir);
    }

    if (col == 1) {
        dir = (dir == 'asc' ? 'desc' : 'asc');
    } else {
        col = 1;
        dir = "asc";
    }

    this.classList.add(dir);
    tableSort();
}

// sort by product name
table.rows[0].cells[2].onclick = function () {
    if (col != 0) {
        // col = 1 or 2
        table.rows[0].cells[col].classList.remove(dir);
    }

    if (col == 1) {
        dir = (dir == 'asc' ? 'desc' : 'asc');
    } else {
        col = 2;
        dir = "asc";
    }

    this.classList.add(dir);
    tableSort();
}

// bubble sort
function tableSort() {
    let rows = table.rows;
    for (let i = 1; i < rows.length; i++) {
        for (let j = i + 1; j < rows.length; j++) {
            if ((dir == 'asc' && rows[i].cells[col].innerHTML.toLowerCase() > rows[j].cells[col].innerHTML.toLowerCase())
                || (dir == 'desc' && rows[i].cells[col].innerHTML.toLowerCase() < rows[j].cells[col].innerHTML.toLowerCase())) {
                // swap
                tmp = rows[i].cells[1].innerHTML;
                rows[i].cells[1].innerHTML = rows[j].cells[1].innerHTML;
                rows[j].cells[1].innerHTML = tmp;

                tmp = rows[i].cells[2].innerHTML;
                rows[i].cells[2].innerHTML = rows[j].cells[2].innerHTML;
                rows[j].cells[2].innerHTML = tmp;
            }
        }
    }
}

// search keyword
const searchInput = document.getElementById('search');

searchInput.onkeyup = function(e){
    if (e.keyCode==13){
        let searchKey = searchInput.value.toLowerCase();
        tableSearch(searchKey);
    }
}

function tableSearch(searchText){
    for (let i=1; i <table.rows.length; i++){
        let row = table.rows[i];
        let found = false;

        for (let j=1; j<row.cells.length; j++){
            let cell = row.cells[j];
            let cellText = cell.textContent.toLowerCase();
        
            if (cellText.includes(searchText)) {
                cell.innerHTML = cell.innerHTML.replace(
                    new RegExp(searchText, 'gi'),
                    (match) => `<span class="highlight">${match}</span>`
                );
                found = true;
            }
        }
        
        if (found) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
}