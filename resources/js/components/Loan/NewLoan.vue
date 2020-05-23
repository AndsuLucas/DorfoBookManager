<template>
    <div>
        <a href="#" @click="toggleNewLoanMode">Novo Empréstimo</a>
        <div class="formModal" v-show="newLoanMode">
            <span class="close" @click="toggleNewLoanMode">&times;</span>
            <feedBackPanel></feedBackPanel>
            <form action="#" class="newLoanForm" id="new_loan" @submit.prevent @keypress.enter.prevent>
                <div class="formGroup">
                    <label for="book">Selecione um Exemplar</label>
                    <input type="text" placeholder="Pesquisar um livro. (Use regex se possível)" id="bookSearch" @keypress.enter="filterBooks">
                    <select id="book" v-model="selectedBook">
                        <option value="0">Selecione um livro</option>
                        <option :value="book" v-for="book in books" :key="book.id" :ref="'book'+book.id">{{book.title}}</option>
                    </select>
                </div>
                <div class="formGroup">
                    <label for="note">Observações</label>
                    <textarea id="note" v-model="newLoanData.note"></textarea>
                </div>
                <div class="formGroup">
                    <label for="recipient">Nome do Beneficiário</label>
                    <input type="text" id="recipient" v-model="newLoanData.recipient">
                </div>
                <button id="sendButton" @click="newLoan" type="submit">Registrar</button>

            </form>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
import Comunication from '../../Comunication.js';
import feedBackPanel from '../GenericComponents/panelFeedBack';

export default {
    data() {
        return {
            books: JSON.parse(localStorage.getItem('booksToLoan')),
            newLoanData: {},
            newLoanMode: false,
            selectedBook: "0",
        }
    },
    components: {
        feedBackPanel: feedBackPanel
    },

    methods: {
        async getBooks() {
            const http = Axios.get('/api/book/getBooksToLoan',);
            this.books = await http.then((response) => {
                localStorage.setItem('booksToLoan', JSON.stringify(response.data));
                return response.data;
            });
        },

        toggleNewLoanMode() {
            this.newLoanMode = !this.newLoanMode;
        },

        filterBooks(event) {
            const pattern = event.target.value;
            const regex = new RegExp(pattern);
            
            const filteredBooks = this.books.filter((book) => {
                return book.title.trim().search(regex) != -1; 
            });

            if (filteredBooks[0] == undefined){
                event.target.classList.toggle('dangerInput');
                setTimeout(function(){event.target.classList.toggle('dangerInput')}, 2000);
                return;
            }

            const $option = this.$refs['book'+filteredBooks[0].id]
            this.selectedBook = filteredBooks[0];
            $option[0].setAttribute('selected', 'selected');
        },

        newLoan() {

            const invalidBookId = this.selectedBook.toString().lenght == 0 || typeof this.selectedBook != 'object';
            if (invalidBookId) {
                Comunication.$on('toggleFeedback', 'Livro inválido.');
                return;
            }
            
            const invalidId = this.selectedBook.id == undefined || isNaN(this.selectedBook.id);
            if (invalidId) {
                Comunication.$on('toggleFeedback', 'Livro inválido.');
                return;
            }

            const http = Axios.post(`api/loan/newLoan/${this.selectedBook.id}`, this.newLoanData);
            http.then((response) => {
                Comunication.$on('toggleFeedback', response.data);
                localStorage.removeItem('booksToLoan');
            });

        }
    },

    created() {
        this.getBooks();
    }
}
</script>