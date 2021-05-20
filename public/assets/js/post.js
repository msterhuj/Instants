function newPost() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", '/api/post', true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () { //Appelle une fonction au changement d'état.
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                alert(this.responseText);
            } else {
                alert('Il y a eu un problème avec la requête.');
            }
        }
    }
    xhr.send("content=text");
}