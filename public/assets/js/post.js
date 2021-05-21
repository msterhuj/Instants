function newPost() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", '/api/post', true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                alert(this.responseText);
                document.location.reload();
            } else {
                alert('Il y a eu un problème avec la requête.');
            }
        }
    }
    xhr.send("content=" + document.querySelector("#post-data").value);
}