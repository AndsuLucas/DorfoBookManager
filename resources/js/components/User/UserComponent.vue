<template>
    <div>
        <login v-if="!isLogged"></login>
        <div v-else>
            <h1>Seja bem vindo {{userData.name}}</h1>
        </div>
    </div>
</template>
<script>
import Login from './Login.vue'
import Comunication from '../../Comunication.js'

export default {    
    components: {
        login: Login
    },

    methods: {
        getUserData() {
            const parsedUserData = localStorage.getItem('userData');
            return JSON.parse(parsedUserData); 
        }
    },

    mounted() {
        Comunication.$on('successLogin', (userData) => {
            localStorage.setItem('userData', JSON.stringify(userData));
            const parsedUserData = localStorage.getItem('userData');
            this.userData = JSON.parse(parsedUserData); 
        });
    },

    computed: {
        isLogged() {
            const userData = this.getUserData();            
            if (!userData) {
                return false;
            }

            return userData.token != null && userData.token.length != 0;
        },

        userData() {
            return this.getUserData();
        }
    }
}
</script>
