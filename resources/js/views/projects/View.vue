<template>
     <div v-if="project.user">
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
                            <form>
                                <!-- @method('PATCH') -->
                                <!-- @csrf -->
                                <div class="flex">
                                    <input 
                                        class="w-full"
                                        :class="{ 'text-grey' : task.completed }" type="text" name="body" :value="task.body" /> 
                                    <input type="checkbox" name="completed" @keyup.enter="update()" :checked="task.completed"/>
                                    Tasks {{task}}
                                </div>

                            </form>
                        </div>

                        <!-- <form action="$project->path() . '/tasks' " method="POST"> -->
                        <form @submit.prevent>
                            <!-- @csrf -->
                            <input class="card mb-3 w-full" type="text" placeholder="Add a new task and hit enter." name="body" @keyup.enter="addTask($event.target.value)">
                        </form>

                    </div>
                    <div class="mb-3">
                        <h2 class="text-grey font-normal text-lg mb-3">General Notes</h2>
                        <form action="project->path()" >
                            <!-- @csrf -->
                            <!-- @method('PATCH') -->
                            <textarea name ="notes" class="card w-full" style="min-height: 200px" placeholder="Anything special you want to take note of?" v-model="project.notes"></textarea>
                            <input type="submit" class="button" value="Add note">
                            <!-- @include('errors') -->
                        </form>
                        
                    </div>

                </div>

                <div class="lg:w-1/4 px-3">

                    @include('projects.card')
                    @include('projects.activity.card')
                    @can('manage', $project)
                        @include('projects.invite')
                    @endcan


                </div>
            </div>
        </main>
    </div> 
</template>

<script>
import { mapGetters } from 'vuex';
import projectApi from '../../api/project';
import taskApi from '../../api/task';

export default {
    name: 'project-view',
    mounted () {
        this.getProject()
    },
    data () {
        return {
            project:{}
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
                    body,
                    ...this.$route.params
                }
                let response = await taskApi.create(data);
                console.log(response);
                // if (response.status === 200) {
                //     this.project = response.data;
                // } else if( response.status === 401 ) {
                //     this.$router.push({name:'login'});
                // }
            } catch (error) {
                console.log(error);
            }
        },

        async updateTask() {
            try {
                let data = {
                    token:this.user.token,
                    ...this.$route.params
                }
                let response = await projectApi.get(data)
                if (response.status === 200) {
                    this.project = response.data;
                } else if( response.status === 401 ) {
                    this.$router.push({name:'login'});
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