<template>
    <Header />
    <div class="container body">
        <Nav />

        <div class="bg-white rounded-lg content">
            <slot></slot>
        </div>
    </div>
    <Footer />
</template>

<script setup>
import Header from './base/header.vue'
import Footer from './base/footer.vue'
import Nav from './base/nav.vue'
</script>

<style lang="scss" scoped>
.body {
    display: flex;
    margin-top: 20px;

    .content {
        width: 100%;
        margin-left: 12px
    }
}
</style>