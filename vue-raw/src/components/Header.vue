<script setup>

    // vue
    import { ref } from 'vue';
    import { useTodoStore } from './../stores/Todo';

    const TodoStore = useTodoStore();

    // scripts

    // components
    import AppSearch from './internal/AppSearch.vue';
    import AddTask from './internal/AddTask.vue';
    import TaskInput from './internal/TaskInput.vue';


</script>

<template>
    <header>        
        <AppSearch />
        <AddTask v-if="!TodoStore.ShowInputBox" @show="TodoStore.ShowInputBox = true"/>
        <TaskInput v-if="TodoStore.ShowInputBox" @hide="TodoStore.ShowInputBox = false" />
    </header>
</template>