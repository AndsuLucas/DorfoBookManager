<template>
     <div class="loginContainer">
        <div class="loginLogo">
            <h2>Login DorfoBookManager</h2>
        </div>
        <div class="userFeedBack">
            <panelFeedback></panelFeedback>
        </div>
        <form action="">
            <div class="formGroup">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="userData.email">
            </div>
            <div class="formGroup">
                <label for="password">Senha</label>
                <input type="password" id="password" v-model="userData.password">
            </div>
            <div class="formGroup">
                <button class="loginButton" @click="login">Entrar</button>
            </div>
        </form>
    </div>
</template>
<script>
import Axios from 'axios';
import panelFeedback from '../GenericComponents/panelFeedBack'
import Comunication from '../../Comunication.js'

export default {
    components: {
        panelFeedback: panelFeedback
    },

    data() {
        return {
            userData: {
                email: "",
                password: "",
            }
        }
    },
    methods: {
        login(evt) {
            evt.preventDefault();
            const email = this.userData.email.toString().trim();
            if (email.length == 0) {
                Comunication.$emit('toggleFeedback', "Por favor insira o e-mail");
                return;
            }

            const password = this.userData.password.toString().trim();
            if (password.length == 0) {
                Comunication.$emit('toggleFeedback', "Por favor insira a senha");
                return;
            }

            const http = Axios;
            const url = 'api/user/login';

            http.post(url, this.userData)
            .then((response) => {
                Comunication.$emit('successLogin', response.data);
            }).catch((error) => {
                this.setFeedback(error);
            });
        },

        setFeedback(error) {
            if (error.response.status == '422') {
                Object.values(error.response.data).forEach((content) => {
                    alert(content)
                    Comunication.$emit('pushFeedBack', content[0]);
                });
                return;
            }

            Comunication.$emit('toggleFeedback', error.response.data);
        },
    }
}
</script>