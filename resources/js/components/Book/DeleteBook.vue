<template>
    <div>
        <button @click="deleteBook">Deletar Livro</button>
    </div>
</template>

<script>
import Axios from 'axios';
export default {
    props: {
        bookId: ""
    },

    methods: {
        deleteBook() {
            alert('Aviso: Ao deleter um livro que contenha algum empréstimo, estes serão deletados também!');
            const http = Axios;
            const url = `/api/book/delete/${this.bookId}`;
            const confirm = window.confirm('Deseja mesmo deletar este Livro?');

            if (!confirm) {
                return;
            }

            http.delete(url).then((response) => {
                alert(response.data);
                window.location.reload();
            })
        },


    }
}
</script>