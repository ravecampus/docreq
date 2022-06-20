import {createWebHistory, createRouter} from "vue-router";
import Home from '../components/Home';
import Login from '../components/Login';
import Signup from '../components/Signup';
import Search from '../components/search/Result';

import Items from '../components/items/Product';
import Cart from '../components/items/Cart';
import Checkout from '../components/items/Checkout';

import User from '../components/users/Dashboard';

import Admin from '../components/admin/Admin';
import AdminItem from '../components/admin/AdminItem';
import AdminDashboard from '../components/admin/AdminDashboard';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        children:[
            {
                path:'',
                name:'items',
                component: Items
            },
            {
                path:'search',
                name:'search',
                component: Search
            },
            {
                path:'cart',
                name:'cart',
                component: Cart
            },
            {
                path:'checkout',
                name:'checkout',
                component: Checkout
            },
        ]

    },
    {
        path:'/user',
        name:'user',
        component: User,
        // children:[
        //     {
        //         path:'',
        //         name:'sa',
        //         component: Items
        //     },
        // ]

    },
    {
        path:'/admin',
        name:'admin',
        component: Admin,
        children:[
            {
                path:'',
                name:'admindashboard',
                component: AdminDashboard
            },
            {
                path:'/admin/items',
                name:'adminitem',
                component: AdminItem
            },
        ]

    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },

    {
        name: 'signup',
        path: '/signup',
        component: Signup
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const openRoutes = [
    'signup', 
    'login',
    'home',
    'items',
    'search',
    'cart', 
    'checkout',
    // 'notfound',
];

const userRoutes = [
    'home',
    'items',
    'search'
];
const adminRoutes = [
    'admin', 
    'adminitem',
    'admindashboard'
];


router.beforeEach((to, from, next)=>{
    if(!window.Laravel.isLoggedin){
        if(openRoutes.includes(to.name)){
            return next();
        }
    }else{
        let user = window.Laravel.user;
        if(adminRoutes.includes(to.name) && user.role == 1){
            return next();
        }else if(userRoutes.includes(to.name) && user.role == 0){
            return next();
        }
    }
    if(openRoutes.includes(to.name)){
        return next();
    }else{
        return next({name:'login'});
    }
    
   
});

export default router;