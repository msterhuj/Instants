<form method="post" action="/login">
    <label for="username">Username</label>
    <input id="username" name="username" type="text">

    <label for="pass">Password</label>
    <input id="pass" name="pass" type="password">

    <input name="csrf" value="{{ CSRF }}" hidden>

    <button type="submit">login !</button>
</form>