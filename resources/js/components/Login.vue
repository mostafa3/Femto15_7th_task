<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>


                  <div class="card-body">
                      <form @submit.prevent="submitted" @keydown="errors.clear($event.target.name)">


                          <div class="form-group row">
                              <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                              <div class="col-md-6">
                                  <input type="email" id="email" name="email" v-model="email" :class="{'is-invalid':errors.has('email'), 'form-control': 'true'}"  required autofocus >


                                      <span class="invalid-feedback" v-if="errors.has('email')">
                                          <strong v-text="errors.get('email')"></strong>
                                      </span>


                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                              <div class="col-md-6">
                                  <input id="password" type="password" v-model="password" :class="{'is-invalid':errors.has('password'), 'form-control': 'true'}" required name="password" >

                                  <span class="invalid-feedback" v-if="errors.has('password')">
                                      <strong v-text="errors.get('password')"></strong>
                                  </span>
                              </div>
                          </div>



                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Login
                                  </button>


                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>

// import router from '../routes';

const axios = require('axios');


 class Errors  {
   constructor(){
     this.errors = {}
   }

   get(field) {
     if (this.errors[field])
      return this.errors[field][0]
   }

   record(errors) {
      this.errors = errors
    }

    has(field){
        return this.errors.hasOwnProperty(field) ;
    }

    clear(field) {
      // console.log(field);

        delete this.errors[field];
    }
 }

    export default {
      name: 'login',

      data(){
        return {
          email: '',
          password: '',
          errors: new Errors,
        }
      },

          mounted (){

          },
          methods:{


            submitted(){
              // this.$store.dispatch('login',{
              //   email: this.email,
              //   password: this.password
              // }).then( response => {
              //   this.$router.push({ path: 'pairs' });
              // });

              axios.post('api/login',{
                email: this.email,
                password: this.password
              }).then( response => {
                console.log(response.data);
                // save the token in the localStorage
                localStorage.setItem('token', response.data.auth.original.access_token);
                this.$router.push({ path: 'pairs' });
              })
              .catch( error => {
                this.errors.record(error.response.data.errors)
              })
            },


          }


    }
</script>
<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>


                  <div class="card-body">
                      <form @submit.prevent="submitted" @keydown="errors.clear($event.target.name)">


                          <div class="form-group row">
                              <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                              <div class="col-md-6">
                                  <input type="email" id="email" name="email" v-model="email" :class="{'is-invalid':errors.has('email'), 'form-control': 'true'}"  required autofocus >


                                      <span class="invalid-feedback" v-if="errors.has('email')">
                                          <strong v-text="errors.get('email')"></strong>
                                      </span>


                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                              <div class="col-md-6">
                                  <input id="password" type="password" v-model="password" :class="{'is-invalid':errors.has('password'), 'form-control': 'true'}" required name="password" >

                                  <span class="invalid-feedback" v-if="errors.has('password')">
                                      <strong v-text="errors.get('password')"></strong>
                                  </span>
                              </div>
                          </div>



                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Login
                                  </button>


                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>

// import router from '../routes';

const axios = require('axios');


 class Errors  {
   constructor(){
     this.errors = {}
   }

   get(field) {
     if (this.errors[field])
      return this.errors[field][0]
   }

   record(errors) {
      this.errors = errors
    }

    has(field){
        return this.errors.hasOwnProperty(field) ;
    }

    clear(field) {
      // console.log(field);

        delete this.errors[field];
    }
 }

    export default {
      name: 'login',

      data(){
        return {
          email: '',
          password: '',
          errors: new Errors,
        }
      },

          mounted (){

          },
          methods:{


            submitted(){
              axios.post('api/login',{
                email: this.email,
                password: this.password
              }).then( response => {
                // save the token and the api_key in the localStorage

                localStorage.setItem('token', response.data.auth.original.access_token);
                localStorage.setItem('key', response.data.api_key);
                // noway for changing the nav links
                location.reload();
                // redirect to index
                this.$router.push({ path: 'pairs' });
              })
              .catch( error => {
                this.errors.record(error.response.data.errors)
              })
            },



          }


    }


</script>
