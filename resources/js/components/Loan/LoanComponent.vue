<template>
    <div class="loansPrincipalContainer">
        <div class="searchLoanContainer">
        </div>
        <div class="loanListContainer">
            <div class="loanContainer"  v-for="loan in loans" :key="loan.id">
                <div class="loanHeaderContainer">
                    <p class="loanHeaderInfo">
                        <span class="loanLabel">Nome do beneficiado:</span> 
                        {{loan.recipient}}

                    </p>
                    <p class="loanHeaderInfo">
                        <span class="loanLabel">Data do Empréstimo:</span>
                        {{loan.loan_date}}
                    </p>
                </div>
                <div class="loanBodyContainer">
                    <p class="loanBodyInfo">
                        <span class="loanLabel">Informação Adicional:</span>
                        {{loan.note}}
                    </p>
                    <p class="loanBodyInfo">
                        <span class="loanLabel">Devolvido:</span>
                        {{loan.returned == true ? 'Sim': 'Não'}}
                    </p>
                    <p class="loanBodyInfo">
                        <span class="loanLabel">Livro:</span>
                        {{loan.book.title}} <!-- clicar e ver detalhes do livro -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Axios from 'axios';
export default {
    data() {
        return {
            loans: []
        }
    },

    methods: {
        async getLoans() {
            const hasCachedLoans = localStorage.getItem('loans') != undefined;

            if (hasCachedLoans) {
                this.loans = JSON.parse(localStorage.getItem('loans'));
            }

            const http = Axios;
            console.log(this.loans);

            this.loans = await http.get('/api/loan').then((response) => {
                localStorage.setItem('loans', JSON.stringify(response.data));
                return response.data;
            });
        }
    },

    mounted() {
        this.getLoans();
    }
}
</script>