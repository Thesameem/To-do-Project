<script setup>

    import { ref, useTemplateRef } from 'vue';
    import { onClickOutside } from '@vueuse/core';
    import { useTodoStore } from './../../stores/Todo';

    import { useRouter } from 'vue-router';

    import { GET } from '@/scripts/Fetch';
    import Cookie from '@/scripts/Cookie';
    
    let emits = defineEmits(['activity']);

    const TodoStore = useTodoStore();
    const router = useRouter();

    let ShowSearch = ref(false);
    let UserModalFocus = ref(false);

    let Keyword = '';

    const target = useTemplateRef('target')
    onClickOutside(target, event => {
        UserModalFocus.value = false;
    });

    // search todo list using title and description
    const StartSearching = () => {
        TodoStore.TaskList.map(element => {
            let title = element.title.toLowerCase();
            let desp = element.description.toLowerCase();
            let toMatch = Keyword.toLowerCase();

            if (title.includes(toMatch) || desp.includes(toMatch)) element.matched = false;
            else element.matched = true;
        });
    }   
    
    // logout the user and route to authentication page
    const LogOut = () => {
        let result = GET('user/logout/' + TodoStore.user.id);
        Cookie.setCookie('todo-app', '', -1);
        // location.reload();
        router.push({path: '/auth'});
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
                <span v-if="TodoStore.UnreadActivities > 0">{{ TodoStore.UnreadActivities }}</span>
                <img src="./../../images/notification.svg" alt="activity">
            </div>
            <img src="./../../images/account.svg" alt="account" @click="UserModalFocus = true">
            
            <div class="profile-pop" v-if="UserModalFocus" ref="target">
                <div class="user">
                    <div class="avatar"><h2>{{ TodoStore.user.fname[0].toUpperCase() }}</h2></div>
                    <h3>{{ TodoStore.user.fname + ' ' + TodoStore.user.lname }}</h3>
                    <p>{{ TodoStore.user.email }}</p>
                </div>
                <ul class="user-menu">
                    <li>
                        <img src="./../../images/settings.svg" />
                        <h4>Settings</h4>
                    </li>
                    <li @click="LogOut">
                        <img src="./../../images/logout.svg" />
                        <h4>Log Out</h4>
                    </li>
                </ul>
            </div>   

        </div>
    </div>
</template>