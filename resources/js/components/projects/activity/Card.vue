<template>
    <div class="card mt-3">
        <ul class="text-sm list-reset">
            <li 
                :class="{'mb-1' : activity.length-1 == index }" 
                v-for="(activity, index) in activities" 
                :key="index"> 
                <component :is="activity.description" :activity="activity" :userId="userId"></component>
                <span class="text-grey">{{ activity.created_at }} </span>
            </li>
        </ul>
    </div>
</template>
<script>
import CompletedTask from './CompletedTask.vue';
import CreatedProject from './CreatedProject.vue';
import CreatedTask from './CreatedTask.vue';
import IncompletedTask from './IncompletedTask.vue';
import UpdatedTask from './UpdatedTask.vue';
import UpdatedProject from './UpdatedProject.vue';
export default {
    name: 'activity-card',
    components:{
        'created_project': CreatedProject,
        'updated_project': UpdatedProject,
        'completed_task': CompletedTask,
        'created_task': CreatedTask,
        'updated_task': UpdatedTask,
        'incompleted_task': IncompletedTask,
    },
    props: {
        activities: {
            type: Array,
            description: 'The activities of a project'
        },
        userId: {
            type: Number
        }
    }
}
</script>