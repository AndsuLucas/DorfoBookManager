<template>
    <div class="filterPanel" v-show="filterMode">
        <div class="filterContainer">
            <div class="filterGroup">
                <p>Status do livro</p>
                <label for="">Status:</label>
                <select v-model="loan.returned">
                    <option value="">Filtrar  estado do empréstimo</option>
                    <option value=1>Devolvido</option>
                    <option value=0>Não devolvido</option>
                </select>
            </div>
            <div class="filterGroup">
                <p>Beneficiário</p>
                <label for="recipient">Nome:</label>
                <input type="text" id="recipient" v-model="loan.recipient">
            </div>
            <div class="filterGroup">
                <p>Data exata</p>
                <label for="loan_date">Data:</label>
                <input type="date" id="loan_date" v-model="loan.loan_date">
            </div>
            <div class="filterGroupGrow4">
                <p for="interval_date">Intervalo entre datas</p>
                <div class="inputGroup">
                    <div>
                        <label for="loan_date_start">De:</label>
                        <input type="date" id="loan_date_start" v-model="loan.loan_date_start">
                    </div>
                    <div>
                        <label for="loan_date_end">Até:</label>
                        <input type="date" id="loan_date_end" v-model="loan.loan_date_end">
                    </div>
                </div>
            </div>
            <!-- TODO: LIMPAR FILTRO -->
        </div>
        <div class="filterButton">
            <button @click="filterLoan">Filtrar</button>
        </div>
    </div>
</template>
<script>
import comunication from '../../Comunication.js';
import Axios from 'axios';
export default {
    data() {
        return {
            loan:{},
            filterMode: false,
        }
    },

    methods: {
        filterLoan() {
            Axios.get('/api/loan/filter', { params: this.loan })
                .then(response => {comunication.$emit('filteredLoan', response.data)});
        }, 

        toggleFilterMode() {
            this.filterMode = !this.filterMode;
        }
    },

    computed: {
        parsedLoan() {
            const parsedParams = Object.values(this.loan).filter(value => {
                return value.trim().length != 0
            });

            return parsedParams;
        }
    },

    mounted() {
        comunication.$on('toggleFilter', () => {
            this.toggleFilterMode();
        });
    }
}
</script>