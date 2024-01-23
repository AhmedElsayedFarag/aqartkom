@extends('../admin/layout/login')

@section('head')
    <title>Forgot password - Aqaratcom</title>
@endsection

@section('content')
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                    <span class="text-white text-lg ml-3">
                        Rubick
                    </span>
                </a>
                <div class="my-auto">
                    <img alt="Rubick Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16"
                        src="{{ asset('dist/images/illustration.svg') }}">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">A few more clicks to <br> sign
                        in to your account.</div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-slate-400">Manage all your
                        e-commerce accounts in one place</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div
                    class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">Forgot your password</h2>
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">Please enter your email address to
                        recieve reset link .</div>
                    <div class="intro-x mt-8">
                        <form id="login-form" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <input id="email" type="text" class="intro-x login__input form-control py-3 px-4 block"
                                placeholder="hello@example.com"  name="email">
                            @error('email')
                                <div id="error-email" class="login__input-error text-danger mt-2">
                                    {{ $errors->first('email') }}
                                </div>
                            @enderror
                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button type="submit" id="btn-login"
                                    class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                    Send reset link
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
@endsection

