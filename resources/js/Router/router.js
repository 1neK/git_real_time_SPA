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

const routes = [
    { path: '/', component: Parallex },
     { path: '/login', component: Login },
     { path: '/logout', component: Logout },
     { path: '/signup', component: Signup },
     { path: '/category', component: CreateCategory },
     { path: '/ask', component: Create },
     { path: '/admin', component: Admin ,name:'admin' },
     { path: '/coordinator', component: Coordinator },
     { path: '/designer', component: Designer },
     { path: '/forum', component: Forum ,name:'forum'},
     { path: '/question/:slug', component: Read ,name:'read'},



  ]

  const router = new VueRouter({
    routes, // short for `routes: routes`
    hashbang : false,
    mode : 'history'
  })


  export default router
