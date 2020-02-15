<template>
    <section class="bookListPrincipalContainer">
        <div class="optionsLinkGroup">
            <div>
                <label for="book-search">Buscar Livro</label>
                <input type="text" class="search" id="book-search">
                <button class="sendButton">Buscar</button>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="#" @click="toggleRegisterMode" v-text="newBookTextLink">tes</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="newBookContainer" v-show="newBookMode">
            <new-book/>      
        </div>
        <table class="showBooksTable">
            <tr>
                <td>Id</td>
                <td>Título</td>
                <td>Quantidade Emprestada</td>
                <td>Quantidade Restante</td>
                <td>Total de Exemplares</td>
                <td colspan="2">
                    Ações
                </td>
            </tr>
            <tr v-for="book in books" :key="book.id">
                <th>{{book.id}}</th>
                <td>{{book.title}}</td>
                <td>{{book.loan_amount}}</td>
                <td>{{book.remaining_amount}}</td>
                <td>{{book.total}}</td>
                <td>
                    <editBook :book="book"/>
                </td>
                <td>
                    <deleteBook :bookId="book.id"/>
                </td>          
            </tr>
        </table>
    </section>
</template>
<script>
import Axios from 'axios';
import newBook from './NewBook.vue';
import editBook from './EditBook.vue';
import deleteBook from './DeleteBook.vue';

export default {
    components: {
        newBook: newBook,
        editBook: editBook,
        deleteBook: deleteBook

    },
    
    data() {
        return {
            books: [],
            newBookMode: false
        }
    },
    
    methods: {
        async getBooks() {
            const http = Axios.get('/api/book');
            this.books = await http.then((response) => {
               return response.data;
            });
        },
        toggleRegisterMode() {
            this.newBookMode = !this.newBookMode;
        }
    },

    computed: {
        newBookTextLink() {
            const textLink = this.newBookMode ? "Esconder Formulário" : "Registrar novo livro";
            return textLink;
        }
    },

    mounted() {
        this.getBooks();
    }
}
</script>