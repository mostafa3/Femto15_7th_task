<template>
  <div class="container">


    <div>
      <h1>Add</h1>
    </div>


    <form @submit.prevent="submitted">


    <!-- Source -->
      <div class="form-group row">
            <div class="col-sm-2">
                <select :class="{'custom-select':'true', 'is-invalid': errors.has('source_currency')}" name="source_currency" id="source_currency" v-model="source_currency" required>

                    <option v-for="currency in currencies.source_currencies" v-text="currency.name" :value="currency.id"></option>

                </select>

                    <span class="invalid-feedback" role="alert" v-if="errors.has('source_currency')">
                        <strong>{{ errors.get('source_currency') }}</strong>
                    </span>

            </div>
      </div>

      <!-- To -->
      <div class="form-group row">
            <div class="col-sm-2">
                <select :class="{'custom-select':'true', 'is-invalid': errors.has('to_currency')}" name="to_currency" id="to_currency" v-model="to_currency" required>

                    <option v-for="currency in currencies.to_currencies" v-text="currency.name"  :value="currency.id"></option>

                </select>

                    <span class="invalid-feedback" role="alert"  v-if="errors.has('to_currency')">
                        <strong>{{ errors.get('to_currency') }}</strong>
                    </span>

            </div>
      </div>

      <!-- Save -->
      <div class="form-group row">
            <div class="col-sm-2">
              <button class="btn btn-primary">Save</button>

            </div>
      </div>



    </form>


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
      name: 'add',


      data(){
        return {

          currencies: [],
          source_currency: 0,
          to_currency: 0,
          errors: new Errors,
        }
      },

          mounted (){
            this.redirectIfGuest();
            this.redirectToSetKey();
            this.getCurrencies();
          },
          methods:{

            getCurrencies(){
              axios.get('api/get_currencies',{
                headers: {
                  'Authorization': 'Bearer '+localStorage.getItem('token'),
                }
              }).then( response => {
                // cach the response data into variables
                this.currencies = response.data;

                // put the first items into the beginning of the dropdown lists
                this.source_currency = this.currencies.source_currencies[0].id;
                this.to_currency = this.currencies.to_currencies[0].id;
              })
              .catch( error => {
                console.log(error.response);
              })
            },

            submitted(){
              axios.post('api/add_pair',{
                source: this.source_currency,
                to: this.to_currency,
              },{
                headers: {
                  'Authorization': 'Bearer '+localStorage.getItem('token'),
                }
              }).then( response => {
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
