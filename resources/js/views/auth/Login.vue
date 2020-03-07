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
                                        :class="{'border-red': errors.email}"
                                        name="email" 
                                        v-model="credentials.email"
                                        required autofocus
                                    >

                                    <template v-if="errors.email">
                                        <span class="text-red text-xs italic" role="alert" v-for="(error, index) in errors.email" :key="index">
                                            <strong>{{ email }}</strong>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <div class="field mb-6">
                                <label for="password" class="label text-sm mb-2 block">Password</label>

                                <div class="col-md-6">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full" 
                                        :class="{'border-red': errors.password}"
                                        name="password" 
                                        required
                                        v-model="credentials.password"
                                    >

                                    <template v-if="errors.password">
                                        <span class="text-red text-xs italic" role="alert" v-for="(error, index) in errors.password" :key="index">
                                            <strong>{{ error }}</strong>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <div class="mb-6">
                                <!-- <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> -->
                                <!-- <input class="" type="checkbox" name="remember" id="remember"> 

                                <label class="label text-sm mb-2" for="remember">
                                    Remember Me
                                </label>-->
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="button" :disabled="working">{{ loginText }}</button>

                                <!-- @if (Route::has('password.request')) -->
                                    <!-- <a class="no-underline" href="{{ route('password.request') }}"> -->
                                    <!-- <a class="no-underline" href="">
                                        Forgot Your Password?
                                    </a> -->
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
                password: '',
            },
            working: false,
            loginText: 'Login',
            errors: {}
        }
    },
    methods: {
      ...mapActions('user', ['clearUserError', 'addUser']),
        async login() {
            this.loginText='Please wait...';
            this.working =true;
            try {
                let response = await userApi.login(this.credentials);
                this.working = false;
                let user = this.cleanObject(response.data.user);
                user.token = response.data.access_token;
                this.addUser(user)
                userApi.setToken(user.token)
                this.clearUserError()
                const destination = this.$route.query.redirect;
                this.loginText='Redirecting...';
                this.$toast.success('Login Successful.', 'OK', this.notificationSystem.options.error)

                if(typeof destination !== 'undefined'){
                    this.$router.push(destination);
                } else {
                    this.$router.push('/projects')
                }
            } catch (error) {
                this.working = false;
                this.loginText='Login';
                // console.log(error.response);
                this.handleError(error, 'Invalid credentials.');
            }
        }
    }
}
</script>