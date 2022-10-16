import {createWebHistory, createRouter} from "vue-router";
import Home from '../components/Home';
import Login from '../components/Login';
import Signup from '../components/Signup';
import Top from '../components/Top';
import Search from '../components/search/Result';

import Items from '../components/items/Product';
import Cart from '../components/items/Cart';
import Checkout from '../components/items/Checkout';

import User from '../components/users/Dashboard';
import BookAddress from '../components/users/BookAddress';
import Order from '../components/users/Order';
import RequestStatus from '../components/users/RequestStatus';
import Topay from '../components/users/Topay';
import Toship from '../components/users/Toship';
import Toreceive from '../components/users/Toreceive';
import UserProfile from '../components/users/UserProfile';
import Received from '../components/users/Received';
import Payment from '../components/users/Payment';
import PaymentSuccess from '../components/users/PaymentSuccess';
import ResetPassword from '../components/users/ResetPassword';
import NewPassword from '../components/users/NewPassword';
import CancelRequest from '../components/users/CancelledRequest';

import Admin from '../components/admin/Admin';
import AdminItem from '../components/admin/AdminItem';
import AdminProfile from '../components/admin/AdminProfile';
import AdminDashboard from '../components/admin/AdminDashboard';
import Charges from '../components/admin/Charges';
import AdminUsers from '../components/admin/AdminUsers';
import AdminClient from '../components/admin/AdminClient';
import AdminOrderList from '../components/admin/AdminOrderList';
import AdminReport from '../components/admin/AdminReport';
import AdminPurpose from '../components/admin/AdminPurpose';


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
            {
                name: 'top',
                path: '/top-requested-docs',
                component: Top
            },
        ]

    },
    {
        path:'/user',
        name:'user',
        component: User,
        children:[
            {
                path:'',
                name:'request',
                component: Order
            },
            {
                path:'req-status',
                name:'reqstatus',
                component: RequestStatus,
                children:[
                    {
                        path:'',
                        name:'topay',
                        component: Topay
                    },
                    {
                        path:'to-ship',
                        name:'toship',
                        component: Toship
                    },
                    {
                        path:'to-receive',
                        name:'toreceive',
                        component: Toreceive
                    },
                    {
                        path:'received',
                        name:'received',
                        component: Received
                    },
                    {
                        path:'cancelled',
                        name:'cancelled',
                        component: CancelRequest
                    }
                ]
            },
            {
                path:'/user/profile',
                name:'userprofile',
                component: UserProfile
            },
            {
                path:'/user/book-address',
                name:'bookaddress',
                component: BookAddress
            },

        ]

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
                path:'/admin/profile',
                name:'aprofile',
                component: AdminProfile
            },
            {
                path:'/admin/items',
                name:'adminitem',
                component: AdminItem
            },
            {
                path:'/admin/charges',
                name:'charges',
                component: Charges
            },
            {
                path:'/admin/users',
                name:'adminuser',
                component: AdminUsers
            },
            {
                path:'/admin/clients',
                name:'adminclient',
                component: AdminClient
            },
            {
                path:'/admin/order-list',
                name:'adminorderlist',
                component: AdminOrderList
            },
            {
                path:'/admin/report',
                name:'adminreport',
                component: AdminReport
            },
            {
                path:'/admin/purpose',
                name:'adminpurpose',
                component: AdminPurpose
            },
        ]

    },
    {
        name: 'paymentsuccess',
        path: '/payment/success/:order_id',
        component: PaymentSuccess
    },
    {
        name: 'payment',
        path: '/payment/:order_id',
        component: Payment
    },
    {
        name: 'resetpassword',
        path: '/reset-password',
        component: ResetPassword
    },
    {
        name: 'newpassword',
        path: '/new-password/:id/:token',
        component: NewPassword
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
    'resetpassword',
    'newpassword',
    'top'
    // 'notfound',
];

const userRoutes = [
    'home',
    'items',
    'search',
    'user',
    'bookaddress',
    'request',
    'reqstatus',
    'topay',
    'toship',
    'toreceive',
    'userprofile',
    'received',
    'payment',
    'paymentsuccess',
    'cancelled'
];
const adminRoutes = [
    'admin', 
    'adminitem',
    'aprofile',
    'charges',
    'admindashboard',
    'adminuser',
    'adminclient',
    'adminorderlist',
    'adminreport',
    'adminpurpose'
    
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