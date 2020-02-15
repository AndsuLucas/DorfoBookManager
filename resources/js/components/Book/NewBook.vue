<template>
    <form action="#" class="newBookForm" id="new_book">
        <div class="feedBackPanel" id="feedBackPanel" @click="clearFeedBack">
            <div v-show="hasFeedback">
                <p>{{feedBack.content}}</p>
            </div>
        </div>
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
            <input type="text" id="total" class="registerInput" v-model="newBookData.total">
        </div>
        <button id="sendButton" @click="newBook">Registrar</button>
    </form>
</template>
<script>
import Axios from 'axios';
export default {
    
    data() {
        return {
            newBookData: {},
            feedBack: {
                type: "",
                content: ""
            }
        }
    },

    methods: {
        newBook() {
            // TODO: validação aqui
            const http = Axios.post('/api/book/new', this.newBookData);
            http.then((response) => {
                const feedBackType = response.status == 'OK' ? 'success' : 'error';
                const feedBackMessage = response.data;
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
        }
    },

    computed: {
        hasFeedback() {
            return (this.feedBack.type && this.feedBack.content) != "";
        } 
    }
}
</script>