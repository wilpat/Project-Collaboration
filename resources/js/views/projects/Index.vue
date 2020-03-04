<template>
    <div>
        <header class="py-4">

            <div class="flex items-end justify-between">
                
                <h2 class="text-grey text-sm font-normal">My Projects</h2>

                <a href="/projects/create" class="button">New Project</a>
            </div>

        </header>
        
        <main class="lg:flex lg:flex-wrap -mx-3">
            <template v-if="projects.length > 0">
                <div class="lg:w-1/3 px-3 pb-6" v-for="(project, index) in projects" :key="index">
                    <card :project='project' @deleteProject="deleteProject"></card>
                </div>
            </template>
            <template v-else>
                <li>No projects at the moment</li>
            </template>
           
        </main>
    </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import projectApi from '../../api/project';

import Card from '../../components/projects/Card.vue';
export default {
    name: 'project-index',
    mounted() {
        this.fetchProjects();
    },
    data() {
        return {
            projects: []
        }
    },
    components: {
        Card
    },
    methods: {
        async fetchProjects() {
            try {
                let response = await projectApi.allProjects({token:this.user.token})
                if (response.status === 200) {
                    this.projects = response.data;
                } else if( response.status === 401 ) {
                    this.$router.push('login');
                }
            } catch (error) {
                console.log(error);
            }
        },
        async deleteProject(id) {
            // console.log(id);
            try {
                let data = {
                    token:this.user.token,
                    id
                }
                let response = await projectApi.deleteProject(data)
                if (response.status === 200) {
                    this.fetchProjects();
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