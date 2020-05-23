<template>
    <div class="loansPrincipalContainer">
        <div class="optionsLinkGroup">
            <nav>
                <ul>
                    <li>     
                        <newLoan></newLoan>
                    </li>
                    <li>
                        <a href="#" @click="toggleFilter">Buscar especificamente</a>
                    </li>
                </ul>
                <filter-loan></filter-loan>
            </nav>
        </div>
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
                <div class="principalLoanContainer">
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
                            {{loan.book.title}} <!-- TODO: clicar e ver detalhes do livro -->
                        </p>
                    </div>
                    <returnLoan :loanId="loan.id" v-show="!loan.returned"></returnLoan>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Axios from 'axios';
import newLoan from './NewLoan.vue';
import returnLoan from './ReturnLoan.vue';
import filterLoan from './Filter.vue';
import Comunication from '../../Comunication.js'
export default {
    data() {
        return {
            loans: []
        }
    },
    components: {
        newLoan: newLoan,
        returnLoan: returnLoan,
        filterLoan: filterLoan
    },

    methods: {
        async getLoans() {
            const hasCachedLoans = localStorage.getItem('loans') != undefined;

            if (hasCachedLoans) {
                this.loans = JSON.parse(localStorage.getItem('loans'));
            }

            const http = Axios;

            this.loans = await http.get('/api/loan').then((response) => {
                localStorage.setItem('loans', JSON.stringify(response.data));
                return response.data;
            });
        },

        toggleFilter() {
            Comunication.$emit('toggleFilter');
        }
    },

    mounted() {
        this.getLoans();
        Comunication.$on('filteredLoan', loans => {this.loans = loans})
    }
}
</script>