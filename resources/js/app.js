import Vue from 'vue';
import VueRouter from 'vue-router';
import BookComponent from './components/Book/BookComponent.vue';
import LoanComponent from './components/Loan/LoanComponent.vue';
window.addEventListener('load', function(){
    Vue.use(VueRouter);
    
    const router = new VueRouter({
        mode: 'history',
        base: '/',
        routes: [
            {path: '/book', component: BookComponent},
            {path: '/loan', component: LoanComponent}
        ]
    });
    
    new Vue({ router }).$mount('#main-app');  
});
