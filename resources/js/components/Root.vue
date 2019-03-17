<template>




    <div class="container">


      <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <router-link to="login" v-show="!isLoggedIn"  class="nav-link" >Login</router-link>
            </li>
            <li class="nav-item active">
              <router-link to="register" v-show="!isLoggedIn"  class="nav-link" >Register</router-link>
            </li>
            <li class="nav-item active">
              <router-link to="key" v-show="isLoggedIn"  class="nav-link" >Set Key </router-link>
            </li>
            <li class="nav-item active">
              <router-link to="pairs" v-show="isLoggedIn"  class="nav-link" >Pairs</router-link>
            </li>

          </ul>

            <a class="nav-link" href="#" v-show="isLoggedIn"  @click.prevent="logout" >Logout</a>

        </div>
      </nav>


        <div>
          <router-view></router-view>
        </div>

    </div>

</template>

<script>

import router from '../routes';

import {store} from '../store';

    export default {


     router :router,
     store,

     mounted(){
       // kick the user to pairs page
       // if he's authenticated the pair page will kicks him to login
       // if he authenticated but no api_key will be kicked to key page
       // or he can continue in pairs page
       this.$router.push({ path: 'pairs' });
     },

     methods:{


       logout(){
         // just remove the token from client side but it remains in the server
         localStorage.removeItem('token');
         localStorage.removeItem('key');
         // noway for changing the nav links
         location.reload();
         this.$router.push({ path: 'login' });
         // axios.post('api/logout',{
         //     headers: {
         //       'Authorization': 'Bearer '+localStorage.getItem('token'),
         //     }
         //   }).then( response => {
         // })
         // .catch( error => {
         //   console.log(error.response);
         //   // this.errors.record(error.response.data.errors);
         //
         // });

       }
     },

}

// share globally
Vue.mixin({
  computed:{

    // i'm trying here to make computed on the token states in localStorage
    // so application can react with users and change nav links
    // according for there status but it doesn't work , the browser must be refreshed
    isLoggedIn(){

      return localStorage.getItem('token') != null;
      // return this.$store.getters.loggedIn;
    },

  },
  methods: {


    redirectIfGuest(status){
      if(!this.isLoggedIn)
      this.$router.push({ path: 'login' });
    },

    // if key is not provided
    redirectToSetKey(){
      var key = localStorage.getItem('key');
      if(!key)
        this.$router.push({ path: 'key' });
    },


  }
})


</script>
