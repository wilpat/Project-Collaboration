<template>
    <div>
        <nav-bar></nav-bar>
        <main class="container mx-auto">
                <router-view></router-view>
        </main>
    </div>
</template>
<script>
import NavBar from '../components/Nav.vue';
export default {
    name: 'Layout',
    components: {
        NavBar
    }
}
</script>