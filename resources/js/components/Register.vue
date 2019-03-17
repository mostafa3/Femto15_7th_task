<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Register</div>


                  <div class="card-body">
                      <form @submit.prevent="submitted" @keydown="errors.clear($event.target.name)">


                          <div class="form-group row">
                              <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>

                              <div class="col-md-6">
                                  <input type="text" id="name" name="name" v-model="name" :class="{'is-invalid':errors.has('name'), 'form-control': 'true'}" required  autofocus >


                                      <span class="invalid-feedback" v-if="errors.has('name')">
                                          <strong v-text="errors.get('name')"></strong>
                                      </span>


                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                              <div class="col-md-6">
                                  <input type="email" id="email" name="email" v-model="email" :class="{'is-invalid':errors.has('email'), 'form-control': 'true'}" required   >


                                      <span class="invalid-feedback" v-if="errors.has('email')">
                                          <strong v-text="errors.get('email')"></strong>
                                      </span>


                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                              <div class="col-md-6">
                                  <input id="password" type="password" v-model="password" :class="{'is-invalid':errors.has('password'), 'form-control': 'true'}" name="password" required>

                                  <span class="invalid-feedback" v-if="errors.has('password')">
                                      <strong v-text="erros.get('password')"></strong>
                                  </span>
                              </div>
                          </div>



                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Register
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
      name: 'register',

      data(){
        return {
          name: '',
          email: '',
          password: '',
          errors: new Errors,
        }
      },

          mounted (){

          },
          methods:{


            submitted(){
              axios.post('api/register',{
                name: this.name,
                email: this.email,
                password: this.password
              }).then( response => {
                localStorage.setItem('token', response.data.auth.original.access_token);
                this.$router.push({ path: 'pairs' });
              })
              .catch( error => {
                console.log(error.response.data.errors);
                this.errors.record(error.response.data.errors);

              })
            },


          }


    }
</script>
