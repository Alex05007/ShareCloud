const filesView = document.getElementsByClassName("content")[0];
var curentFiles = 0;
function getExt(file) {
    file = file.toLowerCase();
    var ext = file.split(".");
    return ext[ext.length - 1];
}
function thub(th) {
    var thubs = document.getElementsByClassName("thub");
    for (var i = 0; i < thubs.length; i++)
        thubs[i].style.boxShadow = "inherit";
    thubs[th].style.boxShadow = "0px 0px 10px #FFF";
}
function refreshButtons() {
    if (curentFiles + 1 > maxFiles)
        document.getElementById("next").querySelector('svg').style.fill = "#999";
    else
        document.getElementById("next").querySelector('svg').style.fill = "#FFF";
    if (curentFiles - 1 < 0)
        document.getElementById("prev").querySelector('svg').style.fill = "#999";
    else
        document.getElementById("prev").querySelector('svg').style.fill = "#FFF";
}

function firstFile() {
    file = files[0];
    document.getElementById("download").setAttribute("href", id + "/" + file);
    document.getElementById("name").innerHTML = file;
    var ext = getExt(file);
    var showFile = document.createElement("div");
    if (ext == "jpg" || ext == "jpeg") {
        showFile.setAttribute("class", "file image");
        showFile.setAttribute("style", "background-image: url('" + id + "/" + file + "');");
    }
    document.getElementsByClassName("content")[0].appendChild(showFile);
    showFile.style.opacity = "1";
    thub(0);
}

function loadFile(file) {
    refreshButtons();
    thub(file);
    curentFiles = file;
    file = files[file];
    document.getElementById("download").setAttribute("href", id + "/" + file);
    document.getElementById("name").innerHTML = file;
    var ext = getExt(file);
    var showFile = document.createElement("div");
    if (ext == "jpg" || ext == "jpeg") {
        showFile.setAttribute("class", "file image");
        showFile.setAttribute("style", "background-image: url('" + id + "/" + file + "');");
    }
    document.getElementsByClassName("content")[0].appendChild(showFile);
    var prevFile = document.getElementsByClassName("file")[0];
    prevFile.style.opacity = "0";
    showFile.style.opacity = "1";
    setTimeout(function () {
        prevFile.remove();
    }, 200);
}

function next() {
    if (curentFiles < maxFiles) {
        curentFiles++;
        loadFile(curentFiles);
    }
}
function prev() {
    if (curentFiles > 0) {
        curentFiles--;
        loadFile(curentFiles);
    }
}