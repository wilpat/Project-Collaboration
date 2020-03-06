<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>

                    <div>
                        <form 
                            method="POST"
                            @submit.prevent="login()"
                            class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6"
                        >
                            <h1 class="text-2xl font-normal mb-10 text-center">
                                <!-- {{ __('Login') }} -->
                                Login
                            </h1>
                            <!-- @csrf -->

                            <div class="field mb-6">
                                <label for="email" class="label text-sm mb-2 block">E-Mail Address</label>

                                <div class="control">
                                    <input 
                                        id="email" 
                                        type="email" 
                                        class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full"
                                        :class="{'border-red': error.email}"
                                        name="email" 
                                        v-model="credentials.email"
                                        required autofocus
                                    >

                                    <!-- @if ($errors->has('email')) -->
                                        <span class="text-red text-xs italic" role="alert" v-if="error.email">
                                            <!-- <strong>{{ $errors->first('email') }}</strong> -->
                                            <strong>Email error</strong>
                                        </span>
                                    <!-- @endif -->
                                </div>
                            </div>

                            <div class="field mb-6">
                                <label for="password" class="label text-sm mb-2 block">Password</label>

                                <div class="col-md-6">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full" 
                                        :class="{'border-red': error.password}"
                                        name="password" 
                                        required
                                        v-model="credentials.password"
                                    >

                                    <!-- @if ($errors->has('password')) -->
                                        <span class="text-red text-xs italic" role="alert" v-if="error.password">
                                            <!-- <strong>{{ $errors->first('password') }}</strong> -->
                                            <strong>Password Error</strong>
                                        </span>
                                    <!-- @endif -->
                                </div>
                            </div>

                            <div class="mb-6">
                                <!-- <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> -->
                                <input class="" type="checkbox" name="remember" id="remember">

                                <label class="label text-sm mb-2" for="remember">
                                    Remember Me
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="button">
                                    Login
                                </button>

                                <!-- @if (Route::has('password.request')) -->
                                    <!-- <a class="no-underline" href="{{ route('password.request') }}"> -->
                                    <a class="no-underline" href="">
                                        Forgot Your Password?
                                    </a>
                                <!-- @endif -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import userApi from '../../api/user'
import {mapActions, mapGetters} from 'vuex'
export default {
    name: 'user-login',
    mounted() {
        
    },
    data() {
        return {
            credentials: {
                email: '',
                password: ''
            },
            error: {
                email: false,
                password: false
            }
        }
    },
    methods: {
      ...mapActions('user', ['clearUserError', 'addUser']),
        async login() {
            try {
                let response = await userApi.userLogin(this.credentials);
                if (response.status === 200) {
                    // console.log(response.data)
                    let user = this.cleanObject(response.data.user);
                    user.token = response.data.access_token;
                    this.addUser(user)
                    userApi.setToken(user.token)
                    this.clearUserError()
                    const destination = this.$route.query.redirect;
                    if(typeof destination !== 'undefined'){
                        this.$router.push(destination);
                    } else {
                        this.$router.push('/projects')
                    }
                    
                } else {
                    // this.$toast.error(response.data.message, '', this.notificationSystem.options.error)
                    return false
                }
            } catch (error) {
                console.error(error)
            }
        }
    }
}
</script>