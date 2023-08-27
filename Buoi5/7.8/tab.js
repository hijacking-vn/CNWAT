frm = document.getElementById('my-frame');
tabs = document.getElementsByClassName('tab');

currTab = null;

for (let tab of tabs){
    tab.onclick = function(){
        if (currTab!=null){
            currTab.classList.remove('selected');
        }

        currTab = this;
        currTab.classList.add('selected');

        switch (currTab.id){
            case 'tab1':
                frm.src = 'https://www.cgv.vn/';
                break;
            case 'tab2':
                frm.src = 'https://www.galaxycine.vn/';
                break;
            case 'tab3':
                frm.src = 'http://betacinemas.vn/';
                break;
            case 'tab4':
                frm.src = 'https://www.lottecinemavn.com/';
                break;
        }
    }
}
