<nav>
    <a href="/">Home</a>
    <a href="/books">Books</a>
    @auth
        <a href="/logout">Logout</a>
    @endauth
    @guest
        <a href="/login">Login</a>
        <a href="/register">Register</a>
    @endguest
</nav>
