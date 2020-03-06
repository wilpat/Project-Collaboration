<template>
    <p>
        {{ username }} completed "{{ activity.subject.body }}"
        <!-- {{ username }} created the project  -->
    </p>
</template>
<script>
export default {
    name: 'CompletedTask',
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
            return this.activity.user_id === this.userId ? 'You' : this.activity.user.name;
        }
    }
}
</script>