function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function switchTheme() {
    let now = new Date();
    let time = now.getTime();
    let expireTime = time + 1000*36000;
    now.setTime(expireTime);
    if (getCookie("THEME") !== "dark") document.cookie = 'THEME=dark;expires='+now.toUTCString()+';path=/';
    else document.cookie = 'THEME=light;expires='+now.toUTCString()+';path=/';
    document.location.reload();
}

function currentTheme() {
    return getCookie("THEME");
}

function updateIconTheme() {
    if (currentTheme() === "dark") document.getElementById("theme-icon").className = "bi-moon";
    else document.getElementById("theme-icon").className = "bi-sun";
}

updateIconTheme();