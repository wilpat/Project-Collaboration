<template>
    <form 
        @submit.prevent
        class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6" 
    >
        <h1 class="text-2xl font-normal mb-10 text-center">
            Let's start something new
        </h1>
        <app-form :buttonText="'Create Project'" @submitted="submit"></app-form>
        
    </form>
</template>

<script>
import { mapGetters } from 'vuex';
import AppForm from '../../components/projects/Form.vue';
import projectApi from '../../api/project';

export default {
    name: 'project-create',
    components : {
        AppForm
    },
    methods: {
        async submit (project){
            try {
                let response = await projectApi.create({token:this.user.token, ...project})
                if (response.status === 201) {
                    // this.projects = response.data;
                    console.log(response)
                } else if( response.status === 401 ) {
                    this.$router.push('login');
                }
            } catch (error) {
                console.log(error);
            }
        }
    },
    computed: {
        ...mapGetters('user', ['user'])
    }
}
</script>