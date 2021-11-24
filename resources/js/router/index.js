import {createWebHistory, createRouter} from "vue-router";

import Register from '../pages/Register';
import PlaygroundSaves from '../pages/Unity/Lite/PlaygroundSaves'
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';
import SideMenu from '../layouts/side-menu/Main'
import Wizard from "../pages/Wizard";
import CategoryAdmin from "../pages/Admin/Community/CategoryAdmin"
import PostsAdmin from "../pages/Admin/Community/PostsAdmin"
import ShowroomList from "../pages/Admin/Showrooms/ShoowromsList"
import AddEditShowroom from "../pages/Admin/Showrooms/AddEditShowroom"
import AddEditSAAS from "../pages/Admin/SAAS/AddEditSAAS"
import SAASList from "../pages/Admin/SAAS/SAASList"
import AdminFreeSaves from "../pages/Admin/AdminFreeSaves";
import AddCategoryAdmin from "../pages/Admin/Community/AddCategoryAdmin";
import AddDiscussionAdmin from "../pages/Admin/Community/AddDiscussionAdmin";
import DiscussionAdmin from "../pages/Admin/Community/DiscussionAdmin";
import MainLite from "../pages/Unity/Lite/MainLite";
import Profile from "../pages/Wizard";
import PeerTest from "../pages/PeerTest";
import WizardOne from "../pages/WizardOne";
import Challenges from "../pages/Challenges/Main";
import Projects from "../pages/Projects/Main";
import ProjectCard from "../pages/Projects/Card";
import ProjectCardSecond from "../pages/Projects/ProjectStageSecond/Card";
import AddChallenge from "../pages/Challenges/New";
import Solutions from "../pages/Solutions/Main";
import AddSolution from "../pages/Solutions/New";
import Teams from "../pages/Teams/Teams";
import NotFound from "../pages/NotFound";
import Main from "../pages/Unity/Main";
import Showroom from "../pages/Unity/Showroom/Showroom";
import MainHangar from "../pages/Unity/Hangars/MainHangar";
import MainKnowledgebase from "../pages/KnowledgeBase/Main";
import AddKnowledgebase from "../pages/KnowledgeBase/Add";
import Profiles from "../pages/Profiles/Main";
import ChangePassword from "../pages/Profiles/ChangePassword";
import List from "../pages/Models/List";
import ModelAdd from "../pages/Models/ModelAdd";
import ModelEdit from "../pages/Models/ModelEdit";
import Card from "../pages/Challenges/Card";
import Communication from "../pages/Communication/Main";
import ReportReview from "../pages/Communication/ReportReview";
import TermsMain from "../pages/Terms/TermsMain";
import ForgotPassword from "../pages/ForgotPassword";
import Workshop from "../pages/Unity/Workshop/Workshop";
import NewOffer from "../pages/Offers/NewOffer";
import Offers from "../pages/Challenges/components/Offers";
import ShowroomLogin from "../pages/Showrooms/ShowroomLogin";
import Secret from '../pages/Admin/Secret';
import SolutionsArchive from "../pages/Solutions/SolutionsArchive";
import Robochallenge from "../pages/Robochallenge";
import Notifications from "../pages/Notifications";
import SAASLogin from "../pages/SAAS/SAASLogin";
import ContestsLogin from "../pages/Contests/ContestsLogin";
import AddEditContest from "../pages/Admin/Contests/AddEditContest";
import ContestsList from "../pages/Admin/Contests/ContestsList";
import ContestsMainPage from "../pages/Contests/ContestsMainPage";

export const routes = [
    {
        name: 'reset-password',
        path: '/reset-password/:token',
        component: ForgotPassword,
        props: true
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'secret',
        path: '/secret',
        component: Secret
    },
    {
        name: 'showroom-login',
        path: '/showroom/:organization/login',
        component: ShowroomLogin,
        props: true
    },
    {
        name: 'saas-login',
        path: '/saas/:organization/login',
        component: SAASLogin,
        props: true
    },
    {
        name: 'contest-login',
        path: '/contest/:organization/login',
        component: ContestsLogin,
        props: true
    },
    {
        name: 'showroom',
        path: '/showroom/play/:organization',
        component: Showroom,
        props: true
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
        name: 'challengeStudio',
        path: '/studio/:type/:id',
        component: Main,
        props: true
    },
    {
        name: 'peerTest',
        path: '/peerTest',
        component: PeerTest,
        props: true
    },
    {
        name: 'hangarStudio',
        path: '/hangar',
        component: MainHangar,
        props: true
    },
    {
        name: 'terms',
        path: "/terms/:page",
        component: TermsMain,
        props: true
    },
    {
        name: 'robochallenge',
        path: '/robochallenge',
        component: Robochallenge
    },
    {
        name: 'studio-playground',
        path: '/playground/:id',
        component: MainLite,
        props: true
    },
    {
        path: "/",
        component: SideMenu,
        children: [
            {
                name: 'admin-saas',
                path: '/admin/saas',
                component: SAASList,
                props: true
            },
            {
                name: 'admin-add-saas',
                path: '/admin/add/saas',
                component: AddEditSAAS,
                props: true
            },
            {
                name: 'admin-showroom',
                path: '/admin/showrooms',
                component: ShowroomList,
                props: true
            },
            {
                name: 'admin-add-post',
                path: '/admin/add/post',
                component: AddDiscussionAdmin,
                props: true
            },
            {
                name: 'admin-add-category',
                path: '/admin/add/category',
                component: AddCategoryAdmin,
                props: true
            },
            {
                name: 'admin-category',
                path: '/admin/categories',
                component: CategoryAdmin,
                props: true
            },
            {
                name: 'admin-discussion',
                path: '/admin/discussion',
                component: DiscussionAdmin,
                props: true
            },
            {
                name: 'admin-posts',
                path: '/admin/posts',
                component: PostsAdmin,
                props: true
            },
            {
                name: 'admin-add-edit-showroom',
                path: '/admin/showrooms/add/:showroom_id',
                component: AddEditShowroom,
                props: true
            },
            {
                name: 'admin-freesaves',
                path: '/admin/free-saves',
                component: AdminFreeSaves,
                props: true
            },
            {
                name: 'contest-admin-list',
                path: '/admin/contests/:organization/main',
                component: ContestsList,
                props: true
            },
            {
                name: 'contest-main-page',
                path: '/contests/:organization/main',
                component: ContestsMainPage,
                props: true
            },
            {
                name: 'contest-add',
                path: '/contests/add',
                component: AddEditContest,
                props: true
            },
            {
                name: 'studio-playground-saves',
                path: '/playground/saves',
                component: PlaygroundSaves,
                props: true
            },
            {
                name: 'workshop',
                path: '/workshop',
                component: Workshop,
                props: true
            },
            {
                name: 'notifications',
                path: "/notifications",
                component: Notifications,
                props: true
            },
            {
                name: 'offer-add',
                path: '/offer/add',
                component: NewOffer,
                props: true
            },
            {
                name: 'offers',
                path: '/offers',
                component: Offers,
                props: true
            },
            {
                name: 'models',
                path: '/models',
                component: List,
                props: true
            },
            {
                name: 'modelsAdd',
                path: '/models/add',
                component: ModelAdd,
                props: true
            },
            {
                name: 'modelEdit',
                path: '/models/edit/:id',
                component: ModelEdit,
                props: true
            },
            {
                name: 'reportReview',
                path: '/report/show/:id',
                component: ReportReview,
                props: true
            },
            {
                name: 'projects',
                path: '/projects',
                component: Projects
            },
            {
                name: 'projectCard',
                path: '/projects/card/:id',
                component: ProjectCard,
                props: true
            },
            {
                name: 'projectCardStageSecond',
                path: '/projects/card/second/:id',
                component: ProjectCardSecond,
                props: true
            },
            {
                name: 'addChallenge',
                path: '/challenge/add',
                component: AddChallenge,
                props: true
            },
            {
                name: 'challenges',
                path: '/challenges',
                component: Challenges,
                props: {type: 'normal'}
            },
            {
                name: 'challengesFollowed',
                path: '/challenges/followed',
                component: Challenges,
                props: {type: 'followed'}
            },
            {
                name: 'challengesArchive',
                path: '/challenges/archive',
                component: Challenges,
                props: {type: 'archive'}
            },
            {
                name: 'internalChallenegeCard',
                path: '/challenges/card/:id',
                component: Card,
                props: true,
            },
            {
                name: 'addSolution',
                path: '/solution/add',
                component: AddSolution
            },
            {
                name: 'solutions',
                path: '/solutions',
                component: Solutions
            },
            {
                name: 'solutionsAll',
                path: '/solutions/all',
                component: SolutionsArchive,
                props: {type: 'all'}
            },
            {
                name: 'solutionsArchive',
                path: '/solutions/archive',
                component: SolutionsArchive,
                props: {type: 'archive'}
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
                name: 'communication',
                path: '/communication',
                component: Communication
            },
            {
                name: 'communication',
                path: '/communication',
                component: Communication
            },
            {
                name: 'wizard',
                path: '/kreator',
                component: Wizard
            },
            {
                name: 'wizardone',
                path: '/kreator-krok-jeden',
                component: WizardOne
            },
            {
                name: 'profile',
                path: '/profile',
                component: Profile,
            },
            {
                name: 'dashboard',
                path: '/dashboard',
                component: Challenges,
                props: {type: 'normal'}
            },
            {
                name: 'profiles',
                path: '/profiles',
                component: Profiles,
                props: true
            },
            {
                name: 'change-password',
                path: '/change-password',
                component: ChangePassword
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
