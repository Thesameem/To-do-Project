<script setup>

    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import { useTodoStore } from '@/stores/Todo';

    import Cookie from '@/scripts/Cookie';
    import { POST } from '@/scripts/Fetch';

    let emits = defineEmits(['signup']);

    let email = '';
    let password = '';
    let isRequesting = ref(false);

    const TodoStore = useTodoStore();
    const router = useRouter();

    let SignupError = ref(false);
    let ErrorText = ref('Something went wrong');

    const LoginUser = async () => {
        if (isRequesting.value) return;
        
        // validation
        if (email.length < 3 || password < 8) {
            SignupError.value = true;
            ErrorText.value = "All fields are required!";
            return;
        }

        // submit form
        let formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        isRequesting.value = true;
        let result = await POST('user/login', formData);
        isRequesting.value = false;
        if (!result.error) {
            Cookie.setCookie('todo-app', result.response.token, 2);
            TodoStore.user = result.response.user;
            router.push({
                path: '/'
            });
        }else {
            SignupError.value = true;
            ErrorText.value = result.reason;
        }
    }

</script>

<template>
    <div class="form">
        <div class="lang">
            <select name="language">
                <option value="English (USA)">English USA</option>
                <option value="English (UK)">English (UK)</option>
                <option value="Nepali">Nepali</option>
            </select>
        </div>

        <div class="input-form">
            <div class="if-header">
                <span>START FOR FREE</span>
                <h2>Sign in to Todo App.</h2>
                <p>Register new account? <a href="#" @click="emits('signup')">Signup</a></p>
            </div>

            <div class="if-input">

                <div class="i-field">
                    <label>E-Mail</label>
                    <div class="field-input">
                        <input type="email" placeholder="mail@example.com" v-model="email">
                        <img src="./../../images/mail.svg" alt="mail">
                    </div>
                </div>

                <div class="i-field">
                    <label>Password</label>
                    <div class="field-input">
                        <input type="password" placeholder="6+ Characters, 1 Capital letter" v-model="password">
                        <img src="./../../images/lock.svg" alt="lock">
                    </div>
                </div>
            </div>

            <div class="if-action">
                <p v-if="SignupError" style="color: red;">{{ ErrorText }}</p>
                <button class="primary" @click="LoginUser">
                    <p v-if="!isRequesting">Sign to Dashboard</p>
                    <img v-else src="./../../images/loader2.gif" />
                </button>
            </div>
        </div>

        <div class="policy">
            <p>This site is protected by reCAPTCHA and the Google</p>
            <p><a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> apply</p>
        </div>
    </div>
</template>