<script setup>

    import { ref } from 'vue';
    import { useTodoStore } from './../../stores/Todo';

    let emits = defineEmits(['activity']);

    const TodoStore = useTodoStore();

    let ShowSearch = ref(false);
    let UserModalFocus = ref(false);

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

        <div class="as-icons">
            <img v-if="!ShowSearch" @click="ShowSearch = true;" src="./../../images/search.svg">
            <div v-if="ShowSearch" class="search-box">
                <input type="text" placeholder="Search" v-model="Keyword" @keyup="StartSearching">
                <img @click="ShowSearch = false" src="./../../images/close.svg">
            </div>

            <div class="activity" @click="emits('activity')">
                <span>2</span>
                <img src="./../../images/notification.svg" alt="activity">
            </div>
            <img src="./../../images/account.svg" alt="account" @click="UserModalFocus = true">
            
            <div class="profile-pop" v-if="UserModalFocus">
                <div class="user">
                    <div class="avatar"><h2>J</h2></div>
                    <h3>Jon Doe</h3>
                    <p>jon.doe@gmail.com</p>
                </div>
                <ul class="user-menu">
                    <li @click="UserModalFocus = false">
                        <img src="./../../images/settings.svg" />
                        <h4>Settings</h4>
                    </li>
                    <li @click="UserModalFocus = false">
                        <img src="./../../images/logout.svg" />
                        <h4>Log Out</h4>
                    </li>
                </ul>
            </div>   
        </div>
    </div>
</template>