<script setup>

    import { onMounted, ref } from 'vue';
    import { useRouter } from 'vue-router';
    import Cookie from '@/scripts/Cookie';

    import Login from './../components/auth/Login.vue';
    import Signup from './../components/auth/Signup.vue';

    let LoginPage = ref(true);
    let router = useRouter();

    // check if the user is already logged in
    // route to dashboard if already logged in
    onMounted(() => {
        let Token = Cookie.getCookie('todo-app');
        if (Token) router.push({
            path: '/'
        });
    })

</script>

<template>
  <div class="login-box">
        <div class="image">
            <div class="content">
                <h1>Todo App</h1>
                <p>A central hub where teams can work, plan, and achieve amazing things together.</p>
            </div>
            <div class="img">
                <img src="./../images/login.svg" alt="login">
            </div>
        </div>

        <Login v-if="LoginPage" @signup="LoginPage = false" />
        <Signup v-else @login="LoginPage = true" />
    </div>
</template>
