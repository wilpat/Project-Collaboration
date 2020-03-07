<template>
    <div>
        <header class="py-4">

            <div class="flex items-end justify-between">
                
                <h2 class="text-grey text-sm font-normal">My Projects</h2>
                <router-link class ="button" :to="{ name: 'create' }">New Project</router-link>
                <!-- <a href="/projects/create" class="button">New Project</a> -->
            </div>

        </header>
        
        <main class="lg:flex lg:flex-wrap -mx-3">
            <template v-if="projects.length > 0">
                <div class="lg:w-1/3 px-3 pb-6" v-for="(project, index) in projects" :key="index">
                    <card :project='project' @deleteProject="deleteProject"></card>
                </div>
            </template>
            <template v-else-if="projects.length == 0 && !working">
                <div class="flex flex-col w-full justify-center mt-12 text-center">
                    <p class="text-3xl">{{ emptyMessage }}</p>
                </div>
            </template>
           
        </main>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import projectApi from '../../api/project';

import Card from '../../components/projects/Card.vue';
export default {
    name: 'project-index',
    mounted() {
        this.fetchProjects();
    },
    data() {
        return {
            projects: [],
            working: true
        }
    },
    components: {
        Card
    },
    methods: {
        async fetchProjects() {
            let loader = this.$loading.show();
            try {
                let response = await projectApi.all({token:this.user.token})
                loader.hide();
                this.working = false;
                this.projects = response.data;
            } catch (error) {
                // console.log(error);
                this.working = false;
                this.handleError(error, '', loader);
            }
        },
        async deleteProject(id) {
            try {
                let data = {
                    token:this.user.token,
                    id
                }
                let response = await projectApi.delete(data)
                // console.log(response);
                this.$toast.warning(`${response.data.title.slice(0,15)} project deleted.`, '', this.notificationSystem.options.warning);
                this.fetchProjects();
            } catch (error) {
                // console.log(error);
                this.handleError(error);
            }
        }
    },
    computed: {
        ...mapGetters('user', ['user'])
    }
}
</script>