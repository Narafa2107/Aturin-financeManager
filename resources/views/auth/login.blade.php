<x-guest-layout>
    <div class="login-page">
        <div class="glow-top"></div>
        <div class="glow-bottom"></div>


    <div class="login-card">
        <div class="login-logo">
            <img
                src="{{ asset('asset/logo.png') }}"
                alt="Aturin Logo"
                class="logo-img"
            >
        </div>

        <h1 class="brand-title">
            Aturin
        </h1>

        <p class="brand-subtitle">
            Manajer bisnis anda
        </p>

        @if ($errors->any())
            <div class="mb-4 text-red-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    class="auth-input"
                    required
                    autofocus
                >
            </div>

            <div class="mb-5">
                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    class="auth-input"
                    required
                >
            </div>

            <button type="submit" class="login-btn">
                Login
            </button>
        </form>

        <div class="text-center mt-5">
            Belum punya akun?
            <a href="{{ route('register') }}" class="underline ml-1">
                Register
            </a>
        </div>
    </div>
</div>


</x-guest-layout>
