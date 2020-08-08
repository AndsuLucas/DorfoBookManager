<template>
    <nav class="principalNavBar" v-if="isLogged">
        <ul>
            <li>
                <router-link to="/book">Livros</router-link>
            </li>
            <li>
                <router-link to="/loan">Empréstimos</router-link>
            </li>
        </ul>
    </nav>
</template>
<script>
import Comunication from '../../Comunication.js'

export default {
    data() {
        return {
            isLogged: true,
        }
    },

    mounted() {
        Comunication.$on('isNotLogged', () => {
            this.isLogged = false;
            localStorage.clear()
        });      
    }
}
</script>