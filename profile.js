function checkCheckBoxes(theForm) {
	if (
	theForm.standard.checked == false &&
	theForm.deluxe.checked == false &&
	theForm.suite.checked == false) 
	{
		alert ('You didn\'t choose any of the room types');
		return false;
	} else { 	
		return true;
	}
}

function standardEnable() {
    var standardImgs = document.getElementsByClassName("standardImages");
    if (document.getElementById("standard").checked){
        document.getElementById("standardPrice").disabled = false;
        for (var i = 0; i < standardImgs.length; i++) {
            standardImgs.item(i).disabled = false;
        }
    } else {
        document.getElementById("standardPrice").disabled = true;
        for (var i = 0; i < standardImgs.length; i++) {
            standardImgs.item(i).disabled = true;
        }
    }
}

function deluxeEnable() {
    var deluxeImgs = document.getElementsByClassName("deluxeImages");
    if (document.getElementById("deluxe").checked){
        document.getElementById("deluxePrice").disabled = false;
        for (var i = 0; i < deluxeImgs.length; i++) {
            deluxeImgs.item(i).disabled = false;
        }
    } else {
        document.getElementById("deluxePrice").disabled = true;
        for (var i = 0; i < deluxeImgs.length; i++) {
            deluxeImgs.item(i).disabled = true;
        }
    }
}

function suiteEnable() {
    var suiteImgs = document.getElementsByClassName("suiteImages");
    if (document.getElementById("suite").checked){
        document.getElementById("suitePrice").disabled = false;
        for (var i = 0; i < suiteImgs.length; i++) {
            suiteImgs.item(i).disabled = false;
        }
    } else {
        document.getElementById("suitePrice").disabled = true;
        for (var i = 0; i < suiteImgs.length; i++) {
            suiteImgs.item(i).disabled = true;
        }
    }
}

function imageChange() {
    if (document.getElementById("imgSrc").value == "view") {
        var divsToHide = document.getElementsByClassName("gallery");
        for(var i = 0; i < divsToHide.length; i++){
            divsToHide[i].style.display = "none";
        }
        document.getElementById("mainGallery").style.display = "";
    }
    if (document.getElementById("imgSrc").value == "standardImg") {
        var divsToHide = document.getElementsByClassName("gallery");
        for(var i = 0; i < divsToHide.length; i++){
            divsToHide[i].style.display = "none";
        }
        document.getElementById("standardGallery").style.display = "";
    }
    if (document.getElementById("imgSrc").value == "deluxeImg") {
        var divsToHide = document.getElementsByClassName("gallery");
        for(var i = 0; i < divsToHide.length; i++){
            divsToHide[i].style.display = "none";
        }
        document.getElementById("deluxeGallery").style.display = "";
    }
    if (document.getElementById("imgSrc").value == "suiteImg") {
        var divsToHide = document.getElementsByClassName("gallery");
        for(var i = 0; i < divsToHide.length; i++){
            divsToHide[i].style.display = "none";
        }
        document.getElementById("suiteGallery").style.display = "";
    }
}
