



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
  
]


export default new VueRouter ({

  routes

})
