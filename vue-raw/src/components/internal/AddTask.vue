<script setup>

    const emit = defineEmits(['show']);

</script>

<template>
    <div class="add-task" @click="$emit('show')">
        <img src="./../../images/add.svg">
        <p>Add Task</p>
    </div>
</template>