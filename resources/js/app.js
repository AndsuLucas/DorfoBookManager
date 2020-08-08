import Vue from 'vue';
import VueRouter from 'vue-router';
import BookComponent from './components/Book/BookComponent.vue';
import LoanComponent from './components/Loan/LoanComponent.vue';
import UserComponent from './components/User/UserComponent.vue';
import NavBar from './components/GenericComponents/NavBar.vue'

window.addEventListener('load', function(){
    Vue.use(VueRouter);
    Vue.component('nav-bar', NavBar);
    const router = new VueRouter({
        mode: 'history',
        base: '/',
        routes: [
            {path: "/", redirect: "/user" },
            {path: '/book', component: BookComponent},
            {path: '/loan', component: LoanComponent},
            {path: '/user', component: UserComponent},
            {path: '*', component: UserComponent}
        ]
    });
    Vue.extend()
    new Vue({ router }).$mount('#main-app');
});
