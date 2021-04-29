<form method="post" action="/signup">
    <label for="username">Username</label>
    <input id="username" name="username" type="text">

    <label for="email">email</label>
    <input id="email" name="email" type="email">

    <label for="pass">Password</label>
    <input id="pass" name="pass" type="password">

    <label for="vpass">Retype Password</label>
    <input id="vpass" name="vpass" type="password">

    <label for="born">Enter born Date</label>
    <input id="born" name="born" type="date">

    <input name="csrf" value="{{ CSRF }}" hidden>

    <button type="submit">Register !</button>
</form>