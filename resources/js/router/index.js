import {createWebHistory, createRouter} from "vue-router";

import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import SideMenu from '../layouts/side-menu/Main'
import Wizard from "../pages/Wizard";
import Profile from "../pages/Wizard";
import WizardOne from "../pages/WizardOne";
import WizardTwo from "../pages/WizardTwo";


export const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        path: "/",
        component: SideMenu,
        children: [
            {
                name: 'wizard',
                path: '/kreator',
                component: Wizard
            },{
                name: 'wizardone',
                path: '/kreator-krok-jeden',
                component: WizardOne
            },
            {
                name: 'wizardtwo',
                path: '/kreator-krok-dwa',
                component: WizardTwo
            },
            {
                name: 'profile',
                path: '/profile',
                component: Profile,
            },
            {
                name: 'dashboard',
                path: '/dashboard',
                component: Dashboard
            },

        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
