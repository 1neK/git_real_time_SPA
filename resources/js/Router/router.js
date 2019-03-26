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
import CreateCategory from '../components/category/CreateCategory'
import log from './middleware/log'
import logged from './middleware/logged'


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
     { path: '/category', component: CreateCategory },
     { path: '/ask', component: Create },
     { path: '/admin', component: Admin ,name:'admin'
     ,
     meta: {
        middleware: logged,
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
    mode : 'history'
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
