<template>
    <div>
        <a href="#" @click="toggleRegister">Registrar novo livro</a>
        <div class="formModal" v-show="registerMode">
            <span class="close" @click="toggleRegister">&times;</span>
            <feedBackPanel></feedBackPanel>
            <form action="#" class="newBookForm" id="new_book">
                <div class="formGroup">
                    <label for="title">Título do exemplar</label>
                    <span class="tagRequired"></span>
                    <input type="text" id="title" class="registerInput" v-model="newBookData.title">
                </div>
                <div class="formGroup">
                    <label for="loan_amount">Quantidade Emprestada</label>
                    <input type="number" id="loan_amount" class="registerInput" v-model="newBookData.loan_amount" min="0" :max="newBookData.total">
                </div>
                <div class="formGroup">
                    <label for="remaining_amount">Quantidade Restante</label>
                    <input type="number"  id="remaining_amount" class="registerInput" min="0" :max="newBookData.total" v-model="newBookData.remaining_amount">
                </div>
                <div class="formGroup">
                    <label for="total">Total de Exemplares</label>
                    <input type="number" id="total" class="registerInput" v-model="newBookData.total" min="0">
                </div>
                <button id="sendButton" @click="newBook" type="submit">Registrar</button>
            </form>
        </div>
    </div>
</template>
<script>
import Axios from 'axios';
import { validateBookData, parseBookData } from '../../helpers/functions.js';
import Comunication from '../../Comunication.js';
import feedBackPanel from '../GenericComponents/panelFeedBack';
export default {
    
    data() {
        return {
            newBookData: {},
            registerMode: false,
        }
    },

    components: {
        feedBackPanel: feedBackPanel
    },

    methods: {
        newBook() {

            const parsedBookData = parseBookData(this.newBookData);
            const validateMessage = validateBookData(parsedBookData);
            // TODO: MELHORAR DEPOIS
            
            if (validateMessage != '') {
                Comunication.$emit('toggleFeedback', validateMessage);
                return;
            }
            
            
            const http = Axios.post('/api/book/new', this.newBookData);
            http.then((response) => {
                const feedBackType = response.status == 'OK' ? 'success' : 'error';
                const feedBackMessage = response.data;
                
                if (feedBackType == 'success') {
                    localStorage.removeItem('books');
                }
                Comunication.$emit('toggleFeedback', feedBackMessage);
            });
        },
    
        toggleRegister() {
            this.registerMode = !this.registerMode;            
        }
    }
}
</script>