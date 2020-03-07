<template>
    <p>
        {{ username }} created the project 
    </p>
</template>
<script>
export default {
    name: 'CreatedProject',
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
            return parseInt(this.activity.user_id)=== this.userId ? 'You' : this.activity.user.name;
        }
    }
}
</script>