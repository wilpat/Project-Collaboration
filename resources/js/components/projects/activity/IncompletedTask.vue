<template>
    <p>
        {{ username }} incompleted "{{ activity.subject.body }}"
    </p>
</template>
<script>
export default {
    name: 'IncompletedTask',
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