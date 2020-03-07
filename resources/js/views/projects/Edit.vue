<template>
    <form 
        @submit.prevent
        class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-12 md:px-16 rounded shadow mt-6" 
    >
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit Project
        </h1>
        <app-form :buttonText="'Edit Project'" @submitted="submit" :project="project" :errors="errors"></app-form>
        
    </form>
</template>

<script>
import { mapGetters } from 'vuex';
import AppForm from '../../components/projects/Form.vue';
import projectApi from '../../api/project';

export default {
    name: 'project-edit',
    components : {
        AppForm
    },
    mounted () {
        this.getProject();
    },
    data () {
        return {
            project: {},
            errors: {}
        }
    },
    methods: {
        async getProject() {
            let loader = this.$loading.show();
            try {
                let data = {
                    token:this.user.token,
                    ...this.$route.params
                }
                let response = await projectApi.get(data);
                loader.hide();
                this.project = response.data;
            } catch (error) {
                // console.log(error);
                this.handleError(error, '', loader);
            }
        },
        async submit (project){
            let loader = this.$loading.show();
            try {
                await projectApi.update({token:this.user.token, ...project});
                loader.hide();
                this.$toast.success('Project updated!', '', this.notificationSystem.options.success);
                this.$router.push({name:'view', params:{id: this.project.id}});
            } catch (error) {
                // console.log(error);
                this.handleError(error, '', loader);
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