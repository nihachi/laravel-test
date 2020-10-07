<template>
    <div class="main-wrapper">
        <header>
            <div class="container"></div>
        </header>
        <!-- Header Component here -->

        <transition name="fade" mode="out-in">
            <router-view :key="$router.fullPath"></router-view>
        </transition>

        <!-- Footer Component here -->
    </div>
</template>
<script>
export default {
    name: "page-home"
};
</script>
