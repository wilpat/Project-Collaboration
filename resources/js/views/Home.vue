<template>
    <div class="flex-center flex-col full-height">
        <div class="content">
            <div class="title m-b-md">
                Collab
                <p class="versioninfo">A simple tool for project collaboration among teams. </p>
            </div>

            <div class="foundation_button_test">
                <div class="block" v-if="!user.id">
                    <router-link :to="{name: 'login'}" class="button is-primary">Login</router-link>
                    <router-link :to="{name: 'register'}" class="button is-info">Register</router-link>
                </div>
                <div class="block" v-else>
                    <router-link :to="{name: 'projects'}" class="button is-primary">My Projects</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    name: 'homepage',
    computed: {
        ...mapGetters('user', ['user'])
    }
}
</script>
<style scoped>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 85vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .versioninfo {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
    }

    .framwork_title {
        font-weight: 600;
        padding-top: 20px;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>