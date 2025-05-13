<script setup>

    const props = defineProps({
        task: {
            type: Object,
            default: {}
        }
    });

    const emit = defineEmits(['hide', 'delete']);

</script>

<template>
    <div class="delete-box">
        <div class="close" @click="emit('hide')"><img src="./../images/close.svg" data-button="delClose"></div>
        <div class="content">
            <h4>Do you want to delete '{{ task.title }}' task?</h4>
        </div>
        <div class="action">
            <button @click="emit('hide')">Cancel</button>
            <button class="addbtn" @click="emit('delete')">Delete</button>
        </div>
    </div>
    <div class="overlay"></div>
</template>