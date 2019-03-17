<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Set Key</div>


                  <div class="card-body">
                      <form @submit.prevent="checkUserKey" @keydown="errors.clear($event.target.name)">


                          <div class="form-group row">
                              <label for="key" class="col-sm-4 col-form-label text-md-right">Key</label>

                              <div class="col-md-6">
                                  <input type="text" id="key" name="key" v-model="key" :class="{'is-invalid':errors.has('key'), 'form-control': 'true'}"  autofocus >


                                      <span class="invalid-feedback" v-if="errors.has('key')">
                                          <strong v-text="errors.get('key')"></strong>
                                      </span>


                              </div>
                          </div>





                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Save
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

 // error feedback for api key
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
      name: 'key',

      data(){
        return {
          key: localStorage.getItem('key'),
          errors: new Errors,
        }
      },

        mounted (){
          this.redirectIfGuest();
        },

          methods:{

            // first we check for validity of this api key
            // if it's valid , store it into the localStorage and database
            checkUserKey(){

              if(!this.key.trim().length){
                // don't send if empty
                this.errors.record(
                  {
                    'key':['the key field is required']
                  }
                );

                return false;
              }

              axios.post('api/check_key',{
                key: this.key,
              },
              {
                headers: {
                  'Authorization': 'Bearer '+localStorage.getItem('token'),
                }
              }).then( response => {
                // send request to save it
                this.saveUserKey(this.key);
              })
              .catch( error => {
                console.log(error.response);
                this.errors.record(error.response.data.errors);

              })
            },

            saveUserKey(key){
              axios.post('api/set_key',{
                key: key,
              },
              {
                headers: {
                  'Authorization': 'Bearer ' + localStorage.getItem('token'),
                }
              }).then( response => {
                // save it too in the localStorage
                localStorage.setItem('key', response.data.api_key);
                this.$router.push({ path: 'pairs' });
              })
              .catch( error => {
                console.log(error.response);
                // this.errors.record(error.response.data.errors);

              })
            },



          }


    }
</script>
