<template>
    <div>
        <button @click="enterEditMode">Editar</button>
        <div v-show="editMode" class="formModal">
            <span class="close" @click="enterEditMode">&times;</span>
            <form action="#">
                <div class="feedBackPanel" id="feedBackPanel" @click="clearFeedBack">
                    <div v-show="hasFeedback">
                        <p>{{feedBack.content}}</p>
                    </div>
                </div>
                <div class="formGroup">
                    <label for="title">Título do exemplar</label>
                    <span class="tagRequired"></span>
                    <input type="text" id="title" class="registerInput" v-model="book.title" aria-selected="false">
                </div>
                <div class="formGroup">
                    <label for="loan_amount">Quantidade Emprestada</label>
                    <input type="number" id="loan_amount" class="registerInput" v-model="book.loan_amount" min="0" :max="book.total">
                </div>
                <div class="formGroup">
                    <label for="remaining_amount">Quantidade Restante</label>
                    <input type="number"  id="remaining_amount" class="registerInput" min="0" :max="book.total" v-model="book.remaining_amount">
                </div>
                <div class="formGroup">
                    <label for="total">Total de Exemplares</label>
                    <input type="text" id="total" class="registerInput" v-model="book.total">
                </div>
            
                <button type="submit" @click="editBook">Salvar Edição</button>
                
            </form>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'
import { validateBookData, parseBookData } from '../../helpers/functions.js';
export default {

    props: {
      book: {},
    },

    data() {
        return {
            editMode: false,
            feedBack: {
                type: "",
                content: ""
            }
        }
    },

    methods: {
        editBook() {
            const http = Axios;
            const url = `/api/book/edit/${this.book.id}`;
    
            const parsedBookData = parseBookData(this.book);
            const validateMessage = validateBookData(parsedBookData);
            
            if (validateMessage != '') {
                this.setFeedback(
                    validateMessage, 'error'
                );
                return;
            }
        
            http.put(url, this.book)
            .then((response) => {
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
        },
        
        enterEditMode() {
            this.editMode = !this.editMode;
        }
    },

    computed: {
        hasFeedback() {
            return (this.feedBack.type && this.feedBack.content) != "";
        } 
    },

    watch: {
    }
}
</script>