<template>
        <div class="loanActionContainer">
            <button @click="returnLoan">Retornar Livro</button>
        </div>
</template>
<script>
import Axios from 'axios';
export default {
    props: {
        loanId: Number()
    },

    methods: {
        async returnLoan() {
            const confirmation = confirm('Deseja mesmo retornar este livro?')
            const url = `/api/loan/checkout/${this.loanId}`;

            const http = Axios;

            const feedBack = await Axios.put(url).then((response) => {
                return response.data
            });
            
            alert(feedBack);
            window.location.reload();
        }
    }
}
</script>