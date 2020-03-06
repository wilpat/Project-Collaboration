<template>
    <p>
        {{ username }} created "{{ activity.subject.body }}"
        <!-- {{ username }} created the project  -->
    </p>
</template>
<script>
export default {
    name: 'CreatedTask',
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