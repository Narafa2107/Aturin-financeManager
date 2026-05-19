@extends('layouts.app')

@section('content')

<div class="register-page">

    <div class="glow-top"></div>

    <div class="glow-bottom"></div>



    <div class="register-container">

        <!-- LEFT -->

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



        <!-- REGISTER CARD -->

        <div class="register-card">

            <form>

                <div class="mb-4">

                    <label class="form-label">
                        Username
                    </label>

                    <input
                        type="text"
                        placeholder="Enter your username"
                        class="form-input"
                    >

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        placeholder="Enter your email"
                        class="form-input"
                    >

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        placeholder="Enter your password"
                        class="form-input"
                    >

                </div>



                <div class="mb-6">

                    <label class="form-label">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        placeholder="Confirm your password"
                        class="form-input"
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

                <a
                    href="/"
                    class="underline ml-1"
                >

                    Login

                </a>

            </div>

        </div>

    </div>

</div>

@endsection