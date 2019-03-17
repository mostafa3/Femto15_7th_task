



import VueRouter from 'vue-router';



let routes =[
  {
    path: '/login',
    component: require('./components/Login').default
  },
  {
    path: '/register',
    component: require('./components/Register').default
  },
  {
    path: '/key',
    component: require('./components/Key').default
  },
  {
    path: '/pairs',
    component: require('./components/Pairs').default
  },
  {
    path: '/add',
    component: require('./components/Add').default
  },
  

]


export default new VueRouter ({

  routes

})
