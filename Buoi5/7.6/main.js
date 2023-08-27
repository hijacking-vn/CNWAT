const checkBoxs = document.getElementsByName("check");
let numOfCheckBox = checkBoxs.length;

for (let i = 0; i < numOfCheckBox; i++) {
    // Xử lý onchange
    checkBoxs[i].onchange = function () {
        if (this.checked) {
            this.parentNode.parentNode.classList.add("selectedr");
        } else {
            this.parentNode.parentNode.classList.remove("selectedr");
        }

        let checkedBox = document.getElementsByClassName("selectedr");
        if (checkedBox.length == numOfCheckBox) {
            document.getElementById('check-all').checked = true;
        } else {
            document.getElementById('check-all').checked = false;
        }
    }
}

// Xử lý check-all
document.getElementById("check-all").onchange = function() {
	for (let i = 0; i < numOfCheckBox; i++) {
		checkBoxs[i].checked = this.checked;
		if (checkBoxs[i].checked) checkBoxs[i].parentNode.parentNode.classList.add("selectedr");
		else checkBoxs[i].parentNode.parentNode.classList.remove("selectedr");		
	}
}