<template>
    <div>
        <a href="#" @click="toggleRegister">Registrar novo livro</a>
        <div class="formModal" v-show="registerMode">
            <span class="close" @click="toggleRegister">&times;</span>
            <div class="feedBackPanel" id="feedBackPanel" @click="clearFeedBack" style="max-width: 80%;">
                <div v-show="hasFeedback">
                    <p>{{feedBack.content}}</p>
                </div>
            </div>
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
export default {
    
    data() {
        return {
            newBookData: {},
            registerMode: false,
            feedBack: {
                type: "",
                content: ""
            }
        }
    },

    methods: {
        newBook() {

            const parsedBookData = parseBookData(this.newBookData);
            const validateMessage = validateBookData(parsedBookData);
            
            if (validateMessage != '') {
                this.setFeedback(
                    validateMessage, 'error'
                );
                return;
            }
            
            
            const http = Axios.post('/api/book/new', this.newBookData);
            http.then((response) => {
                const feedBackType = response.status == 'OK' ? 'success' : 'error';
                const feedBackMessage = response.data;
                
                if (feedBackType == 'success') {
                    localStorage.removeItem('books');
                }

                this.setFeedback(
                    feedBackMessage, feedBackType
                );
            });
        },
    
        setFeedback(msg, type){
            this.feedBack.type = type;
            this.feedBack.content = msg;
        },

        clearFeedBack() {
            this.feedBack.type = "";
            this.feedBack.content = "";
        },

        toggleRegister() {
            this.registerMode = !this.registerMode;            
        }
    },

    computed: {
        hasFeedback() {
            return (this.feedBack.type && this.feedBack.content) != "";
        } 
    },
}
</script>