<template>
    <Header />
    <div class="content">
        <slot></slot>
    </div>
    <Footer />
</template>

<script setup>
import Header from './base/header.vue'
import Footer from './base/footer.vue'
</script>