<template>
    <div>
        <div class="card flex flex-col" style="height: 200px">
            <h3 class="font-normal text-xl py-6 border-l-4 border-blue-light -ml-5 pl-4">
                <router-link :to="{name: 'view', params:{id: project.id}}" class="text-black no-underline">
                    {{ project.title }}
                </router-link>
            </h3>
            <div class="text-grey flex-1">
                {{ project.description.slice(0,100) }} 
            </div>
            <!-- @can('manage', $project) -->
                <footer>
                    <form @submit.prevent="$emit('deleteProject',project.id)" class="text-right">
                        <button class="text-xs" type="submit">
                            Delete
                        </button>
                    </form>
                </footer>
            <!-- @endcan -->
        </div>
    </div>
</template>

<script>
export default {
    name: 'project-card',
    props: {
        project: {
            type: Object,
            description: 'Project Details'
        }
    },
    methods: {
        
    }
}
</script>