import Vue from 'vue'
import VueRouter from 'vue-router'
import Parallex from '../components/parallex'
import Login from '../components/login/Login'
import Signup from '../components/login/Signup'
import Logout from '../components/login/Logout'
import AllNotifications from '../components/notifications/notifications'
import Team from '../components/team/index'
import AllUsers from '../components/users/index'
import Project from '../components/project/index'
import ProjectSingle from '../components/project/show'
import Task from '../components/task/index'
import taskSingle from '../components/task/show'
import CreateCategory from '../components/category/index'
import TeamSingle from '../components/team/show'
import dashboard from '../components/dashboard/dashboard'
import Profile from '../components/profile'
import log from './middleware/log'
import logged from './middleware/logged'


Vue.use(VueRouter)


const routes = [
    {path: '/', component: Parallex, name: 'home'},
    {path: '/login', component: Login, name: 'login', meta: {middleware: log,}},
    {path: '/logout', component: Logout, meta: {middleware: logged}},
    {path: '/signup', component: Signup,name: 'signup', meta: {middleware: log,}},
    {path: '/users', component: AllUsers, meta: {middleware: logged}},
    {path: '/projects', component: Project, meta: {middleware: logged}},
    {path: '/project/:id', component: ProjectSingle, name: 'project-single', meta: {middleware: logged}},
    {path: '/tasks', component: Task, meta: {middleware: logged}},
    {path: '/task/:id', component: taskSingle, name: 'task-single', meta: {middleware: logged}},
    {path: '/category', component: CreateCategory, meta: {middleware: logged}},
    {path: '/teams', component: Team, meta: {middleware: logged}},
    {path: '/team/:id', component: TeamSingle, name: 'team-single', meta: {middleware: logged}},
    {path: '/dashboard', component: dashboard, meta: {middleware: logged}},
    {path: '/notifications', component: AllNotifications, meta: {middleware: logged}},
    {path: '/profile', component: Profile, name: 'profile', meta: {middleware: logged}},


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
