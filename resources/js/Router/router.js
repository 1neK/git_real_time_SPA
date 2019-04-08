import Vue from 'vue'
import VueRouter from 'vue-router'



Vue.use(VueRouter)
import Parallex from '../components/parallex'
import Login from '../components/login/Login'
import Signup from '../components/login/Signup'
import Logout from '../components/login/Logout'
import Forum from '../components/forum/Forum'
import Read from '../components/forum/Read'
import Create from '../components/forum/create'
import Admin from '../components/users/Admin'
import Coordinator from '../components/users/Coordinator'
import Designer from '../components/users/Designer'
import Team from '../components/users/Team'
import AddUsers from '../components/users/AddUsers'
import AllUsers from '../components/users/AllUsers'
import CreateUser from '../components/users/CreateUser'
import CreateProject from '../components/project/CreateProject'
import Project from '../components/project/Project'
import  ProjectSingle from  '../components/project/ProjectSingle'
import CreateTask from '../components/task/CreateTask'
import Task from '../components/task/Task'
import CreateCategory from '../components/category/CreateCategory'
//import CreateTeam from '../components/team/CreateTeam'
//import ListeTeam from '../components/team/ListeTeam'
import TeamSingle from '../components/team/TeamSingle'
import dashboard from '../components/dashboard/dashboard'
import log from './middleware/log'
import logged from './middleware/logged'
import adminMiddleware from './middleware/AdminMiddleware'


const routes = [
    { path: '/', component: Parallex },
     {  path: '/login',
        component: Login,
        name :'login',
        meta: {
               middleware: log,
              }
     },
     { path: '/logout', component: Logout },
     { path: '/signup', component: Signup ,
     name :'signup',

     meta: {
        middleware: log,
       }
    },
    { path: '/addusers', component: AddUsers },
    { path: '/allusers', component: AllUsers },
    { path: '/createuser', component: CreateUser },

    { path: '/createproject', component: CreateProject },
    { path: '/project', component: Project },
    { path: '/project/:id', component: ProjectSingle ,name:'project-single' },

    { path: '/createtask', component: CreateTask },
    { path: '/task', component: Task },

     { path: '/category', component: CreateCategory },



     //{ path: '/create_team', component:CreateTeam   },
     //{ path: '/liste_team', component:ListeTeam   },
     { path: '/team', component: Team },
     { path: '/team/:id', component: TeamSingle ,name:'team-single'},

     { path: '/dashboard', component: dashboard },

     { path: '/ask', component: Create },
     { path: '/admin', component: Admin ,name:'admin'
     ,

     meta: {
        middleware: adminMiddleware,
       }
    },
     { path: '/coordinator', component: Coordinator,name:'coordinator',

     meta: {
        middleware: logged,
       }
    },
     { path: '/designer', component: Designer ,name :'designer',
     meta: {
        middleware: logged,
       }

    },
     { path: '/forum', component: Forum ,name:'forum'

    },
     { path: '/question/:slug', component: Read ,name:'read'},



  ]


  const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang : false,
    mode : 'history',

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
      subsequentMiddleware({ ...context, next: nextMiddleware });
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

      return middleware[0]({ ...context, next: nextMiddleware });
    }

    return next();
  });



  export default router
