function requestSearch(find, data, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", '/api/search', true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200)
                callback(this.responseText)
            else alert("Error Getting Posts")
        }
    }
    xhr.send("type=" + find + "&data=" + data);
}

const find = document.getElementById("dataList")

/*
 = -> post
 $ -> user
 */

find.onkeyup = function () {
    let find = "post"
    let data = document.getElementById("dataList").value
    if (data.charAt(0) === '$') find = "user"

    if (data.charAt(0) === '$' || data.charAt(0) === "=") data = data.substring(1)

    requestSearch(find, data, (result) => {
        let dl = document.getElementById("datalistOptions")
        dl.innerHTML = ''

        content = JSON.parse(result)
        console.log(content)

        for (let i  = 0; i < content.length; i++) {
            let op = document.createElement("option")

            if (find == "user") op.value = content[i].username
            else op.value = content[i].content

            dl.appendChild(op)
        }
    })
}