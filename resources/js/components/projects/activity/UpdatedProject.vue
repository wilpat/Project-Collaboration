<template>
    <p v-if="Object.keys(activity.changes.after).length == 1">
        {{ username }} updated the {{ Object.keys(activity.changes.after)[0] }} of the project.
    </p>
    <p v-else>
        {{ username }} updated the project.
    </p>
</template>
<script>
export default {
    name: 'UpdatedProject',
    props: {
        activity: {
            type: Object
        },
        userId: {
            type: Number
        }
    },
    computed: {
        username() {
            // console.log(this.activity.user_id, this.userId)
            return this.activity.user_id === this.userId ? 'You' : this.activity.user.name;
        }
    }
}
</script>