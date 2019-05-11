@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>

                <div>
                    <form 
                        method="POST"
                        action="{{ route('login') }}"
                        class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6"
                    >
                        <h1 class="text-2xl font-normal mb-10 text-center">
                            {{ __('Login') }}
                        </h1>
                        @csrf

                        <div class="field mb-6">
                            <label for="email" class="label text-sm mb-2 block">{{ __('E-Mail Address') }}</label>

                            <div class="control">
                                <input 
                                    id="email" 
                                    type="email" 
                                    class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full{{ $errors->has('email') ? ' border-red' : '' }}" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required autofocus
                                >

                                @if ($errors->has('email'))
                                    <span class="text-red text-xs italic" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="field mb-6">
                            <label for="password" class="label text-sm mb-2 block">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input 
                                    id="password" 
                                    type="password" 
                                    class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full{{ $errors->has('password') ? ' border-red' : '' }}" 
                                    name="password" 
                                    required
                                >

                                @if ($errors->has('password'))
                                    <span class="text-red text-xs italic" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-6">
                            <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="label text-sm mb-2" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="button">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="no-underline" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
