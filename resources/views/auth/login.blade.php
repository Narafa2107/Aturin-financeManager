@extends('layouts.app')

@section('content')

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



        <form>

            <div class="mb-5">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    placeholder="Enter your email"
                    class="form-input"
                >

            </div>



            <div class="mb-5">

                <label class="form-label">
                    Password
                </label>

                <input
                    type="password"
                    placeholder="Enter your password"
                    class="form-input"
                >

            </div>



            <button class="login-btn">

                Login

            </button>

        </form>



        <div class="text-center mt-5">

            Belum punya akun?

            <a
                href="/register"
                class="underline ml-1"
            >

                Register

            </a>

        </div>

    </div>

</div>

@endsection