<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="icon" href="{{ asset('images/favicon.jpg') }}" type="image/x-icon">

    @vite(['resources/css/app.css','resources/js/app.js', 'resources/js/js.js'])

    <style>
        body{
           background-color: #f6f9ff;
        }
    </style>
</head>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                                <img src="{{ asset('images/logo3.png') }}" style="height: 25vh;" alt="Advantech logo">
                        </div><!-- End Logo -->

                        <div class="card mb-3 mt-0">

                            <div class="card-body">
                                @if (session('alert'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        {{ session('alert') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @elseif (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="pt-1 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <x-form-error name="err"></x-form-error>
                                </div>

                                <form class="row g-3 needs-validation" method="POST" action="/login">
                                    @csrf

                                    <div class="col-12">
                                        <label for="username" class="form-label">Username</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="username" class="form-control" value={{ old('username') }}>
                                        </div>
                                        <x-form-error name="username"></x-form-error>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control">
                                        <x-form-error name="password"></x-form-error>
                                    </div>

                                    <div class="col-12">

                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
