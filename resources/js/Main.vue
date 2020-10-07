<template>
    <transition name="fade" mode="out-in">
        <router-view></router-view>
    </transition>
</template>

<script>
export default {
    name: "MainApp"
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition-property: opacity;
    transition-duration: 0.25s;
}

.fade-enter-active {
    transition-delay: 0.25s;
}

.fade-enter,
.fade-leave-active {
    opacity: 0;
}
</style>
