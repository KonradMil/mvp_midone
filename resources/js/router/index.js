import {createWebHistory, createRouter} from "vue-router";

import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import SideMenu from '../layouts/side-menu/Main'
import Wizard from "../pages/Wizard";
import Profile from "../pages/Wizard";
import WizardOne from "../pages/WizardOne";
import WizardTwo from "../pages/WizardTwo";
import Challenges from "../pages/Challenges/Main";
import AddChallenge from "../pages/Challenges/New";
import Teams from "../pages/Teams/Teams";
import NotFound from "../pages/NotFound";
import Main from "../pages/Unity/Main";
import MainKnowledgebase  from "../pages/KnowledgeBase/Main";
import AddKnowledgebase  from "../pages/KnowledgeBase/Add";

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
        name: 'acceptInvite',
        path: '/teams/user/accept_invite/:token',
        component: Register,
        props: true
    },
    {
        name: 'studio',
        path: '/studio',
        component: Main,
        props: true
    },
    {
        path: "/",
        component: SideMenu,
        children: [
            {
                name: 'addChallenge',
                path: '/challenge/add',
                component: AddChallenge
            },
            {
                name: 'challenges',
                path: '/challenges',
                component: Challenges
            },
            {
                name: 'knowledgebase',
                path: '/knowledgebase',
                component: MainKnowledgebase
            },
            {
                name: 'addKnowledgebasePost',
                path: '/knowledgebase/post/add',
                component: AddKnowledgebase
            },
            {
                name: 'teams',
                path: '/teams',
                component: Teams
            },
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
    },
    {
        path: "/:catchAll(.*)",
        component: NotFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
