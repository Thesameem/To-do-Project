<script setup>
import Cookie from '@/scripts/Cookie';
    import { useTodoStore } from '@/stores/Todo'; 
    import { useRouter } from 'vue-router';
    import { POST } from '@/scripts/Fetch';

    let emits = defineEmits(['signup']);

    let email="";
    let password="";


    const TodoStore=useTodoStore();
    const router = useRouter();

    const LogInUser=async()=>{
        //create form data to send to server


        let formData = new FormData();

        formData.append('email',email);
        formData.append('password',password);

        //send post method to register user
      let result=await POST ('user/login',formData);
      console.log(result);
      if(!result.error){
        Cookie.setCookie('todo-app',result.response.token,2);
        TodoStore.user =result.response.user;
        router.push({
            path:'/'
        });
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
                <button class="primary" @click="LogInUser">
                    <p>Log In</p>
                </button>
            </div>
        </div>

        <div class="policy">
            <p>This site is protected by reCAPTCHA and the Google</p>
            <p><a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> apply</p>
        </div>
    </div>
</template>