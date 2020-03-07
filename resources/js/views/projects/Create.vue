<template>
    <form 
        @submit.prevent
        class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6" 
    >
        <h1 class="text-2xl font-normal mb-10 text-center">
            Let's start something new
        </h1>
        <app-form :buttonText="'Create Project'" @submitted="submit" :errors="errors"></app-form>
        
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
    data () {
        return {
            project: {},
            errors: {}
        }
    },
    methods: {
        async submit (project){
            let loader = this.$loading.show();
            try {
                let response = await projectApi.create({token:this.user.token, ...project});
                loader.hide()
                this.project = response.data;
                this.$router.push({name:'view', params:{id: this.project.id}});
            } catch (error) {
                // console.log(error);
                this.handleError(error,'', loader);
                if(error.message !== 'Network Error'){
                    this.errors = error.response.data.errors;
                }
            }
        }
    },
    computed: {
        ...mapGetters('user', ['user'])
    }
}
</script>