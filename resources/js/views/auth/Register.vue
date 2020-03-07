<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>

                    <div>
                        <form 
                            @submit.prevent="register()"
                            class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6"
                        >
                            <h1 class="text-2xl font-normal mb-10 text-center">
                                Register
                            </h1>

                            <div class="field mb-6">
                                <label for="name" class="label text-sm mb-2 block">Name</label>

                                <div class="control">
                                    <input 
                                        id="name" 
                                        type="text" 
                                        class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full"
                                        :class="{'border-red' : errors.name }" 
                                        name="name" 
                                        v-model="credentials.name" 
                                        required 
                                        autofocus
                                    >

                                    <template v-if="errors.name">
                                        <span class="text-red text-xs italic" role="alert" v-for="(error, index) in errors.name" :key="index">
                                            <strong>{{ error}}</strong>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <div class="field mb-6">
                                <label for="email" class="label text-sm mb-2 block">E-Mail Address</label>

                                <div class="control">
                                    <input 
                                        id="email" 
                                        type="email" 
                                        class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full"
                                        :class="{'border-red' : errors.email }" 
                                        name="email" 
                                        v-model="credentials.email" 
                                        required
                                    >

                                    <template v-if="errors.email">
                                        <span class="text-red text-xs italic" role="alert" v-for="(error, index) in errors.email" :key="index">
                                            <strong>{{ error }}</strong>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <div class="field mb-6">
                                <label for="password" class="label text-sm mb-2 block">Password</label>

                                <div class="control">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full"
                                        :class="{'border-red' : errors.password }" 
                                        v-model="credentials.password"
                                        name="password" 
                                        required
                                    >

                                    <template v-if="errors.password">
                                        <span class="text-red text-xs italic" role="alert" v-for="(error, index) in errors.password" :key="index">
                                            <strong>{{ error }}</strong>
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <div class="field mb-6">
                                <label for="password-confirm" class="label text-sm mb-2 block">Confirm Password</label>

                                <div class="control">
                                    <input 
                                        id="password-confirm" 
                                        type="password" 
                                        class="input bg-transparent border border-grey-light rounded p-2 text-ws w-full"
                                        :class="{'border-red' : errors.password }" 
                                        v-model="credentials.password_confirmation"
                                        name="password_confirmation" 
                                        required
                                    >
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="button" :disabled="working">
                                    {{ buttonText }}
                                </button>
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
    name: 'user-register',
    data () {
        return {
            credentials: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: {
                
            },
            working: false,
            buttonText: 'Register'
        }
    },
    methods: {
    //   ...mapActions('user', ['clearUserError', 'addUser']),
        ...mapActions('user', ['addUser', 'clearUserError']),
        async register(){
            this.buttonText= 'Please wait...';
            this.working = true;
            let loader = this.$loading.show();
            try {
                let response = await userApi.register(this.credentials);
                loader.hide();
                this.buttonText= 'Redirecting...';
                this.working = false;
                // console.log(response)
                let user = this.cleanObject(response.data.user);
                user.token = response.data.access_token;
                this.addUser(user)
                this.clearUserError()
                this.$toast.success('Registration successful.', '', this.notificationSystem.options.success)
                this.$router.push('/projects')
            } catch (error) {
                // console.log(error.response)
                this.buttonText= 'Register.';
                this.working = false;
                if(error.message !== 'Network Error'){
                    this.errors = error.response.data.errors;
                }
                this.handleError(error, '', loader);
            }
        }
    }
}
</script>