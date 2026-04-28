<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex justify-between items-center">
        <div>
            <a href="/">Idea</a>
        </div>

        <div class="flex gap-x-5 items-center">
            @auth
            <form action="/logout" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn">Logout</button>
            </form>
            @endauth

            @guest
            <a href="/login">Login</a>
            <a href="/register" class="btn">Register</a>
            @endguest
        </div>
    </div>
</nav>