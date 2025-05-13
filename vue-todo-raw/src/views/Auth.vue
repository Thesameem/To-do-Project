<script setup>

    import { ref } from 'vue';

    import Login from './../components/auth/Login.vue';
    import Signup from './../components/auth/Signup.vue';

    let LoginPage = ref(true);

    const ShowSignupPage = () => {
        console.log ('here');
        LoginPage.value = false;
    }

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
