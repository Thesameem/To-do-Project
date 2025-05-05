<script setup>

    import { ref } from 'vue';
    import { useTodoStore } from './../../stores/Todo';

    const TodoStore = useTodoStore();

    let ShowSearch = ref(false);

    let Keyword = '';

    const StartSearching = () => {
        TodoStore.TaskList.map(element => {
            let title = element.title.toLowerCase();
            let desp = element.description.toLowerCase();
            let toMatch = Keyword.toLowerCase();

            if (title.includes(toMatch) || desp.includes(toMatch)) element.matched = false;
            else element.matched = true;
        });
    }

</script>

<template>
    <div class="app-search">
        <h1>Todo List ({{ TodoStore.TaskList.length }})</h1>
        <img v-if="!ShowSearch" @click="ShowSearch = true;" src="./../../images/search.svg">
        <div v-if="ShowSearch" class="search-box">
            <input type="text" placeholder="Search" v-model="Keyword" @keyup="StartSearching">
            <img @click="ShowSearch = false" src="./../../images/close.svg">
        </div>
    </div>
</template>