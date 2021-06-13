function sendMSGAJAX(id) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", '/messages/' + id, true);

    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                console.log(this.responseText)
                document.getElementById("msgdata").value = ''
            }
            else alert("Error Getting Posts")
        }
    }
    xhr.send("id=" + id + "&msg=" + document.getElementById("msgdata").value);
}

function fetch(id, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", '/messages/' + id + "/fetch", true);

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200)
                callback(this.responseText)
            else alert("Error Getting Posts")
        }
    }
    xhr.send();
}

let user_recv = document.getElementById("msgid").value

setInterval(() => {
    fetch(user_recv, (result) => {
        let chat = document.getElementById("message_list")
        chat.innerText = ''

        let data = JSON.parse(result)
        for (let i = 0; i < data.length; i++) {
            let user = document.createElement("a")
            if (user_recv !== data[i].receiver) {
                user.innerText = document.getElementById("author").value
                user.href = "/p/" + user.innerText
            } else user.innerText = "vous"

            let msg = document.createElement("p")
            msg.innerText = data[i].content

            chat.appendChild(user)
            chat.appendChild(msg)
        }
    })
}, 500)