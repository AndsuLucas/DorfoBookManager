<template>
    <div>
        <button @click="enterEditMode">Editar</button>
        <div v-show="editMode" class="formModal">
            <span class="close" @click="enterEditMode">&times;</span>
            <form action="#">
                <feedBackPanel></feedBackPanel>
                <div class="formGroup">
                    <label for="title">Título do exemplar</label>
                    <span class="tagRequired"></span>
                    <input type="text" id="title" class="registerInput" v-model="book.title" aria-selected="false" @input="parseBook" @change="parseBook">
                </div>
                <div class="formGroup">
                    <label for="loan_amount">Quantidade Emprestada</label>
                    <input type="number" id="loan_amount" class="registerInput" v-model="book.loan_amount" min="0" :max="book.total" @input="parseBook" @change="parseBook">
                </div>
                <div class="formGroup">
                    <label for="remaining_amount">Quantidade Restante</label>
                    <input type="number"  id="remaining_amount" class="registerInput" min="0" :max="book.total" v-model="book.remaining_amount" @input="parseBook" @change="parseBook">
                </div>
                <div class="formGroup">
                    <label for="total">Total de Exemplares</label>
                    <input type="text" id="total" class="registerInput" v-model="book.total" @input="parseBook" @change="parseBook">
                </div>
            
                <button type="submit" @click="editBook">Salvar Edição</button>
                
            </form>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'
import { validateBookData, parseBookData } from '../../helpers/functions.js';
import Comunication from '../../Comunication.js';
import feedBackPanel from '../GenericComponents/panelFeedBack';

export default {

    props: {
      book: {},
    },

    data() {
        return {
            editMode: false,
        }
    },

    components: {
        feedBackPanel: feedBackPanel
    },

    methods: {
        editBook() {
            const http = Axios;
            const url = `/api/book/edit/${this.book.id}`;

            const validateMessage = validateBookData(this.book);
            if (validateMessage != '') {
                Comunication.$emit('toggleFeedback', validateMessage);
                return;
            }

            http.put(url, this.book)
            .then((response) => {
                const feedBackType = response.status == 'OK' ? 'success' : 'error';
                const feedBackMessage = response.data;
               Comunication.$emit('toggleFeedback', feedBackMessage);

            });
        },

        parseBook() {
            parseBookData(this.book)
        },

        enterEditMode() {
            this.editMode = !this.editMode;
        },

    },
}
</script>