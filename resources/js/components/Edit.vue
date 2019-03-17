<template>
  <div class="container">


    <div>
      <h1>Edit</h1>
    </div>

    <form @submit.prevent="submitted">


    <!-- Source -->
      <div class="form-group row">
            <div class="col-sm-2">
                <select :class="{'custom-select':'true', 'is-invalid': errors.has('source_currency')}" name="source_currency" id="source_currency" v-model="source_currency" required>

                    <option v-for="currency in currencies.source_currencies" v-text="currency.name" :value="currency.id" :selected="currency.id == source_currency"></option>

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

                    <option v-for="currency in currencies.to_currencies" v-text="currency.name"  :value="currency.id"  :selected="currency.id == to_currency"></option>

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
      name: 'edit',
      props: ['source'],

      data(){
        return {

          currencies: [],
          source_currency: this.$route.query.source,
          to_currency: this.$route.query.to,
          errors: new Errors,
        }
      },

          mounted (){
            this.getCurrencies();
          },
          methods:{

            getCurrencies(){
              axios.get('api/get_currencies',
              {
                  headers: {
                    'Authorization': 'Bearer '+localStorage.getItem('token'),
                  }
              }).then( response => {
                this.currencies = response.data;

              })
              .catch( error => {
                console.log(error.response);
                // this.errors.record(error.response.data.errors);

              })
            },

            submitted(){
              axios.post('api/update_currency',{

                source: this.source_currency,
                to: this.to_currency,
                old_source: this.$route.query.source,
                old_to: this.$route.query.to,
              },{
                headers: {
                  'Authorization': 'Bearer '+localStorage.getItem('token'),
                }
              }).then( response => {})
              .catch( error => {
                console.log(error.response.data.errors);
                this.errors.record(error.response.data.errors);

              })
            },


          }


    }
</script>
