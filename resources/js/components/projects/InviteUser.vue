<template>
    <div class="card flex flex-col mt-4">
        <h3 class="font-normal text-xl py-6 border-l-4 border-blue-light -ml-5 pl-4">
            <p>Invite User</p>
        </h3>

        <form action="$project->path().'/invitations'" class="text-left" @submit.prevent="invite()">
            <div class="mb-3">
                <input type="email" class="px-3 py-2 border border-grey-light rounded w-full" placeholder="Email address." v-model="email">
            </div>
            <button class="text-xs button" type="submit">
                Invite
            </button>
            <!-- @include('errors', ['bag' => 'invitations']) -->
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
                email: ''
            }
        },
        methods: {
            async invite() {
                try {
                    let data ={
                        token: this.user.token,
                        email: this.email,
                        project_id: this.project.id
                    }
                    let response = await projectApi.inviteUser(data)
                    // console.log(response)
                    if (response.status === 200) {
                        this.email = '';
                        this.$emit('invited', response.data);
                    } else if( response.status === 401 ) {
                        this.$router.push('login');
                    }
                } catch (error) {
                    console.log(error);
                }
            }
        },
        computed: {
            ...mapGetters('user',['user'])
        }
    }
</script>