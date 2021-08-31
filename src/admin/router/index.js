import Vue from 'vue'
import Router from 'vue-router'
import Home from 'admin/pages/Home.vue'
import UserSingle from 'admin/pages/UserSingle.vue'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/user-single/:id',
      name: 'user-single',
      component: UserSingle
    },
  ]
})
