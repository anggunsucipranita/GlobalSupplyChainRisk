<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm border-bottom border-secondary">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold text-light" href="/">
            🌍 Global Supply Chain Risk
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">

            <span class="badge bg-success">
                ● Online
            </span>

            <span class="text-light">
                Hello, {{ Auth::user()->name }} 
            </span>

            <form method="POST" action="{{ route('logout') }}" class="d-inline">

    @csrf

    <button type="submit" class="btn btn-outline-light">

        Logout

    </button>

</form>

        </div>

    </div>

</nav>