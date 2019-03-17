<template>




    <div class="container">


      <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <router-link to="login" class="nav-link" >Login</router-link>
            </li>
            <li class="nav-item active">
              <router-link to="register" class="nav-link" >Register</router-link>
            </li>
            <li class="nav-item active">
              <router-link to="key" class="nav-link" >Set Key </router-link>
            </li>
            <li class="nav-item active">
              <router-link to="pairs" class="nav-link" >Pairs</router-link>
            </li>

          </ul>

            <a class="nav-link" href="#">Logout</a>

        </div>
      </nav>


        <div>
          <router-view></router-view>
        </div>

    </div>

</template>

<script>

import router from '../routes';

import login from './Login'
import register from './Register'
import key from './Key'


    export default {

      components: {
        login,
        register,
        key,

      },
     router: router,

}

</script>
