import Vue from 'vue'
import VueRouter from 'vue-router'
import Parallex from '../components/parallex'
import Login from '../components/login/Login'
import Signup from '../components/login/Signup'
import Logout from '../components/login/Logout'

import Read from '../components/forum/Read'
import Create from '../components/forum/create'
import Admin from '../components/users/Admin'
import Coordinator from '../components/users/Coordinator'

import Team from '../components/users/Team'
import AddUsers from '../components/users/AddUsers'
import AllUsers from '../components/users/AllUsers'
import CreateUser from '../components/users/CreateUser'

import Project from '../components/project/Project'
import ProjectSingle from '../components/project/ProjectSingle'
import Task from '../components/task/Task'
import taskSingle from '../components/task/show'
import CreateCategory from '../components/category/CreateCategory'
import TeamSingle from '../components/team/TeamSingle'
import dashboard from '../components/dashboard/dashboard'
import Profile from '../components/profile'
import log from './middleware/log'
import logged from './middleware/logged'
import adminMiddleware from './middleware/AdminMiddleware'


Vue.use(VueRouter)


const routes = [
    {path: '/', component: Parallex, name: 'home'},
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            middleware: log,
        }
    },
    {path: '/logout', component: Logout},
    {
        path: '/signup', component: Signup,
        name: 'signup',

        meta: {
            middleware: log,
        }
    },
    {path: '/addusers', component: AddUsers},
    {path: '/allusers', component: AllUsers},
    {path: '/createuser', component: CreateUser},

    //{ path: '/createproject', component: CreateProject },
    {path: '/project', component: Project},
    {path: '/project/:id', component: ProjectSingle, name: 'project-single'},

    //{ path: '/createtask', component: CreateTask },
    {path: '/task', component: Task},
    {path: '/task/:id', component: taskSingle, name: 'task-single'},

    {path: '/category', component: CreateCategory},


    //{ path: '/create_team', component:CreateTeam   },
    //{ path: '/liste_team', component:ListeTeam   },
    {path: '/team', component: Team},
    {path: '/team/:id', component: TeamSingle, name: 'team-single'},

    {path: '/dashboard', component: dashboard},

    {path: '/ask', component: Create},
    {
        path: '/admin', component: Admin, name: 'admin',
        meta: {
            middleware: adminMiddleware,
        }
    },

    {
        path: '/coordinator', component: Coordinator, name: 'coordinator',
        meta: {
            middleware: logged,
        }
    },



    {
        path: '/profile', component: Profile, name: 'profile',
        meta: {
            middleware: logged,
        }

    },
    // { path: '/forum', component: Forum ,name:'forum'},
    {path: '/question/:slug', component: Read, name: 'read'},


]


const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang: false,
    mode: 'history',

})


function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    // If no subsequent Middleware exists,
    // the default `next()` callback is returned.
    if (!subsequentMiddleware) return context.next;

    return (...parameters) => {
        // Run the default Vue Router `next()` callback first.
        context.next(...parameters);
        // Than run the subsequent Middleware with a new
        // `nextMiddleware()` callback.
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({...context, next: nextMiddleware});
    };
}

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware)
            ? to.meta.middleware
            : [to.meta.middleware];

        const context = {
            from,
            next,
            router,
            to,
        };
        const nextMiddleware = nextFactory(context, middleware, 1);

        return middleware[0]({...context, next: nextMiddleware});
    }

    return next();
});


export default router
