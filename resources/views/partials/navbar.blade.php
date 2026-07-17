<nav class="navbar custom-navbar">

    <div class="navbar-left">

        <div class="brand-area">

            <h4 class="brand-title">

                🌍 Global Supply Chain Risk

            </h4>

            <small class="brand-subtitle">

                Real-Time Monitoring Dashboard

            </small>

        </div>

    </div>

    <div class="navbar-right">

        <div class="status-online">

            <span class="status-dot"></span>

            Online

        </div>

        <div class="user-box">

            <div class="user-avatar">

                {{ strtoupper(substr(Auth::user()->name,0,1)) }}

            </div>

            <div class="user-info">

                <span class="welcome">

                    Welcome

                </span>

                <strong>

                    {{ Auth::user()->name }}

                </strong>

            </div>

        </div>

        <form method="POST"
              action="{{ route('logout') }}">

            @csrf

            <button class="logout-btn">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </button>

        </form>

    </div>

</nav>