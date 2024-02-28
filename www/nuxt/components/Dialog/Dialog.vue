<template>
    <dialog id="dialogCom" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <p v-if="content" class="py-4">{{ content }}</p>
            <slot></slot>
        </div>
    </dialog>
</template>

<script setup lang="ts">
interface Props {
    showClose: boolean,
    content: string
}

const props = withDefaults(defineProps<Props>(), {
    showClose: false,
    content: ''
})

const open = function() {
    document.getElementById('dialogCom').showModal()
}

defineExpose({
    open
})
</script>