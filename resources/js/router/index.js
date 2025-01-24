import { createRouter, createWebHistory } from 'vue-router';
import Card from '../components/pages/Card.vue';
import ShowCard from '../components/pages/ShowCard.vue';
import Login from '../components/auth/Login.vue';
import Home from '../components/pages/Home.vue';
import Admin from '../components/pages/admin/index.vue';
import Detail from '../components/pages/admin/Detail.vue';
import Camera from '../components/camera/Camera.vue';
import User from '../components/user/index.vue';
import Userd from '../components/NavBar_all.vue';
import UserPage from '../components/UserPage.vue';
import Dashboard from '../components/Dashboard.vue';


const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/showcard/:id', // ใช้พารามิเตอร์ id
        name: 'ShowCard',
        component: ShowCard,
        props: true // ส่ง id เป็น props ให้กับคอมโพเนนต์
    },
    {
        path: '/getCard/:id', // ใช้พารามิเตอร์ id
        name: 'Card',
        component: Card,
        props: true // ส่ง id เป็น props ให้กับคอมโพเนนต์
    },
    // {
    //     path: '/admin',
    //     name: 'admin',
    //     component: Admin,
    // },
    // {
    //     path: '/admin/detail',
    //     name: 'admin.detail',
    //     component: Detail,
    // },
    {
        path: '/camera',
        name: 'camera',
        component: Camera,
    },
    {
        path: '/user/:id&:token',
        name: 'User',
        component: User,
    },
    // {
    //     path: '/userd',
    //     name: 'Userd',
    //     component: Userd,
    // },
    {
        path: '/userPage',
        name: 'userPage',
        component: UserPage,
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
