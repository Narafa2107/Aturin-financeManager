<x-guest-layout>
    <div class="register-page">
        <div class="glow-top"></div>
        <div class="glow-bottom"></div>

```
    <div class="register-container">
        <div class="left-content">
            <img
                src="{{ asset('asset/logo.png') }}"
                alt="Aturin Logo"
                class="left-logo"
            >

            <h1 class="left-title">
                Welcome to <br>
                Aturin.
            </h1>

            <p class="left-description">
                A system that lets you plan your business activities efficiently.
            </p>
        </div>

        <div class="register-card">

            @if ($errors->any())
                <div class="mb-4 text-red-400">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter your username"
                        class="auth-input"
                        required
                    >
                </div>

                <div class="mb-4">
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
                    >
                </div>

                <div class="mb-4">
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

                <div class="mb-6">
                    <label class="form-label">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        class="auth-input"
                        required
                    >
                </div>

                <button
                    type="submit"
                    class="register-btn"
                >
                    Register
                </button>
            </form>

            <div class="text-center mt-5">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="underline ml-1">
                    Login
                </a>
            </div>
        </div>
    </div>
</div>
```

</x-guest-layout>
