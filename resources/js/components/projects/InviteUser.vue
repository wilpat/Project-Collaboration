<template>
    <div class="card flex flex-col mt-4">
        <h3 class="font-normal text-xl py-6 border-l-4 border-blue-light -ml-5 pl-4">
            <p>Invite User</p>
        </h3>

        <form action="$project->path().'/invitations'" class="text-left" @submit.prevent="invite()">
            <div class="mb-3">
                <input type="email" class="px-3 py-2 border border-grey-light rounded w-full" placeholder="Email address." v-model="email">
            </div>
            <button class="text-xs button" type="submit" :disabled="working">
                {{ inviteText }}
            </button>
            <!-- @include('errors', ['bag' => 'invitations']) -->
            <template v-if="errors.email">
                <p class="text-red text-xs italic" role="alert" v-for="(error, index) in errors.email" :key="index">
                    <strong>{{ error }}</strong>
                </p>
            </template>
        </form>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex';
    import projectApi from '../../api/project';
    export default {
        name: 'InviteUser',
        props: {
            project: {
                type: Object
            }
        },

        data() {
            return {
                email: '',
                working: false,
                inviteText: 'Invite',
                errors: {}
            }
        },
        methods: {
            async invite() {
                let loader = this.$loading.show();
                this.inviteText = 'Please wait.';
                this.working = true;
                try {
                    let data ={
                        token: this.user.token,
                        email: this.email,
                        project_id: this.project.id
                    }
                    let response = await projectApi.inviteUser(data)
                    loader.hide();
                    this.inviteText = 'Invite';
                    this.working = false;
                    this.$emit('invited', response.data);
                    this.email = '';
                } catch (error) {
                    // console.log(error.message);
                    this.inviteText = 'Invite';
                    this.working = false;
                    if(error.message !== 'Network Error'){
                        this.errors = error.response.data.errors;
                    }
                    this.handleError(error,'',loader);
                }
            }
        },
        computed: {
            ...mapGetters('user',['user'])
        }
    }
</script>