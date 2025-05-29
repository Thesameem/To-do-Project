<script setup>

    // pinia store
    import { useTodoStore } from './../stores/Todo';
    const TodoStore = useTodoStore();

    // components
    import AppSearch from './internal/AppSearch.vue';
    import AddTask from './internal/AddTask.vue';
    import TaskInput from './internal/TaskInput.vue';


</script>

<template>
    <header>        
        <AppSearch @activity="TodoStore.ShowActivity = true" />
        <AddTask v-if="!TodoStore.ShowInputBox" @show="TodoStore.ShowInputBox = true"/>
        <TaskInput v-if="TodoStore.ShowInputBox" @hide="TodoStore.ShowInputBox = false" />
    </header>
</template>