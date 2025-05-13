<script setup>

    import axios from 'axios';
    let emits = defineEmits(['login']);
    let Fullname="";
    let email="";
    let password="";

    const RegisterUser=()=>{

        //create form data to send to server


        let formData = new FormData();

        let nameAry=Fullname.split(' ');
        formData.append('fname',nameAry[0]);
        formData.append('lname',nameAry[1]);
        formData.append('email',email);
        formData.append('password',password);

        //send post method to register user
        axios.post('http://127.0.0.1:8000/api/user/register',formData)
        .then(function(response){
            console.log(response);
        });
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
                <h2>Sign up to Todo App.</h2>
                <p>Already a member? <a href="#" @click="emits('login')">Log in</a></p>
            </div>

            <div class="if-input">
                <div class="i-field">
                    <label>Fullname</label>
                    <div class="field-input">
                        <input type="text" placeholder="Jon Doe" v-model="Fullname">
                        <img src="./../../images/user.svg" alt="user">
                    </div>
                </div>

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
                <button class="primary" @click="RegisterUser">
                    <p>Create an account</p>
                </button>
            </div>
        </div>

        <div class="policy">
            <p>This site is protected by reCAPTCHA and the Google</p>
            <p><a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> apply</p>
        </div>
    </div>
</template>