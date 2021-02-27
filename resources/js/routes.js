import Vue from 'vue';
import VueRouter from 'vue-router';

// Component Routers
Vue.use(VueRouter)
let routes = [
    { path: '/', component: require('./components/Index.vue').default},
    { path: '/home', component: require('./components/Welcome.vue').default,
        children: [
            { path: '/home', component: require('./components/Home.vue').default },
            { path: '/logs', component: require('./components/Logs.vue').default },
            { path: '/management', component: require('./components/Management.vue').default },
            { path: '/instructor', component: require('./components/Instructor.vue').default },
            { path: '/job_orders', component: require('./components/JobOrders.vue').default },
            { path: '/class', component: require('./components/Class.vue').default }
        ]
    },
]
const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push (location, onResolve, onReject) {
  if (onResolve || onReject) return originalPush.call(this, location, onResolve, onReject)
  try {
    return originalPush.call(this, location).catch(err => err)
  } catch (error) {
    console.log(error)
  }
}

export default router;
