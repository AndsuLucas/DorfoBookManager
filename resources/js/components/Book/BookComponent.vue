<template>
    <section class="bookListPrincipalContainer">
        <div class="optionsLinkGroup">
            <nav>
                <ul>
                    <li>
                        <new-book/>      
                    </li>
                    <li>
                        <a href="#">Buscar Livro</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="searchForm">
            <form>
                <label for="book-search">Buscar Livro</label>
                <input type="text" class="searchInput" id="book-search">
                <button class="sendButton" aria-selected="false">Buscar</button>
            </form>
        </div>
        <table class="showBooksTable">
            <thead>
                <tr>
                    <th>Id</th>
                    <td>Título</td>
                    <td>Quantidade Emprestada</td>
                    <td>Quantidade Restante</td>
                    <td>Total de Exemplares</td>
                    <td colspan="2">
                        Ações
                    </td>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
            <tfoot></tfoot>
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
            
            if (localStorage.getItem('books') != undefined) {
                this.books = JSON.parse(localStorage.getItem('books'));
            }
            
            this.books = await http.then((response) => {
               localStorage.setItem('books', JSON.stringify(response.data));
               return response.data;
            });
        }
    },

    mounted() {
        this.getBooks();
    }
}
</script>