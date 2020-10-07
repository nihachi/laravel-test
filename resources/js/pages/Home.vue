<template>
    <div class="main-wrapper">
        <Header />

        <transition name="fade" mode="out-in">
            <router-view :key="$router.fullPath"></router-view>
        </transition>
    </div>
</template>
<script>
import Header from "../components/Header";
export default {
    name: "page-home",
    components: {
        Header
    }
};
</script>
