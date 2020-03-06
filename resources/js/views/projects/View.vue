<template>
     <div v-if="project.id">
       <header class="py-4">

            <div class="flex items-end justify-between">
                
                <p class="text-grey text-sm font-normal">
                    <a href="/projects" class="no-underline text-grey">My Projects</a> / {{ project.title }}
                </p>

                <div class="flex items-center">
                    <!-- @foreach ($project->users as $user) -->
                    <template v-if="project.users">
                        <img 
                        v-for ="(user, index) in project.users"
                        :key="index"
                        :src="gravatar(user.email)" 
                        :alt="user.name"
                        class="rounded-full w-8 mr-2">
                    </template>
                    <!-- @endforeach -->

                    <img 
                        :src="gravatar(project.user.email) " 
                        :alt="project.user.name"
                        class="rounded-full w-8 mr-2">
                    <a :href="`/projects/${ project.id }/edit`" class="button ml-4">Edit Project</a>
                </div>
            </div>

        </header>

        <main>
            <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3">
                    <div class="mb-8">

                        <h2 class="text-grey font-normal text-lg mb-3">Tasks</h2>
                        <div class="card mb-3" v-for="(task, index) in project.tasks" :key="index">
                            <form @submit.prevent="updateTask(task)">
                                <!-- @method('PATCH') -->
                                <!-- @csrf -->
                                <div class="flex">
                                    <input 
                                        class="w-full"
                                        :class="{ 'text-grey' : task.completed }" 
                                        type="text" name="body" 
                                        v-model="task.body" /> 
                                    <input type="checkbox" name="completed" v-model="task.completed" @change="updateTask(task)"/>
                                </div>

                            </form>
                        </div>

                        <form @submit.prevent>
                            <input class="card mb-3 w-full" type="text" placeholder="Add a new task and hit enter." v-model="newTask" @keyup.enter="addTask()">
                        </form>

                    </div>
                    <div class="mb-3">
                        <h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>
                        <form action="project->path()" @submit.prevent="addNote()" >
                            <textarea name ="notes" class="card w-full" style="min-height: 200px" placeholder="Anything special you want to take note of?" v-model="project.notes"></textarea>
                            <input type="submit" class="button" value="Update note">
                            <!-- @include('errors') -->
                        </form>
                        
                    </div>

                </div>

                <div class="lg:w-1/4 px-3">

                    <card :project='project' @deleteProject="deleteProject"></card>
                    <activities-card :activities="project.activities" :userId="user.id"></activities-card>
                    <invite-user v-if="project.user_id === user.id" :project="project" @invited="invited"></invite-user>

                </div>
            </div>
        </main>
    </div> 
</template>

<script>
import { mapGetters } from 'vuex';
import projectApi from '../../api/project';
import taskApi from '../../api/task';
import Card from '../../components/projects/Card.vue';
import ActivitiesCard from '../../components/projects/activity/Card.vue';
import InviteUser from '../../components/projects/InviteUser.vue';

export default {
    name: 'project-view',
    components: {
        Card,
        InviteUser,
        ActivitiesCard,
    },
    mounted () {
        this.getProject();
    },
    data () {
        return {
            project:[],
            newTask: '',
        }
    },
    methods: {
        async getProject() {
            try {
                let data = {
                    token:this.user.token,
                    ...this.$route.params
                }
                let response = await projectApi.get(data)
                if (response.status === 200) {
                    this.project = response.data;
                } else if( response.status === 404 ) {
                    this.$router.push({name:'projects'});
                } else if( response.status === 401 ) {
                    this.$router.push({name:'login',query: { redirect: this.$route.fullPath }});
                }
            } catch (error) {
                console.log(error);
            }
        },

        async addTask(body) {
            try {
                let data = {
                    token:this.user.token,
                    body: this.newTask,
                    ...this.$route.params
                }
                let response = await taskApi.create(data);
                if (response.status === 201) {
                    this.getProject();
                    this.newTask ='';
                } else if( response.status === 401 ) {
                    this.$router.push({name:'login',query: { redirect: this.$route.fullPath }});
                }
            } catch (error) {
                console.log(error);
            }
        },

        async updateTask(task) {
            try {

                let data = {
                    token:this.user.token,
                    ...task
                }
                let response = await taskApi.update(data)
                // console.log(response);
                if (response.status === 200) {
                    // this.project = response.data;
                } else if( response.status === 401 ) {
                    this.$router.push({name:'login',query: { redirect: this.$route.fullPath }});
                }
            } catch (error) {
                console.log(error);
            }
        },

        async addNote() {
            try {
                let data = {
                    token:this.user.token,
                    ...this.project

                }
                let response = await projectApi.addNote(data);
                if (response.status === 200) {
                    this.project = response.data;
                } else if( response.status === 401 ) {
                    this.$router.push({name:'login',query: { redirect: this.$route.fullPath }});
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
                let response = await projectApi.delete(data)
                if (response.status === 200) {
                    this.$router.push({name:'projects'})
                } else if( response.status === 401 ) {
                    this.$router.push({name:'login',query: { redirect: this.$route.fullPath }});
                }
            } catch (error) {
                console.log(error);
            }
        },
        invited(user) {
            this.project.users.push(user);
        }
    },
    computed: {
        ...mapGetters('user',['user'])
    }
}
</script>